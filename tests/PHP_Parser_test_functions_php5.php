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

class PHP_Parser_test_functions_php5 extends PHPUnit_TestCase
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

    function PHP_Parser_test_functions_php5($name)
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
function test(someclass \$a){}
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
        $count = count(explode('
', $testPHP)) - 1;
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
                            '$a' =>
                                array(
                                    'default' => null,
                                    'type' => 'someclass',
                                    'isReference' => false,
                                ),
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
function test(&\$a = null){}
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
        $count = count(explode('
', $testPHP)) - 1;
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
                            '$a' =>
                                array(
                                    'default' => 'null',
                                    'type' => '',
                                    'isReference' => true,
                                ),
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

    function test_valid_function_throw()
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
    throw \$a;
    throw new Exception('hi');
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
        $count = count(explode('
', $testPHP)) - 1;
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
                        'throws' => array(
                            '$a',
                            'Exception',
                            ),
                        'catches' => array(),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array('Exception'),
                        'returns' => array(
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

    function test_valid_function_catch1()
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
    try {
    } catch (Exception \$e) {
    }
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
        $count = count(explode('
', $testPHP)) - 1;
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
                        'throws' => array(
                            ),
                        'catches' => array('Exception'),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array('Exception'),
                        'returns' => array(
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

    function test_valid_function_catch2()
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
    try {
    } catch (Exception \$e) {
    } catch (SomeException \$e) {
    } catch (SomeOtherException \$e) {
    }
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
        $count = count(explode('
', $testPHP)) - 1;
        $this->assertEquals(
            array(
                'classes' => array(
                ),
                'interfaces' => array(),
                'includes' => array(
                    ),
                'functions' => array(
                    'test' =>  array(array(
                        'name' => 'test',
                        'returnsReference' => false,
                        'params' => array(
                            ),
                        'globals' => array(
                        ),
                        'statics' => array(
                            ),
                        'throws' => array(
                            ),
                        'catches' => array('SomeException', 'SomeOtherException', 'Exception'),
                        'referencedFunctions' => array(),
                        'referencedClasses' => array('Exception', 'SomeException', 'SomeOtherException'),
                        'returns' => array(
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
    return clone \$mystupid;
    return \$a   instanceof foo;
    return grob   ::  constantname;
    return marky ::  \$method ( \$h );
    //return 6  + __METHOD__  + __FUNCTION__;
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
        $count = count(explode('
', $testPHP)) - 1;
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
                        'throws' => array(
                            ),
                        'catches' => array(),
                        'referencedFunctions' => array('count'),
                        'referencedClasses' => array('foo', 'grob', 'marky'),
                        'returns' => array(
                            "'test'",
                            '25 + $a + count(array(5, 3))',
                            'clone $mystupid',
                            '$a   instanceof foo',
                            'grob   ::  constantname',
                            'marky ::  $method ( $h )',
//                            '6  + __METHOD__  + __FUNCTION__',
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