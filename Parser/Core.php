<?php
 // created by jay 0.8 (c) 1998 Axel.Schreiner@informatik.uni-osnabrueck.de
 // modified by alan@akbkhome.com to try to generate php!
 // modified by cellog@users.sourceforge.net to fit PEAR CS
 // %token constants

 require_once 'PEAR.php';

  define ('TOKEN_T_INCLUDE',  257);
  $GLOBALS['_TOKEN_DEBUG'][257] = 'T_INCLUDE';
  define ('TOKEN_T_INCLUDE_ONCE',  258);
  $GLOBALS['_TOKEN_DEBUG'][258] = 'T_INCLUDE_ONCE';
  define ('TOKEN_T_EVAL',  259);
  $GLOBALS['_TOKEN_DEBUG'][259] = 'T_EVAL';
  define ('TOKEN_T_REQUIRE',  260);
  $GLOBALS['_TOKEN_DEBUG'][260] = 'T_REQUIRE';
  define ('TOKEN_T_REQUIRE_ONCE',  261);
  $GLOBALS['_TOKEN_DEBUG'][261] = 'T_REQUIRE_ONCE';
  define ('TOKEN_T_LOGICAL_OR',  262);
  $GLOBALS['_TOKEN_DEBUG'][262] = 'T_LOGICAL_OR';
  define ('TOKEN_T_LOGICAL_XOR',  263);
  $GLOBALS['_TOKEN_DEBUG'][263] = 'T_LOGICAL_XOR';
  define ('TOKEN_T_LOGICAL_AND',  264);
  $GLOBALS['_TOKEN_DEBUG'][264] = 'T_LOGICAL_AND';
  define ('TOKEN_T_PRINT',  265);
  $GLOBALS['_TOKEN_DEBUG'][265] = 'T_PRINT';
  define ('TOKEN_T_PLUS_EQUAL',  266);
  $GLOBALS['_TOKEN_DEBUG'][266] = 'T_PLUS_EQUAL';
  define ('TOKEN_T_MINUS_EQUAL',  267);
  $GLOBALS['_TOKEN_DEBUG'][267] = 'T_MINUS_EQUAL';
  define ('TOKEN_T_MUL_EQUAL',  268);
  $GLOBALS['_TOKEN_DEBUG'][268] = 'T_MUL_EQUAL';
  define ('TOKEN_T_DIV_EQUAL',  269);
  $GLOBALS['_TOKEN_DEBUG'][269] = 'T_DIV_EQUAL';
  define ('TOKEN_T_CONCAT_EQUAL',  270);
  $GLOBALS['_TOKEN_DEBUG'][270] = 'T_CONCAT_EQUAL';
  define ('TOKEN_T_MOD_EQUAL',  271);
  $GLOBALS['_TOKEN_DEBUG'][271] = 'T_MOD_EQUAL';
  define ('TOKEN_T_AND_EQUAL',  272);
  $GLOBALS['_TOKEN_DEBUG'][272] = 'T_AND_EQUAL';
  define ('TOKEN_T_OR_EQUAL',  273);
  $GLOBALS['_TOKEN_DEBUG'][273] = 'T_OR_EQUAL';
  define ('TOKEN_T_XOR_EQUAL',  274);
  $GLOBALS['_TOKEN_DEBUG'][274] = 'T_XOR_EQUAL';
  define ('TOKEN_T_SL_EQUAL',  275);
  $GLOBALS['_TOKEN_DEBUG'][275] = 'T_SL_EQUAL';
  define ('TOKEN_T_SR_EQUAL',  276);
  $GLOBALS['_TOKEN_DEBUG'][276] = 'T_SR_EQUAL';
  define ('TOKEN_T_BOOLEAN_OR',  277);
  $GLOBALS['_TOKEN_DEBUG'][277] = 'T_BOOLEAN_OR';
  define ('TOKEN_T_BOOLEAN_AND',  278);
  $GLOBALS['_TOKEN_DEBUG'][278] = 'T_BOOLEAN_AND';
  define ('TOKEN_T_IS_EQUAL',  279);
  $GLOBALS['_TOKEN_DEBUG'][279] = 'T_IS_EQUAL';
  define ('TOKEN_T_IS_NOT_EQUAL',  280);
  $GLOBALS['_TOKEN_DEBUG'][280] = 'T_IS_NOT_EQUAL';
  define ('TOKEN_T_IS_IDENTICAL',  281);
  $GLOBALS['_TOKEN_DEBUG'][281] = 'T_IS_IDENTICAL';
  define ('TOKEN_T_IS_NOT_IDENTICAL',  282);
  $GLOBALS['_TOKEN_DEBUG'][282] = 'T_IS_NOT_IDENTICAL';
  define ('TOKEN_T_IS_SMALLER_OR_EQUAL',  283);
  $GLOBALS['_TOKEN_DEBUG'][283] = 'T_IS_SMALLER_OR_EQUAL';
  define ('TOKEN_T_IS_GREATER_OR_EQUAL',  284);
  $GLOBALS['_TOKEN_DEBUG'][284] = 'T_IS_GREATER_OR_EQUAL';
  define ('TOKEN_T_SL',  285);
  $GLOBALS['_TOKEN_DEBUG'][285] = 'T_SL';
  define ('TOKEN_T_SR',  286);
  $GLOBALS['_TOKEN_DEBUG'][286] = 'T_SR';
  define ('TOKEN_T_INC',  287);
  $GLOBALS['_TOKEN_DEBUG'][287] = 'T_INC';
  define ('TOKEN_T_DEC',  288);
  $GLOBALS['_TOKEN_DEBUG'][288] = 'T_DEC';
  define ('TOKEN_T_INT_CAST',  289);
  $GLOBALS['_TOKEN_DEBUG'][289] = 'T_INT_CAST';
  define ('TOKEN_T_DOUBLE_CAST',  290);
  $GLOBALS['_TOKEN_DEBUG'][290] = 'T_DOUBLE_CAST';
  define ('TOKEN_T_STRING_CAST',  291);
  $GLOBALS['_TOKEN_DEBUG'][291] = 'T_STRING_CAST';
  define ('TOKEN_T_ARRAY_CAST',  292);
  $GLOBALS['_TOKEN_DEBUG'][292] = 'T_ARRAY_CAST';
  define ('TOKEN_T_OBJECT_CAST',  293);
  $GLOBALS['_TOKEN_DEBUG'][293] = 'T_OBJECT_CAST';
  define ('TOKEN_T_BOOL_CAST',  294);
  $GLOBALS['_TOKEN_DEBUG'][294] = 'T_BOOL_CAST';
  define ('TOKEN_T_UNSET_CAST',  295);
  $GLOBALS['_TOKEN_DEBUG'][295] = 'T_UNSET_CAST';
  define ('TOKEN_T_NEW',  296);
  $GLOBALS['_TOKEN_DEBUG'][296] = 'T_NEW';
  define ('TOKEN_T_EXIT',  297);
  $GLOBALS['_TOKEN_DEBUG'][297] = 'T_EXIT';
  define ('TOKEN_T_IF',  298);
  $GLOBALS['_TOKEN_DEBUG'][298] = 'T_IF';
  define ('TOKEN_T_ELSEIF',  299);
  $GLOBALS['_TOKEN_DEBUG'][299] = 'T_ELSEIF';
  define ('TOKEN_T_ELSE',  300);
  $GLOBALS['_TOKEN_DEBUG'][300] = 'T_ELSE';
  define ('TOKEN_T_ENDIF',  301);
  $GLOBALS['_TOKEN_DEBUG'][301] = 'T_ENDIF';
  define ('TOKEN_T_LNUMBER',  302);
  $GLOBALS['_TOKEN_DEBUG'][302] = 'T_LNUMBER';
  define ('TOKEN_T_DNUMBER',  303);
  $GLOBALS['_TOKEN_DEBUG'][303] = 'T_DNUMBER';
  define ('TOKEN_T_STRING',  304);
  $GLOBALS['_TOKEN_DEBUG'][304] = 'T_STRING';
  define ('TOKEN_T_STRING_VARNAME',  305);
  $GLOBALS['_TOKEN_DEBUG'][305] = 'T_STRING_VARNAME';
  define ('TOKEN_T_VARIABLE',  306);
  $GLOBALS['_TOKEN_DEBUG'][306] = 'T_VARIABLE';
  define ('TOKEN_T_NUM_STRING',  307);
  $GLOBALS['_TOKEN_DEBUG'][307] = 'T_NUM_STRING';
  define ('TOKEN_T_INLINE_HTML',  308);
  $GLOBALS['_TOKEN_DEBUG'][308] = 'T_INLINE_HTML';
  define ('TOKEN_T_CHARACTER',  309);
  $GLOBALS['_TOKEN_DEBUG'][309] = 'T_CHARACTER';
  define ('TOKEN_T_BAD_CHARACTER',  310);
  $GLOBALS['_TOKEN_DEBUG'][310] = 'T_BAD_CHARACTER';
  define ('TOKEN_T_ENCAPSED_AND_WHITESPACE',  311);
  $GLOBALS['_TOKEN_DEBUG'][311] = 'T_ENCAPSED_AND_WHITESPACE';
  define ('TOKEN_T_CONSTANT_ENCAPSED_STRING',  312);
  $GLOBALS['_TOKEN_DEBUG'][312] = 'T_CONSTANT_ENCAPSED_STRING';
  define ('TOKEN_T_ECHO',  313);
  $GLOBALS['_TOKEN_DEBUG'][313] = 'T_ECHO';
  define ('TOKEN_T_DO',  314);
  $GLOBALS['_TOKEN_DEBUG'][314] = 'T_DO';
  define ('TOKEN_T_WHILE',  315);
  $GLOBALS['_TOKEN_DEBUG'][315] = 'T_WHILE';
  define ('TOKEN_T_ENDWHILE',  316);
  $GLOBALS['_TOKEN_DEBUG'][316] = 'T_ENDWHILE';
  define ('TOKEN_T_FOR',  317);
  $GLOBALS['_TOKEN_DEBUG'][317] = 'T_FOR';
  define ('TOKEN_T_ENDFOR',  318);
  $GLOBALS['_TOKEN_DEBUG'][318] = 'T_ENDFOR';
  define ('TOKEN_T_FOREACH',  319);
  $GLOBALS['_TOKEN_DEBUG'][319] = 'T_FOREACH';
  define ('TOKEN_T_ENDFOREACH',  320);
  $GLOBALS['_TOKEN_DEBUG'][320] = 'T_ENDFOREACH';
  define ('TOKEN_T_DECLARE',  321);
  $GLOBALS['_TOKEN_DEBUG'][321] = 'T_DECLARE';
  define ('TOKEN_T_ENDDECLARE',  322);
  $GLOBALS['_TOKEN_DEBUG'][322] = 'T_ENDDECLARE';
  define ('TOKEN_T_AS',  323);
  $GLOBALS['_TOKEN_DEBUG'][323] = 'T_AS';
  define ('TOKEN_T_SWITCH',  324);
  $GLOBALS['_TOKEN_DEBUG'][324] = 'T_SWITCH';
  define ('TOKEN_T_ENDSWITCH',  325);
  $GLOBALS['_TOKEN_DEBUG'][325] = 'T_ENDSWITCH';
  define ('TOKEN_T_CASE',  326);
  $GLOBALS['_TOKEN_DEBUG'][326] = 'T_CASE';
  define ('TOKEN_T_DEFAULT',  327);
  $GLOBALS['_TOKEN_DEBUG'][327] = 'T_DEFAULT';
  define ('TOKEN_T_BREAK',  328);
  $GLOBALS['_TOKEN_DEBUG'][328] = 'T_BREAK';
  define ('TOKEN_T_CONTINUE',  329);
  $GLOBALS['_TOKEN_DEBUG'][329] = 'T_CONTINUE';
  define ('TOKEN_T_OLD_FUNCTION',  330);
  $GLOBALS['_TOKEN_DEBUG'][330] = 'T_OLD_FUNCTION';
  define ('TOKEN_T_FUNCTION',  331);
  $GLOBALS['_TOKEN_DEBUG'][331] = 'T_FUNCTION';
  define ('TOKEN_T_CONST',  332);
  $GLOBALS['_TOKEN_DEBUG'][332] = 'T_CONST';
  define ('TOKEN_T_RETURN',  333);
  $GLOBALS['_TOKEN_DEBUG'][333] = 'T_RETURN';
  define ('TOKEN_T_USE',  334);
  $GLOBALS['_TOKEN_DEBUG'][334] = 'T_USE';
  define ('TOKEN_T_GLOBAL',  335);
  $GLOBALS['_TOKEN_DEBUG'][335] = 'T_GLOBAL';
  define ('TOKEN_T_STATIC',  336);
  $GLOBALS['_TOKEN_DEBUG'][336] = 'T_STATIC';
  define ('TOKEN_T_VAR',  337);
  $GLOBALS['_TOKEN_DEBUG'][337] = 'T_VAR';
  define ('TOKEN_T_UNSET',  338);
  $GLOBALS['_TOKEN_DEBUG'][338] = 'T_UNSET';
  define ('TOKEN_T_ISSET',  339);
  $GLOBALS['_TOKEN_DEBUG'][339] = 'T_ISSET';
  define ('TOKEN_T_EMPTY',  340);
  $GLOBALS['_TOKEN_DEBUG'][340] = 'T_EMPTY';
  define ('TOKEN_T_CLASS',  341);
  $GLOBALS['_TOKEN_DEBUG'][341] = 'T_CLASS';
  define ('TOKEN_T_EXTENDS',  342);
  $GLOBALS['_TOKEN_DEBUG'][342] = 'T_EXTENDS';
  define ('TOKEN_T_OBJECT_OPERATOR',  343);
  $GLOBALS['_TOKEN_DEBUG'][343] = 'T_OBJECT_OPERATOR';
  define ('TOKEN_T_DOUBLE_ARROW',  344);
  $GLOBALS['_TOKEN_DEBUG'][344] = 'T_DOUBLE_ARROW';
  define ('TOKEN_T_LIST',  345);
  $GLOBALS['_TOKEN_DEBUG'][345] = 'T_LIST';
  define ('TOKEN_T_ARRAY',  346);
  $GLOBALS['_TOKEN_DEBUG'][346] = 'T_ARRAY';
  define ('TOKEN_T_CLASS_C',  347);
  $GLOBALS['_TOKEN_DEBUG'][347] = 'T_CLASS_C';
  define ('TOKEN_T_FUNC_C',  348);
  $GLOBALS['_TOKEN_DEBUG'][348] = 'T_FUNC_C';
  define ('TOKEN_T_LINE',  349);
  $GLOBALS['_TOKEN_DEBUG'][349] = 'T_LINE';
  define ('TOKEN_T_FILE',  350);
  $GLOBALS['_TOKEN_DEBUG'][350] = 'T_FILE';
  define ('TOKEN_T_COMMENT',  351);
  $GLOBALS['_TOKEN_DEBUG'][351] = 'T_COMMENT';
  define ('TOKEN_T_ML_COMMENT',  352);
  $GLOBALS['_TOKEN_DEBUG'][352] = 'T_ML_COMMENT';
  define ('TOKEN_T_OPEN_TAG',  353);
  $GLOBALS['_TOKEN_DEBUG'][353] = 'T_OPEN_TAG';
  define ('TOKEN_T_OPEN_TAG_WITH_ECHO',  354);
  $GLOBALS['_TOKEN_DEBUG'][354] = 'T_OPEN_TAG_WITH_ECHO';
  define ('TOKEN_T_CLOSE_TAG',  355);
  $GLOBALS['_TOKEN_DEBUG'][355] = 'T_CLOSE_TAG';
  define ('TOKEN_T_WHITESPACE',  356);
  $GLOBALS['_TOKEN_DEBUG'][356] = 'T_WHITESPACE';
  define ('TOKEN_T_START_HEREDOC',  357);
  $GLOBALS['_TOKEN_DEBUG'][357] = 'T_START_HEREDOC';
  define ('TOKEN_T_END_HEREDOC',  358);
  $GLOBALS['_TOKEN_DEBUG'][358] = 'T_END_HEREDOC';
  define ('TOKEN_T_DOLLAR_OPEN_CURLY_BRACES',  359);
  $GLOBALS['_TOKEN_DEBUG'][359] = 'T_DOLLAR_OPEN_CURLY_BRACES';
  define ('TOKEN_T_CURLY_OPEN',  360);
  $GLOBALS['_TOKEN_DEBUG'][360] = 'T_CURLY_OPEN';
  define ('TOKEN_T_PAAMAYIM_NEKUDOTAYIM',  361);
  $GLOBALS['_TOKEN_DEBUG'][361] = 'T_PAAMAYIM_NEKUDOTAYIM';
   define('TOKEN_yyErrorCode', 256);

 // Class now

					// line 2 "Parser/Core.jay"
?><?
/*
   +----------------------------------------------------------------------+
   | Based on the Zend Engine                                             |
   +----------------------------------------------------------------------+
   | Copyright (c) 1998-2002 Zend Technologies Ltd. (http://www.zend.com) |
   +----------------------------------------------------------------------+
   | This source file is subject to version 2.00 of the Zend license,     |
   | that is bundled with this package in the file LICENSE, and is        | 
   | available at through the world-wide-web at                           |
   | http://www.zend.com/license/2_00.txt.                                |
   | If you did not receive a copy of the Zend license and are unable to  |
   | obtain it through the world-wide-web, please send a note to          |
   | license@zend.com so we can mail you a copy immediately.              |
   +----------------------------------------------------------------------+
   | Authors: Andi Gutmans <andi@zend.com>                                |
   |          Zeev Suraski <zeev@zend.com>                                |
   | native PHP version:  Alan Knowles <alan@akbkhome.com>                |
   +----------------------------------------------------------------------+
*/


/*
* This does nothing on it's own - refer to PHP_Parser
* It's purely the code for the Parser, generated by phpJay
*/
 

class PHP_Parser_Core {
        
    /**
     * Options, 
     *
     */
    var $_options = array();
    
    function PHP_Parser_Core($options = array())
    {
        $this->_options['classContainer'] =
        $this->_options['includeContainer'] =
        $this->_options['functionContainer'] =
        $this->_options['globalContainer'] =
        $this->_options['varContainer'] =
        $this->_options['constContainer'] =
        $this->_options['classConstContainer'] =
        $this->_options['methodContainer'] =
        $this->_options['publisher'] =
        $this->_options['publishMethod'] =
        $this->_options['publishMessageClass'] =
        $this->_options['publishClasses'] =
        $this->_options['publishClassMessage'] =
        $this->_options['publishIncludes'] =
        $this->_options['publishIncludeMessage'] =
        $this->_options['publishFunctions'] =
        $this->_options['publishFunctionMessage'] =
        $this->_options['publishGlobals'] =
        $this->_options['publishGlobalMessage'] =
        $this->_options['publishVars'] =
        $this->_options['publishVarMessage'] =
        $this->_options['publishClassConsts'] =
        $this->_options['publishClassConstMessage'] =
        $this->_options['publishMethods'] =
        $this->_options['publishMethodMessage'] =
        $this->_options['publishConsts'] =
        $this->_options['publishConstMessage'] =
        false;
        $this->_options = array_merge($this->_options, $options);
        if (!class_exists($this->_options['classContainer'])) {
            $this->_options['classContainer'] = false;
        }
        if (!class_exists($this->_options['includeContainer'])) {
            $this->_options['includeContainer'] = false;
        }
        if (!class_exists($this->_options['functionContainer'])) {
            $this->_options['functionContainer'] = false;
        }
        if (!class_exists($this->_options['globalContainer'])) {
            $this->_options['globalContainer'] = false;
        }
        if (!class_exists($this->_options['varContainer'])) {
            $this->_options['varContainer'] = false;
        }
        if (!class_exists($this->_options['constContainer'])) {
            $this->_options['constContainer'] = false;
        }
        if (!class_exists($this->_options['classConstContainer'])) {
            $this->_options['classConstContainer'] = false;
        }
        if (!class_exists($this->_options['methodContainer'])) {
            $this->_options['methodContainer'] = false;
        }
        if (!is_object($this->_options['publisher'])) {
            $this->_options['publisher'] = false;
        } else {
            if (!method_exists($this->_options['publisher'], $this->_options['publishMethod'])) {
                $this->_options['publishMethod'] = false;
                if (!method_exists($this->_options['publisher'], 'publish')) {
                    $this->_options['publisher'] = false;
                } else {
                    $this->_options['publishMethod'] = 'publish';
                }
            } else {
                if (!class_exists($this->_options['publishMessageClass'])) {
                    $this->_options['publishMessageClass'] = false;
                }
            }
        }
    }

    /**
     * array of classes => array(methods => ...., vars => ....)
     *
     * @var array
     * @access public 
     */

    var $classes = array();

   /**
    * array of includes
    *
    * @var array
    * @access public 
    */
    var $includes = array();

    /**
     * array of functions
     *
     * @var array
     * @access public 
     */
    var $functions = array();
    /**
     * array of constants
     *
     * @var array
     * @access public 
     */
    var $constants = array();
     /**
     * array of interfaces
     *
     * @var array
     * @access public 
     */
     
    var $interfaces = array();
     /**
     * array of globals
     *
     * @var array
     * @access public 
     */
    var $globals = array();
    /**
     * global variable name of parser arrays
     * should match the build options  
     *
     * @var string
     * @access public 
     */
    var $yyGlobalName = '_PHP_PARSER';


					// line 285 "-"

    /**
     * thrown for irrecoverable syntax errors and stack overflow.
     */
    
     var $yyErrorCode = 256;

    /**
     * Debugging
     */
     var $debug = false;

    /**
     * (syntax) error message.
     * Can be overwritten to control message format.
     * @param message text to be displayed.
     * @param expected vector of acceptable tokens, if available.
     */
    function raiseError ($message, $expected = null)
    {     
        if ($expected !== null ) {
            $m = "$message expecting ";
            if (!$expected) {
                $m .= " '?? nothing expeced ??'";
            }	
            foreach($expected as $e) {
                $m .= " '$e'";
            }
        } else {
            $m = $message;
        }
        return PEAR::raiseError($m);  
    }



    /**
     * index-checked interface to yyName[].
     * @param token single character or %token value.
     * @return token name or [illegal] or [unknown].
     */
    function yyname ($token) {
        if ($token < 0 || $token >  count($GLOBALS[$this->yyGlobalName]['yyName'])) return "[illegal]";
        if (isset($GLOBALS[$this->yyGlobalName]['yyName'][$token])) {
            return $GLOBALS[$this->yyGlobalName]['yyName'][$token];
        }
        return "[unknown]";
    }

    /**
     * computes list of expected tokens on error by tracing the tables.
     * @param state for which to compute the list.
     * @return list of token names.
     */
    function yyExpecting ($state) {
        $len = 0;
        $ok = array();//new boolean[YyNameClass.yyName.length];

        if (($n =  $GLOBALS[$this->yyGlobalName]['yySindex'][$state]) != 0) {
            $start = $n;
            if ($start < 0) { $start = 0; }       
            for ($token = $start;
                $token < count($GLOBALS[$this->yyGlobalName]['yyName']) && 
                        $n+$token < count($GLOBALS[$this->yyGlobalName]['yyTable']); $token++) {
                if (@$GLOBALS[$this->yyGlobalName]['yyCheck'][$n+$token] == $token && !@$ok[$token] && 
                        $GLOBALS[$this->yyGlobalName]['yyName'][$token] != null) {
                    $len++;
                    $ok[$token] = true;
                }
            } // end for
        }
        if (($n = $GLOBALS[$this->yyGlobalName]['yyRindex'][$state]) != 0) {
            $start = $n;
            if ($start < 0) { $start = 0; }       
            for ($token = $start;
                     $token < count($GLOBALS[$this->yyGlobalName]['yyName'])  && 
                     $n+$token <  count($GLOBALS[$this->yyGlobalName]['yyTable']); $token++) 
            {
               if (@$GLOBALS[$this->yyGlobalName]['yyCheck'][$n+$token] == $token && !@$ok[$token] 
                          && @$GLOBALS[$this->yyGlobalName]['yyName'][$token] != null) {
                    $len++;
                    $ok[$token] = true;
               }
            } // end for
        }
        $result = array();
        for ($n = $token = 0; $n < $len;  $token++) {
            if (@$ok[$token]) { $result[$n++] =$GLOBALS[$this->yyGlobalName]['yyName'][$token]; }
        }
        return $result;
    }


    /**
     * initial size and increment of the state/value stack [default 256].
     * This is not final so that it can be overwritten outside of invocations
     * of yyparse().
     */
    var $yyMax;

    /**
     * executed at the beginning of a reduce action.
     * Used as $$ = yyDefault($1), prior to the user-specified action, if any.
     * Can be overwritten to provide deep copy, etc.
     * @param first value for $1, or null.
     * @return first.
     */
    function yyDefault ($first) {
        return $first;
    }

    /**
     * the generated parser.
     * Maintains a state and a value stack, currently with fixed maximum size.
     * @param yyLex scanner.
     * @return result of the last reduction, if any.
     * @throws yyException on irrecoverable parse error.
     */
    function yyparse (&$yyLex,$options=array()) {
        $this->debug = @$options['debug'];
        $this->yyLex = &$yyLex;
        if (!$this->yyGlobalName) {
            echo "\n\nYou must define \$this->yyGlobalName to match the build option -g _XXXXX \n\n";
            exit;
        }
        if ($this->debug)
           echo "\tStarting jay:yyparse";
        //error_reporting(E_ALL);
        if ($this->yyMax <= 0) $this->yyMax = 256;			// initial size
        $this->yyState = 0;
        $this->yyStates = array();
        $this->yyVal = null;
        $this->yyVals = array();
        $yyTableCount = count($GLOBALS[$this->yyGlobalName]['yyTable']);
        $yyToken = -1;                 // current input
        $yyErrorFlag = 0;              // #tks to shift
        $tloop = 0;
    
        while (1) {//yyLoop: 
            //echo "yyLoop\n";
            //if ($this->debug) echo "\tyyLoop:\n";
            for ($yyTop = 0;; $yyTop++) {
                //if ($this->debug) echo ($tloop++) .">>>>>>yyLoop:yTop = {$yyTop}\n";
                $this->yyStates[$yyTop] = $this->yyState;
                $this->yyVals[$yyTop] = $this->yyVal;

                //yyDiscarded: 
                for (;;) {	// discarding a token does not change stack
                    //echo "yyDiscarded\n";
                    if ($this->debug) echo "\tIn main loop : State = {$this->yyState}\n";
                    if ($this->debug) echo "\tyydefred = {$GLOBALS[$this->yyGlobalName]['yyDefRed'][$this->yyState]}\n";
                    if (($yyN = $GLOBALS[$this->yyGlobalName]['yyDefRed'][$this->yyState]) == 0) {	
                        // else [default] reduce (yyN)
                        //if ($this->debug) echo "\tA:token is $yyToken\n";
                        if ($yyToken < 0) {
                            //if ($this->debug) echo "\tA:advance\n";
                            if ($yyLex->advance()) {
                               
                                $yyToken = $yyLex->token ;
                            } else {
                                $yyToken = 0;
                            }
                        }
                        if ($this->debug) {
                            echo "\tA:token is now " .
                            "{$GLOBALS[$this->yyGlobalName]['yyName'][$yyToken]} " .token_name($yyToken).  "\n";
                            var_dump($yyToken);
                        }
                        //if ($this->debug) echo "GOT TOKEN $yyToken";
                        //if ($this->debug) echo "Sindex:  {$GLOBALS[$this->yyGlobalName]['yySindex'][$this->yyState]}\n";

                        if (($yyN = $GLOBALS[$this->yyGlobalName]['yySindex'][$this->yyState]) != 0
                                  && ($yyN += $yyToken) >= 0
                                  && $yyN < $yyTableCount && $GLOBALS[$this->yyGlobalName]['yyCheck'][$yyN] == $yyToken) {
                            $this->yyState = $GLOBALS[$this->yyGlobalName]['yyTable'][$yyN];		// shift to yyN
                            $this->yyVal = $yyLex->value;
                            $yyToken = -1;
                            if ($yyErrorFlag > 0) $yyErrorFlag--;
                            continue 2; // goto!!yyLoop;
                        }
 
                       
              
                        if (($yyN = $GLOBALS[$this->yyGlobalName]['yyRindex'][$this->yyState]) != 0
                                && ($yyN += $yyToken) >= 0
                                && $yyN < $yyTableCount && $GLOBALS[$this->yyGlobalName]['yyCheck'][$yyN] == $yyToken) {
                            $yyN = $GLOBALS[$this->yyGlobalName]['yyTable'][$yyN];			// reduce (yyN)
                        } else {
                            switch ($yyErrorFlag) {
    
                                case 0:
                                    $info = $yyLex->parseError();
                                    $info .= ', Unexpected '.$this->yyName($yyToken).',';
                                    return $this->raiseError("$info syntax error",
                                                $this->yyExpecting($this->yyState));
                                
                                case 1: case 2:
                                    $yyErrorFlag = 3;
                                    do { 
                                        if (($yyN = @$GLOBALS[$this->yyGlobalName]['yySindex']
                                                [$this->yyStates[$yyTop]]) != 0
                                                && ($yyN += $this->yyErrorCode) >= 0 && $yyN < $yyTableCount
                                                && $GLOBALS[$this->yyGlobalName]['yyCheck'][$yyN] == $this->yyErrorCode) {
                                            $this->yyState = $GLOBALS[$this->yyGlobalName]['yyTable'][$yyN];
                                            $this->yyVal = $yyLex->value;
                                            //vi /echo "goto yyLoop?\n";
                                            break 3; //continue yyLoop;
                                        }
                                    } while ($yyTop-- >= 0);
                                    $info = $yyLex->parseError();
                                    return $this->raiseError("$info irrecoverable syntax error");
    
                                case 3:
                                    if ($yyToken == 0) {
                                        $info =$yyLex->parseError();
                                        return $this->raiseError("$info irrecoverable syntax error at end-of-file");
                                    }
                                    $yyToken = -1;
                                    //echo "goto yyDiscarded?";  
                                    break 1; //continue yyDiscarded;		// leave stack alone
                            }
                        }
                    }    
                    $yyV = $yyTop + 1-$GLOBALS[$this->yyGlobalName]['yyLen'][$yyN];
                    //if ($this->debug) echo "\tyyV is $yyV\n";
                    $yyVal = $yyV > $yyTop ? null : $this->yyVals[$yyV];
                    //if ($this->debug) echo "\tyyVal is ". serialize($yyVal) ."\n";
                    if ($this->debug) echo "\tswitch($yyN)\n";
                   
                    $method = '_' .$yyN;
                    if (method_exists($this,$method)) {
                         $this->$method($yyTop);

                    }
                   
                    //if ($this->debug) echo "\tDONE switch\n";if ($this->debug) echo "\t--------------\n";
                    $yyTop -= $GLOBALS[$this->yyGlobalName]['yyLen'][$yyN];
                    //if ($this->debug) echo "\tyyTop is $yyTop\n";
                    $this->yyState = $this->yyStates[$yyTop];
                    //if ($this->debug) echo "\tyyState is {$this->yyState}\n";
                    $yyM = $GLOBALS[$this->yyGlobalName]['yyLhs'][$yyN];
                    //if ($this->debug) echo "\tyyM is now $yyM\n";



                    if ($this->yyState == 0 && $yyM == 0) {
                        $this->yyState = $GLOBALS[$this->yyGlobalName]['yyFinal'];
                        if ($yyToken < 0) {
                            $yyToken =0;
                            if ($yyLex->advance()) {
                                $yyToken = $yyLex->token;
                            }
                        }
                        if ($this->debug) echo "\tTOKEN IS NOW $yyToken\n";
                        if ($yyToken == 0) {
                            return $yyVal;
                        }
                        //if ($this->debug) echo "\t>>>>> yyLoop(A)?\n";
                        continue 2; //continue yyLoop;
                    }
                    if (($yyN = $GLOBALS[$this->yyGlobalName]['yyGindex'][$yyM]) != 0 && ($yyN += $this->yyState) >= 0
                            && $yyN < $yyTableCount && $GLOBALS[$this->yyGlobalName]['yyCheck'][$yyN] == $this->yyState) {
                        //if ($this->debug) echo "\tyyState: using yyTable\n";
                        $this->yyState = $GLOBALS[$this->yyGlobalName]['yyTable'][$yyN];
                    } else {
                        //if ($this->debug) echo "\tyyState: using yyDgoto\n";
                        $this->yyState = $GLOBALS[$this->yyGlobalName]['yyDgoto'][$yyM];
                    }  
                    //if ($this->debug) echo "\t>>>>> yyLoop(B)?\n";
                    continue 2;//continue yyLoop;
                }
            }
        }
    }

   function _1($yyTop) {
					// line 316 "Parser/Core.jay"
  {   }
    }
   function _2($yyTop) {
					// line 316 "Parser/Core.jay"
  {   }
    }
   function _5($yyTop) {
					// line 323 "Parser/Core.jay"
  {   }
    }
   function _6($yyTop) {
					// line 328 "Parser/Core.jay"
  {  }
    }
   function _7($yyTop) {
					// line 328 "Parser/Core.jay"
  {   }
    }
   function _11($yyTop) {
					// line 340 "Parser/Core.jay"
  {   }
    }
   function _33($yyTop) {
					// line 374 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _34($yyTop) {
					// line 374 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _35($yyTop) {
					// line 374 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _36($yyTop) {
					// line 375 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _37($yyTop) {
					// line 375 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _38($yyTop) {
					// line 375 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _39($yyTop) {
					// line 376 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _40($yyTop) {
					// line 376 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _44($yyTop) {
					// line 386 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _45($yyTop) {
					// line 390 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _46($yyTop) {
					// line 391 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop]; }
    }
   function _47($yyTop) {
					// line 396 "Parser/Core.jay"
  { /* do stuff */  }
    }
   function _48($yyTop) {
					// line 401 "Parser/Core.jay"
  {  
                $this->functionLine = $this->yyLex->line; 
                $this->functionPos = $this->yyLex->pos; 
                $this->functionComment = $this->yyLex->lastComment;
                $this->functionCommentToken = $this->yyLex->lastCommentToken;
                
            }
    }
   function _49($yyTop) {
					// line 408 "Parser/Core.jay"
  { 
                $this->functions[$this->yyVals[-6+$yyTop]] = array(
                    'name'=>$this->yyVals[-6+$yyTop],
                    'args' => $this->yyVals[-4+$yyTop]
            ); 
            
            
            
            }
    }
   function _51($yyTop) {
					// line 418 "Parser/Core.jay"
  { 
            $this->methods = array(); 
            $this->vars = array(); 
            $this->referencedVars = array();
        }
    }
   function _52($yyTop) {
					// line 423 "Parser/Core.jay"
  {  
                $this->classes[$this->yyVals[-4+$yyTop]] = array(
                    'name'              => $this->yyVals[-4+$yyTop],
                    'methods'           => $this->methods,
                    'vars'              => $this->vars,
                    'referencedVars'    => $this->referencedVars
                ); 
        }
    }
   function _53($yyTop) {
					// line 431 "Parser/Core.jay"
  { 
            $this->methods = array(); 
            $this->vars = array(); 
            $this->referencedVars = array();
        }
    }
   function _54($yyTop) {
					// line 436 "Parser/Core.jay"
  {
            $this->classes[$this->yyVals[-6+$yyTop]] = array(
                'name'              => $this->yyVals[-6+$yyTop],
                'extends'           => $this->yyVals[-4+$yyTop],
                'methods'           =>$this->methods,
                'vars'              => $this->vars,
                'referencedVars'    => $this->referencedVars
            ); 
        }
    }
   function _55($yyTop) {
					// line 449 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _56($yyTop) {
					// line 450 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _63($yyTop) {
					// line 473 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _64($yyTop) {
					// line 474 "Parser/Core.jay"
  { /* do stuff */  }
    }
   function _65($yyTop) {
					// line 479 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop]; }
    }
   function _66($yyTop) {
					// line 480 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop]; }
    }
   function _67($yyTop) {
					// line 481 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-2+$yyTop]; }
    }
   function _68($yyTop) {
					// line 482 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-2+$yyTop]; }
    }
   function _69($yyTop) {
					// line 487 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _70($yyTop) {
					// line 488 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _71($yyTop) {
					// line 488 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _72($yyTop) {
					// line 489 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _73($yyTop) {
					// line 489 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _79($yyTop) {
					// line 508 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _80($yyTop) {
					// line 508 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _82($yyTop) {
					// line 514 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _83($yyTop) {
					// line 514 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _89($yyTop) {
					// line 532 "Parser/Core.jay"
  { $this->yyVal = array(); }
    }
   function _90($yyTop) {
					// line 537 "Parser/Core.jay"
  {  $this->yyVal = array(array('var'=>$this->yyVals[0+$yyTop])); }
    }
   function _91($yyTop) {
					// line 538 "Parser/Core.jay"
  {  $this->yyVal = array(array('var'=>$this->yyVals[0+$yyTop],'byRef'=>true)); }
    }
   function _92($yyTop) {
					// line 539 "Parser/Core.jay"
  {   /* do stuff */  }
    }
   function _93($yyTop) {
					// line 540 "Parser/Core.jay"
  {   $this->yyVal = array(array('var'=>$this->yyVals[-2+$yyTop],'default'=>$this->yyVals[0+$yyTop])); }
    }
   function _94($yyTop) {
					// line 541 "Parser/Core.jay"
  {   $this->yyVal = array_merge($this->yyVals[-2+$yyTop],array(array('var'=>$this->yyVals[0+$yyTop])));  }
    }
   function _95($yyTop) {
					// line 542 "Parser/Core.jay"
  {   $this->yyVal = array_merge($this->yyVals[-3+$yyTop],array(array('var'=>$this->yyVals[-1+$yyTop],'byRef'=>true))); }
    }
   function _96($yyTop) {
					// line 543 "Parser/Core.jay"
  {    }
    }
   function _97($yyTop) {
					// line 544 "Parser/Core.jay"
  {   $this->yyVal = array_merge($this->yyVals[-4+$yyTop],array(array('var'=>$this->yyVals[-2+$yyTop],'default'=>$this->yyVals[0+$yyTop])));  }
    }
   function _98($yyTop) {
					// line 549 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _99($yyTop) {
					// line 550 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _100($yyTop) {
					// line 555 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _101($yyTop) {
					// line 556 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _102($yyTop) {
					// line 557 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _103($yyTop) {
					// line 558 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _104($yyTop) {
					// line 559 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _105($yyTop) {
					// line 560 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _106($yyTop) {
					// line 564 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _107($yyTop) {
					// line 565 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _108($yyTop) {
					// line 570 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _109($yyTop) {
					// line 571 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _110($yyTop) {
					// line 572 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop]; }
    }
   function _111($yyTop) {
					// line 577 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _112($yyTop) {
					// line 578 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _113($yyTop) {
					// line 579 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _114($yyTop) {
					// line 580 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _115($yyTop) {
					// line 586 "Parser/Core.jay"
  {   }
    }
   function _116($yyTop) {
					// line 587 "Parser/Core.jay"
  {  }
    }
   function _117($yyTop) {
					// line 592 "Parser/Core.jay"
  {   }
    }
   function _118($yyTop) {
					// line 593 "Parser/Core.jay"
  {  
                $this->functionLine = $this->yyLex->line; 
                $this->functionPos = $this->yyLex->pos; 
                $this->functionComment = $this->yyLex->lastComment;/* do stuff */
                $this->functionCommentToken = $this->yyLex->lastCommentToken;/* do stuff */
            }
    }
   function _119($yyTop) {
					// line 598 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _120($yyTop) {
					// line 599 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _121($yyTop) {
					// line 599 "Parser/Core.jay"
  { 
                $this->methods[$this->yyVals[-8+$yyTop]] = array( 
                    'name'=>$this->yyVals[-8+$yyTop],
                    'args'=>$this->yyVals[-5+$yyTop], 
                    'line'=>$this->functionLine,
                    'startToken'=>$this->functionPos,
                    'endToken'=>$this->yyLex->pos,
                    'comment' => $this->functionComment
                    
                    ); 
                if ($this->functionCommentToken > -1) {
                    $this->methods[$this->yyVals[-8+$yyTop]]['commentToken'] = $this->functionCommentToken;
                }
            }
    }
   function _122($yyTop) {
					// line 613 "Parser/Core.jay"
  { /* do stuff */  }
    }
   function _123($yyTop) {
					// line 613 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _124($yyTop) {
					// line 614 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _127($yyTop) {
					// line 624 "Parser/Core.jay"
  {  
                $this->vars[$this->yyVals[0+$yyTop]] = array(
                    'name'=>$this->yyVals[0+$yyTop],
                    'comment' => $this->yyLex->lastComment,
                    'commentToken' => $this->yyLex->lastCommentToken,
                    'line'  => $this->yyLex->line,
                    'token' => $this->yyLex->pos,
                    
                ); 
        }
    }
   function _128($yyTop) {
					// line 634 "Parser/Core.jay"
  { 
                $this->varStartLine = $this->yyLex->line; 
                $this->varStartToken = $this->yyLex->pos; 
        }
    }
   function _129($yyTop) {
					// line 638 "Parser/Core.jay"
  {  
                $this->vars[$this->yyVals[-3+$yyTop]] = array(
                    'name'=>$this->yyVals[-3+$yyTop],
                    'value'=>$this->yyVals[0+$yyTop],
                    'comment' => $this->yyLex->lastComment,
                    'commentToken' => $this->yyLex->lastCommentToken,
                    'line'  => $this->varStartLine,
                    'token' => $this->varStartToken,
                ); 
        }
    }
   function _130($yyTop) {
					// line 648 "Parser/Core.jay"
  {  
                $this->vars[$this->yyVals[0+$yyTop]] = array(
                    'name'=>$this->yyVals[0+$yyTop] ,
                    'comment' => $this->yyLex->lastComment,
                    'commentToken' => $this->yyLex->lastCommentToken,
                    'line'  => $this->yyLex->line,
                    'token' => $this->yyLex->pos,
                );
        }
    }
   function _131($yyTop) {
					// line 657 "Parser/Core.jay"
  { 
                $this->varStartLine = $this->yyLex->line; 
                $this->varStartToken = $this->yyLex->pos; 
        }
    }
   function _132($yyTop) {
					// line 661 "Parser/Core.jay"
  {  
                $this->vars[$this->yyVals[-3+$yyTop]] = array(
                    'name'=>$this->yyVals[-3+$yyTop],
                    'value'=>$this->yyVals[0+$yyTop],
                    'comment' => $this->yyLex->lastComment,
                    'commentToken' => $this->yyLex->lastCommentToken,
                    'line'  => $this->varStartLine,
                    'token' => $this->varStartToken,
                ); 
        }
    }
   function _137($yyTop) {
					// line 682 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _138($yyTop) {
					// line 686 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _139($yyTop) {
					// line 686 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _140($yyTop) {
					// line 687 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _141($yyTop) {
					// line 692 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _142($yyTop) {
					// line 692 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _143($yyTop) {
					// line 693 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _144($yyTop) {
					// line 694 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _145($yyTop) {
					// line 695 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _146($yyTop) {
					// line 696 "Parser/Core.jay"
  {
            /*echo "New:  ".$5."\n";*/
            /*var_dump($1);*/
            /* store a variable type.*/
            if (is_array($this->yyVals[-5+$yyTop]) && ($this->yyVals[-5+$yyTop][0] == '$this') && (count($this->yyVals[-5+$yyTop]) == 2))  {
                if ($this->yyVals[-1+$yyTop]{0} != '$') {
                    $this->referencedVars[$this->yyVals[-5+$yyTop][1]] = $this->yyVals[-1+$yyTop];
                } else {
                    /* since all classes extend stdclass in theory...*/
                    $this->referencedVars[$this->yyVals[-5+$yyTop][1]] = 'StdClass';
                }
            } 
        }
    }
   function _147($yyTop) {
					// line 709 "Parser/Core.jay"
  { 
            /* store a variable type.*/
            if (is_array($this->yyVals[-4+$yyTop]) && ($this->yyVals[-4+$yyTop][0] == '$this') && (count($this->yyVals[-4+$yyTop]) == 2))  {
                if ($this->yyVals[-1+$yyTop]{0} != '$') {
                    $this->referencedVars[$this->yyVals[-4+$yyTop][1]] = $this->yyVals[-2+$yyTop];
                } else {
                    /* since all classes extend stdclass in theory...*/
                    $this->referencedVars[$this->yyVals[-4+$yyTop][1]] = 'StdClass';
                }
            }
        }
    }
   function _148($yyTop) {
					// line 720 "Parser/Core.jay"
  { 
            /*echo "(no assign?) New:  ".$2."\n";*/
        }
    }
   function _149($yyTop) {
					// line 724 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _150($yyTop) {
					// line 725 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _151($yyTop) {
					// line 726 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _152($yyTop) {
					// line 727 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _153($yyTop) {
					// line 728 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _154($yyTop) {
					// line 729 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _155($yyTop) {
					// line 730 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _156($yyTop) {
					// line 731 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _157($yyTop) {
					// line 732 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _158($yyTop) {
					// line 733 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _159($yyTop) {
					// line 734 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _160($yyTop) {
					// line 735 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _161($yyTop) {
					// line 736 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _162($yyTop) {
					// line 737 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _163($yyTop) {
					// line 738 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _164($yyTop) {
					// line 739 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _165($yyTop) {
					// line 739 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _166($yyTop) {
					// line 740 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _167($yyTop) {
					// line 740 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _168($yyTop) {
					// line 741 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _169($yyTop) {
					// line 741 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _170($yyTop) {
					// line 742 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _171($yyTop) {
					// line 742 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _172($yyTop) {
					// line 743 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _173($yyTop) {
					// line 744 "Parser/Core.jay"
  {  /* do stuff */   }
    }
   function _174($yyTop) {
					// line 745 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _175($yyTop) {
					// line 746 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _176($yyTop) {
					// line 747 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _177($yyTop) {
					// line 748 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _178($yyTop) {
					// line 749 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _179($yyTop) {
					// line 750 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _180($yyTop) {
					// line 751 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _181($yyTop) {
					// line 752 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _182($yyTop) {
					// line 753 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _183($yyTop) {
					// line 754 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _184($yyTop) {
					// line 755 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _185($yyTop) {
					// line 756 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _186($yyTop) {
					// line 757 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _187($yyTop) {
					// line 758 "Parser/Core.jay"
  {  /* do stuff */ }
    }
   function _188($yyTop) {
					// line 759 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _189($yyTop) {
					// line 760 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _190($yyTop) {
					// line 761 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _191($yyTop) {
					// line 762 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _192($yyTop) {
					// line 763 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _193($yyTop) {
					// line 764 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _194($yyTop) {
					// line 765 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _195($yyTop) {
					// line 766 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _196($yyTop) {
					// line 767 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop]; }
    }
   function _197($yyTop) {
					// line 768 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _198($yyTop) {
					// line 769 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _199($yyTop) {
					// line 770 "Parser/Core.jay"
  { /* do stuff */  }
    }
   function _200($yyTop) {
					// line 771 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _201($yyTop) {
					// line 772 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _202($yyTop) {
					// line 773 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _203($yyTop) {
					// line 774 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _204($yyTop) {
					// line 775 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _205($yyTop) {
					// line 776 "Parser/Core.jay"
  {   /* do stuff */  }
    }
   function _206($yyTop) {
					// line 777 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _207($yyTop) {
					// line 778 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _208($yyTop) {
					// line 779 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _209($yyTop) {
					// line 780 "Parser/Core.jay"
  {  /* do stuff */  }
    }
   function _210($yyTop) {
					// line 781 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _211($yyTop) {
					// line 781 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _212($yyTop) {
					// line 782 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _213($yyTop) {
					// line 783 "Parser/Core.jay"
  { $this->yyVal = 'Array ('.$this->yyVals[-1+$yyTop].')'; }
    }
   function _214($yyTop) {
					// line 784 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _215($yyTop) {
					// line 785 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _216($yyTop) {
					// line 789 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _217($yyTop) {
					// line 791 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _218($yyTop) {
					// line 792 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _219($yyTop) {
					// line 794 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _220($yyTop) {
					// line 795 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _221($yyTop) {
					// line 797 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _222($yyTop) {
					// line 802 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _223($yyTop) {
					// line 803 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _224($yyTop) {
					// line 808 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _225($yyTop) {
					// line 809 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _226($yyTop) {
					// line 810 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop]; }
    }
   function _227($yyTop) {
					// line 815 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _228($yyTop) {
					// line 816 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop]; }
    }
   function _229($yyTop) {
					// line 821 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _230($yyTop) {
					// line 822 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _231($yyTop) {
					// line 823 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _232($yyTop) {
					// line 824 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _233($yyTop) {
					// line 825 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _234($yyTop) {
					// line 826 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _235($yyTop) {
					// line 827 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _236($yyTop) {
					// line 832 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _237($yyTop) {
					// line 833 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _238($yyTop) {
					// line 834 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _239($yyTop) {
					// line 835 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _240($yyTop) {
					// line 836 "Parser/Core.jay"
  { $this->yyVal= 'Array ('.$this->yyVals[-1+$yyTop].')'; }
    }
   function _241($yyTop) {
					// line 841 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _242($yyTop) {
					// line 842 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _243($yyTop) {
					// line 843 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _244($yyTop) {
					// line 844 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop]; }
    }
   function _245($yyTop) {
					// line 845 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop]; }
    }
   function _246($yyTop) {
					// line 846 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _247($yyTop) {
					// line 851 "Parser/Core.jay"
  { $this->yyVal = ''; }
    }
   function _248($yyTop) {
					// line 852 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop] . $this->yyVals[0+$yyTop]; }
    }
   function _249($yyTop) {
					// line 856 "Parser/Core.jay"
  { $this->yyVal = ''; }
    }
   function _251($yyTop) {
					// line 861 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-4+$yyTop] .','.$this->yyVals[-2+$yyTop] . '=>' . $this->yyVals[0+$yyTop]; }
    }
   function _252($yyTop) {
					// line 862 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-2+$yyTop] .','.$this->yyVals[0+$yyTop]; }
    }
   function _253($yyTop) {
					// line 863 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-2+$yyTop] .'=>'.$this->yyVals[0+$yyTop]; }
    }
   function _254($yyTop) {
					// line 864 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _255($yyTop) {
					// line 868 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _256($yyTop) {
					// line 869 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _257($yyTop) {
					// line 874 "Parser/Core.jay"
  {   $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _258($yyTop) {
					// line 879 "Parser/Core.jay"
  {   $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _259($yyTop) {
					// line 884 "Parser/Core.jay"
  {   $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _260($yyTop) {
					// line 889 "Parser/Core.jay"
  {  $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _261($yyTop) {
					// line 890 "Parser/Core.jay"
  { 
        
            $this->yyVal = array_merge(array($this->yyVals[-2+$yyTop]),$this->yyVals[0+$yyTop]);
            
            if ((count($this->yyVals[0+$yyTop]) == 1) && ($this->yyVals[-2+$yyTop] == '$this')  && (empty($this->referencedVars[$this->yyVals[0+$yyTop][0]]))) {
                $this->referencedVars[$this->yyVals[0+$yyTop][0]] = true;
            }
            
             
    }
    }
   function _262($yyTop) {
					// line 904 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _263($yyTop) {
					// line 905 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop] . $this->yyVals[0+$yyTop]; }
    }
   function _264($yyTop) {
					// line 910 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-3+$yyTop] . '['.$this->yyVals[-1+$yyTop].']'; }
    }
   function _265($yyTop) {
					// line 911 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-3+$yyTop] . '{'.$this->yyVals[-1+$yyTop].'}'; }
    }
   function _267($yyTop) {
					// line 917 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _268($yyTop) {
					// line 918 "Parser/Core.jay"
  { $this->yyVal = '${'.$this->yyVals[-1+$yyTop].'}'; }
    }
   function _270($yyTop) {
					// line 923 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _271($yyTop) {
					// line 927 "Parser/Core.jay"
  { $this->yyVal = array($this->yyVals[0+$yyTop]); }
    }
   function _272($yyTop) {
					// line 928 "Parser/Core.jay"
  { $this->yyVal = array_merge($this->yyVals[-2+$yyTop],array($this->yyVals[0+$yyTop])); }
    }
   function _273($yyTop) {
					// line 932 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _274($yyTop) {
					// line 933 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _275($yyTop) {
					// line 937 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-3+$yyTop] . '['.$this->yyVals[-1+$yyTop].']'; }
    }
   function _276($yyTop) {
					// line 938 "Parser/Core.jay"
  {  $this->yyVal = $this->yyVals[-3+$yyTop] . '{'.$this->yyVals[-1+$yyTop].'}'; }
    }
   function _277($yyTop) {
					// line 939 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _278($yyTop) {
					// line 943 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _279($yyTop) {
					// line 944 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop]; }
    }
   function _280($yyTop) {
					// line 949 "Parser/Core.jay"
  { /* do stuff */; }
    }
   function _281($yyTop) {
					// line 950 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _285($yyTop) {
					// line 961 "Parser/Core.jay"
  { $this->yyVal = 'list('.$this->yyVals[-1+$yyTop].')';}
    }
   function _288($yyTop) {
					// line 968 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop] . $this->yyVals[0+$yyTop]; }
    }
   function _289($yyTop) {
					// line 972 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _290($yyTop) {
					// line 973 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _291($yyTop) {
					// line 974 "Parser/Core.jay"
  {/* do stuff */ }
    }
   function _292($yyTop) {
					// line 975 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _293($yyTop) {
					// line 976 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _294($yyTop) {
					// line 977 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _295($yyTop) {
					// line 978 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _296($yyTop) {
					// line 979 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _297($yyTop) {
					// line 983 "Parser/Core.jay"
  {/* do stuff */ }
    }
   function _298($yyTop) {
					// line 984 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _299($yyTop) {
					// line 985 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _300($yyTop) {
					// line 986 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _301($yyTop) {
					// line 987 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _302($yyTop) {
					// line 988 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _303($yyTop) {
					// line 989 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _304($yyTop) {
					// line 990 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _305($yyTop) {
					// line 991 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _306($yyTop) {
					// line 992 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _307($yyTop) {
					// line 993 "Parser/Core.jay"
  {/* do stuff */ }
    }
   function _308($yyTop) {
					// line 994 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _309($yyTop) {
					// line 1001 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _310($yyTop) {
					// line 1002 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _311($yyTop) {
					// line 1003 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _312($yyTop) {
					// line 1004 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _313($yyTop) {
					// line 1005 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _314($yyTop) {
					// line 1006 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop]; }
    }
   function _315($yyTop) {
					// line 1011 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _316($yyTop) {
					// line 1012 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[0+$yyTop]; }
    }
   function _317($yyTop) {
					// line 1013 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _318($yyTop) {
					// line 1018 "Parser/Core.jay"
  { $this->yyVal = $this->yyVals[-1+$yyTop]; }
    }
   function _319($yyTop) {
					// line 1019 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _320($yyTop) {
					// line 1020 "Parser/Core.jay"
  { $this->includes[] = $this->yyVals[0+$yyTop]; }
    }
   function _321($yyTop) {
					// line 1021 "Parser/Core.jay"
  { $this->includes[] = $this->yyVals[0+$yyTop]; }
    }
   function _322($yyTop) {
					// line 1022 "Parser/Core.jay"
  { /* do stuff */ }
    }
   function _323($yyTop) {
					// line 1023 "Parser/Core.jay"
  { $this->includes[] = $this->yyVals[0+$yyTop]; }
    }
   function _324($yyTop) {
					// line 1024 "Parser/Core.jay"
  { $this->includes[] = $this->yyVals[0+$yyTop]; }
    }
   function _325($yyTop) {
					// line 1028 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _326($yyTop) {
					// line 1029 "Parser/Core.jay"
  { /* do stuff */}
    }
   function _327($yyTop) {
					// line 1029 "Parser/Core.jay"
  { /* do stuff */}
    }
					// line 1754 "-"

					// line 1033 "Parser/Core.jay"


}
					// line 1760 "-"

  $GLOBALS['_PHP_PARSER']['yyLhs']  = array(              -1,
    2,    0,    0,    1,    1,    7,    5,    5,    6,    6,
    3,    8,    8,    8,    8,    8,    8,    8,    8,    8,
    8,    8,    8,    8,    8,    8,    8,    8,    8,    8,
    8,    8,   26,   29,    8,   30,   31,    8,   32,    8,
    8,   24,   24,   35,   23,   23,    4,   38,   36,   36,
   40,   36,   42,   36,   27,   27,   16,   16,   28,   28,
   34,   34,   33,   33,   17,   17,   17,   17,   44,   46,
   44,   47,   44,   45,   45,   14,   14,   10,   48,   10,
   12,   49,   12,   11,   11,   13,   13,   39,   39,   50,
   50,   50,   50,   50,   50,   50,   50,   51,   51,   52,
   52,   52,   52,   52,   52,   20,   20,   53,   53,   53,
   21,   21,   21,   21,   41,   41,   55,   57,   58,   59,
   55,   60,   61,   55,   37,   37,   56,   62,   56,   56,
   63,   56,   22,   22,   22,   15,   15,   65,   64,   64,
   67,   18,   18,   18,   18,   18,   18,   18,   18,   18,
   18,   18,   18,   18,   18,   18,   18,   18,   18,   18,
   18,   18,   18,   72,   18,   73,   18,   74,   18,   75,
   18,   18,   18,   18,   18,   18,   18,   18,   18,   18,
   18,   18,   18,   18,   18,   18,   18,   18,   18,   18,
   18,   18,   18,   18,   18,   18,   76,   77,   18,   18,
   18,   18,   18,   18,   18,   18,   18,   18,   18,   80,
   18,   18,   18,   18,   18,   84,   68,   85,   68,   86,
   68,   69,   69,   79,   79,   79,   70,   70,   87,   87,
   87,   87,   87,   87,   87,   43,   43,   43,   43,   43,
   81,   81,   81,   81,   81,   81,   88,   88,   90,   90,
   89,   89,   89,   89,    9,    9,   54,   25,   71,   19,
   19,   91,   91,   93,   93,   93,   96,   96,   95,   95,
   92,   92,   97,   97,   98,   98,   98,   99,   99,   94,
   94,   66,   66,  100,  100,  100,   82,   82,  101,  101,
  101,  101,  101,  101,  101,  101,   83,   83,   83,   83,
   83,   83,   83,   83,   83,   83,   83,   83,  102,  102,
  102,  102,  102,  102,  103,  103,  103,   78,   78,   78,
   78,   78,   78,   78,  104,  105,  104,
  );
  $GLOBALS['_PHP_PARSER']['yyLen'] = array(           2,
    0,    3,    0,    1,    1,    0,    3,    0,    1,    1,
    1,    3,    7,   10,    5,    7,    9,    5,    2,    3,
    2,    3,    2,    3,    3,    3,    3,    3,    1,    2,
    3,    5,    0,    0,   10,    0,    0,   10,    0,    6,
    1,    1,    3,    1,    1,    3,    1,    0,   10,    8,
    0,    6,    0,    8,    0,    2,    1,    4,    1,    4,
    1,    4,    3,    5,    3,    4,    4,    5,    0,    0,
    6,    0,    5,    1,    1,    1,    4,    0,    0,    7,
    0,    0,    8,    0,    2,    0,    3,    1,    0,    1,
    2,    2,    3,    3,    4,    4,    5,    1,    0,    1,
    1,    2,    3,    3,    4,    3,    1,    1,    2,    4,
    3,    5,    1,    3,    2,    0,    3,    0,    0,    0,
   12,    0,    0,   10,    0,    1,    3,    0,    6,    1,
    0,    4,    0,    3,    1,    0,    1,    0,    4,    1,
    0,    7,    3,    4,    4,    6,    5,    3,    3,    3,
    3,    3,    3,    3,    3,    3,    3,    3,    3,    2,
    2,    2,    2,    0,    4,    0,    4,    0,    4,    0,
    4,    3,    3,    3,    3,    3,    3,    3,    3,    3,
    3,    3,    3,    2,    2,    2,    2,    3,    3,    3,
    3,    3,    3,    3,    3,    3,    0,    0,    7,    1,
    1,    2,    2,    2,    2,    2,    2,    2,    2,    0,
    3,    1,    4,    3,    2,    0,    5,    0,    5,    0,
    7,    1,    1,    0,    2,    3,    0,    3,    1,    1,
    1,    1,    1,    1,    1,    1,    1,    2,    2,    4,
    1,    1,    1,    3,    3,    3,    0,    2,    0,    1,
    5,    3,    3,    1,    1,    1,    1,    1,    1,    1,
    3,    1,    2,    4,    4,    1,    1,    4,    0,    1,
    1,    3,    1,    1,    4,    4,    1,    1,    3,    1,
    2,    3,    1,    1,    4,    0,    0,    2,    5,    3,
    3,    1,    6,    4,    4,    2,    2,    2,    2,    2,
    2,    2,    2,    2,    2,    2,    2,    0,    1,    2,
    3,    3,    6,    3,    1,    1,    1,    4,    4,    2,
    2,    4,    2,    2,    1,    0,    4,
  );
  $GLOBALS['_PHP_PARSER']['yyDefRed'] = array(            3,
    1,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  229,  230,    0,  242,  267,   29,  231,    0,    0,    0,
    0,    0,   39,    0,    0,    0,    0,   48,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  234,  235,
  232,  233,  308,    0,    0,    0,    0,  210,    8,    0,
   41,    0,  308,  308,  308,    2,    4,    5,   11,    0,
  256,    0,   47,  255,  200,    0,  201,  212,  243,    0,
    0,    0,  266,    0,    0,    0,    0,    0,    0,  259,
  161,  163,  202,  203,  204,  205,  206,  207,  208,  222,
  257,  223,    0,    0,  209,    0,    0,  216,    0,    0,
    0,    0,    0,    0,    0,    0,   19,    0,   21,    0,
  126,    0,    0,   23,    0,    0,    0,   45,    0,    0,
  108,    0,    0,  107,    0,    0,    0,    0,    0,    0,
  141,    0,    0,    0,    0,  186,  187,    0,    0,    0,
    0,    0,    0,    0,  168,    0,  170,  164,  166,    0,
    0,    0,    0,    0,    0,    0,    0,  197,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,   30,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  218,  160,  162,    0,    0,    0,    0,    0,
    0,    0,  148,  225,    0,    0,    0,    0,    0,   28,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
   20,   22,    0,    0,   24,   25,    0,   31,    0,  109,
    0,   26,    0,    0,   27,   44,    0,   42,  325,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  298,    0,
  299,  301,  302,  300,  307,  246,    0,    0,  303,  305,
  306,  304,  297,  211,   12,    0,  196,    0,  214,  244,
  245,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,  179,  180,  181,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,  278,    0,  274,    0,  271,    0,  277,    0,    0,
    0,  322,    0,    0,    0,    0,    0,  226,    0,  220,
    0,    0,    0,    0,    0,  138,   36,   33,    0,    0,
    0,    0,    0,    0,    0,    0,    0,   46,    0,  106,
  237,    0,    0,    0,  114,  236,    0,    0,    0,  326,
  318,  319,   53,  116,    0,  284,    0,  283,  258,  296,
    0,  213,    0,  288,    0,  310,    0,    0,    0,    9,
   10,    7,  268,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  144,  145,    0,    0,    0,    0,    0,  264,
  265,  102,  228,    0,    8,   78,    0,  217,    0,    8,
   76,   15,    0,    0,    0,    0,    0,    0,    0,    0,
    0,   18,    0,   92,   91,    8,    0,    0,  110,    0,
  238,  239,    0,   43,   32,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  311,    0,  312,  314,  198,
  147,    0,  219,  279,  272,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,   63,
    0,    8,   61,   40,   69,    0,   69,    0,   93,    0,
    0,    0,    0,    0,    0,    0,    0,  112,  327,  116,
  122,  118,    0,   52,  115,    0,  282,    0,  295,  294,
    0,    0,    0,  146,  275,  276,  105,    0,    0,    0,
   13,  221,   16,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,   65,    0,    0,   96,   95,
    0,    0,  240,    0,  248,    0,    0,    0,    0,    0,
  285,    0,    0,    0,    0,    0,    0,    0,    0,    0,
   85,   77,    0,   56,   37,   34,   64,    0,    0,   67,
    0,   74,   75,   72,   66,   50,   97,    8,  253,    0,
   54,    0,    0,    0,    0,  117,  293,  313,    0,    8,
    0,    0,    8,   57,   17,    0,    0,   62,   68,   70,
    8,    0,    0,  123,  119,    0,    0,    0,    0,   14,
   79,    0,    8,   59,   38,   35,    8,    0,   49,  251,
    0,    0,  132,    0,    0,    0,    0,    0,    0,    0,
    0,    0,   82,   80,   58,    0,    8,    0,  129,    8,
   60,    0,  120,    0,    0,    0,  124,    8,    0,  121,
  );
  $GLOBALS['_PHP_PARSER']['yyDgoto']  = array(             1,
   66,    2,  604,   68,  149,  382,  266,   69,   70,  462,
  511,  508,  549,  412,  214,  585,  422,   71,   72,  133,
  136,  110,  130,  237,  218,  416,  517,  605,  587,  415,
  586,  115,  340,  474,  238,   73,  122,  123,  345,  243,
  438,  437,  355,  476,  564,  607,  591,  616,  630,  346,
  326,  327,  134,   74,  495,  540,  538,  612,  636,  537,
  611,  614,  574,  215,  414,  367,  244,   75,  103,  203,
   76,  275,  276,  272,  274,  285,  503,   77,  105,  148,
   78,  247,  143,  208,  311,  407,   79,  486,  487,  374,
   80,  315,   81,   82,  320,   83,  316,  317,  318,  368,
  248,  263,    0,  240,  436,
  );
  $GLOBALS['_PHP_PARSER']['yySindex'] = array(            0,
    0, 1593, 4236, 4236,   26, 4236, 4236, 4236,  -15,  -15,
 4236, 4236, 4236, 4236, 4236, 4236, 4236,    3,   41,   49,
    0,    0,  -39,    0,    0,    0,    0, 4236, 2733,   65,
   70,  105,    0,  111, 3052, 3123,  132,    0, 3194,  -37,
   -7, -234,  156,  169,  176, -176,  181,  187,    0,    0,
    0,    0,    0, 4236, 4236, 4236, 4236,    0,    0, 4236,
    0,   84,    0,    0,    0,    0,    0,    0,    0, 6877,
    0,  660,    0,    0,    0, -235,    0,    0,    0, -111,
  -31,    6,    0, 7878, 7878, 4236, 7878, 7878, 4594,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  215, 3397,    0, 4236,    3,    0, 7878,   68,
  -77, 4236, 4236, 4236,  217, 4236,    0, 6947,    0, 6980,
    0,  -54,  132,    0, 7878,  202,  336,    0,    4,  214,
    0,   14,   82,    0,  249,   87,  -15,  -15,  -15,  -40,
    0, 3474,  923,  299,  299,    0,    0, 4236,  230, 7007,
 4236, 2888,  167,  601,    0, 4236,    0,    0,    0, 4236,
 4236, 4236, 4236, 4236, 4236, 4236, 4236,    0, 4236, 4236,
 4236, 4236, 4236, 4236, 4236, 4236, 4236, 4236, 4236,    0,
 4236, 4236, 4236, 4236, 4236, 4236, 4236, 4236, 4236, 4236,
 4236, 3545,    0,    0,    0,  -10, 4236, 4236,   84,  -31,
 7018, 3685,    0,    0, 7051, 7127,  318, 3685, 4236,    0,
  326, 7154, 7878,  335,  333,   73,  660,   75,  103, 7279,
    0,    0,  -18,  104,    0,    0,  369,    0, 4236,    0,
   -7,    0,  211,  117,    0,    0,   91,    0,    0,  154,
  383,  123,  305,  -34,  -15, 2416,  389,  387,    0,  -17,
    0,    0,    0,    0,    0,    0, 4313,  -15,    0,    0,
    0,    0,    0,    0,    0, 1593,    0, 7320,    0,    0,
    0, 4236, 8129, 4236, 4236, 4236,  533,  533,  533,  533,
   57,   57,  314,  314, 4236, 4144, 2449, 4003,   57,   57,
  299,  299,  299,    0,    0,    0, 4594, 4594, 4594, 4594,
 4594, 4594, 4594, 4594, 4594, 4594, 4594,    3,  -25, 4594,
 3685,    0, 4236,    0,   92,    0,  -26,    0, 7878,  339,
 7332,    0,  -15,    0,  660,  392,  390,    0, 2006,    0,
  395, 7878, 4236, 2100, 4236,    0,    0,    0,  378,  192,
  -22,  382,  136,  138,  405,  402,  407,    0, 7404,    0,
    0,  408,  211,  211,    0,    0,  396,  -15,  391,    0,
    0,    0,    0,    0,  411,    0,  198,    0,    0,    0,
 3822,    0, 3962,    0,  149,    0,  365, 7442,  334,    0,
    0,    0,    0, 8083, 4594, 7416, 3589, 7454,  215,    3,
  -39,  420,    0,    0,  422, 7583,  -10, 4236, 4236,    0,
    0,    0,    0, 4033,    0,    0, 3685,    0, 7704,    0,
    0,    0,  406, 4236,  -15,  -15,  211,  166, 2210,  413,
  416,    0,  211,    0,    0,    0,  -13,  -18,    0,  211,
    0,    0,  211,    0,    0,  -15,  356, -102,  -34,  -34,
  424,  -15, 7878,  -15, 5472,    0, 4236,    0,    0,    0,
    0,  215,    0,    0,    0,  393, 7715,  -15,    0,  660,
    0, -161,  449,  430,  178, 4236, 7878,  148,  148,    0,
  434,    0,    0,    0,    0,   13,    0, -101,    0,  455,
  436,  195,  196,  457,  155,  463,  462,    0,    0,    0,
    0,    0,  203,    0,    0,  221,    0, 4236,    0,    0,
 4109, 7748, 4236,    0,    0,    0,    0, -143,  471, 2733,
    0,    0,    0,  459,  478,  -15,  480,  481,  211,  206,
   78,  465, 4236,  210,  -82,    0,  470,  211,    0,    0,
  409,  211,    0,  211,    0,  -90,  132,  132,    0,   89,
    0, 4594,  -15, 7878,  414, 6545,  490,  473,  232, 4236,
    0,    0, 2529,    0,    0,    0,    0,  477,  483,    0,
 6664,    0,    0,    0,    0,    0,    0,    0,    0,  199,
    0,  236,  242,  486,  244,    0,    0,    0, 4236,    0,
  494, 7759,    0,    0,    0, 2623, 2623,    0,    0,    0,
    0,  429,  211,    0,    0,  211,    0, 7788,    0,    0,
    0,  231,    0,    0,    0,    0,    0,    0,    0,    0,
  -18,  515,    0,  495,  506, 2733,  507,  247,    0,  532,
  -18,  211,    0,    0,    0,  518,    0,  541,    0,    0,
    0,  542,    0,    0,  525,  468,    0,    0,  460,    0,
  );
  $GLOBALS['_PHP_PARSER']['yyRindex'] = array(            0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0, 5115,    0,
    0,    0, 5183,    0,    0,    0,    0,   90,    0,    0,
    0,    0,    0,    0,    0,    0,  288,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,   18,    0,    0,    0,    0,    0,    0,    0,    0,
    0, 5088,    0,    0,    0,    0,    0,    0,    0, 4795,
 4427,    0,    0,    5,  193,    0,  476,  504,  880,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0, 5377,    0,    0,    0,    0,    0,   96,    0,
    0,    0,  537,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  288,    0,    0, 8041, 6625,    0,    0,    0,
    0,    0,    0,    0,  158,    0,    0,    0,    0,  475,
    0,  558,    0, 5499, 5556,    0,    0,    0, 1687,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  520,    0,   19, 4679,
    0,  559,    0,    0,    0,    0,    0,  559,    0,    0,
    0,    0,   32,    0,   36, 8041, 6490,    0,    0,    0,
    0,    0,  575,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,  241,    0,  303,    0,  587,    0,   -6,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0, 3555,    0,    0,    0, 2108, 6262, 6285, 6374,
 5954, 6119, 5917, 6005,    0, 6252, 4502, 6381, 6126, 6215,
 5752, 5809, 5863,    0,    0,    0,  908,  924, 1199, 1293,
 1321, 1612, 1706, 1734, 2025, 2548, 2631,    0,    0, 3182,
  559,    0,    0,    0, 5061,    0, 4768,    0,  543,    0,
    0,    0,    0, 6697, 3089,    0,  597,    0,    0,    0,
    0,  161,    0,    0,  537,    0,    0,    0,    0,    0,
    0,   39,    0,    0,    0,  243,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  164,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  598,    0,    0,    0, 7833,    0,    0,    0,
    0,    0,    0,   27, 3213, 3202, 4155,    0, 5377,    0,
    0, 5445,    0,    0,    0,    0,    0,  520,    0,    0,
    0,    0,    0,    0,    0,    0,  559,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,   88,
  -78,    0,    0,    0,    0,    0,    0,  611,    0,  620,
    0,    0,    0,    0,    0,    0,    0,    0,  241,  241,
    0,    0,  323,    0,  337,    0,    0,    0,    0,    0,
    0, 5377,    0,    0,    0,    0,    0,    0, 6752, 6556,
  861,  329,    0,    0, 1687,  625,   34,  630,  630,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0, 1687,
  174,    0,    0,    0,  342,    0,  587,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  371,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0, 1687,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,  598,    0,    0,  288,  288,   23,    0,
    0, 3536,    0,  343,    0,  788,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  348,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0, 1687,    0,    0,    0,    0,   63,    0, 1274,    0,
    0, 1687,    0,    0,    0,    0,    0,  448,    0,    0,
  575,    0,    0,    0,    0,    0,    0, 1687,  767,    0,
  611,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0, 1687,    0, 1180,    0,    0,    0,    0, 1687,    0,
  );
  $GLOBALS['_PHP_PARSER']['yyGindex'] = array(            0,
    0,    0,   -2,  415, 1191,    0,    0,    0,    2,    0,
    0,    0,    0,    0, -284,    0,    0,   -5,   22,    0,
    0,    0,    0,    0,   25,    0,  204,   93,    0,    0,
    0,    0,    0,    0,  324,    0, -119,    0, -358,    0,
  194,    0, 6039, -352,  122,    0,    0,    0,    0,    0,
 -164,    0,  454,  -11,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  248,    0,  379,  -95, -341,
  381,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  357,    0,    0,    0, -211,    0,    0,  208,
 -151,    0,  607,    0,  292,    0,  294,    0,    0,  253,
    0,    0,    0,    0,    0,
  );
  $GLOBALS['_PHP_PARSER']['yyTable'] = array(            67,
  108,   62,  129,  224,   84,   85,  102,   87,   88,   89,
   62,  207,   93,   94,   95,   96,   97,   98,   99,  344,
   62,  356,  494,  526,  483,   62,  111,  309,  132,  109,
   90,   90,  309,  126,  571,  420,  118,  120,   62,  101,
  125,  199,  565,  331,  314,  320,   69,  451,  320,   62,
  413,  194,  195,  280,  281,  144,  145,  146,  147,  197,
  127,  150,  320,  320,  398,   86,  130,  169,  478,  484,
  169,  135,  140,  376,  139,  140,  137,  139,   90,   90,
  104,  130,   90,  131,  169,  169,  309,  201,  106,  309,
  140,  198,  139,  179,  137,  102,  399,  320,  177,  174,
  421,  175,  176,  178,  112,  205,  127,  206,  216,  113,
  504,  209,  313,  212,  213,  125,  309,  220,  309,  169,
  230,  127,  521,  128,  525,  231,  210,  140,  101,  320,
  234,  359,  575,  133,  358,  217,  229,  509,  510,  135,
  232,  356,  356,  246,  114,  235,  395,  576,  133,  264,
  116,  169,  268,  101,  135,  547,  548,  273,  236,  239,
  241,  277,  278,  279,  280,  281,  282,  283,  284,  121,
  286,  287,  288,  289,  290,  291,  292,  293,  294,  295,
  296,  515,  297,  298,  299,  300,  301,  302,  303,  304,
  305,  306,  307,  310,  361,  137,  324,  360,  319,  321,
  270,  113,  324,  125,  134,  356,  151,  111,  138,  125,
  332,  356,  389,   94,   94,  139,  113,   94,  356,  134,
  141,  356,  111,  325,  523,  524,  142,  491,  492,  325,
  349,  196,  419,  321,  493,  418,  321,  211,  441,  491,
  492,  440,  463,  523,  524,  314,  493,   69,   69,  223,
  321,  321,  620,  353,  202,  354,  219,  259,  378,  262,
  225,  541,  628,  380,  440,  366,  369,  562,  563,  370,
  390,   25,  228,  384,  128,  385,  386,  387,  391,  379,
   25,  286,   88,   88,  286,  321,  388,  342,  169,  260,
   25,  261,  481,  312,  452,   25,  102,  309,  131,  309,
  309,  242,  309,  309,  309,  324,  100,  356,   25,  233,
  365,   25,  125,  343,  396,  227,  356,  321,  482,   25,
  356,  107,  356,  280,  281,  375,  406,  320,   84,  101,
  392,  411,  325,  393,  409,  179,  213,  522,  523,  524,
  177,  166,  167,  292,  369,  178,  292,  402,  320,  169,
  179,  309,  309,  309,  265,  177,  174,  330,  175,  176,
  178,   84,   84,  291,   84,  333,  291,   84,   84,   84,
  169,   84,  443,   84,  445,  193,  336,  290,  102,  236,
  290,  356,  254,  289,  356,  254,  289,   84,  252,   91,
   92,  252,   84,  335,  226,  337,  192,  338,  459,  319,
  457,  324,  559,  523,  524,  125,  339,  347,  125,  348,
  356,  101,   69,   69,   69,  467,  473,  572,  573,  152,
  153,  154,  357,  362,   84,  460,  363,  364,  325,  372,
  373,  400,  403,  404,  397,  408,  369,  369,  417,  468,
  469,  424,  423,  425,  426,  427,  428,  430,  502,  435,
  439,   84,  446,   84,   84,  447,  433,  489,  449,  193,
  366,  366,  453,  369,  466,  369,  499,  213,  500,  471,
  249,  475,  250,  251,  477,  252,  253,  254,  490,  369,
    6,    6,  507,    6,  498,  505,    6,    6,  513,  512,
    6,  516,    6,  514,  519,  527,  528,  531,  532,  542,
  529,  530,  544,  533,  546,  534,    6,  551,  539,  255,
  550,    6,   21,   22,  351,  321,  323,  552,  553,  323,
  555,  556,   27,  560,  561,  257,  258,  558,  566,  579,
  580,  568,  581,  323,  323,  588,  321,  369,  578,  594,
  554,  589,  593,    6,  324,  595,  596,  324,  617,  597,
  584,  582,  600,  609,  621,  622,  352,   49,   50,   51,
   52,  324,  324,  623,  369,  625,  626,  577,  323,  179,
    6,  627,   73,    6,  177,  174,  631,  175,  176,  178,
  598,  633,  635,  637,  640,   84,   84,   84,   84,   84,
  638,  125,  172,   84,  173,  136,  324,   51,  287,   99,
  323,  181,  182,  183,  184,  185,  186,  187,  188,  189,
  190,  191,  269,  624,   89,   84,   84,   84,   84,   84,
   84,   84,   84,   84,   84,   84,   84,  249,  324,   84,
   84,   84,   84,   84,   84,  270,   84,   98,  250,  271,
   84,   84,   84,   84,   84,   84,   84,   84,   84,   84,
   84,   89,   84,   84,   84,   84,   84,   84,   84,   84,
  247,   84,   84,   84,   84,  136,   84,   84,   84,   84,
   55,   86,  518,   84,   84,   84,   84,   84,   84,  606,
  381,  434,  590,  536,  350,   84,  496,  394,  200,  456,
  455,  259,  497,  262,  535,    0,    0,    0,    0,  193,
    0,    0,    0,    0,    6,    6,    6,    6,    6,    0,
    0,    0,    6,    0,    0,    0,    0,    0,    0,    0,
  192,    0,    0,  260,    0,  261,    0,    0,    0,    0,
    0,    0,    0,    0,    6,    6,    6,    6,    6,    6,
    6,    6,    6,    6,    6,    6,    0,    0,    0,    6,
    6,    6,    6,    6,    0,    6,    0,    0,    0,    6,
    6,    6,    6,    0,    6,    0,    6,    0,    6,    0,
    0,    6,   73,   73,   73,    6,    6,    6,    6,    0,
    6,    6,    6,    6,    0,    6,    6,    6,    6,    0,
    0,    0,    6,    6,    6,    6,    6,    6,  323,    6,
    6,    0,    6,    0,    6,    6,    6,    0,    0,    6,
    0,    6,    0,    0,    0,  164,  165,  166,  167,  323,
    0,    0,    0,    0,    0,    6,  324,    0,  199,    0,
    6,  199,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  199,  199,  324,    0,    0,
  199,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    6,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  199,    0,    0,    0,    0,    0,    0,    0,    0,    6,
    0,   71,    6,    6,    6,    0,    6,    0,    0,    6,
    6,    0,    0,    6,  249,    6,  250,  251,    0,  252,
  253,  254,  199,    0,    0,    0,    0,    0,    0,    6,
  215,    0,    0,  215,    6,  181,  182,  183,  184,  185,
  186,  187,  188,  189,  190,  191,    0,  215,  215,    0,
    0,    0,    0,  255,    0,    0,    0,    0,  149,    0,
    0,  149,    0,    0,    0,    0,    6,    0,    0,  257,
  258,    0,    0,    0,  150,  149,  149,  150,    0,    0,
    0,    0,  215,    0,    0,    0,    0,    0,    0,    0,
    0,  150,  150,    6,    0,    0,    6,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  149,    0,    0,    0,  215,    0,    0,    0,    0,    0,
    0,    0,    0,  259,    0,  262,  150,    0,    0,    0,
    0,    0,    0,    6,    6,    6,    6,    6,    0,    0,
    0,    6,  149,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  260,    0,  261,  150,  199,
  199,  199,    0,    6,    6,    6,    6,    6,    6,    6,
    6,    6,    6,    6,    6,    0,    0,    0,    6,    6,
    6,    6,    6,    0,    6,    0,    0,    0,    6,    6,
    6,    6,    0,    6,    0,    6,    0,    6,    0,    0,
    6,   71,   71,   71,    6,    6,    6,    6,    0,    6,
    6,    6,    6,    0,    6,    6,    6,    6,    0,    0,
  199,    6,    6,    6,    6,    6,    6,    6,    6,    6,
    6,    6,    0,    6,    0,    6,    0,    0,    0,    0,
    0,  199,    0,    0,    0,    0,    0,    0,    0,    0,
    0,  215,  215,  215,    0,    0,    0,    6,    6,    6,
    6,    6,    6,    6,    6,    6,    6,    6,    6,   81,
   81,   81,    6,    6,    6,    6,    6,    0,    6,  149,
  149,  149,    6,    6,    6,    6,    0,    6,    0,    6,
    0,    6,    0,    0,    6,  150,  150,  150,    6,    6,
    6,    6,    0,    6,    6,    6,    6,    0,    6,    6,
    6,    6,  215,    0,    0,    6,    6,    6,    6,    6,
    6,    0,    6,    6,    0,    6,    0,    6,    6,    6,
    0,    0,    6,  215,    6,    0,  249,    0,  250,  251,
  149,  252,  253,  254,    0,    0,    0,    0,    6,  151,
    0,    0,  151,    6,    0,    0,  150,    0,    0,    0,
    0,  149,    0,    0,    0,    0,  151,  151,    0,    0,
    0,    0,    0,    0,    0,  255,    0,  150,    0,    0,
    0,    0,    0,    0,    0,    6,    0,    0,    0,    0,
  256,  257,  258,    0,    0,    0,    0,    0,    0,    0,
    0,  151,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    6,    0,    0,    6,    6,    6,    0,    6,
    0,    0,    6,    6,    0,    0,    6,    0,    6,    0,
    0,    0,    0,  151,    0,    0,    0,    0,    0,    0,
    0,    0,    6,  152,    0,    0,  152,    6,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  152,  152,    0,    0,    0,    0,    0,    0,    0,    0,
    0,  153,    0,    0,  153,    0,    0,    0,    0,    6,
    0,    0,    0,    0,    0,    0,    0,    0,  153,  153,
    0,    0,    0,    0,    0,  152,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    6,    0,    0,    6,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,  153,    0,    0,    0,  152,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    6,    6,    6,    6,
    6,    0,    0,    0,    6,  153,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  151,  151,  151,    0,    0,    0,    6,    6,    6,    6,
    6,    6,    6,    6,    6,    6,    6,    6,   83,   83,
   83,    6,    6,    6,    6,    6,    0,    6,    0,    0,
    0,    6,    6,    6,    6,    0,    6,    0,    6,    0,
    6,    0,    0,    6,    0,    0,    0,    6,    6,    6,
    6,    0,    6,    6,    6,    6,    0,    6,    6,    6,
    6,  151,    0,    0,    6,    6,    6,    6,    6,    6,
    6,    6,    6,    6,    6,    0,    6,    0,    6,    0,
    0,    0,  151,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  152,  152,  152,    0,    0,    0,
    6,    6,    6,    6,    6,    6,    6,    6,    6,    6,
    6,    6,    0,    0,   87,    6,    6,    6,    6,    6,
    0,    6,  153,  153,  153,    6,    6,    6,    6,    0,
    6,    0,    6,    0,    6,  461,    0,    6,    0,    0,
  465,    6,    6,    6,    6,    0,    6,    6,    6,    6,
    0,    6,    6,    6,    6,  152,  480,    0,    6,    6,
    6,    6,    6,    6,    0,   56,   64,    0,   62,    0,
    6,   65,   60,    0,    0,   54,  152,   55,    0,    0,
    0,    0,    0,  153,    0,    0,    0,    0,    0,    0,
    0,   61,  154,    0,    0,  154,   58,    0,    0,    0,
    0,    0,  520,    0,  153,    0,    0,    0,    0,  154,
  154,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,   63,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  154,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,   59,    0,    0,   57,    6,
    6,    0,    6,    0,    0,    6,    6,    0,    0,    6,
    0,    6,    0,    0,    0,    0,  154,    0,    0,    0,
    0,    0,    0,    0,    0,    6,  155,    0,    0,  155,
    6,    0,    0,    0,    0,    0,    0,    0,  592,    0,
    0,    0,    0,  155,  155,    0,    0,    0,    0,    0,
  599,    0,    0,  602,  156,    0,    0,  156,    0,    0,
    0,  608,    6,    0,    0,    0,    0,    0,    0,    0,
    0,  156,  156,  618,    0,    0,    0,  619,  155,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    6,
    0,    0,    6,    0,    0,    0,    0,  632,    0,    0,
  634,    0,    0,    0,    0,    0,  156,    0,  639,    0,
  155,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    3,
    4,    5,    6,    7,    0,    0,    0,    8,  156,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,  154,  154,  154,    0,    0,    0,    9,
   10,   11,   12,   13,   14,   15,   16,   17,   18,   19,
   20,    0,    0,    0,   21,   22,   23,   24,   25,    0,
   26,    0,    0,    0,   27,   28,   29,   30,    0,   31,
    0,   32,    0,   33,    0,    0,   34,    0,    0,    0,
   35,   36,   37,   38,    0,   39,   40,   41,   42,    0,
   43,   44,   45,   46,  154,    0,    0,   47,   48,   49,
   50,   51,   52,    6,    6,    6,    6,    6,    0,   53,
    0,    6,    0,    0,    0,  154,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  155,  155,  155,
    0,    0,    0,    6,    6,    6,    6,    6,    6,    6,
    6,    6,    6,    6,    6,    0,    0,    0,    6,    6,
    6,    6,    6,    0,    6,  156,  156,  156,    6,    6,
    6,    6,    0,    6,    0,    6,    0,    6,    0,    0,
    6,    0,    0,    0,    6,    6,    6,    6,    0,    6,
    6,    6,    6,    0,    6,    6,    6,    6,  155,    0,
    0,    6,    6,    6,    6,    6,    6,    0,   56,   64,
    0,   62,    0,    6,   65,   60,    0,    0,   54,  155,
   55,    0,    0,    0,    0,    0,  156,    0,    0,    0,
    0,    0,    0,  405,   61,  157,    0,    0,  157,   58,
    0,    0,    0,    0,    0,    0,    0,  156,    0,    0,
    0,    0,  157,  157,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,   63,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  157,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,   59,    0,
    0,   57,   56,   64,    0,   62,    0,    0,   65,   60,
    0,    0,   54,    0,   55,  190,    0,    0,  190,  157,
    0,  190,    0,    0,    0,    0,    0,  410,   61,    0,
    0,    0,    0,   58,    0,  190,  190,    0,    0,    0,
  190,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,   63,    0,    0,    0,    0,
  190,  190,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,   59,    0,    0,   57,    0,    0,    0,    0,
    0,  190,  190,    0,    0,    0,    0,    0,    0,    0,
    0,    0,   56,   64,    0,   62,    0,    0,   65,   60,
    0,    0,   54,    0,   55,    0,    0,    0,    0,    0,
    0,    0,    3,    4,    5,    6,    7,  472,   61,    0,
    8,    0,    0,   58,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  157,  157,  157,    0,
    0,    0,    9,   10,   11,   12,   13,   14,   15,   16,
   17,   18,   19,   20,    0,   63,    0,   21,   22,   23,
   24,   25,    0,   26,    0,    0,    0,   27,   28,   29,
   30,    0,   31,    0,   32,    0,   33,    0,    0,   34,
    0,    0,   59,   35,   36,   57,    0,    0,   39,   40,
   41,   42,    0,   43,   44,   45,    0,  157,    0,    0,
   47,   48,   49,   50,   51,   52,    3,    4,    5,    6,
    7,    0,   53,    0,    8,    0,    0,    0,  157,  190,
  190,  190,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  190,  190,    9,   10,   11,   12,
   13,   14,   15,   16,   17,   18,   19,   20,    0,    0,
    0,   21,   22,   23,   24,   25,    0,   26,    0,    0,
    0,   27,   28,   29,   30,    0,   31,    0,   32,    0,
   33,    0,    0,   34,    0,    0,    0,   35,   36,    0,
  190,    0,   39,   40,   41,   42,    0,   43,   44,   45,
    0,    0,    0,    0,   47,   48,   49,   50,   51,   52,
    0,  190,  179,  171,    0,    0,   53,  177,  174,    0,
  175,  176,  178,    0,    0,    0,    3,    4,    5,    6,
    7,    0,    0,    0,    8,  172,    0,  173,  168,    0,
    0,    0,    0,    0,    0,  179,  171,    0,    0,    0,
  177,  174,    0,  175,  176,  178,    9,   10,   11,   12,
   13,   14,   15,   16,   17,   18,   19,   20,  172,  170,
  173,   21,   22,   23,   24,   25,    0,   26,    0,    0,
    0,   27,   28,   29,   30,    0,   31,    0,   32,    0,
   33,    0,    0,   34,    0,    0,    0,   35,   36,  169,
    0,    0,   39,   40,   41,   42,    0,   43,   44,   45,
    0,    0,    0,    0,   47,   48,   49,   50,   51,   52,
    0,   56,   64,    0,   62,    0,   53,   65,   60,    0,
    0,   54,    0,   55,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  583,   61,  158,    0,
    0,  158,   58,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  158,  158,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,   63,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  158,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,   59,    0,    0,   57,   56,   64,    0,   62,    0,
    0,   65,   60,    0,    0,   54,    0,   55,    0,    0,
    0,  159,  158,    0,  159,    0,    0,  155,  156,  157,
  603,   61,    0,    0,    0,    0,   58,    0,  159,  159,
    0,    0,  158,  159,  160,  161,  162,  163,  164,  165,
  166,  167,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,   63,    0,
    0,    0,    0,  159,    0,    0,    0,  160,  161,  162,
  163,  164,  165,  166,  167,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,   59,    0,    0,   57,    0,
    0,    0,    0,    0,    0,  159,    0,    0,    0,  371,
    0,    0,    0,    0,    0,   56,   64,    0,   62,    0,
    0,   65,   60,    0,    0,   54,    0,   55,    0,    0,
    0,    0,    0,    0,    0,    3,    4,    5,    6,    7,
    0,   61,    0,    8,    0,    0,   58,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  158,
  158,  158,    0,    0,    0,    9,   10,   11,   12,   13,
   14,   15,   16,   17,   18,   19,   20,    0,   63,    0,
   21,   22,   23,   24,   25,    0,   26,    0,    0,    0,
   27,   28,   29,   30,    0,   31,    0,   32,    0,   33,
    0,    0,   34,    0,    0,   59,   35,   36,   57,    0,
    0,   39,   40,   41,   42,    0,   43,   44,   45,    0,
  158,    0,    0,   47,   48,   49,   50,   51,   52,    3,
    4,    5,    6,    7,    0,   53,    0,    8,    0,    0,
    0,  158,  159,  159,  159,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    9,
   10,   11,   12,   13,   14,   15,   16,   17,   18,   19,
   20,    0,    0,    0,   21,   22,   23,   24,   25,    0,
   26,    0,    0,    0,   27,   28,   29,   30,    0,   31,
    0,   32,    0,   33,    0,    0,   34,    0,    0,    0,
   35,   36,    0,  159,    0,   39,   40,   41,   42,    0,
   43,   44,   45,    0,    0,    0,    0,   47,   48,   49,
   50,   51,   52,    0,  159,    0,    0,    0,  259,   53,
  262,    0,    0,  269,    0,    0,    0,    0,    0,    3,
    4,    5,    6,    7,    0,    0,    0,    8,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  260,    0,  261,    0,    0,    0,    0,    0,    0,    9,
   10,   11,   12,   13,   14,   15,   16,   17,   18,   19,
   20,    0,    0,    0,   21,   22,   23,   24,   25,    0,
   26,    0,    0,    0,   27,   28,   29,   30,    0,   31,
    0,   32,    0,   33,    0,    0,   34,    0,    0,    0,
   35,   36,    0,    0,    0,   39,   40,   41,   42,    0,
   43,   44,   45,    0,    0,    0,    0,   47,   48,   49,
   50,   51,   52,    0,   56,   64,    0,   62,    0,   53,
   65,   60,    0,    0,   54,    0,   55,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  117,    0,    0,    0,    0,   58,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  257,  257,    0,    0,  101,
  257,  257,  101,  257,  257,  257,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,   63,  257,    0,
  257,  257,    0,    0,    0,   56,   64,    0,   62,    0,
    0,   65,   60,    0,    0,   54,    0,   55,    0,    0,
    0,    0,    0,    0,    0,    0,    0,   57,    0,    0,
    0,  119,  257,    0,    0,    0,   58,    0,    0,    0,
    0,  249,    0,  250,  251,    0,  252,  253,  254,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  257,    0,    0,    0,    0,    0,   63,    0,
    0,    0,  143,    0,    0,  143,   56,   64,    0,   62,
  255,    0,   65,   60,    0,    0,   54,    0,   55,  143,
  143,    0,  165,    0,    0,  165,  257,  258,   57,    0,
    0,    0,  124,  171,    0,    0,  171,   58,    0,  165,
  165,    0,    0,    0,  165,    0,    0,    0,    0,    0,
  171,  171,    0,    0,  143,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,   63,
    0,    0,    0,    0,  165,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  171,  143,    0,    3,    4,
    5,    6,    7,    0,    0,    0,    8,    0,    0,   57,
    0,    0,    0,    0,    0,    0,  165,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  171,    9,   10,
   11,   12,   13,   14,   15,   16,   17,   18,   19,    0,
  257,  257,  257,   21,   22,   23,   24,   25,    0,    0,
    0,    0,    0,   27,    0,  257,  257,  257,  257,  257,
  257,  257,  257,  257,  257,  259,  259,    0,    0,    3,
    4,    5,    6,    7,    0,    0,    0,    8,    0,    0,
   44,   45,    0,    0,    0,    0,   47,   48,   49,   50,
   51,   52,    0,    0,    0,    0,    0,    0,   53,    9,
   10,   11,   12,   13,   14,   15,   16,   17,   18,   19,
    0,    0,    0,    0,   21,   22,   23,   24,   25,   56,
   64,    0,   62,    0,   27,   65,   60,  204,    0,   54,
    0,   55,    0,  143,  143,  143,    0,    0,    0,    0,
    3,    4,    5,    6,    7,    0,    0,    0,    8,    0,
   58,   44,   45,  165,  165,  165,    0,   47,   48,   49,
   50,   51,   52,    0,  171,  171,  171,    0,  165,   53,
    9,   10,   11,   12,   13,   14,   15,   16,   17,   18,
   19,    0,   63,    0,    0,   21,   22,   23,   24,   25,
    0,    0,    0,    0,  143,   27,   56,   64,    0,   62,
    0,  245,   65,   60,    0,    0,   54,    0,   55,    0,
    0,    0,   57,    0,  165,  143,    0,    0,    0,    0,
    0,    0,   44,   45,    0,  171,    0,   58,   47,   48,
   49,   50,   51,   52,    0,  165,    0,    0,    0,    0,
   53,    0,    0,    0,    0,    0,  171,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,   63,
    0,    0,    0,    0,    0,    0,  142,   56,   64,  142,
   62,    0,  309,   65,   60,    0,    0,   54,    0,   55,
    0,    0,    0,  142,  142,  172,    0,    0,  172,   57,
    0,    0,    0,    0,    0,    0,    0,    0,   58,    0,
    0,    0,  172,  172,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  179,  171,    0,  142,    0,
  177,  174,    0,  175,  176,  178,    0,    0,    0,    0,
   63,    0,    0,    0,    0,    0,    0,  172,  172,    0,
  173,    0,    0,    3,    4,    5,    6,    7,    0,    0,
  142,    8,    0,    0,    0,    0,    0,    0,    0,    0,
   57,    0,    0,    0,    0,    0,    0,    0,    0,  172,
    0,    0,  170,    9,   10,   11,   12,   13,   14,   15,
   16,   17,   18,   19,    0,    0,    0,    0,   21,   22,
   23,   24,   25,    0,    0,    0,    0,    0,   27,    0,
    0,    0,  169,    0,    0,    0,    0,   56,   64,    0,
   62,    0,  323,   65,   60,    0,    0,   54,    0,   55,
    3,    4,    5,    6,    7,   44,   45,    0,    8,    0,
    0,   47,   48,   49,   50,   51,   52,    0,   58,    0,
    0,    0,    0,   53,    0,    0,    0,    0,    0,    0,
    9,   10,   11,   12,   13,   14,   15,   16,   17,   18,
   19,    0,    0,    0,    0,   21,   22,   23,   24,   25,
   63,    0,    0,    0,    0,   27,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  142,  142,  142,
    0,    3,    4,    5,    6,    7,    0,    0,    0,    8,
   57,    0,   44,   45,    0,    0,  172,  172,   47,   48,
   49,   50,   51,   52,    0,    0,    0,    0,    0,    0,
   53,    9,   10,   11,   12,   13,   14,   15,   16,   17,
  308,   19,    0,    0,    0,    0,   21,   22,   23,   24,
   25,    0,    0,    0,   56,   64,   27,   62,  142,  442,
   65,   60,    0,    0,   54,    0,   55,  160,  161,  162,
  163,  164,  165,  166,  167,    0,    0,  172,    0,  142,
    0,    0,    0,   44,   45,   58,    0,    0,    0,   47,
   48,   49,   50,   51,   52,    0,    0,    0,  172,    0,
    0,   53,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,   63,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    3,    4,    5,    6,    7,    0,   57,    0,    8,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    9,   10,   11,   12,   13,   14,   15,   16,   17,
   18,   19,    0,    0,    0,    0,   21,   22,   23,   24,
   25,    0,    0,    0,   56,   64,   27,   62,    0,  444,
   65,   60,    0,    0,   54,    0,   55,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,   44,   45,   58,    0,    0,    0,   47,
   48,   49,   50,   51,   52,    0,    0,    0,    0,  179,
    0,   53,    0,    0,  177,  174,    0,  175,  176,  178,
    0,    0,    0,    0,    0,    0,    0,   63,    0,    0,
    0,    0,  172,    0,  173,   56,   64,    0,   62,    0,
  458,   65,   60,    0,    0,   54,    0,   55,    3,    4,
    5,    6,    7,    0,    0,    0,    8,   57,    0,    0,
    0,    0,    0,    0,    0,    0,   58,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    9,   10,
   11,   12,   13,   14,   15,   16,   17,   18,   19,    0,
    0,    0,    0,   21,   22,   23,   24,   25,   63,    0,
    0,    0,    0,   27,    0,    0,    0,    0,    0,    0,
    0,   56,   64,    0,   62,    0,  543,   65,   60,    0,
    0,   54,    0,   55,    0,    0,    0,    0,   57,    0,
   44,   45,    0,    0,    0,    0,   47,   48,   49,   50,
   51,   52,   58,    0,    0,    0,    0,    0,   53,    0,
  179,  171,    0,    0,    0,  177,  174,    0,  175,  176,
  178,    0,    0,    0,    0,  167,    0,    0,  167,    0,
    0,    0,    0,  172,   63,  173,    0,    0,    0,    0,
    0,    0,  167,  167,    0,    0,    0,  167,    3,    4,
    5,    6,    7,    0,    0,    0,    8,    0,    0,    0,
    0,    0,    0,    0,   57,    0,    0,  170,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  167,    9,   10,
   11,   12,   13,   14,   15,   16,   17,   18,   19,    0,
    0,    0,    0,   21,   22,   23,   24,   25,   56,   64,
    0,   62,    0,   27,   65,   60,    0,    0,   54,  167,
   55,  160,  161,  162,  163,  164,  165,  166,  167,    3,
    4,    5,    6,    7,    0,    0,    0,    8,    0,   58,
   44,   45,    0,    0,    0,    0,   47,   48,   49,   50,
   51,   52,    0,    0,    0,    0,    0,    0,   53,    9,
   10,   11,   12,   13,   14,   15,   16,   17,   18,   19,
    0,   63,    0,    0,   21,   22,   23,   24,   25,    0,
    0,    0,    0,    0,   27,   56,   64,    0,   62,    0,
    0,   65,   60,    0,    0,   54,    0,   55,    0,    0,
    0,   57,    0,    0,    0,    3,    4,    5,    6,    7,
    0,   44,   45,    8,    0,    0,   58,   47,   48,   49,
   50,   51,   52,    0,    0,    0,    0,    0,    0,   53,
    0,    0,    0,    0,    0,    9,   10,   11,   12,   13,
   14,   15,   16,   17,   18,   19,    0,    0,   63,    0,
   21,   22,   23,   24,   25,    0,  167,  167,  167,    0,
   27,    0,  160,  161,  162,  163,  164,  165,  166,  167,
    0,  167,  167,    0,    0,    0,    0,    0,   57,    0,
    0,    0,    0,    0,    0,    0,    0,   44,   45,    0,
    0,    0,    0,   47,   48,   49,   50,   51,   52,    0,
    0,    0,    0,  262,  262,   53,  262,  262,  262,  262,
  262,  262,  262,  262,    0,    0,    0,  167,    0,    0,
    0,    0,    0,    0,  262,  262,  262,  262,  262,  262,
    0,    0,    3,    4,    5,    6,    7,    0,  167,    0,
    8,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  262,
  262,    0,    9,   10,   11,   12,   13,   14,   15,   16,
   17,   18,   19,    0,    0,    0,    0,   21,   22,   23,
   24,   25,  175,    0,    0,  175,    0,   27,    0,    0,
  262,  262,    0,    0,    0,    0,    0,    0,    0,  175,
  175,    0,    0,    0,  175,    0,    0,    0,    0,    3,
    4,    5,    6,    7,   44,   45,    0,    8,    0,    0,
   47,   48,   49,   50,   51,   52,    0,    0,    0,    0,
    0,    0,   53,    0,  175,  175,    0,    0,    0,    9,
   10,   11,   12,   13,   14,   15,   16,   17,   18,   19,
    0,    0,    0,    0,   21,   22,   23,  377,   25,    0,
    0,    0,    0,    0,   27,  175,  175,    0,    0,    0,
  179,  171,    0,    0,    0,  177,  174,    0,  175,  176,
  178,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,   44,   45,  172,    0,  173,  168,   47,   48,   49,
   50,   51,   52,    0,    0,    0,    0,    0,    0,   53,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  170,  262,  262,
  262,    0,  262,  262,  262,  262,  262,  262,  262,  262,
  262,  262,  262,  262,  262,  262,  262,  262,  262,  262,
  262,  262,  262,  262,  262,  263,  263,  169,  263,  263,
  263,  263,  263,  263,  263,  263,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  263,  263,  263,  263,
  263,  263,    0,    0,    0,    0,    0,    0,    0,  262,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,  175,  175,  175,    0,    0,    0,  262,
  262,  263,  263,    0,    0,    0,    0,    0,  175,  175,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  263,  263,  273,  273,    0,  273,  273,  273,
  273,  273,  273,  273,  273,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  175,  273,  273,  273,  273,  273,
  273,  260,  260,    0,  260,  260,  260,  260,  260,  260,
  260,  260,    0,    0,    0,  175,    0,    0,    0,    0,
    0,    0,  260,  260,  260,  260,  260,  260,    0,    0,
  273,  273,    0,    0,    0,    0,    0,    0,    0,    0,
  158,  159,  160,  161,  162,  163,  164,  165,  166,  167,
    0,    0,    0,    0,    0,    0,    0,  260,  260,    0,
    0,  273,  273,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  260,  260,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  263,  263,  263,    0,  263,  263,  263,  263,  263,  263,
  263,  263,  263,  263,  263,  263,  263,  263,  263,  263,
  263,  263,  263,  263,  263,  263,  263,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,  263,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,  263,  263,    0,    0,    0,    0,    0,    0,  273,
  273,  273,    0,  273,  273,  273,  273,  273,  273,  273,
  273,  273,  273,  273,  273,  273,  273,  273,  273,  273,
  273,  273,  273,  273,  273,  273,  260,  260,  260,    0,
  260,  260,  260,  260,  260,  260,  260,  260,  260,  260,
  260,  260,  260,  260,  260,  260,  260,  260,  260,  260,
  260,  260,  260,    0,    0,    0,    0,    0,    0,    0,
  273,    0,    0,    0,    0,    0,    0,  261,  261,    0,
  261,  261,  261,  261,  261,  261,  261,  261,    0,    0,
  273,  273,    0,    0,    0,    0,    0,  260,  261,  261,
  261,  261,  261,  261,  257,  257,    0,    0,  257,  257,
  257,  257,  257,  257,  257,    0,    0,    0,  260,    0,
    0,    0,    0,    0,    0,  257,  257,  257,    0,  257,
  257,  224,  224,  261,  261,  224,  224,  224,  224,  224,
  224,  224,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  224,  224,  224,    0,  224,  224,    0,    0,
  257,  257,    0,    0,  261,  261,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  224,  224,    0,
    0,  257,  257,    0,    0,    0,    0,    0,    0,  241,
  241,    0,    0,  241,  241,  241,  241,  241,  241,  241,
    0,    0,    0,    0,    0,    0,    0,    0,  224,  224,
  241,  241,  241,    0,  241,  241,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  241,  241,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  241,  241,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  261,  261,  261,    0,  261,  261,  261,  261,
  261,  261,  261,  261,  261,  261,  261,  261,  261,  261,
  261,  261,  261,  261,  261,  261,  261,  261,  261,  257,
  257,  257,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  257,  257,  257,  257,  257,  257,
  257,  257,  257,  257,  259,  259,  224,  224,  224,    0,
    0,    0,    0,  261,    0,    0,    0,    0,    0,    0,
    0,  224,  224,  224,  224,  224,  224,  224,  224,  224,
  224,    0,    0,    0,  261,    0,    0,    0,    0,    0,
  257,    0,    0,  227,  227,    0,    0,  227,  227,  227,
  227,  227,  227,  227,    0,    0,    0,    0,    0,    0,
    0,  257,    0,    0,  227,  227,  227,  224,  227,  227,
    0,    0,    0,    0,  241,  241,  241,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  224,  241,
  241,  241,  241,  241,  241,  241,  241,  241,  241,  227,
  227,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,  258,  258,    0,    0,  258,  258,  258,  258,  258,
  258,  258,    0,    0,    0,    0,    0,    0,    0,    0,
  227,  227,  258,  258,  258,  241,  258,  258,  179,  171,
    0,    0,    0,  177,  174,    0,  175,  176,  178,    0,
    0,    0,    0,    0,    0,    0,  241,    0,    0,    0,
    0,  172,    0,  173,  168,    0,  184,  258,  258,  184,
    0,  184,  184,  184,  184,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  184,  184,  184,    0,
  184,  184,    0,    0,    0,  170,    0,    0,  258,  258,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,  184,  184,  185,    0,  169,  185,    0,  185,  185,
  185,  185,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,  185,  185,  185,    0,  185,  185,    0,
    0,    0,  184,  184,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  227,  227,
  227,    0,    0,    0,    0,    0,    0,    0,  185,  185,
    0,    0,    0,  227,  227,  227,  227,  227,  227,  227,
  227,  227,  227,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  185,
  185,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  227,
    0,    0,    0,    0,    0,    0,  258,  258,  258,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  227,  258,  258,  258,  258,  258,  258,  258,  258,  258,
  258,    0,    0,  155,  156,  157,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  158,  159,
  160,  161,  162,  163,  164,  165,  166,  167,    0,    0,
  184,  184,  184,    0,    0,    0,    0,  258,    0,    0,
    0,    0,    0,    0,    0,  184,  184,  184,  184,  184,
  184,  184,  184,  184,  184,    0,    0,    0,  258,  177,
    0,    0,  177,    0,  177,  177,  177,  177,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  177,
  177,  177,    0,  177,  177,  501,    0,  185,  185,  185,
    0,  184,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  185,  185,  185,  185,  185,  185,  185,  185,
  185,  185,  184,    0,  177,  177,  178,    0,    0,  178,
    0,  178,  178,  178,  178,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  178,  178,  178,    0,
  178,  178,    0,    0,    0,  177,  177,    0,  185,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  185,
  176,  178,  178,  176,    0,  176,  176,  176,  176,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  176,  176,  176,    0,  176,  176,    0,    0,    0,    0,
    0,    0,  178,  178,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  182,  176,  176,  182,    0,    0,
  182,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  182,  182,  182,    0,  182,  182,
    0,    0,    0,    0,    0,    0,  176,  176,    0,    0,
    0,  193,    0,    0,  193,    0,    0,  193,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  182,
  182,  193,  193,  177,  177,  177,  193,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  177,  177,
  177,  177,  177,  177,  177,  177,  177,  177,    0,    0,
  182,  182,  183,    0,    0,  183,  193,  193,  183,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  183,  183,  183,    0,  183,  183,    0,    0,
  178,  178,  178,    0,  177,    0,    0,  193,  193,    0,
    0,    0,    0,    0,    0,  178,  178,  178,  178,  178,
  178,  178,  178,  178,  178,  177,    0,  183,  183,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  176,  176,  176,    0,  183,  183,
    0,  178,    0,    0,    0,    0,    0,    0,    0,  176,
  176,  176,  176,  176,  176,  176,  176,  176,  176,    0,
    0,    0,  178,    0,    0,    0,  195,    0,    0,  195,
    0,    0,  195,  192,    0,    0,  192,    0,    0,  192,
    0,    0,    0,    0,    0,    0,  195,  195,  182,  182,
  182,  195,    0,  192,  192,  176,    0,    0,  192,    0,
    0,    0,    0,  182,  182,  182,  182,  182,  182,  182,
  182,  182,  182,    0,    0,    0,  176,    0,    0,    0,
    0,  195,  195,    0,    0,  193,  193,  193,  192,  192,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  193,  193,  193,  193,  193,  193,    0,    0,    0,  182,
    0,    0,  195,  195,    0,    0,    0,    0,    0,  192,
  192,    0,  194,    0,    0,  194,    0,    0,  194,    0,
  182,    0,    0,    0,    0,    0,  183,  183,  183,    0,
    0,    0,  194,  194,    0,    0,  193,  194,    0,    0,
    0,  183,  183,  183,  183,  183,  183,  183,  183,  183,
  183,    0,  173,    0,    0,  173,    0,  193,    0,  191,
    0,    0,  191,    0,    0,  191,    0,  194,  194,  173,
  173,    0,    0,    0,  173,    0,    0,    0,    0,  191,
  191,    0,  188,    0,  191,  188,    0,  183,  188,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  194,  194,
    0,    0,  188,  188,  173,    0,    0,  188,  183,    0,
    0,    0,    0,    0,  191,  191,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  173,  173,  188,  188,    0,
  195,  195,  195,    0,    0,  191,  191,  192,  192,  192,
    0,  431,  432,    0,    0,  195,  195,  195,  195,  195,
  195,    0,  192,  192,  192,  192,  192,  192,  188,  188,
    0,  189,    0,    0,  189,    0,    0,  189,  174,    0,
    0,  174,    0,    0,  174,    0,    0,    0,    0,    0,
    0,  189,  189,    0,    0,    0,  189,    0,  174,  174,
    0,  195,    0,  174,    0,    0,    0,    0,  192,    0,
    0,    0,    0,    0,    0,  470,    0,    0,    0,    0,
    0,  479,  195,    0,    0,    0,  189,  189,  485,  192,
    0,  488,    0,  174,  174,    0,  194,  194,  194,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,  194,  194,  194,  194,  194,  194,  189,  189,    0,
    0,    0,    0,    0,  174,  174,    0,    0,    0,    0,
    0,    0,    0,  173,  173,  173,    0,    0,    0,    0,
    0,    0,    0,  191,  191,  191,  257,  257,  173,  173,
    0,  257,  257,    0,  257,  257,  257,  194,  191,  191,
    0,    0,    0,    0,    0,    0,  188,  188,  188,  257,
    0,  257,  257,    0,    0,    0,    0,  557,  194,    0,
    0,  188,  188,    0,    0,    0,  567,    0,    0,    0,
  569,    0,  570,    0,  173,    0,    0,    0,    0,    0,
    0,  179,  171,  257,  191,    0,  177,  174,    0,  175,
  176,  178,  257,  257,    0,  173,  104,  257,  257,  104,
  257,  257,  257,    0,  172,  191,  173,  188,    0,    0,
    0,    0,    0,  257,    0,  257,    0,  257,  257,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  188,    0,
    0,  610,    0,    0,  613,  189,  189,  189,  170,    0,
    0,    0,  174,  174,  174,    0,    0,    0,    0,  257,
  189,  189,    0,    0,    0,    0,    0,  174,  174,    0,
  629,  257,  257,    0,    0,    0,  257,  257,  169,  257,
  257,  257,    0,    0,    0,    0,    0,    0,    0,  257,
    0,    0,    0,    0,  257,    0,  257,  257,    0,    0,
    0,    0,    0,    0,    0,    0,  189,    0,    0,    0,
  179,  171,    0,  174,    0,  177,  174,    0,  175,  176,
  178,    0,    0,    0,    0,    0,    0,  189,  257,    0,
    0,  562,  563,  172,  174,  173,  168,    0,    0,    0,
    0,    0,    0,  256,  256,    0,    0,  100,  256,  256,
  100,  256,  256,  256,    0,    0,    0,    0,  257,    0,
    0,  257,  257,  257,    0,    0,  256,  170,  256,  256,
    0,    0,    0,    0,    0,    0,  257,  257,  257,  257,
  257,  257,  257,  257,  257,  257,  259,  259,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  169,  256,  256,
  256,    0,  103,  256,  256,  103,  256,  256,  256,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,  256,  258,  256,  256,    0,    0,  257,  257,  257,
  256,  158,  159,  160,  161,  162,  163,  164,  165,  166,
  167,    0,  257,  257,  257,  257,  257,  257,  257,  257,
  257,  257,  259,  259,    0,  256,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  256,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  257,  257,  257,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,  257,  257,  257,  257,  257,  257,  257,  257,  257,
  257,  259,  259,  179,  171,    0,    0,    0,  177,  174,
    0,  175,  176,  178,    0,  155,  156,  157,    0,    0,
    0,    0,    0,    0,    0,  180,  172,    0,  173,  168,
  158,  159,  160,  161,  162,  163,  164,  165,  166,  167,
    0,    0,    0,    0,    0,    0,    0,    0,  256,  256,
  256,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  170,    0,    0,  256,  256,  256,  256,  256,  256,  256,
  256,  256,  256,  179,  171,    0,    0,    0,  177,  174,
    0,  175,  176,  178,    0,    0,    0,    0,    0,    0,
  169,    0,    0,    0,    0,  221,  172,    0,  173,  168,
    0,    0,    0,  256,  256,  256,  179,  171,    0,    0,
    0,  177,  174,    0,  175,  176,  178,    0,  256,  256,
  256,  256,  256,  256,  256,  256,  256,  256,  222,  172,
  170,  173,  168,  179,  171,    0,    0,  267,  177,  174,
    0,  175,  176,  178,  179,  171,    0,    0,  322,  177,
  174,    0,  175,  176,  178,    0,  172,    0,  173,  168,
  169,    0,    0,  170,    0,    0,    0,  172,    0,  173,
  168,    0,    0,    0,    0,    0,    0,  179,  171,    0,
    0,  328,  177,  174,    0,  175,  176,  178,    0,    0,
  170,    0,    0,  169,    0,    0,    0,    0,    0,    0,
  172,  170,  173,  168,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  169,    0,    0,    0,    0,    0,    0,    0,  155,  156,
  157,  169,    0,    0,  170,    0,    0,    0,    0,    0,
    0,    0,    0,  158,  159,  160,  161,  162,  163,  164,
  165,  166,  167,  179,  171,    0,    0,  329,  177,  174,
    0,  175,  176,  178,  169,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  172,    0,  173,  168,
  179,  171,    0,    0,  334,  177,  174,    0,  175,  176,
  178,    0,    0,    0,    0,    0,    0,    0,  155,  156,
  157,    0,    0,  172,    0,  173,  168,    0,    0,    0,
  170,    0,    0,  158,  159,  160,  161,  162,  163,  164,
  165,  166,  167,    0,    0,    0,    0,    0,    0,    0,
    0,  155,  156,  157,    0,    0,    0,  170,    0,    0,
  169,    0,    0,    0,    0,    0,  158,  159,  160,  161,
  162,  163,  164,  165,  166,  167,    0,    0,  155,  156,
  157,    0,    0,    0,    0,    0,    0,  169,    0,  155,
  156,  157,    0,  158,  159,  160,  161,  162,  163,  164,
  165,  166,  167,    0,  158,  159,  160,  161,  162,  163,
  164,  165,  166,  167,    0,    0,    0,    0,    0,    0,
    0,    0,  155,  156,  157,  179,  171,    0,    0,  341,
  177,  174,    0,  175,  176,  178,    0,  158,  159,  160,
  161,  162,  163,  164,  165,  166,  167,    0,  172,    0,
  173,  168,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  179,  171,    0,    0,
    0,  177,  174,    0,  175,  176,  178,    0,  179,  171,
    0,    0,  170,  177,  174,    0,  175,  176,  178,  172,
    0,  173,  168,    0,    0,    0,    0,    0,  155,  156,
  157,  172,    0,  173,  168,    0,    0,    0,    0,    0,
    0,    0,  169,  158,  159,  160,  161,  162,  163,  164,
  165,  166,  167,  170,    0,  155,  156,  157,    0,    0,
    0,    0,    0,    0,    0,  170,    0,    0,    0,    0,
  158,  159,  160,  161,  162,  163,  164,  165,  166,  167,
  179,  171,    0,  169,  383,  177,  174,    0,  175,  176,
  178,    0,  179,  171,    0,  169,  401,  177,  174,    0,
  175,  176,  178,  172,    0,  173,  168,    0,    0,    0,
    0,    0,    0,    0,    0,  172,    0,  173,  179,  171,
    0,    0,    0,  177,  174,    0,  175,  176,  178,    0,
  179,  171,    0,    0,    0,  177,  174,  170,  175,  176,
  178,  172,    0,  173,  168,    0,    0,    0,    0,  170,
    0,  450,    0,  172,    0,  173,  168,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  169,  429,    0,
    0,    0,    0,    0,    0,  170,    0,    0,    0,  169,
  155,  156,  157,    0,    0,    0,    0,  170,    0,    0,
    0,    0,    0,    0,    0,  158,  159,  160,  161,  162,
  163,  164,  165,  166,  167,  169,  448,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  169,    0,    0,
    0,  155,  156,  157,    0,    0,    0,    0,    0,    0,
    0,    0,    0,  155,  156,  157,  158,  159,  160,  161,
  162,  163,  164,  165,  166,  167,    0,    0,  158,  159,
  160,  161,  162,  163,  164,  165,  166,  167,    0,  179,
  171,    0,    0,    0,  177,  174,    0,  175,  176,  178,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  172,    0,  173,  168,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  155,  156,  157,    0,    0,
    0,    0,    0,    0,    0,    0,  170,    0,    0,    0,
  158,  159,  160,  161,  162,  163,  164,  165,  166,  167,
    0,    0,    0,  159,  160,  161,  162,  163,  164,  165,
  166,  167,    0,  155,  156,  157,  169,  454,    0,    0,
    0,    0,    0,    0,    0,  155,  156,  157,  158,  159,
  160,  161,  162,  163,  164,  165,  166,  167,    0,    0,
  158,  159,  160,  161,  162,  163,  164,  165,  166,  167,
  179,  171,    0,    0,  464,  177,  174,    0,  175,  176,
  178,  179,  171,    0,    0,    0,  177,  174,    0,  175,
  176,  178,    0,  172,    0,  173,  168,    0,    0,    0,
    0,    0,    0,    0,  172,    0,  173,  168,    0,    0,
    0,    0,    0,    0,  179,  171,    0,    0,    0,  177,
  174,    0,  175,  176,  178,  179,  171,  170,    0,  601,
  177,  174,    0,  175,  176,  178,    0,  172,  170,  173,
  168,    0,    0,    0,    0,    0,    0,    0,  172,    0,
  173,  168,    0,    0,  179,  171,    0,  169,  615,  177,
  174,    0,  175,  176,  178,    0,    0,    0,  169,  506,
  545,  170,    0,    0,  155,  156,  157,  172,    0,  173,
  168,    0,  170,    0,    0,    0,    0,    0,    0,  158,
  159,  160,  161,  162,  163,  164,  165,  166,  167,  242,
  242,  169,    0,    0,  242,  242,    0,  242,  242,  242,
    0,  170,  169,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  242,    0,  242,  242,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,  169,    0,    0,  179,  171,    0,    0,    0,  177,
  174,    0,  175,  176,  178,    0,  242,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  172,    0,  173,
  168,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  242,  242,    0,    0,
    0,    0,    0,    0,    0,  155,  156,  157,    0,    0,
    0,  170,    0,    0,    0,    0,  155,  156,  157,    0,
  158,  159,  160,  161,  162,  163,  164,  165,  166,  167,
    0,  158,  159,  160,  161,  162,  163,  164,  165,  166,
  167,  169,    0,    0,    0,    0,    0,    0,    0,  155,
  156,  157,    0,    0,    0,    0,    0,    0,    0,    0,
  155,  156,  157,    0,  158,  159,  160,  161,  162,  163,
  164,  165,  166,  167,    0,  158,  159,  160,  161,  162,
  163,  164,  165,  166,  167,    0,    0,    0,    0,  155,
  156,  157,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  158,  159,  160,  161,  162,  163,
  164,  165,  166,  167,    0,    0,    0,  256,  256,    0,
    0,    0,  256,  256,    0,  256,  256,  256,    0,    0,
    0,    0,    0,    0,  242,  242,  242,    0,    0,    0,
  256,    0,  256,  256,    0,    0,    0,    0,    0,  242,
  242,  242,  242,  242,  242,  242,  242,  242,  242,  179,
  171,    0,    0,    0,  177,  174,    0,  175,  176,  178,
    0,    0,    0,    0,  256,    0,    0,    0,    0,  155,
  156,  157,  172,    0,  173,  168,    0,    0,    0,    0,
    0,    0,    0,    0,  158,  159,  160,  161,  162,  163,
  164,  165,  166,  167,  256,  179,  171,    0,    0,    0,
  177,  174,    0,  175,  176,  178,  170,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  172,    0,
  173,  168,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  169,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  170,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  169,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  256,  256,  256,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  256,  256,  256,
  256,  256,  256,  256,  256,  256,  256,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  156,  157,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  158,
  159,  160,  161,  162,  163,  164,  165,  166,  167,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  157,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  158,  159,  160,  161,  162,
  163,  164,  165,  166,  167,
  );
 $GLOBALS['_PHP_PARSER']['yyCheck'] = array(             2,
   40,   36,   40,  123,    3,    4,   18,    6,    7,    8,
   36,  107,   11,   12,   13,   14,   15,   16,   17,   38,
   36,  233,  125,  125,   38,   36,   29,   34,   36,   28,
    9,   10,   39,   39,  125,   58,   35,   36,   36,   18,
   39,   36,  125,  208,  196,   41,  125,  389,   44,   36,
  335,  287,  288,   36,   36,   54,   55,   56,   57,   91,
   39,   60,   58,   59,   91,   40,   44,   41,  421,  428,
   44,  306,   41,   91,   41,   44,   41,   44,   40,   41,
   40,   59,   44,   61,   58,   59,   93,   86,   40,   96,
   59,  123,   59,   37,   59,  107,  123,   93,   42,   43,
  123,   45,   46,   47,   40,  104,   44,  106,  114,   40,
  452,   44,  123,  112,  113,  114,  123,  116,  125,   93,
  132,   59,  475,   61,  477,   44,   59,  304,  107,  125,
   44,   41,   44,   44,   44,  114,  123,  299,  300,   44,
   59,  353,  354,  142,   40,   59,  311,   59,   59,  148,
   40,  125,  151,  132,   59,  299,  300,  156,  137,  138,
  139,  160,  161,  162,  163,  164,  165,  166,  167,   38,
  169,  170,  171,  172,  173,  174,  175,  176,  177,  178,
  179,  466,  181,  182,  183,  184,  185,  186,  187,  188,
  189,  190,  191,  192,   41,   40,  202,   44,  197,  198,
   34,   44,  208,  202,   44,  417,  123,   44,   40,  208,
  209,  423,  308,   40,   41,   40,   59,   44,  430,   59,
   40,  433,   59,  202,  326,  327,   40,  330,  331,  208,
  229,  343,   41,   41,  337,   44,   44,  315,   41,  330,
  331,   44,  407,  326,  327,  397,  337,  326,  327,  304,
   58,   59,  611,   43,   40,   45,   40,   91,  257,   93,
   59,   41,  621,  266,   44,  244,  245,   58,   59,  245,
  296,  306,   59,  272,  312,  274,  275,  276,  304,  258,
  306,   41,   40,   41,   44,   93,  285,  306,  262,  123,
  306,  125,  306,  304,  390,  306,  308,  304,  306,  306,
  307,  342,  309,  310,  311,  311,  304,  519,  306,   61,
  345,  306,  311,  332,  313,  312,  528,  125,  332,  306,
  532,  361,  534,  306,  306,  343,  329,  323,    0,  308,
  309,  334,  311,  309,  333,   37,  335,  325,  326,  327,
   42,  285,  286,   41,  323,   47,   44,  323,  344,  323,
   37,  358,  359,  360,  125,   42,   43,   40,   45,   46,
   47,   33,   34,   41,   36,   40,   44,   39,   40,   41,
  344,   43,  371,   45,  373,   40,   44,   41,  390,  358,
   44,  593,   41,   41,  596,   44,   44,   59,   41,    9,
   10,   44,   64,   59,   59,  323,   61,  323,  404,  398,
  399,  407,  325,  326,  327,  404,  304,  304,  407,   41,
  622,  390,  325,  326,  327,  414,  419,  537,  538,   63,
   64,   65,  306,   41,   96,  404,  304,  123,  407,   41,
   44,   93,   41,   44,  343,   41,  415,  416,   61,  415,
  416,  306,   61,  306,   40,   44,   40,   40,  447,   59,
   40,  123,  304,  125,  126,   91,   61,  436,  125,   40,
  439,  440,   41,  442,   59,  444,  442,  466,  444,  304,
  304,   59,  306,  307,   59,  309,  310,  311,  123,  458,
   33,   34,  458,   36,   61,   93,   39,   40,   59,   41,
   43,  344,   45,  316,   61,   41,   61,   41,  344,  498,
  306,  306,  501,   41,  503,   44,   59,  510,  306,  343,
   40,   64,  302,  303,  304,  323,   41,   59,   41,   44,
   41,   41,  312,   59,  523,  359,  360,  322,   59,   40,
   58,  123,  301,   58,   59,   59,  344,  516,  125,  304,
  516,   59,  344,   96,   41,  304,   61,   44,  318,  306,
  553,  550,   59,  125,   40,   61,  346,  347,  348,  349,
  350,   58,   59,   58,  543,   59,  320,  543,   93,   37,
  123,   40,  125,  126,   42,   43,   59,   45,   46,   47,
  579,   41,   41,   59,  125,  257,  258,  259,  260,  261,
  123,  304,   60,  265,   62,   59,   93,  123,   41,   41,
  125,  266,  267,  268,  269,  270,  271,  272,  273,  274,
  275,  276,   93,  616,   40,  287,  288,  289,  290,  291,
  292,  293,  294,  295,  296,  297,  298,   41,  125,  301,
  302,  303,  304,  305,  306,   93,  308,   41,   41,   39,
  312,  313,  314,  315,  316,  317,  318,  319,  320,  321,
  322,   41,  324,  325,  326,  327,  328,  329,  330,  331,
   41,  333,  334,  335,  336,   41,  338,  339,  340,  341,
   41,  301,  469,  345,  346,  347,  348,  349,  350,  587,
  266,  358,  561,  490,  231,  357,  439,  309,   82,  398,
  397,   91,  440,   93,  487,   -1,   -1,   -1,   -1,   40,
   -1,   -1,   -1,   -1,  257,  258,  259,  260,  261,   -1,
   -1,   -1,  265,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   61,   -1,   -1,  123,   -1,  125,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,  287,  288,  289,  290,  291,  292,
  293,  294,  295,  296,  297,  298,   -1,   -1,   -1,  302,
  303,  304,  305,  306,   -1,  308,   -1,   -1,   -1,  312,
  313,  314,  315,   -1,  317,   -1,  319,   -1,  321,   -1,
   -1,  324,  325,  326,  327,  328,  329,  330,  331,   -1,
  333,  334,  335,  336,   -1,  338,  339,  340,  341,   -1,
   -1,   -1,  345,  346,  347,  348,  349,  350,  323,   33,
   34,   -1,   36,   -1,  357,   39,   40,   -1,   -1,   43,
   -1,   45,   -1,   -1,   -1,  283,  284,  285,  286,  344,
   -1,   -1,   -1,   -1,   -1,   59,  323,   -1,   41,   -1,
   64,   44,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   58,   59,  344,   -1,   -1,
   63,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   96,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   93,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  123,
   -1,  125,  126,   33,   34,   -1,   36,   -1,   -1,   39,
   40,   -1,   -1,   43,  304,   45,  306,  307,   -1,  309,
  310,  311,  125,   -1,   -1,   -1,   -1,   -1,   -1,   59,
   41,   -1,   -1,   44,   64,  266,  267,  268,  269,  270,
  271,  272,  273,  274,  275,  276,   -1,   58,   59,   -1,
   -1,   -1,   -1,  343,   -1,   -1,   -1,   -1,   41,   -1,
   -1,   44,   -1,   -1,   -1,   -1,   96,   -1,   -1,  359,
  360,   -1,   -1,   -1,   41,   58,   59,   44,   -1,   -1,
   -1,   -1,   93,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   58,   59,  123,   -1,   -1,  126,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   93,   -1,   -1,   -1,  125,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   91,   -1,   93,   93,   -1,   -1,   -1,
   -1,   -1,   -1,  257,  258,  259,  260,  261,   -1,   -1,
   -1,  265,  125,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  123,   -1,  125,  125,  262,
  263,  264,   -1,  287,  288,  289,  290,  291,  292,  293,
  294,  295,  296,  297,  298,   -1,   -1,   -1,  302,  303,
  304,  305,  306,   -1,  308,   -1,   -1,   -1,  312,  313,
  314,  315,   -1,  317,   -1,  319,   -1,  321,   -1,   -1,
  324,  325,  326,  327,  328,  329,  330,  331,   -1,  333,
  334,  335,  336,   -1,  338,  339,  340,  341,   -1,   -1,
  323,  345,  346,  347,  348,  349,  350,  257,  258,  259,
  260,  261,   -1,  357,   -1,  265,   -1,   -1,   -1,   -1,
   -1,  344,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,  262,  263,  264,   -1,   -1,   -1,  287,  288,  289,
  290,  291,  292,  293,  294,  295,  296,  297,  298,  299,
  300,  301,  302,  303,  304,  305,  306,   -1,  308,  262,
  263,  264,  312,  313,  314,  315,   -1,  317,   -1,  319,
   -1,  321,   -1,   -1,  324,  262,  263,  264,  328,  329,
  330,  331,   -1,  333,  334,  335,  336,   -1,  338,  339,
  340,  341,  323,   -1,   -1,  345,  346,  347,  348,  349,
  350,   -1,   33,   34,   -1,   36,   -1,  357,   39,   40,
   -1,   -1,   43,  344,   45,   -1,  304,   -1,  306,  307,
  323,  309,  310,  311,   -1,   -1,   -1,   -1,   59,   41,
   -1,   -1,   44,   64,   -1,   -1,  323,   -1,   -1,   -1,
   -1,  344,   -1,   -1,   -1,   -1,   58,   59,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  343,   -1,  344,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   96,   -1,   -1,   -1,   -1,
  358,  359,  360,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   93,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,  123,   -1,   -1,  126,   33,   34,   -1,   36,
   -1,   -1,   39,   40,   -1,   -1,   43,   -1,   45,   -1,
   -1,   -1,   -1,  125,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   59,   41,   -1,   -1,   44,   64,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   58,   59,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   41,   -1,   -1,   44,   -1,   -1,   -1,   -1,   96,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   58,   59,
   -1,   -1,   -1,   -1,   -1,   93,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,  123,   -1,   -1,  126,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   93,   -1,   -1,   -1,  125,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,  257,  258,  259,  260,
  261,   -1,   -1,   -1,  265,  125,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
  262,  263,  264,   -1,   -1,   -1,  287,  288,  289,  290,
  291,  292,  293,  294,  295,  296,  297,  298,  299,  300,
  301,  302,  303,  304,  305,  306,   -1,  308,   -1,   -1,
   -1,  312,  313,  314,  315,   -1,  317,   -1,  319,   -1,
  321,   -1,   -1,  324,   -1,   -1,   -1,  328,  329,  330,
  331,   -1,  333,  334,  335,  336,   -1,  338,  339,  340,
  341,  323,   -1,   -1,  345,  346,  347,  348,  349,  350,
  257,  258,  259,  260,  261,   -1,  357,   -1,  265,   -1,
   -1,   -1,  344,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,  262,  263,  264,   -1,   -1,   -1,
  287,  288,  289,  290,  291,  292,  293,  294,  295,  296,
  297,  298,   -1,   -1,  301,  302,  303,  304,  305,  306,
   -1,  308,  262,  263,  264,  312,  313,  314,  315,   -1,
  317,   -1,  319,   -1,  321,  405,   -1,  324,   -1,   -1,
  410,  328,  329,  330,  331,   -1,  333,  334,  335,  336,
   -1,  338,  339,  340,  341,  323,  426,   -1,  345,  346,
  347,  348,  349,  350,   -1,   33,   34,   -1,   36,   -1,
  357,   39,   40,   -1,   -1,   43,  344,   45,   -1,   -1,
   -1,   -1,   -1,  323,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   59,   41,   -1,   -1,   44,   64,   -1,   -1,   -1,
   -1,   -1,  472,   -1,  344,   -1,   -1,   -1,   -1,   58,
   59,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   96,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   93,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  123,   -1,   -1,  126,   33,
   34,   -1,   36,   -1,   -1,   39,   40,   -1,   -1,   43,
   -1,   45,   -1,   -1,   -1,   -1,  125,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   59,   41,   -1,   -1,   44,
   64,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  568,   -1,
   -1,   -1,   -1,   58,   59,   -1,   -1,   -1,   -1,   -1,
  580,   -1,   -1,  583,   41,   -1,   -1,   44,   -1,   -1,
   -1,  591,   96,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   58,   59,  603,   -1,   -1,   -1,  607,   93,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  123,
   -1,   -1,  126,   -1,   -1,   -1,   -1,  627,   -1,   -1,
  630,   -1,   -1,   -1,   -1,   -1,   93,   -1,  638,   -1,
  125,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  257,
  258,  259,  260,  261,   -1,   -1,   -1,  265,  125,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,  262,  263,  264,   -1,   -1,   -1,  287,
  288,  289,  290,  291,  292,  293,  294,  295,  296,  297,
  298,   -1,   -1,   -1,  302,  303,  304,  305,  306,   -1,
  308,   -1,   -1,   -1,  312,  313,  314,  315,   -1,  317,
   -1,  319,   -1,  321,   -1,   -1,  324,   -1,   -1,   -1,
  328,  329,  330,  331,   -1,  333,  334,  335,  336,   -1,
  338,  339,  340,  341,  323,   -1,   -1,  345,  346,  347,
  348,  349,  350,  257,  258,  259,  260,  261,   -1,  357,
   -1,  265,   -1,   -1,   -1,  344,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,  262,  263,  264,
   -1,   -1,   -1,  287,  288,  289,  290,  291,  292,  293,
  294,  295,  296,  297,  298,   -1,   -1,   -1,  302,  303,
  304,  305,  306,   -1,  308,  262,  263,  264,  312,  313,
  314,  315,   -1,  317,   -1,  319,   -1,  321,   -1,   -1,
  324,   -1,   -1,   -1,  328,  329,  330,  331,   -1,  333,
  334,  335,  336,   -1,  338,  339,  340,  341,  323,   -1,
   -1,  345,  346,  347,  348,  349,  350,   -1,   33,   34,
   -1,   36,   -1,  357,   39,   40,   -1,   -1,   43,  344,
   45,   -1,   -1,   -1,   -1,   -1,  323,   -1,   -1,   -1,
   -1,   -1,   -1,   58,   59,   41,   -1,   -1,   44,   64,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,  344,   -1,   -1,
   -1,   -1,   58,   59,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   96,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   93,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  123,   -1,
   -1,  126,   33,   34,   -1,   36,   -1,   -1,   39,   40,
   -1,   -1,   43,   -1,   45,   38,   -1,   -1,   41,  125,
   -1,   44,   -1,   -1,   -1,   -1,   -1,   58,   59,   -1,
   -1,   -1,   -1,   64,   -1,   58,   59,   -1,   -1,   -1,
   63,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   96,   -1,   -1,   -1,   -1,
   93,   94,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,  123,   -1,   -1,  126,   -1,   -1,   -1,   -1,
   -1,  124,  125,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   33,   34,   -1,   36,   -1,   -1,   39,   40,
   -1,   -1,   43,   -1,   45,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,  257,  258,  259,  260,  261,   58,   59,   -1,
  265,   -1,   -1,   64,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,  262,  263,  264,   -1,
   -1,   -1,  287,  288,  289,  290,  291,  292,  293,  294,
  295,  296,  297,  298,   -1,   96,   -1,  302,  303,  304,
  305,  306,   -1,  308,   -1,   -1,   -1,  312,  313,  314,
  315,   -1,  317,   -1,  319,   -1,  321,   -1,   -1,  324,
   -1,   -1,  123,  328,  329,  126,   -1,   -1,  333,  334,
  335,  336,   -1,  338,  339,  340,   -1,  323,   -1,   -1,
  345,  346,  347,  348,  349,  350,  257,  258,  259,  260,
  261,   -1,  357,   -1,  265,   -1,   -1,   -1,  344,  262,
  263,  264,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,  277,  278,  287,  288,  289,  290,
  291,  292,  293,  294,  295,  296,  297,  298,   -1,   -1,
   -1,  302,  303,  304,  305,  306,   -1,  308,   -1,   -1,
   -1,  312,  313,  314,  315,   -1,  317,   -1,  319,   -1,
  321,   -1,   -1,  324,   -1,   -1,   -1,  328,  329,   -1,
  323,   -1,  333,  334,  335,  336,   -1,  338,  339,  340,
   -1,   -1,   -1,   -1,  345,  346,  347,  348,  349,  350,
   -1,  344,   37,   38,   -1,   -1,  357,   42,   43,   -1,
   45,   46,   47,   -1,   -1,   -1,  257,  258,  259,  260,
  261,   -1,   -1,   -1,  265,   60,   -1,   62,   63,   -1,
   -1,   -1,   -1,   -1,   -1,   37,   38,   -1,   -1,   -1,
   42,   43,   -1,   45,   46,   47,  287,  288,  289,  290,
  291,  292,  293,  294,  295,  296,  297,  298,   60,   94,
   62,  302,  303,  304,  305,  306,   -1,  308,   -1,   -1,
   -1,  312,  313,  314,  315,   -1,  317,   -1,  319,   -1,
  321,   -1,   -1,  324,   -1,   -1,   -1,  328,  329,  124,
   -1,   -1,  333,  334,  335,  336,   -1,  338,  339,  340,
   -1,   -1,   -1,   -1,  345,  346,  347,  348,  349,  350,
   -1,   33,   34,   -1,   36,   -1,  357,   39,   40,   -1,
   -1,   43,   -1,   45,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   58,   59,   41,   -1,
   -1,   44,   64,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   58,   59,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   96,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   93,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,  123,   -1,   -1,  126,   33,   34,   -1,   36,   -1,
   -1,   39,   40,   -1,   -1,   43,   -1,   45,   -1,   -1,
   -1,   41,  125,   -1,   44,   -1,   -1,  262,  263,  264,
   58,   59,   -1,   -1,   -1,   -1,   64,   -1,   58,   59,
   -1,   -1,  277,  278,  279,  280,  281,  282,  283,  284,
  285,  286,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   96,   -1,
   -1,   -1,   -1,   93,   -1,   -1,   -1,  279,  280,  281,
  282,  283,  284,  285,  286,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  123,   -1,   -1,  126,   -1,
   -1,   -1,   -1,   -1,   -1,  125,   -1,   -1,   -1,  344,
   -1,   -1,   -1,   -1,   -1,   33,   34,   -1,   36,   -1,
   -1,   39,   40,   -1,   -1,   43,   -1,   45,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  257,  258,  259,  260,  261,
   -1,   59,   -1,  265,   -1,   -1,   64,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  262,
  263,  264,   -1,   -1,   -1,  287,  288,  289,  290,  291,
  292,  293,  294,  295,  296,  297,  298,   -1,   96,   -1,
  302,  303,  304,  305,  306,   -1,  308,   -1,   -1,   -1,
  312,  313,  314,  315,   -1,  317,   -1,  319,   -1,  321,
   -1,   -1,  324,   -1,   -1,  123,  328,  329,  126,   -1,
   -1,  333,  334,  335,  336,   -1,  338,  339,  340,   -1,
  323,   -1,   -1,  345,  346,  347,  348,  349,  350,  257,
  258,  259,  260,  261,   -1,  357,   -1,  265,   -1,   -1,
   -1,  344,  262,  263,  264,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  287,
  288,  289,  290,  291,  292,  293,  294,  295,  296,  297,
  298,   -1,   -1,   -1,  302,  303,  304,  305,  306,   -1,
  308,   -1,   -1,   -1,  312,  313,  314,  315,   -1,  317,
   -1,  319,   -1,  321,   -1,   -1,  324,   -1,   -1,   -1,
  328,  329,   -1,  323,   -1,  333,  334,  335,  336,   -1,
  338,  339,  340,   -1,   -1,   -1,   -1,  345,  346,  347,
  348,  349,  350,   -1,  344,   -1,   -1,   -1,   91,  357,
   93,   -1,   -1,   96,   -1,   -1,   -1,   -1,   -1,  257,
  258,  259,  260,  261,   -1,   -1,   -1,  265,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
  123,   -1,  125,   -1,   -1,   -1,   -1,   -1,   -1,  287,
  288,  289,  290,  291,  292,  293,  294,  295,  296,  297,
  298,   -1,   -1,   -1,  302,  303,  304,  305,  306,   -1,
  308,   -1,   -1,   -1,  312,  313,  314,  315,   -1,  317,
   -1,  319,   -1,  321,   -1,   -1,  324,   -1,   -1,   -1,
  328,  329,   -1,   -1,   -1,  333,  334,  335,  336,   -1,
  338,  339,  340,   -1,   -1,   -1,   -1,  345,  346,  347,
  348,  349,  350,   -1,   33,   34,   -1,   36,   -1,  357,
   39,   40,   -1,   -1,   43,   -1,   45,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   59,   -1,   -1,   -1,   -1,   64,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   37,   38,   -1,   -1,   41,
   42,   43,   44,   45,   46,   47,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   96,   60,   -1,
   62,   63,   -1,   -1,   -1,   33,   34,   -1,   36,   -1,
   -1,   39,   40,   -1,   -1,   43,   -1,   45,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,  126,   -1,   -1,
   -1,   59,   94,   -1,   -1,   -1,   64,   -1,   -1,   -1,
   -1,  304,   -1,  306,  307,   -1,  309,  310,  311,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,  124,   -1,   -1,   -1,   -1,   -1,   96,   -1,
   -1,   -1,   41,   -1,   -1,   44,   33,   34,   -1,   36,
  343,   -1,   39,   40,   -1,   -1,   43,   -1,   45,   58,
   59,   -1,   41,   -1,   -1,   44,  359,  360,  126,   -1,
   -1,   -1,   59,   41,   -1,   -1,   44,   64,   -1,   58,
   59,   -1,   -1,   -1,   63,   -1,   -1,   -1,   -1,   -1,
   58,   59,   -1,   -1,   93,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   96,
   -1,   -1,   -1,   -1,   93,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   93,  125,   -1,  257,  258,
  259,  260,  261,   -1,   -1,   -1,  265,   -1,   -1,  126,
   -1,   -1,   -1,   -1,   -1,   -1,  125,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,  125,  287,  288,
  289,  290,  291,  292,  293,  294,  295,  296,  297,   -1,
  262,  263,  264,  302,  303,  304,  305,  306,   -1,   -1,
   -1,   -1,   -1,  312,   -1,  277,  278,  279,  280,  281,
  282,  283,  284,  285,  286,  287,  288,   -1,   -1,  257,
  258,  259,  260,  261,   -1,   -1,   -1,  265,   -1,   -1,
  339,  340,   -1,   -1,   -1,   -1,  345,  346,  347,  348,
  349,  350,   -1,   -1,   -1,   -1,   -1,   -1,  357,  287,
  288,  289,  290,  291,  292,  293,  294,  295,  296,  297,
   -1,   -1,   -1,   -1,  302,  303,  304,  305,  306,   33,
   34,   -1,   36,   -1,  312,   39,   40,   41,   -1,   43,
   -1,   45,   -1,  262,  263,  264,   -1,   -1,   -1,   -1,
  257,  258,  259,  260,  261,   -1,   -1,   -1,  265,   -1,
   64,  339,  340,  262,  263,  264,   -1,  345,  346,  347,
  348,  349,  350,   -1,  262,  263,  264,   -1,  277,  357,
  287,  288,  289,  290,  291,  292,  293,  294,  295,  296,
  297,   -1,   96,   -1,   -1,  302,  303,  304,  305,  306,
   -1,   -1,   -1,   -1,  323,  312,   33,   34,   -1,   36,
   -1,   38,   39,   40,   -1,   -1,   43,   -1,   45,   -1,
   -1,   -1,  126,   -1,  323,  344,   -1,   -1,   -1,   -1,
   -1,   -1,  339,  340,   -1,  323,   -1,   64,  345,  346,
  347,  348,  349,  350,   -1,  344,   -1,   -1,   -1,   -1,
  357,   -1,   -1,   -1,   -1,   -1,  344,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   96,
   -1,   -1,   -1,   -1,   -1,   -1,   41,   33,   34,   44,
   36,   -1,   38,   39,   40,   -1,   -1,   43,   -1,   45,
   -1,   -1,   -1,   58,   59,   41,   -1,   -1,   44,  126,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   64,   -1,
   -1,   -1,   58,   59,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   37,   38,   -1,   93,   -1,
   42,   43,   -1,   45,   46,   47,   -1,   -1,   -1,   -1,
   96,   -1,   -1,   -1,   -1,   -1,   -1,   93,   60,   -1,
   62,   -1,   -1,  257,  258,  259,  260,  261,   -1,   -1,
  125,  265,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
  126,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  125,
   -1,   -1,   94,  287,  288,  289,  290,  291,  292,  293,
  294,  295,  296,  297,   -1,   -1,   -1,   -1,  302,  303,
  304,  305,  306,   -1,   -1,   -1,   -1,   -1,  312,   -1,
   -1,   -1,  124,   -1,   -1,   -1,   -1,   33,   34,   -1,
   36,   -1,   38,   39,   40,   -1,   -1,   43,   -1,   45,
  257,  258,  259,  260,  261,  339,  340,   -1,  265,   -1,
   -1,  345,  346,  347,  348,  349,  350,   -1,   64,   -1,
   -1,   -1,   -1,  357,   -1,   -1,   -1,   -1,   -1,   -1,
  287,  288,  289,  290,  291,  292,  293,  294,  295,  296,
  297,   -1,   -1,   -1,   -1,  302,  303,  304,  305,  306,
   96,   -1,   -1,   -1,   -1,  312,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,  262,  263,  264,
   -1,  257,  258,  259,  260,  261,   -1,   -1,   -1,  265,
  126,   -1,  339,  340,   -1,   -1,  262,  263,  345,  346,
  347,  348,  349,  350,   -1,   -1,   -1,   -1,   -1,   -1,
  357,  287,  288,  289,  290,  291,  292,  293,  294,  295,
  296,  297,   -1,   -1,   -1,   -1,  302,  303,  304,  305,
  306,   -1,   -1,   -1,   33,   34,  312,   36,  323,   38,
   39,   40,   -1,   -1,   43,   -1,   45,  279,  280,  281,
  282,  283,  284,  285,  286,   -1,   -1,  323,   -1,  344,
   -1,   -1,   -1,  339,  340,   64,   -1,   -1,   -1,  345,
  346,  347,  348,  349,  350,   -1,   -1,   -1,  344,   -1,
   -1,  357,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   96,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,  257,  258,  259,  260,  261,   -1,  126,   -1,  265,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,  287,  288,  289,  290,  291,  292,  293,  294,  295,
  296,  297,   -1,   -1,   -1,   -1,  302,  303,  304,  305,
  306,   -1,   -1,   -1,   33,   34,  312,   36,   -1,   38,
   39,   40,   -1,   -1,   43,   -1,   45,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,  339,  340,   64,   -1,   -1,   -1,  345,
  346,  347,  348,  349,  350,   -1,   -1,   -1,   -1,   37,
   -1,  357,   -1,   -1,   42,   43,   -1,   45,   46,   47,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   96,   -1,   -1,
   -1,   -1,   60,   -1,   62,   33,   34,   -1,   36,   -1,
   38,   39,   40,   -1,   -1,   43,   -1,   45,  257,  258,
  259,  260,  261,   -1,   -1,   -1,  265,  126,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   64,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  287,  288,
  289,  290,  291,  292,  293,  294,  295,  296,  297,   -1,
   -1,   -1,   -1,  302,  303,  304,  305,  306,   96,   -1,
   -1,   -1,   -1,  312,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   33,   34,   -1,   36,   -1,   38,   39,   40,   -1,
   -1,   43,   -1,   45,   -1,   -1,   -1,   -1,  126,   -1,
  339,  340,   -1,   -1,   -1,   -1,  345,  346,  347,  348,
  349,  350,   64,   -1,   -1,   -1,   -1,   -1,  357,   -1,
   37,   38,   -1,   -1,   -1,   42,   43,   -1,   45,   46,
   47,   -1,   -1,   -1,   -1,   41,   -1,   -1,   44,   -1,
   -1,   -1,   -1,   60,   96,   62,   -1,   -1,   -1,   -1,
   -1,   -1,   58,   59,   -1,   -1,   -1,   63,  257,  258,
  259,  260,  261,   -1,   -1,   -1,  265,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,  126,   -1,   -1,   94,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   93,  287,  288,
  289,  290,  291,  292,  293,  294,  295,  296,  297,   -1,
   -1,   -1,   -1,  302,  303,  304,  305,  306,   33,   34,
   -1,   36,   -1,  312,   39,   40,   -1,   -1,   43,  125,
   45,  279,  280,  281,  282,  283,  284,  285,  286,  257,
  258,  259,  260,  261,   -1,   -1,   -1,  265,   -1,   64,
  339,  340,   -1,   -1,   -1,   -1,  345,  346,  347,  348,
  349,  350,   -1,   -1,   -1,   -1,   -1,   -1,  357,  287,
  288,  289,  290,  291,  292,  293,  294,  295,  296,  297,
   -1,   96,   -1,   -1,  302,  303,  304,  305,  306,   -1,
   -1,   -1,   -1,   -1,  312,   33,   34,   -1,   36,   -1,
   -1,   39,   40,   -1,   -1,   43,   -1,   45,   -1,   -1,
   -1,  126,   -1,   -1,   -1,  257,  258,  259,  260,  261,
   -1,  339,  340,  265,   -1,   -1,   64,  345,  346,  347,
  348,  349,  350,   -1,   -1,   -1,   -1,   -1,   -1,  357,
   -1,   -1,   -1,   -1,   -1,  287,  288,  289,  290,  291,
  292,  293,  294,  295,  296,  297,   -1,   -1,   96,   -1,
  302,  303,  304,  305,  306,   -1,  262,  263,  264,   -1,
  312,   -1,  279,  280,  281,  282,  283,  284,  285,  286,
   -1,  277,  278,   -1,   -1,   -1,   -1,   -1,  126,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,  339,  340,   -1,
   -1,   -1,   -1,  345,  346,  347,  348,  349,  350,   -1,
   -1,   -1,   -1,   37,   38,  357,   40,   41,   42,   43,
   44,   45,   46,   47,   -1,   -1,   -1,  323,   -1,   -1,
   -1,   -1,   -1,   -1,   58,   59,   60,   61,   62,   63,
   -1,   -1,  257,  258,  259,  260,  261,   -1,  344,   -1,
  265,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   93,
   94,   -1,  287,  288,  289,  290,  291,  292,  293,  294,
  295,  296,  297,   -1,   -1,   -1,   -1,  302,  303,  304,
  305,  306,   41,   -1,   -1,   44,   -1,  312,   -1,   -1,
  124,  125,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   58,
   59,   -1,   -1,   -1,   63,   -1,   -1,   -1,   -1,  257,
  258,  259,  260,  261,  339,  340,   -1,  265,   -1,   -1,
  345,  346,  347,  348,  349,  350,   -1,   -1,   -1,   -1,
   -1,   -1,  357,   -1,   93,   94,   -1,   -1,   -1,  287,
  288,  289,  290,  291,  292,  293,  294,  295,  296,  297,
   -1,   -1,   -1,   -1,  302,  303,  304,  305,  306,   -1,
   -1,   -1,   -1,   -1,  312,  124,  125,   -1,   -1,   -1,
   37,   38,   -1,   -1,   -1,   42,   43,   -1,   45,   46,
   47,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,  339,  340,   60,   -1,   62,   63,  345,  346,  347,
  348,  349,  350,   -1,   -1,   -1,   -1,   -1,   -1,  357,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   94,  262,  263,
  264,   -1,  266,  267,  268,  269,  270,  271,  272,  273,
  274,  275,  276,  277,  278,  279,  280,  281,  282,  283,
  284,  285,  286,  287,  288,   37,   38,  124,   40,   41,
   42,   43,   44,   45,   46,   47,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   58,   59,   60,   61,
   62,   63,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  323,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,  262,  263,  264,   -1,   -1,   -1,  343,
  344,   93,   94,   -1,   -1,   -1,   -1,   -1,  277,  278,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,  124,  125,   37,   38,   -1,   40,   41,   42,
   43,   44,   45,   46,   47,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,  323,   58,   59,   60,   61,   62,
   63,   37,   38,   -1,   40,   41,   42,   43,   44,   45,
   46,   47,   -1,   -1,   -1,  344,   -1,   -1,   -1,   -1,
   -1,   -1,   58,   59,   60,   61,   62,   63,   -1,   -1,
   93,   94,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
  277,  278,  279,  280,  281,  282,  283,  284,  285,  286,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   93,   94,   -1,
   -1,  124,  125,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  124,  125,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
  262,  263,  264,   -1,  266,  267,  268,  269,  270,  271,
  272,  273,  274,  275,  276,  277,  278,  279,  280,  281,
  282,  283,  284,  285,  286,  287,  288,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,  323,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,  343,  344,   -1,   -1,   -1,   -1,   -1,   -1,  262,
  263,  264,   -1,  266,  267,  268,  269,  270,  271,  272,
  273,  274,  275,  276,  277,  278,  279,  280,  281,  282,
  283,  284,  285,  286,  287,  288,  262,  263,  264,   -1,
  266,  267,  268,  269,  270,  271,  272,  273,  274,  275,
  276,  277,  278,  279,  280,  281,  282,  283,  284,  285,
  286,  287,  288,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
  323,   -1,   -1,   -1,   -1,   -1,   -1,   37,   38,   -1,
   40,   41,   42,   43,   44,   45,   46,   47,   -1,   -1,
  343,  344,   -1,   -1,   -1,   -1,   -1,  323,   58,   59,
   60,   61,   62,   63,   37,   38,   -1,   -1,   41,   42,
   43,   44,   45,   46,   47,   -1,   -1,   -1,  344,   -1,
   -1,   -1,   -1,   -1,   -1,   58,   59,   60,   -1,   62,
   63,   37,   38,   93,   94,   41,   42,   43,   44,   45,
   46,   47,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   58,   59,   60,   -1,   62,   63,   -1,   -1,
   93,   94,   -1,   -1,  124,  125,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   93,   94,   -1,
   -1,  124,  125,   -1,   -1,   -1,   -1,   -1,   -1,   37,
   38,   -1,   -1,   41,   42,   43,   44,   45,   46,   47,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  124,  125,
   58,   59,   60,   -1,   62,   63,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   93,   94,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,  124,  125,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,  262,  263,  264,   -1,  266,  267,  268,  269,
  270,  271,  272,  273,  274,  275,  276,  277,  278,  279,
  280,  281,  282,  283,  284,  285,  286,  287,  288,  262,
  263,  264,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,  277,  278,  279,  280,  281,  282,
  283,  284,  285,  286,  287,  288,  262,  263,  264,   -1,
   -1,   -1,   -1,  323,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,  277,  278,  279,  280,  281,  282,  283,  284,  285,
  286,   -1,   -1,   -1,  344,   -1,   -1,   -1,   -1,   -1,
  323,   -1,   -1,   37,   38,   -1,   -1,   41,   42,   43,
   44,   45,   46,   47,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,  344,   -1,   -1,   58,   59,   60,  323,   62,   63,
   -1,   -1,   -1,   -1,  262,  263,  264,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  344,  277,
  278,  279,  280,  281,  282,  283,  284,  285,  286,   93,
   94,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   37,   38,   -1,   -1,   41,   42,   43,   44,   45,
   46,   47,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
  124,  125,   58,   59,   60,  323,   62,   63,   37,   38,
   -1,   -1,   -1,   42,   43,   -1,   45,   46,   47,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,  344,   -1,   -1,   -1,
   -1,   60,   -1,   62,   63,   -1,   38,   93,   94,   41,
   -1,   43,   44,   45,   46,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   58,   59,   60,   -1,
   62,   63,   -1,   -1,   -1,   94,   -1,   -1,  124,  125,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   93,   94,   38,   -1,  124,   41,   -1,   43,   44,
   45,   46,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   58,   59,   60,   -1,   62,   63,   -1,
   -1,   -1,  124,  125,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  262,  263,
  264,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   93,   94,
   -1,   -1,   -1,  277,  278,  279,  280,  281,  282,  283,
  284,  285,  286,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  124,
  125,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  323,
   -1,   -1,   -1,   -1,   -1,   -1,  262,  263,  264,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
  344,  277,  278,  279,  280,  281,  282,  283,  284,  285,
  286,   -1,   -1,  262,  263,  264,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  277,  278,
  279,  280,  281,  282,  283,  284,  285,  286,   -1,   -1,
  262,  263,  264,   -1,   -1,   -1,   -1,  323,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  277,  278,  279,  280,  281,
  282,  283,  284,  285,  286,   -1,   -1,   -1,  344,   38,
   -1,   -1,   41,   -1,   43,   44,   45,   46,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   58,
   59,   60,   -1,   62,   63,  344,   -1,  262,  263,  264,
   -1,  323,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,  277,  278,  279,  280,  281,  282,  283,  284,
  285,  286,  344,   -1,   93,   94,   38,   -1,   -1,   41,
   -1,   43,   44,   45,   46,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   58,   59,   60,   -1,
   62,   63,   -1,   -1,   -1,  124,  125,   -1,  323,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  344,
   38,   93,   94,   41,   -1,   43,   44,   45,   46,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   58,   59,   60,   -1,   62,   63,   -1,   -1,   -1,   -1,
   -1,   -1,  124,  125,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   38,   93,   94,   41,   -1,   -1,
   44,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   58,   59,   60,   -1,   62,   63,
   -1,   -1,   -1,   -1,   -1,   -1,  124,  125,   -1,   -1,
   -1,   38,   -1,   -1,   41,   -1,   -1,   44,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   93,
   94,   58,   59,  262,  263,  264,   63,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  277,  278,
  279,  280,  281,  282,  283,  284,  285,  286,   -1,   -1,
  124,  125,   38,   -1,   -1,   41,   93,   94,   44,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   58,   59,   60,   -1,   62,   63,   -1,   -1,
  262,  263,  264,   -1,  323,   -1,   -1,  124,  125,   -1,
   -1,   -1,   -1,   -1,   -1,  277,  278,  279,  280,  281,
  282,  283,  284,  285,  286,  344,   -1,   93,   94,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,  262,  263,  264,   -1,  124,  125,
   -1,  323,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  277,
  278,  279,  280,  281,  282,  283,  284,  285,  286,   -1,
   -1,   -1,  344,   -1,   -1,   -1,   38,   -1,   -1,   41,
   -1,   -1,   44,   38,   -1,   -1,   41,   -1,   -1,   44,
   -1,   -1,   -1,   -1,   -1,   -1,   58,   59,  262,  263,
  264,   63,   -1,   58,   59,  323,   -1,   -1,   63,   -1,
   -1,   -1,   -1,  277,  278,  279,  280,  281,  282,  283,
  284,  285,  286,   -1,   -1,   -1,  344,   -1,   -1,   -1,
   -1,   93,   94,   -1,   -1,  262,  263,  264,   93,   94,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
  277,  278,  279,  280,  281,  282,   -1,   -1,   -1,  323,
   -1,   -1,  124,  125,   -1,   -1,   -1,   -1,   -1,  124,
  125,   -1,   38,   -1,   -1,   41,   -1,   -1,   44,   -1,
  344,   -1,   -1,   -1,   -1,   -1,  262,  263,  264,   -1,
   -1,   -1,   58,   59,   -1,   -1,  323,   63,   -1,   -1,
   -1,  277,  278,  279,  280,  281,  282,  283,  284,  285,
  286,   -1,   41,   -1,   -1,   44,   -1,  344,   -1,   38,
   -1,   -1,   41,   -1,   -1,   44,   -1,   93,   94,   58,
   59,   -1,   -1,   -1,   63,   -1,   -1,   -1,   -1,   58,
   59,   -1,   38,   -1,   63,   41,   -1,  323,   44,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  124,  125,
   -1,   -1,   58,   59,   93,   -1,   -1,   63,  344,   -1,
   -1,   -1,   -1,   -1,   93,   94,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  124,  125,   93,   94,   -1,
  262,  263,  264,   -1,   -1,  124,  125,  262,  263,  264,
   -1,  353,  354,   -1,   -1,  277,  278,  279,  280,  281,
  282,   -1,  277,  278,  279,  280,  281,  282,  124,  125,
   -1,   38,   -1,   -1,   41,   -1,   -1,   44,   38,   -1,
   -1,   41,   -1,   -1,   44,   -1,   -1,   -1,   -1,   -1,
   -1,   58,   59,   -1,   -1,   -1,   63,   -1,   58,   59,
   -1,  323,   -1,   63,   -1,   -1,   -1,   -1,  323,   -1,
   -1,   -1,   -1,   -1,   -1,  417,   -1,   -1,   -1,   -1,
   -1,  423,  344,   -1,   -1,   -1,   93,   94,  430,  344,
   -1,  433,   -1,   93,   94,   -1,  262,  263,  264,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,  277,  278,  279,  280,  281,  282,  124,  125,   -1,
   -1,   -1,   -1,   -1,  124,  125,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,  262,  263,  264,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,  262,  263,  264,   37,   38,  277,  278,
   -1,   42,   43,   -1,   45,   46,   47,  323,  277,  278,
   -1,   -1,   -1,   -1,   -1,   -1,  262,  263,  264,   60,
   -1,   62,   63,   -1,   -1,   -1,   -1,  519,  344,   -1,
   -1,  277,  278,   -1,   -1,   -1,  528,   -1,   -1,   -1,
  532,   -1,  534,   -1,  323,   -1,   -1,   -1,   -1,   -1,
   -1,   37,   38,   94,  323,   -1,   42,   43,   -1,   45,
   46,   47,   37,   38,   -1,  344,   41,   42,   43,   44,
   45,   46,   47,   -1,   60,  344,   62,  323,   -1,   -1,
   -1,   -1,   -1,  124,   -1,   60,   -1,   62,   63,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  344,   -1,
   -1,  593,   -1,   -1,  596,  262,  263,  264,   94,   -1,
   -1,   -1,  262,  263,  264,   -1,   -1,   -1,   -1,   94,
  277,  278,   -1,   -1,   -1,   -1,   -1,  277,  278,   -1,
  622,   37,   38,   -1,   -1,   -1,   42,   43,  124,   45,
   46,   47,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  124,
   -1,   -1,   -1,   -1,   60,   -1,   62,   63,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,  323,   -1,   -1,   -1,
   37,   38,   -1,  323,   -1,   42,   43,   -1,   45,   46,
   47,   -1,   -1,   -1,   -1,   -1,   -1,  344,   94,   -1,
   -1,   58,   59,   60,  344,   62,   63,   -1,   -1,   -1,
   -1,   -1,   -1,   37,   38,   -1,   -1,   41,   42,   43,
   44,   45,   46,   47,   -1,   -1,   -1,   -1,  124,   -1,
   -1,  262,  263,  264,   -1,   -1,   60,   94,   62,   63,
   -1,   -1,   -1,   -1,   -1,   -1,  277,  278,  279,  280,
  281,  282,  283,  284,  285,  286,  287,  288,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,  124,   37,   38,
   94,   -1,   41,   42,   43,   44,   45,   46,   47,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   60,  323,   62,   63,   -1,   -1,  262,  263,  264,
  124,  277,  278,  279,  280,  281,  282,  283,  284,  285,
  286,   -1,  277,  278,  279,  280,  281,  282,  283,  284,
  285,  286,  287,  288,   -1,   94,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  124,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,  262,  263,  264,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,  277,  278,  279,  280,  281,  282,  283,  284,  285,
  286,  287,  288,   37,   38,   -1,   -1,   -1,   42,   43,
   -1,   45,   46,   47,   -1,  262,  263,  264,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   59,   60,   -1,   62,   63,
  277,  278,  279,  280,  281,  282,  283,  284,  285,  286,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  262,  263,
  264,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   94,   -1,   -1,  277,  278,  279,  280,  281,  282,  283,
  284,  285,  286,   37,   38,   -1,   -1,   -1,   42,   43,
   -1,   45,   46,   47,   -1,   -1,   -1,   -1,   -1,   -1,
  124,   -1,   -1,   -1,   -1,   59,   60,   -1,   62,   63,
   -1,   -1,   -1,  262,  263,  264,   37,   38,   -1,   -1,
   -1,   42,   43,   -1,   45,   46,   47,   -1,  277,  278,
  279,  280,  281,  282,  283,  284,  285,  286,   59,   60,
   94,   62,   63,   37,   38,   -1,   -1,   41,   42,   43,
   -1,   45,   46,   47,   37,   38,   -1,   -1,   41,   42,
   43,   -1,   45,   46,   47,   -1,   60,   -1,   62,   63,
  124,   -1,   -1,   94,   -1,   -1,   -1,   60,   -1,   62,
   63,   -1,   -1,   -1,   -1,   -1,   -1,   37,   38,   -1,
   -1,   41,   42,   43,   -1,   45,   46,   47,   -1,   -1,
   94,   -1,   -1,  124,   -1,   -1,   -1,   -1,   -1,   -1,
   60,   94,   62,   63,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
  124,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  262,  263,
  264,  124,   -1,   -1,   94,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,  277,  278,  279,  280,  281,  282,  283,
  284,  285,  286,   37,   38,   -1,   -1,   41,   42,   43,
   -1,   45,   46,   47,  124,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   60,   -1,   62,   63,
   37,   38,   -1,   -1,   41,   42,   43,   -1,   45,   46,
   47,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  262,  263,
  264,   -1,   -1,   60,   -1,   62,   63,   -1,   -1,   -1,
   94,   -1,   -1,  277,  278,  279,  280,  281,  282,  283,
  284,  285,  286,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,  262,  263,  264,   -1,   -1,   -1,   94,   -1,   -1,
  124,   -1,   -1,   -1,   -1,   -1,  277,  278,  279,  280,
  281,  282,  283,  284,  285,  286,   -1,   -1,  262,  263,
  264,   -1,   -1,   -1,   -1,   -1,   -1,  124,   -1,  262,
  263,  264,   -1,  277,  278,  279,  280,  281,  282,  283,
  284,  285,  286,   -1,  277,  278,  279,  280,  281,  282,
  283,  284,  285,  286,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,  262,  263,  264,   37,   38,   -1,   -1,   41,
   42,   43,   -1,   45,   46,   47,   -1,  277,  278,  279,
  280,  281,  282,  283,  284,  285,  286,   -1,   60,   -1,
   62,   63,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   37,   38,   -1,   -1,
   -1,   42,   43,   -1,   45,   46,   47,   -1,   37,   38,
   -1,   -1,   94,   42,   43,   -1,   45,   46,   47,   60,
   -1,   62,   63,   -1,   -1,   -1,   -1,   -1,  262,  263,
  264,   60,   -1,   62,   63,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,  124,  277,  278,  279,  280,  281,  282,  283,
  284,  285,  286,   94,   -1,  262,  263,  264,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   94,   -1,   -1,   -1,   -1,
  277,  278,  279,  280,  281,  282,  283,  284,  285,  286,
   37,   38,   -1,  124,  125,   42,   43,   -1,   45,   46,
   47,   -1,   37,   38,   -1,  124,  125,   42,   43,   -1,
   45,   46,   47,   60,   -1,   62,   63,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   60,   -1,   62,   37,   38,
   -1,   -1,   -1,   42,   43,   -1,   45,   46,   47,   -1,
   37,   38,   -1,   -1,   -1,   42,   43,   94,   45,   46,
   47,   60,   -1,   62,   63,   -1,   -1,   -1,   -1,   94,
   -1,   58,   -1,   60,   -1,   62,   63,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,  124,  125,   -1,
   -1,   -1,   -1,   -1,   -1,   94,   -1,   -1,   -1,  124,
  262,  263,  264,   -1,   -1,   -1,   -1,   94,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  277,  278,  279,  280,  281,
  282,  283,  284,  285,  286,  124,  125,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,  124,   -1,   -1,
   -1,  262,  263,  264,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,  262,  263,  264,  277,  278,  279,  280,
  281,  282,  283,  284,  285,  286,   -1,   -1,  277,  278,
  279,  280,  281,  282,  283,  284,  285,  286,   -1,   37,
   38,   -1,   -1,   -1,   42,   43,   -1,   45,   46,   47,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   60,   -1,   62,   63,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  262,  263,  264,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   94,   -1,   -1,   -1,
  277,  278,  279,  280,  281,  282,  283,  284,  285,  286,
   -1,   -1,   -1,  278,  279,  280,  281,  282,  283,  284,
  285,  286,   -1,  262,  263,  264,  124,  125,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  262,  263,  264,  277,  278,
  279,  280,  281,  282,  283,  284,  285,  286,   -1,   -1,
  277,  278,  279,  280,  281,  282,  283,  284,  285,  286,
   37,   38,   -1,   -1,   41,   42,   43,   -1,   45,   46,
   47,   37,   38,   -1,   -1,   -1,   42,   43,   -1,   45,
   46,   47,   -1,   60,   -1,   62,   63,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   60,   -1,   62,   63,   -1,   -1,
   -1,   -1,   -1,   -1,   37,   38,   -1,   -1,   -1,   42,
   43,   -1,   45,   46,   47,   37,   38,   94,   -1,   41,
   42,   43,   -1,   45,   46,   47,   -1,   60,   94,   62,
   63,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   60,   -1,
   62,   63,   -1,   -1,   37,   38,   -1,  124,   41,   42,
   43,   -1,   45,   46,   47,   -1,   -1,   -1,  124,  125,
   93,   94,   -1,   -1,  262,  263,  264,   60,   -1,   62,
   63,   -1,   94,   -1,   -1,   -1,   -1,   -1,   -1,  277,
  278,  279,  280,  281,  282,  283,  284,  285,  286,   37,
   38,  124,   -1,   -1,   42,   43,   -1,   45,   46,   47,
   -1,   94,  124,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   60,   -1,   62,   63,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,  124,   -1,   -1,   37,   38,   -1,   -1,   -1,   42,
   43,   -1,   45,   46,   47,   -1,   94,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   60,   -1,   62,
   63,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,  124,  125,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  262,  263,  264,   -1,   -1,
   -1,   94,   -1,   -1,   -1,   -1,  262,  263,  264,   -1,
  277,  278,  279,  280,  281,  282,  283,  284,  285,  286,
   -1,  277,  278,  279,  280,  281,  282,  283,  284,  285,
  286,  124,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  262,
  263,  264,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
  262,  263,  264,   -1,  277,  278,  279,  280,  281,  282,
  283,  284,  285,  286,   -1,  277,  278,  279,  280,  281,
  282,  283,  284,  285,  286,   -1,   -1,   -1,   -1,  262,
  263,  264,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,  277,  278,  279,  280,  281,  282,
  283,  284,  285,  286,   -1,   -1,   -1,   37,   38,   -1,
   -1,   -1,   42,   43,   -1,   45,   46,   47,   -1,   -1,
   -1,   -1,   -1,   -1,  262,  263,  264,   -1,   -1,   -1,
   60,   -1,   62,   63,   -1,   -1,   -1,   -1,   -1,  277,
  278,  279,  280,  281,  282,  283,  284,  285,  286,   37,
   38,   -1,   -1,   -1,   42,   43,   -1,   45,   46,   47,
   -1,   -1,   -1,   -1,   94,   -1,   -1,   -1,   -1,  262,
  263,  264,   60,   -1,   62,   63,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,  277,  278,  279,  280,  281,  282,
  283,  284,  285,  286,  124,   37,   38,   -1,   -1,   -1,
   42,   43,   -1,   45,   46,   47,   94,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   60,   -1,
   62,   63,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,  124,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   94,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,  124,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,  262,  263,  264,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,  277,  278,  279,
  280,  281,  282,  283,  284,  285,  286,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  263,  264,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,  277,
  278,  279,  280,  281,  282,  283,  284,  285,  286,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,  264,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,  277,  278,  279,  280,  281,
  282,  283,  284,  285,  286,
  );

  $GLOBALS['_PHP_PARSER']['yyFinal'] = 1;
$GLOBALS['_PHP_PARSER']['yyRule'] = array(
   "\$accept :  top_statement_list ",
   "\$\$1 :",
    "top_statement_list :  top_statement_list \$\$1  top_statement ",
    "top_statement_list :",
    "top_statement :  statement ",
    "top_statement :  declaration_statement ",
   "\$\$2 :",
    "inner_statement_list :  inner_statement_list \$\$2  inner_statement ",
    "inner_statement_list :",
    "inner_statement :  statement ",
    "inner_statement :  declaration_statement ",
    "statement :  unticked_statement ",
    "unticked_statement : '{'  inner_statement_list  '}'",
    "unticked_statement :  T_IF  '('  expr  ')'  statement   elseif_list   else_single ",
    "unticked_statement :  T_IF  '('  expr  ')' ':'  inner_statement_list   new_elseif_list   new_else_single   T_ENDIF  ';'",
    "unticked_statement :  T_WHILE  '('  expr  ')'  while_statement ",
    "unticked_statement :  T_DO   statement   T_WHILE  '('  expr  ')' ';'",
    "unticked_statement :  T_FOR  '('  for_expr  ';'  for_expr  ';'  for_expr  ')'  for_statement ",
    "unticked_statement :  T_SWITCH  '('  expr  ')'  switch_case_list ",
    "unticked_statement :  T_BREAK  ';'",
    "unticked_statement :  T_BREAK   expr  ';'",
    "unticked_statement :  T_CONTINUE  ';'",
    "unticked_statement :  T_CONTINUE   expr  ';'",
    "unticked_statement :  T_RETURN  ';'",
    "unticked_statement :  T_RETURN   expr_without_variable  ';'",
    "unticked_statement :  T_RETURN   cvar  ';'",
    "unticked_statement :  T_GLOBAL   global_var_list  ';'",
    "unticked_statement :  T_STATIC   static_var_list  ';'",
    "unticked_statement :  T_ECHO   echo_expr_list  ';'",
    "unticked_statement :  T_INLINE_HTML ",
    "unticked_statement :  expr  ';'",
    "unticked_statement :  T_USE   use_filename  ';'",
    "unticked_statement :  T_UNSET  '('  unset_variables  ')' ';'",
   "\$\$3 :",
   "\$\$4 :",
    "unticked_statement :  T_FOREACH  '('  w_cvar   T_AS \$\$3  w_cvar   foreach_optional_arg  ')'\$\$4  foreach_statement ",
   "\$\$5 :",
   "\$\$6 :",
    "unticked_statement :  T_FOREACH  '('  expr_without_variable   T_AS \$\$5  w_cvar   foreach_optional_arg  ')'\$\$6  foreach_statement ",
   "\$\$7 :",
    "unticked_statement :  T_DECLARE \$\$7 '('  declare_list  ')'  declare_statement ",
    "unticked_statement : ';'",
    "unset_variables :  unset_variable ",
    "unset_variables :  unset_variables  ','  unset_variable ",
    "unset_variable :  cvar ",
    "use_filename :  T_CONSTANT_ENCAPSED_STRING ",
    "use_filename : '('  T_CONSTANT_ENCAPSED_STRING  ')'",
    "declaration_statement :  unticked_declaration_statement ",
   "\$\$8 :",
    "unticked_declaration_statement :  T_FUNCTION \$\$8  is_reference   T_STRING  '('  parameter_list  ')' '{'  inner_statement_list  '}'",
    "unticked_declaration_statement :  T_OLD_FUNCTION   is_reference   T_STRING   parameter_list  '('  inner_statement_list  ')' ';'",
   "\$\$9 :",
    "unticked_declaration_statement :  T_CLASS   T_STRING \$\$9 '{'  class_statement_list  '}'",
   "\$\$10 :",
    "unticked_declaration_statement :  T_CLASS   T_STRING   T_EXTENDS   T_STRING \$\$1 '{'  class_statement_list  '}'",
    "foreach_optional_arg :",
    "foreach_optional_arg :  T_DOUBLE_ARROW   w_cvar ",
    "for_statement :  statement ",
    "for_statement : ':'  inner_statement_list   T_ENDFOR  ';'",
    "foreach_statement :  statement ",
    "foreach_statement : ':'  inner_statement_list   T_ENDFOREACH  ';'",
    "declare_statement :  statement ",
    "declare_statement : ':'  inner_statement_list   T_ENDDECLARE  ';'",
    "declare_list :  T_STRING  '='  static_scalar ",
    "declare_list :  declare_list  ','  T_STRING  '='  static_scalar ",
    "switch_case_list : '{'  case_list  '}'",
    "switch_case_list : '{' ';'  case_list  '}'",
    "switch_case_list : ':'  case_list   T_ENDSWITCH  ';'",
    "switch_case_list : ':' ';'  case_list   T_ENDSWITCH  ';'",
    "case_list :",
   "\$\$11 :",
    "case_list :  case_list   T_CASE   expr   case_separator \$\$1  inner_statement_list ",
   "\$\$12 :",
    "case_list :  case_list   T_DEFAULT   case_separator \$\$1  inner_statement_list ",
    "case_separator : ':'",
    "case_separator : ';'",
    "while_statement :  statement ",
    "while_statement : ':'  inner_statement_list   T_ENDWHILE  ';'",
    "elseif_list :",
   "\$\$13 :",
    "elseif_list :  elseif_list   T_ELSEIF  '('  expr  ')'\$\$1  statement ",
    "new_elseif_list :",
   "\$\$14 :",
    "new_elseif_list :  new_elseif_list   T_ELSEIF  '('  expr  ')' ':'\$\$1  inner_statement_list ",
    "else_single :",
    "else_single :  T_ELSE   statement ",
    "new_else_single :",
    "new_else_single :  T_ELSE  ':'  inner_statement_list ",
    "parameter_list :  non_empty_parameter_list ",
    "parameter_list :",
    "non_empty_parameter_list :  T_VARIABLE ",
    "non_empty_parameter_list : '&'  T_VARIABLE ",
    "non_empty_parameter_list :  T_CONST   T_VARIABLE ",
    "non_empty_parameter_list :  T_VARIABLE  '='  static_scalar ",
    "non_empty_parameter_list :  non_empty_parameter_list  ','  T_VARIABLE ",
    "non_empty_parameter_list :  non_empty_parameter_list  ',' '&'  T_VARIABLE ",
    "non_empty_parameter_list :  non_empty_parameter_list  ','  T_CONST   T_VARIABLE ",
    "non_empty_parameter_list :  non_empty_parameter_list  ','  T_VARIABLE  '='  static_scalar ",
    "function_call_parameter_list :  non_empty_function_call_parameter_list ",
    "function_call_parameter_list :",
    "non_empty_function_call_parameter_list :  expr_without_variable ",
    "non_empty_function_call_parameter_list :  cvar ",
    "non_empty_function_call_parameter_list : '&'  w_cvar ",
    "non_empty_function_call_parameter_list :  non_empty_function_call_parameter_list  ','  expr_without_variable ",
    "non_empty_function_call_parameter_list :  non_empty_function_call_parameter_list  ','  cvar ",
    "non_empty_function_call_parameter_list :  non_empty_function_call_parameter_list  ',' '&'  w_cvar ",
    "global_var_list :  global_var_list  ','  global_var ",
    "global_var_list :  global_var ",
    "global_var :  T_VARIABLE ",
    "global_var : '\$'  r_cvar ",
    "global_var : '\$' '{'  expr  '}'",
    "static_var_list :  static_var_list  ','  T_VARIABLE ",
    "static_var_list :  static_var_list  ','  T_VARIABLE  '='  static_scalar ",
    "static_var_list :  T_VARIABLE ",
    "static_var_list :  T_VARIABLE  '='  static_scalar ",
    "class_statement_list :  class_statement_list   class_statement ",
    "class_statement_list :",
    "class_statement :  T_VAR   class_variable_decleration  ';'",
   "\$\$15 :",
   "\$\$16 :",
   "\$\$17 :",
    "class_statement :  T_FUNCTION \$\$1  is_reference   T_STRING \$\$1 '('  parameter_list  ')'\$\$1 '{'  inner_statement_list  '}'",
   "\$\$18 :",
   "\$\$19 :",
    "class_statement :  T_OLD_FUNCTION \$\$1  is_reference   T_STRING \$\$1  parameter_list  '('  inner_statement_list  ')' ';'",
    "is_reference :",
    "is_reference : '&'",
    "class_variable_decleration :  class_variable_decleration  ','  T_VARIABLE ",
   "\$\$20 :",
    "class_variable_decleration :  class_variable_decleration  ','  T_VARIABLE \$\$2 '='  static_scalar ",
    "class_variable_decleration :  T_VARIABLE ",
   "\$\$21 :",
    "class_variable_decleration :  T_VARIABLE \$\$2 '='  static_scalar ",
    "echo_expr_list :",
    "echo_expr_list :  echo_expr_list  ','  expr ",
    "echo_expr_list :  expr ",
    "for_expr :",
    "for_expr :  non_empty_for_expr ",
   "\$\$22 :",
    "non_empty_for_expr :  non_empty_for_expr  ','\$\$2  expr ",
    "non_empty_for_expr :  expr ",
   "\$\$23 :",
    "expr_without_variable :  T_LIST  '('\$\$2  assignment_list  ')' '='  expr ",
    "expr_without_variable :  cvar  '='  expr ",
    "expr_without_variable :  cvar  '=' '&'  w_cvar ",
    "expr_without_variable :  cvar  '=' '&'  function_call ",
    "expr_without_variable :  cvar  '=' '&'  T_NEW   static_or_variable_string   ctor_arguments ",
    "expr_without_variable :  cvar  '='  T_NEW   static_or_variable_string   ctor_arguments ",
    "expr_without_variable :  T_NEW   static_or_variable_string   ctor_arguments ",
    "expr_without_variable :  cvar   T_PLUS_EQUAL   expr ",
    "expr_without_variable :  cvar   T_MINUS_EQUAL   expr ",
    "expr_without_variable :  cvar   T_MUL_EQUAL   expr ",
    "expr_without_variable :  cvar   T_DIV_EQUAL   expr ",
    "expr_without_variable :  cvar   T_CONCAT_EQUAL   expr ",
    "expr_without_variable :  cvar   T_MOD_EQUAL   expr ",
    "expr_without_variable :  cvar   T_AND_EQUAL   expr ",
    "expr_without_variable :  cvar   T_OR_EQUAL   expr ",
    "expr_without_variable :  cvar   T_XOR_EQUAL   expr ",
    "expr_without_variable :  cvar   T_SL_EQUAL   expr ",
    "expr_without_variable :  cvar   T_SR_EQUAL   expr ",
    "expr_without_variable :  rw_cvar   T_INC ",
    "expr_without_variable :  T_INC   rw_cvar ",
    "expr_without_variable :  rw_cvar   T_DEC ",
    "expr_without_variable :  T_DEC   rw_cvar ",
   "\$\$24 :",
    "expr_without_variable :  expr   T_BOOLEAN_OR \$\$2  expr ",
   "\$\$25 :",
    "expr_without_variable :  expr   T_BOOLEAN_AND \$\$2  expr ",
   "\$\$26 :",
    "expr_without_variable :  expr   T_LOGICAL_OR \$\$2  expr ",
   "\$\$27 :",
    "expr_without_variable :  expr   T_LOGICAL_AND \$\$2  expr ",
    "expr_without_variable :  expr   T_LOGICAL_XOR   expr ",
    "expr_without_variable :  expr  '|'  expr ",
    "expr_without_variable :  expr  '&'  expr ",
    "expr_without_variable :  expr  '^'  expr ",
    "expr_without_variable :  expr  '.'  expr ",
    "expr_without_variable :  expr  '+'  expr ",
    "expr_without_variable :  expr  '-'  expr ",
    "expr_without_variable :  expr  '*'  expr ",
    "expr_without_variable :  expr  '/'  expr ",
    "expr_without_variable :  expr  '%'  expr ",
    "expr_without_variable :  expr   T_SL   expr ",
    "expr_without_variable :  expr   T_SR   expr ",
    "expr_without_variable : '+'  expr ",
    "expr_without_variable : '-'  expr ",
    "expr_without_variable : '!'  expr ",
    "expr_without_variable : '~'  expr ",
    "expr_without_variable :  expr   T_IS_IDENTICAL   expr ",
    "expr_without_variable :  expr   T_IS_NOT_IDENTICAL   expr ",
    "expr_without_variable :  expr   T_IS_EQUAL   expr ",
    "expr_without_variable :  expr   T_IS_NOT_EQUAL   expr ",
    "expr_without_variable :  expr  '<'  expr ",
    "expr_without_variable :  expr   T_IS_SMALLER_OR_EQUAL   expr ",
    "expr_without_variable :  expr  '>'  expr ",
    "expr_without_variable :  expr   T_IS_GREATER_OR_EQUAL   expr ",
    "expr_without_variable : '('  expr  ')'",
   "\$\$28 :",
   "\$\$29 :",
    "expr_without_variable :  expr  '?'\$\$2  expr  ':'\$\$2  expr ",
    "expr_without_variable :  function_call ",
    "expr_without_variable :  internal_functions_in_yacc ",
    "expr_without_variable :  T_INT_CAST   expr ",
    "expr_without_variable :  T_DOUBLE_CAST   expr ",
    "expr_without_variable :  T_STRING_CAST   expr ",
    "expr_without_variable :  T_ARRAY_CAST   expr ",
    "expr_without_variable :  T_OBJECT_CAST   expr ",
    "expr_without_variable :  T_BOOL_CAST   expr ",
    "expr_without_variable :  T_UNSET_CAST   expr ",
    "expr_without_variable :  T_EXIT   exit_expr ",
   "\$\$30 :",
    "expr_without_variable : '@'\$\$3  expr ",
    "expr_without_variable :  scalar ",
    "expr_without_variable :  T_ARRAY  '('  array_pair_list  ')'",
    "expr_without_variable : '`'  encaps_list  '`'",
    "expr_without_variable :  T_PRINT   expr ",
   "\$\$31 :",
    "function_call :  T_STRING  '('\$\$3  function_call_parameter_list  ')'",
   "\$\$32 :",
    "function_call :  cvar  '('\$\$3  function_call_parameter_list  ')'",
   "\$\$33 :",
    "function_call :  T_STRING   T_PAAMAYIM_NEKUDOTAYIM   static_or_variable_string  '('\$\$3  function_call_parameter_list  ')'",
    "static_or_variable_string :  T_STRING ",
    "static_or_variable_string :  r_cvar ",
    "exit_expr :",
    "exit_expr : '(' ')'",
    "exit_expr : '('  expr  ')'",
    "ctor_arguments :",
    "ctor_arguments : '('  function_call_parameter_list  ')'",
    "common_scalar :  T_LNUMBER ",
    "common_scalar :  T_DNUMBER ",
    "common_scalar :  T_CONSTANT_ENCAPSED_STRING ",
    "common_scalar :  T_LINE ",
    "common_scalar :  T_FILE ",
    "common_scalar :  T_CLASS_C ",
    "common_scalar :  T_FUNC_C ",
    "static_scalar :  common_scalar ",
    "static_scalar :  T_STRING ",
    "static_scalar : '+'  static_scalar ",
    "static_scalar : '-'  static_scalar ",
    "static_scalar :  T_ARRAY  '('  static_array_pair_list  ')'",
    "scalar :  T_STRING ",
    "scalar :  T_STRING_VARNAME ",
    "scalar :  common_scalar ",
    "scalar : '\"'  encaps_list  '\"'",
    "scalar : '\\''  encaps_list  '\\''",
    "scalar :  T_START_HEREDOC   encaps_list   T_END_HEREDOC ",
    "static_array_pair_list :",
    "static_array_pair_list :  non_empty_static_array_pair_list   possible_comma ",
    "possible_comma :",
    "possible_comma : ','",
    "non_empty_static_array_pair_list :  non_empty_static_array_pair_list  ','  static_scalar   T_DOUBLE_ARROW   static_scalar ",
    "non_empty_static_array_pair_list :  non_empty_static_array_pair_list  ','  static_scalar ",
    "non_empty_static_array_pair_list :  static_scalar   T_DOUBLE_ARROW   static_scalar ",
    "non_empty_static_array_pair_list :  static_scalar ",
    "expr :  r_cvar ",
    "expr :  expr_without_variable ",
    "r_cvar :  cvar ",
    "w_cvar :  cvar ",
    "rw_cvar :  cvar ",
    "cvar :  cvar_without_objects ",
    "cvar :  cvar_without_objects   T_OBJECT_OPERATOR   ref_list ",
    "cvar_without_objects :  reference_variable ",
    "cvar_without_objects :  simple_indirect_reference   reference_variable ",
    "reference_variable :  reference_variable  '['  dim_offset  ']'",
    "reference_variable :  reference_variable  '{'  expr  '}'",
    "reference_variable :  compound_variable ",
    "compound_variable :  T_VARIABLE ",
    "compound_variable : '\$' '{'  expr  '}'",
    "dim_offset :",
    "dim_offset :  expr ",
    "ref_list :  object_property ",
    "ref_list :  ref_list   T_OBJECT_OPERATOR   object_property ",
    "object_property :  object_dim_list ",
    "object_property :  cvar_without_objects ",
    "object_dim_list :  object_dim_list  '['  dim_offset  ']'",
    "object_dim_list :  object_dim_list  '{'  expr  '}'",
    "object_dim_list :  variable_name ",
    "variable_name :  T_STRING ",
    "variable_name : '{'  expr  '}'",
    "simple_indirect_reference : '\$'",
    "simple_indirect_reference :  simple_indirect_reference  '\$'",
    "assignment_list :  assignment_list  ','  assignment_list_element ",
    "assignment_list :  assignment_list_element ",
    "assignment_list_element :  cvar ",
    "assignment_list_element :  T_LIST  '('  assignment_list  ')'",
    "assignment_list_element :",
    "array_pair_list :",
    "array_pair_list :  non_empty_array_pair_list   possible_comma ",
    "non_empty_array_pair_list :  non_empty_array_pair_list  ','  expr   T_DOUBLE_ARROW   expr ",
    "non_empty_array_pair_list :  non_empty_array_pair_list  ','  expr ",
    "non_empty_array_pair_list :  expr   T_DOUBLE_ARROW   expr ",
    "non_empty_array_pair_list :  expr ",
    "non_empty_array_pair_list :  non_empty_array_pair_list  ','  expr   T_DOUBLE_ARROW  '&'  w_cvar ",
    "non_empty_array_pair_list :  non_empty_array_pair_list  ',' '&'  w_cvar ",
    "non_empty_array_pair_list :  expr   T_DOUBLE_ARROW  '&'  w_cvar ",
    "non_empty_array_pair_list : '&'  w_cvar ",
    "encaps_list :  encaps_list   encaps_var ",
    "encaps_list :  encaps_list   T_STRING ",
    "encaps_list :  encaps_list   T_NUM_STRING ",
    "encaps_list :  encaps_list   T_ENCAPSED_AND_WHITESPACE ",
    "encaps_list :  encaps_list   T_CHARACTER ",
    "encaps_list :  encaps_list   T_BAD_CHARACTER ",
    "encaps_list :  encaps_list  '['",
    "encaps_list :  encaps_list  ']'",
    "encaps_list :  encaps_list  '{'",
    "encaps_list :  encaps_list  '}'",
    "encaps_list :  encaps_list   T_OBJECT_OPERATOR ",
    "encaps_list :",
    "encaps_var :  T_VARIABLE ",
    "encaps_var :  T_VARIABLE  '['",
    "encaps_var :  T_VARIABLE   T_OBJECT_OPERATOR   T_STRING ",
    "encaps_var :  T_DOLLAR_OPEN_CURLY_BRACES   expr  '}'",
    "encaps_var :  T_DOLLAR_OPEN_CURLY_BRACES   T_STRING_VARNAME  '['  expr  ']' '}'",
    "encaps_var :  T_CURLY_OPEN   cvar  '}'",
    "encaps_var_offset :  T_STRING ",
    "encaps_var_offset :  T_NUM_STRING ",
    "encaps_var_offset :  T_VARIABLE ",
    "internal_functions_in_yacc :  T_ISSET  '('  isset_variables  ')'",
    "internal_functions_in_yacc :  T_EMPTY  '('  cvar  ')'",
    "internal_functions_in_yacc :  T_INCLUDE   expr ",
    "internal_functions_in_yacc :  T_INCLUDE_ONCE   expr ",
    "internal_functions_in_yacc :  T_EVAL  '('  expr  ')'",
    "internal_functions_in_yacc :  T_REQUIRE   expr ",
    "internal_functions_in_yacc :  T_REQUIRE_ONCE   expr ",
    "isset_variables :  cvar ",
   "\$\$34 :",
    "isset_variables :  isset_variables  ','\$\$3  cvar ",
  );
  $GLOBALS['_PHP_PARSER']['yyName'] =array(    
    "end-of-file",null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,"'!'","'\"'",null,"'\$'","'%'",
    "'&'","'\\''","'('","')'","'*'","'+'","','","'-'","'.'","'/'",null,
    null,null,null,null,null,null,null,null,null,"':'","';'","'<'","'='",
    "'>'","'?'","'@'",null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,"'['",null,"']'","'^'",null,"'`'",null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,"'{'","'|'","'}'","'~'",null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,"T_INCLUDE","T_INCLUDE_ONCE","T_EVAL","T_REQUIRE",
    "T_REQUIRE_ONCE","T_LOGICAL_OR","T_LOGICAL_XOR","T_LOGICAL_AND",
    "T_PRINT","T_PLUS_EQUAL","T_MINUS_EQUAL","T_MUL_EQUAL","T_DIV_EQUAL",
    "T_CONCAT_EQUAL","T_MOD_EQUAL","T_AND_EQUAL","T_OR_EQUAL",
    "T_XOR_EQUAL","T_SL_EQUAL","T_SR_EQUAL","T_BOOLEAN_OR",
    "T_BOOLEAN_AND","T_IS_EQUAL","T_IS_NOT_EQUAL","T_IS_IDENTICAL",
    "T_IS_NOT_IDENTICAL","T_IS_SMALLER_OR_EQUAL","T_IS_GREATER_OR_EQUAL",
    "T_SL","T_SR","T_INC","T_DEC","T_INT_CAST","T_DOUBLE_CAST",
    "T_STRING_CAST","T_ARRAY_CAST","T_OBJECT_CAST","T_BOOL_CAST",
    "T_UNSET_CAST","T_NEW","T_EXIT","T_IF","T_ELSEIF","T_ELSE","T_ENDIF",
    "T_LNUMBER","T_DNUMBER","T_STRING","T_STRING_VARNAME","T_VARIABLE",
    "T_NUM_STRING","T_INLINE_HTML","T_CHARACTER","T_BAD_CHARACTER",
    "T_ENCAPSED_AND_WHITESPACE","T_CONSTANT_ENCAPSED_STRING","T_ECHO",
    "T_DO","T_WHILE","T_ENDWHILE","T_FOR","T_ENDFOR","T_FOREACH",
    "T_ENDFOREACH","T_DECLARE","T_ENDDECLARE","T_AS","T_SWITCH",
    "T_ENDSWITCH","T_CASE","T_DEFAULT","T_BREAK","T_CONTINUE",
    "T_OLD_FUNCTION","T_FUNCTION","T_CONST","T_RETURN","T_USE","T_GLOBAL",
    "T_STATIC","T_VAR","T_UNSET","T_ISSET","T_EMPTY","T_CLASS",
    "T_EXTENDS","T_OBJECT_OPERATOR","T_DOUBLE_ARROW","T_LIST","T_ARRAY",
    "T_CLASS_C","T_FUNC_C","T_LINE","T_FILE","T_COMMENT","T_ML_COMMENT",
    "T_OPEN_TAG","T_OPEN_TAG_WITH_ECHO","T_CLOSE_TAG","T_WHITESPACE",
    "T_START_HEREDOC","T_END_HEREDOC","T_DOLLAR_OPEN_CURLY_BRACES",
    "T_CURLY_OPEN","T_PAAMAYIM_NEKUDOTAYIM",
  );
 ?>
