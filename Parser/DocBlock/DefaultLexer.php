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
        $this->debug = false;
        $this->yyline = 1;
    }

    var $yy_state_dtrans = array  ( 
        0,
        93,
        94,
        15,
        96,
        99,
        106,
        109,
        112,
        113,
        114,
        136
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
        /* 31 */   YY_NOT_ACCEPT,
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
        /* 42 */   YY_NO_ANCHOR,
        /* 43 */   YY_NO_ANCHOR,
        /* 44 */   YY_NOT_ACCEPT,
        /* 45 */   YY_NO_ANCHOR,
        /* 46 */   YY_NO_ANCHOR,
        /* 47 */   YY_NO_ANCHOR,
        /* 48 */   YY_NO_ANCHOR,
        /* 49 */   YY_NO_ANCHOR,
        /* 50 */   YY_NO_ANCHOR,
        /* 51 */   YY_NO_ANCHOR,
        /* 52 */   YY_NO_ANCHOR,
        /* 53 */   YY_NO_ANCHOR,
        /* 54 */   YY_NOT_ACCEPT,
        /* 55 */   YY_NO_ANCHOR,
        /* 56 */   YY_NO_ANCHOR,
        /* 57 */   YY_NO_ANCHOR,
        /* 58 */   YY_NO_ANCHOR,
        /* 59 */   YY_NO_ANCHOR,
        /* 60 */   YY_NO_ANCHOR,
        /* 61 */   YY_NO_ANCHOR,
        /* 62 */   YY_NO_ANCHOR,
        /* 63 */   YY_NOT_ACCEPT,
        /* 64 */   YY_NO_ANCHOR,
        /* 65 */   YY_NO_ANCHOR,
        /* 66 */   YY_NO_ANCHOR,
        /* 67 */   YY_NO_ANCHOR,
        /* 68 */   YY_NO_ANCHOR,
        /* 69 */   YY_NO_ANCHOR,
        /* 70 */   YY_NO_ANCHOR,
        /* 71 */   YY_NOT_ACCEPT,
        /* 72 */   YY_NO_ANCHOR,
        /* 73 */   YY_NO_ANCHOR,
        /* 74 */   YY_NO_ANCHOR,
        /* 75 */   YY_NOT_ACCEPT,
        /* 76 */   YY_NO_ANCHOR,
        /* 77 */   YY_NO_ANCHOR,
        /* 78 */   YY_NO_ANCHOR,
        /* 79 */   YY_NOT_ACCEPT,
        /* 80 */   YY_NO_ANCHOR,
        /* 81 */   YY_NO_ANCHOR,
        /* 82 */   YY_NO_ANCHOR,
        /* 83 */   YY_NOT_ACCEPT,
        /* 84 */   YY_NO_ANCHOR,
        /* 85 */   YY_NO_ANCHOR,
        /* 86 */   YY_NOT_ACCEPT,
        /* 87 */   YY_NO_ANCHOR,
        /* 88 */   YY_NOT_ACCEPT,
        /* 89 */   YY_NO_ANCHOR,
        /* 90 */   YY_NOT_ACCEPT,
        /* 91 */   YY_NOT_ACCEPT,
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
        /* 128 */   YY_NO_ANCHOR,
        /* 129 */   YY_NO_ANCHOR,
        /* 130 */   YY_NO_ANCHOR,
        /* 131 */   YY_NO_ANCHOR,
        /* 132 */   YY_NOT_ACCEPT,
        /* 133 */   YY_NO_ANCHOR,
        /* 134 */   YY_NOT_ACCEPT,
        /* 135 */   YY_NOT_ACCEPT,
        /* 136 */   YY_NOT_ACCEPT,
        /* 137 */   YY_NO_ANCHOR,
        /* 138 */   YY_NO_ANCHOR,
        /* 139 */   YY_NO_ANCHOR,
        /* 140 */   YY_NOT_ACCEPT,
        /* 141 */   YY_NO_ANCHOR,
        /* 142 */   YY_NO_ANCHOR,
        /* 143 */   YY_NO_ANCHOR,
        /* 144 */   YY_NOT_ACCEPT,
        /* 145 */   YY_NO_ANCHOR,
        /* 146 */   YY_NO_ANCHOR,
        /* 147 */   YY_NO_ANCHOR,
        /* 148 */   YY_NO_ANCHOR,
        /* 149 */   YY_NO_ANCHOR,
        /* 150 */   YY_NO_ANCHOR
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
        16, 17, 1, 18, 18, 1, 1, 7,
        17, 19, 20, 20, 1, 1, 21, 22,
        23, 1, 24, 25, 6, 26, 7, 1,
        1, 20, 20, 27, 28, 29, 30, 31,
        32, 32, 32, 32, 33, 34, 35, 36,
        16, 16, 16, 16, 37, 38, 39, 40,
        41, 42, 43, 44, 45, 46, 47, 48,
        49, 50, 51, 52, 53, 54, 55, 56,
        57, 58, 59, 60, 61, 62, 63, 64,
        65, 66, 67, 68, 69, 17, 70, 71,
        72, 73, 74, 75, 76, 77, 78, 14,
        79, 80, 81, 82, 83, 84, 85, 86,
        87, 88, 89, 90, 91, 92, 93, 94,
        95, 20, 32, 96, 97, 98, 99, 100,
        101, 102, 103, 104, 105, 106, 107, 108,
        109, 110, 111, 112, 113, 114, 115 
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
        array( -1, -1, 3, 31, 3, 3, 3, 3,
            3, 3, 3, 3, 3, 3, 3, 3,
            3, 44, 3, 3, 3, 3, 3, 3,
            3 ),
        array( -1, 5, 31, 132, 140, 54, 54, 54,
            54, 33, 31, 54, 54, 54, 46, 31,
            31, 44, 31, 54, 54, 54, 54, 54,
            31 ),
        array( -1, 5, -1, -1, -1, -1, -1, -1,
            -1, 5, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 7, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 31, 31, 31, 31, 31, 31,
            31, 31, 31, 31, 31, 31, 31, 31,
            31, 44, 31, 31, 31, 31, 31, 31,
            31 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 13, 13,
            -1 ),
        array( 1, 39, 16, 39, 39, 39, 39, 39,
            39, 39, 39, 39, 39, 39, 39, 39,
            39, 39, 39, 39, 39, 39, 39, 39,
            39 ),
        array( -1, -1, 97, 137, 141, 60, 60, 60,
            60, 129, 129, 60, 60, 60, 129, 129,
            129, 44, 129, 60, 60, 60, 60, 60,
            129 ),
        array( -1, 19, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 20, -1, 20, 20, 20, 20,
            20, 20, 20, 20, 20, 20, 20, 20,
            20, -1, 20, 20, 20, 20, 20, 20,
            20 ),
        array( -1, -1, 108, 138, 142, 42, 42, 42,
            42, 130, 130, 42, 42, 42, 130, 130,
            130, -1, 130, 42, 42, 42, 42, 42,
            130 ),
        array( -1, -1, -1, -1, -1, 22, 22, 22,
            22, -1, -1, 22, 22, 22, -1, -1,
            -1, -1, -1, 22, 22, 22, 22, 22,
            -1 ),
        array( -1, 23, -1, -1, -1, -1, -1, -1,
            -1, 110, -1, -1, -1, -1, -1, 111,
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
        array( -1, 5, 31, 31, 31, 31, 31, 31,
            31, 33, 31, 31, 31, 31, 31, 31,
            31, 44, 31, 31, 31, 31, 31, 31,
            31 ),
        array( -1, -1, 97, 129, 129, 129, 129, 129,
            129, 129, 129, 129, 129, 129, 129, 129,
            129, 44, 129, 129, 129, 129, 129, 129,
            129 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 13, 14,
            -1 ),
        array( -1, 39, -1, 39, 39, 39, 39, 39,
            39, 39, 39, 39, 39, 39, 39, 39,
            39, 39, 39, 39, 39, 39, 39, 39,
            39 ),
        array( -1, -1, 98, 40, 40, 40, 40, 40,
            40, 40, 40, 40, 40, 40, 40, 40,
            40, -1, 40, 40, 40, 40, 40, 40,
            40 ),
        array( -1, 75, 108, 130, 69, 42, 42, 42,
            42, 73, 56, 42, 42, 42, 130, 130,
            130, -1, 130, 42, 42, 42, 42, 42,
            130 ),
        array( -1, 75, 24, 24, 70, 43, 43, 43,
            43, 74, 64, 43, 43, 43, 24, 24,
            24, -1, 24, 43, 43, 43, 43, 43,
            24 ),
        array( -1, 40, 18, 129, 129, 129, 129, 129,
            129, 129, 129, 129, 129, 129, 129, 129,
            129, 51, 129, 129, 129, 129, 129, 129,
            129 ),
        array( -1, 7, 98, 40, 40, 40, 40, 40,
            40, 40, 40, 40, 40, 40, 40, 40,
            40, -1, 40, 40, 40, 40, 40, 40,
            40 ),
        array( -1, 134, 108, 130, 77, 52, 52, 52,
            52, 81, 85, 52, 52, 52, 130, 130,
            130, -1, 130, 52, 52, 52, 52, 52,
            130 ),
        array( -1, 134, 24, 24, 145, 53, 53, 53,
            53, 78, 82, 53, 53, 53, 24, 24,
            24, -1, 24, 53, 53, 53, 53, 53,
            24 ),
        array( -1, 75, 31, 31, 79, 54, 54, 54,
            54, 83, 8, 54, 54, 54, 31, 31,
            31, 44, 31, 54, 54, 54, 54, 54,
            31 ),
        array( -1, -1, -1, 115, 135, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 108, 130, 130, 130, 130, 130,
            130, 130, 130, 130, 130, 130, 130, 130,
            130, -1, 130, 130, 130, 130, 130, 130,
            130 ),
        array( -1, 75, 97, 129, 76, 60, 60, 60,
            60, 80, 34, 60, 60, 60, 129, 129,
            129, 44, 129, 60, 60, 60, 60, 60,
            129 ),
        array( -1, -1, 108, 130, 130, 61, 61, 61,
            61, 130, 57, 61, 61, 61, 130, 130,
            130, -1, 130, 61, 61, 61, 61, 61,
            130 ),
        array( -1, -1, 24, 24, 24, 62, 62, 62,
            62, 24, 65, 62, 62, 62, 24, 24,
            24, -1, 24, 62, 62, 62, 62, 62,
            24 ),
        array( -1, 134, 31, 31, 144, 63, 63, 63,
            63, 86, 88, 63, 63, 63, 31, 31,
            31, 44, 31, 63, 63, 63, 63, 63,
            31 ),
        array( -1, 134, 97, 129, 84, 68, 68, 68,
            68, 87, 89, 68, 68, 68, 129, 129,
            129, 44, 129, 68, 68, 68, 68, 68,
            129 ),
        array( -1, -1, 108, 130, 130, 130, 130, 130,
            130, 130, 58, 130, 130, 130, 130, 130,
            130, -1, 130, 130, 130, 130, 130, 130,
            130 ),
        array( -1, -1, 24, 24, 24, 24, 24, 24,
            24, 24, 66, 24, 24, 24, 24, 24,
            24, -1, 24, 24, 24, 24, 24, 24,
            24 ),
        array( -1, -1, 31, 31, 31, 71, 71, 71,
            71, 31, 9, 71, 71, 71, 31, 31,
            31, 44, 31, 71, 71, 71, 71, 71,
            31 ),
        array( -1, -1, 97, 129, 129, 72, 72, 72,
            72, 129, 35, 72, 72, 72, 129, 129,
            129, 44, 129, 72, 72, 72, 72, 72,
            129 ),
        array( -1, 75, 108, 130, 69, 130, 130, 130,
            130, 73, 130, 130, 130, 130, 130, 130,
            130, -1, 130, 130, 130, 130, 130, 130,
            130 ),
        array( -1, 75, 24, 24, 70, 24, 24, 24,
            24, 74, 24, 24, 24, 24, 24, 24,
            24, -1, 24, 24, 24, 24, 24, 24,
            24 ),
        array( -1, 75, -1, -1, 90, -1, -1, -1,
            -1, 75, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, 97, 129, 129, 129, 129, 129,
            129, 129, 49, 129, 129, 129, 129, 129,
            129, 44, 129, 129, 129, 129, 129, 129,
            129 ),
        array( -1, -1, 108, 130, 130, 130, 130, 130,
            130, 130, 85, 130, 130, 130, 130, 130,
            130, -1, 130, 130, 130, 130, 130, 130,
            130 ),
        array( -1, 134, 24, 24, 145, 24, 24, 24,
            24, 78, 24, 24, 24, 24, 24, 24,
            24, -1, 24, 24, 24, 24, 24, 24,
            24 ),
        array( -1, -1, 31, 31, 31, 31, 31, 31,
            31, 31, 10, 31, 31, 31, 31, 31,
            31, 44, 31, 31, 31, 31, 31, 31,
            31 ),
        array( -1, 75, 97, 129, 76, 129, 129, 129,
            129, 80, 129, 129, 129, 129, 129, 129,
            129, 44, 129, 129, 129, 129, 129, 129,
            129 ),
        array( -1, 134, 108, 130, 77, 130, 130, 130,
            130, 81, 130, 130, 130, 130, 130, 130,
            130, -1, 130, 130, 130, 130, 130, 130,
            130 ),
        array( -1, -1, 24, 24, 24, 24, 24, 24,
            24, 24, 67, 24, 24, 24, 24, 24,
            24, -1, 24, 24, 24, 24, 24, 24,
            24 ),
        array( -1, 75, 31, 31, 79, 31, 31, 31,
            31, 83, 31, 31, 31, 31, 31, 31,
            31, 44, 31, 31, 31, 31, 31, 31,
            31 ),
        array( -1, -1, 97, 129, 129, 129, 129, 129,
            129, 129, 89, 129, 129, 129, 129, 129,
            129, 44, 129, 129, 129, 129, 129, 129,
            129 ),
        array( -1, -1, 108, 130, 130, 130, 130, 130,
            130, 130, 59, 130, 130, 130, 130, 130,
            130, -1, 130, 130, 130, 130, 130, 130,
            130 ),
        array( -1, 134, 31, 31, 144, 31, 31, 31,
            31, 86, 31, 31, 31, 31, 31, 31,
            31, 44, 31, 31, 31, 31, 31, 31,
            31 ),
        array( -1, 134, 97, 129, 84, 129, 129, 129,
            129, 87, 129, 129, 129, 129, 129, 129,
            129, 44, 129, 129, 129, 129, 129, 129,
            129 ),
        array( -1, -1, 31, 31, 31, 31, 31, 31,
            31, 31, 11, 31, 31, 31, 31, 31,
            31, 44, 31, 31, 31, 31, 31, 31,
            31 ),
        array( -1, -1, 97, 129, 129, 129, 129, 129,
            129, 129, 50, 129, 129, 129, 129, 129,
            129, 44, 129, 129, 129, 129, 129, 129,
            129 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 36, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 92, -1, -1, -1, -1, -1,
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
            -1, -1, 95, 150, 13, 13, 13, 13,
            -1 ),
        array( -1, -1, 12, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( 1, 2, 45, 17, 129, 129, 129, 129,
            129, 129, 129, 129, 129, 129, 129, 129,
            129, 32, 129, 129, 129, 129, 129, 129,
            129 ),
        array( -1, 40, 31, 129, 129, 129, 129, 129,
            129, 129, 129, 129, 129, 129, 129, 129,
            129, 51, 129, 129, 129, 129, 129, 129,
            129 ),
        array( -1, 40, -1, 40, 40, 40, 40, 40,
            40, 40, 40, 40, 40, 40, 40, 40,
            40, 40, 40, 40, 40, 40, 40, 40,
            40 ),
        array( 1, 19, 20, 100, 20, 20, 20, 20,
            20, 20, 20, 20, 20, 20, 20, 20,
            20, 101, 20, 20, 20, 20, 20, 20,
            20 ),
        array( -1, -1, -1, 102, 135, 103, 103, 103,
            103, -1, -1, 103, 103, 103, -1, -1,
            -1, -1, -1, 103, 103, 103, 103, 103,
            -1 ),
        array( -1, -1, -1, -1, -1, 104, 104, 104,
            104, -1, -1, 104, 104, 104, -1, -1,
            -1, -1, -1, 104, 104, 104, 104, 104,
            -1 ),
        array( -1, 75, -1, -1, 90, 103, 103, 103,
            103, 75, 47, 103, 103, 103, -1, -1,
            -1, -1, -1, 103, 103, 103, 103, 103,
            -1 ),
        array( -1, 134, -1, -1, 91, 104, 104, 104,
            104, 134, 92, 104, 104, 104, -1, -1,
            -1, -1, -1, 104, 104, 104, 104, 104,
            -1 ),
        array( -1, -1, -1, -1, -1, 105, 105, 105,
            105, -1, 48, 105, 105, 105, -1, -1,
            -1, -1, -1, 105, 105, 105, 105, 105,
            -1 ),
        array( 1, 19, 107, 21, 130, 130, 130, 130,
            130, 130, 130, 130, 130, 130, 130, 130,
            130, 101, 130, 130, 130, 130, 130, 130,
            130 ),
        array( -1, 130, 41, 130, 130, 130, 130, 130,
            130, 130, 130, 130, 130, 130, 130, 130,
            130, 130, 130, 130, 130, 130, 130, 130,
            130 ),
        array( -1, 130, -1, 130, 130, 130, 130, 130,
            130, 130, 130, 130, 130, 130, 130, 130,
            130, 130, 130, 130, 130, 130, 130, 130,
            130 ),
        array( 1, 110, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 110, -1, -1, -1, -1, -1, -1,
            -1, 110, -1, -1, -1, -1, -1, 111,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( 1, 23, 24, 131, 24, 24, 24, 24,
            24, 24, 24, 24, 24, 24, 24, 24,
            24, 25, 24, 24, 24, 24, 24, 24,
            24 ),
        array( 1, 26, 26, 26, 26, 26, 26, 26,
            26, 26, 26, 26, 26, 26, 26, 26,
            -1, 26, 26, 26, 26, 26, 26, 26,
            26 ),
        array( 1, 27, 28, 55, 28, 28, 28, 28,
            28, 28, 28, 28, 28, 28, 28, 28,
            28, 32, 28, 28, 28, 28, 28, 28,
            28 ),
        array( -1, -1, -1, -1, 116, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, 117, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, 118, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, 119,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            120, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 120, -1, -1, -1, -1, -1, -1,
            -1, 120, 121, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 29, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, 123, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, 124, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, 125, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            126, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 126, -1, -1, -1, -1, -1, -1,
            -1, 126, 127, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, 30, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 38, 13,
            -1 ),
        array( -1, -1, 24, 139, 143, 43, 43, 43,
            43, 24, 24, 43, 43, 43, 24, 24,
            24, -1, 24, 43, 43, 43, 43, 43,
            24 ),
        array( -1, -1, 31, 31, 31, 63, 63, 63,
            63, 31, 31, 63, 63, 63, 31, 31,
            31, 44, 31, 63, 63, 63, 63, 63,
            31 ),
        array( -1, -1, -1, 122, 135, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, 134, -1, -1, 91, -1, -1, -1,
            -1, 134, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1,
            -1 ),
        array( -1, -1, -1, -1, -1, 105, 105, 105,
            105, -1, -1, 105, 105, 105, -1, -1,
            -1, -1, -1, 105, 105, 105, 105, 105,
            -1 ),
        array( 1, 27, 28, 133, 28, 28, 28, 28,
            28, 28, 28, 28, 28, 28, 28, 28,
            28, 32, 28, 28, 28, 28, 28, 28,
            28 ),
        array( -1, -1, 97, 129, 129, 68, 68, 68,
            68, 129, 129, 68, 68, 68, 129, 129,
            129, 44, 129, 68, 68, 68, 68, 68,
            129 ),
        array( -1, -1, 108, 130, 130, 52, 52, 52,
            52, 130, 130, 52, 52, 52, 130, 130,
            130, -1, 130, 52, 52, 52, 52, 52,
            130 ),
        array( -1, -1, 24, 24, 24, 53, 53, 53,
            53, 24, 24, 53, 53, 53, 24, 24,
            24, -1, 24, 53, 53, 53, 53, 53,
            24 ),
        array( -1, -1, 31, 31, 31, 71, 71, 71,
            71, 31, 31, 71, 71, 71, 31, 31,
            31, 44, 31, 71, 71, 71, 71, 71,
            31 ),
        array( -1, -1, 97, 129, 129, 72, 72, 72,
            72, 129, 129, 72, 72, 72, 129, 129,
            129, 44, 129, 72, 72, 72, 72, 72,
            129 ),
        array( -1, -1, 108, 130, 130, 61, 61, 61,
            61, 130, 130, 61, 61, 61, 130, 130,
            130, -1, 130, 61, 61, 61, 61, 61,
            130 ),
        array( -1, -1, 24, 24, 24, 62, 62, 62,
            62, 24, 24, 62, 62, 62, 24, 24,
            24, -1, 24, 62, 62, 62, 62, 62,
            24 ),
        array( -1, -1, 31, 31, 31, 31, 31, 31,
            31, 31, 88, 31, 31, 31, 31, 31,
            31, 44, 31, 31, 31, 31, 31, 31,
            31 ),
        array( -1, -1, 24, 24, 24, 24, 24, 24,
            24, 24, 82, 24, 24, 24, 24, 24,
            24, -1, 24, 24, 24, 24, 24, 24,
            24 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 128, 13, 13, 13,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 146, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 13, 13,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            147, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 13, 13, 13,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 13, 148, 13, 13,
            -1 ),
        array( -1, -1, -1, -1, -1, 13, 13, 13,
            13, -1, -1, 13, 13, 13, -1, -1,
            -1, -1, -1, 13, 149, 13, 13, 13,
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
                       if ($yy_last_accept_state < 151) {
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
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
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
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
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
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
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
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
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
    if ($this->debug) echo "complete tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_XML_TAG, $this->yytext());
}
case 37:
{
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
case 41:
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
case 42:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 43:
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
case 45:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 46:
{
    if ($this->debug) echo "1 normal desc text [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 47:
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
case 48:
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
case 49:
{
    if ($this->debug) echo "complete tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_XML_TAG, $this->yytext());
}
case 50:
{
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}
case 51:
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
case 52:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
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
case 55:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 56:
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
case 57:
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
case 58:
{
    if ($this->debug) echo "complete tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_XML_TAG, $this->yytext());
}
case 59:
{
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}
case 60:
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
case 61:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
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
case 64:
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
case 65:
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
case 66:
{
    if ($this->debug) echo "complete tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_XML_TAG, $this->yytext());
}
case 67:
{
    if ($this->debug) echo "escaped tag [".$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_ESCAPED_TAG, $this->yytext());
}
case 68:
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
case 69:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
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
case 73:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
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
case 77:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
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
case 81:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
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
case 85:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 87:
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
case 128:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 129:
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
case 130:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
}
case 131:
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
case 133:
{
    if ($this->debug) echo "everything else[" .$this->yytext()."]\n";
    return array(PHP_PARSER_DOCLEX_TEXT, $this->yytext());
}
case 137:
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
case 138:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
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
case 142:
{
    $res = $this->_doList();
    if ($this->_break) {
        $this->_break = false;
        break;
    }
    return $res;
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
case 146:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
}
case 147:
{
    if ($this->debug) echo "inline tag open [{@]\n";
    $this->_tagName = $this->yytext();
    $this->yybegin(INLINETAGNAME);
    return array(PHP_PARSER_DOCLEX_INLINE_TAG_OPEN, "{@");
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
