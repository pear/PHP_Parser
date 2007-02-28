--TEST--
PHP_Parser: test unticked_statement 1
--FILE--
<?php
require_once 'PHP/Parser/Core.php';
require_once 'PHP/Parser/Tokenizer.php';
$a = new PHP_Parser_Tokenizer(file_get_contents(dirname(__FILE__) . '/files/unticked_statement1.inc'));
$b = new PHP_Parser_Core($a);
while ($a->advance()) {
    $b->doParse($a->token, $a->getValue(), $a);
}
$b->doParse(0, 0);
var_dump($b->data);
var_dump($b->classes);
var_dump($b->interfaces);
var_dump($b->functions);
var_dump($b->includes);
var_dump($b->globals);
?>
===DONE===
--EXPECT--
array(20) {
  [0]=>
  array(1) {
    ["global"]=>
    string(2) "$a"
  }
  [1]=>
  array(1) {
    ["global"]=>
    string(2) "$a"
  }
  [2]=>
  array(2) {
    ["static"]=>
    string(2) "$a"
    ["default"]=>
    NULL
  }
  [3]=>
  array(2) {
    ["static"]=>
    string(2) "$a"
    ["default"]=>
    string(1) "1"
  }
  [4]=>
  array(2) {
    ["static"]=>
    string(2) "$a"
    ["default"]=>
    NULL
  }
  [5]=>
  array(2) {
    ["static"]=>
    string(2) "$b"
    ["default"]=>
    string(1) "1"
  }
  [6]=>
  array(2) {
    ["static"]=>
    string(2) "$a"
    ["default"]=>
    NULL
  }
  [7]=>
  array(2) {
    ["static"]=>
    string(2) "$b"
    ["default"]=>
    NULL
  }
  [8]=>
  array(1) {
    ["uses"]=>
    string(4) "'hi'"
  }
  [9]=>
  array(1) {
    ["uses"]=>
    string(6) "('hi')"
  }
  [10]=>
  array(2) {
    ["declare"]=>
    string(2) "hi"
    ["default"]=>
    string(1) "1"
  }
  [11]=>
  array(2) {
    ["declare"]=>
    string(2) "hi"
    ["default"]=>
    string(1) "1"
  }
  [12]=>
  array(2) {
    ["declare"]=>
    string(3) "hit"
    ["default"]=>
    string(1) "2"
  }
  [13]=>
  array(2) {
    ["declare"]=>
    string(3) "bye"
    ["default"]=>
    string(1) "3"
  }
  [14]=>
  array(2) {
    ["declare"]=>
    string(3) "hit"
    ["default"]=>
    string(1) "2"
  }
  [15]=>
  array(2) {
    ["declare"]=>
    string(3) "bye"
    ["default"]=>
    string(1) "3"
  }
  [16]=>
  array(1) {
    ["catches"]=>
    string(4) "Blah"
  }
  [17]=>
  array(1) {
    ["catches"]=>
    string(4) "Blah"
  }
  [18]=>
  array(1) {
    ["catches"]=>
    string(3) "Foo"
  }
  [19]=>
  array(1) {
    ["throws"]=>
    string(9) "Classname"
  }
}
array(0) {
}
array(0) {
}
array(0) {
}
array(0) {
}
array(0) {
}
===DONE===