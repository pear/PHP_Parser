<?php
require_once 'PHP/Parser/DocBlock/CommonLexer.php';
/**
 * @package PHP_Parser
 */
class PHP_Parser_DocBlock_DefaultTagLexer extends PHP_Parser_DocBlock_CommonLexer
{
    /**
     * Mapping of tag field types to lexer function name
     *
     * Use this array to extend the tag parser, simply add a mapping of
     * typename => lexer function name.  The function name must exist or
     * an exception will be thrown
     * @access protected
     */
    var $_typeMap =
        array(
              'desc' => 'getDesc',
              'type' => 'getType',
              'var' => 'getVar',
              'typewithvar' => 'getTypeWithVar',
              'word' => 'getWord',
              'link' => 'getLink',
              'multi-word' => 'getWords',
              'allwords' => 'getAllWords',
              'authoremails' => 'getAuthorEmails',
            );

    /**
     * Set Lexer options
     *
     * Valid options are
     * - separator: this is a string or false.  If it is
     *              a string, then the lexer will assume
     *              the inline tag can have multiple
     *              values, and will split the contents
     *              on the separator, and loop over each
     *              segment as if it were a separate tag
     * - descparser: The DocBlock parser that can be used to parse
     *               a general tag description
     * - desclexer: The DocBlock lexer that can be used to parse
     *              a general tag description
     * @param array
     */
    function setOptions($options = array())
    {
        $this->_options['separator'] =
        $this->_options['descparser'] = 
        $this->_options['desclexer'] = 
        false;
        $this->_options['linenumber'] = 1;
        $this->_options = array_merge($this->_options, $options);
        if (!is_object($this->_options['descparser']) ||
                !is_object($this->_options['desclexer'])) {
            $this->_options['descparser'] = 
            $this->_options['desclexer'] = 
            false;
            return false;
        }
    }
    
    /**
     * Return a long description
     *
     * This returns the results of parsing
     * @return false|object|array
     */
    function getDesc()
    {
        $desc = $this->getAllWords();
        return $this->_parseDesc($desc);
    }
    
    /**
     * Return the description section from an @author tag
     *
     * Handles emails like <cellog@users.sourceforge.net>, converting them into
     * inline links
     */
    function getAuthorEmails()
    {
        $desc = $this->getAllWords();
        // replace emails with an inline link before processing
        $desc = preg_replace('/<([a-zA-Z0-9\._-]+\@[a-zA-Z0-9\-\.]+\.' .
            '(?:[a-zA-Z]{2,4}|[0-9]{1,3}))>/', '<{@link mailto:\\1 \\1}>', $desc);
        return $this->_parseDesc($desc);
    }
    
    /**
     * Parse a description for inline tags/HTML
     * @param string
     * @access private
     * @return array
     */
    function _parseDesc($desc)
    {
        $lex = $this->_options['descparser'];
        $parser = $this->_options['descparser'];
        $description = $parser->parse(
            array('lexer' => $lex,
                  'nosummary' => true,
                  'tagdesc' => true,
                  'comment' => $desc,
                  'commentline' => $this->_options['lineNumber'],
                  'commenttoken' => false
                  ));
        return $description['documentation'];
    }
    
    /**
     * Return a type array like array("array") or
     * array("array", "object PhpDocumentor").
     *
     * All valid types must begin with a letter or underscore.  Anything else is
     * assumed to be a variable name or description
     * @return false|object|array
     */
    function getType()
    {
        // need at least 1 word to be a valid type
        $word = $this->getWord();
        if (!$word) {
            return false;
        }
        
        $types = array();
        $typeindex = 0;
        
        if ($word == 'object') {
            $types[$typeindex] .= $word;
            $word = $this->getWord();
            if (!$word) {
                // found the complete type
                return $types;
            }
            // this checks for object classname.  Classname may only begin
            // with alphanumeric and _
            if (!preg_match('/[a-zA-Z_]/', $word{0})) {
                $this->_index--;
                return $types;
            } else {
                // prepare for addition of classname
                $types[$typeindex] = ' ';
            }
        }
        
        $done = false;
        do
        { // this loop checks for type|type|type and for
          // type|object classname|type|object classname2
            if (!preg_match('/[a-zA-Z_]/', $word{0})) {
                break;
            }
            if (strpos($word, '|'))
            {
                if (!isset($types[$typeindex])) {
                    $types[$typeindex] = '';
                }
                $temptypes = explode('|', $word);
                while (count($temptypes) - 1) {
                    if (!isset($types[$typeindex])) {
                        $types[$typeindex] = '';
                    }
                    // grab all but the last type into its own array
                    $types[$typeindex++] .= array_shift($temptypes);
                }
                if (!isset($types[$typeindex])) {
                    $types[$typeindex] = '';
                }
                // this is just in case we have type1|type2|object classname
                // it will not increment $typeindex
                $types[$typeindex] .= $word = array_shift($temptypes);
                if ($word != 'object') {
                    // we're done
                    if (!count($types)) {
                        return false;
                    }
                    return $types;
                } else {
                    $typeindex++;
                }
            } else {
                if (!isset($types[$typeindex])) {
                    $types[$typeindex] = '';
                }
                if (!preg_match('/[a-zA-Z_]/', $word{0})) {
                    $this->_index--;
                    if (!count($types)) {
                        return false;
                    }
                    return $types;
                } else {
                    $types[$typeindex] .= $word;
                }
                return $types;
            }
            $word = $this->getWord();
        } while ($word);
        if (!count($types)) {
            return false;
        }
        return $types;
    }
    
    /**
     * Retrieve a type and optional variable name.
     *
     * This uses {@link getType()} to retrieve the type portion, and then uses
     * {@link getVar()} to retrieve the variable name portion
     * @return array Format: array('types' => type array|false, 'var' =>
     *                              false|variable)
     */
    function getTypeWithVar()
    {
        return array('types' => $this->getType(), 'var' => $this->getVar());
    }
    
    /**
     * Retrieve an optional variable name
     *
     * This checks the next word to see if it is begins with $ or &$, and
     * returns it as a variable name if so.
     * @return string|false
     */
    function getVar()
    {
        $word = $this->getWord();
        if ($word) {
            if (!preg_match('/^(?:\$|&\$)/', $word)) {
                $word = false;
                $this->_index--;
            }
        }
        return $word;
    }
}
