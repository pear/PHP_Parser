<?php
define('PHP_PARSER_DOCBLOCK_DEFAULTLEXER_ERROR', 1);
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
define('PHP_PARSER_DOCLEX_NL', ++$a); // newline character
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
    function advance()
    {
        $lex = $this->yylex();
        if ($lex) {
            $this->token = $lex[0];
            $this->tokenWithWhitespace = $lex[0];
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
        $ret = PHP_Parser_Stack::staticPush('PHP_Parser_Docblock_DefaultLexer',
            PHP_PARSER_DOCBLOCK_DEFAULTLEXER_ERROR,
            'error', $params,
            $m);
        if ($params['fatal']) {
            exit;
        }
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
                    echo "error, number should be ".($this->_lastNum + 1)." and is [".$this->yytext()."]\n";
                    exit;
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
                            echo "error, no dot[".$this->yytext()."]\n";
                            exit;
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


    var $yy_reader;
    var $yy_buffer_index;
    var $yy_buffer_read;
    var $yy_buffer_start;
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
        $this->debug = true;
        $this->yyline = 1;
    }

    var $yy_state_dtrans = array  ( 
        0,
        95,
        96,
        15,
        98,
        101,
        108,
        111,
        114,
        115,
        116,
        124
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
        "Error: Unmatched input.\n"
        );


    function yy_error ($code,$fatal)
    {
        if (method_exists($this,'raiseError')) { 
 	    return $this->raiseError($code, $this->yy_error_string[$code], $fatal); 
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
        /* 30 */   YY_NO_ANCHOR,
        /* 31 */   YY_NO_ANCHOR,
        /* 32 */   YY_NO_ANCHOR,
        /* 33 */   YY_NOT_ACCEPT,
        /* 34 */   YY_NO_ANCHOR,
        /* 35 */   YY_NO_ANCHOR,
        /* 36 */   YY_NO_ANCHOR,
        /* 37 */   YY_NO_ANCHOR,
        /* 38 */   YY_NO_ANCHOR,
        /* 39 */   YY_NO_ANCHOR,
        /* 40 */   YY_NO_ANCHOR,
        /* 41 */   YY_NO_ANCHOR,
        /* 42 */   YY_NO_ANCHOR,
        /* 43 */   YY_NO_ANCHOR,
        /* 44 */   YY_NO_ANCHOR,
        /* 45 */   YY_NO_ANCHOR,
        /* 46 */   YY_NOT_ACCEPT,
        /* 47 */   YY_NO_ANCHOR,
        /* 48 */   YY_NO_ANCHOR,
        /* 49 */   YY_NO_ANCHOR,
        /* 50 */   YY_NO_ANCHOR,
        /* 51 */   YY_NO_ANCHOR,
        /* 52 */   YY_NO_ANCHOR,
        /* 53 */   YY_NO_ANCHOR,
        /* 54 */   YY_NO_ANCHOR,
        /* 55 */   YY_NO_ANCHOR,
        /* 56 */   YY_NOT_ACCEPT,
        /* 57 */   YY_NO_ANCHOR,
        /* 58 */   YY_NO_ANCHOR,
        /* 59 */   YY_NO_ANCHOR,
        /* 60 */   YY_NO_ANCHOR,
        /* 61 */   YY_NO_ANCHOR,
        /* 62 */   YY_NO_ANCHOR,
        /* 63 */   YY_NO_ANCHOR,
        /* 64 */   YY_NO_ANCHOR,
        /* 65 */   YY_NOT_ACCEPT,
        /* 66 */   YY_NO_ANCHOR,
        /* 67 */   YY_NO_ANCHOR,
        /* 68 */   YY_NO_ANCHOR,
        /* 69 */   YY_NO_ANCHOR,
        /* 70 */   YY_NO_ANCHOR,
        /* 71 */   YY_NO_ANCHOR,
        /* 72 */   YY_NO_ANCHOR,
        /* 73 */   YY_NOT_ACCEPT,
        /* 74 */   YY_NO_ANCHOR,
        /* 75 */   YY_NO_ANCHOR,
        /* 76 */   YY_NO_ANCHOR,
        /* 77 */   YY_NOT_ACCEPT,
        /* 78 */   YY_NO_ANCHOR,
        /* 79 */   YY_NO_ANCHOR,
        /* 80 */   YY_NO_ANCHOR,
        /* 81 */   YY_NOT_ACCEPT,
        /* 82 */   YY_NO_ANCHOR,
        /* 83 */   YY_NO_ANCHOR,
        /* 84 */   YY_NO_ANCHOR,
        /* 85 */   YY_NOT_ACCEPT,
        /* 86 */   YY_NO_ANCHOR,
        /* 87 */   YY_NO_ANCHOR,
        /* 88 */   YY_NOT_ACCEPT,
        /* 89 */   YY_NO_ANCHOR,
        /* 90 */   YY_NOT_ACCEPT,
        /* 91 */   YY_NO_ANCHOR,
        /* 92 */   YY_NOT_ACCEPT,
        /* 93 */   YY_NOT_ACCEPT,
        /* 94 */   YY_NOT_ACCEPT,
        /* 95 */   YY_NOT_ACCEPT,
        /* 96 */   YY_NOT_ACCEPT,
        /* 97 */   YY_NOT_ACCEPT,
        /* 98 */   YY_NOT_ACCEPT,
        /* 99 */   YY_NOT_ACCEPT,
        /* 100 */   YY_NOT_ACCEPT,
        /* 101 */   YY_NOT_ACCEPT,
        /* 102 */   YY_NOT_ACCEPT,
        /* 103 */   YY_NOT_ACCEPT,
        /* 104 */   YY_NOT_ACCEPT,
        /* 105 */   YY_NOT_ACCEPT,
        /* 106 */   YY_NOT_ACCEPT,
        /* 107 */   YY_NOT_ACCEPT,
        /* 108 */   YY_NOT_ACCEPT,
        /* 109 */   YY_NOT_ACCEPT,
        /* 110 */   YY_NOT_ACCEPT,
        /* 111 */   YY_NOT_ACCEPT,
        /* 112 */   YY_NOT_ACCEPT,
        /* 113 */   YY_NOT_ACCEPT,
        /* 114 */   YY_NOT_ACCEPT,
        /* 115 */   YY_NOT_ACCEPT,
        /* 116 */   YY_NOT_ACCEPT,
        /* 117 */   YY_NOT_ACCEPT,
        /* 118 */   YY_NOT_ACCEPT,
        /* 119 */   YY_NOT_ACCEPT,
        /* 120 */   YY_NOT_ACCEPT,
        /* 121 */   YY_NOT_ACCEPT,
        /* 122 */   YY_NOT_ACCEPT,
        /* 123 */   YY_NOT_ACCEPT,
        /* 124 */   YY_NOT_ACCEPT,
        /* 125 */   YY_NOT_ACCEPT,
        /* 126 */   YY_NOT_ACCEPT,
        /* 127 */   YY_NOT_ACCEPT,
        /* 128 */   YY_NOT_ACCEPT,
        /* 129 */   YY_NOT_ACCEPT,
        /* 130 */   YY_NOT_ACCEPT,
        /* 131 */   YY_NO_ANCHOR,
        /* 132 */   YY_NO_ANCHOR,
        /* 133 */   YY_NO_ANCHOR,
        /* 134 */   YY_NO_ANCHOR,
        /* 135 */   YY_NOT_ACCEPT,
        /* 136 */   YY_NO_ANCHOR,
        /* 137 */   YY_NOT_ACCEPT,
        /* 138 */   YY_NOT_ACCEPT,
        /* 139 */   YY_NO_ANCHOR,
        /* 140 */   YY_NO_ANCHOR,
        /* 141 */   YY_NO_ANCHOR,
        /* 142 */   YY_NOT_ACCEPT,
        /* 143 */   YY_NO_ANCHOR,
        /* 144 */   YY_NO_ANCHOR,
        /* 145 */   YY_NO_ANCHOR,
        /* 146 */   YY_NOT_ACCEPT,
        /* 147 */   YY_NO_ANCHOR,
        /* 148 */   YY_NO_ANCHOR,
        /* 149 */   YY_NO_ANCHOR,
        /* 150 */   YY_NO_ANCHOR,
        /* 151 */   YY_NO_ANCHOR,
        /* 152 */   YY_NO_ANCHOR
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
        16, 17, 1, 18, 18, 1, 19, 19,
        1, 7, 17, 20, 21, 21, 1, 1,
        22, 23, 24, 1, 25, 26, 6, 27,
        7, 1, 1, 21, 21, 28, 29, 30,
        31, 32, 33, 33, 33, 33, 34, 35,
        36, 37, 16, 16, 16, 16, 38, 39,
        40, 41, 42, 43, 44, 45, 46, 47,
        48, 49, 50, 51, 52, 53, 54, 55,
        56, 57, 58, 59, 60, 61, 62, 63,
        64, 65, 66, 67, 68, 69, 70, 17,
        71, 72, 73, 74, 75, 76, 77, 78,
        79, 14, 80, 81, 82, 83, 84, 85,
        86, 87, 88, 89, 90, 91, 92, 93,
        94, 95, 96, 97, 21, 33, 98, 99,
        100, 101, 102, 103, 104, 105, 106, 107,
        108, 109, 110, 111, 112, 113, 114, 115,
        116 
        );


    var $yy_nxt = array(
        array( 1, 2, 3, 4, 3, 3, 3, 3,
            3, 3, 3, 3, 3, 3, 3, 3,
            3, 34, 3, 3, 3, 3, 3, 3,
            3 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 2, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 3, 33, 3, 3, 3, 3,
            3, 3, 3, 3, 3, 3, 3, 3,
            3, 46, 3, 3, 3, 3, 3, 3,
            3 ),
        array( -1, 5, 33, 135, 142, 56, 56, 56,
            56, 35, 33, 56, 56, 56, 48, 33,
            33, 46, 33, 56, 56, 56, 56, 56,
            33 ),
        array( -1, 5, -1, -1, -1, -1, -1, -1,
            -1, 5, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 7, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 33, 33, 33, 33, 33, 33,
            33, 33, 33, 33, 33, 33, 33, 33,
            33, 46, 33, 33, 33, 33, 33, 33,
            33 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 13, 13,
            -1 ),
        array( 1, 41, 16, 41, 41, 41, 41, 41,
            41, 41, 41, 41, 41, 41, 41, 41,
            41, 41, 41, 41, 41, 41, 41, 41,
            41 ),
        array( -1, -1, 99, 139, 143, 62, 62, 62,
            62, 132, 132, 62, 62, 62, 132, 132,
            132, 46, 132, 62, 62, 62, 62, 62,
            132 ),
        array( -1, 19, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 20, -1, 20, 20, 20, 20,
            20, 20, 20, 20, 20, 20, 20, 20,
            20, -1, 20, 20, 20, 20, 20, 20,
            20 ),
        array( -1, -1, 110, 140, 144, 44, 44, 44,
            44, 133, 133, 44, 44, 44, 133, 133,
            133, -1, 133, 44, 44, 44, 44, 44,
            133 ),
        array( -1, -1, -1, -1, -1, 22, 22, 22,
            22, -1, -1, 22, 22, 22, -1, -1,
            -1, -1, -1, 22, 22, 22, 22, 22,
            -1 ),
        array( -1, 23, -1, -1, -1, -1, -1, -1,
            -1, 112, -1, -1, -1, -1, -1, 113,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 24, 24, 24, 24, 24, 24,
            24, 24, 24, 24, 24, 24, 24, 24,
            24, -1, 24, 24, 24, 24, 24, 24,
            24 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, 6,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 28, 28, -1, 28, 28, 28, 28,
            28, 28, 28, 28, 28, 28, 28, 28,
            28, -1, 28, 28, 28, 28, 28, 28,
            28 ),
        array( -1, 31, 31, -1, 31, 31, 31, 31,
            31, 31, 31, 31, 31, 31, 31, 31,
            31, -1, 31, 31, 31, 31, 31, 31,
            31 ),
        array( -1, 5, 33, 33, 33, 33, 33, 33,
            33, 35, 33, 33, 33, 33, 33, 33,
            33, 46, 33, 33, 33, 33, 33, 33,
            33 ),
        array( -1, -1, 99, 132, 132, 132, 132, 132,
            132, 132, 132, 132, 132, 132, 132, 132,
            132, 46, 132, 132, 132, 132, 132, 132,
            132 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 13, 14,
            -1 ),
        array( -1, 41, -1, 41, 41, 41, 41, 41,
            41, 41, 41, 41, 41, 41, 41, 41,
            41, 41, 41, 41, 41, 41, 41, 41,
            41 ),
        array( -1, -1, 100, 42, 42, 42, 42, 42,
            42, 42, 42, 42, 42, 42, 42, 42,
            42, -1, 42, 42, 42, 42, 42, 42,
            42 ),
        array( -1, 77, 110, 133, 71, 44, 44, 44,
            44, 75, 58, 44, 44, 44, 133, 133,
            133, -1, 133, 44, 44, 44, 44, 44,
            133 ),
        array( -1, 77, 24, 24, 72, 45, 45, 45,
            45, 76, 66, 45, 45, 45, 24, 24,
            24, -1, 24, 45, 45, 45, 45, 45,
            24 ),
        array( -1, 42, 18, 132, 132, 132, 132, 132,
            132, 132, 132, 132, 132, 132, 132, 132,
            132, 53, 132, 132, 132, 132, 132, 132,
            132 ),
        array( -1, 7, 100, 42, 42, 42, 42, 42,
            42, 42, 42, 42, 42, 42, 42, 42,
            42, -1, 42, 42, 42, 42, 42, 42,
            42 ),
        array( -1, 137, 110, 133, 79, 54, 54, 54,
            54, 83, 87, 54, 54, 54, 133, 133,
            133, -1, 133, 54, 54, 54, 54, 54,
            133 ),
        array( -1, 137, 24, 24, 147, 55, 55, 55,
            55, 80, 84, 55, 55, 55, 24, 24,
            24, -1, 24, 55, 55, 55, 55, 55,
            24 ),
        array( -1, 77, 33, 33, 81, 56, 56, 56,
            56, 85, 8, 56, 56, 56, 33, 33,
            33, 46, 33, 56, 56, 56, 56, 56,
            33 ),
        array( -1, -1, -1, 117, 138, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 110, 133, 133, 133, 133, 133,
            133, 133, 133, 133, 133, 133, 133, 133,
            133, -1, 133, 133, 133, 133, 133, 133,
            133 ),
        array( -1, 77, 99, 132, 78, 62, 62, 62,
            62, 82, 36, 62, 62, 62, 132, 132,
            132, 46, 132, 62, 62, 62, 62, 62,
            132 ),
        array( -1, -1, 110, 133, 133, 63, 63, 63,
            63, 133, 59, 63, 63, 63, 133, 133,
            133, -1, 133, 63, 63, 63, 63, 63,
            133 ),
        array( -1, -1, 24, 24, 24, 64, 64, 64,
            64, 24, 67, 64, 64, 64, 24, 24,
            24, -1, 24, 64, 64, 64, 64, 64,
            24 ),
        array( -1, 137, 33, 33, 146, 65, 65, 65,
            65, 88, 90, 65, 65, 65, 33, 33,
            33, 46, 33, 65, 65, 65, 65, 65,
            33 ),
        array( -1, 137, 99, 132, 86, 70, 70, 70,
            70, 89, 91, 70, 70, 70, 132, 132,
            132, 46, 132, 70, 70, 70, 70, 70,
            132 ),
        array( -1, -1, 110, 133, 133, 133, 133, 133,
            133, 133, 60, 133, 133, 133, 133, 133,
            133, -1, 133, 133, 133, 133, 133, 133,
            133 ),
        array( -1, -1, 24, 24, 24, 24, 24, 24,
            24, 24, 68, 24, 24, 24, 24, 24,
            24, -1, 24, 24, 24, 24, 24, 24,
            24 ),
        array( -1, -1, 33, 33, 33, 73, 73, 73,
            73, 33, 9, 73, 73, 73, 33, 33,
            33, 46, 33, 73, 73, 73, 73, 73,
            33 ),
        array( -1, -1, 99, 132, 132, 74, 74, 74,
            74, 132, 37, 74, 74, 74, 132, 132,
            132, 46, 132, 74, 74, 74, 74, 74,
            132 ),
        array( -1, 77, 110, 133, 71, 133, 133, 133,
            133, 75, 133, 133, 133, 133, 133, 133,
            133, -1, 133, 133, 133, 133, 133, 133,
            133 ),
        array( -1, 77, 24, 24, 72, 24, 24, 24,
            24, 76, 24, 24, 24, 24, 24, 24,
            24, -1, 24, 24, 24, 24, 24, 24,
            24 ),
        array( -1, 77, -1, -1, 92, -1, -1, -1,
            -1, 77, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 99, 132, 132, 132, 132, 132,
            132, 132, 51, 132, 132, 132, 132, 132,
            132, 46, 132, 132, 132, 132, 132, 132,
            132 ),
        array( -1, -1, 110, 133, 133, 133, 133, 133,
            133, 133, 87, 133, 133, 133, 133, 133,
            133, -1, 133, 133, 133, 133, 133, 133,
            133 ),
        array( -1, 137, 24, 24, 147, 24, 24, 24,
            24, 80, 24, 24, 24, 24, 24, 24,
            24, -1, 24, 24, 24, 24, 24, 24,
            24 ),
        array( -1, -1, 33, 33, 33, 33, 33, 33,
            33, 33, 10, 33, 33, 33, 33, 33,
            33, 46, 33, 33, 33, 33, 33, 33,
            33 ),
        array( -1, 77, 99, 132, 78, 132, 132, 132,
            132, 82, 132, 132, 132, 132, 132, 132,
            132, 46, 132, 132, 132, 132, 132, 132,
            132 ),
        array( -1, 137, 110, 133, 79, 133, 133, 133,
            133, 83, 133, 133, 133, 133, 133, 133,
            133, -1, 133, 133, 133, 133, 133, 133,
            133 ),
        array( -1, -1, 24, 24, 24, 24, 24, 24,
            24, 24, 69, 24, 24, 24, 24, 24,
            24, -1, 24, 24, 24, 24, 24, 24,
            24 ),
        array( -1, 77, 33, 33, 81, 33, 33, 33,
            33, 85, 33, 33, 33, 33, 33, 33,
            33, 46, 33, 33, 33, 33, 33, 33,
            33 ),
        array( -1, -1, 99, 132, 132, 132, 132, 132,
            132, 132, 91, 132, 132, 132, 132, 132,
            132, 46, 132, 132, 132, 132, 132, 132,
            132 ),
        array( -1, -1, 110, 133, 133, 133, 133, 133,
            133, 133, 61, 133, 133, 133, 133, 133,
            133, -1, 133, 133, 133, 133, 133, 133,
            133 ),
        array( -1, 137, 33, 33, 146, 33, 33, 33,
            33, 88, 33, 33, 33, 33, 33, 33,
            33, 46, 33, 33, 33, 33, 33, 33,
            33 ),
        array( -1, 137, 99, 132, 86, 132, 132, 132,
            132, 89, 132, 132, 132, 132, 132, 132,
            132, 46, 132, 132, 132, 132, 132, 132,
            132 ),
        array( -1, -1, 33, 33, 33, 33, 33, 33,
            33, 33, 11, 33, 33, 33, 33, 33,
            33, 46, 33, 33, 33, 33, 33, 33,
            33 ),
        array( -1, -1, 99, 132, 132, 132, 132, 132,
            132, 132, 52, 132, 132, 132, 132, 132,
            132, 46, 132, 132, 132, 132, 132, 132,
            132 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 38, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 94, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 39, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( 1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( 1, -1, 12, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, 97, 152, 13, 13, 13, 13,
            -1 ),
        array( -1, -1, 12, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( 1, 2, 47, 17, 132, 132, 132, 132,
            132, 132, 132, 132, 132, 132, 132, 132,
            132, 34, 132, 132, 132, 132, 132, 132,
            132 ),
        array( -1, 42, 33, 132, 132, 132, 132, 132,
            132, 132, 132, 132, 132, 132, 132, 132,
            132, 53, 132, 132, 132, 132, 132, 132,
            132 ),
        array( -1, 42, -1, 42, 42, 42, 42, 42,
            42, 42, 42, 42, 42, 42, 42, 42,
            42, 42, 42, 42, 42, 42, 42, 42,
            42 ),
        array( 1, 19, 20, 102, 20, 20, 20, 20,
            20, 20, 20, 20, 20, 20, 20, 20,
            20, 103, 20, 20, 20, 20, 20, 20,
            20 ),
        array( -1, -1, -1, 104, 138, 105, 105, 105,
            105, -1, -1, 105, 105, 105, -1, -1,
            -1, -1, -1, 105, 105, 105, 105, 105,
            -1 ),
        array( -1, -1, -1, -1, -1, 106, 106, 106,
            106, -1, -1, 106, 106, 106, -1, -1,
            -1, -1, -1, 106, 106, 106, 106, 106,
            -1 ),
        array( -1, 77, -1, -1, 92, 105, 105, 105,
            105, 77, 49, 105, 105, 105, -1, -1,
            -1, -1, -1, 105, 105, 105, 105, 105,
            -1 ),
        array( -1, 137, -1, -1, 93, 106, 106, 106,
            106, 137, 94, 106, 106, 106, -1, -1,
            -1, -1, -1, 106, 106, 106, 106, 106,
            -1 ),
        array( -1, -1, -1, -1, -1, 107, 107, 107,
            107, -1, 50, 107, 107, 107, -1, -1,
            -1, -1, -1, 107, 107, 107, 107, 107,
            -1 ),
        array( 1, 19, 109, 21, 133, 133, 133, 133,
            133, 133, 133, 133, 133, 133, 133, 133,
            133, 103, 133, 133, 133, 133, 133, 133,
            133 ),
        array( -1, 133, 43, 133, 133, 133, 133, 133,
            133, 133, 133, 133, 133, 133, 133, 133,
            133, 133, 133, 133, 133, 133, 133, 133,
            133 ),
        array( -1, 133, -1, 133, 133, 133, 133, 133,
            133, 133, 133, 133, 133, 133, 133, 133,
            133, 133, 133, 133, 133, 133, 133, 133,
            133 ),
        array( 1, 112, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 112, -1, -1, -1, -1, -1, -1,
            -1, 112, -1, -1, -1, -1, -1, 113,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( 1, 23, 24, 134, 24, 24, 24, 24,
            24, 24, 24, 24, 24, 24, 24, 24,
            24, 25, 24, 24, 24, 24, 24, 24,
            24 ),
        array( 1, 26, 26, 26, 26, 26, 26, 26,
            26, 26, 26, 26, 26, 26, 26, 26,
            -1, 26, 26, 26, 26, 26, 26, 26,
            26 ),
        array( 1, 27, 28, 57, 28, 28, 28, 28,
            28, 28, 28, 28, 28, 28, 28, 28,
            28, 34, 28, 28, 28, 28, 28, 28,
            28 ),
        array( -1, -1, -1, -1, 118, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, 119, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, 120, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, 121,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            122, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 122, -1, -1, -1, -1, -1, -1,
            -1, 122, 123, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 29, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( 1, 30, 31, 136, 31, 31, 31, 31,
            31, 31, 31, 31, 31, 31, 31, 31,
            31, 34, 31, 31, 31, 31, 31, 31,
            31 ),
        array( -1, -1, -1, -1, 126, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, 127, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, 128, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            129, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 129, -1, -1, -1, -1, -1, -1,
            -1, 129, 130, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 32, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 40, 13,
            -1 ),
        array( -1, -1, 24, 141, 145, 45, 45, 45,
            45, 24, 24, 45, 45, 45, 24, 24,
            24, -1, 24, 45, 45, 45, 45, 45,
            24 ),
        array( -1, -1, 33, 33, 33, 65, 65, 65,
            65, 33, 33, 65, 65, 65, 33, 33,
            33, 46, 33, 65, 65, 65, 65, 65,
            33 ),
        array( -1, -1, -1, 125, 138, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 137, -1, -1, 93, -1, -1, -1,
            -1, 137, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, 107, 107, 107,
            107, -1, -1, 107, 107, 107, -1, -1,
            -1, -1, -1, 107, 107, 107, 107, 107,
            -1 ),
        array( -1, -1, 99, 132, 132, 70, 70, 70,
            70, 132, 132, 70, 70, 70, 132, 132,
            132, 46, 132, 70, 70, 70, 70, 70,
            132 ),
        array( -1, -1, 110, 133, 133, 54, 54, 54,
            54, 133, 133, 54, 54, 54, 133, 133,
            133, -1, 133, 54, 54, 54, 54, 54,
            133 ),
        array( -1, -1, 24, 24, 24, 55, 55, 55,
            55, 24, 24, 55, 55, 55, 24, 24,
            24, -1, 24, 55, 55, 55, 55, 55,
            24 ),
        array( -1, -1, 33, 33, 33, 73, 73, 73,
            73, 33, 33, 73, 73, 73, 33, 33,
            33, 46, 33, 73, 73, 73, 73, 73,
            33 ),
        array( -1, -1, 99, 132, 132, 74, 74, 74,
            74, 132, 132, 74, 74, 74, 132, 132,
            132, 46, 132, 74, 74, 74, 74, 74,
            132 ),
        array( -1, -1, 110, 133, 133, 63, 63, 63,
            63, 133, 133, 63, 63, 63, 133, 133,
            133, -1, 133, 63, 63, 63, 63, 63,
            133 ),
        array( -1, -1, 24, 24, 24, 64, 64, 64,
            64, 24, 24, 64, 64, 64, 24, 24,
            24, -1, 24, 64, 64, 64, 64, 64,
            24 ),
        array( -1, -1, 33, 33, 33, 33, 33, 33,
            33, 33, 90, 33, 33, 33, 33, 33,
            33, 46, 33, 33, 33, 33, 33, 33,
            33 ),
        array( -1, -1, 24, 24, 24, 24, 24, 24,
            24, 24, 84, 24, 24, 24, 24, 24,
            24, -1, 24, 24, 24, 24, 24, 24,
            24 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 131, 13, 13, 13,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 148, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 13, 13,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            149, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 13, 13,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 150, 13, 13,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 151, 13, 13, 13,
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
                } else {
                    $yy_anchor = $this->yy_acpt[$yy_last_accept_state];
                    if (0 != (YY_END & $yy_anchor)) {
                        $this->yy_move_end();
                    }
                    $this->yy_to_mark();
                    if ($yy_last_accept_state < 0) {
                       if ($yy_last_accept_state < 153) {
                           $this->yy_error(YY_E_INTERNAL, false);
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
    if ($this->yy_lexical_state == INLINEINTERNALTAG) $this->fuck = true;
    if ($this->debug) echo "initial newline ".strlen($this->yytext())."\n";
    if (isset($this->fuck)) {
        $this->fuckyou = true;
    }
    return array(PHP_PARSER_DOCLEX_NL, $this->yytext());
}
case 3:
{
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
                $tag = array_shift(preg_split('/\s+/',$this->yytext()));
                $this->yy_buffer_end = $this->yy_buffer_index = strlen($tag);
                if ($this->debug) echo "new tag start [".trim($this->yytext())."]\n";
                $this->_atNewLine = false;
                return array(PHP_PARSER_DOCLEX_TAG, trim($this->yytext()));
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
    if ($this->debug) echo "complete tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_XML_TAG, $this->yytext());
}
case 11:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 18:
{
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
case 19:
{
    if ($this->debug) echo "simplelist newline\n";
    if (strlen($this->yytext()) > 1) {
        // A simple list may not contain double newlines
        $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
        $this->yy_start($this->_listOriginal);
        return array(PHP_PARSER_DOCLEX_SIMPLELIST_END, '');
    }
    $this->_atNewLine = true;
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
    if ($this->debug) echo "tags newline\n";
    $this->_atNewLine = true;
    $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start + 1;
    return array(PHP_PARSER_DOCLEX_NL, $this->yytext());
}
case 24:
{
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
case 25:
{
    if ($this->debug) echo "in tag normal bracket [{]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 26:
{
    if ($this->debug) echo "inline tag name [".$this->_tagName."]\n";
    $this->yybegin(INLINETAG);
    $this->yy_buffer_end = $this->yy_buffer_index = $this->yy_buffer_start;
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_NAME, $this->_tagName);
}
case 27:
{
    if ($this->debug) echo '<code> newline ['.$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_NL, $this->yytext());
}
case 28:
{
        if ($this->debug) echo "normal code text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 29:
{
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}
case 30:
{
    if ($this->debug) echo '<pre> newline ['.$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_NL, $this->yytext());
}
case 31:
{
        if ($this->debug) echo "normal pre text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 32:
{
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}
case 34:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 35:
{
    if ($this->debug) echo "1 normal desc text [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 36:
{
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
case 37:
{
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
case 38:
{
    if ($this->debug) echo "complete tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_XML_TAG, $this->yytext());
}
case 39:
{
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}
case 40:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 41:
{
    if ($this->debug) echo "inline tag $this->_tagName contents [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_CONTENTS, $this->yytext());
}
case 42:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 43:
{
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
case 44:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 45:
{
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
case 47:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 48:
{
    if ($this->debug) echo "1 normal desc text [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 49:
{
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
case 50:
{
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
case 51:
{
    if ($this->debug) echo "complete tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_XML_TAG, $this->yytext());
}
case 52:
{
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}
case 53:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 54:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 55:
{
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
case 57:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 58:
{
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
case 59:
{
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
case 60:
{
    if ($this->debug) echo "complete tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_XML_TAG, $this->yytext());
}
case 61:
{
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}
case 62:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 63:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 64:
{
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
case 66:
{
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
case 67:
{
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
case 68:
{
    if ($this->debug) echo "complete tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_XML_TAG, $this->yytext());
}
case 69:
{
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}
case 70:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 71:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 72:
{
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
case 74:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 75:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 76:
{
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
case 78:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 79:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 80:
{
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
case 82:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 83:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 84:
{
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
case 86:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 87:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 89:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 91:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 131:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 132:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 133:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 134:
{
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
case 136:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 139:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 140:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 141:
{
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
case 143:
{
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
        $this->fuck = true;
        if ($this->debug) echo "3 normal desc text [".$this->yytext()."]\n";
        return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
    }
}
case 144:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 145:
{
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
case 147:
{
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
case 148:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 149:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 150:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 151:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 152:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}

                        }
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
