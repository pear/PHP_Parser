<?php
/**
 * @package PHP_Parser
 */
class PHP_Parser_DocBlock_InlineTags_Link
    extends PHP_Parser_DocBlock_InlineTags_Base {
    /**
     * @access protected
     */
    var $_link = array();
    /**
     * @access protected
     */
    var $_description = array();

    function structure()
    {
        return array('params' =>
                 array(
                     array('type' => 'link',
                           'required' => true,
                           'name' => 'link'),
                     array('type' => 'allwords',
                           'required' => false,
                           'name' => 'description')
                      )
               );
    }
    
    function setLink($link)
    {
        $this->_link[] = $link;
    }
    
    function setDescription($description)
    {
        $this->_description[count($this->_link) - 1] = $description;
    }
    
    function getLexerOptions()
    {
        return array('separator' => ',');
    }
}
?>