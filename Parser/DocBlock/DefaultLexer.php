<?php
//
// +----------------------------------------------------------------------+
// | PHP_Parser                                                           |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Greg Beaver <cellog@php.net>                                |
// +----------------------------------------------------------------------+
//
// $Id$
//
require_once 'PEAR/ErrorStack.php';
define('PHP_Parser_DocBlock_DefaultLexer_ERROR', 1);
/* the tokenizer states */
define('YYINITIAL',0);
define('POSTNEWLINE',1);
define('CHECKINLINE',2);
define('INLINETAG',3);
define('INLINEINTERNALTAG',4);
define('SIMPLELIST',5);
define('INTERNALSIMPLELIST',6);
define('TAGS',7);
define('INTAG',8);
define('INLINETAGNAME',9);
define('INCODE',10);
define('INPRE',11);
define('LIST_NUMBERED',0);
define('LIST_NUMBERED_DOT',1);
define('LIST_UNORDERED',2);
define('PHP_PARSER_DOCLEX_ERROR_LEX', 1);
define('PHP_PARSER_DOCLEX_ERROR_NUMWRONG', -1);
define('PHP_PARSER_DOCLEX_ERROR_NODOT', -2);
$a = 0;
define('PHP_PARSER_DOCLEX_BULLET', ++$a); // unordered '-' list item bullet
define('PHP_PARSER_DOCLEX_NBULLET', ++$a); // numbered '1' list number bullet
define('PHP_PARSER_DOCLEX_NDBULLET', ++$a); // numbered '1.' list number bullet
define('PHP_PARSER_DOCLEX_SIMPLELIST', ++$a); // simple list item text
define('PHP_PARSER_DOCLEX_SIMPLELIST_NL', ++$a); // newline character
define('PHP_PARSER_DOCLEX_SIMPLELIST_END', ++$a); // end of a simplelist (empty string)
define('PHP_PARSER_DOCLEX_SIMPLELIST_START', ++$a); // start of a nested simplelist (empty string)
define('PHP_PARSER_DOCLEX_WHITESPACE', ++$a); // whitespace before a bullet in a simple list
define('PHP_PARSER_DOCLEX_NESTEDLIST', ++$a); // start of a nested list
define('PHP_PARSER_DOCLEX_OPEN_P', ++$a); // open <p>
define('PHP_PARSER_DOCLEX_OPEN_LIST', ++$a); // open <ol>/<ul>
define('PHP_PARSER_DOCLEX_OPEN_LI', ++$a); // open <li>
define('PHP_PARSER_DOCLEX_OPEN_CODE', ++$a); // open <code>
define('PHP_PARSER_DOCLEX_OPEN_PRE', ++$a); // open <pre>
define('PHP_PARSER_DOCLEX_OPEN_B', ++$a); // open <b>/<strong>
define('PHP_PARSER_DOCLEX_OPEN_I', ++$a); // open <i>/<em>
define('PHP_PARSER_DOCLEX_OPEN_KBD', ++$a); // open <kbd>
define('PHP_PARSER_DOCLEX_OPEN_VAR', ++$a); // open <var>
define('PHP_PARSER_DOCLEX_OPEN_SAMP', ++$a); // open <samp>
define('PHP_PARSER_DOCLEX_CLOSE_P', ++$a); // close </p>
define('PHP_PARSER_DOCLEX_CLOSE_LIST', ++$a); // close </ul>/</ol>
define('PHP_PARSER_DOCLEX_CLOSE_LI', ++$a); // close </li>
define('PHP_PARSER_DOCLEX_CLOSE_CODE', ++$a); // close </code>
define('PHP_PARSER_DOCLEX_CLOSE_PRE', ++$a); // close </pre>
define('PHP_PARSER_DOCLEX_CLOSE_B', ++$a); // close </b>/</strong>
define('PHP_PARSER_DOCLEX_CLOSE_I', ++$a); // close </i>/</em>
define('PHP_PARSER_DOCLEX_CLOSE_KBD', ++$a); // close </kbd>
define('PHP_PARSER_DOCLEX_CLOSE_VAR', ++$a); // close </var>
define('PHP_PARSER_DOCLEX_CLOSE_SAMP', ++$a); // close </samp>
define('PHP_PARSER_DOCLEX_XML_TAG', ++$a); // complete <tag />
define('PHP_PARSER_DOCLEX_ESCAPED_TAG', ++$a); // escaped <<tag>> or <<tag />>
define('PHP_PARSER_DOCLEX_TEXT', ++$a); // normal text
define('PHP_PARSER_DOCLEX_INLINE_ESC', ++$a); // inline escape {@} or {@*}
define('PHP_PARSER_DOCLEX_INTERNAL', ++$a); // {@internal
define('PHP_PARSER_DOCLEX_ENDINTERNAL', ++$a); // }} ending an {@internal }}
define('PHP_PARSER_DOCLEX_DOUBLENL', ++$a); // double newline character
define('PHP_PARSER_DOCLEX_TAG', ++$a); // @tag
define('PHP_PARSER_DOCLEX_INLINE_TAG_OPEN', ++$a); // inline tag open {@
define('PHP_PARSER_DOCLEX_INLINE_TAG_CLOSE', ++$a); // inline tag close }
define('PHP_PARSER_DOCLEX_INLINE_TAG_NAME', ++$a); // inline tag name
define('PHP_PARSER_DOCLEX_INLINE_TAG_CONTENTS', ++$a); // inline tag contents
define('PHP_PARSER_DOCLEX_ENDNESTEDLIST', ++$a); // end of a nested list
define ('YY_E_INTERNAL', 0);
define ('YY_E_MATCH',  1);
define ('YY_BUFFER_SIZE', 4096);
define ('YY_F' , -1);
define ('YY_NO_STATE', -1);
define ('YY_NOT_ACCEPT' ,  0);
define ('YY_START' , 1);
define ('YY_END' , 2);
define ('YY_NO_ANCHOR' , 4);
define ('YY_BOL' , 257);
define ('YY_EOF' , 258);


class PHP_Parser_DocBlock_DefaultLexer
{

    /**
     * Tag name => token mapping
     * @var array
     * @access private
     */
    var $_tagMap =
        array(
            'open' =>
            array(
                'p' => PHP_PARSER_DOCLEX_OPEN_P,
                'ul' => PHP_PARSER_DOCLEX_OPEN_LIST,
                'ol' => PHP_PARSER_DOCLEX_OPEN_LIST,
                'li' => PHP_PARSER_DOCLEX_OPEN_LI,
                'code' => PHP_PARSER_DOCLEX_OPEN_CODE,
                'pre' => PHP_PARSER_DOCLEX_OPEN_PRE,
                'b' => PHP_PARSER_DOCLEX_OPEN_B,
                'strong' => PHP_PARSER_DOCLEX_OPEN_B,
                'i' => PHP_PARSER_DOCLEX_OPEN_I,
                'em' => PHP_PARSER_DOCLEX_OPEN_I,
                'kbd' => PHP_PARSER_DOCLEX_OPEN_KBD,
                'var' => PHP_PARSER_DOCLEX_OPEN_VAR,
                'samp' => PHP_PARSER_DOCLEX_OPEN_SAMP,
            ),
            'close' =>
            array(
                'p' => PHP_PARSER_DOCLEX_CLOSE_P,
                'ul' => PHP_PARSER_DOCLEX_CLOSE_LIST,
                'ol' => PHP_PARSER_DOCLEX_CLOSE_LIST,
                'li' => PHP_PARSER_DOCLEX_CLOSE_LI,
                'code' => PHP_PARSER_DOCLEX_CLOSE_CODE,
                'pre' => PHP_PARSER_DOCLEX_CLOSE_PRE,
                'b' => PHP_PARSER_DOCLEX_CLOSE_B,
                'strong' => PHP_PARSER_DOCLEX_CLOSE_B,
                'i' => PHP_PARSER_DOCLEX_CLOSE_I,
                'em' => PHP_PARSER_DOCLEX_CLOSE_I,
                'kbd' => PHP_PARSER_DOCLEX_CLOSE_KBD,
                'var' => PHP_PARSER_DOCLEX_CLOSE_VAR,
                'samp' => PHP_PARSER_DOCLEX_CLOSE_SAMP,
            )
        );
    /**
     * @var array
     * @access private
     */
    var $_options = array(
                    'return_internal' => true,
                    );
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
        return array("Error at line {$this->yyline}", $this->yyline);
    }
    function setOptions($options = array())
    {
        $this->_options['return_internal'] = true;
        $this->_options = array_merge($this->_options, $options);
    }
    var $_nextToken = false;
    var $_getNestedList = false;
    var $_lastNum = false;
    function saveState()
    {
        $save = get_object_vars($this);
        unset($save['yy_nxt']);
        unset($save['yy_acpt']);
        unset($save['yy_cmap']);
        unset($save['yy_rmap']);
        unset($save['_tagMap']);
        unset($save['yy_state_dtrans']);
        return $save;
    }
    function restoreState($save)
    {
        foreach ($save as $name => $value) {
            $this->$name = $value;
        }
    }
    function advance()
    {
        if ($this->_getNestedList) {
            if ($this->debug) echo "found nested list whitespace[{$this->_getNestedList[1]}]\n";
            $lex = $this->_getNestedList;
            $this->_getNestedList = false;
            $this->tokenWithWhitespace = $lex[0];
            $this->token = $lex[0];
            $this->value = $lex[1];
            $this->valueWithWhitespace = $lex[1];
            return true;
        }
        $lex = $this->yylex();
        if ($lex) {
            if ($lex[0] == PHP_PARSER_DOCLEX_TEXT) {
                $save = $this->saveState();
                do {
                    $next = $this->yylex();
                    if ($next[0] == PHP_PARSER_DOCLEX_TEXT) {
                        $save = $this->saveState();
                        $lex[1] .= $next[1];
                    }
                } while ($next && $next[0] == PHP_PARSER_DOCLEX_TEXT);
                $this->restoreState($save);
            }
            if ($lex[0] == PHP_PARSER_DOCLEX_SIMPLELIST) {
                $save = $this->saveState();
                do {
                    $next = $this->yylex();
                    if ($next[0] == PHP_PARSER_DOCLEX_SIMPLELIST) {
                        $save = $this->saveState();
                        $lex[1] .= $next[1];
                    }
                } while ($next && $next[0] == PHP_PARSER_DOCLEX_SIMPLELIST);
                $this->restoreState($save);
            }
            $this->tokenWithWhitespace = $lex[0];
            $this->token = $lex[0];
            $this->value = $lex[1];
            $this->valueWithWhitespace = $lex[1];
        } elseif ($this->yy_lexical_state == SIMPLELIST ||
            $this->yy_lexical_state == INTERNALSIMPLELIST) {
            array_pop($this->_listLevel);
            if (!count($this->_listLevel)) {
                $this->yy_lexical_state = $this->_listOriginal;
            }
            $this->token = PHP_PARSER_DOCLEX_SIMPLELIST_END;
            $this->value = '';
            return true;
        }
        return (boolean) $lex;
    }
    /**
     * (syntax) error message.
     * Can be overwritten to control message format.
     * @param message text to be displayed.
     * @param expected vector of acceptable tokens, if available.
     */
    function raiseError ($message, $code, $params)
    {
        $m = $message;
        $params = array('fatal' => $params);
        $ret = PEAR_ErrorStack::staticPush('PHP_Parser_DocBlock_DefaultLexer',
            $code,
            'error', $params,
            $m);
        return $ret;
    }
    function setup($data)
    {
        $this->PHP_Parser_DocBlock_DefaultLexer($data);
    }
    function _doList()
    {
        if ($this->_atBullet) {
            if ($this->_listType == LIST_UNORDERED) {
                $this->yy_buffer_end = $this->yy_buffer_index =
                    $this->yy_buffer_start + 1;
                if ($this->yytext() == $this->_listBullet) {
                    if ($this->debug) echo "List Item Bullet[".$this->yytext()."]\n";
                    $this->_atBullet = false;
                    $this->_lastBullet = $this->yytext();
                    $this->_lastBulletLen = $this->yylength();
                    return array(PHP_PARSER_DOCLEX_BULLET, $this->yytext());
                }
            } elseif ($this->_listType == LIST_NUMBERED) {
                $text = $this->yytext();
                $this->yy_buffer_end = $this->yy_buffer_index =
                    $this->yy_buffer_start + 1;
                // allow lists up to 999 items in length
                $num = $text{1};
                if (is_numeric($num)) {
                    $this->yy_buffer_end++;
                    $this->yy_buffer_index++;
                }
                $num = $text{2};
                if (is_numeric($num)) {
                    $this->yy_buffer_end++;
                    $this->yy_buffer_index++;
                }
                $num = $this->yytext();
                if ($num == $this->_lastNum + 1) {
                    $this->_lastNum++;
                    if ($this->debug) echo "List Item Number bullet[".$this->yytext()."]\n";
                    $this->_atBullet = false;
                    $this->_lastBulletLen = $this->yylength();
                    return array(PHP_PARSER_DOCLEX_NBULLET, $this->yytext());
                } else {
                    if ($this->debug) echo "shunting list to original state, returning dummy\n";
                    $this->raiseError("simple list number should be ".($this->_lastNum + 1)." and is [".$this->yytext()."]",
                    PHP_PARSER_DOCLEX_ERROR_NUMWRONG, false);
                    $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
                    $this->yybegin($this->_listOriginal);
                    return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
                }
            } elseif ($this->_listType == LIST_NUMBERED_DOT) {
                $text = $this->yytext();
                $this->yy_buffer_end = $this->yy_buffer_index =
                    $this->yy_buffer_start + 1;
                // allow lists up to 999 items in length
                $dot = $text{1};
                if ($dot == '.') {
                    $this->yy_buffer_end++;
                    $this->yy_buffer_index++;
                } else {
                    $dot = $text{2};
                    if ($dot == '.') {
                        $this->yy_buffer_end++;
                        $this->yy_buffer_index++;
                    } else {
                        $dot = $text{3};
                        if ($dot == '.') {
                            $this->yy_buffer_end++;
                            $this->yy_buffer_index++;
                        } else {
                            $this->raiseError("error, no dot in simple list bullet [".$this->yytext()."]",
                            PHP_PARSER_DOCLEX_ERROR_NODOT, true);
                            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
                            $this->yybegin($this->_listOriginal);
                            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
                        }
                    }
                }
                $num = str_replace('.', '', $this->yytext());
                if ($num == $this->_lastNum + 1) {
                    $this->_lastNum++;
                    if ($this->debug) echo "List Item Dotted Number bullet[".$this->yytext()."]\n";
                    $this->_atBullet = false;
                    $this->_lastBulletLen = $this->yylength();
                    return array(PHP_PARSER_DOCLEX_NDBULLET, $this->yytext());
                }
            }
        } else { // if $this->_atBullet
            if ($this->_atNewLine) {
                $this->_atNewLine = false;
                $test = ltrim($this->yytext());
                if (strlen($test)) {
                    $whitespace = substr($this->yytext(), 0, strpos($this->yytext(), $test));
                } else {
                    $whitespace = false;
                }
                $wstrlen = array_pop($this->_listLevel);
                array_push($this->_listLevel, $wstrlen);
                if (strlen($whitespace) == $wstrlen) {
                    $index = $this->yy_buffer_end - $this->yylength() + $wstrlen;
                    $this->yy_buffer_index = $index;
                    $this->yy_mark_end();
                    if ($this->debug) echo "found after newline whitespace[$whitespace]\n";
                    $this->_atBullet = true;
                    return array(PHP_PARSER_DOCLEX_WHITESPACE, $whitespace);
                } elseif (strlen($whitespace) >= ($wstrlen + $this->_lastBulletLen + 1)) {
                    if (strlen($test) && in_array($test{0}, array('-', '+', 'o', '1'))) {
                        // check for simple lists
                        $save = $this->saveState();
                        if ($this->debug) echo ">>checking next token\n";
                        $next = $this->yylex();
                        $this->restoreState($save);
                        if ((strlen($test) > 2 || !in_array($next, array(PHP_PARSER_DOCLEX_DOUBLENL, false))) &&
                            ($test{0} != '1' && ($test{1} == ' ') ||
                            ($test{0} == '1' && (($test{1} == ' ') ||
                                                 ($test{1} == '.') &&
                                                 ($test{2} == ' ' ))))) {
                            // found a nested list
                            array_push($this->_listTypeStack, $this->_listType);
                            array_push($this->_bulletLenStack, $this->_lastBulletLen);
                            switch($this->_listType) {
                                case LIST_NUMBERED_DOT :
                                case LIST_NUMBERED :
                                    array_push($this->_bulletStack, $this->_lastNum);
                                break;
                                case LIST_UNORDERED :
                                    array_push($this->_bulletStack, $this->_listBullet);
                                break;
                            }
                            if ($test{1} == '.') {
                                $this->_lastNum = 0;
                                $this->_listType = LIST_NUMBERED_DOT;
                            } else {
                                $this->_lastNum = 0;
                                if ($test{0} == '1') {
                                    $this->_listType = LIST_NUMBERED;
                                } else {
                                    $this->_listType = LIST_UNORDERED;
                                    $this->_listBullet = $test{0};
                                }
                            }
                            if ($whitespace && strlen($whitespace)) {
                                $index = $this->yy_buffer_end - $this->yylength() + strlen($whitespace);
                                $this->yy_buffer_index = $index;
                                $this->yy_mark_end();
                                $this->_atBullet = true;
                                array_push($this->_listLevel, strlen($whitespace));
                                $this->_getNestedList = array(PHP_PARSER_DOCLEX_WHITESPACE, $whitespace);
                                if ($this->debug) echo "found nested simplelist\n";
                                return array(PHP_PARSER_DOCLEX_SIMPLELIST_START, '');
                            } else {
                                array_push($this->_listLevel, 0);
                            }
                            $this->_break = true;
                            return;
                        } else {
                            return;
                        }
                    }
                    $index = $this->yy_buffer_end - $this->yylength() + ($wstrlen + $this->_lastBulletLen + 1);
                    $this->yy_buffer_index = $index;
                    $this->yy_mark_end();
                    if ($this->debug) echo "found pre-list text whitespace[$whitespace]\n";
                    return array(PHP_PARSER_DOCLEX_WHITESPACE, $whitespace);
                } else {
                    if ($this->debug) echo "going to parent list (_doList)\n";
                    array_pop($this->_listLevel);
                    if (!count($this->_listLevel)) {
                        $this->yybegin($this->_listOriginal);
                        $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
                        return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
                        $this->_break = true;
                        return;
                    } else {
                        $this->_atNewLine = true;
                        $this->_atBullet = false;
                        $this->_listType = array_pop($this->_listTypeStack);
                        switch($this->_listType) {
                            case LIST_NUMBERED_DOT :
                            case LIST_NUMBERED :
                                $this->_lastNum = array_pop($this->_bulletStack);
                                $this->_lastBulletLen = array_pop($this->_bulletLenStack);
                            break;
                            case LIST_UNORDERED :
                                $this->_listBullet = array_pop($this->_bulletStack);
                                $this->_lastBulletLen = array_pop($this->_bulletLenStack);
                            break;
                        }
                        $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
//                        $this->_break = true;
                        return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
                    }
                }
            }
            if ($this->debug) echo "1 simple list stuff [".$this->yytext()."]\n";
            return array (PHP_PARSER_DOCLEX_SIMPLELIST, $this->yytext());
        }
    }
    function _checkList($next, $whitespace, $test, $newstate, $startingstate)
    {
        if (is_array($next)) {
            $next = $next[0];
        }
        // check for simple lists
        if ((strlen($test) > 2 || !in_array($next, array(PHP_PARSER_DOCLEX_DOUBLENL, false))) &&
            ($test{0} != '1' && ($test{1} == ' ') ||
            ($test{0} == '1' && (($test{1} == ' ') ||
                                 ($test{1} == '.') &&
                                 ($test{2} == ' '))))) {
            // found one
            if ($this->debug) echo "found valid bullet\n";
            if ($test{1} == '.') {
                $this->_lastNum = 0;
                $this->_listType = LIST_NUMBERED_DOT;
            } else {
                $this->_lastNum = 0;
                if ($test{0} == '1') {
                    $this->_listType = LIST_NUMBERED;
                } else {
                    $this->_listType = LIST_UNORDERED;
                    $this->_listBullet = $test{0};
                }
            }
            if ($whitespace && strlen($whitespace)) {
                $index = $this->yy_buffer_end - $this->yylength() + strlen($whitespace);
                $this->yy_buffer_index = $index;
                $this->yy_mark_end();
                if ($this->debug) echo "found whitespace[$whitespace]\n";
                $this->_listOriginal = $this->yy_lexical_state;
                $this->_oldOriginal = $this->_original;
                $this->_original = $startingstate; // INLINEINTERNALTAG;
                $this->yybegin($newstate); //INTERNALSIMPLELIST);
                $this->_atBullet = true;
                array_push($this->_listLevel, strlen($whitespace));
                return array(PHP_PARSER_DOCLEX_WHITESPACE, $whitespace);
            } else {
                array_push($this->_listLevel, 0);
                return false;
            }
        } else {
            if ($this->debug) echo "normal text [".$this->yytext()."]\n";
            return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
        }
    }


    var $yy_reader;
    var $yy_buffer_index;
    var $yy_buffer_read;
    var $yy_buffer_start;
    var $_fatal = false;
    var $yy_buffer_end;
    var $yy_buffer;
    var $yychar;
    var $yyline;
    var $yyEndOfLine;
    var $yy_at_bol;
    var $yy_lexical_state;

    function PHP_Parser_DocBlock_DefaultLexer($data) 
    {
        $this->yy_buffer = $data;
        $this->yy_buffer_read = strlen($data);
        $this->yy_buffer_index = 0;
        $this->yy_buffer_start = 0;
        $this->yy_buffer_end = 0;
        $this->yychar = 0;
        $this->yyline = 0;
        $this->yy_at_bol = true;
        $this->yy_lexical_state = YYINITIAL;

        $this->yy_buffer = str_replace("\r", '', $this->yy_buffer);
        $this->yy_buffer_read = strlen($this->yy_buffer);
        $this->_original = YYINITIAL;
        $this->_oldOriginal = YYINITIAL;
        $this->_listOriginal = YYINITIAL;
        $this->_listLevel = array();
        $this->_atBullet = false;
        $this->_atNewLine = false;
        $this->_listTypeStack = array();
        $this->_bulletStack = array();
        $this->_bulletLenStack = array();
        $this->_break = false;
        $this->debug = false;
        $this->yyline = 1;
    }

    var $yy_state_dtrans = array  ( 
        0,
        60,
        61,
        15,
        63,
        66,
        73,
        76,
        79,
        80,
        81,
        100
    );


    function yybegin ($state)
    {
        $this->yy_lexical_state = $state;
    }



    function yy_advance ()
    {
        if ($this->yy_buffer_index < $this->yy_buffer_read) {
            return ord($this->yy_buffer{$this->yy_buffer_index++});
        }
        return YY_EOF;
    }


    function yy_move_end ()
    {
        if ($this->yy_buffer_end > $this->yy_buffer_start && 
            '\n' == $this->yy_buffer{$this->yy_buffer_end-1})
        {
            $this->yy_buffer_end--;
        }
        if ($this->yy_buffer_end > $this->yy_buffer_start &&
            '\r' == $this->yy_buffer{$this->yy_buffer_end-1})
        {
            $this->yy_buffer_end--;
        }
    }


    var $yy_last_was_cr=false;


    function yy_mark_start ()
    {
        for ($i = $this->yy_buffer_start; $i < $this->yy_buffer_index; $i++) {
            if ($this->yy_buffer{$i} == "\n" && !$this->yy_last_was_cr) {
                $this->yyline++; $this->yyEndOfLine = $this->yychar;
            }
            if ($this->yy_buffer{$i} == "\r") {
                $this->yyline++; $this->yyEndOfLine = $this->yychar;
                $this->yy_last_was_cr=true;
            } else {
                $this->yy_last_was_cr=false;
            }
        }
        $this->yychar = $this->yychar + $this->yy_buffer_index - $this->yy_buffer_start;
        $this->yy_buffer_start = $this->yy_buffer_index;
    }


    function yy_mark_end ()
    {
        $this->yy_buffer_end = $this->yy_buffer_index;
    }


    function  yy_to_mark ()
    {
        $this->yy_buffer_index = $this->yy_buffer_end;
        $this->yy_at_bol = ($this->yy_buffer_end > $this->yy_buffer_start) &&
            ($this->yy_buffer{$this->yy_buffer_end-1} == '\r' ||
            $this->yy_buffer{$this->yy_buffer_end-1} == '\n');
    }


    function yytext()
    {
        return substr($this->yy_buffer,$this->yy_buffer_start,$this->yy_buffer_end - $this->yy_buffer_start);
    }


    function yylength ()
    {
        return $this->yy_buffer_end - $this->yy_buffer_start;
    }


    var $yy_error_string = array(
        "Error: Internal error.\n",
        "Error: Unmatched input - \""
        );


    function yy_error ($code,$fatal)
    {
        if (method_exists($this,'raiseError')) { 
	        $this->_fatal = $fatal;
            $msg = $this->yy_error_string[$code];
            if ($code == 1) {
                $msg .= $this->yy_buffer[$this->yy_buffer_start] . "\"";
            }
 		    return $this->raiseError($msg, $code, $fatal); 
 		}
        echo $this->yy_error_string[$code];
        if ($fatal) {
            exit;
        }
    }


    var  $yy_acpt = array (
        /* 0 */   YY_NOT_ACCEPT,
        /* 1 */   YY_NO_ANCHOR,
        /* 2 */   YY_NO_ANCHOR,
        /* 3 */   YY_NO_ANCHOR,
        /* 4 */   YY_NO_ANCHOR,
        /* 5 */   YY_NO_ANCHOR,
        /* 6 */   YY_NO_ANCHOR,
        /* 7 */   YY_NO_ANCHOR,
        /* 8 */   YY_NO_ANCHOR,
        /* 9 */   YY_NO_ANCHOR,
        /* 10 */   YY_NO_ANCHOR,
        /* 11 */   YY_NO_ANCHOR,
        /* 12 */   YY_NO_ANCHOR,
        /* 13 */   YY_NO_ANCHOR,
        /* 14 */   YY_NO_ANCHOR,
        /* 15 */   YY_NO_ANCHOR,
        /* 16 */   YY_NO_ANCHOR,
        /* 17 */   YY_NO_ANCHOR,
        /* 18 */   YY_NO_ANCHOR,
        /* 19 */   YY_NO_ANCHOR,
        /* 20 */   YY_NO_ANCHOR,
        /* 21 */   YY_NO_ANCHOR,
        /* 22 */   YY_NO_ANCHOR,
        /* 23 */   YY_NO_ANCHOR,
        /* 24 */   YY_NO_ANCHOR,
        /* 25 */   YY_NO_ANCHOR,
        /* 26 */   YY_NO_ANCHOR,
        /* 27 */   YY_NO_ANCHOR,
        /* 28 */   YY_NO_ANCHOR,
        /* 29 */   YY_NO_ANCHOR,
        /* 30 */   YY_NOT_ACCEPT,
        /* 31 */   YY_NO_ANCHOR,
        /* 32 */   YY_NO_ANCHOR,
        /* 33 */   YY_NO_ANCHOR,
        /* 34 */   YY_NO_ANCHOR,
        /* 35 */   YY_NO_ANCHOR,
        /* 36 */   YY_NO_ANCHOR,
        /* 37 */   YY_NO_ANCHOR,
        /* 38 */   YY_NO_ANCHOR,
        /* 39 */   YY_NO_ANCHOR,
        /* 40 */   YY_NO_ANCHOR,
        /* 41 */   YY_NO_ANCHOR,
        /* 42 */   YY_NOT_ACCEPT,
        /* 43 */   YY_NO_ANCHOR,
        /* 44 */   YY_NO_ANCHOR,
        /* 45 */   YY_NO_ANCHOR,
        /* 46 */   YY_NOT_ACCEPT,
        /* 47 */   YY_NO_ANCHOR,
        /* 48 */   YY_NOT_ACCEPT,
        /* 49 */   YY_NO_ANCHOR,
        /* 50 */   YY_NOT_ACCEPT,
        /* 51 */   YY_NO_ANCHOR,
        /* 52 */   YY_NOT_ACCEPT,
        /* 53 */   YY_NOT_ACCEPT,
        /* 54 */   YY_NOT_ACCEPT,
        /* 55 */   YY_NOT_ACCEPT,
        /* 56 */   YY_NOT_ACCEPT,
        /* 57 */   YY_NOT_ACCEPT,
        /* 58 */   YY_NOT_ACCEPT,
        /* 59 */   YY_NOT_ACCEPT,
        /* 60 */   YY_NOT_ACCEPT,
        /* 61 */   YY_NOT_ACCEPT,
        /* 62 */   YY_NOT_ACCEPT,
        /* 63 */   YY_NOT_ACCEPT,
        /* 64 */   YY_NOT_ACCEPT,
        /* 65 */   YY_NOT_ACCEPT,
        /* 66 */   YY_NOT_ACCEPT,
        /* 67 */   YY_NOT_ACCEPT,
        /* 68 */   YY_NOT_ACCEPT,
        /* 69 */   YY_NOT_ACCEPT,
        /* 70 */   YY_NOT_ACCEPT,
        /* 71 */   YY_NOT_ACCEPT,
        /* 72 */   YY_NOT_ACCEPT,
        /* 73 */   YY_NOT_ACCEPT,
        /* 74 */   YY_NOT_ACCEPT,
        /* 75 */   YY_NOT_ACCEPT,
        /* 76 */   YY_NOT_ACCEPT,
        /* 77 */   YY_NOT_ACCEPT,
        /* 78 */   YY_NOT_ACCEPT,
        /* 79 */   YY_NOT_ACCEPT,
        /* 80 */   YY_NOT_ACCEPT,
        /* 81 */   YY_NOT_ACCEPT,
        /* 82 */   YY_NOT_ACCEPT,
        /* 83 */   YY_NOT_ACCEPT,
        /* 84 */   YY_NOT_ACCEPT,
        /* 85 */   YY_NOT_ACCEPT,
        /* 86 */   YY_NOT_ACCEPT,
        /* 87 */   YY_NOT_ACCEPT,
        /* 88 */   YY_NOT_ACCEPT,
        /* 89 */   YY_NOT_ACCEPT,
        /* 90 */   YY_NOT_ACCEPT,
        /* 91 */   YY_NOT_ACCEPT,
        /* 92 */   YY_NOT_ACCEPT,
        /* 93 */   YY_NOT_ACCEPT,
        /* 94 */   YY_NOT_ACCEPT,
        /* 95 */   YY_NO_ANCHOR,
        /* 96 */   YY_NOT_ACCEPT,
        /* 97 */   YY_NO_ANCHOR,
        /* 98 */   YY_NOT_ACCEPT,
        /* 99 */   YY_NOT_ACCEPT,
        /* 100 */   YY_NOT_ACCEPT,
        /* 101 */   YY_NOT_ACCEPT,
        /* 102 */   YY_NOT_ACCEPT,
        /* 103 */   YY_NO_ANCHOR,
        /* 104 */   YY_NO_ANCHOR,
        /* 105 */   YY_NO_ANCHOR,
        /* 106 */   YY_NO_ANCHOR,
        /* 107 */   YY_NO_ANCHOR
        );


    var  $yy_cmap = array(
        24, 24, 24, 24, 24, 24, 24, 24,
        9, 9, 1, 24, 24, 16, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        9, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 18, 24, 24, 24, 24, 4,
        14, 14, 14, 14, 14, 14, 14, 14,
        14, 14, 24, 24, 3, 24, 10, 24,
        15, 13, 13, 13, 13, 13, 13, 13,
        13, 13, 13, 13, 13, 13, 13, 13,
        13, 13, 13, 13, 13, 13, 13, 13,
        13, 13, 13, 24, 24, 24, 24, 24,
        24, 22, 13, 5, 7, 8, 13, 13,
        13, 19, 13, 13, 23, 13, 20, 6,
        11, 13, 12, 13, 21, 13, 13, 13,
        13, 13, 13, 17, 24, 2, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 24, 24, 24, 24, 24, 24, 24,
        24, 0, 0 
         );


    var $yy_rmap = array(
        0, 1, 2, 3, 4, 5, 1, 6,
        7, 7, 7, 7, 1, 8, 8, 9,
        1, 10, 7, 11, 12, 13, 14, 15,
        16, 1, 17, 17, 1, 1, 7, 18,
        16, 19, 1, 1, 1, 1, 20, 21,
        22, 1, 6, 23, 7, 24, 25, 26,
        27, 28, 29, 30, 31, 32, 33, 34,
        35, 36, 37, 38, 39, 40, 41, 42,
        43, 44, 45, 28, 16, 46, 47, 48,
        49, 50, 51, 52, 53, 54, 14, 55,
        56, 57, 58, 59, 60, 61, 62, 63,
        64, 65, 66, 67, 68, 69, 70, 71,
        72, 73, 74, 75, 76, 77, 78, 79,
        80, 81, 82, 83 
        );


    var $yy_nxt = array(
        array( 1, 2, 3, 4, 3, 3, 3, 3,
            3, 3, 3, 3, 3, 3, 3, 3,
            3, 32, 3, 3, 3, 3, 3, 3,
            3 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 2, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 3, 30, 3, 3, 3, 3,
            3, 3, 3, 3, 3, 3, 3, 3,
            3, 42, 3, 3, 3, 3, 3, 3,
            3 ),
        array( -1, 5, 30, 96, 101, 46, 46, 46,
            46, 33, 30, 46, 46, 46, 44, 30,
            30, 42, 30, 46, 46, 46, 46, 46,
            30 ),
        array( -1, 5, -1, -1, -1, -1, -1, -1,
            -1, 5, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 7, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 30, 30, 30, 30, 30, 30,
            30, 30, 30, 30, 30, 30, 30, 30,
            30, 42, 30, 30, 30, 30, 30, 30,
            30 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 13, 13,
            -1 ),
        array( 1, 39, 16, 39, 39, 39, 39, 39,
            39, 39, 39, 39, 39, 39, 39, 39,
            39, 39, 39, 39, 39, 39, 39, 39,
            39 ),
        array( -1, -1, 64, 30, 17, 17, 17, 17,
            17, 17, 17, 17, 17, 17, 17, 17,
            17, 42, 17, 17, 17, 17, 17, 17,
            17 ),
        array( -1, 19, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 20, -1, 20, 20, 20, 20,
            20, 20, 20, 20, 20, 20, 20, 20,
            20, -1, 20, 20, 20, 20, 20, 20,
            20 ),
        array( -1, -1, 75, -1, 21, 21, 21, 21,
            21, 21, 21, 21, 21, 21, 21, 21,
            21, -1, 21, 21, 21, 21, 21, 21,
            21 ),
        array( -1, -1, -1, -1, -1, 22, 22, 22,
            22, -1, -1, 22, 22, 22, -1, -1,
            -1, -1, -1, 22, 22, 22, 22, 22,
            -1 ),
        array( -1, -1, 23, -1, 23, 23, 23, 23,
            23, 23, 23, 23, 23, 23, 23, 23,
            23, -1, 23, 23, 23, 23, 23, 23,
            23 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, 6,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 27, 27, -1, 27, 27, 27, 27,
            27, 27, 27, 27, 27, 27, 27, 27,
            27, -1, 27, 27, 27, 27, 27, 27,
            27 ),
        array( -1, 31, -1, -1, -1, -1, -1, -1,
            -1, 77, -1, -1, -1, -1, -1, 78,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 5, 30, 30, 30, 30, 30, 30,
            30, 33, 30, 30, 30, 30, 30, 30,
            30, 42, 30, 30, 30, 30, 30, 30,
            30 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 13, 14,
            -1 ),
        array( -1, 39, -1, 39, 39, 39, 39, 39,
            39, 39, 39, 39, 39, 39, 39, 39,
            39, 39, 39, 39, 39, 39, 39, 39,
            39 ),
        array( -1, -1, 65, -1, 40, 40, 40, 40,
            40, 40, 40, 40, 40, 40, 40, 40,
            40, -1, 40, 40, 40, 40, 40, 40,
            40 ),
        array( -1, 40, 18, 17, 17, 17, 17, 17,
            17, 17, 17, 17, 17, 17, 17, 17,
            17, 45, 17, 17, 17, 17, 17, 17,
            17 ),
        array( -1, 7, 65, -1, 40, 40, 40, 40,
            40, 40, 40, 40, 40, 40, 40, 40,
            40, -1, 40, 40, 40, 40, 40, 40,
            40 ),
        array( -1, 52, 30, 30, 53, 46, 46, 46,
            46, 54, 8, 46, 46, 46, 30, 30,
            30, 42, 30, 46, 46, 46, 46, 46,
            30 ),
        array( -1, -1, 30, 96, 101, 46, 46, 46,
            46, 30, 30, 46, 46, 46, 30, 30,
            30, 42, 30, 46, 46, 46, 46, 46,
            30 ),
        array( -1, 98, 30, 30, 102, 48, 48, 48,
            48, 55, 56, 48, 48, 48, 30, 30,
            30, 42, 30, 48, 48, 48, 48, 48,
            30 ),
        array( -1, -1, -1, 69, 99, 70, 70, 70,
            70, -1, -1, 70, 70, 70, -1, -1,
            -1, -1, -1, 70, 70, 70, 70, 70,
            -1 ),
        array( -1, -1, 30, 30, 30, 50, 50, 50,
            50, 30, 9, 50, 50, 50, 30, 30,
            30, 42, 30, 50, 50, 50, 50, 50,
            30 ),
        array( -1, -1, -1, 82, 99, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 52, -1, -1, 57, -1, -1, -1,
            -1, 52, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 30, 30, 30, 30, 30, 30,
            30, 30, 10, 30, 30, 30, 30, 30,
            30, 42, 30, 30, 30, 30, 30, 30,
            30 ),
        array( -1, 52, 30, 30, 53, 30, 30, 30,
            30, 54, 30, 30, 30, 30, 30, 30,
            30, 42, 30, 30, 30, 30, 30, 30,
            30 ),
        array( -1, 98, 30, 30, 102, 30, 30, 30,
            30, 55, 30, 30, 30, 30, 30, 30,
            30, 42, 30, 30, 30, 30, 30, 30,
            30 ),
        array( -1, -1, 30, 30, 30, 30, 30, 30,
            30, 30, 11, 30, 30, 30, 30, 30,
            30, 42, 30, 30, 30, 30, 30, 30,
            30 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 36, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 59, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 37, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( 1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( 1, -1, 12, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, 62, 107, 13, 13, 13, 13,
            -1 ),
        array( -1, -1, 12, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( 1, 2, 43, 47, 17, 17, 17, 17,
            17, 17, 17, 17, 17, 17, 17, 17,
            17, 32, 17, 17, 17, 17, 17, 17,
            17 ),
        array( -1, 40, 30, 17, 17, 17, 17, 17,
            17, 17, 17, 17, 17, 17, 17, 17,
            17, 45, 17, 17, 17, 17, 17, 17,
            17 ),
        array( -1, 40, -1, 40, 40, 40, 40, 40,
            40, 40, 40, 40, 40, 40, 40, 40,
            40, 40, 40, 40, 40, 40, 40, 40,
            40 ),
        array( 1, 19, 20, 67, 20, 20, 20, 20,
            20, 20, 20, 20, 20, 20, 20, 20,
            20, 68, 20, 20, 20, 20, 20, 20,
            20 ),
        array( -1, -1, -1, -1, -1, 71, 71, 71,
            71, -1, -1, 71, 71, 71, -1, -1,
            -1, -1, -1, 71, 71, 71, 71, 71,
            -1 ),
        array( -1, 52, -1, -1, 57, 70, 70, 70,
            70, 52, 34, 70, 70, 70, -1, -1,
            -1, -1, -1, 70, 70, 70, 70, 70,
            -1 ),
        array( -1, 98, -1, -1, 58, 71, 71, 71,
            71, 98, 59, 71, 71, 71, -1, -1,
            -1, -1, -1, 71, 71, 71, 71, 71,
            -1 ),
        array( -1, -1, -1, -1, -1, 72, 72, 72,
            72, -1, 35, 72, 72, 72, -1, -1,
            -1, -1, -1, 72, 72, 72, 72, 72,
            -1 ),
        array( 1, 19, 74, 67, 21, 21, 21, 21,
            21, 21, 21, 21, 21, 21, 21, 21,
            21, 68, 21, 21, 21, 21, 21, 21,
            21 ),
        array( -1, 21, 41, 21, 21, 21, 21, 21,
            21, 21, 21, 21, 21, 21, 21, 21,
            21, 21, 21, 21, 21, 21, 21, 21,
            21 ),
        array( -1, 21, -1, 21, 21, 21, 21, 21,
            21, 21, 21, 21, 21, 21, 21, 21,
            21, 21, 21, 21, 21, 21, 21, 21,
            21 ),
        array( 1, 77, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 77, -1, -1, -1, -1, -1, -1,
            -1, 77, -1, -1, -1, -1, -1, 78,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( 1, 31, 23, 49, 23, 23, 23, 23,
            23, 23, 23, 23, 23, 23, 23, 23,
            23, 24, 23, 23, 23, 23, 23, 23,
            23 ),
        array( 1, 25, 25, 25, 25, 25, 25, 25,
            25, 25, 25, 25, 25, 25, 25, 25,
            -1, 25, 25, 25, 25, 25, 25, 25,
            25 ),
        array( 1, 26, 27, 51, 27, 27, 27, 27,
            27, 27, 27, 27, 27, 27, 27, 27,
            27, 32, 27, 27, 27, 27, 27, 27,
            27 ),
        array( -1, -1, -1, -1, 83, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, 84, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, 85, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, 86,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            87, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 87, -1, -1, -1, -1, -1, -1,
            -1, 87, 88, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 28, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, 90, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, 91, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, 92, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            93, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 93, -1, -1, -1, -1, -1, -1,
            -1, 93, 94, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 29, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 38, 13,
            -1 ),
        array( -1, -1, 30, 30, 30, 48, 48, 48,
            48, 30, 30, 48, 48, 48, 30, 30,
            30, 42, 30, 48, 48, 48, 48, 48,
            30 ),
        array( -1, -1, -1, 89, 99, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 98, -1, -1, 58, -1, -1, -1,
            -1, 98, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, 72, 72, 72,
            72, -1, -1, 72, 72, 72, -1, -1,
            -1, -1, -1, 72, 72, 72, 72, 72,
            -1 ),
        array( 1, 26, 27, 97, 27, 27, 27, 27,
            27, 27, 27, 27, 27, 27, 27, 27,
            27, 32, 27, 27, 27, 27, 27, 27,
            27 ),
        array( -1, -1, 30, 30, 30, 50, 50, 50,
            50, 30, 30, 50, 50, 50, 30, 30,
            30, 42, 30, 50, 50, 50, 50, 50,
            30 ),
        array( -1, -1, 30, 30, 30, 30, 30, 30,
            30, 30, 56, 30, 30, 30, 30, 30,
            30, 42, 30, 30, 30, 30, 30, 30,
            30 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 95, 13, 13, 13,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 103, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 13, 13,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            104, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 13, 13,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 105, 13, 13,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 106, 13, 13, 13,
            -1 )
        );


    function  yylex()
    {
        $yy_lookahead = '';
        $yy_anchor = YY_NO_ANCHOR;
        $yy_state = $this->yy_state_dtrans[$this->yy_lexical_state];
        $yy_next_state = YY_NO_STATE;
         $yy_last_accept_state = YY_NO_STATE;
        $yy_initial = true;
        $yy_this_accept = 0;
        
        $this->yy_mark_start();
        $yy_this_accept = $this->yy_acpt[$yy_state];
        if (YY_NOT_ACCEPT != $yy_this_accept) {
            $yy_last_accept_state = $yy_state;
            $this->yy_buffer_end = $this->yy_buffer_index;
        }
        while (true) {
            if ($yy_initial && $this->yy_at_bol) {
                $yy_lookahead =  YY_BOL;
            } else {
                $yy_lookahead = $this->yy_advance();
            }
            $yy_next_state = $this->yy_nxt[$this->yy_rmap[$yy_state]][$this->yy_cmap[$yy_lookahead]];
            if (YY_EOF == $yy_lookahead && $yy_initial) {
                return false;            }
            if (YY_F != $yy_next_state) {
                $yy_state = $yy_next_state;
                $yy_initial = false;
                $yy_this_accept = $this->yy_acpt[$yy_state];
                if (YY_NOT_ACCEPT != $yy_this_accept) {
                    $yy_last_accept_state = $yy_state;
                    $this->yy_buffer_end = $this->yy_buffer_index;
                }
            } else {
                if (YY_NO_STATE == $yy_last_accept_state) {
                    $this->yy_error(1,1);
                    if ($this->_fatal) {
                        return;
                    }
                } else {
                    $yy_anchor = $this->yy_acpt[$yy_last_accept_state];
                    if (0 != (YY_END & $yy_anchor)) {
                        $this->yy_move_end();
                    }
                    $this->yy_to_mark();
                    if ($yy_last_accept_state < 0) {
                        if ($yy_last_accept_state < 108) {
                            $this->yy_error(YY_E_INTERNAL, false);
                            if ($this->_fatal) {
                                return;
                            }
                        }
                    } else {

                        switch ($yy_last_accept_state) {
case 2:
{
    if (strlen($this->yytext()) >= 2) {
        $this->yy_buffer_index = $this->yy_buffer_end = $this->yy_buffer_start + 2;
        if ($this->debug) echo "initial double newline ".strlen($this->yytext())."\n";
        return array(PHP_PARSER_DOCLEX_DOUBLENL, $this->yytext());
    }
    if ($this->debug) echo "initial newline ".strlen($this->yytext())."\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 3:
{
    $test = ltrim($this->yytext());
    if (strlen($test)) {
        $whitespace = substr($this->yytext(), 0, strpos($this->yytext(), $test));
    } else {
        $whitespace = false;
    }
    if (strlen($test) && in_array($test{0}, array('-', '+', 'o', '1'))) {
        // check for simple lists
        $save = $this->saveState();
        if ($this->debug) echo ">>checking next token\n";
        $next = $this->yylex();
        $this->restoreState($save);
        if ($res = $this->_checkList($next, $whitespace, $test, SIMPLELIST, YYINITIAL)) {
            return $res;
        } else {
            break;
        }
    } elseif (strlen($test) && $test{0} == '@') {
        if (preg_match("/[a-zA-Z]/", $test{1})) {
            if ($this->debug) echo "found tag 567\n";
            // found a tag
            $this->yybegin(TAGS);
            if ($this->yy_buffer_start == 0) {
                // this only happens if there is no description
                $this->yybegin(INTAG);
                $this->_atNewLine = false;
                if (strlen($whitespace)) {
                    if ($this->debug) echo "new tag start [".trim($test)."]\n";
                } else {
                    $tag = array_shift(preg_split('/[\s]+/', $this->yytext()));
                    $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start + strlen($tag);
                    if ($this->debug) echo "new tag start [".trim($tag)."]\n";
                }
                return array(PHP_PARSER_DOCLEX_TAG, trim($tag));
            }
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start - 1;
            break;
        }
    } else {
        if ($this->debug) echo "2 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 4:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 5:
{
    if ($this->debug) echo "1 normal desc text [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 6:
{
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        array_pop($this->_listLevel);
        if (!count($this->_listLevel)) {
            $this->yybegin($this->_listOriginal);
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        } else {
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
    }
    if ($this->debug) echo "checking for inline tag\n";
    $this->_original = $this->yy_lexical_state;
    $this->yybegin(CHECKINLINE);
    break;
}
case 7:
{
    $cut = $this->yylength() - strlen(rtrim($this->yytext()));
    $this->yy_buffer_end -= $cut;
    $this->yy_buffer_index -= $cut;
    if ($this->debug) echo "line with bracket at line end [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 8:
{
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        array_pop($this->_listLevel);
        if (!count($this->_listLevel)) {
            $this->yybegin($this->_listOriginal);
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        } else {
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
    }
    $tagname = strtolower(str_replace(array('<','>'),array('',''), $this->yytext()));
    if (isset($this->_tagMap['open'][$tagname])) {
        if ($this->debug) echo "open $tagname tag [".$this->yytext()."]\n";
        if ($tagname == 'code') {
            $this->_codeOriginal = $this->yy_lexical_state;
            $this->yybegin(INCODE);
        }
        if ($tagname == 'pre') {
            $this->_codeOriginal = $this->yy_lexical_state;
            $this->yybegin(INPRE);
        }
        return array($this->_tagMap['open'][$tagname], $this->yytext());
    } elseif ($this->yy_lexical_state == YYINITIAL || $this->yy_lexical_state == INLINEINTERNALTAG
                || $this->yy_lexical_state == INTAG) {
        if ($this->debug) echo "normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    } elseif ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST) {
        if ($this->debug) echo "2 simple list stuff [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_SIMPLELIST, $this->yytext());
    }
}
case 9:
{
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        array_pop($this->_listLevel);
        if (!count($this->_listLevel)) {
            if ($this->debug) {
                echo "end simple list in </tag>\n";
            }
            $this->yybegin($this->_listOriginal);
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        } else {
            if ($this->debug) {
                echo "go to parent list in </tag>\n";
            }
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
    }
    $tagname = str_replace(array('</','>'), array('',''), $this->yytext());
    if ($this->yy_lexical_state == INCODE) {
        if ($tagname != 'code') {
            if ($this->debug) echo '<code> stuff ['.$this->yytext()."]\n";
            return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
        } else {
            $this->yybegin($this->_codeOriginal);
        }
    }
    if ($this->yy_lexical_state == INPRE) {
        if ($tagname != 'pre') {
            if ($this->debug) echo '<pre> stuff ['.$this->yytext()."]\n";
            return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
        } else {
            $this->yybegin($this->_codeOriginal);
        }
    }
    if (isset($this->_tagMap['close'][$tagname])) {
        if ($tagname == 'p' && ($this->yy_lexical_state == SIMPLELIST
                                || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
            if ($this->debug) echo "shunting list to original state, returning dummy\n";
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            $this->yybegin($this->_listOriginal);
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
        if ($this->debug) echo "close $tagname tag [".$this->yytext()."]\n";
        return array($this->_tagMap['close'][$tagname], $this->yytext());
    } elseif ($this->yy_lexical_state == YYINITIAL || $this->yy_lexical_state == INLINEINTERNALTAG ||
                $this->yy_lexical_state == INTAG) {
        if ($this->debug) echo "normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    } elseif ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST) {
        if ($this->debug) echo "3 simple list stuff [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_SIMPLELIST, $this->yytext());
    }
}
case 10:
{
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        array_pop($this->_listLevel);
        if (!count($this->_listLevel)) {
            $this->yybegin($this->_listOriginal);
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        } else {
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
    }
    if ($this->debug) echo "complete tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_XML_TAG, $this->yytext());
}
case 11:
{
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        array_pop($this->_listLevel);
        if (!count($this->_listLevel)) {
            $this->yybegin($this->_listOriginal);
        } else {
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
    }
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}
case 12:
{
    if ($this->debug) echo "found inline escape [{@".$this->yytext()."]\n";
    $this->yybegin($this->_original);
    return array(PHP_PARSER_DOCLEX_INLINE_ESC, "{@".$this->yytext());
}
case 13:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 14:
{
    if ($this->debug) echo "found internal [{@".$this->yytext()."]\n";
    if ($this->_original == SIMPLELIST) {
        $this->yybegin(INTERNALSIMPLELIST);
        $this->_listOriginal = INLINEINTERNALTAG;
    } else {
        $this->yybegin(INLINEINTERNALTAG);
        $this->_original = YYINITIAL;
    }
    if ($this->_options['return_internal']) {
        return array(PHP_PARSER_DOCLEX_INTERNAL, "{@internal");
    } else {
        if ($this->debug) echo "not returning {@internal";
        $this->yy_buffer_start = $this->yy_buffer_index;
        break;
    }
}
case 15:
{
    if ($this->debug) echo "inline tag $this->_tagName contents [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_CONTENTS, $this->yytext());
}
case 16:
{
    if ($this->debug) echo "inline tag close [}]\n";
    $this->yybegin($this->_original);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_CLOSE, $this->yytext());
}
case 17:
{
    $test = ltrim($this->yytext());
    if (strlen($test)) {
        $whitespace = substr($this->yytext(), 0, strpos($this->yytext(), $test));
    } else {
        $whitespace = false;
    }
    if (strlen($test) && in_array($test{0}, array('-', '+', 'o', '1'))) {
        // check for simple lists
        $save = $this->saveState();
        if ($this->debug) echo ">>checking next token\n";
        $next = $this->yylex();
        $this->restoreState($save);
        if ($res = $this->_checkList($next, $whitespace, $test, INTERNALSIMPLELIST, INLINEINTERNALTAG)) {
            return $res;
        } else {
            break;
        }
    } elseif (strlen($test) && $test{0} == '@') {
        if (preg_match("/[a-zA-Z]/", $test{1})) {
            if ($this->debug) echo "found tag 687\n";
            // found a tag
            $this->yybegin(TAGS);
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start - 1;
            break;
        }
    } else {
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 18:
{
    if ($this->yy_lexical_state == INTERNALSIMPLELIST) {
        if (!count($this->_listLevel)) {
            $this->yybegin($this->_listOriginal);
        } else {
            array_pop($this->_listLevel);
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            if ($this->debug) {
                echo "end of simple list\n";
            }
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
    }
//    if ($this->yy_lexical_state == INTERNALSIMPLELIST) {
//        $this->_original = $this->_oldOriginal;
//        $this->_listOriginal = $this->_oldOriginal;
//        $this->yybegin(INLINEINTERNALTAG);
//        $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
//        if ($this->debug) echo "simplelist end\n";
//        return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
//    } else {
        if ($this->debug) echo "found end internal [".$this->yytext()."]\n";
        $this->_original = $this->_oldOriginal;
        $this->yybegin($this->_oldOriginal);
//    }
    if ($this->_options['return_internal']) {
        return array(PHP_PARSER_DOCLEX_ENDINTERNAL, $this->yytext());
    } else {
        if ($this->debug) echo "not returning end internal\n";
        $this->yy_buffer_start = $this->yy_buffer_index;
        break;
    }
}
case 19:
{
    $this->_atNewLine = true;
    if (strlen($this->yytext()) > 1) {
        $save = $this->saveState();
        if ($this->debug) {
            echo "**testing tokens multi-\\n**\n";
        }
        $this->advance();
        $token = $this->token;
        $this->restoreState($save);
        if ($token == PHP_PARSER_DOCLEX_WHITESPACE || $token == PHP_PARSER_DOCLEX_SIMPLELIST_START) {
            if ($this->debug) echo "double newline in simplelist [" . $this->yytext() . "]\n";
            return array(PHP_PARSER_DOCLEX_DOUBLENL, $this->yytext());
        } else {
            // A simple list may not contain double newlines
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            $this->yybegin($this->_listOriginal);
            if ($this->debug) echo "end simple list (in \\n handler)\n";
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
    }
    $save = $this->saveState();
    if ($this->debug) {
        echo "**testing tokens**\n";
    }
    $this->advance();
    if ($this->token == PHP_PARSER_DOCLEX_WHITESPACE) {
        if ($this->debug) {
            echo "**testing tokens**\n";
        }
        $this->advance();
        $estack = &PEAR_ErrorStack::singleton('PHP_Parser_DocBlock_DefaultLexer');
        if ($this->token == PHP_PARSER_DOCLEX_SIMPLELIST_END && !$estack->hasErrors()) {
            if ($this->debug) {
                echo "end simple list early\n";
            }
            $this->restoreState($save);
            array_pop($this->_listLevel);
            if (!count($this->_listLevel)) {
                $this->yybegin($this->_listOriginal);
            } else {
                $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            }
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, $this->yytext());
        } else {
            if (!count($estack->getErrors(true)) && !in_array($this->token, array(
                  PHP_PARSER_DOCLEX_BULLET,
                  PHP_PARSER_DOCLEX_NBULLET,
                  PHP_PARSER_DOCLEX_NDBULLET))) {
                $this->restoreState($save);
                if ($this->debug) echo "not a simplelist newline\n";
                return $this->yylex();
            }
        }
    }
    $this->restoreState($save);
    if ($this->debug) echo "simplelist newline\n";
    return array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, $this->yytext());
}
case 20:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 21:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 22:
{
    if ($this->debug) echo "new tag start [".trim($this->yytext())."]\n";
    $this->yybegin(INTAG);
    $this->_atNewLine = false;
    return array(PHP_PARSER_DOCLEX_TAG, trim($this->yytext()));
}
case 23:
{
    $test = ltrim($this->yytext());
    if (strlen($test)) {
        $whitespace = substr($this->yytext(), 0, strpos($this->yytext(), $test));
    } else {
        $whitespace = false;
    }
    if (strlen($test) && in_array($test{0}, array('-', '+', 'o', '1'))) {
        // check for simple lists
        $save = $this->saveState();
        if ($this->debug) echo ">>checking next token\n";
        $next = $this->yylex();
        $this->restoreState($save);
        if ($res = $this->_checkList($next, $whitespace, $test, SIMPLELIST, YYINITIAL)) {
            return $res;
        } else {
            break;
        }
    } else {
        if ($this->debug) echo "normal text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 24:
{
    if ($this->debug) echo "in tag normal bracket [{]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 25:
{
    if ($this->debug) echo "inline tag name [".$this->_tagName."]\n";
    $this->yybegin(INLINETAG);
    $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_NAME, $this->_tagName);
}
case 26:
{
    if ($this->debug) echo '<code> newline ['.$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 27:
{
        if ($this->debug) echo "normal code text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 28:
{
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}
case 29:
{
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}
case 31:
{
    if (strlen($this->yytext()) >= 2) {
        $this->yy_buffer_index = $this->yy_buffer_end = $this->yy_buffer_start + 2;
        if ($this->debug) echo "initial double newline ".strlen($this->yytext())."\n";
        return array(PHP_PARSER_DOCLEX_DOUBLENL, $this->yytext());
    }
    if ($this->debug) echo "initial newline ".strlen($this->yytext())."\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 32:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 33:
{
    if ($this->debug) echo "1 normal desc text [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 34:
{
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        array_pop($this->_listLevel);
        if (!count($this->_listLevel)) {
            $this->yybegin($this->_listOriginal);
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        } else {
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
    }
    $tagname = strtolower(str_replace(array('<','>'),array('',''), $this->yytext()));
    if (isset($this->_tagMap['open'][$tagname])) {
        if ($this->debug) echo "open $tagname tag [".$this->yytext()."]\n";
        if ($tagname == 'code') {
            $this->_codeOriginal = $this->yy_lexical_state;
            $this->yybegin(INCODE);
        }
        if ($tagname == 'pre') {
            $this->_codeOriginal = $this->yy_lexical_state;
            $this->yybegin(INPRE);
        }
        return array($this->_tagMap['open'][$tagname], $this->yytext());
    } elseif ($this->yy_lexical_state == YYINITIAL || $this->yy_lexical_state == INLINEINTERNALTAG
                || $this->yy_lexical_state == INTAG) {
        if ($this->debug) echo "normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    } elseif ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST) {
        if ($this->debug) echo "2 simple list stuff [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_SIMPLELIST, $this->yytext());
    }
}
case 35:
{
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        array_pop($this->_listLevel);
        if (!count($this->_listLevel)) {
            if ($this->debug) {
                echo "end simple list in </tag>\n";
            }
            $this->yybegin($this->_listOriginal);
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        } else {
            if ($this->debug) {
                echo "go to parent list in </tag>\n";
            }
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
    }
    $tagname = str_replace(array('</','>'), array('',''), $this->yytext());
    if ($this->yy_lexical_state == INCODE) {
        if ($tagname != 'code') {
            if ($this->debug) echo '<code> stuff ['.$this->yytext()."]\n";
            return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
        } else {
            $this->yybegin($this->_codeOriginal);
        }
    }
    if ($this->yy_lexical_state == INPRE) {
        if ($tagname != 'pre') {
            if ($this->debug) echo '<pre> stuff ['.$this->yytext()."]\n";
            return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
        } else {
            $this->yybegin($this->_codeOriginal);
        }
    }
    if (isset($this->_tagMap['close'][$tagname])) {
        if ($tagname == 'p' && ($this->yy_lexical_state == SIMPLELIST
                                || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
            if ($this->debug) echo "shunting list to original state, returning dummy\n";
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            $this->yybegin($this->_listOriginal);
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
        if ($this->debug) echo "close $tagname tag [".$this->yytext()."]\n";
        return array($this->_tagMap['close'][$tagname], $this->yytext());
    } elseif ($this->yy_lexical_state == YYINITIAL || $this->yy_lexical_state == INLINEINTERNALTAG ||
                $this->yy_lexical_state == INTAG) {
        if ($this->debug) echo "normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    } elseif ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST) {
        if ($this->debug) echo "3 simple list stuff [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_SIMPLELIST, $this->yytext());
    }
}
case 36:
{
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        array_pop($this->_listLevel);
        if (!count($this->_listLevel)) {
            $this->yybegin($this->_listOriginal);
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        } else {
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
    }
    if ($this->debug) echo "complete tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_XML_TAG, $this->yytext());
}
case 37:
{
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        array_pop($this->_listLevel);
        if (!count($this->_listLevel)) {
            $this->yybegin($this->_listOriginal);
        } else {
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
    }
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}
case 38:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 39:
{
    if ($this->debug) echo "inline tag $this->_tagName contents [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_CONTENTS, $this->yytext());
}
case 40:
{
    $test = ltrim($this->yytext());
    if (strlen($test)) {
        $whitespace = substr($this->yytext(), 0, strpos($this->yytext(), $test));
    } else {
        $whitespace = false;
    }
    if (strlen($test) && in_array($test{0}, array('-', '+', 'o', '1'))) {
        // check for simple lists
        $save = $this->saveState();
        if ($this->debug) echo ">>checking next token\n";
        $next = $this->yylex();
        $this->restoreState($save);
        if ($res = $this->_checkList($next, $whitespace, $test, INTERNALSIMPLELIST, INLINEINTERNALTAG)) {
            return $res;
        } else {
            break;
        }
    } elseif (strlen($test) && $test{0} == '@') {
        if (preg_match("/[a-zA-Z]/", $test{1})) {
            if ($this->debug) echo "found tag 687\n";
            // found a tag
            $this->yybegin(TAGS);
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start - 1;
            break;
        }
    } else {
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 41:
{
    if ($this->yy_lexical_state == INTERNALSIMPLELIST) {
        if (!count($this->_listLevel)) {
            $this->yybegin($this->_listOriginal);
        } else {
            array_pop($this->_listLevel);
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
            if ($this->debug) {
                echo "end of simple list\n";
            }
            return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
        }
    }
//    if ($this->yy_lexical_state == INTERNALSIMPLELIST) {
//        $this->_original = $this->_oldOriginal;
//        $this->_listOriginal = $this->_oldOriginal;
//        $this->yybegin(INLINEINTERNALTAG);
//        $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
//        if ($this->debug) echo "simplelist end\n";
//        return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
//    } else {
        if ($this->debug) echo "found end internal [".$this->yytext()."]\n";
        $this->_original = $this->_oldOriginal;
        $this->yybegin($this->_oldOriginal);
//    }
    if ($this->_options['return_internal']) {
        return array(PHP_PARSER_DOCLEX_ENDINTERNAL, $this->yytext());
    } else {
        if ($this->debug) echo "not returning end internal\n";
        $this->yy_buffer_start = $this->yy_buffer_index;
        break;
    }
}
case 43:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 44:
{
    if ($this->debug) echo "1 normal desc text [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 45:
{
    $test = ltrim($this->yytext());
    if (strlen($test)) {
        $whitespace = substr($this->yytext(), 0, strpos($this->yytext(), $test));
    } else {
        $whitespace = false;
    }
    if (strlen($test) && in_array($test{0}, array('-', '+', 'o', '1'))) {
        // check for simple lists
        $save = $this->saveState();
        if ($this->debug) echo ">>checking next token\n";
        $next = $this->yylex();
        $this->restoreState($save);
        if ($res = $this->_checkList($next, $whitespace, $test, INTERNALSIMPLELIST, INLINEINTERNALTAG)) {
            return $res;
        } else {
            break;
        }
    } elseif (strlen($test) && $test{0} == '@') {
        if (preg_match("/[a-zA-Z]/", $test{1})) {
            if ($this->debug) echo "found tag 687\n";
            // found a tag
            $this->yybegin(TAGS);
            $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start - 1;
            break;
        }
    } else {
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 47:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 49:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 51:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 95:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 97:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 103:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 104:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 105:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 106:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 107:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}

                        }
                    }
                    if ($this->_fatal) {
                        return;
                    }
                    $yy_initial = true;
                    $yy_state = $this->yy_state_dtrans[$this->yy_lexical_state];
                    $yy_next_state = YY_NO_STATE;
                    $yy_last_accept_state = YY_NO_STATE;
                    $this->yy_mark_start();
                    $yy_this_accept = $this->yy_acpt[$yy_state];
                    if (YY_NOT_ACCEPT != $yy_this_accept) {
                        $yy_last_accept_state = $yy_state;
                        $this->yy_buffer_end = $this->yy_buffer_index;
                    }
                }
            }
        }
        return null;
    }
}
