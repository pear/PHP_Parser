<?php
require_once 'PHP/Parser/MsgServer.php';
class noHandleMessage {}

class hasHandleMessageDefault
{
    function handleMessage(){}
}

class hasHandleMessageOther
{
    function Other(){}
}

class PHP_Parser_MsgServer_test extends PHPUnit_TestCase {
    var $_msgserver;
    
    function setUp()
    {
        error_reporting(E_ALL);
        $this->errorOccured = false;
        set_error_handler(array(&$this, 'errorHandler'));
        $this->_expectedErrors = array();
        $this->_msgserver = &new PHP_Parser_MsgServer;
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
        unset($this->_msgserver);
    }

    function errorCodeToString($package, $code)
    {
        $codes = array(
           'PHP_Parser_MsgServer' =>
            array_flip(array(
                'PHP_PARSER_MSGSERVER_ERR_BAD_UNIQUE_ID' => PHP_PARSER_MSGSERVER_ERR_BAD_UNIQUE_ID,
                'PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED' => PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED,
                'PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT' => PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT,
                'PHP_PARSER_MSGSERVER_ERR_UNIQUEID_ALREADY_REGISTERED' => PHP_PARSER_MSGSERVER_ERR_UNIQUEID_ALREADY_REGISTERED,
                'PHP_PARSER_MSGSERVER_ERR_NO_LISTENERS' => PHP_PARSER_MSGSERVER_ERR_NO_LISTENERS,
                'PHP_PARSER_MSGSERVER_ERR_NOT_LISTENING' => PHP_PARSER_MSGSERVER_ERR_NOT_LISTENING,
                'PHP_PARSER_MSGSERVER_ERR_NONE_REGISTERED' => PHP_PARSER_MSGSERVER_ERR_NONE_REGISTERED,
                'PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED_YET' => PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED_YET,
                'PHP_PARSER_MSGSERVER_ERR_HANDLER_DOESNT_EXIST' => PHP_PARSER_MSGSERVER_ERR_HANDLER_DOESNT_EXIST,
                'PHP_PARSER_MSGSERVER_ERR_NO_CATCHERS' => PHP_PARSER_MSGSERVER_ERR_NO_CATCHERS,
            )),
        );
        return $codes[$package][$code];
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
            foreach ($compare as $i => $guineapig) {
                if ($err['level'] == $guineapig['level'] &&
                      $err['package'] == $guineapig['package'] &&
                      $err['message'] == $guineapig['message']) {
                    unset($compare[$i]);
                }
            }
        }
        $compare = array_values($compare);
        if (count($compare)) {
            foreach ($compare as $err) {
                $this->assertFalse(true, "$method Extra error: package $err[package], message '$err[message]', level $err[level], code" . $this->errorCodeToString($err['package'], $err['code']));
            }
        }
        foreach ($save as $err) {
            foreach ($errors as $i => $guineapig) {
                if ($err['level'] == $guineapig['level'] &&
                      $err['package'] == $guineapig['package'] &&
                      $err['message'] == $guineapig['message']) {
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
                $this->assertFalse(true, $this->errorCodeToString('PHP_Parser_MsgServer',
                   $error['code']));
                $this->assertFalse(true, $error['level']);
            }
        }
        PHP_Parser_Stack::staticGetErrors(true);
    }
    
    function _catch3($type, $message)
    {
        $this->_message[] = array($type, $message);
    }
    
    function _catch4($type, $message)
    {
        $this->_message[] = array($type, $message);
        return 'hi to you too';
    }
    
    function testsingleton()
    {
        $server = &PHP_Parser_MsgServer::singleton();
        $this->assertTrue(is_a($server, 'PHP_Parser_MsgServer'), 'doesn\'t return MsgServer object');
        $this->assertEquals(get_class($GLOBALS['_PHP_PARSER_MSGSERVER_INSTANCE']), get_class($server), 'Global instance isn\'t same class');
        $server->hello = 6;
        $this->assertEquals($server->hello, $GLOBALS['_PHP_PARSER_MSGSERVER_INSTANCE']->hello, 'not same object');
    }
    
    function testRegisterListener_invalid1()
    {
        $a = 6;
        $a = $this->_msgserver->registerListener(5, $a);
        $this->assertErrors(
            array(
                array(
                    'package' => 'PHP_Parser_MsgServer',
                    'level' => 'exception',
                    'message' => 'Invalid parameter passed to $obj, should be type "object", is "integer"',
                    'code' => PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT
                ),
            ),
        'testRegisterListener_invalid1');
        $b = 'Invalid parameter passed to $obj, ' .
                'should be type "object", is "integer"';
    }
    
    function testRegisterListener_invalid2()
    {
        $a = new noHandleMessage;
        $a = $this->_msgserver->registerListener(array(), $a);
        $b = 'Unique ID must be string or integer,' .
                ' not array';
        $this->assertErrors(
            array(
                array(
                    'package' => 'PHP_Parser_MsgServer',
                    'level' => 'exception',
                    'message' => $b,
                    'code' => PHP_PARSER_MSGSERVER_ERR_BAD_UNIQUE_ID,
                )
            ),
            'testRegisterListener_invalid2');
    }
    
    function testRegisterListener_valid1()
    {
        $a = new noHandleMessage;
        $aa = $this->_msgserver->registerListener(5, $a);
        $this->assertSame(true, $aa, 'registration failed');
        $this->assertNoErrors('testRegisterListener_valid1', 'first registration failed');
        $this->assertEquals(array(5 => $a), $this->_msgserver->_ref_store, 'registration unexpectedly different');
        $ar = new noHandleMessage;
        $aa = $this->_msgserver->registerListener(5, $ar);
        $b = 'Unique ID "5" is ' .
                'already registered';
        $this->assertErrors(
            array(
                array(
                    'package' => 'PHP_Parser_MsgServer',
                    'level' => 'error',
                    'message' => $b,
                    'code' => PHP_PARSER_MSGSERVER_ERR_UNIQUEID_ALREADY_REGISTERED,
                )
            ),
        'testRegisterListener_valid1');
        $ar = new noHandleMessage;
        $aa = $this->_msgserver->registerListener(6, $ar);
        $this->assertSame(true, $aa, 'duplicate registration failed');
    }
    
    function testRegisterListener4()
    {
        $a = new noHandleMessage;
        $b = $this->_msgserver->registerListener('string', $a);
        $this->assertSame(true, $b, 'registration of string unique_id failed');
        $this->assertNoErrors('testRegisterListener4', 'first registration failed');
    }
    
    function test_unregisterAll1()
    {
        $a = new noHandleMessage;
        $aa = $this->_msgserver->registerListener(5, $a);
        $this->assertSame(true, $aa, 'registration failed');
        $this->assertNoErrors('test_unregisterAll1', 'first registration failed');
        $a = new noHandleMessage;
        $aa = $this->_msgserver->registerListener(5, $a);
        $b = 'Unique ID "5" is ' .
                'already registered';
        $this->assertErrors(
            array(
                array(
                    'package' => 'PHP_Parser_MsgServer',
                    'level' => 'error',
                    'message' => $b,
                    'code' => PHP_PARSER_MSGSERVER_ERR_UNIQUEID_ALREADY_REGISTERED,
                )
            ),
        'test_unregisterAll1');
        PHP_Parser_Stack::staticGetErrors(true);
        $ar = new noHandleMessage;
        $aa = $this->_msgserver->registerListener(6, $ar);
        $this->assertSame(true, $aa, 'duplicate registration failed');

        $ae = $this->_msgserver->_unregisterAll();
        $this->assertSame(true, $ae, 'total unregistration didn\'t return true');
        $this->assertEquals(array(), $this->_msgserver->_reg_store, 'registration not cleared');
        $this->assertEquals(array(), $this->_msgserver->_ref_store, 'references not cleared');
    }
    
    function test_unregisterAll2()
    {
        $a = new noHandleMessage;
        $aa = $this->_msgserver->registerListener(5, $a);
        $this->assertSame(true, $aa, 'registration failed');
        $ae = new noHandleMessage;
        $aa = $this->_msgserver->registerListener(5, $ae);
        $b = 'Unique ID "5" is ' .
                'already registered';
        $this->assertErrors(
            array(
                array(
                    'package' => 'PHP_Parser_MsgServer',
                    'level' => 'error',
                    'message' => $b,
                    'code' => PHP_PARSER_MSGSERVER_ERR_UNIQUEID_ALREADY_REGISTERED,
                )
            ),
        'test_unregisterAll2');
        PHP_Parser_Stack::staticGetErrors(true);
        $ra = new noHandleMessage;
        $ah = $this->_msgserver->registerListener(6, $ra);
        $this->assertSame(true, $ah, 'duplicate registration failed');

        $ah = $this->_msgserver->_unregisterAll(array());
        $b = 'Unique ID must be string or integer,' .
                ' not array';
        $this->assertErrors(
            array(
                array(
                    'package' => 'PHP_Parser_MsgServer',
                    'level' => 'exception',
                    'message' => $b,
                    'code' => PHP_PARSER_MSGSERVER_ERR_BAD_UNIQUE_ID,
                )
            ),
        'test_unregisterAll2');
    }
    
    function test_unregisterAll3()
    {
        $a = new noHandleMessage;
        $res = $this->_msgserver->registerListener(5, $a);
        $this->assertSame(true, $res, 'registration failed');
        $ar = new noHandleMessage;
        $res = $this->_msgserver->registerListener(5, $ar);
        $b = 'Unique ID "5" is ' .
                'already registered';
        $this->assertErrors(
            array(
                array(
                    'package' => 'PHP_Parser_MsgServer',
                    'level' => 'error',
                    'message' => $b,
                    'code' => PHP_PARSER_MSGSERVER_ERR_UNIQUEID_ALREADY_REGISTERED,
                )
            ),
        'test_unregisterAll3');
        PHP_Parser_Stack::staticGetErrors(true);
        $aq = new noHandleMessage;
        $res = $this->_msgserver->registerListener(6, $aq);
        $this->assertSame(true, $res, 'duplicate registration failed');
        $this->assertNoErrors('test_unregisterAll3', 'errors after dupe registration');

        $res = $this->_msgserver->_unregisterAll(7);
        $this->assertSame(true, $res, 'didn\'t unregister non-existing successfully');
        $b = 'Unique ID "7" is not a registered ' .
                'listener for any messages';
        $this->assertErrors(
            array(
                array(
                    'package' => 'PHP_Parser_MsgServer',
                    'level' => 'warning',
                    'message' => $b,
                    'code' => PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED,
                )
            ),
        'test_unregisterAll3');
    }
    
    function test_unregisterAll4()
    {
        $a = new noHandleMessage;
        $res = $this->_msgserver->registerListener(5, $a);
        $this->assertSame(true, $res, 'registration failed');
        $ar = new noHandleMessage;
        $res = $this->_msgserver->registerListener(5, $ar);
        $b = 'Unique ID "5" is ' .
                'already registered';
        $this->assertErrors(
            array(
                array(
                    'package' => 'PHP_Parser_MsgServer',
                    'level' => 'error',
                    'message' => $b,
                    'code' => PHP_PARSER_MSGSERVER_ERR_UNIQUEID_ALREADY_REGISTERED,
                )
            ),
        'test_unregisterAll3');
        PHP_Parser_Stack::staticGetErrors(true);
        $ra = new noHandleMessage;
        $res = $this->_msgserver->registerListener(6, $ra);
        $this->assertSame(true, $res, 'duplicate registration failed');
        $this->assertNoErrors('test_unregisterAll4', 'dupe reg failed');

        $res = $this->_msgserver->_unregisterAll(5);
        $this->assertSame(true, $res);
        $this->assertEquals(array(6 => $a), $this->_msgserver->_ref_store, 'ref_store doesn\'t match');
        $this->assertNoErrors('test_unregisterAll4', '2nd _unregisterAll failed');
    }
    
    function test_unregisterAll5()
    {
        $this->testcatchMessage5();
        $res = $this->_msgserver->_unregisterAll(5);
        $this->assertSame(true, $res);
        $this->assertEquals(array(), $this->_msgserver->_ref_store, 'ref_store doesn\'t match');
        $this->assertEquals(array(), $this->_msgserver->_reg_store, 'reg_store doesn\'t match');
    }
    
    function testcatchMessage1()
    {
        $a = $this->_msgserver->catchMessage(5, 5);
        $b = 'No registered listeners for ' .
                'any message, use registerListener() first';
        $this->assertErrors(
            array(
                array(
                    'package' => 'PHP_Parser_MsgServer',
                    'level' => 'exception',
                    'message' => $b,
                    'code' => PHP_PARSER_MSGSERVER_ERR_NO_LISTENERS,
                )
            ),
        'testcatchMessage1');
    }
    
    function testcatchMessage2()
    {
        $a = new hasHandleMessageDefault;
        $res = $this->_msgserver->registerListener(5, $a);
        $this->assertSame(true, $res, 'registration failed');
        $this->assertNoErrors('testcatchMessage2', 'setup failed');
        $res = $this->_msgserver->catchMessage(6, 6);
        $b = 'Unique ID "6" is not a ' .
                'registered listener, use registerListener() first';
        $this->assertErrors(
            array(
                array(
                    'package' => 'PHP_Parser_MsgServer',
                    'level' => 'exception',
                    'message' => $b,
                    'code' => PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED,
                )
            ),
        'testcatchMessage2');
    }
    
    function testcatchMessage3()
    {
        $a = new hasHandleMessageDefault;
        $res = $this->_msgserver->registerListener(5, $a);
        $this->assertSame(true, $res, 'registration failed');
        $this->assertNoErrors('testcatchMessage3', 'setup failed');
        $res = $this->_msgserver->catchMessage(5, array());
        $b = 'Invalid parameter passed to $message_type, ' .
                'should be type "string|integer", is "array"';
        $this->assertErrors(
            array(
                array(
                    'package' => 'PHP_Parser_MsgServer',
                    'level' => 'exception',
                    'message' => $b,
                    'code' => PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT,
                )
            ),
        'testcatchMessage3');
    }
    
    function testcatchMessage4()
    {
        $a = new hasHandleMessageDefault;
        $res = $this->_msgserver->registerListener(5, $a);
        $this->assertSame(true, $res, 'registration failed');
        $res = $this->_msgserver->catchMessage(5, 5);
        $this->assertSame(true, $res, 'integer message type, default handler failed');
        $res = $this->_msgserver->catchMessage(5, 'string');
        $this->assertSame(true, $res, 'string message type, default handler failed');
    }
    
    function testcatchMessage5()
    {
        $a = new hasHandleMessageOther;
        $res = $this->_msgserver->registerListener(5, $a);
        $this->assertSame(true, $res, 'registration failed');
        $res = $this->_msgserver->catchMessage(5, 5, 'Other');
        $this->assertSame(true, $res, 'integer message type, different handler failed');
        $res = $this->_msgserver->catchMessage(5, 'string', 'Other');
        $this->assertSame(true, $res, 'string message type, different handler failed');
    }
    
    function testcatchMessage6()
    {
        $a = new hasHandleMessageOther;
        $res = $this->_msgserver->registerListener(5, $a);
        $this->assertSame(true, $res, 'registration failed');
        $res = $this->_msgserver->catchMessage(5, 5);
        $this->assertEquals('msgserver_exception', get_class($res), 'didn\'t return exception');
        $b = 'Message handler method ' .
                '"handleMessage" doesn\'t exist for listener "5", class "hashandlemessageother"';
        $res = $this->_msgserver->catchMessage(5, 'string');
        $this->assertEquals('msgserver_exception', get_class($res), 'didn\'t return exception');
        $b = 'Message handler method ' .
                '"handleMessage" doesn\'t exist for listener "5", class "hashandlemessageother"';
    }
    
    function teststopCatchingMessages1()
    {
        $res = $this->_msgserver->stopCatchingMessages(array(), 5);
        $this->assertEquals('msgserver_exception', get_class($res), 'didn\'t return exception');
        $b = 'Invalid parameter passed to $message_type, ' .
                'should be type "string|integer", is "array"';
    }
    
    function teststopCatchingMessages2()
    {
        $a = new hasHandleMessageOther;
        $res = $this->_msgserver->registerListener(5, $a);
        $this->assertSame(true, $res, 'registration failed');
        $res = $this->_msgserver->catchMessage(5, 5, 'other');
        $this->assertSame(true, $res, 'catchmessage failed');
        $res = $this->_msgserver->stopCatchingMessages(5, 5);
        $this->assertEquals('msgserver_exception', get_class($res), 'didn\'t return exception');
        $b = 'Invalid parameter passed to $unique_ids, ' .
                'should be type "array", is "integer"';
    }
    
    function teststopCatchingMessages3()
    {
        $res = $this->_msgserver->stopCatchingMessages(5, array());
        $this->assertSame(true, $res, 'stop catching failed, should work');
        $this->assertEquals('msgserver_notice', get_class($this->_caught), 'didn\'t throw notice');
        $b = 'No Listeners registered for ' .
                'message type "5"';
    }
    
    function teststopCatchingMessages4()
    {
        $this->testcatchMessage5();
        $res = $this->_msgserver->stopCatchingMessages(5, array(null, array()));
        $this->assertEquals('msgserver_exception', get_class($res), 'didn\'t return exception');
        $b = 'Unique ID must be string or integer,' .
                ' not NULL';
    }
    
    function teststopCatchingMessages5()
    {
        $this->testcatchMessage5();
        $res = $this->_msgserver->stopCatchingMessages(5, array(7));
        $this->assertSame(true, $res, 'stop catching failed, should work');
        $this->assertEquals('msgserver_notice', get_class($this->_caught), 'didn\'t throw notice');
        $res = $this->_caught;
        $b = 'Listener "7" is not listening ' .
                'to message "5"';
    }
    
    function teststopCatchingMessages6()
    {
        $this->testcatchMessage5();
        $res = $this->_msgserver->stopCatchingMessages(5, array(7));
        $this->assertSame(true, $res, 'stop catching failed, should work');
        $this->assertEquals('msgserver_notice', get_class($this->_caught), 'didn\'t throw notice');
        $b = 'Listener "7" is not listening ' .
                'to message "5"';
    }
    
    function teststopCatchingMessages7()
    {
        $this->testcatchMessage5();
        $res = $this->_msgserver->stopCatchingMessages(5, array(5, 7));
        $this->assertSame(true, $res, 'stop catching failed, should work');
        $this->assertNull(@$this->_msgserver->_reg_store[5], 'didn\'t unregister');
        $this->assertSame(1, count($this->_caught), count($this->_caught). ' errors thrown');
        $this->assertEquals('msgserver_notice', get_class($this->_caught[0]), 'didn\'t throw notice');
        $res = $this->_caught[0];
        $b = 'Listener "7" is not listening ' .
                'to message "5"';
    }
    
    function teststopCatchingMessage1()
    {
        $this->testcatchMessage5();
        $res = $this->_msgserver->stopCatchingMessage(array());
        $this->assertEquals('msgserver_exception', get_class($res), 'didn\'t return exception');
        $b = 'Invalid parameter passed to $messagetype, ' .
                'should be type "string|integer", is "array"';
    }
    
    function teststopCatchingMessage2()
    {
        $res = $this->_msgserver->stopCatchingMessage(5);
        $this->assertSame(true, $res, 'stop catch failed, should work');
        $this->assertEquals('msgserver_notice', get_class($this->_caught), 'didn\'t throw notice');
        $res = $this->_caught;
        $b = 'No Listeners registered for message type "5"';
    }
    
    function teststopCatchingMessage3()
    {
        $this->testcatchMessage5();
        $res = $this->_msgserver->stopCatchingMessage(5);
        $this->assertSame(true, $res, 'stop catch failed, should work');
        $this->assertSame(false, $this->_caught, 'threw error, and shouldn\'t');
        $this->assertNull(@$this->_msgserver->_reg_store[5], 'didn\'t unset!');
    }
    
    function testunRegisterId()
    {
        $this->testcatchMessage5();
        $res = $this->_msgserver->unregisterId(5);
        $this->assertSame(true, $res, 'unregisterId failed, should work');
        $this->assertSame(false, $this->_caught, 'threw error, and shouldn\'t');
    }
    
    function testunregisterIds1()
    {
        $res = $this->_msgserver->unregisterIds(6);
        $this->assertEquals('msgserver_exception', get_class($res), 'didn\'t return exception');
        $b = 'Invalid parameter passed to $unique_ids, ' .
                'should be type "array", is "integer"';
    }
    
    function testunregisterIds2()
    {
        $this->testcatchMessage5();
        $a = new noHandleMessage;
        $res = $this->_msgserver->registerListener(6, $a);
        $this->assertSame(true, $res, 'registration of other failed');
        $res = $this->_msgserver->unregisterIds(array(5, 6));
        $this->assertSame(true, $res, 'unregisterId failed, should work');
        $this->assertSame(false, $this->_caught, 'threw error, and shouldn\'t');
        $this->assertEquals(array(), $this->_msgserver->_ref_store, 'refstore not empty');
        $this->assertEquals(array(), $this->_msgserver->_reg_store, 'regstore not empty');
    }
    
    function testsendMessage1()
    {
        $res = $this->_msgserver->sendMessage(5, 5);
        $this->assertSame(true, $res, 'sendmessage should work');
        $this->assertEquals('msgserver_notice', get_class($this->_caught), 'not notice');
        $res = $this->_caught;
        $b = 'No registered listeners for ' .
                'any message, use registerListener() first';
    }
    
    function testsendMessage2()
    {
        $a = new noHandleMessage;
        $res = $this->_msgserver->registerListener(6, $a);
        $this->assertSame(true, $res, 'registration of other failed');
        $res = $this->_msgserver->sendMessage(5, 5);
        $this->assertSame(true, $res, 'sendmessage should work');
        $this->assertEquals('msgserver_notice', get_class($this->_caught), 'not notice');
        $res = $this->_caught;
        $b = 'Message "5" has no registered' .
                'listeners';
    }
    
    function testsendMessage3()
    {
        $a = new hasHandleMessageDefault;
        $res = $this->_msgserver->registerListener(6, $a);
        $this->assertSame(true, $res, 'registration of 6 failed');
        $res = $this->_msgserver->catchMessage(6, 7);
        $this->assertSame(true, $res, 'catchmessage of 7 failed');
        $res = $this->_msgserver->sendMessage(5, 5);
        $this->assertSame(true, $res, 'sendmessage should work');
        $this->assertEquals('msgserver_notice', get_class($this->_caught), 'not notice');
        $res = $this->_caught;
        $b = 'No Listeners registered for ' .
                'message type "5"';
    }
    
    function testsendMessage4()
    {
        $res = $this->_msgserver->registerListener(6, $this);
        $this->assertSame(true, $res, 'registration of 6 failed');
        $res = $this->_msgserver->catchMessage(6, 7, '_catch3');
        $this->assertSame(true, $res, 'catchmessage of 7 failed');
        $this->_message = array();
        $res = $this->_msgserver->sendMessage(7, 'hello');
        $this->assertSame(true, $res, 'sendmessage should work');
        $this->assertSame(false, $this->_caught, 'errors shouldn\'t be thrown '.(is_object($this->_caught)?$this->_caught->getMessage():''));
        $this->assertEquals(array(array(7, 'hello')), $this->_message, 'message not heard');
    }
    
    function testsendMessageGetAnswer1()
    {
        $res = $this->_msgserver->sendMessageGetAnswer(5, 5);
        $this->assertEquals(array(), $res, 'sendmessage should work');
        $this->assertEquals('msgserver_notice', get_class($this->_caught), 'not notice');
        $res = $this->_caught;
        $b = 'No registered listeners for ' .
                'any message, use registerListener() first';
    }
    
    function testsendMessageGetAnswer2()
    {
        $a = new noHandleMessage;
        $res = $this->_msgserver->registerListener(6, $a);
        $this->assertSame(true, $res, 'registration of other failed');
        $res = $this->_msgserver->sendMessageGetAnswer(5, 5);
        $this->assertEquals(array(), $res, 'sendmessage should work');
        $this->assertEquals('msgserver_notice', get_class($this->_caught), 'not notice');
        $res = $this->_caught;
        $b = 'Message "5" has no registered' .
                'listeners';
    }
    
    function testsendMessageGetAnswer3()
    {
        $a = new hasHandleMessageDefault;
        $res = $this->_msgserver->registerListener(6, $a);
        $this->assertSame(true, $res, 'registration of 6 failed');
        $res = $this->_msgserver->catchMessage(6, 7);
        $this->assertSame(true, $res, 'catchmessage of 7 failed');
        $res = $this->_msgserver->sendMessageGetAnswer(5, 5);
        $this->assertEquals(array(), $res, 'sendmessage should work');
        $this->assertEquals('msgserver_notice', get_class($this->_caught), 'not notice');
        $res = $this->_caught;
        $b = 'No Listeners registered for ' .
                'message type "5"';
    }
    
    function testsendMessageGetAnswer4()
    {
        $res = $this->_msgserver->registerListener(6, $this);
        $this->assertSame(true, $res, 'registration of 6 failed');
        $res = $this->_msgserver->catchMessage(6, 7, '_catch3');
        $this->assertSame(true, $res, 'catchmessage of 7 failed');
        $this->_message = array();
        $res = $this->_msgserver->sendMessageGetAnswer(7, 'hello');
        $this->assertEquals(array(), $res, 'sendmessage should work');
        $this->assertSame(false, $this->_caught, 'errors shouldn\'t be thrown '.(is_object($this->_caught)?$this->_caught->getMessage():''));
        $this->assertEquals(array(array(7, 'hello')), $this->_message, 'message not heard');
    }
    
    function testsendMessageGetAnswer5()
    {
        $res = $this->_msgserver->registerListener(6, $this);
        $this->assertSame(true, $res, 'registration of 6 failed');
        $res = $this->_msgserver->catchMessage(6, 7, '_catch4');
        $this->assertSame(true, $res, 'catchmessage of 7 failed');
        $this->_message = array();
        $res = $this->_msgserver->sendMessageGetAnswer(7, 'hello');
        $this->assertEquals(array(6 => 'hi to you too'), $res, 'sendmessage should work');
        $this->assertSame(false, $this->_caught, 'errors shouldn\'t be thrown '.(is_object($this->_caught)?$this->_caught->getMessage():''));
        $this->assertEquals(array(array(7, 'hello')), $this->_message, 'message not heard');
    }
}

?>