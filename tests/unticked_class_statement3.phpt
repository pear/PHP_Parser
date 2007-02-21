--TEST--
PHP_Parser: test unticked_class_statement 3
--FILE--
<?php
require_once 'PHP/Parser/Core.php';
require_once 'PHP/Parser/Tokenizer.php';
$a = new PHP_Parser_Tokenizer(file_get_contents(dirname(__FILE__) . '/files/unticked_class_statement3.inc'));
$b = new PHP_Parser_Core($a);
while ($a->advance()) {
    $b->doParse($a->token, $a->getValue(), $a);
}
$b->doParse(0, 0);
var_dump($b->data);
?>
===DONE===
--EXPECT--
array(1) {
  [0]=>
  array(4) {
    ["type"]=>
    string(9) "interface"
    ["name"]=>
    string(4) "blah"
    ["extends"]=>
    array(0) {
    }
    ["info"]=>
    array(3) {
      [0]=>
      array(3) {
        ["type"]=>
        string(5) "const"
        ["name"]=>
        string(1) "a"
        ["value"]=>
        string(1) "1"
      }
      [1]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(1) "a"
        ["parameters"]=>
        array(0) {
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
      }
      [2]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(1) "b"
        ["parameters"]=>
        array(3) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(3) "Foo"
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
          [1]=>
          array(4) {
            ["typehint"]=>
            string(3) "Arp"
            ["param"]=>
            string(2) "$b"
            ["isreference"]=>
            bool(true)
            ["default"]=>
            string(4) "null"
          }
          [2]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$c"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            string(7) "array()"
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
      }
    }
  }
}
===DONE===