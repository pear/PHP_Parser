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
define('PHP_PARSER_DOCLEX_WHITESPACE', ++$a); // whitespace before a bullet in a simple list
define('PHP_PARSER_DOCLEX_NESTEDWHITESPACE', ++$a); // whitespace before a bullet in a nested simple list
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



%%
%namespace Mono.CSharp
%public
%class PHP_Parser_DocBlock_DefaultLexer
%implements yyParser.yyInput
%type int
%ignore_token  null
%eofval{
    return false;
%eofval}
%full
%line
%char
%state POSTNEWLINE CHECKINLINE INLINETAG INLINEINTERNALTAG SIMPLELIST INTERNALSIMPLELIST TAGS INTAG INLINETAGNAME INCODE INPRE
 
%init{
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
%init}

%{
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
    
    function advance()
    {
        $lex = $this->yylex();
        if ($lex) {
            if ($lex[0] == PHP_PARSER_DOCLEX_TEXT) {
                $save = array(
                    'yy_reader' => $this->yy_reader,
                    'yy_buffer_index' => $this->yy_buffer_index,
                    'yy_buffer_read' => $this->yy_buffer_read,
                    'yy_buffer_start' => $this->yy_buffer_start,
                    'yy_buffer_end' => $this->yy_buffer_end,
                    'yychar' => $this->yychar,
                    'yyline' => $this->yyline,
                    'yyEndOfLine' => $this->yyEndOfLine,
                    'yy_at_bol' => $this->yy_at_bol,
                    'yy_lexical_state' => $this->yy_lexical_state,
                    'token' => $this->token,
                    'value' => $this->value,
                );
                do {
                    $next = $this->yylex();
                    if ($next[0] == PHP_PARSER_DOCLEX_TEXT) {
                        $save = array(
                            'yy_reader' => $this->yy_reader,
                            'yy_buffer_index' => $this->yy_buffer_index,
                            'yy_buffer_read' => $this->yy_buffer_read,
                            'yy_buffer_start' => $this->yy_buffer_start,
                            'yy_buffer_end' => $this->yy_buffer_end,
                            'yychar' => $this->yychar,
                            'yyline' => $this->yyline,
                            'yyEndOfLine' => $this->yyEndOfLine,
                            'yy_at_bol' => $this->yy_at_bol,
                            'yy_lexical_state' => $this->yy_lexical_state,
                            'token' => $this->token,
                            'value' => $this->value,
                        );
                        $lex[1] .= $next[1];
                    }
                } while ($next && $next[0] == PHP_PARSER_DOCLEX_TEXT);
                foreach ($save as $name => $value) {
                    $this->$name = $value;
                }
            }
            $this->tokenWithWhitespace = $lex[0];
            $this->token = $lex[0];
            $this->value = $lex[1];
            $this->valueWithWhitespace = $lex[1];
        } elseif ($this->yy_lexical_state == SIMPLELIST ||
            $this->yy_lexical_state == INTERNALSIMPLELIST) {
            $this->token = YY_EOF;
            $this->value = '';
            $this->yy_lexical_state = $this->_listOriginal;
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
                $test = trim($this->yytext());
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
                        if (strlen($test) > 2 &&
                            ($test{0} != '1' && ($test{1} == ' ' && preg_match("/[^\s]/", $test{2})) ||
                            ($test{0} == '1' && (($test{1} == ' ' && preg_match("/[^\s]/", $test{2})) ||
                                                 ($test{1} == '.') &&
                                                 ($test{2} == ' ' && preg_match("/[^\s]/", $test{3})))))) {
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
                                if ($this->debug) echo "found nested list whitespace[$whitespace]\n";
                                $this->_atBullet = true;
                                array_push($this->_listLevel, strlen($whitespace));
                                return array(PHP_PARSER_DOCLEX_WHITESPACE, $whitespace);
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
                    if ($this->debug) echo "going to parent list\n";
                    array_pop($this->_listLevel);
                    if (!count($this->_listLevel)) {
                        $this->yybegin($this->_listOriginal);
                        $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
                        $this->_break = true;
                        return;
                    } else {
                        $this->_atNewLine = true;
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
                        $this->_break = true;
                        return;
                    }
                }
            }
            if ($this->debug) echo "1 simple list stuff [".$this->yytext()."]\n";
            return array (PHP_PARSER_DOCLEX_SIMPLELIST, $this->yytext());
        }
    }
%}

NONNEWLINE_WHITE_SPACE_CHAR = [\ \t\b\012]+
INLINE_ESCAPE = \*\}|\}
NORMAL_DESC_TEXT = ([^\n<{])+
INTERNAL_DESC_TEXT = ([^{}\n<]|\}[^}])+
NOBRACKETS = [^}]*


%%

<INCODE, INPRE> \n {
    if ($this->debug) echo '<code> newline ['.$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}

<INCODE, INPRE> [^<{]+ {
        if ($this->debug) echo "normal code text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}

<INCODE> <<\/code[\ \t\b\012]*>> {
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}

<INPRE> <<\/pre[\ \t\b\012]*>> {
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}

<YYINITIAL, INLINEINTERNALTAG, SIMPLELIST, INTERNALSIMPLELIST, INTAG> <[a-zA-Z]+> {
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        $this->yybegin($this->_listOriginal);
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

<YYINITIAL, INLINEINTERNALTAG, SIMPLELIST, INTERNALSIMPLELIST, INTAG> (<<[a-zA-Z]+>>|<<[a-zA-Z]+[\ \t\b\012]*/>>) {
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        $this->yybegin($this->_listOriginal);
    }
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}

<YYINITIAL, INLINEINTERNALTAG, SIMPLELIST, INTERNALSIMPLELIST, INTAG, INCODE, INPRE> </[a-zA-Z]+> {
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        $this->yybegin($this->_listOriginal);
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

<YYINITIAL, INLINEINTERNALTAG, SIMPLELIST, INTERNALSIMPLELIST, INTAG> <[a-zA-Z]+[\ \t\b\012]*/> {
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        $this->yybegin($this->_listOriginal);
    }
    if ($this->debug) echo "complete tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_XML_TAG, $this->yytext());
}

<YYINITIAL> <({NONNEWLINE_WHITE_SPACE_CHAR}|[0-9]) {
    if ($this->debug) echo "1 normal desc text [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}

<YYINITIAL, INLINEINTERNALTAG> [\n]+ {
    if (strlen($this->yytext()) >= 2) {
        $this->yy_buffer_index = $this->yy_buffer_end = $this->yy_buffer_start + 2;
        if ($this->debug) echo "initial double newline ".strlen($this->yytext())."\n";
        return array(PHP_PARSER_DOCLEX_DOUBLENL, $this->yytext());
    }
    if ($this->debug) echo "initial newline ".strlen($this->yytext())."\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}

<INTAG> [\n]+ {
    if ($this->debug) echo "tags newline\n";
    $this->_atNewLine = true;
    $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start + 1;
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}

<INTAG> [^\n{<]+ {
    $test = trim($this->yytext());
    if (strlen($test)) {
        $whitespace = substr($this->yytext(), 0, strpos($this->yytext(), $test));
    } else {
        $whitespace = false;
    }
    if (strlen($test) && in_array($test{0}, array('-', '+', 'o', '1'))) {
        // check for simple lists
        if (strlen($test) > 2 &&
            ($test{0} != '1' && ($test{1} == ' ' && preg_match("/[^\s]/", $test{2})) ||
            ($test{0} == '1' && (($test{1} == ' ' && preg_match("/[^\s]/", $test{2})) ||
                                 ($test{1} == '.') &&
                                 ($test{2} == ' ' && preg_match("/[^\s]/", $test{3})))))) {
            // found one
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
                $this->_original = SIMPLELIST;
                $this->yybegin(SIMPLELIST);
                $this->_atBullet = true;
                array_push($this->_listLevel, strlen($whitespace));
                return array(PHP_PARSER_DOCLEX_WHITESPACE, $whitespace);
            } else {
                array_push($this->_listLevel, 0);
            }
            break;
        } else {
            if ($this->debug) echo "normal text [".$this->yytext()."]\n";
            return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
        }
    } else {
        if ($this->debug) echo "normal text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}

<TAGS, INTAG> \n[\ \t\b\012]*@[a-zA-Z]+ {
    if ($this->debug) echo "new tag start [".trim($this->yytext())."]\n";
    $this->yybegin(INTAG);
    $this->_atNewLine = false;
    return array(PHP_PARSER_DOCLEX_TAG, trim($this->yytext()));
}

<INTAG> @[a-zA-Z]+ {
    if ($this->debug) echo 'bad condition!';exit;
}

<SIMPLELIST, INTERNALSIMPLELIST> [\n]+ {
    if ($this->debug) echo "simplelist newline\n";
    if (strlen($this->yytext()) > 1) {
        // A simple list may not contain double newlines
        $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
        $this->yybegin($this->_listOriginal);
        return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
    }
    $this->_atNewLine = true;
    return array(PHP_PARSER_DOCLEX_SIMPLELIST_NL, $this->yytext());
}

<YYINITIAL> {NORMAL_DESC_TEXT} {
    $test = trim($this->yytext());
    if (strlen($test)) {
        $whitespace = substr($this->yytext(), 0, strpos($this->yytext(), $test));
    } else {
        $whitespace = false;
    }
    if (strlen($test) && in_array($test{0}, array('-', '+', 'o', '1'))) {
        // check for simple lists
        if (strlen($test) > 2 &&
            ($test{0} != '1' && ($test{1} == ' ' && preg_match("/[^\s]/", $test{2})) ||
            ($test{0} == '1' && (($test{1} == ' ' && preg_match("/[^\s]/", $test{2})) ||
                                 ($test{1} == '.') &&
                                 ($test{2} == ' ' && preg_match("/[^\s]/", $test{3})))))) {
            // found one
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
                $this->_original = SIMPLELIST;
                $this->yybegin(SIMPLELIST);
                $this->_atBullet = true;
                array_push($this->_listLevel, strlen($whitespace));
                return array(PHP_PARSER_DOCLEX_WHITESPACE, $whitespace);
            } else {
                array_push($this->_listLevel, 0);
            }
            break;
        } else {
            if ($this->debug) echo "normal text [".$this->yytext()."]\n";
            return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
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

<INTERNALSIMPLELIST> {INTERNAL_DESC_TEXT} {
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}

<SIMPLELIST> {NORMAL_DESC_TEXT} {
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}

<YYINITIAL, INLINEINTERNALTAG, SIMPLELIST, INTERNALSIMPLELIST, INTAG, INCODE, INPRE> "{@" {
    if ($this->_atNewLine && ($this->yy_lexical_state == SIMPLELIST || $this->yy_lexical_state == INTERNALSIMPLELIST)) {
        $this->yybegin($this->_listOriginal);
    }
    if ($this->debug) echo "checking for inline tag\n";
    $this->_original = $this->yy_lexical_state;
    $this->yybegin(CHECKINLINE);
    break;
}

<INTAG> "{" {
    if ($this->debug) echo "in tag normal bracket [{]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}

<CHECKINLINE> {INLINE_ESCAPE} {
    if ($this->debug) echo "found inline escape [{@".$this->yytext()."]\n";
    $this->yybegin($this->_original);
    return array(PHP_PARSER_DOCLEX_INLINE_ESC, "{@".$this->yytext());
}

<CHECKINLINE> "internal" {
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

<CHECKINLINE> [a-zA-Z]+ {
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}

<INLINETAGNAME> .|\n {
    if ($this->debug) echo "inline tag name [".$this->_tagName."]\n";
    $this->yybegin(INLINETAG);
    $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_NAME, $this->_tagName);
}

<INLINEINTERNALTAG> {INTERNAL_DESC_TEXT} {
    $test = trim($this->yytext());
    if (strlen($test)) {
        $whitespace = substr($this->yytext(), 0, strpos($this->yytext(), $test));
    } else {
        $whitespace = false;
    }
    if (strlen($test) && in_array($test{0}, array('-', '+', 'o', '1'))) {
        // check for simple lists
        if (strlen($test) > 2 &&
            ($test{0} != '1' && ($test{1} == ' ' && preg_match("/[^\s]/", $test{2})) ||
            ($test{0} == '1' && (($test{1} == ' ' && preg_match("/[^\s]/", $test{2})) ||
                                 ($test{1} == '.') &&
                                 ($test{2} == ' ' && preg_match("/[^\s]/", $test{3})))))) {
            // found one
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
                $this->_original = INLINEINTERNALTAG;
                $this->yybegin(INTERNALSIMPLELIST);
                $this->_atBullet = true;
                array_push($this->_listLevel, strlen($whitespace));
                return array(PHP_PARSER_DOCLEX_WHITESPACE, $whitespace);
            } else {
                array_push($this->_listLevel, 0);
            }
            break;
        } else {
            if ($this->debug) echo "normal text [".$this->yytext()."]\n";
            return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
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

<INLINEINTERNALTAG, INTERNALSIMPLELIST> "}}" {
    if ($this->yy_lexical_state == INTERNALSIMPLELIST) {
        $this->_original = $this->_oldOriginal;
        $this->_listOriginal = $this->_oldOriginal;
        $this->yybegin(INLINEINTERNALTAG);
        $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
        if ($this->debug) echo "simplelist end\n";
        return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
    } else {
        if ($this->debug) echo "found end internal [".$this->yytext()."]\n";
        $this->_original = $this->_oldOriginal;
        $this->yybegin($this->_oldOriginal);
    }
    if ($this->_options['return_internal']) {
        return array(PHP_PARSER_DOCLEX_ENDINTERNAL, $this->yytext());
    } else {
        if ($this->debug) echo "not returning end internal\n";
        $this->yy_buffer_start = $this->yy_buffer_index;
        break;
    }
}

<INLINETAG> {NOBRACKETS} {
    if ($this->debug) echo "inline tag $this->_tagName contents [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_CONTENTS, $this->yytext());
}

<INLINETAG> "}" {
    if ($this->debug) echo "inline tag close [}]\n";
    $this->yybegin($this->_original);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_CLOSE, $this->yytext());
}
 
<YYINITIAL, INLINEINTERNALTAG> [^{\n]+\{([\n]+) {
    $cut = $this->yylength() - strlen(rtrim($this->yytext()));
    $this->yy_buffer_end -= $cut;
    $this->yy_buffer_index -= $cut;
    if ($this->debug) echo "line with bracket at line end [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}

<YYINITIAL, INLINEINTERNALTAG, INCODE, INPRE, INTAG> . {
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}