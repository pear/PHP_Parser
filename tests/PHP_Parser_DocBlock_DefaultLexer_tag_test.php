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

class PHP_Parser_DocBlock_DefaultLexer_tag_test extends PHPUnit_TestCase
{
    /**
     * A PHP_Parser_DocBlock_DefaultLexer object (or one of the drivers)
     * @var        object
     */
    var $lexer;
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

    function PHP_Parser_DocBlock_DefaultLexer_tag_test($name)
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
        PEAR_ErrorStack::staticGetErrors(true);
    }

    function errorCodeToString($package, $code)
    {
        $codes = array(
           'PHP_Parser_DocBlock_DefaultLexer' =>
            array(
                PHP_PARSER_DOCLEX_ERROR_LEX => 'PHP_PARSER_DOCLEX_ERROR_LEX',
                PHP_PARSER_DOCLEX_ERROR_NUMWRONG => 'PHP_PARSER_DOCLEX_ERROR_NUMWRONG',
                PHP_PARSER_DOCLEX_ERROR_NODOT => 'PHP_PARSER_DOCLEX_ERROR_NODOT',
            ),
        );
        return $codes[$package][$code];
    }
    
    function assertErrors($errors, $method)
    {
        $compare = PEAR_ErrorStack::staticGetErrors(false, true);
        $save = $compare;
        foreach ($errors as $err) {
            foreach ($compare as $i => $guineapig) {
                if ($err['level'] == $guineapig['level'] &&
                      $err['package'] == $guineapig['package'] &&
                      $err['message'] == $guineapig['message'] &&
                      $err['code'] == $guineapig['code']) {
                    unset($compare[$i]);
                }
            }
        }
        $compare = array_values($compare);
        if (count($compare)) {
            foreach ($compare as $err) {
                $this->assertFalse(true, "$method Extra error: package $err[package], message '$err[message]', level $err[level], code " . $this->errorCodeToString($err['package'], $err['code']));
            }
        }
        foreach ($save as $err) {
            foreach ($errors as $i => $guineapig) {
                if ($err['level'] == $guineapig['level'] &&
                      $err['package'] == $guineapig['package'] &&
                      $err['message'] == $guineapig['message'] &&
                      $err['code'] == $guineapig['code']) {
                    unset($errors[$i]);
                }
            }
        }
        foreach ($errors as $err) {
            $this->assertFalse(true, "$method Unthrown error: package $err[package], message '$err[message]', level $err[level], code " . $this->errorCodeToString($err['package'], $err['code']));
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
                $this->assertFalse(true, $this->errorCodeToString($error['package'],
                   $error['code']));
                $this->assertFalse(true, $error['level']);
            }
        }
        PEAR_ErrorStack::staticGetErrors(true);
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
    
    function test_tag()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@ignore');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@ignore'),
            ), $data, 'tags failed 1');
        $this->assertNoErrors('test_tag', 'tags error 1');

        $this->lexer->setup('test not a tag @ignore');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TEXT, 'test not a tag @ignore'),
            ), $data, 'tags failed 2');
        $this->assertNoErrors('test_tag', 'tags error 2');

        $this->lexer->setup('test not a tag
@static');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TEXT, "test not a tag\n"),
                array(PHP_PARSER_DOCLEX_TAG, '@static'),
            ), $data, 'tags failed 3');
        $this->assertNoErrors('test_tag', 'tags error 3');

        $this->lexer->setup('@author Greg Beaver <testing@example.com>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@author'),
                array(PHP_PARSER_DOCLEX_TEXT, " Greg Beaver <testing@example.com>"),
            ), $data, 'tags failed 4');
        $this->assertNoErrors('test_tag', 'tags error 4');

        $this->lexer->setup('@since my second @tag attempt');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, " my second @tag attempt"),
            ), $data, 'tags failed 5');
        $this->assertNoErrors('test_tag', 'tags error 5');
    }
    
    function test_multipletags()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }

        $this->lexer->setup('@see my beefy arms
@since my second @tag attempt');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@see'),
                array(PHP_PARSER_DOCLEX_TEXT, " my beefy arms"),
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, " my second @tag attempt"),
            ), $data, 'tags failed 5');
        $this->assertNoErrors('test_tag', 'tags error');
    }
    
    function test_htmltag()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@see me <b></p><pre></pre> < test bracket');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@see'),
                array(PHP_PARSER_DOCLEX_TEXT, " me "),
                array(PHP_PARSER_DOCLEX_OPEN_B, '<b>'),
                array(PHP_PARSER_DOCLEX_CLOSE_P, '</p>'),
                array(PHP_PARSER_DOCLEX_OPEN_PRE, '<pre>'),
                array(PHP_PARSER_DOCLEX_CLOSE_PRE, '</pre>'),
                array(PHP_PARSER_DOCLEX_TEXT, " < test bracket"),
            ), $data, 'tags failed 1');
        $this->lexer->setup('@since </b><samp></samp><kbd>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_CLOSE_B, '</b>'),
                array(PHP_PARSER_DOCLEX_OPEN_SAMP, '<samp>'),
                array(PHP_PARSER_DOCLEX_CLOSE_SAMP, '</samp>'),
                array(PHP_PARSER_DOCLEX_OPEN_KBD, '<kbd>'),
            ), $data, 'tags failed 2');
        $this->lexer->setup('@since </kbd><code></code><ol>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_CLOSE_KBD, '</kbd>'),
                array(PHP_PARSER_DOCLEX_OPEN_CODE, '<code>'),
                array(PHP_PARSER_DOCLEX_CLOSE_CODE, '</code>'),
                array(PHP_PARSER_DOCLEX_OPEN_LIST, '<ol>'),
            ), $data, 'tags failed 3');
        $this->lexer->setup('@since </ol><li></li><ul></ul>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_CLOSE_LIST, '</ol>'),
                array(PHP_PARSER_DOCLEX_OPEN_LI, '<li>'),
                array(PHP_PARSER_DOCLEX_CLOSE_LI, '</li>'),
                array(PHP_PARSER_DOCLEX_OPEN_LIST, '<ul>'),
                array(PHP_PARSER_DOCLEX_CLOSE_LIST, '</ul>'),
            ), $data, 'tags failed 4');
        $this->lexer->setup('@since <strong></i></strong><em></em><var></var><i>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
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
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since <pre>
testing my this has <b>   lots of doohickeys<</pre>><</pre  >><</code>><</code  >>
</pre>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_OPEN_PRE, '<pre>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\ntesting my this has <b>   lots of doohickeys"),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<</pre>>'),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<</pre  >>'),
                array(PHP_PARSER_DOCLEX_TEXT, "<</code>><</code  >>\n"),
                array(PHP_PARSER_DOCLEX_CLOSE_PRE, '</pre>'),
            ), $data, 'pre');
    }

    function test_code()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since <code>
testing my this has <b>   lots of doohickeys<</pre>><</code>><</code  >>
</code>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_OPEN_CODE, '<code>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\ntesting my this has <b>   lots of doohickeys<</pre>>"),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<</code>>'),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<</code  >>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\n"),
                array(PHP_PARSER_DOCLEX_CLOSE_CODE, '</code>'),
            ), $data, 'pre');
    }

    function test_escaped_tag()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since <<one>><<two   />>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<<one>>'),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<<two   />>'),
            ), $data, 'escaped tag');
    }

    function test_complete_tag()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since <br/><br  />');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_XML_TAG, '<br/>'),
                array(PHP_PARSER_DOCLEX_XML_TAG, '<br  />'),
            ), $data, 'complete tag');
    }
    
    function test_double_nl()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since

');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_DOUBLENL, "\n\n"),
            ), $data, 'first doublenl');

            $this->lexer->setup('@since testing my theory
this is some text

and some more text here we go
isn\'t this fun?

again some more');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, " testing my theory\nthis is some text"),
                array(PHP_PARSER_DOCLEX_DOUBLENL, "\n\n"),
                array(PHP_PARSER_DOCLEX_TEXT, "and some more text here we go\nisn't this fun?"),
                array(PHP_PARSER_DOCLEX_DOUBLENL, "\n\n"),
                array(PHP_PARSER_DOCLEX_TEXT, 'again some more'),
            ), $data, 'second doublenl');
    }

    function test_inline_tag()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since {@inheritdoc}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, '{@'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_NAME, 'inheritdoc'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CLOSE, '}'),
            ), $data, 'inline tag');
        $this->lexer->setup('@since {@link somefoo someotherfoo}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, '{@'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_NAME, 'link'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CONTENTS, ' somefoo someotherfoo'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CLOSE, '}'),
            ), $data, 'inline tag contents');
        $this->lexer->setup('@since <code>{@id 3}</code>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_OPEN_CODE, '<code>'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, '{@'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_NAME, 'id'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CONTENTS, ' 3'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CLOSE, '}'),
                array(PHP_PARSER_DOCLEX_CLOSE_CODE, '</code>'),
            ), $data, 'inline tag code');
        $this->lexer->setup('@since <pre>{@id 4}</pre>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_OPEN_PRE, '<pre>'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, '{@'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_NAME, 'id'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CONTENTS, ' 4'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CLOSE, '}'),
                array(PHP_PARSER_DOCLEX_CLOSE_PRE, '</pre>'),
            ), $data, 'inline tag pre');
        $this->lexer->setup('{@}{@*}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_INLINE_ESC, '{@}'),
                array(PHP_PARSER_DOCLEX_INLINE_ESC, '{@*}'),
            ), $data, 'inline escape');
    }

    function test_simplelist_basic()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since - first item
 - second item
 - third item');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
            ), $data, 'simple list 1');
        $this->lexer->setup('@since o first item
 o second item
 o third item');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "o"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "o"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "o"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
            ), $data, 'simple list 1.1');
        $this->lexer->setup('@since 1 first item
 2 second item
 3 third item');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NBULLET, "1"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NBULLET, "2"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NBULLET, "3"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
            ), $data, 'simple list 2');
        $this->lexer->setup('@since 1. first item
 2. second item
 3. third item');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NDBULLET, "1."),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NDBULLET, "2."),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NDBULLET, "3."),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
            ), $data, 'simple list 3');
    }

    function test_simplelist_basic_intag()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since <b>
 - first item
 - second item
 - third item
</b>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_OPEN_B, '<b>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_CLOSE_B, '</b>'),
            ), $data, 'simple list 1');
        $this->lexer->setup('@since <i>
 o first item
 o second item
 o third item
</i>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_OPEN_I, '<i>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "o"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "o"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "o"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_CLOSE_I, '</i>'),
            ), $data, 'simple list 1.1');
        $this->lexer->setup('@since <kbd>
 1 first item
 2 second item
 3 third item
</kbd>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_OPEN_KBD, '<kbd>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NBULLET, "1"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NBULLET, "2"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NBULLET, "3"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_CLOSE_KBD, '</kbd>'),
            ), $data, 'simple list 2');
        $this->lexer->setup('@since <samp>
 1. first item
 2. second item
 3. third item
 </samp>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_OPEN_SAMP, '<samp>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NDBULLET, "1."),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NDBULLET, "2."),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NDBULLET, "3."),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_CLOSE_SAMP, '</samp>'),
            ), $data, 'simple list 3');
    }

    function test_simplelist_nested()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since - first item
   1 nested first
   2 nested second
 - second item
 - third item
       1 nested first
         + another item
         + yet another
         + a third
       2 nested second
');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_START, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "   "),
                array(PHP_PARSER_DOCLEX_NBULLET, "1"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested first'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "   "),
                array(PHP_PARSER_DOCLEX_NBULLET, "2"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested second'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_START, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "       "),
                array(PHP_PARSER_DOCLEX_NBULLET, "1"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested first'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_START, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "         "),
                array(PHP_PARSER_DOCLEX_BULLET, "+"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' another item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "         "),
                array(PHP_PARSER_DOCLEX_BULLET, "+"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' yet another'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "         "),
                array(PHP_PARSER_DOCLEX_BULLET, "+"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' a third'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "       "),
                array(PHP_PARSER_DOCLEX_NBULLET, "2"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested second'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
            ), $data, 'simple list 1');
    }

    function test_simplelist_nested_intag()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since <var>
 - first item
   1 nested first
   2 nested second
 - second item
 - third item
       1 nested first
         + another item
         + yet another
         + a third
       2 nested second
</var>');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_OPEN_VAR, '<var>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_START, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "   "),
                array(PHP_PARSER_DOCLEX_NBULLET, "1"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested first'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "   "),
                array(PHP_PARSER_DOCLEX_NBULLET, "2"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested second'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_START, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "       "),
                array(PHP_PARSER_DOCLEX_NBULLET, "1"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested first'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_START, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "         "),
                array(PHP_PARSER_DOCLEX_BULLET, "+"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' another item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "         "),
                array(PHP_PARSER_DOCLEX_BULLET, "+"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' yet another'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "         "),
                array(PHP_PARSER_DOCLEX_BULLET, "+"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' a third'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "       "),
                array(PHP_PARSER_DOCLEX_NBULLET, "2"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested second'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_CLOSE_VAR, '</var>'),
            ), $data, 'simple list 1');
    }
    
    function test_inlineinternal_basic()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since {@internal}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'simple list 1');
    }
    
    function test_inline_internal_htmltag()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since {@internal<b></p><pre></pre>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_OPEN_B, '<b>'),
                array(PHP_PARSER_DOCLEX_CLOSE_P, '</p>'),
                array(PHP_PARSER_DOCLEX_OPEN_PRE, '<pre>'),
                array(PHP_PARSER_DOCLEX_CLOSE_PRE, '</pre>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'tags failed 1');
        $this->lexer->setup('@since {@internal</b><samp></samp><kbd>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_CLOSE_B, '</b>'),
                array(PHP_PARSER_DOCLEX_OPEN_SAMP, '<samp>'),
                array(PHP_PARSER_DOCLEX_CLOSE_SAMP, '</samp>'),
                array(PHP_PARSER_DOCLEX_OPEN_KBD, '<kbd>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'tags failed 2');
        $this->lexer->setup('@since {@internal</kbd><code></code><ol>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_CLOSE_KBD, '</kbd>'),
                array(PHP_PARSER_DOCLEX_OPEN_CODE, '<code>'),
                array(PHP_PARSER_DOCLEX_CLOSE_CODE, '</code>'),
                array(PHP_PARSER_DOCLEX_OPEN_LIST, '<ol>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'tags failed 3');
        $this->lexer->setup('@since {@internal</ol><li></li><ul></ul>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_CLOSE_LIST, '</ol>'),
                array(PHP_PARSER_DOCLEX_OPEN_LI, '<li>'),
                array(PHP_PARSER_DOCLEX_CLOSE_LI, '</li>'),
                array(PHP_PARSER_DOCLEX_OPEN_LIST, '<ul>'),
                array(PHP_PARSER_DOCLEX_CLOSE_LIST, '</ul>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'tags failed 4');
        $this->lexer->setup('@since {@internal<strong></i></strong><em></em><var></var><i>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_OPEN_B, '<strong>'),
                array(PHP_PARSER_DOCLEX_CLOSE_I, '</i>'),
                array(PHP_PARSER_DOCLEX_CLOSE_B, '</strong>'),
                array(PHP_PARSER_DOCLEX_OPEN_I, '<em>'),
                array(PHP_PARSER_DOCLEX_CLOSE_I, '</em>'),
                array(PHP_PARSER_DOCLEX_OPEN_VAR, '<var>'),
                array(PHP_PARSER_DOCLEX_CLOSE_VAR, '</var>'),
                array(PHP_PARSER_DOCLEX_OPEN_I, '<i>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'tags failed 5');
    }

    function test_inlineinternal_pre()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since {@internal<pre>
testing my this has <b>   lots of doohickeys<</pre>><</pre  >><</code>><</code  >>
</pre>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_OPEN_PRE, '<pre>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\ntesting my this has <b>   lots of doohickeys"),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<</pre>>'),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<</pre  >>'),
                array(PHP_PARSER_DOCLEX_TEXT, "<</code>><</code  >>\n"),
                array(PHP_PARSER_DOCLEX_CLOSE_PRE, '</pre>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'pre');
    }

    function test_inlineinternal_code()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since {@internal<code>
testing my this has <b>   lots of doohickeys<</pre>><</code>><</code  >>
</code>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_OPEN_CODE, '<code>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\ntesting my this has <b>   lots of doohickeys<</pre>>"),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<</code>>'),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<</code  >>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\n"),
                array(PHP_PARSER_DOCLEX_CLOSE_CODE, '</code>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'code');
    }

    function test_inlineinternal_escaped_tag()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since {@internal<<one>><<two   />>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<<one>>'),
                array(PHP_PARSER_DOCLEX_ESCAPED_TAG, '<<two   />>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'escaped tag');
    }

    function test_inlineinternal_complete_tag()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since {@internal<br/><br  />}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_XML_TAG, '<br/>'),
                array(PHP_PARSER_DOCLEX_XML_TAG, '<br  />'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'complete tag');
    }
    
    function test_inlineinternal_double_nl()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since {@internal

}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_DOUBLENL, "\n\n"),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'first doublenl');

            $this->lexer->setup('@since {@internal testing my theory
this is some text

and some more text here we go
isn\'t this fun?

again some more}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_TEXT, " testing my theory\nthis is some text"),
                array(PHP_PARSER_DOCLEX_DOUBLENL, "\n\n"),
                array(PHP_PARSER_DOCLEX_TEXT, "and some more text here we go\nisn't this fun?"),
                array(PHP_PARSER_DOCLEX_DOUBLENL, "\n\n"),
                array(PHP_PARSER_DOCLEX_TEXT, 'again some more'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'second doublenl');
    }

    function test_inlineinternal_inline_tag()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since {@internal{@inheritdoc}}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, '{@'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_NAME, 'inheritdoc'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CLOSE, '}'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'inline tag');
        $this->lexer->setup('@since {@internal{@link somefoo someotherfoo}}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, '{@'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_NAME, 'link'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CONTENTS, ' somefoo someotherfoo'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CLOSE, '}'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'inline tag contents');
        $this->lexer->setup('@since {@internal<code>{@id 3}</code>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_OPEN_CODE, '<code>'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, '{@'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_NAME, 'id'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CONTENTS, ' 3'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CLOSE, '}'),
                array(PHP_PARSER_DOCLEX_CLOSE_CODE, '</code>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'inline tag code');
        $this->lexer->setup('@since {@internal<pre>{@id 4}</pre>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_OPEN_PRE, '<pre>'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, '{@'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_NAME, 'id'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CONTENTS, ' 4'),
                array(PHP_PARSER_DOCLEX_INLINE_TAG_CLOSE, '}'),
                array(PHP_PARSER_DOCLEX_CLOSE_PRE, '</pre>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'inline tag pre');
        $this->lexer->setup('@since {@internal{@}{@*}}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_INLINE_ESC, '{@}'),
                array(PHP_PARSER_DOCLEX_INLINE_ESC, '{@*}'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'inline escape');
    }

    function test_inlineinternal_simplelist_basic()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since {@internal - first item
 - second item
 - third item}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'simple list 1');
        $this->lexer->setup('@since {@internal o first item
 o second item
 o third item}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "o"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "o"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "o"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'simple list 1.1');
        $this->lexer->setup('@since {@internal 1 first item
 2 second item
 3 third item}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NBULLET, "1"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NBULLET, "2"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NBULLET, "3"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'simple list 2');
        $this->lexer->setup('@since {@internal 1. first item
 2. second item
 3. third item}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NDBULLET, "1."),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NDBULLET, "2."),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NDBULLET, "3."),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'simple list 3');
    }

    function test_inlineinternal_simplelist_basic_intag()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since {@internal<b>
 - first item
 - second item
 - third item
</b>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_OPEN_B, '<b>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_CLOSE_B, '</b>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'simple list 1');
        $this->lexer->setup('@since {@internal<i>
 o first item
 o second item
 o third item
</i>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_OPEN_I, '<i>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "o"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "o"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "o"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_CLOSE_I, '</i>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'simple list 1.1');
        $this->lexer->setup('@since {@internal<kbd>
 1 first item
 2 second item
 3 third item
</kbd>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_OPEN_KBD, '<kbd>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NBULLET, "1"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NBULLET, "2"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NBULLET, "3"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_CLOSE_KBD, '</kbd>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'simple list 2');
        $this->lexer->setup('@since {@internal<samp>
 1. first item
 2. second item
 3. third item
 </samp>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_OPEN_SAMP, '<samp>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NDBULLET, "1."),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NDBULLET, "2."),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_NDBULLET, "3."),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_CLOSE_SAMP, '</samp>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'simple list 3');
    }

    function test_inlineinternal_simplelist_nested()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since {@internal - first item
   1 nested first
   2 nested second
 - second item
 - third item
       1 nested first
         + another item
         + yet another
         + a third
       2 nested second
}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_START, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "   "),
                array(PHP_PARSER_DOCLEX_NBULLET, "1"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested first'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "   "),
                array(PHP_PARSER_DOCLEX_NBULLET, "2"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested second'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_START, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "       "),
                array(PHP_PARSER_DOCLEX_NBULLET, "1"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested first'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_START, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "         "),
                array(PHP_PARSER_DOCLEX_BULLET, "+"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' another item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "         "),
                array(PHP_PARSER_DOCLEX_BULLET, "+"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' yet another'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "         "),
                array(PHP_PARSER_DOCLEX_BULLET, "+"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' a third'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "       "),
                array(PHP_PARSER_DOCLEX_NBULLET, "2"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested second'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'simple list 1');
    }

    function test_inlineinternal_simplelist_nested_intag()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since {@internal<var>
 - first item
   1 nested first
   2 nested second
 - second item
 - third item
       1 nested first
         + another item
         + yet another
         + a third
       2 nested second
</var>}}');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_TEXT, ' '),
                array(PHP_PARSER_DOCLEX_INTERNAL, '{@internal'),
                array(PHP_PARSER_DOCLEX_OPEN_VAR, '<var>'),
                array(PHP_PARSER_DOCLEX_TEXT, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_START, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "   "),
                array(PHP_PARSER_DOCLEX_NBULLET, "1"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested first'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "   "),
                array(PHP_PARSER_DOCLEX_NBULLET, "2"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested second'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' second item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' third item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_START, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "       "),
                array(PHP_PARSER_DOCLEX_NBULLET, "1"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested first'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_START, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "         "),
                array(PHP_PARSER_DOCLEX_BULLET, "+"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' another item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "         "),
                array(PHP_PARSER_DOCLEX_BULLET, "+"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' yet another'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "         "),
                array(PHP_PARSER_DOCLEX_BULLET, "+"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' a third'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "       "),
                array(PHP_PARSER_DOCLEX_NBULLET, "2"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested second'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_CLOSE_VAR, '</var>'),
                array(PHP_PARSER_DOCLEX_ENDINTERNAL, '}}'),
            ), $data, 'simple list 1');
    }

    function test_simplelist_invalid1()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since - first item
   1 nested first
   3 unnested second');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_WHITESPACE, " "),
                array(PHP_PARSER_DOCLEX_BULLET, "-"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first item'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_START, ''),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "   "),
                array(PHP_PARSER_DOCLEX_NBULLET, "1"),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' nested first'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "   "),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_TEXT, '3 unnested second'),
            ), $data, 'simple list 1');
        $this->assertErrors(
            array(array(
                'package' => 'PHP_Parser_DocBlock_DefaultLexer',
                'level' => 'error',
                'code' => PHP_PARSER_DOCLEX_ERROR_NUMWRONG,
                'message' => 'simple list number should be 2 and is [3]',
            )),
        'test_simplelist_invalid1');
    }

    function test_simplelist_invalid2()
    {
        if (!$this->_methodExists('setup')) {
            return;
        }
        if (!$this->_methodExists('advance')) {
            return;
        }
        $this->lexer->setup('@since   1. first
   2 invalid second');
        $data = array();
        while ($a = $this->lexer->advance()) {
            $data[] = array($this->lexer->token, $this->lexer->value);
        }
        $this->assertEquals(
            array(
                array(PHP_PARSER_DOCLEX_TAG, '@since'),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "   "),
                array(PHP_PARSER_DOCLEX_NDBULLET, "1."),
                array(PHP_PARSER_DOCLEX_SIMPLELIST, ' first'),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, "\n"),
                array(PHP_PARSER_DOCLEX_WHITESPACE, "   "),
                array(PHP_PARSER_DOCLEX_SIMPLELIST_END, ''),
                array(PHP_PARSER_DOCLEX_TEXT, '2 invalid second'),
            ), $data, 'simple list 1');
        $this->assertErrors(
            array(array(
                'package' => 'PHP_Parser_DocBlock_DefaultLexer',
                'level' => 'error',
                'code' => PHP_PARSER_DOCLEX_ERROR_NODOT,
                'message' => 'error, no dot in simple list bullet [2]',
            )),
        'test_simplelist_invalid2');
    }
}
?>