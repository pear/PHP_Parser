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

class PHP_Parser_DocBlock_DefaultLexer_test extends PHPUnit_TestCase
{
    /**
     * A PHP_Parser_DocBlock_DefaultLexer object (or one of the drivers)
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

    function PHP_Parser_DocBlock_DefaultLexer_test($name)
    {
        $this->PHPUnit_TestCase($name);
    }

    function setUp()
    {
        error_reporting(E_ALL);
        $this->errorOccured = false;
        set_error_handler(array(&$this, 'errorHandler'));

        $this->lexer = new PHP_Parser_DocBlock_DefaultLexer('');
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
           'PHP_Parser_DocBlock_DefaultLexer' =>
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
    
    function test_htmltag()
    {
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        $this->lexer->setup('<b></p><pre></pre>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_OPEN_B, '<b>'),
                array(PHP_PARSER_DOCLEX_CLOSE_P, '</p>'),
                array(PHP_PARSER_DOCLEX_OPEN_PRE, '<pre>'),
                array(PHP_PARSER_DOCLEX_CLOSE_PRE, '</pre>'),
            ), $data, 'tags failed 1');
        $this->lexer->setup('</b><samp></samp><kbd>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_CLOSE_B, '</b>'),
                array(PHP_PARSER_DOCLEX_OPEN_SAMP, '<samp>'),
                array(PHP_PARSER_DOCLEX_CLOSE_SAMP, '</samp>'),
                array(PHP_PARSER_DOCLEX_OPEN_KBD, '<kbd>'),
            ), $data, 'tags failed 2');
        $this->lexer->setup('</kbd><code></code><ol>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_CLOSE_KBD, '</kbd>'),
                array(PHP_PARSER_DOCLEX_OPEN_CODE, '<code>'),
                array(PHP_PARSER_DOCLEX_CLOSE_CODE, '</code>'),
                array(PHP_PARSER_DOCLEX_OPEN_LIST, '<ol>'),
            ), $data, 'tags failed 3');
        $this->lexer->setup('</ol><li></li><ul></ul>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_CLOSE_LIST, '</ol>'),
                array(PHP_PARSER_DOCLEX_OPEN_LI, '<li>'),
                array(PHP_PARSER_DOCLEX_CLOSE_LI, '</li>'),
                array(PHP_PARSER_DOCLEX_OPEN_LIST, '<ul>'),
                array(PHP_PARSER_DOCLEX_CLOSE_LIST, '</ul>'),
            ), $data, 'tags failed 4');
        $this->lexer->setup('<strong></i></strong><em></em><var></var><i>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_OPEN_B, '<strong>'),
                array(PHP_PARSER_DOCLEX_CLOSE_I, '</i>'),
                array(PHP_PARSER_DOCLEX_CLOSE_B, '</strong>'),
                array(PHP_PARSER_DOCLEX_OPEN_I, '<em>'),
                array(PHP_PARSER_DOCLEX_CLOSE_I, '</em>'),
                array(PHP_PARSER_DOCLEX_OPEN_VAR, '<var>'),
                array(PHP_PARSER_DOCLEX_CLOSE_VAR, '</var>'),
                array(PHP_PARSER_DOCLEX_OPEN_I, '<i>'),
            ), $data, 'tags failed 5');
    }

    function test_pre()
    {
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        $this->lexer->setup('<pre>
testing my this has <b>   lots of doohickeys<</pre>><</code>>
</pre>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_OPEN_PRE, '<pre>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\ntesting my this has <b>   lots of doohickeys"),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<</pre>>'),
                array(PHP_PARSER_DOCLEX_TEXT, "<</code>>\n"),
                array(PHP_PARSER_DOCLEX_CLOSE_PRE, '</pre>'),
            ), $data, 'pre');
    }

    function test_code()
    {
        if (!$this->_methodExists('setOptions')) {
            return;
        }
        $this->lexer->setup('<code>
testing my this has <b>   lots of doohickeys<</pre>><</code>>
</code>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_OPEN_CODE, '<code>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\ntesting my this has <b>   lots of doohickeys<</pre>>"),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<</code>>'),
                array(PHP_PARSER_DOCLEX_NL, "\n"),
                array(PHP_PARSER_DOCLEX_CLOSE_CODE, '</code>'),
            ), $data, 'pre');
    }
}
?>