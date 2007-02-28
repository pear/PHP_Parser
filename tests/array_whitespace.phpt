--TEST--
PHP_Parser: test array default value whitespace calculation
--FILE--
<?php
require_once 'PHP/Parser/Core.php';
require_once 'PHP/Parser/Tokenizer.php';
$a = new PHP_Parser_Tokenizer(file_get_contents(dirname(__FILE__) . '/files/array_whitespace.inc'));
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
array(1) {
  [0]=>
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(2)
    ["endline"]=>
    int(17)
    ["returnsref"]=>
    bool(false)
    ["name"]=>
    string(5) "test1"
    ["parameters"]=>
    array(1) {
      [0]=>
      array(4) {
        ["typehint"]=>
        string(0) ""
        ["param"]=>
        string(2) "$a"
        ["isreference"]=>
        bool(false)
        ["default"]=>
        string(37) "array(1, 2 => 'hi', 'my' => array(4))"
      }
    }
    ["info"]=>
    array(2) {
      [0]=>
      array(2) {
        ["static"]=>
        string(2) "$b"
        ["default"]=>
        string(138) "array(
        array(
            1,
            2,
            3 => 'hello',
            array('my' => 'goodness')
        )
    )"
      }
      [1]=>
      array(2) {
        ["uses"]=>
        string(5) "class"
        ["name"]=>
        string(4) "Test"
      }
    }
  }
}
array(0) {
}
array(0) {
}
array(1) {
  ["test1"]=>
  array(1) {
    [0]=>
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(2)
      ["endline"]=>
      int(17)
      ["returnsref"]=>
      bool(false)
      ["name"]=>
      string(5) "test1"
      ["parameters"]=>
      array(1) {
        [0]=>
        array(4) {
          ["typehint"]=>
          string(0) ""
          ["param"]=>
          string(2) "$a"
          ["isreference"]=>
          bool(false)
          ["default"]=>
          string(37) "array(1, 2 => 'hi', 'my' => array(4))"
        }
      }
      ["info"]=>
      array(2) {
        [0]=>
        array(2) {
          ["static"]=>
          string(2) "$b"
          ["default"]=>
          string(138) "array(
        array(
            1,
            2,
            3 => 'hello',
            array('my' => 'goodness')
        )
    )"
        }
        [1]=>
        array(2) {
          ["uses"]=>
          string(5) "class"
          ["name"]=>
          string(4) "Test"
        }
      }
    }
  }
}
array(0) {
}
array(0) {
}
===DONE===