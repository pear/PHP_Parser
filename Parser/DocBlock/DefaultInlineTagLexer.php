<?php
/**
 * @package PHP_Parser
 */
class PHP_Parser_DocBlock_DefaultInlineTagLexer
{
    /**
     * Run-time options
     * @access protected
     * @var array
     */
    var $_options = array();
    /**
     * @var string
     * @access private
     */
    var $_buf;
    /**
     * @var integer
     * @access private
     */
    var $_index;
    /**
     * Indicates whether the current Inline Tag contains separate sections
     *
     * This parameter is a flag used to determine whether the input buffer
     * has been split into sections such as what happens in a {@}link} tag.
     * (Sections are delimited by commas.)
     * @var boolean
     */
    var $_multipleBuffers = false;
    /**
     * Mapping of inline tag field types to lexer function name
     *
     * Use this array to extend the inlinetag parser, simply add a mapping of
     * typename => lexer function name.  The function name must exist or
     * an exception will be thrown
     * @access protected
     */
    var $_typeMap =
        array(
              'word' => 'getWord',
              'link' => 'getLink',
              'multi-word' => 'getWords',
              'allwords' => 'getAllWords',
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
        $this->_options['separator'] = false;
        $this->_options = array_merge($this->_options, $options);
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
            $ret = $save;
            if ($this->_readBuf(false)) {
                $ret .= $ret . ' ' . $this->_readBuf();
            } else {
                return false;
            }
        } else {
            return $save;
        }
        return $ret;
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
        while ($word = $this->_readBuf(true)) {
            if ($ret != '') {
                $ret .= ' ';
            }
            $ret .= $word;
        }
        if ($ret == '') {
            return false;
        } else {
            return $ret;
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
     * For single-segment inline tags, this returns the whole buffer.  For
     * multi-segment inline tags, this returns the current buffer, or if it
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
     * Prepare inline tag contents for lexing.
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
                // strip open and close {@ } and collapse all whitespace
                preg_match_all('/([^\s]+)(\s+)?/', ltrim($data), $this->_buf[$this->_bufIndex++]);
//                $this->_buf[$this->_bufIndex++] = preg_split("/\s+/", ltrim($data));
            }
            $this->_bufIndex = 0;
            $this->_multipleBuffers = true;
        } else {
            // strip open and close {@ } and collapse all whitespace
            preg_match_all('/([^\s]+)(\s+)?/', ltrim($data), $this->_buf);
        }
        $this->_index = 0;
    }

    /**
     * Passes data to {@link newTag()}
     * @var string
     */
    function PHP_Parser_DocBlock_DefaultInlineTagLexer($data = '')
    {
        $this->debug = false;
        $this->setOptions();
        $this->newTag($data);
    }
}
