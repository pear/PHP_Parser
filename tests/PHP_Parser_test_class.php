<?php

/**
 * API Unit tests for PEAR_PackageFileManager package.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org> portions from HTML_CSS
 * @author     Greg Beaver
 * @package    PEAR_PackageFileManager
 */

/**
 * @package PEAR_PackageFileManager
 */

class PHP_Parser_test_class extends PHPUnit_TestCase
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
    
    function test_invalid_empty()
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
class foochunk extends class {}
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_invalid_class', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_invalid_class', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_invalid_class', 'setTokenizerOptions()');
        $this->parser->parseString('');
        $this->assertErrors(array(array('package' => 'PHP_Parser', 'level' => 'exception',
            'message' => 'Nothing to parse in parseString')),
            'test_invalid_empty');
    }
    
    function test_invalid_class1()
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
class foochunk extends class {}
?>
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_invalid_class', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_invalid_class', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_invalid_class', 'setTokenizerOptions()');
        $this->parser->parseString($testPHP);
        $this->assertErrors(array(array('package' => 'PHP_Parser_Structure', 'level' => 'error',
            'message' => 'Error at line 2, Unexpected T_CLASS, syntax error, expecting T_STRING')),
            'test_invalid_class');
    }
    
    function test_invalid_class2()
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
class foochunk;
?>
EOF;
        $this->parser->setParser('Structure');
        $this->assertNoErrors('test_invalid_class', 'setParser(Structure)');
        $this->parser->setTokenizer('Structure');
        $this->assertNoErrors('test_invalid_class', 'setTokenizer(Structure)');
        $this->parser->setTokenizerOptions($testPHP);
        $this->assertNoErrors('test_invalid_class', 'setTokenizerOptions()');
        $this->parser->parseString($testPHP);
        $this->assertErrors(array(array('package' => 'PHP_Parser_Structure', 'level' => 'error',
            'message' => 'Error at line 2, Unexpected \';\', syntax error, expecting \'{\', T_EXTENDS, or T_IMPLEMENTS')),
            'test_invalid_class2');
    }
    
    function test_valid_simpleclass()
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
class foochunk {}
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
                        array(array(
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
                                ),
                            'startline' => 2,
                            'endline' => 2,
                            'documentation' => null,
                        ))
                ),
                'includes' => array(),
                'interfaces' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
    
    function test_valid_extends()
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
class foochunk extends clregy {}
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
                        array(array(
                            'extends' => 'clregy',
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
                                ),
                            'startline' => 2,
                            'endline' => 2,
                            'documentation' => null,
                        ))
                ),
                'includes' => array(),
                'interfaces' => array(),
                'functions' => array(),
                'constants' => array(),
                'globals' => array(),
            ), $e, 'wrong return');
    }
}
?>