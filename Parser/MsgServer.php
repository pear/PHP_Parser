<?php
/**
 * @package PHP_Parser
 */
/**
 * Error handling
 */
require_once 'PHP/Parser/Stack.php';
/**
 * Used for singleton server
 * @global array $GLOBALS['_PHP_PARSER_MSGSERVER_INSTANCE']
 */
$GLOBALS['_PHP_PARSER_PHP_PARSER_MSGSERVER_INSTANCE'] = null;

/**#@+
 * Error constants
 */
define('PHP_PARSER_MSGSERVER_ERR_BAD_UNIQUE_ID', 1);
define('PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED', 2);
define('PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT', 3);
define('PHP_PARSER_MSGSERVER_ERR_UNIQUEID_ALREADY_REGISTERED', 4);
define('PHP_PARSER_MSGSERVER_ERR_NO_LISTENERS', 5);
define('PHP_PARSER_MSGSERVER_ERR_NOT_LISTENING', 6);
define('PHP_PARSER_MSGSERVER_ERR_NONE_REGISTERED', 7);
define('PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED_YET', 8);
define('PHP_PARSER_MSGSERVER_ERR_HANDLER_DOESNT_EXIST', 9);
define('PHP_PARSER_MSGSERVER_ERR_NO_CATCHERS', 10);
/**#@-*/

/**
 * Inter-process Message Server
 *
 * This Message Server separates programming logic to allow
 * dynamic extension of a package without any need to modify
 * the original source code whatsoever
 *
 * @author Gregory Beaver
 * @author Joshua Eichorn, API discussion
 * @package PHP_Parser
 */
class PHP_Parser_MsgServer
{
    /**
     * Stores the mapping of unique ID to object reference
     * @var array
     * @access private
     */
    var $_ref_store = array();
    /**
     * Stores the mapping of message ID to listeners
     * @var array
     * @access private
     */
    var $_reg_store = array();

    /**
     * Generate a Unique ID for a listener
     * @return integer Unique ID
     */
    function getUniqueId()
    {
        $a = count($this->_ref_store);
        while(in_array($a, $this->_ref_store)) {
            $a++;
        }
        return $a;
    }

    /**
     * Retrieve the Global Message Server
     * @static
     * @return PHP_Parser_MsgServer
     */
    function &singleton()
    {
        if (!isset($GLOBALS['_PHP_PARSER_MSGSERVER_INSTANCE'])) {
            $GLOBALS['_PHP_PARSER_MSGSERVER_INSTANCE'] = &new PHP_Parser_MsgServer;
        }
        return $GLOBALS['_PHP_PARSER_MSGSERVER_INSTANCE'];
    }
    
    /**
     * Either unset all listeners, or all messages listened to
     * by a particular unique ID.
     * @param string|integer If passed, this instructs _unregisterAll
     *                       to dissociate this class ID with the
     *                       messages it listens to
     * @access private
     * @throws PHP_PARSER_MSGSERVER_ERR_BAD_UNIQUE_ID unique ID is
     *    neither an integer or string
     * @throws PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED object referenced
     *    by the unique ID has not registered as a listener
     * @return true|exception
     */
    function _unregisterAll($unique_id = false)
    {
        if ($unique_id !== false) {
            // $unique_id must be an integer or string
            if (!is_int($unique_id) && !is_string($unique_id)) {
                return PHP_Parser_Stack::staticPush(
                            'PHP_Parser_MsgServer',
                            PHP_PARSER_MSGSERVER_ERR_BAD_UNIQUE_ID,
                            'exception',
                            array(
                                'type' => gettype($unique_id)));
            }
            if (!isset($this->_ref_store[$unique_id])) {
                PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED,
                     'warning',
                    array('id' => $unique_id));
                return true;
            }
            unset($this->_ref_store[$unique_id]);
            $reg = array();
            foreach($this->_reg_store as $message_type => $stuff) {
                foreach($stuff as $id => $unused) {
                    if ($id === $unique_id) {
                        unset($this->_reg_store[$message_type][$id]);
                        continue 2;
                    }
                }
                if (count($this->_reg_store[$message_type])) {
                    $reg[$message_type] = $this->_reg_store[$message_type];
                }
            }
            $this->_reg_store = $reg;
        } else
        {
            $this->_reg_store = array();
            $this->_ref_store = array();
        }
        return true;
    }
    
    /**
     * Unregister a single Message Listener
     * @param string|int unique identifier of class to unregister
     * @return true|exception
     */
    function unRegisterId($unique_id)
    {
        return $this->_unregisterAll($unique_id);
    }
    
    /**
     * Unregister several Message Listeners at once
     * @param array array of class identifiers to unregister
     * @throws PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT unique ID is
     *    neither a string nor an integer
     * @return true|exception
     */
    function unRegisterIds($unique_ids)
    {
        if (!is_array($unique_ids)) {
            return PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT,
                    'exception',
                    array(
                        'param' => '$unique_ids',
                        'type1' => 'array', 
                        'type2' => gettype($unique_ids)));
        }
        foreach($unique_ids as $id) {
            $result = $this->_unregisterAll($id);
            if (PHP_Parser_Stack::staticHasErrors()) {
                return $result;
            }
        }
        return true;
    }

    /**
     * Register a new Message Listener
     *
     * A Message Listener is any object.  To catch particular messages, use {@link catchMessage()}
     * @param object any object that implements the handleMessage() method
     * @param string|int unique identifier for this class
     * @throws PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT if either the
     *    unique ID isn't a string/integer or $obj isn't an object
     * @throws PHP_PARSER_MSGSERVER_ERR_UNIQUEID_ALREADY_REGISTERED if
     *    the unique ID has already been assigned to another object
     * @return string|integer|exception Returns the Unique ID or an exception
     */
    function registerListener(&$obj, $unique_id = false)
    {
        if ($unique_id === false) {
            $unique_id = $this->getUniqueId();
        }
        // $obj must be an object
        if (!is_object($obj)) {
            return PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT,
                    'exception',
                    array(
                        'param' => '$obj',
                        'type1' => 'object',
                        'type2' => gettype($obj)));
        }
        // $unique_id must be an integer or string
        if (!is_int($unique_id) && !is_string($unique_id)) {
            return PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_BAD_UNIQUE_ID,
                    'exception',
                    array('type' => gettype($unique_id)));
        }
        // $unique_id must indeed be unique 
        if (count($this->_ref_store) &&
              in_array($unique_id, array_keys($this->_ref_store))) {
            return PHP_Parser_Stack::staticPush(
                'PHP_Parser_MsgServer',
                PHP_PARSER_MSGSERVER_ERR_UNIQUEID_ALREADY_REGISTERED,
                'error',
                array('id' => $unique_id . ''));
        }
        $this->_ref_store[$unique_id] =& $obj;
        return $unique_id;
    }
    
    /**
     * Determine whether a unique ID has been registered
     *
     * This method may be used to eliminate notices from {@link sendMessage()},
     * or to ensure that an ID to be used is indeed unique.
     * @param integer|string identifier to look up
     * @return boolean true if ID is registered
     * @throws PHP_PARSER_MSGSERVER_ERR_BAD_UNIQUE_ID if the Unique ID
     *    is neither a string nor an array
     */
    function listenerRegistered($unique_id)
    {
        // $unique_id must be an integer or string
        if (!is_int($unique_id) && !is_string($unique_id)) {
            return PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_BAD_UNIQUE_ID,
                    'error',
                    array('type' => gettype($unique_id)));
        }
        return isset($this->_ref_store[$unique_id]);
    }
    
    /**
     * Determine whether a message type has been registered
     *
     * This method may be used to eliminate notices from {@link sendMessage()}
     * 
     * @param integer|string message type to look up
     * @return boolean|exception true if listeners are listening for this message type
     * @throws PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT if the Message
     *    type is neither a string nor an array
     */
    function messageRegistered($message_type)
    {
        if (!is_string($message_type) && !is_integer($message_type)) {
            return PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT,
                    'exception',
                    array(
                        'param' => '$message_type',
                        'type1' => 'integer|string',
                        'type2' => gettype($message_type)));
        }
        return isset($this->_reg_store[$message_type]);
    }

    /**
     * Remove all Listening to a message type
     * @param int|string message type to stop listening for
     * @return true|exception
     * @throws PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT if the Message
     *      type is neither a string nor an integer
     * @throws PHP_PARSER_MSGSERVER_ERR_NO_LISTENERS if there isn't
     *      any registered listener listening for this message type
     */
    function stopCatchingMessage($message_type)
    {
        if (!is_int($message_type) && !is_string($message_type)) {
            return PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT,
                    'exception',
                    array(
                        'param' => '$messagetype',
                        'type1' => 'string|integer',
                        'type2' => gettype($message_type)));
        }
        if (!isset($this->_reg_store[$message_type])) {
            PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_NO_LISTENERS,
                    'notice',
                    array('type' => $message_type));
        }
        unset($this->_reg_store[$message_type]);
        return true;
    }

    /**
     * Remove selected Message Listeners from a message type
     * @param int|string message type to stop listening for
     * @param array list of each id that should stop listening for message
     *        $message_type
     * @throws PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT if Message Type
     *      is not a string/integer, or $unique_ids is not an array
     * @throws PHP_PARSER_MSGSERVER_ERR_BAD_UNIQUE_ID one of the
     *      Unique ids is not a string or integer
     * @throws PHP_PARSER_MSGSERVER_ERR_NO_LISTENERS if there are no
     *      registered listeners for this Message Type
     * @throws PHP_PARSER_MSGSERVER_ERR_NOT_LISTENING if any of the
     *      unique IDs passed are not listening to this message
     * @return true|exception
     */
    function stopCatchingMessages($message_type, $unique_ids)
    {
        if (!is_int($message_type) && !is_string($message_type)) {
            return PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT,
                    'exception',
                    array(
                    'param' => '$message_type',
                    'type1' => 'string|integer',
                    'type2' => gettype($message_type)));
        }
        if (!isset($this->_reg_store[$message_type])) {
            PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_NO_LISTENERS,
                    'notice',
                    array('type' => $message_type));
            return true;
        }
        if (!is_array($unique_ids)) {
            return PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT,
                    'exception',
                    array(
                        'param' => '$unique_ids',
                        'type1' => 'array',
                        'type2' => gettype($unique_ids)));
        }
        foreach($unique_ids as $id) {
            if (!is_int($id) && !is_string($id)) {
                return PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_BAD_UNIQUE_ID,
                    'exception',
                    array('type' => gettype($id)));
            }
            if (!isset($this->_reg_store[$message_type][$id])) {
                PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_NOT_LISTENING,
                    'notice',
                    array('listener' => $id, 'message' => $message_type));
            }
            unset($this->_reg_store[$message_type][$id]);
        }
        if (!count($this->_reg_store[$message_type])) {
            unset($this->_reg_store[$message_type]);
        }
        return true;
    }
    
    /**
     *
     * @param string|int unique identifier for this class
     * @param string|int message type to catch for a registered listener
     * @throws PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT if Message Type
     *      is not a string or integer
     * @throws PHP_PARSER_MSGSERVER_ERR_NONE_REGISTERED if no
     *      listeners have been registered yet
     * @throws PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED_YET if the
     *      Unique ID has not been registered yet
     * @throws PHP_PARSER_MSGSERVER_ERR_HANDLER_DOESNT_EXIST if the
     *      Error handler specified by $handle_method isn't a method of the
     *      class
     * @return true|exception
     */
    function catchMessage($unique_id, $message_type, $handle_method = false)
    {
        // no items can receive
        if (!count($this->_ref_store)) {
            return PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_NONE_REGISTERED,
                    'exception');
        }
        // unique id must be a pre-registered object
        if (!in_array($unique_id, array_keys($this->_ref_store))) {
            return PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED_YET,
                    'exception',
                    array('id' => $unique_id));
        }
        // $message_type must be an integer or string
        if (!is_int($message_type) && !is_string($message_type)) {
            return PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT,
                    'exception',
                    array(
                        'param' => '$message_type',
                        'type1' => 'string|integer',
                        'type2' => gettype($message_type)));
        }
        if (!$handle_method) {
            $handle_method = 'handleMessage';
        }
        if (!method_exists($this->_ref_store[$unique_id], $handle_method)) {
            return PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_HANDLER_DOESNT_EXIST,
                    'exception',
                    array(
                        'handler' => $handle_method,
                        'listener' => $unique_id,
                        'class' => get_class($this->_ref_store[$unique_id])));
        }
        $this->_reg_store[$message_type][$unique_id] = array('id' => $unique_id,
            'method' => $handle_method);
        return true;
    }

    /**
     * Send a message to all listeners
     *
     * Every listener who is registered to receive messages of type $messagetype
     * will have its reciving method called with the message and the message
     * type
     *
     * To get a return value from the listeners, use
     * {@link sendMessageGetAnswer()}
     * @param string|integer message type, used to find listeners
     * @param mixed message to pass to listening objects
     * @return true|exception
     * @throws PHP_PARSER_MSGSERVER_ERR_NO_CATCHERS if there are no
     *      registered listeners for any message
     * @throws PHP_PARSER_MSGSERVER_ERR_NONE_REGISTERED if there are no
     *      registered listeners
     * @throws PHP_PARSER_MSGSERVER_ERR_NO_LISTENERS if there are no
     *      registered listeners for message $messagetype
     */
    function sendMessage($messagetype, $message)
    {
        // no message listeners registered
        if (!count($this->_ref_store)) {
            PHP_Parser_Stack::staticPush(
                'PHP_Parser_MsgServer',
                PHP_PARSER_MSGSERVER_ERR_NONE_REGISTERED,
                'notice');
            return true;
        }
        // no messages are caught
        if (!count($this->_reg_store)) {
            PHP_Parser_Stack::staticPush(
                'PHP_Parser_MsgServer',
                PHP_PARSER_MSGSERVER_ERR_NO_CATCHERS,
                'notice',
                array('message' => $messagetype));
            return true;
        }
        // no listeners to this message
        if (!isset($this->_reg_store[$messagetype])) {
            PHP_Parser_Stack::staticPush(
                'PHP_Parser_MsgServer',
                PHP_PARSER_MSGSERVER_ERR_NO_LISTENERS,
                'exception',
                array('type' => $messagetype));
            return true;
        }
        foreach($this->_reg_store[$messagetype] as $val)
        {
            // verification of handler existence is in catchMessage()
            $handler = $val['method'];
            $this->_ref_store[$val['id']]->$handler($messagetype, $message);
        }
        return true;
    }
    

    /**
     * @param string|integer message type, used to find listeners
     * @param mixed message to pass to listening objects
     * @return bool|array|exception returns either true to indicate lack of any
     *         listeners, false to indicate invalid parameters, or an array
     *         of data returned from listening objects.  It is up to the sender to
     *         process returned data.
     */
    function sendMessageGetAnswer($messagetype, $message)
    {
        // no message listeners registered
        if (!count($this->_ref_store)) {
            PHP_Parser_Stack::staticPush(
                    'PHP_Parser_MsgServer',
                    PHP_PARSER_MSGSERVER_ERR_NONE_REGISTERED,
                    'notice');
            return array();
        }
        // no messages are caught
        if (!count($this->_reg_store)) {
            PHP_Parser_Stack::staticPush(
                'PHP_Parser_MsgServer',
                PHP_PARSER_MSGSERVER_ERR_NO_CATCHERS,
                'notice',
                array('message' => $messagetype));
            return array();
        }
        // no listeners to this message
        if (!isset($this->_reg_store[$messagetype])) {
            PHP_Parser_Stack::staticPush(
                'PHP_Parser_MsgServer',
                PHP_PARSER_MSGSERVER_ERR_NO_LISTENERS,
                'notice',
                array('type' => $messagetype));
            return array();
        }
        $return = array();
        foreach($this->_reg_store[$messagetype] as $val)
        {
            // verification of handler existence is in catchMessage()
            $handler = $val['method'];
            $ret = $this->_ref_store[$val['id']]->$handler($messagetype, $message);
            if (isset($ret)) $return[$val['id']] = $ret;
        }
        return $return;
    }
}
$_PHP_Parser_a = &PHP_Parser_Stack::singleton('PHP_Parser_MsgServer');
$_PHP_Parser_a->setErrorMessageTemplate(
            array(
             PHP_PARSER_MSGSERVER_ERR_BAD_UNIQUE_ID => 'Unique ID must be string or integer,' .
                ' not %type%',
             PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED => 'Unique ID "%id%" is not a registered ' .
                'listener for any messages',
             PHP_PARSER_MSGSERVER_ERR_INVALID_INPUT => 'Invalid parameter passed to %param%, ' .
                'should be type "%type1%", is "%type2%"',
             PHP_PARSER_MSGSERVER_ERR_UNIQUEID_ALREADY_REGISTERED => 'Unique ID "%id%" is ' .
                'already registered',
             PHP_PARSER_MSGSERVER_ERR_NO_LISTENERS => 'No Listeners registered for ' .
                'message type "%type%"',
             PHP_PARSER_MSGSERVER_ERR_NOT_LISTENING => 'Listener "%listener%" is not listening ' .
                'to message "%message%"',
             PHP_PARSER_MSGSERVER_ERR_NONE_REGISTERED => 'No registered listeners for ' .
                'any message, use registerListener() first',
             PHP_PARSER_MSGSERVER_ERR_NOT_REGISTERED_YET => 'Unique ID "%id%" is not a ' .
                'registered listener, use registerListener() first',
             PHP_PARSER_MSGSERVER_ERR_HANDLER_DOESNT_EXIST => 'Message handler method ' .
                '"%handler%" doesn\'t exist for listener "%listener%", class "%class%"',
             PHP_PARSER_MSGSERVER_ERR_NO_CATCHERS => 'Message "%message%" has no registered' .
                'listeners',
                ));
?>