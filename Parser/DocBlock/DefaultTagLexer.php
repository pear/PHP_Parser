<?php
/**
 * @package PHP_Parser
 */
class PHP_Parser_DocBlock_DefaultTagLexer
{
    /**
     * @var string
     */
    var $_buf;
    /**
     * @var integer
     */
    var $_index;
    /**
     * Indicates whether the current Tag contains separate sections
     *
     * This parameter is a flag used to determine whether the input buffer
     * has been split into sections such as what happens in a @see tag.
     * Sections are delimited by commas.
     * @var boolean
     */
    var $_multipleBuffers = false;
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
     * return something useful, when a parse error occurs.
     *
     * used to build error messages if the parser fails, and needs to know the line number..
     *
     * @return   string 
     * @access   public 
     */
    function parseError() 
    {
        return "Error at line {$this->yyline}";
    }

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
     * @param array
     */
    function setOptions($options = array())
    {
        $this->_options['descParserClass'] = 
        $this->_options['descLexerClass'] = 
        false;
        $this->_options['lineNumber'] = 1;
        $this->_options = array_merge($this->_options, $options);
        if (!is_object($this->_options['descParserClass']) ||
                !is_object($this->_options['descLexerClass'])) {
            return false;
        }
    }
    
    /**
     * Retrieve the next word from the tag contents
     * @return string|false
     */
    function getWord()
    {
        return $this->_readBuf();
    }

    /**
     * Retrieve multiple words from the tag contents
     * @param integer the number of words to return
     * @return false|string
     */
    function getWords($param)
    {
        $count = $param['count'];
        $ret = '';
        for ($i = 0; $i < $count; $i++) {
            if ($word = $this->_readBuf(true, true)) {
                $ret .= $word;
            }
        }
        return rtrim($ret);
    }

    /**
     * Retrieve all remaining words from the tag contents
     * @return string|false
     */
    function getAllWords()
    {
        $ret = '';
        while ($word = $this->_readBuf(true, true)) {
            $ret .= $word;
        }
        if ($ret == '') {
            return false;
        } else {
            return $ret;
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
        $lex = $this->_options['descLexerClass'];
        $parser = $this->_options['descParserClass'];
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
    
    /**
     * Return a link expected by phpDocumentor
     *
     * This will be either 1 or two words.  This is to
     * allow links like "function mine()" and so on
     * @return false|string
     */
    function getLink()
    {
        // must have at least 1 word to be a valid link
        $ret = $this->getWord();
        if (!$ret) {
            return false;
        }
        $save = $ret;
        if (strpos($ret, '#')) {
            $ret = substr($ret, strpos($ret, '#') + 1); // chop off package selector
        }
        // if the word is function or global
        if (in_array($ret, array('function', 'global'))) {
            if ($this->_readBuf(false)) {
                $ret = $save;
                $ret .= ' ' . $this->_readBuf();
                return $ret;
            } else {
                return false;
            }
        } else {
            return $save;
        }
    }
    
    /**
     * Read a word from the buffer
     * @param boolean whether to increment the index into the buffer
     * @param boolean whether to include whitespace
     * @access private
     */
    function _readBuf($inc = true, $whitespace = false)
    {
        $index = $this->_index;
        $buf = $this->_getBuf();
        if ($inc) {
            $this->_index++;
        }
        if (!isset($buf[1][$index])) {
            return null;
        }
        if ($whitespace) {
            return $buf[0][$index];
        }
        return $buf[1][$index];
    }
    
    /**
     * Returns true if there is another segment of the multi-segment
     * inline tag to parse.
     * @return boolean
     */
    function hasNextBuf()
    {
        if (!$this->_multipleBuffers) {
            return false;
        }
        if (!isset($this->_buf[$this->_bufIndex][0][$this->_index]) &&
                !isset($this->_buf[$this->_bufIndex + 1])) {
            return false;
        }
        return $this->_bufIndex < count($this->_buf);
    }
    
    /**
     * Move to next buffer in the multi-section tag
     * @return boolean Success is returned
     */
    function moveNextBuf()
    {
        if (isset($this->_buf[++$this->_bufIndex][0])) {
            $this->_index = 0;
            return $this->_buf[$this->_bufIndex];
        } else {
            return false;
        }
    }
    
    /**
     * Return the input buffer
     *
     * For single-segment tags, this returns the whole buffer.  For
     * multi-segment tags, this returns the current buffer, or if it
     * is empty, returns the next one
     * @return array
     */
    function _getBuf()
    {
        if ($this->_multipleBuffers) {
            if (isset($this->_buf[$this->_bufIndex][0][$this->_index])) {
                return $this->_buf[$this->_bufIndex];
            } else {
                return false;
            }
        } else {
            return $this->_buf;
        }
    }
    
    /**
     * Prepare tag contents for lexing.
     *
     * This function replaces the current buffer with the data after
     * splitting it along whitespace, and along any separators
     * passed to {@link setOptions()}
     * @param string
     */
    function newTag($data)
    {
        $data = ltrim($data);
        if ($this->_options['separator']) {
            $data2 = explode($this->_options['separator'], $data);
            $this->_bufIndex = 0;
            foreach($data2 as $data) {
                // strip out all whitespace
                preg_match_all('/([^\s]+)(\s+)?/', ltrim($data), $this->_buf[$this->_bufIndex++]);
//                $this->_buf[$this->_bufIndex++] = preg_split("/\s+/", ltrim($data));
            }
            $this->_bufIndex = 0;
            $this->_multipleBuffers = true;
        } else {
            $this->_multipleBuffers = false;
            // strip out all whitespace
            preg_match_all('/([^\s]+)(\s+)?/', ltrim($data), $this->_buf);
//            $this->_buf = preg_split("/\s+/", $data);
        }
        $this->_index = 0;
    }

    /**
     * Passes data to {@link newTag()}
     * @var string
     */
    function PHP_Parser_DocBlock_DefaultTagLexer($data = '')
    {
        $this->debug = false;
        if (!empty($data)) {
            $this->setOptions();
            $this->newTag($data);
        }
    }
}
