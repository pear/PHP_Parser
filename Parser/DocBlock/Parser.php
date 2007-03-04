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
        $this->_parser = new PHP_DocblockParser($this->_lex, $processInternal);
    }

    function parse($data, PHP_Parser_Tokenizer $tokenizer)
    {
        $this->_lex = new PHP_DocblockParser_Tokenizer($data);
        while ($this->_lex->advance()) {
            $this->_parser->doParse($this->_lex->token, $this->_lex->getValue());
        }
        $this->_parser->doParse(0, 0);
        if (!count($this->_parser->data['tags'])) {
            return $this->_parser->data;
        }
        if (!isset($this->_parser->data['tags']['global'])) {
            return $this->_parser->data;
        }
        if (count($this->_parser->data['tags']['global']) > 1) {
            // too many @global tags, this isn't valid
            return $this->_parser->data;
        }
        if (count($this->_parser->data['tags'])) {
            foreach ($this->_parser->data['tags']['global'] as $tag) {
                if ($tag['text']) {
                    if (!is_array($tag['text'])) {
                        $info = preg_split('/[\t ]+/', trim($tag['text']), 2);
                        if (count($info) != 2) {
                            break;
                        }
                        if ($info[0][0] == '$') {
                            // invalid
                            break;
                        }
                        if ($info[1][0] != '$') {
                            // function-level @global
                            break;
                        }
                        $tokenizer->_setGlobalSearch(trim($info[1]));
                        return $this->_parser->data;
                    }
                }
            }
        }
        return $this->_parser->data;
    }
}
?>