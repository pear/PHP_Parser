<?php
/**
 * @package PHP_Parser
 */
class PHP_Parser_DocBlock_DefaultInlineTagParser {
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
    
    function PHP_Parser_DocBlock_DefaultInlineTagParser($options = array())
    {
        $this->_options['taglocation'] = 'PHP/Parser/DocBlock/InlineTags/';
        $this->_options['tagprefix'] = 'PHP_Parser_DocBlock_InlineTags_';
        $this->_options['taglexer'] = 'PHP_Parser_DocBlock_DefaultInlineTagLexer';
        $this->_options = array_merge($this->_options, $options);
        if (is_object($this->_options['taglexer']) ||
            (is_string($this->_options['taglexer']) && !class_exists($this->_options['taglexer']))) {
            $this->_options['taglexer'] = false;
        }
    }
    
    /**
     * @param string inline tag name
     * @param string inline tag contents
     * @return object|array returns either a user-specified tag class, or an unparsed array
     */
    function parseInlineTag($name, $contents)
    {
        if (!($lexer = $this->_options['taglexer'])) {
            return false;
        } elseif (is_string($lexer)) {
            $lexer = new $lexer($contents);
            if (!is_a($lexer, 'PHP_Parser_DocBlock_DefaultInlineTagLexer')) {
                return false;
            }
        }
        $name = strtolower($name);
        $a = $this->_getLoadedTag($name);
        if (is_array($a) && !count($a)) {
            $return = $this->_loadInlineTag($name);
            if ($return) {
                return $return;
            }
        }
        
        $a = $this->_getLoadedTag($name);
        if (!$a) {
            return array('tag' => $name, 'contents' => $contents);
        }
        $structure = $a['structure'];
        $tagname = $a['class'];
        $inlinetag = new $tagname;
        if (!is_a($inlinetag, 'PHP_Parser_DocBlock_InlineTags_Base')) {
            return false;
        }
        if (!count($structure['params'])) {
            // tags like {@inheritdoc} have no params
            return $inlinetag;
        }
        $lexer->setOptions($lexoptions = $inlinetag->getLexerOptions());
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
            $e = $inlinetag->$setparam($val);
            if (PEAR::isError($e)) {
                return $e;
            }
        }
        return $inlinetag;
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
     * Load the file containing an inline tag class.
     *
     * In phpDocumentor version 2.x, inline tags can be located in one of
     * two locations, which are specified in the options passed to
     * the constructor.  The first location is a user-specified location
     * which is designed to allow multi-user installations with a central
     * phpDocumentor install to specify a local location for inline tag files.
     *
     * User A, for example, may have a specialized inline tag {@homepage} that
     * spits out a project homepage.  This tag is located in ~A/itags/homepage.php.
     * The user will pass this location on the command-line as the location to
     * search for user-defined tags.  By default, phpDocumentor will look for a
     * PhpDocumentor_Structures_DocBlock_InlineTags_Homepage class.  This can
     * also be changed so that a shorter classname may be used.
     *
     * This flexibility allows users to extend phpDocumentor in ways we haven't
     * imagined without breaking forward compatibility to future phpDocumentor
     * versions.
     *
     * Every inline tag class must specify the tag structure in an array
     * returned by function getTagStructure().
     * @param string
     * @return null|array null on successful tag load, an array with failed parse
     *                    if the tag is not loaded successfully
     */
    function _loadInlineTag($name)
    {
        if (!class_exists($this->_options['tagprefix'] . ucfirst($name)) &&
                !class_exists('PHP_Parser_DocBlock_InlineTags_' . ucfirst($name))) {
            // try to include it
            $filename = $this->_options['taglocation'] . ucfirst($name) . '.php';
            if (PhpDocumentor::isIncludeable($filename)) {
                include_once($filename);
            }
            if (!class_exists($this->_options['tagprefix'] . ucfirst($name)) &&
                    !class_exists('PHP_Parser_DocBlock_InlineTags_' . ucfirst($name))) {
                $filename = 'PHP_Parser_DocBlock_InlineTags_' . ucfirst($name) . '.php';
                if (PhpDocumentor::isIncludeable($filename)) {
                    include_once($filename);
                }
            }
        }
        // try the user tagname first
        if (class_exists($this->_options['tagprefix'] . ucfirst($name))) {
            $this->_setLoadedTag($name, 
                array('class' => $this->_options['tagprefix'] . ucfirst($name)));
            if (!in_array('gettagstructure', get_class_methods($this->_options['tagprefix'] . ucfirst($name)))) {
                $this->_setLoadedTag($name, false);
                return false;
            } else {
                $a = $this->_getLoadedTag($name);
                $a['structure'] = call_user_func(array($a['class'], 'structure'));
                $this->_setLoadedTag($name, $a);
            }
        } elseif (class_exists('PHP_Parser_DocBlock_InlineTags_' . ucfirst($name))) {
            $this->_setLoadedTag($name, 
                array('class' => 'PHP_Parser_DocBlock_InlineTags_' . ucfirst($name)));
            if (!in_array('gettagstructure', get_class_methods('PHP_Parser_DocBlock_InlineTags_' . ucfirst($name)))) {
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