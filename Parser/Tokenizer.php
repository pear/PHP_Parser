<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors:  nobody <nobody@localhost>                                  |
// +----------------------------------------------------------------------+
//
// $Id$
//

// global map array which is used if the tokenizer items are number
// differently than the compiled 

$GLOBALS['_PHP_PARSER_TOKENIZER']['map'] = null;

/**
* The tokenizer wrapper for parser - implements the 'standard?' yylex interface
*
* 2 main methods:
*  <ul>
*   <li>constructor, which takes the data to parse 
*     calls php's internal tokenizer, then tidies up the array
*     a little (key=>value) rather than mixed type.</li>
*   <li>advance, which returns true while tokens are available
*       - sets {@link $value}
*       - sets {@link $token}
*   </li>
*   <li>parseError, which returns a string to appear on parser error messages.
*       (could also display some of the code that has an error)
*   </li>
*
* uses a few flags like:
*   - {@link $line} - current line number
*   - {@link $pos} - current token id
*   - {@link $N} - total no. of tokens
* @version    $Id$
*/

class PHP_Parser_Tokenizer {
    
         
    /**
    * Debugging on/off
    *
    * @var boolean
    * @access public
    */
    var $debug = false;
    /**
    * Tokens - array of all the tokens.
    *
    * @var array
    * @access public
    */
    var $tokens;
    /**
    * Total Number of tokens.
    *
    * @var int
    * @access public
    */
    var $N = 0;
    /**
    * Current line.
    *
    * @var int
    * @access public
    */
    var $line;
    /**
    * Current token position.
    *
    * @var int
    * @access public
    */
    var $pos = -1;
    /**
    * The current token (either a ord(';') or token numer - see php tokenizer.
    *
    * @var int
    * @access public
    */ 
    
    var $token;
    
    /**
    * The value associated with a token - eg. for T_STRING it's the string 
    *
    * @var string
    * @access public
    */ 
    
    var $value;
     
    /**
    * ID of the last Comment Token 
    *
    * @var int
    * @access public
    */ 
    
    var $lastCommentToken; 
     
    /**
    * ID of the last Comment Token 
    *
    * @var int
    * @access public
    */ 
    
    var $lastCommentLine; 
    
    /**
    * The string of the last Comment Token
    *
    * @var string
    * @access public
    */ 
    
    var $lastComment;
    
    /**
     * String of global variable to search for
     *
     * phpDocumentor-specific usage, extracted from
     * documentation's @global tag
     * @var string
     * @access private
     */
    var $_globalSearch = false;
    
    /**
     * Tokenizing options
     * @access private
     */
    var $_options;
    
    /**
    * Constructor
    *
    * Load the tokenizer - with a string to tokenize.
    * tidies up array, sets vars pos, line, N and tokens
    * 
    * @param   string PHP code to serialize
    * 
    *
    * @return   none
    * @access   public
    */
  
    
    function PHP_Parser_Tokenizer($data, $options = array()) 
    {
        $this->_options['documentationParser'] =
        $this->_options['publishAllDocumentation'] =
        $this->_options['publisher'] =
        $this->_options['publishMethod'] =
        $this->_options['publishMessageClass'] =
        $this->_options['publishDocumentation'] =
        $this->_options['publishDocumentationMessage'] =
        false;
        $this->_options = array_merge($this->_options, $options);
        if (!class_exists($this->_options['methodContainer'])) {
            $this->_options['documentationContainer'] = false;
        }
        if (!is_object($this->_options['documentationParser'])) {
            $this->_options['documentationParser'] = false;
        } else {
            $this->_options['documentationParser'] = &$options['documentationParser'];
            // make sure it's an exact match
        }
        if (!is_object($this->_options['publisher'])) {
            $this->_options['publisher'] = false;
            $this->_options['publishAllDocumentation'] = false;
        } else {
            if (!method_exists($this->_options['publisher'], $this->_options['publishMethod'])) {
                $this->_options['publishMethod'] = false;
                if (!method_exists($this->_options['publisher'], 'publish')) {
                    $this->_options['publisher'] = false;
                    $this->_options['publishAllDocumentation'] = false;
                } else {
                    $this->_options['publishMethod'] = 'publish';
                }
            } else {
                if (!class_exists($this->_options['publishMessageClass'])) {
                    $this->_options['publishMessageClass'] = false;
                }
            }
        }
        $this->tokens = token_get_all($data);
        $this->N = count($this->tokens);
        for ($i=0;$i<$this->N;$i++) {
            if (!is_array($this->tokens[$i])) {
                $this->tokens[$i] = array(ord($this->tokens[$i]),$this->tokens[$i]);
            }
        }
        $this->pos = -1;
        $this->line = 1;
        if ($GLOBALS['_PHP_PARSER_TOKENIZER']['map'] == null) {
            $this->buildMap();
        }
        
    }
    
    /**
     * @param MsgServer_Msg
     */
    function handleMessage($msg)
    {
        if ($msg->getMsg() == 'find global') {
            $this->_setGlobalSearch($msg->getData());
        }
    }
    
    /**
     * @param string
     * @access private
     */
    function _setGlobalSearch($var)
    {
        $this->_globalSearch = $var;
    }
    
    /**
     * Compare global variable to search value, to see if we've
     * found a variable that must be documented
     * @param string global variable found in source code
     */
    function globalSearch($var)
    {
        if ($this->_globalSearch) {
            $ret = $var == $this->_globalSearch;
            if ($ret) {
                $this->_globalSearch = false;
            }
            return $ret;
        } else {
            return false;
        }
    }
    
    /**
    * get the last comment block (and reset it)
    *
    * 
    *
    * @return   array  ($commmentstring and $tokenPosition)
    * @access   public
    */
    
    function getLastComment()
    {
        $com = $this->lastComment;
        $tok = $this->lastCommentToken;
        $line = $this->lastCommentLine;
        $this->lastComment = '';
        $this->lastCommentToken = -1;
        $this->lastCommentLine = -1;
       
        return array($com, $tok, $line);
    }
    
    /**
     * Helper function for advance(), parses and publishes doc
     * comments as necessary
     * @access private
     */
    function _handleDocumentation()
    {
        $this->lastComment = $this->tokens[$this->pos][1];
        $this->lastCommentLine = $this->line;
        $this->lastCommentToken = $this->pos;
        if ($this->_options['documentationParser']) {
            $parser = &$this->_options['documentationParser'];
            $this->lastComment = $parser->parse($this->lastComment,
                                                $this->lastCommentLine,
                                                $this->lastCommentToken);
        }
        if ($this->_options['publishAllDocumentation']) {
            $publish = $this->_options['publishMethod'];
            $message = 'documentation';
            if ($this->_options['publishDocumentationMessage']) {
                $message = $this->_options['publishDocumentationMessage'];
            }
            if ($this->_options['publishMessageClass']) {
                $pc = $this->_options['publishMessageClass'];
                $publisher = $this->_options['publisher'];
                $message = new $pc($message, $this->lastComment);
                $publisher->$publish($pc);
            } else {
                $publisher = $this->_options['publisher'];
                $publisher->$publish($message, $this->lastComment);
            }
        }
    }


    /**
    * The main advance call required by the parser 
    *
    * return true if a token is available, false if no more are available.
    * skips stuff that is not a valid token
    * stores lastcomment, lastcommenttoken
    * 
    *
    * @return   boolean - true = have tokens
    * @access   public 
    */
  
    
    function advance() 
    {
        $this->pos++;
        while ($this->pos < $this->N) { 
            
            if ($this->debug) {
                echo token_name($this->tokens[$this->pos][0]). '(' .
                (isset($GLOBALS['_PHP_PARSER']['yyName'][$GLOBALS['_PHP_PARSER_TOKENIZER']['map'][$this->tokens[$this->pos][0]]]) ?
                $GLOBALS['_PHP_PARSER']['yyName'][$GLOBALS['_PHP_PARSER_TOKENIZER']['map'][$this->tokens[$this->pos][0]]] :
                $GLOBALS['_PHP_PARSER']['yyName'][$this->tokens[$this->pos][0]])
                .')' ." : {$this->tokens[$this->pos][1]}\n";
            }
            static $T_DOC_COMMENT = false;
            
            if (!$T_DOC_COMMENT) {
                $T_DOC_COMMENT = defined('T_DOC_COMMENT') ? constant('T_DOC_COMMENT') : 10000;
            }
            
            switch ($this->tokens[$this->pos][0]) {
            
            
                // simple ignore tags.
               
                case T_CLOSE_TAG:
                case T_OPEN_TAG_WITH_ECHO:
                    $this->pos++;
                    continue;
                
                // comments - store for phpdoc
                case $T_DOC_COMMENT;
                
                
                case T_COMMENT:
                    $this->lastComment = '';
                    $this->lastCommentToken = -1;
                    $this->lastCommentLine = -1;
                    if (substr($this->tokens[$this->pos][1],0,2) == '/*') {
                        $this->_handleDocumentation();
                    }
                    $this->line += substr_count ($this->tokens[$this->pos][1], "\n");
                    $this->pos++;
                    continue;
                    
                case $T_DOC_COMMENT;
                    $this->_handleDocumentation();
                // ... continues into m/l skipeed tags..
                
                // large 
                case T_OPEN_TAG:
                case T_INLINE_HTML:
                case T_WHITESPACE:
                case T_ENCAPSED_AND_WHITESPACE:
                    $this->line += substr_count ($this->tokens[$this->pos][1], "\n");
                    $this->pos++;
                    continue;
                
                //--- begin returnable values--
                
                // end statement - clear any comment details.
                case 59; // ord(';'):
                    $this->lastComment = '';
                    $this->lastCommentToken = -1;
                    
                // everything else!
                default:
                    $this->line += substr_count ($this->tokens[$this->pos][1], "\n");
                    
                    $this->token = $this->tokens[$this->pos][0];
                    $this->value = $this->tokens[$this->pos][1];
                    
                    // map token to something else if the tokenizer doesnt return the same numbers as the 
                    // parser does not match the numbers defined in parser.jay..
                    
                    if ($GLOBALS['_PHP_PARSER_TOKENIZER']['map'] && isset($GLOBALS['_PHP_PARSER_TOKENIZER']['map'][$this->token])) {
                        $this->token = $GLOBALS['_PHP_PARSER_TOKENIZER']['map'][$this->token];
                    }
                    
                    return true;
            }
        }
        //echo "END OF FILE?";
        return false;
        
    }
    /**
    * return something useful, when a parse error occurs.
    *
    * used to build error messages if the parser fails, and needs to know the line number..
    *
    * @return   string 
    * @access   public 
    */
    function parseError() 
    {
        return "Error at line {$this->line}";
        
    }
    /**
    * build a map if the token arrays do not match.
    *
    *
    * @return   none
    * @access   public 
    */
    function buildMap() 
    {
        if ($GLOBALS['_PHP_PARSER_TOKENIZER']['map'] !== null) {
            return;
        }
        require_once 'PHP/Parser/Core.php';
        $start = (token_name(257) == 'UNKNOWN') ? 258 : 257;
        
        $map = array();
        $hash = @array_flip($GLOBALS['_PHP_PARSER']['yyName']);
        for ($i=$start;$i< count($GLOBALS['_PHP_PARSER']['yyName']) + $start - 257;$i++) {
            $lt = token_name($i);
            $lt = ($i - ($start - 257) == 350 && $lt == 'UNKNOWN') ? 'T_INTERFACE' : $lt;
            $lt = ($i - ($start - 257) == 352 && $lt == 'UNKNOWN') ? 'T_IMPLEMENTS' : $lt;
            $lt = ($lt == 'T_DOUBLE_COLON') ?  'T_PAAMAYIM_NEKUDOTAYIM' : $lt;
//            echo "$lt has hash? ".$hash[$lt]."\n";
//            continue;
            
            //echo "compare $lt with {$tokens[$i]}\n";
            if ($GLOBALS['_PHP_PARSER']['yyName'][$i] != $lt) {
                $map[$i] = $hash[$lt];
            }
            
        }
//        exit;
        //print_r($map);
        // set the map to false if nothing in there.
        $GLOBALS['_PHP_PARSER_TOKENIZER']['map'] = (count($map) ? $map : false);
    }
    
}
?>
