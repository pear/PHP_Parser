<?php
/**
 * @package PHP_Parser
 */
class PHP_Parser_DocBlock_InlineTags_Inheritdoc extends PHP_Parser_DocBlock_InlineTags_Base {
    function structure()
    {
        return array('params' =>
                 array(
                      )
               );
    }

    function getLexerOptions()
    {
        return array();
    }
}
?>