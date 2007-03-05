--TEST--
PHP_Parser: test global variables
--SKIPIF--
<?php
$fp = @fopen('PHP/Parser/DocblockParser.php', 'r', true);
if ($fp) {
    fclose($fp);
} else {
    echo 'skip no PHP_Parser_DocblockParser';
}
?>
--FILE--
<?php
require_once 'PHP/Parser/Core.php';
require_once 'PHP/Parser/Tokenizer.php';
require_once 'PHP/Parser/Docblock/Parser.php';
$a = new PHP_Parser_Tokenizer('<?php
$a = "hi";
/**
 * @global string $GLOBALS[\'hi there\']
 */
$GLOBALS[\'hi there\'] = "holy crap";
?>', new PHP_Parser_Docblock_Parser(''));
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
    string(6) "global"
    ["name"]=>
    string(20) "$GLOBALS['hi there']"
    ["line"]=>
    int(6)
    ["default"]=>
    string(11) ""holy crap""
    ["doc"]=>
    string(48) "/**
 * @global string $GLOBALS['hi there']
 */"
    ["parseddoc"]=>
    array(2) {
      ["desc"]=>
      string(3) "
 "
      ["tags"]=>
      array(1) {
        ["global"]=>
        array(1) {
          [0]=>
          array(2) {
            ["tag"]=>
            string(6) "global"
            ["text"]=>
            string(30) " string $GLOBALS['hi there']
"
          }
        }
      }
    }
    ["docline"]=>
    int(3)
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
array(1) {
  ["$GLOBALS['hi there']"]=>
  array(1) {
    [0]=>
    array(7) {
      ["type"]=>
      string(6) "global"
      ["name"]=>
      string(20) "$GLOBALS['hi there']"
      ["line"]=>
      int(6)
      ["default"]=>
      string(11) ""holy crap""
      ["doc"]=>
      string(48) "/**
 * @global string $GLOBALS['hi there']
 */"
      ["parseddoc"]=>
      array(2) {
        ["desc"]=>
        string(3) "
 "
        ["tags"]=>
        array(1) {
          ["global"]=>
          array(1) {
            [0]=>
            array(2) {
              ["tag"]=>
              string(6) "global"
              ["text"]=>
              string(30) " string $GLOBALS['hi there']
"
            }
          }
        }
      }
      ["docline"]=>
      int(3)
    }
  }
}
===DONE===