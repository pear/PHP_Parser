<?php
require_once 'PHP/DocblockParser.php';
require_once 'PHP/DocblockParser/Tokenizer.php';
/**
 * Basic PHP_Parser docblock parsing mechanism.
 *
 * This allows processing of @global tags to search
 * for global variables, for instance, as well as
 * parsing out the structure of doc comments
 */
class PHP_Parser_Docblock_Parser
{
    private $_lex;
    private $_parser;
    function __construct($data, $processInternal = false)
    {
        $this->_lex = new PHP_DocblockParser_Tokenizer($data);
        $this->_parser = new PHP_DocblockParser($this->_lex, $processInternal);
    }

    function parse()
    {
        while ($this->_lex->advance()) {
            $this->_parser->doParse($this->_lex->token, $this->_lex->getValue());
        }
        $this->_parser->doParse(0, 0);
        return $this->_parser->data;
    }
}
?>