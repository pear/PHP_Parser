<?php


require_once 'PHP/Parser.php';

//this uses gregs more advanced parser
//pulls out more detailed information from the file.

$p = PHP_Parser::factory('Structure','Structure');
print_r($p->parseString(file_get_contents(__FILE__)));



class test { 
    function test() {
       echo "hello world";
    }
}
