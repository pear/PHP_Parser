<?php

/**
 * API Unit tests for PHP_Parser package.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org> portions from HTML_CSS
 * @author     Greg Beaver
 * @package    PEAR_PackageFileManager
 */

/**
 * @package PHP_Parser
 */

class PHP_Parser_test_functions extends PHPUnit_TestCase
{
    /**
     * A PHP_Parser object (or one of the drivers)
     * @var        object
     */
    var $parser;
    /**
     * This will be Error_Stack if the package is accepted into PEAR
     */
    var $errorStackClass = 'PEAR_ErrorStack';
    
    /**#@+
     * Error Stacks
     */
    var $pstack;
    var $sstack;
    var $estack;

    function PHP_Parser_test_functions($name)
    {
        $this->PHPUnit_TestCase($name);
    }

    function setUp()
    {
        error_reporting(E_ALL);
        $this->errorOccured = false;
        set_error_handler(array(&$this, 'errorHandler'));

        $this->parser = new PHP_Parser;
        $this->pstack = &PEAR_ErrorStack::singleton('PHP_Parser');
        $this->sstack = &PEAR_ErrorStack::singleton('PHP_Parser_Structure');
        $this->estack = &PEAR_ErrorStack::singleton('PHP_Parser_Extendable');
        $this->_expectedErrors = array();
        $this->_testMethod = 'unknown';
    }

    function tearDown()
    {
        // purge all error stacks
        PEAR_ErrorStack::staticGetErrors(true);
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
        $compare = PEAR_ErrorStack::staticGetErrors(false, true);
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
                $this->assertFalse(true, "$method Extra error: package $err[package], message '$err[message]'");
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
            $this->assertFalse(true, "$method Unthrown error: package $err[package], message '$err[message]'");
        }
    }
    
    function assertNoErrors($method, $message)
    {
        $errs = PEAR_ErrorStack::staticGetErrors(false, true);
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
        PEAR_ErrorStack::staticGetErrors(true);
    }
    
    function test_valid_functions1()
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
function test(){}
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
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(),
                        'globals' => array(),
                        'statics' => array(),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array(),
                        'returns' => array(),
                        'superglobals' => array(),
                        'startline' => 2,
                        'endline' => 2,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_functions_params1()
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
function test(\$a){}
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
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            '$a' =>
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
                        'referencedClasses' => array(),
                        'returns' => array(),
                        'superglobals' => array(),
                        'startline' => 2,
                        'endline' => 2,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_functions_params2()
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
function test(\$a = 'hello'){}
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
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            '$a' =>
                                array(
                                    'default' => "'hello'",
                                    'type' => '',
                                    'isReference' => false,
                                ),
                            ),
                        'globals' => array(),
                        'statics' => array(),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array(),
                        'returns' => array(),
                        'superglobals' => array(),
                        'startline' => 2,
                        'endline' => 2,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_functions_params3()
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
function test(\$first, \$a = 'hello'){}
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
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            '$first' =>
                                array(
                                    'default' => null,
                                    'type' => '',
                                    'isReference' => false,
                                ),
                            '$a' =>
                                array(
                                    'default' => "'hello'",
                                    'type' => '',
                                    'isReference' => false,
                                ),
                            ),
                        'globals' => array(),
                        'statics' => array(),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array(),
                        'returns' => array(),
                        'superglobals' => array(),
                        'startline' => 2,
                        'endline' => 2,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_functions_params4()
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
function test(&\$first, \$second, \$a = 'hello'){}
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
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            '$first' =>
                                array(
                                    'default' => null,
                                    'type' => '',
                                    'isReference' => true,
                                ),
                            '$second' =>
                                array(
                                    'default' => null,
                                    'type' => '',
                                    'isReference' => false,
                                ),
                            '$a' =>
                                array(
                                    'default' => "'hello'",
                                    'type' => '',
                                    'isReference' => false,
                                ),
                            ),
                        'globals' => array(),
                        'statics' => array(),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array(),
                        'returns' => array(),
                        'superglobals' => array(),
                        'startline' => 2,
                        'endline' => 2,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_returnsref()
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
function &test(){}
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
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => true,
                        'params' => array(
                            ),
                        'globals' => array(),
                        'statics' => array(),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array(),
                        'returns' => array(),
                        'superglobals' => array(),
                        'startline' => 2,
                        'endline' => 2,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_globalvars()
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
function test()
{
    global \$test, \${'hello' . "\$a"};
    global \$another;
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
        $this->assertEquals(
            array(
                'classes' => array(
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            ),
                        'globals' => array(
                            '$test',
                            '${\'hello\' . "$a"}',
                            '$another'
                        ),
                        'statics' => array(),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array(),
                        'returns' => array(),
                        'superglobals' => array(),
                        'startline' => 2,
                        'endline' => 6,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_staticvars()
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
function test()
{
    static \$test, \$hello = 6;
    static \$another;
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
        $this->assertEquals(
            array(
                'classes' => array(
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            ),
                        'globals' => array(
                        ),
                        'statics' => array(
                            array(
                                'name' => '$test',
                                'default' => null,
                                ),
                            array(
                                'name' => '$hello',
                                'default' => '6',
                                ),
                            array(
                                'name' => '$another',
                                'default' => null,
                                ),
                            ),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array(),
                        'returns' => array(),
                        'superglobals' => array(),
                        'startline' => 2,
                        'endline' => 6,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_referencedClasses()
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
function test()
{
    \$a = new \$foo;
    \$a = new Test;
    \$a = new Test('something');
    \$a = &new Other;
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
        $this->assertEquals(
            array(
                'classes' => array(
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            ),
                        'globals' => array(
                        ),
                        'statics' => array(
                            ),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array('Test', 'Other'),
                        'returns' => array(),
                        'superglobals' => array(),
                        'startline' => 2,
                        'endline' => 8,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_return()
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
function test()
{
    if (0) { return 'test'; }
    return 25 + \$a + count(array(5, 3));
    return new Gronk;
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
        $this->assertEquals(
            array(
                'classes' => array(
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            ),
                        'globals' => array(
                        ),
                        'statics' => array(
                            ),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array('count'),
                        'referencedClasses' => array('Gronk'),
                        'returns' => array(
                            "'test'",
                            '25 + $a + count(array(5, 3))',
                            'new Gronk',
                            ),
                        'superglobals' => array(),
                        'startline' => 2,
                        'endline' => 7,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_global()
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
function test()
{
    global \$a;
    global \${\$a . '_second'}, \$b;
    \$see = \$_SERVER['SERVER_NAME'];
    \$me = \$GLOBALS['hello'];
    \$thee = \$_GET['hi'];
    \$thee = \$_POST['hi'];
    \$thee = \$_REQUEST['hi'];
    \$thee = \$_REQUEST['hi'] . \$_ENV['blah'];
    \$thee = \$_COOKIE['hi'] . \$_FILES['blah'] . \$_SESSION['first'];
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
        $this->assertEquals(
            array(
                'classes' => array(
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            ),
                        'globals' => array(
                           '$a',
                           '${$a . \'_second\'}',
                           '$b',
                        ),
                        'statics' => array(
                            ),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array(),
                        'returns' => array(
                            ),
                        'superglobals' => array(
                            array('array' => '$_SERVER', 'var' => "'SERVER_NAME'"),
                            array('array' => '$GLOBALS', 'var' => "'hello'"),
                            array('array' => '$_GET', 'var' => "'hi'"),
                            array('array' => '$_POST', 'var' => "'hi'"),
                            array('array' => '$_REQUEST', 'var' => "'hi'"),
                            array('array' => '$_REQUEST', 'var' => "'hi'"),
                            array('array' => '$_ENV', 'var' => "'blah'"),
                            array('array' => '$_COOKIE', 'var' => "'hi'"),
                            array('array' => '$_FILES', 'var' => "'blah'"),
                            array('array' => '$_SESSION', 'var' => "'first'"),
                        ),
                        'startline' => 2,
                        'endline' => 13,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }

    function test_valid_return_expressions1()
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
function test()
{
    return \$a= list(  \$test , \$another) =  each( \$a);
    return \$a =  & \$b;
    return \$a =  new foo (\$b , 'hello' );
    return \$a = &  new foo (\$b , 'hello' );
    return \$a  +=6;
    return \$a  -= 6;
    return \$a  *=  6;
    return \$a  /=  6;
    return \$a  .=  6;
    return \$a  %=  6;
    return \$a  &=  6;
    return \$a  |=  6;
    return \$a  ^=  6;
    return \$a  <<=  6;
    return \$a  >>=  6;
}
?>
EOF;
        $count = count(explode('
', $testPHP)) - 1;
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
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            ),
                        'globals' => array(
                        ),
                        'statics' => array(
                            ),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array('each'),
                        'referencedClasses' => array('foo'),
                        'returns' => array(
                            '$a= list(  $test , $another) =  each( $a)',
                            '$a =  & $b',
                            '$a =  new foo ($b , \'hello\' )',
                            '$a = &  new foo ($b , \'hello\' )',
                            '$a  +=6',
                            '$a  -= 6',
                            '$a  *=  6',
                            '$a  /=  6',
                            '$a  .=  6',
                            '$a  %=  6',
                            '$a  &=  6',
                            '$a  |=  6',
                            '$a  ^=  6',
                            '$a  <<=  6',
                            '$a  >>=  6',
                            ),
                        'superglobals' => array(
                        ),
                        'startline' => 2,
                        'endline' => $count,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_return_expressions2()
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
function test()
{
    return \$a  ++;
    return 1 +  ++\$a;
    return \$a  --;
    return 1 -  --\$a;
    return \$a  ||  true;
    return \$a  &&  true;
    return \$a  or  true;
    return \$a  and  true;
    return \$a  xor  true;
    return \$a  |  true;
    return \$a  &  true;
    return \$a  ^  true;
    return \$a  .  true;
    return \$a  +  true;
    return \$a  -  true;
    return \$a  *  true;
    return \$a  /  true;
    return \$a  %  true;
    return \$a  <<  true;
    return \$a  >>  true;
}
?>
EOF;
        $count = count(explode('
', $testPHP)) - 1;
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
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            ),
                        'globals' => array(
                        ),
                        'statics' => array(
                            ),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array(),
                        'returns' => array(
                            '$a  ++',
                            '1 +  ++$a',
                            '$a  --',
                            '1 -  --$a',
                            '$a  ||  true',
                            '$a  &&  true',
                            '$a  or  true',
                            '$a  and  true',
                            '$a  xor  true',
                            '$a  |  true',
                            '$a  &  true',
                            '$a  ^  true',
                            '$a  .  true',
                            '$a  +  true',
                            '$a  -  true',
                            '$a  *  true',
                            '$a  /  true',
                            '$a  %  true',
                            '$a  <<  true',
                            '$a  >>  true',
                            ),
                        'superglobals' => array(
                        ),
                        'startline' => 2,
                        'endline' => $count,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_return_expressions3()
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
function test()
{
    return \$a =    + 1;
    return \$a =    - 1;
    return \$a =    ! 1;
    return \$a =    ~ 1;
    return \$a  ===  6;
    return \$a  !==  6;
    return \$a  ==  6;
    return \$a  <  6;
    return \$a  >  6;
    return \$a  >=  6;
    return \$a  <=  6;
    return \$a = ( \$b + \$c   );
    return \$a  = 25  ? \$b : "hello";
    return isset ( \$b  , \$a);
    return empty ( \$a  );
    return eval ( "\\\$a + 6" );
}
?>
EOF;
        $count = count(explode('
', $testPHP)) - 1;
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
                ),
                'interfaces' => array(),
                'includes' => array(),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            ),
                        'globals' => array(
                        ),
                        'statics' => array(
                            ),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array(),
                        'returns' => array(
                            '$a =    + 1',
                            '$a =    - 1',
                            '$a =    ! 1',
                            '$a =    ~ 1',
                            '$a  ===  6',
                            '$a  !==  6',
                            '$a  ==  6',
                            '$a  <  6',
                            '$a  >  6',
                            '$a  >=  6',
                            '$a  <=  6',
                            '$a = ( $b + $c   )',
                            '$a  = 25  ? $b : "hello"',
                            'isset ( $b  , $a)',
                            'empty ( $a  )',
                            'eval ( "\$a + 6" )',
                            ),
                        'superglobals' => array(
                        ),
                        'startline' => 2,
                        'endline' => $count,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
        
    function test_valid_return_expressions4()
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
function test()
{
    return include  "hi";
    return include_once  "hi";
    return require  "hi";
    return require_once  "hi";
    return \$a =   (int) 6;
    return \$a =   (double) 6;
    return \$a =   (string) 6;
    return \$a =   (array) 6;
    return \$a =   (object) 6;
    return \$a =   (bool) 6;
    return \$a =   (unset) 6;
    return \$a =   exit ( "bye" );
    return \$a = @ "hello";
    return \$a = `  test `;
    return \$a =   print  "blah";
    return "test";
    return 'test';
    return 6;
    return 6.346;
    return <<<EOF1
hi
EOF1;
    return 6 +  __CLASS__  + __FILE__   + __LINE__;
    return " \$somevar  and then    some space";
}
?>
EOF;
        $count = count(explode('
', $testPHP)) - 2;
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
                ),
                'interfaces' => array(),
                'includes' => array(
                    array('file' => '"hi"', 'type' => 'include', 'startline' => 4, 'endline' => 4, 'documentation' => ''),
                    array('file' => '"hi"', 'type' => 'include_once', 'startline' => 5, 'endline' => 5, 'documentation' => ''),
                    array('file' => '"hi"', 'type' => 'require', 'startline' => 6, 'endline' => 6, 'documentation' => ''),
                    array('file' => '"hi"', 'type' => 'require_once', 'startline' => 7, 'endline' => 7, 'documentation' => ''),
                    ),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            ),
                        'globals' => array(
                        ),
                        'statics' => array(
                            ),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array(),
                        'returns' => array(
                            'include  "hi"',
                            'include_once  "hi"',
                            'require  "hi"',
                            'require_once  "hi"',
                            '$a =   (int) 6',
                            '$a =   (double) 6',
                            '$a =   (string) 6',
                            '$a =   (array) 6',
                            '$a =   (object) 6',
                            '$a =   (bool) 6',
                            '$a =   (unset) 6',
                            '$a =   exit ( "bye" )',
                            '$a = @ "hello"',
                            '$a = `  test `',
                            '$a =   print  "blah"',
                            '"test"',
                            "'test'",
                            '6',
                            '6.346',
                            '<<<EOF1
hi
EOF1',
                            '6 +  __CLASS__  + __FILE__   + __LINE__',
                            '" $somevar  and then    some space"',
                            ),
                        'superglobals' => array(
                        ),
                        'startline' => 2,
                        'endline' => $count,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
        
    function test_valid_return_expressions5()
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
function test()
{
    return \$a = array();
    return \$a = array (  & \$q  );
    return \$a = array (  6  => & \$q  );
    return \$a = array (  6 , & \$q  );
    return \$a = array (  6 , 6  => & \$q  );
    return \$a = array ( 6 =>  6 );
    return \$a = array ( 6 =>  6 , 6 );
    return \$a = array ( 6  , 6 =>  6 );
    return \$a = array (  6  => & \$q  );
}
?>
EOF;
        $count = count(explode('
', $testPHP)) - 1;
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
                ),
                'interfaces' => array(),
                'includes' => array(
                    ),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            ),
                        'globals' => array(
                        ),
                        'statics' => array(
                            ),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array(),
                        'returns' => array(
                            '$a = array()',
                            '$a = array (  & $q  )',
                            '$a = array (  6  => & $q  )',
                            '$a = array (  6 , & $q  )',
                            '$a = array (  6 , 6  => & $q  )',
                            '$a = array ( 6 =>  6 )',
                            '$a = array ( 6 =>  6 , 6 )',
                            '$a = array ( 6  , 6 =>  6 )',
                            '$a = array (  6  => & $q  )',
                            ),
                        'superglobals' => array(
                        ),
                        'startline' => 2,
                        'endline' => $count,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
        
    function test_valid_return_functioncall()
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
function test()
{
    return 6 +  foo( );
    return 6 +  foo( 6 );
    return 6 +  bar(   \$h);
    return 6 +  bar( &  \$h);
    return 6 +  bar( &  \$h ,  6);
    return 6 +  bar( &  \$h ,  \$r);
    return 6 +  bar( &  \$h ,  & \$r);
    return 6 +  \$bar( \$h );
}
?>
EOF;
        $count = count(explode('
', $testPHP)) - 1;
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
                ),
                'interfaces' => array(),
                'includes' => array(
                    ),
                'functions' => array(
                    'test' => array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            ),
                        'globals' => array(
                        ),
                        'statics' => array(
                            ),
                        'throws' => array(),
                        'catches' => array(),
                        'referencedFunctions' => array('foo', 'bar'),
                        'referencedClasses' => array(),
                        'returns' => array(
                            '6 +  foo( )',
                            '6 +  foo( 6 )',
                            '6 +  bar(   $h)',
                            '6 +  bar( &  $h)',
                            '6 +  bar( &  $h ,  6)',
                            '6 +  bar( &  $h ,  $r)',
                            '6 +  bar( &  $h ,  & $r)',
                            '6 +  $bar( $h )',
                            ),
                        'superglobals' => array(
                        ),
                        'startline' => 2,
                        'endline' => $count,
                        'documentation' => null,
                    ))
                ),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
}
?>