<?php
/**
 * @package PHP_Parser
 */
class PHP_Parser_DocBlock_InlineTags_Source extends PHP_Parser_DocBlock_InlineTags_Base {
    /**
     * @access protected
     */
    var $_startline = 1;
    /**
     * @access protected
     */
    var $_length = -1;

    function structure()
    {
        return array('params' =>
                 array(
                     array('type' => 'word',
                           'required' => false,
                           'name' => 'startline'),
                     array('type' => 'word',
                           'required' => false,
                           'name' => 'length')
                      )
               );
    }
    
    /**
     * @todo throw exception if $line isn't a number
     */
    function setStartLine($line)
    {
        if (is_numeric($line)) {
            $this->_startline = $line + 0;
        } else {
            // throw exception
        }
    }
    
    function setLength($length)
    {
        if (is_numeric($line)) {
            $this->_length = $length + 0;
        } else {
            // throw exception
        }
    }
    
    function getLexerOptions()
    {
        return array();
    }
}
?>