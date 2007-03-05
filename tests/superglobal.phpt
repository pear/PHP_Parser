--TEST--
PHP_Parser: test superglobals
--FILE--
<?php
require_once 'PHP/Parser/Core.php';
require_once 'PHP/Parser/Tokenizer.php';
$a = new PHP_Parser_Tokenizer('<?php
$a = $_POST["hi"];
$b = $GLOBALS[$_GET["biu".$q]];
?>
'
);
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
array(3) {
  [0]=>
  array(2) {
    ["superglobal"]=>
    string(6) "$_POST"
    ["contents"]=>
    string(12) "$_POST["hi"]"
  }
  [1]=>
  array(2) {
    ["superglobal"]=>
    string(8) "$GLOBALS"
    ["contents"]=>
    string(27) "$GLOBALS[$_GET["biu" . $q]]"
  }
  [2]=>
  array(2) {
    ["superglobal"]=>
    string(5) "$_GET"
    ["contents"]=>
    string(17) "$_GET["biu" . $q]"
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