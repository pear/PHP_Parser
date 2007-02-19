--TEST--
PHP_Parser: test empty file
--FILE--
<?php
require_once 'PHP/Parser/Core.php';
require_once 'PHP/Parser/Tokenizer.php';
$a = new PHP_Parser_Tokenizer(file_get_contents(dirname(__FILE__) . '/files/basic.inc'));
$b = new PHP_Parser_Core($a);
$b->printTrace();
while ($a->advance()) {
    $b->doParse($a->token, $a->getValue(), $a);
}
$b->doParse(0, 0);
var_dump($b->data);
?>
===DONE===
--EXPECT--
Input $
Reduce (2) [top_statement_list ::=].
Shift 13
Stack: top_statement_list
Reduce (0) [start ::= top_statement_list].
Accept!
Popping $
array(0) {
}
===DONE===