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
     * Stores the tokens for the inline tag
     *
     * The inline tag buffer has three components:
     *
     *  1 tokens with trailing whitespace
     *  2 tokens without whitespace
     *  3 trailing whitespace only
     *
     * $_buf is a zero-indexed array (index 0 is tokens with whitespace).
     *
     * If the inline tag allows separators (like ","), then it is an array
     * of buffers as described above (see {@link $_multipleBuffers})
     * @var string
     * @access private
     */
    var $_buf;
    /**
     * @var Error_Stack
     * @access private
     */
    var $_stack;
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
        $word = $this->getWord();
        if (!$word) {
            return false;
        }
        $details = array();
        $details['link'] = $details['text'] = $word;
        $details['valid'] = true;
        $details['type'] = 'unknown';
        $save = $word;
        if (strpos($word, '#')) {
            $details['link'] = $word = substr($word, strpos($word, '#') + 1); // chop off package selector
            $details['package'] = substr($save, 0, strlen($save) - strlen($word) - 1);
        }
        if (in_array($word, array('function', 'global', 'object', 'constant'))) {
            $details['link'] = false;
            $details['type'] = $word;
            if ($word = $this->_readBuf()) {
                $details['text'] .= ' ' . $word;
                $details['link'] = $word;
                $is_func = false;
                if (strpos($word, '::')) {
                    $details['valid'] = false;
                    $details['link'] = false;
                }
                if (strpos($word, '()') && $details['type'] != 'function') {
                    $details['valid'] = false;
                    $details['link'] = false;
                } elseif ($details['type'] == 'function') {
                    if (strpos($word, '::')) {
                        $details['valid'] = true;
                        $details['link'] = substr($word, strpos($word, '::') + 2);
                        $details['class'] = substr($word, 0,
                            strlen($word) - strlen($details['link']) - 2);
                        $details['type'] = 'method';
                    }
                    $details['link'] = str_replace('()', '', $details['link']);
                }
                if (strpos($word, '$') === 0 && $details['type'] != 'global') {
                    $details['valid'] = false;
                    $details['link'] = false;
                }
            } else {
                // invalid link
                $details['valid'] = false;
                $details['link'] = false;
            }
        } else {
            $is_func = false;
            $is_var = false;
            $is_member = false;
            if (strpos($word, '()')) {
                $details['link'] = str_replace('()', '', $details['link']);
                $is_func = true;
            }
            if (strpos($word, '$') === 0) {
                $is_var = true;
            }
            if (strpos($word, '::')) {
                $is_member = true;
            }
            if ($is_member) {
                $details['link'] = substr($word, strpos($word, '::') + 2);
                $details['class'] = substr($word, 0,
                    strlen($word) - strlen($details['link']) - 2);
                if (strpos($details['link'], '$') === 0) {
                    $is_var = true;
                }
                $details['type'] = $is_func ? 'method' : ($is_var ? 'var' : 'class constant');
                $details['link'] = str_replace('()', '', $details['link']);
            } else {
                $details['type'] = $is_func ? 'function' : ($is_var ? 'global' : 'unknown');
            }
        }
        return $details;
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
     * Retrieve multiple words from the tag contents with trailing whitespace
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
     * @return false|string
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
            return false;
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
        return $this->_bufIndex < count($this->_buf) - 1;
    }
    
    /**
     * Move to next buffer in the multi-section tag
     * @return boolean Success is returned
     */
    function moveNextBuf()
    {
        if (!$this->hasNextBuf()) {
            if ($this->_multipleBuffers) {
                ++$this->_bufIndex;
            }
            return false;
        }
        $this->_index = 0;
        return $this->_buf[++$this->_bufIndex];
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
     * splitting it along whitespace, and along any separators.
     *
     * Note that separators may be escaped using a backslash.  If the separator is
     * a comma ",", this string "my \, is escaped, tried, and true" will split into:
     * - "my , is escaped"
     * - "tried"
     * - "and true"
     *
     * Note that all leading whitespace is removed in all contexts ("tried" instead of " tried")
     * passed to {@link setOptions()}
     * @param string
     */
    function newTag($data)
    {
        $this->_buf = array();
        $data = ltrim($data);
        if ($this->_options['separator']) {
            $data2 = explode($this->_options['separator'], $data);
            $newdata = array();
            $save = '';
            // post-process
            foreach ($data2 as $data) {
                // allow escaping of the separator using "\"
                if (substr($data, -1) == '\\') {
                    $save = substr($data, 0, strlen($data) - 1) . $this->_options['separator'];
                } else {
                    $newdata[] = $save . $data;
                    $save = '';
                }
            }
            $data2 = $newdata;
            $this->_bufIndex = 0;
            foreach($data2 as $data) {
                // collapse all whitespace
                preg_match_all('/([^\s]+)(\s+)?/', ltrim($data), $this->_buf[$this->_bufIndex++]);
//                $this->_buf[$this->_bufIndex++] = preg_split("/\s+/", ltrim($data));
            }
            $this->_bufIndex = 0;
            $this->_multipleBuffers = true;
        } else {
            // collapse all whitespace
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
//        $this->_stack = &PHP_Parser_Stack::singleton('PHP_Parser_DocBlock_DefaultInlineTagLexer');
    }
}
?>