<?php


require_once 'PHP/Parser.php';

//print_r(PHP_Parser::staticParseFile(__FILE__));

$p = PHP_Parser::factory();
print_r($p->parseString(file_get_contents(__FILE__)));




