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

class PHP_Parser_DocBlock_DefaultInlineTagLexer_test extends PHPUnit_TestCase
{
    /**
     * A PHP_Parser_DocBlock_DefaultInlineTagLexer object (or one of the drivers)
     * @var        object
     */
    var $lexer;
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

    function PHP_Parser_DocBlock_DefaultInlineTagLexer_test($name)
    {
        $this->PHPUnit_TestCase($name);
    }

    function setUp()
    {
        error_reporting(E_ALL);
        $this->errorOccured = false;
        set_error_handler(array(&$this, 'errorHandler'));

        $this->lexer = new PHP_Parser_DocBlock_DefaultInlineTagLexer;
        $this->_expectedErrors = array();
        $this->_testMethod = 'unknown';
    }

    function tearDown()
    {
        unset($this->lexer);
        restore_error_handler();
    }

    function errorCodeToString($code)
    {
        $codes = array(
           'PHP_Parser_DocBlock_DefaultInlineTagLexer' =>
            array(
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
        if (in_array($test, get_class_methods($this->lexer))) {
            return true;
        }
        $this->assertTrue(false, 'method '. $name . ' not implemented in ' . get_class($this->lexer));
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
    
    function test_setOptions1()
    {
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        $this->assertEquals(array('separator' => false), $this->lexer->_options);
        $this->lexer->setOptions();
        $this->assertEquals(array('separator' => false), $this->lexer->_options);
    }

    function test_setOptions2()
    {
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        $this->assertEquals(array('separator' => false), $this->lexer->_options);
        $this->lexer->setOptions(array('separator' => ','));
        $this->assertEquals(array('separator' => ','), $this->lexer->_options);
        $this->lexer->setOptions();
        $this->assertEquals(array('separator' => false), $this->lexer->_options);
    }

    function test_newTag_empty()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        $this->lexer->newTag('');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array(), array(), array()), $this->lexer->_buf);
    }

    function test_newTag_oneword()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        $this->lexer->newTag('test');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array('test'), array('test'), array('')), $this->lexer->_buf, 1);
        $this->lexer->newTag('test   ');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array('test   '), array('test'), array('   ')), $this->lexer->_buf, 2);
        $this->lexer->newTag('   test');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array('test'), array('test'), array('')), $this->lexer->_buf, 3);
    }

    function test_newTag_twowords()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        $this->lexer->newTag('test two');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array('test ','two'), array('test','two'), array(' ','')), $this->lexer->_buf, 1);
        $this->lexer->newTag('test   two');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array('test   ','two'), array('test','two'), array('   ','')), $this->lexer->_buf, 2);
    }

    function test_newTag_oneword_multibuffers()
    {
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        if (!$this->_methodExists('newTag')) {
            return;
        }
        $this->lexer->setOptions(array('separator' => ','));
        $this->lexer->newTag('test');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array(array('test'), array('test'), array(''))), $this->lexer->_buf, 1);
        $this->lexer->newTag('test   ');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array(array('test   '), array('test'), array('   '))), $this->lexer->_buf, 2);
        $this->lexer->newTag('   test');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array(array('test'), array('test'), array(''))), $this->lexer->_buf, 3);
    }

    function test_newTag_twowords_multibuffers()
    {
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        if (!$this->_methodExists('newTag')) {
            return;
        }
        $this->lexer->setOptions(array('separator' => ','));
        $this->lexer->newTag('test two');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array(array('test ','two'), array('test','two'), array(' ',''))), $this->lexer->_buf, 1);
        $this->lexer->newTag('test   two');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array(array('test   ','two'), array('test','two'), array('   ',''))), $this->lexer->_buf, 2);
    }

    function test_newTag_twowords_separator()
    {
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        if (!$this->_methodExists('newTag')) {
            return;
        }
        $this->lexer->setOptions(array('separator' => ','));
        $this->lexer->newTag('test,two');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array(array('test'), array('test'), array('')),
                                  array(array('two'), array('two'), array(''))), $this->lexer->_buf, 1);
        $this->lexer->newTag('test ,  two');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array(array('test '), array('test'), array(' ')),
                                  array(array('two'), array('two'), array(''))), $this->lexer->_buf, 2);
        $this->lexer->newTag('test,   two');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array(array('test'), array('test'), array('')),
                                  array(array('two'), array('two'), array(''))), $this->lexer->_buf, 3);
        $this->lexer->newTag('test   ,two ');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array(array('test   '), array('test'), array('   ')),
                                  array(array('two '), array('two'), array(' '))), $this->lexer->_buf, 4);
    }

    function test_newTag_escapeseparator_multibuffers()
    {
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        if (!$this->_methodExists('newTag')) {
            return;
        }
        $this->lexer->setOptions(array('separator' => ','));
        $this->lexer->newTag('test\\,');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array(array('test,'), array('test,'), array(''))), $this->lexer->_buf, 1);
        $this->lexer->newTag('test\\, hi');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array(array('test, ','hi'), array('test,','hi'), array(' ',''))), $this->lexer->_buf, 2);
        $this->lexer->newTag('test\\, hi,there ');
        $this->assertEquals(0, $this->lexer->_index);
        $this->assertEquals(array(array(array('test, ','hi'), array('test,','hi'), array(' ','')),
                                  array(array('there '), array('there'), array(' '))), $this->lexer->_buf, 3);
    }

    function test_getBuf()
    {
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('_getBuf')) {
            return;
        }
        $this->lexer->newTag('test');
        $buf = $this->lexer->_getBuf();
        $this->assertEquals(array(array('test'), array('test'), array('')), $buf, 1);

        $this->lexer->setOptions(array('separator' => ','));
        $this->lexer->newTag('test,two');
        $buf = $this->lexer->_getBuf();
        $this->assertEquals(array(array('test'), array('test'), array('')), $buf, 2);
        $this->lexer->_bufIndex++;
        $buf = $this->lexer->_getBuf();
        $this->assertEquals(array(array('two'), array('two'), array('')), $buf, 3);
    }

    function test_moveNextBuf()
    {
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('_getBuf')) {
            return;
        }
        if (!$this->_methodExists('moveNextBuf')) {
            return;
        }
        $this->lexer->newTag('test');
        $buf = $this->lexer->_getBuf();
        $this->assertEquals(array(array('test'), array('test'), array('')), $buf, 1);
        $this->assertFalse($this->lexer->moveNextBuf(), 'moveNextBuf 1');
        $buf = $this->lexer->_getBuf();
        $this->assertEquals(array(array('test'), array('test'), array('')), $buf, 1);

        $this->lexer->setOptions(array('separator' => ','));
        $this->lexer->newTag('test,two');
        $buf = $this->lexer->_getBuf();
        $this->assertEquals(array(array('test'), array('test'), array('')), $buf, 2);
        $this->assertEquals(array(array('two'), array('two'), array('')), $this->lexer->moveNextBuf(), 'moveNextBuf 2');
        $buf = $this->lexer->_getBuf();
        $this->assertEquals(array(array('two'), array('two'), array('')), $buf, 3);
        $this->assertFalse($this->lexer->moveNextBuf(), 'moveNextBuf false');
        $this->assertFalse($this->lexer->_getBuf(), '_getBuf false');
    }

    function test_hasNextBuf()
    {
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('_getBuf')) {
            return;
        }
        if (!$this->_methodExists('moveNextBuf')) {
            return;
        }
        if (!$this->_methodExists('hasNextBuf')) {
            return;
        }
        $this->lexer->newTag('test');
        $buf = $this->lexer->_getBuf();
        $this->assertEquals(array(array('test'), array('test'), array('')), $buf, 1);
        $this->assertFalse($this->lexer->moveNextBuf(), 'moveNextBuf 1');
        $this->assertFalse($this->lexer->hasNextBuf(), 'hasNextBuf 1');
        $buf = $this->lexer->_getBuf();
        $this->assertEquals(array(array('test'), array('test'), array('')), $buf, 1);

        $this->lexer->setOptions(array('separator' => ','));
        $this->lexer->newTag('test,two');
        $this->assertTrue($this->lexer->hasNextBuf(), 'hasNextBuf 2');
        $buf = $this->lexer->_getBuf();
        $this->assertEquals(array(array('test'), array('test'), array('')), $buf, 2);
        $this->assertEquals(array(array('two'), array('two'), array('')), $this->lexer->moveNextBuf(), 'moveNextBuf 2');
        $this->assertFalse($this->lexer->hasNextBuf(), 'hasNextBuf 3');
        $buf = $this->lexer->_getBuf();
        $this->assertEquals(array(array('two'), array('two'), array('')), $buf, 3);
    }

    function test_readBuf_empty()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('_readBuf')) {
            return;
        }
        $this->lexer->newTag('');
        $this->assertTrue($this->lexer->_readBuf() === false, 1);
        $this->assertTrue($this->lexer->_readBuf(false, true) === false, 2);
        $this->assertTrue($this->lexer->_readBuf(true) === false, 3);
        $this->assertTrue($this->lexer->_readBuf(true, true) === false, 4);
    }

    function test_readBuf_singleBuffer()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('_readBuf')) {
            return;
        }
        $this->lexer->newTag('test   me ');
        $this->assertEquals('test', $this->lexer->_readBuf(false), 1);
        $this->assertEquals('test', $this->lexer->_readBuf(false), 2);
        $this->assertEquals('test   ', $this->lexer->_readBuf(false, true), 3);
        $this->assertEquals('test', $this->lexer->_readBuf(true), 4);
        $this->assertEquals('me', $this->lexer->_readBuf(false), 5);
        $this->assertEquals('me ', $this->lexer->_readBuf(true, true), 6);
        $this->assertTrue($this->lexer->_readBuf(true, true) === false, 7);
    }

    function test_readBuf_multiBuffer()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('_readBuf')) {
            return;
        }
        if (!$this->_methodExists('moveNextBuf')) {
            return;
        }
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        $this->lexer->setOptions(array('separator' => '#'));
        $this->lexer->newTag('test   me # hi ');
        $this->assertEquals('test', $this->lexer->_readBuf(false), 1);
        $this->assertEquals('test', $this->lexer->_readBuf(false), 2);
        $this->assertEquals('test   ', $this->lexer->_readBuf(false, true), 3);
        $this->assertEquals('test', $this->lexer->_readBuf(true), 4);
        $this->assertEquals('me', $this->lexer->_readBuf(false), 5);
        $this->assertEquals('me ', $this->lexer->_readBuf(true, true), 6);
        $this->assertTrue($this->lexer->_readBuf(true, true) === false, 7);
        $this->assertEquals(array(array('hi '), array('hi'), array(' ')), $this->lexer->moveNextBuf(), 'move');
        $this->assertEquals('hi', $this->lexer->_readBuf(false), 8);
        $this->assertEquals('hi ', $this->lexer->_readBuf(false, true), 9);
        $this->assertEquals('hi ', $this->lexer->_readBuf(true, true), 10);
        $this->assertTrue($this->lexer->_readBuf(true, true) === false, 11);
    }

    function test_getWord_empty()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getWord')) {
            return;
        }
        $this->lexer->newTag('');
        $this->assertTrue($this->lexer->getWord() === false, 1);
        $this->assertTrue($this->lexer->getWord() === false, 2);
    }

    function test_getWord_singleBuffer()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getWord')) {
            return;
        }
        $this->lexer->newTag('test   me ');
        $this->assertEquals('test', $this->lexer->getWord(), 1);
        $this->assertEquals('me', $this->lexer->getWord(), 2);
        $this->assertTrue($this->lexer->getWord() === false, 3);
    }

    function test_getWord_multiBuffer()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getWord')) {
            return;
        }
        if (!$this->_methodExists('moveNextBuf')) {
            return;
        }
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        $this->lexer->setOptions(array('separator' => '#'));
        $this->lexer->newTag('test   me # hi ');
        $this->assertEquals('test', $this->lexer->getWord(), 1);
        $this->assertEquals('me', $this->lexer->getWord(), 2);
        $this->assertTrue($this->lexer->getWord() === false, 3);
        $this->assertEquals(array(array('hi '), array('hi'), array(' ')), $this->lexer->moveNextBuf(), 'move');
        $this->assertEquals('hi', $this->lexer->getWord(), 4);
        $this->assertTrue($this->lexer->getWord() === false, 5);
    }

    function test_getAllWords_singleBuffer()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getAllWords')) {
            return;
        }
        $this->lexer->newTag('test   me baby');
        $this->assertEquals('test me baby', $this->lexer->getAllWords(), 1);
        $this->assertFalse($this->lexer->getAllWords(), 2);
    }

    function test_getAllWords_multiBuffer()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getAllWords')) {
            return;
        }
        if (!$this->_methodExists('moveNextBuf')) {
            return;
        }
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        $this->lexer->setOptions(array('separator' => '#'));
        $this->lexer->newTag('test   me baby# hi there sweetness  ');
        $this->assertEquals('test me baby', $this->lexer->getAllWords(), 1);
        $this->assertFalse($this->lexer->getAllWords(), 1.1);
        $this->assertEquals(array(array('hi ','there ', 'sweetness  '), array('hi','there','sweetness'), array(' ',' ','  ')),
            $this->lexer->moveNextBuf(), 'move');
        $this->assertEquals('hi there sweetness', $this->lexer->getAllWords(), 2);
        $this->assertFalse($this->lexer->getAllWords(), 2.1);
    }

    function test_getWords_singleBuffer()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getWords')) {
            return;
        }
        $this->lexer->newTag('test   me baby ');
        $this->assertEquals('test   me', $this->lexer->getWords(array('count' => 2)), 1);
        $this->assertEquals('baby', $this->lexer->getWords(array('count' => 2)), 2);
        $this->assertFalse($this->lexer->getWords(array('count' => 2)), 3);
        $this->lexer->newTag('test   me baby');
        $this->assertEquals('test   me baby', $this->lexer->getWords(array('count' => 4)), 4);
        $this->assertFalse($this->lexer->getWords(array('count' => 2)), 5);
        $this->lexer->newTag('test   me baby');
        $this->assertEquals('test', $this->lexer->getWords(array('count' => 1)), 6);
        $this->assertEquals('me', $this->lexer->getWords(array('count' => 1)), 7);
        $this->assertEquals('baby', $this->lexer->getWords(array('count' => 1)), 8);
        $this->assertFalse($this->lexer->getWords(array('count' => 2)), 9);
    }

    function test_getWords_multiBuffer()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getWords')) {
            return;
        }
        if (!$this->_methodExists('moveNextBuf')) {
            return;
        }
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        $this->lexer->setOptions(array('separator' => '#'));
        $this->lexer->newTag('test   me baby# hi there sweetness  ');
        $this->assertEquals('test   me', $this->lexer->getWords(array('count' => 2)), 1);
        $this->assertEquals('baby', $this->lexer->getWords(array('count' => 2)), 2);
        $this->assertFalse($this->lexer->getWords(array('count' => 2)), 3);
        $this->assertEquals(array(array('hi ','there ', 'sweetness  '), array('hi','there','sweetness'), array(' ',' ','  ')),
            $this->lexer->moveNextBuf(), 'move');
        $this->assertEquals('hi there', $this->lexer->getWords(array('count' => 2)), 1);
        $this->assertEquals('sweetness', $this->lexer->getWords(array('count' => 2)), 2);
        $this->assertFalse($this->lexer->getWords(array('count' => 2)), 3);
    }

    function test_getLink_empty()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getLink')) {
            return;
        }
        $this->lexer->newTag('');
        $this->assertTrue($this->lexer->getLink() === false, 1);
        $this->assertTrue($this->lexer->getLink() === false, 2);
    }

    function test_getLink_unknown()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getLink')) {
            return;
        }
        $this->lexer->newTag('test');
        $this->assertEquals(
            array(
                'text' => 'test',
                'link' => 'test',
                'valid' => true,
                'type' => 'unknown',
            ),
            $this->lexer->getLink(), 1);
        $this->assertFalse($this->lexer->getLink(), 2);
    }

    function test_getLink_url()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getLink')) {
            return;
        }
        $this->lexer->newTag('mailto:test@example.com');
        $this->assertEquals(
            array(
                'text' => 'mailto:test@example.com',
                'link' => 'mailto:test@example.com',
                'valid' => true,
                'type' => 'url',
            ),
            $this->lexer->getLink(), 1);
        $this->lexer->newTag('http://www.example.com');
        $this->assertEquals(
            array(
                'text' => 'http://www.example.com',
                'link' => 'http://www.example.com',
                'valid' => true,
                'type' => 'url',
            ),
            $this->lexer->getLink(), 2);
        // very treeky :)
        $this->lexer->newTag('mailto::sender()');
        $this->assertEquals(
            array(
                'text' => 'mailto::sender()',
                'link' => 'sender',
                'valid' => true,
                'type' => 'method',
                'class' => 'mailto',
            ),
            $this->lexer->getLink(), 3);
    }

    function test_invalid_getLink()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getLink')) {
            return;
        }
        $this->lexer->newTag('object test()');
        $this->assertEquals(
            array(
                'text' => 'object test()',
                'link' => false,
                'valid' => false,
                'type' => 'object',
            ),
            $this->lexer->getLink(), 1);
        $this->lexer->newTag('global test()');
        $this->assertEquals(
            array(
                'text' => 'global test()',
                'link' => false,
                'valid' => false,
                'type' => 'global',
            ),
            $this->lexer->getLink(), 2);
        $this->lexer->newTag('constant test()');
        $this->assertEquals(
            array(
                'text' => 'constant test()',
                'link' => false,
                'valid' => false,
                'type' => 'constant',
            ),
            $this->lexer->getLink(), 3);
        $this->lexer->newTag('constant $test');
        $this->assertEquals(
            array(
                'text' => 'constant $test',
                'link' => false,
                'valid' => false,
                'type' => 'constant',
            ),
            $this->lexer->getLink(), 4);
        $this->lexer->newTag('object $test');
        $this->assertEquals(
            array(
                'text' => 'object $test',
                'link' => false,
                'valid' => false,
                'type' => 'object',
            ),
            $this->lexer->getLink(), 5);
        $this->lexer->newTag('function $test');
        $this->assertEquals(
            array(
                'text' => 'function $test',
                'link' => false,
                'valid' => false,
                'type' => 'function',
            ),
            $this->lexer->getLink(), 6);
    }

    function test_invalid_getLink2()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getLink')) {
            return;
        }
        $this->lexer->newTag('object');
        $this->assertEquals(
            array(
                'text' => 'object',
                'link' => false,
                'valid' => false,
                'type' => 'object',
            ),
            $this->lexer->getLink(), 1);
        $this->lexer->newTag('global');
        $this->assertEquals(
            array(
                'text' => 'global',
                'link' => false,
                'valid' => false,
                'type' => 'global',
            ),
            $this->lexer->getLink(), 2);
        $this->lexer->newTag('constant');
        $this->assertEquals(
            array(
                'text' => 'constant',
                'link' => false,
                'valid' => false,
                'type' => 'constant',
            ),
            $this->lexer->getLink(), 3);
        $this->lexer->newTag('function');
        $this->assertEquals(
            array(
                'text' => 'function',
                'link' => false,
                'valid' => false,
                'type' => 'function',
            ),
            $this->lexer->getLink(), 4);
        $this->lexer->newTag('global some::$var');
        $this->assertEquals(
            array(
                'text' => 'global some::$var',
                'link' => false,
                'valid' => false,
                'type' => 'global',
            ),
            $this->lexer->getLink(), 4);
    }

    function test_getLink_disambiguate()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getLink')) {
            return;
        }
        $this->lexer->newTag('function test');
        $this->assertEquals(
            array(
                'text' => 'function test',
                'link' => 'test',
                'valid' => true,
                'type' => 'function',
            ),
            $this->lexer->getLink(), 1);
        $this->lexer->newTag('object test');
        $this->assertEquals(
            array(
                'text' => 'object test',
                'link' => 'test',
                'valid' => true,
                'type' => 'object',
            ),
            $this->lexer->getLink(), 1);
        $this->lexer->newTag('global $test');
        $this->assertEquals(
            array(
                'text' => 'global $test',
                'link' => '$test',
                'valid' => true,
                'type' => 'global',
            ),
            $this->lexer->getLink(), 1);
        $this->lexer->newTag('constant test');
        $this->assertEquals(
            array(
                'text' => 'constant test',
                'link' => 'test',
                'valid' => true,
                'type' => 'constant',
            ),
            $this->lexer->getLink(), 1);
    }

    function test_getLink_guesstype()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getLink')) {
            return;
        }
        $this->lexer->newTag('test()');
        $this->assertEquals(
            array(
                'text' => 'test()',
                'link' => 'test',
                'valid' => true,
                'type' => 'function',
            ),
            $this->lexer->getLink(), 1);
        $this->lexer->newTag('some::$test');
        $this->assertEquals(
            array(
                'text' => 'some::$test',
                'link' => '$test',
                'valid' => true,
                'type' => 'var',
                'class' => 'some',
            ),
            $this->lexer->getLink(), 2);
        $this->lexer->newTag('function some::func()');
        $this->assertEquals(
            array(
                'text' => 'function some::func()',
                'link' => 'func',
                'valid' => true,
                'type' => 'method',
                'class' => 'some',
            ),
            $this->lexer->getLink(), 3);
        $this->lexer->newTag('some::func()');
        $this->assertEquals(
            array(
                'text' => 'some::func()',
                'link' => 'func',
                'valid' => true,
                'type' => 'method',
                'class' => 'some',
            ),
            $this->lexer->getLink(), 4);
        $this->lexer->newTag('some::definedconstant');
        $this->assertEquals(
            array(
                'text' => 'some::definedconstant',
                'link' => 'definedconstant',
                'valid' => true,
                'type' => 'class constant',
                'class' => 'some',
            ),
            $this->lexer->getLink(), 5);
        $this->lexer->newTag('$test');
        $this->assertEquals(
            array(
                'text' => '$test',
                'link' => '$test',
                'valid' => true,
                'type' => 'global',
            ),
            $this->lexer->getLink(), 6);
    }

    function test_getLink_packageselector()
    {
        if (!$this->_methodExists('newTag')) {
            return;
        }
        if (!$this->_methodExists('getLink')) {
            return;
        }
        $this->lexer->newTag('test#test');
        $this->assertEquals(
            array(
                'text' => 'test#test',
                'link' => 'test',
                'valid' => true,
                'type' => 'unknown',
                'package' => 'test',
            ),
            $this->lexer->getLink(), 1);
        $this->lexer->newTag('test#test()');
        $this->assertEquals(
            array(
                'text' => 'test#test()',
                'link' => 'test',
                'valid' => true,
                'type' => 'function',
                'package' => 'test',
            ),
            $this->lexer->getLink(), 2);
    }
}
?>