<?php

/**
 * API Unit tests for PHP_Parser package.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org> portions from HTML_CSS
 * @author     Greg Beaver
 * @package    PHP_Parser
 */

/**
 * @package PHP_Parser
 */

class PHP_Parser_test_class_php5 extends PHPUnit_TestCase
{
    /**
     * A PHP_Parser object (or one of the drivers)
     * @var        object
     */
    var $parser;
    /**
     * This will be Error_Stack if the package is accepted into PEAR
     */
    var $errorStackClass = 'PHP_Parser_Stack';
    
    /**#@+
     * Error Stacks
     */
    var $pstack;
    var $sstack;
    var $estack;

    function PHP_Parser_test_class($name)
    {
        $this->PHPUnit_TestCase($name);
    }

    function setUp()
    {
        error_reporting(E_ALL);
        $this->errorOccured = false;
        set_error_handler(array(&$this, 'errorHandler'));

        $this->parser = new PHP_Parser;
        $this->pstack = &PHP_Parser_Stack::singleton('PHP_Parser');
        $this->sstack = &PHP_Parser_Stack::singleton('PHP_Parser_Structure');
        $this->estack = &PHP_Parser_Stack::singleton('PHP_Parser_Extendable');
        $this->_expectedErrors = array();
        $this->_testMethod = 'unknown';
    }

    function tearDown()
    {
        // purge all error stacks
        PHP_Parser_Stack::staticGetErrors(true);
        unset($this->pstack);
        unset($this->sstack);
        unset($this->estack);
        unset($this->parser);
        restore_error_handler();
    }

    function errorCodeToString($code)
    {
        $codes = array(
           'PHP_Parser' =>
            array(
                PHP_PARSER_ERROR_NODRIVER => 'PHP_PARSER_ERROR_NODRIVER',
                PHP_PARSER_ERROR_NOTINITIALIZED => 'PHP_PARSER_ERROR_NOTINITIALIZED',
            ),
           'PHP_Parser_Structure' =>
            array(
                PHP_PARSER_ERROR_NODRIVER => 'PHP_PARSER_ERROR_NODRIVER'
            ),
           'PHP_Parser_Extendable' =>
            array(
                PHP_PARSER_ERROR_NODRIVER => 'PHP_PARSER_ERROR_NODRIVER'
            ),
        );
        return $codes[$code];
    }

    function _stripWhitespace($str)
    {
        return preg_replace('/\\s+/', '', $str);
    }

    function _methodExists($name) 
    {
        $test = (version_compare(phpversion(), '4.3.5', '>') == 1) ? $name : strtolower($name);
        if (in_array($test, get_class_methods($this->parser))) {
            return true;
        }
        $this->assertTrue(false, 'method '. $name . ' not implemented in ' . get_class($this->parser));
        return false;
    }

    function errorHandler($errno, $errstr, $errfile, $errline) {
        if (error_reporting() == 0) {
            return;
        }
        //die("$errstr in $errfile at line $errline: $errstr");
        $this->errorOccured = true;
        $this->assertTrue(false, "$errstr at line $errline, $errfile");
    }
    
    function assertErrors($errors, $method)
    {
        $compare = PHP_Parser_Stack::staticGetErrors(false, true);
        $save = $compare;
        foreach ($errors as $err) {
        	for ($i = 0; $i < count($compare); $i++) {
        	    if ($err['level'] == $compare[$i]['level'] &&
                      $err['package'] == $compare[$i]['package'] &&
                      $err['message'] == $compare[$i]['message']) {
        	        unset($compare[$i]);
        	    }
        	}
        }
        if (count($compare)) {
            foreach ($compare as $err) {
            	$this->assertFalse(true, "Extra error: package $err[package], message '$err[message]'");
            }
        }
        foreach ($save as $err) {
        	for ($i = 0; $i < count($errors); $i++) {
        	    if ($err['level'] == $errors[$i]['level'] &&
                      $err['package'] == $errors[$i]['package'] &&
                      $err['message'] == $errors[$i]['message']) {
        	        unset($errors[$i]);
        	    }
        	}
        }
        foreach ($errors as $err) {
        	$this->assertFalse(true, "Unthrown error: package $err[package], message '$err[message]'");
        }
    }
    
    function assertNoErrors($method, $message)
    {
        $errs = PHP_Parser_Stack::staticGetErrors(false, true);
        $error = 'error';
        if (count($errs)) {
            if (count($errs) > 1) {
                $error .= 's';
            }
            $count = count($errs);
            $this->assertFalse(true, "$method $message triggered $count $error:");
            foreach ($errs as $error) {
            	$this->assertFalse(true, $error['message']);
            }
        }
        PHP_Parser_Stack::staticGetErrors(true);
    }
    
    function test_valid_classimplements1()
    {
        if (!$this->_methodExists('setParser')) {
            return;
        }
        if (!$this->_methodExists('setTokenizer')) {
            return;
        }
        if (!$this->_methodExists('setTokenizerOptions')) {
            return;
        }
        $testPHP = <<<EOF
<?php
class foochunk implements Ione {}
?>
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizerOptions()');
        $e = $this->parser->parseString($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'parseString');
        $this->assertEquals(
            array(
                'classes' => array(
                    'foochunk' =>
                        array(
                            'extends' => '',
                            'type' => '',
                            'methods' =>
                                array(
                                ),
                            'vars' =>
                                array(
                                ),
                            'consts' =>
                                array(
                                ),
                            'implements' =>
                                array(
                                    'Ione'
                                ),
                            'startline' => 2,
                            'endline' => 2,
                            'documentation' => null,
                        )
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_classimplements_extends()
    {
        if (!$this->_methodExists('setParser')) {
            return;
        }
        if (!$this->_methodExists('setTokenizer')) {
            return;
        }
        if (!$this->_methodExists('setTokenizerOptions')) {
            return;
        }
        $testPHP = <<<EOF
<?php
class foochunk extends blah implements Ione {}
?>
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizerOptions()');
        $e = $this->parser->parseString($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'parseString');
        $this->assertEquals(
            array(
                'classes' => array(
                    'foochunk' =>
                        array(
                            'extends' => 'blah',
                            'type' => '',
                            'methods' =>
                                array(
                                ),
                            'vars' =>
                                array(
                                ),
                            'consts' =>
                                array(
                                ),
                            'implements' =>
                                array(
                                    'Ione'
                                ),
                            'startline' => 2,
                            'endline' => 2,
                            'documentation' => null,
                        )
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_classimplements2()
    {
        if (!$this->_methodExists('setParser')) {
            return;
        }
        if (!$this->_methodExists('setTokenizer')) {
            return;
        }
        if (!$this->_methodExists('setTokenizerOptions')) {
            return;
        }
        $testPHP = <<<EOF
<?php
class foochunk implements Ione, Itwo {}
?>
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizerOptions()');
        $e = $this->parser->parseString($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'parseString');
        $this->assertEquals(
            array(
                'classes' => array(
                    'foochunk' =>
                        array(
                            'extends' => '',
                            'type' => '',
                            'methods' =>
                                array(
                                ),
                            'vars' =>
                                array(
                                ),
                            'consts' =>
                                array(
                                ),
                            'implements' =>
                                array(
                                    'Ione',
                                    'Itwo'
                                ),
                            'startline' => 2,
                            'endline' => 2,
                            'documentation' => null,
                        )
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_simpleinterface()
    {
        if (!$this->_methodExists('setParser')) {
            return;
        }
        if (!$this->_methodExists('setTokenizer')) {
            return;
        }
        if (!$this->_methodExists('setTokenizerOptions')) {
            return;
        }
        $testPHP = <<<EOF
<?php
interface foochunk {}
?>
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizerOptions()');
        $e = $this->parser->parseString($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'parseString');
        $this->assertEquals(
            array(
                'classes' => array(),
                'interfaces' => array(
                    'foochunk' =>
                        array(
                            'methods' =>
                                array(
                                ),
                            'extends' =>
                                array(
                                ),
                            'startline' => 2,
                            'endline' => 2,
                            'documentation' => null,
                        )
                ),
                'includes' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_interfaceextends1()
    {
        if (!$this->_methodExists('setParser')) {
            return;
        }
        if (!$this->_methodExists('setTokenizer')) {
            return;
        }
        if (!$this->_methodExists('setTokenizerOptions')) {
            return;
        }
        $testPHP = <<<EOF
<?php
interface foochunk extends foo {}
?>
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizerOptions()');
        $e = $this->parser->parseString($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'parseString');
        $this->assertEquals(
            array(
                'classes' => array(),
                'interfaces' => array(
                    'foochunk' =>
                        array(
                            'methods' =>
                                array(
                                ),
                            'extends' =>
                                array(
                                    'foo',
                                ),
                            'startline' => 2,
                            'endline' => 2,
                            'documentation' => null,
                        )
                ),
                'includes' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_interfaceextends2()
    {
        if (!$this->_methodExists('setParser')) {
            return;
        }
        if (!$this->_methodExists('setTokenizer')) {
            return;
        }
        if (!$this->_methodExists('setTokenizerOptions')) {
            return;
        }
        $testPHP = <<<EOF
<?php
interface foochunk extends foo, bar {}
?>
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizerOptions()');
        $e = $this->parser->parseString($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'parseString');
        $this->assertEquals(
            array(
                'classes' => array(),
                'interfaces' => array(
                    'foochunk' =>
                        array(
                            'methods' =>
                                array(
                                ),
                            'extends' =>
                                array(
                                    'foo',
                                    'bar'
                                ),
                            'startline' => 2,
                            'endline' => 2,
                            'documentation' => null,
                        )
                ),
                'includes' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_interfacemethod1()
    {
        if (!$this->_methodExists('setParser')) {
            return;
        }
        if (!$this->_methodExists('setTokenizer')) {
            return;
        }
        if (!$this->_methodExists('setTokenizerOptions')) {
            return;
        }
        $testPHP = '<?php
interface foochunk {
    public function test();
    public function thisone($a, $another);
    private function mine(someclass $ar);
}
?>';
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizerOptions()');
        $e = $this->parser->parseString($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'parseString');
        $this->assertEquals(
            array(
                'classes' => array(),
                'interfaces' => array(
                    'foochunk' =>
                        array(
                            'methods' =>
                                array(
                                    'test' => array(
                                        'name' => 'test',
                                        'access' => array('public'),
                                        'static' => false,
                                        'abstract' => false,
                                        'returnsReference' => false,
                                        'params' => array(),
                                        'globals' => array(),
                                        'statics' => array(),
                                        'throws' => array(),
                                        'catches' => array(),
                                        'referencedFunctions' => array(),
                                        'referencedVars' => array(),
                                        'referencedMethods' => array(),
                                        'referencedClasses' => array(),
                                        'returns' => array(),
                                        'superglobals' => array(),
                                        'startline' => 3,
                                        'endline' => 3,
                                        'documentation' => '',
                                    ),
                                    'thisone' => array(
                                        'name' => 'thisone',
                                        'access' => array('public'),
                                        'static' => false,
                                        'abstract' => false,
                                        'returnsReference' => false,
                                        'params' => array(
                                            '$a' =>
                                                array(
                                                    'default' => null,
                                                    'type' => '',
                                                    'isReference' => false,
                                                ),
                                            '$another' =>
                                                array(
                                                    'default' => null,
                                                    'type' => '',
                                                    'isReference' => false,
                                                ),
                                        ),
                                        'globals' => array(),
                                        'statics' => array(),
                                        'throws' => array(),
                                        'catches' => array(),
                                        'referencedFunctions' => array(),
                                        'referencedVars' => array(),
                                        'referencedMethods' => array(),
                                        'referencedClasses' => array(),
                                        'returns' => array(),
                                        'superglobals' => array(),
                                        'startline' => 4,
                                        'endline' => 4,
                                        'documentation' => '',
                                    ),
                                    'mine' => array(
                                        'name' => 'mine',
                                        'access' => array('private'),
                                        'static' => false,
                                        'abstract' => false,
                                        'returnsReference' => false,
                                        'params' => array(
                                            '$ar' =>
                                                array(
                                                    'default' => null,
                                                    'type' => 'someclass',
                                                    'isReference' => false,
                                                ),
                                        ),
                                        'globals' => array(),
                                        'statics' => array(),
                                        'throws' => array(),
                                        'catches' => array(),
                                        'referencedFunctions' => array(),
                                        'referencedVars' => array(),
                                        'referencedMethods' => array(),
                                        'referencedClasses' => array(),
                                        'returns' => array(),
                                        'superglobals' => array(),
                                        'startline' => 5,
                                        'endline' => 5,
                                        'documentation' => '',
                                    ),
                                ),
                            'extends' =>
                                array(
                                ),
                            'startline' => 2,
                            'endline' => 6,
                            'documentation' => null,
                        )
                ),
                'includes' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_classconst1()
    {
        if (!$this->_methodExists('setParser')) {
            return;
        }
        if (!$this->_methodExists('setTokenizer')) {
            return;
        }
        if (!$this->_methodExists('setTokenizerOptions')) {
            return;
        }
        $testPHP = <<<EOF
<?php
class foochunk {
    const TEST = 1;
}
?>
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizerOptions()');
        $e = $this->parser->parseString($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'parseString');
//        echo '<pre>';
//        var_dump($e);
//      echo '</pre>';
        $this->assertEquals(
            array(
                'classes' => array(
                    'foochunk' =>
                        array(
                            'extends' => '',
                            'type' => '',
                            'methods' =>
                                array(
                                ),
                            'vars' =>
                                array(
                                ),
                            'consts' =>
                                array(
                                    'TEST' =>
                                        array(
                                            'name' => 'TEST',
                                            'value' => '1',
                                            'startline' => 3,
                                            'endline' => 3,
                                            'documentation' => ''
                                        )
                                ),
                            'implements' =>
                                array(
                                ),
                            'startline' => 2,
                            'endline' => 4,
                            'documentation' => null,
                        )
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_classconst2()
    {
        if (!$this->_methodExists('setParser')) {
            return;
        }
        if (!$this->_methodExists('setTokenizer')) {
            return;
        }
        if (!$this->_methodExists('setTokenizerOptions')) {
            return;
        }
        $testPHP = <<<EOF
<?php
class foochunk {
    const TEST = 1, ANOTHER = 'hello';
}
?>
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizerOptions()');
        $e = $this->parser->parseString($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'parseString');
//        echo '<pre>';
//        var_dump($e);
//      echo '</pre>';
        $this->assertEquals(
            array(
                'classes' => array(
                    'foochunk' =>
                        array(
                            'extends' => '',
                            'type' => '',
                            'methods' =>
                                array(
                                ),
                            'vars' =>
                                array(
                                ),
                            'consts' =>
                                array(
                                    'TEST' =>
                                        array(
                                            'name' => 'TEST',
                                            'value' => '1',
                                            'startline' => 3,
                                            'endline' => 3,
                                            'documentation' => ''
                                        ),
                                    'ANOTHER' =>
                                        array(
                                            'name' => 'ANOTHER',
                                            'value' => "'hello'",
                                            'startline' => 3,
                                            'endline' => 3,
                                            'documentation' => ''
                                        )
                                ),
                            'implements' =>
                                array(
                                ),
                            'startline' => 2,
                            'endline' => 4,
                            'documentation' => null,
                        )
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_classconst3()
    {
        if (!$this->_methodExists('setParser')) {
            return;
        }
        if (!$this->_methodExists('setTokenizer')) {
            return;
        }
        if (!$this->_methodExists('setTokenizerOptions')) {
            return;
        }
        $testPHP = <<<EOF
<?php
class foochunk {
    const TEST = 1;
    const ANOTHER = 'hello';
}
?>
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizerOptions()');
        $e = $this->parser->parseString($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'parseString');
//        echo '<pre>';
//        var_dump($e);
//      echo '</pre>';
        $this->assertEquals(
            array(
                'classes' => array(
                    'foochunk' =>
                        array(
                            'extends' => '',
                            'type' => '',
                            'methods' =>
                                array(
                                ),
                            'vars' =>
                                array(
                                ),
                            'consts' =>
                                array(
                                    'TEST' =>
                                        array(
                                            'name' => 'TEST',
                                            'value' => '1',
                                            'startline' => 3,
                                            'endline' => 3,
                                            'documentation' => ''
                                        ),
                                    'ANOTHER' =>
                                        array(
                                            'name' => 'ANOTHER',
                                            'value' => "'hello'",
                                            'startline' => 4,
                                            'endline' => 4,
                                            'documentation' => ''
                                        )
                                ),
                            'implements' =>
                                array(
                                ),
                            'startline' => 2,
                            'endline' => 5,
                            'documentation' => null,
                        )
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_abstractclass()
    {
        if (!$this->_methodExists('setParser')) {
            return;
        }
        if (!$this->_methodExists('setTokenizer')) {
            return;
        }
        if (!$this->_methodExists('setTokenizerOptions')) {
            return;
        }
        $testPHP = <<<EOF
<?php
abstract class foochunk {
}
?>
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizerOptions()');
        $e = $this->parser->parseString($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'parseString');
//        echo '<pre>';
//        var_dump($e);
//      echo '</pre>';
        $this->assertEquals(
            array(
                'classes' => array(
                    'foochunk' =>
                        array(
                            'extends' => '',
                            'type' => 'abstract',
                            'methods' =>
                                array(
                                ),
                            'vars' =>
                                array(
                                ),
                            'consts' =>
                                array(
                                ),
                            'implements' =>
                                array(
                                ),
                            'startline' => 2,
                            'endline' => 3,
                            'documentation' => null,
                        )
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_abstractclass_extends()
    {
        if (!$this->_methodExists('setParser')) {
            return;
        }
        if (!$this->_methodExists('setTokenizer')) {
            return;
        }
        if (!$this->_methodExists('setTokenizerOptions')) {
            return;
        }
        $testPHP = <<<EOF
<?php
abstract class foochunk extends burp {
}
?>
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'setTokenizerOptions()');
        $e = $this->parser->parseString($testPHP);
        $this->assertNoErrors('test_valid_simpleclass', 'parseString');
//        echo '<pre>';
//        var_dump($e);
//      echo '</pre>';
        $this->assertEquals(
            array(
                'classes' => array(
                    'foochunk' =>
                        array(
                            'extends' => 'burp',
                            'type' => 'abstract',
                            'methods' =>
                                array(
                                ),
                            'vars' =>
                                array(
                                ),
                            'consts' =>
                                array(
                                ),
                            'implements' =>
                                array(
                                ),
                            'startline' => 2,
                            'endline' => 3,
                            'documentation' => null,
                        )
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
}

?>
