<?php
require_once 'PHP/Parser/DocBlock/CommonLexer.php';
/**
 * @package PHP_Parser
 */
class PHP_Parser_DocBlock_DefaultInlineTagLexer extends PHP_Parser_DocBlock_CommonLexer
{
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
}
?>