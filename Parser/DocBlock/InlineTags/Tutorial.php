<?php
/**
 * @package phpDocumentor
 */
class PHP_Parser_DocBlock_InlineTags_Tutorial extends PHP_Parser_DocBlock_InlineTags_Base {
    /**
     * @access protected
     */
    var $_link;
    /**
     * @access protected
     */
    var $_title = array();

    function structure()
    {
        return array('params' =>
                 array(
                     array('type' => 'word',
                           'required' => true,
                           'name' => 'link'),
                     array('type' => 'allwords',
                           'required' => false,
                           'name' => 'title')
                      )
               );
    }
    
    function setLink($link)
    {
        $this->_link = $link;
    }
    
    function setTitle($title)
    {
        $this->_title[count($this->_link) - 1] = $title;
    }
    
    function getLexerOptions()
    {
        return array('separator' => ',');
    }
}
?>