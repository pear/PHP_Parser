<?php
/**
 * @package PHP_Parser
 */
class PHP_Parser_DocBlock_DefaultTagParser {
    /**
     * Run-time options
     * @access protected
     * @var array
     */
    var $_options = array();

    /**
     * @var array
     * @access protected
     */
    var $_loadedTags = array();
    
    function PHP_Parser_DocBlock_DefaultTagParser($options = array())
    {
        $this->_options['taglocation'] = 'PHP/Parser/DocBlock/Tags/';
        $this->_options['tagprefix'] = 'PHP_Parser_DocBlock_Tags_';
        $this->_options['lexeroptions'] = array();
        $this->_options['taglexer'] = 'PHP_Parser_DocBlock_DefaultTagLexer';
        $this->_options = array_merge($this->_options, $options);
        if (is_object($this->_options['taglexer']) ||
              (is_string($this->_options['taglexer']) && !class_exists($this->_options['TagLexer']))) {
            $this->_options['taglexer'] = 'PHP_Parser_DocBlock_DefaultTagLexer';
        }
    }
    
    /**
     * @param string inline tag name
     * @param string inline tag contents
     * @return object|array returns either a user-specified tag class, or an unparsed array
     */
    function parseTag($name, $contents)
    {
        $lexer = $this->_options['taglexer'];
        if (is_string($lexer)) {
            $lexer = new $lexer;
        }
        $lexer->setOptions($this->_options['lexeroptions']);
        $name = strtolower($name);
        // attempt to load the tag parser class for this tag
        $a = $this->_getLoadedTag($name);
        if ($a === false) {
            return array('tag' => $name, 'contents' => $contents);
        }
        if (is_array($a) && !count($a)) {
            $return = $this->_loadTag($name);
            if ($return) {
                return $return;
            }
        }
        
        $a = $this->_getLoadedTag($name);
        if (is_array($a) && !count($a)) {
            return array('tag' => $name, 'contents' => $contents);
        }
        $structure = $a['structure'];
        $tagname = $a['class'];
        $tag = new $tagname;
        if (!is_a($tag, 'PHP_Parser_DocBlock_Tags_Base')) {
            return false;
        }
        if (!count($structure['params'])) {
            // tags like @abstract have no params
            return $tag;
        }
        $this->_options['lexeroptions']['separator'] = false;
        $lexer->setOptions(array_merge($this->_options['lexerOptions'], $lexoptions = $tag->getLexerOptions()));
        $lexer->newTag($contents);
        foreach($structure['params'] as $param) {
            $setparam = 'set' . $param['name'];
            if (!isset($lexer->_typeMap[$param['type']])) {
                // throw exception
            }
            $handler = $lexer->_typeMap[$param['type']];
            if (!method_exists($lexer, $handler)) {
                // throw exception
            }
            if (isset($lexoptions['separator'])) {
                $val = $this->_getMultiOptions($lexer, $handler, $param);
            } else {
                $val = $lexer->$handler($param);
            }
            if ($param['required'] && !$val) {
                return false;
            }
            $e = $tag->$setparam($val);
            if (PEAR::isError($e)) {
                return $e;
            }
        }
        return $tag;
    }
    
    function _getMultiOptions(&$lexer, $handler, $param)
    {
        $val = array();
        while ($lexer->hasNextBuf()) {
            $val[] = $lexer->$handler($param);
            if (!$lexer->moveNextBuf()) {
                break;
            }
        }
        return $val;
    }
    
    /**
     * Load the file containing a tag class.
     *
     * Tags can be located in one of two locations,
     * PHP/Parser/DocBlock/Tags/ or a user-specified location
     * which is designed to allow multi-user installations with a central
     * PHP_Parser install to specify a local location for tag files.
     *
     * User A, for example, may have a specialized tag @homepage that
     * spits out a project homepage.  This tag is located in ~A/tags/homepage.php.
     * The user will pass this location on the command-line as the location to
     * search for user-defined tags.  By default, PHP_Parser will look for a
     * PHP_Parser_DocBlock_Tags_Homepage class.  This can
     * also be changed so that a shorter classname may be used.
     *
     * This flexibility allows users to extend PHP_Parser in ways we haven't
     * imagined without breaking forward compatibility to future PHP_Parser
     * versions.
     *
     * Every tag class must specify the tag structure in an array
     * returned by function structure()
     * @param string
     * @return null|array null on successful tag load, an array with failed parse
     *                    if the tag is not loaded successfully
     */
    function _loadTag($name)
    {
        if (!class_exists($this->_options['tagprefix'] . ucfirst($name)) &&
                !class_exists($this->_options['tagprefix'] . ucfirst($name))) {
            // try to include it
            $filename = $this->_options['defaultTagLocation'] . ucfirst($name) . '.php';
            if (PhpDocumentor::isIncludeable($filename)) {
                include_once($filename);
            }
        if (!class_exists('PHP_Parser_DocBlock_Tags_' . ucfirst($name)) &&
                !class_exists('PHP_Parser_DocBlock_Tags_' . ucfirst($name))) {
                $filename = 'PHP/Parser/DocBlock/Tags/' . ucfirst($name) . '.php';
                if (PhpDocumentor::isIncludeable($filename)) {
                    include_once($filename);
                }
            }
        }
        // try the user tagname first
        if (class_exists($this->_options['tagprefix'] . ucfirst($name))) {
            $this->_setLoadedTag($name, 
                array('class' => $this->_options['tagprefix'] . ucfirst($name)));
            if (!in_array('structure', get_class_methods($this->_options['tagprefix'] . ucfirst($name)))) {
                // failure - doesn't have the structure() static method
                $this->_setLoadedTag($name, false);
                return false;
            } else {
                $a = $this->_getLoadedTag($name);
                $a['structure'] = call_user_func(array($a['class'], 'structure'));
                $this->_setLoadedTag($name, $a);
            }
        } elseif (class_exists($this->_options['tagprefix'] . ucfirst($name))) {
            $this->_setLoadedTag($name, 
                array('class' => $this->_options['tagprefix'] . ucfirst($name)));
            if (!in_array('gettagstructure', get_class_methods($this->_options['tagprefix'] . ucfirst($name)))) {
                // failure - doesn't have the structure() static method
                $this->_setLoadedTag($name, false);
                return false;
            } else {
                $a = $this->_getLoadedTag($name);
                $a['structure'] = call_user_func(array($a['class'], 'structure'));
                $this->_setLoadedTag($name, $a);
            }
        }
        return false;
    }
    
    function _getLoadedTag($tagname)
    {
        if (!isset($this->_loadedTags[$tagname])) {
            return array();
        }
        return $this->_loadedTags[$tagname];
    }
    
    function _setLoadedTag($tagname, $value)
    {
        $this->_loadedTags[$tagname] = $value;
    }
}
?>