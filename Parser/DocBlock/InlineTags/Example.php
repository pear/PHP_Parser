<?php
/**
 * @package PHP_Parser
 */
class PHP_Parser_DocBlock_InlineTags_Example extends PHP_Parser_DocBlock_InlineTags_Source {
    /**
     * @var string
     * @access private
     */
    var $_file;

    function structure()
    {
        return array('params' =>
                 array(
                     array('type' => 'word',
                           'required' => true,
                           'name' => 'file'),
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
     * @param array
     */
    function setFile($file)
    {
        $this->_file = $file;
    }
    
    function getLexerOptions()
    {
        return array();
    }
}
?>