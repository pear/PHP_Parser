<?php
 // created by jay 0.8 (c) 1998 Axel.Schreiner@informatik.uni-osnabrueck.de
 // modified by alan@akbkhome.com to try to generate php!
 // modified by cellog@users.sourceforge.net to fit PEAR CS
 // %token constants

 require_once 'PHP/Parser/Stack.php';

 define('PHP_PARSER_ERROR_UNEXPECTED', 1);
 define('PHP_PARSER_ERROR_SYNTAX', 2);
 define('PHP_PARSER_ERROR_SYNTAX_EOF', 3);
if (!defined('TOKEN_yyErrorCode')) {   define('TOKEN_yyErrorCode', 256);
}
 // Class now

					// line 1 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"

?><?php
define('PHP_PARSER_DOCBLOCK_DEFAULT_ERROR_PARSE', 1);
require_once 'PHP/Parser/MsgServer.php';

/**
 * Default phpDocumentor DocBlock Parser
 * @package PHP_Parser
 */
class PHP_Parser_DocBlock_Default {

    /**
     * Options, used to control how the parser collects
     * and distributes the data it finds.
     *
     * Currently, options are grouped into two categories:
     * - containers for data
     * - publishing of data
     *
     * Default action is to return arrays of parsed data
     * for use by other applications.  The first set of
     * options, container options, provide a means to
     * tell the parser to encapsulate data in objects
     * instead of in arrays.  The option tells the parser which
     * class to instantiate for each documentable element.  The
     * default value of false will prompt the usage of arrays
     * instead.
     *
     * The second set of options provide for intermediary
     * publishing of data while parsing, to allow other
     * classes to hook into functionality if they desire
     * @access protected
     * @var array
     */
    var $_options = array();
    
    /**
     * The global message server
     * @var PHP_Parser_MsgServer
     */
    var $_server;
    
    /**
     * The error stack
     * @var PEAR_ErrorStack
     */
    var $_errorStack;
    
    /**
     * Tags from parsing
     * @tutorial tags.pkg
     * @var array
     */
    var $tags = array();
    
    /**
     * Long description
     * @var array
     */
    var $paragraphs = array();
    
    /**
     * Summary of documentation
     * @var array
     */
    var $summary = array();
    
    /**
     * Compatibility with PHP 4
     * @param array
     */
    function PHP_Parser_DocBlock_Default($options = array())
    {
        $this->_server = &PHP_Parser_MsgServer::singleton();
        $this->_errorStack = &PEAR_ErrorStack::singleton('PHP_Parser_Docblock_Default');
        $this->_options['publishConstMessage'] =
        $this->_options['parseInternal'] =
        false;
        $this->_options['tagParserMap'] = array();
        $this->_options['inlineTagParserMap'] = array();
        $this->_options['docblockClass'] =
        $this->_options['completeTagClass'] =
        $this->_options['codeClass'] =
        $this->_options['preClass'] =
        $this->_options['boldClass'] =
        $this->_options['italicClass'] =
        $this->_options['varClass'] =
        $this->_options['kbdClass'] =
        $this->_options['sampClass'] =
        $this->_options['listClass'] =
        $this->_options['listitemClass'] =
        $this->_options['tagsContainerClass'] =
        false;
        $this->_options = array_merge($this->_options, $options);
        if (!class_exists($this->_options['tagsContainerClass'])) {
            $this->_options['tagsContainerClass'] = false;
        }
        if (!class_exists($this->_options['listClass'])) {
            $this->_options['listClass'] = false;
        }
        if (!class_exists($this->_options['listitemClass'])) { // until we can instanceof a classname
            $this->_options['listitemClass'] = false;
        }
        if (!class_exists($this->_options['codeClass'])) { // until we can instanceof a classname
            $this->_options['codeClass'] = false;
        }
        if (!class_exists($this->_options['completeTagClass'])) { // until we can instanceof a classname
            $this->_options['completeTagClass'] = false;
        }
        if (!class_exists($this->_options['docblockClass'])) { // until we can instanceof a classname
            $this->_options['codeClass'] = false;
        }
        if (!class_exists($this->_options['preClass'])) { // until we can instanceof a classname
            $this->_options['preClass'] = false;
        }
        if (!class_exists($this->_options['boldClass'])) { // until we can instanceof a classname
            $this->_options['boldClass'] = false;
        }
        if (!class_exists($this->_options['italicClass'])) { // until we can instanceof a classname
            $this->_options['italicClass'] = false;
        }
        if (!class_exists($this->_options['varClass'])) { // until we can instanceof a classname
            $this->_options['varClass'] = false;
        }
        if (!class_exists($this->_options['kbdClass'])) { // until we can instanceof a classname
            $this->_options['kbdClass'] = false;
        }
        if (!class_exists($this->_options['sampClass'])) { // until we can instanceof a classname
            $this->_options['sampClass'] = false;
        }
        if (is_array($this->_options['tagParserMap'])) {
            $map = $this->_options['tagParserMap'];
            foreach($map as $tag => $handler) {
                if (!is_a($handler, 'PHP_Parser_DocBlock_TagParser')) {
                    unset($this->_options['tagParserMap'][$tag]);
                }
            }
        }
        if (is_array($this->_options['inlineTagParserMap'])) {
            $map = $this->_options['inlineTagParserMap'];
            foreach($map as $tag => $handler) {
                if (!is_a($handler, 'PHP_Parser_DocBlock_InlineTagParser')) {
                    unset($this->_options['inlineTagParserMap'][$tag]);
                }
            }
        }
    }

    /**
     * global variable name of parser arrays
     * should match the build options  
     *
     * @var string
     * @access public 
     */
    var $yyGlobalName = '_PHP_PARSER_DOCBLOCK_DEFAULT';

    /**
     * (syntax) error message.
     * Can be overwritten to control message format.
     * @param message text to be displayed.
     * @param expected vector of acceptable tokens, if available.
     */
    function raiseError ($message, $code, $params)
    {     
        if (isset($params['expected'])) {
            $p = $params['expected'];
            $m = "$message, expecting ";
            if (count($p) - 1) {
                $last = array_pop($p);
                array_push($p, 'or ' . $last);
            }
            $m .= implode(', ', $p);
        } else {
            $m = $message;
        }
        return $this->_errorStack->push(
            PHP_PARSER_DOCBLOCK_DEFAULT_ERROR_PARSE,
            'error', $params,
            $m);  
    }
    
    function _newList($item, $lt)
    {
        $l = $this->_options['listClass'];
        $i = $this->_options['listitemClass'];
        if ($l && $i) {
            $list = new $l();
            $list->setType($lt);
            $list->addItem(new $i($item));
        } else {
            $list = array(
                        'type' => $lt,
                        'list' =>
                        array('items' => array($item)));
        }
        return $list;
    }
    
    function _addList($list, $item)
    {
        if (is_array($list)) {
            $list['items'][] = $item;
        } else {
            $i = $this->_options['listitemClass'];
            $list->addItem(new $i($item));
        }
        return $list;
    }
    
    /**
     * @param array $options
     * @param:array string $comment DocBlock to parse
     * @param:array integer $line line number
     * @param:array array $token T_DOC_COMMENT token
     * @param:array PhpDocumentor_DocBlock_Lexer $lex DocBlock lexer
     * @param:array boolean $nosummary if true, then the description will not
     *                      be separated into summary/long description
     * @param:array boolean $preformatted if true, then the documentation
     *                      has already had the comment stuff stripped
     */
    function parse($options)
    {
        if (count($options) < 4) {
            return false;
        }
        $comment = $options['comment'];
        $line = @$options['commentline'];
        $token = @$options['commenttoken'];
        $lex = $options['lexer'];
        
        $this->summary = $this->paragraphs = $this->tags = array();

        $endlinenumber = $line + count(explode("\n", $comment));
        $dtemplate = false;
        if (!isset($options['tagdesc'])) {
            if ($comment == '/**#@-*/') {
                $parsed_docs = false;
                $this->_server->sendMessage(PHPDOCUMENTOR_PARSED_DOCTEMPLATE_STOP, false);
                return false;
            }
            if (strpos($comment,'/**#@+') === 0) {
                $dtemplate = true;
            }
            $comment = $this->stripNonEssentials($comment);
        }
        $lex->setup($comment);
        $result = $this->yyparse($lex);
        if (PEAR::isError($result)) {
            echo $result->getMessage()."\n";
            return $result;
        }
        if (!isset($options['nosummary'])) {
            $this->setSummary();
        }
        $docblock = $this->_options['docblockClass'];
        if ($docblock) {
            $parsed_docs = new $docblock($this);
            $parsed_docs->setStartLine($line);
            $parsed_docs->setEndLine($endlinenumber);
        } else {
            $parsed_docs =
                array(
                    'summary' => $this->summary,
                    'documentation' => $this->paragraphs,
                    'tags' => $this->tags,
                    'startline' => $line,
                    'endline' => $endlinenumber,
                     );
        }
        if ($dtemplate) {
            $this->_server->sendMessage('parsed docblock template', $parsed_docs);
        } else {
            if (!isset($options['tagdesc'])) {
                $this->_server->sendMessage('parsed docblock', $parsed_docs);
            }
            return $parsed_docs;
        }
    }
    
    function getSummary()
    {
        return $this->summary;
    }
    
    function getDescription()
    {
        return $this->paragraphs;
    }
    
    function getTags()
    {
        return $this->tags;
    }
    
    /**
     * Remove the /**, * from the doc comment
     *
     * Also remove blank lines
     * @param string
     * @return array
     */
    function stripNonEssentials($comment)
    {
        $comment = str_replace("\r", '', trim($comment));
        if (strpos($comment, '/**#@+') === 0)
        { // docblock template definition
            // strip /**#@+ and */
            $comment = substr($comment,6).'*';
            $comment = substr($comment,0,strlen($comment) - 2);
        } else
        {
            // strip /** and */
            $comment = substr($comment,2);
            $comment = substr($comment,0,strlen($comment) - 2);
        }
        $lines = explode("\n", trim($comment));
        $go = count($lines);
        for($i=0; $i < $go; $i++)
        {
            if (substr(trim($lines[$i]),0,1) != '*') {
                unset($lines[$i]);
            } else {
                $lines[$i] = substr(trim($lines[$i]),1); // remove leading "* "
            }
        }
        // remove empty lines
        return trim(join("\n", $lines));
    }

    function _parseTag($name, $contents)
    {
        if (is_array($this->_options['tagParserMap'])) {
            if (isset($this->_options['tagParserMap']
                  [str_replace('@', '', $name)])) {
                // use custom tag parser
                return $this->_options['tagParserMap'][str_replace('@', '',
                  $name)]->parseTag(str_replace('@', '', $name), $contents);
            } elseif (isset($this->_options['tagParserMap']['*'])) {
                // use default tag parser
                return $this->_options['tagParserMap']['*']->parseTag(
                  str_replace('@', '', $name), $contents);
            } else {
                // no default handler
                return array('tag' => str_replace('@', '', $name),
                  'value' => $contents);
            }
        } else {
            // no registered tag parsers
            return array('tag' => str_replace('@', '', $name),
              'value' => $contents);
        }
    }
    
    function _parseInlineTag($name, $contents)
    {
        if (is_array($this->_options['inlineTagParserMap'])) {
            if (isset($this->_options['inlineTagParserMap'][$name])) {
                // use custom inline tag parser
                return $this->_options['inlineTagParserMap']
                  [$name]->parseInlineTag($name, $contents);
            } elseif (isset($this->_options['inlineTagParserMap']['*'])) {
                // use default inline tag parser
                return $this->_options['inlineTagParserMap']
                  ['*']->parseInlineTag($name, $contents);
            } else {
                // no default handler
                return array('inlinetag' => $name, 'value' => $contents);
            }
        } else {
            // no registered inline tag parsers
            return array('inlinetag' => $name, 'value' => $contents);
        }
    }
					// line 392 "-"

    /**
     * thrown for irrecoverable syntax errors and stack overflow.
     */
    
     var $yyErrorCode = 256;

    /**
     * Debugging
     */
     var $debug = false;




    /**
     * index-checked interface to yyName[].
     * @param token single character or %token value.
     * @return token name or [illegal] or [unknown].
     */
    function yyname ($token) {
        if ($token < 0 || $token >  count($GLOBALS[$this->yyGlobalName]['yyName'])) return "[illegal]";
        if (($name = $GLOBALS[$this->yyGlobalName]['yyName'][$token]) != null) return $name;
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
            $start = 1;
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
            $start = 1;
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
    function yyparse (&$yyLex) {
        $this->debug = true;
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
        $this->yyValWithWhitespace = null;
        $this->yyVals = array();
        $this->yW = array();
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
                $this->yW[$yyTop] = $this->yyValWithWhitespace;

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
                            $this->yyValWithWhitespace = $yyLex->valueWithWhitespace;
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
                                    $data = $yyLex->parseError();
                                    $info = $data[0];
                                    $info .= ', Unexpected '.$this->yyName($yyToken).',';
                                    return $this->raiseError("$info syntax error",
                                                PHP_PARSER_ERROR_UNEXPECTED,
                                                array(
                                                  'expected' => $this->yyExpecting($this->yyState),
                                                  'token' => $this->yyName($yyToken),
                                                  'line' => $data[1],
                                                ));
                                
                                case 1: case 2:
                                    $yyErrorFlag = 3;
                                    do { 
                                        if (($yyN = @$GLOBALS[$this->yyGlobalName]['yySindex']
                                                [$this->yyStates[$yyTop]]) != 0
                                                && ($yyN += $this->yyErrorCode) >= 0 && $yyN < $yyTableCount
                                                && $GLOBALS[$this->yyGlobalName]['yyCheck'][$yyN] == $this->yyErrorCode) {
                                            $this->yyState = $GLOBALS[$this->yyGlobalName]['yyTable'][$yyN];
                                            $this->yyVal = $yyLex->value;
                                            $this->yyValWithWhitespace = $yyLex->valueWithWhitespace;
                                            //vi /echo "goto yyLoop?\n";
                                            break 3; //continue yyLoop;
                                        }
                                    } while ($yyTop-- >= 0);
                                    $data = $yyLex->parseError();
                                    return $this->raiseError("$data[0] irrecoverable syntax error",
                                           PHP_PARSER_ERROR_SYNTAX,
                                           array('line' => $data[1]));
    
                                case 3:
                                    if ($yyToken == 0) {
                                        $info =$yyLex->parseError();
                                        return $this->raiseError("$info[0] irrecoverable syntax error at end-of-file",
                                           PHP_PARSER_ERROR_SYNTAX_EOF,
                                           array('line' => $info[1]));
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


    function _1($yyTop)  					// line 431 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->paragraphs = array($this->yyVals[0+$yyTop]);
        }

    function _2($yyTop)  					// line 435 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->paragraphs = $this->yyVals[-1+$yyTop];
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _3($yyTop)  					// line 440 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            array_unshift($this->yyVals[-1+$yyTop], $this->yyVals[-2+$yyTop]);
            $this->paragraphs = $this->yyVals[-1+$yyTop];
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _4($yyTop)  					// line 446 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            array_unshift($this->yyVals[0+$yyTop], $this->yyVals[-1+$yyTop]);
            $this->paragraphs = $this->yyVals[0+$yyTop];
        }

    function _5($yyTop)  					// line 451 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->paragraphs = $this->yyVals[-1+$yyTop];
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _6($yyTop)  					// line 456 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _7($yyTop)  					// line 464 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
        $this->yyVal = $this->yyVals[0+$yyTop];
    }

    function _8($yyTop)  					// line 471 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->tags[] = $this->_parseTag($this->yyVals[0+$yyTop], array());
        }

    function _9($yyTop)  					// line 475 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->tags[] = $this->_parseTag($this->yyVals[-1+$yyTop], $this->yyVals[0+$yyTop]);
        }

    function _10($yyTop)  					// line 479 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if (is_string($this->yyVals[0+$yyTop][0])) {
                $this->yyVals[0+$yyTop][0] = $this->yyVals[-1+$yyTop] . $this->yyVals[0+$yyTop][0];
            }
            $this->tags[] = $this->_parseTag($this->yyVals[-2+$yyTop], $this->yyVals[0+$yyTop]);
        }

    function _12($yyTop)  					// line 489 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _13($yyTop)  					// line 493 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _14($yyTop)  					// line 501 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _15($yyTop)  					// line 505 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _16($yyTop)  					// line 513 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _17($yyTop)  					// line 517 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _18($yyTop)  					// line 521 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _19($yyTop)  					// line 525 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _20($yyTop)  					// line 529 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _21($yyTop)  					// line 533 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
        }

    function _22($yyTop)  					// line 537 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _23($yyTop)  					// line 541 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _24($yyTop)  					// line 551 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _25($yyTop)  					// line 561 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _26($yyTop)  					// line 566 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _27($yyTop)  					// line 571 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _28($yyTop)  					// line 576 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _29($yyTop)  					// line 586 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _30($yyTop)  					// line 596 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _31($yyTop)  					// line 606 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $temp = '{@';
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $temp = '*/';
            } else {
                $temp = '';
            }
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $temp;
            } else {
                $this->yyVal[] = $temp;
            }
        }

    function _32($yyTop)  					// line 623 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _33($yyTop)  					// line 631 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _34($yyTop)  					// line 635 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _35($yyTop)  					// line 639 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _36($yyTop)  					// line 643 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _37($yyTop)  					// line 647 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _38($yyTop)  					// line 651 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
        }

    function _39($yyTop)  					// line 655 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _40($yyTop)  					// line 665 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _41($yyTop)  					// line 669 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _42($yyTop)  					// line 679 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
         }

    function _43($yyTop)  					// line 684 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _44($yyTop)  					// line 689 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _45($yyTop)  					// line 694 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _46($yyTop)  					// line 699 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _47($yyTop)  					// line 709 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $t = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $t = array('*/');
            } else {
                $t = array('');
            }
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $t;
            } else {
                $this->yyVal[] = $t;
            }
        }

    function _48($yyTop)  					// line 725 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _49($yyTop)  					// line 738 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _50($yyTop)  					// line 742 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
        }

    function _51($yyTop)  					// line 746 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[0+$yyTop];
        }

    function _52($yyTop)  					// line 753 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['completeTagClass'];
            if ($tag) {
                $this->yyVal = array(new $tag($this->yyVals[0+$yyTop]));
            } else {
                $this->yyVal = array(array('completetag' => $this->yyVals[0+$yyTop]));
            }
        }

    function _59($yyTop)  					// line 771 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['completeTagClass'];
            if ($tag) {
                $this->yyVal = array(new $tag($this->yyVals[0+$yyTop]));
            } else {
                $this->yyVal = array(array('completetag' => $this->yyVals[0+$yyTop]));
            }
        }

    function _66($yyTop)  					// line 789 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['boldClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('strong' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _67($yyTop)  					// line 801 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['boldClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('strong' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _68($yyTop)  					// line 813 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['codeClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('code' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _69($yyTop)  					// line 825 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['codeClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('code' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _70($yyTop)  					// line 837 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['sampClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('samp' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _71($yyTop)  					// line 849 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['sampClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('samp' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _72($yyTop)  					// line 861 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['kbdClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('kbd' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _73($yyTop)  					// line 873 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['kbdClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('kbd' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _74($yyTop)  					// line 885 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['varClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('var' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _75($yyTop)  					// line 897 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['varClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('var' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _76($yyTop)  					// line 909 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $list = $this->_options['listClass'];
            if ($list) {
                $this->yyVal = new $list(2);
            } else {
                $this->yyVal = array('list' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _77($yyTop)  					// line 921 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $list = $this->_options['listClass'];
            if ($list) {
                $this->yyVal = new $list(2);
            } else {
                $this->yyVal = array('list' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _78($yyTop)  					// line 933 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _79($yyTop)  					// line 937 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _80($yyTop)  					// line 945 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _81($yyTop)  					// line 949 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _82($yyTop)  					// line 957 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _83($yyTop)  					// line 964 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _84($yyTop)  					// line 971 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _85($yyTop)  					// line 975 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-3+$yyTop];
            $this->yyVal[] = $this->yyVals[-1+$yyTop];
        }

    function _86($yyTop)  					// line 983 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _87($yyTop)  					// line 987 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-3+$yyTop];
            $this->yyVal[] = $this->yyVals[-1+$yyTop];
        }

    function _88($yyTop)  					// line 995 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'unordered';
        }

    function _89($yyTop)  					// line 999 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'ordered';
        }

    function _90($yyTop)  					// line 1003 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'ordered';
        }

    function _92($yyTop)  					// line 1011 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'unordered';
        }

    function _93($yyTop)  					// line 1015 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'ordered';
        }

    function _94($yyTop)  					// line 1019 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'ordered';
        }

    function _99($yyTop)  					// line 1034 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _100($yyTop)  					// line 1038 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array(str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]));
        }

    function _101($yyTop)  					// line 1042 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _102($yyTop)  					// line 1046 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _103($yyTop)  					// line 1056 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _104($yyTop)  					// line 1060 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _105($yyTop)  					// line 1064 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _106($yyTop)  					// line 1069 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _107($yyTop)  					// line 1078 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _108($yyTop)  					// line 1083 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $t = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $t = array('*/');
            } else {
                $t = array('');
            }
            $this->yyVal = $this->yyVals[-1+$yyTop];
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $t;
            } else {
                $this->yyVal[] = $t;
            }
        }

    function _109($yyTop)  					// line 1099 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _110($yyTop)  					// line 1104 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _112($yyTop)  					// line 1113 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
        }

    function _113($yyTop)  					// line 1117 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _114($yyTop)  					// line 1121 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _115($yyTop)  					// line 1131 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _116($yyTop)  					// line 1135 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _117($yyTop)  					// line 1139 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _118($yyTop)  					// line 1143 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _119($yyTop)  					// line 1148 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _120($yyTop)  					// line 1158 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _121($yyTop)  					// line 1163 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $t = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $t = array('*/');
            } else {
                $t = array('');
            }
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $t;
            } else {
                $this->yyVal[] = $t;
            }
        }

    function _122($yyTop)  					// line 1180 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _123($yyTop)  					// line 1190 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _124($yyTop)  					// line 1195 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _125($yyTop)  					// line 1203 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _126($yyTop)  					// line 1210 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _127($yyTop)  					// line 1217 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->_parseInlineTag($this->yyVals[-2+$yyTop], $this->yyVals[-1+$yyTop]);
        }

    function _128($yyTop)  					// line 1221 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->_parseInlineTag($this->yyVals[-1+$yyTop], array());
        }

    function _129($yyTop)  					// line 1228 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->_options['parseInternal']) {
                $this->yyVal = $this->yyVals[-1+$yyTop];
            } else {
                $this->yyVal = '';
            }
        }

    function _130($yyTop)  					// line 1239 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->_options['parseInternal']) {
                $this->yyVal = $this->yyVals[-1+$yyTop];
            } else {
                $this->yyVal = '';
            }
        }
					// line 1454 "-"

					// line 1247 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"

    /**#@-*/
}
					// line 1460 "-"

  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyLhs']  = array(              -1,
    0,    0,    0,    0,    0,    0,    3,    2,    2,    2,
    5,    5,    5,    4,    4,    1,    1,    1,    1,    1,
    1,    1,    1,    1,    1,    1,    1,    1,    1,    1,
    1,    1,   11,   11,   11,   11,   11,   11,   11,   11,
   11,   11,   11,   11,   11,   11,   11,   11,    6,    6,
    6,    7,    7,    7,    7,    7,    7,    7,   12,   12,
   12,   12,   12,   12,   12,   15,   21,   16,   22,   17,
   23,   18,   24,   19,   25,   20,   26,   27,   27,   28,
   28,   29,   30,    8,    8,   13,   13,   31,   31,   31,
   31,   35,   35,   35,   33,   33,   33,   33,   32,   32,
   32,   32,   32,   32,   32,   32,   32,   32,   32,   32,
   34,   34,   34,   34,   34,   34,   34,   34,   34,   34,
   34,   34,   34,   34,   36,   37,    9,    9,   10,   14,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyLen'] = array(           2,
    1,    2,    3,    2,    2,    1,    2,    1,    2,    3,
    0,    1,    3,    1,    2,    1,    1,    1,    1,    1,
    1,    1,    1,    2,    2,    2,    2,    2,    2,    2,
    2,    2,    1,    1,    1,    1,    1,    1,    1,    1,
    2,    2,    2,    2,    2,    2,    2,    2,    3,    4,
    2,    1,    1,    1,    1,    1,    1,    1,    1,    1,
    1,    1,    1,    1,    1,    3,    3,    3,    3,    3,
    3,    3,    3,    3,    3,    3,    3,    1,    2,    1,
    2,    3,    3,    3,    4,    3,    4,    1,    1,    1,
    2,    2,    2,    2,    1,    1,    1,    3,    1,    1,
    1,    1,    1,    1,    2,    2,    2,    2,    2,    2,
    1,    1,    1,    1,    1,    1,    1,    2,    2,    2,
    2,    2,    2,    2,    3,    3,    4,    3,    3,    3,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyDefRed'] = array(            0,
   88,   89,   90,    0,    0,    0,    0,    0,    0,    0,
    0,   22,   52,   21,   16,   23,    0,    0,    0,    0,
    0,    6,    0,   14,   17,    0,   19,   20,   53,   54,
   55,   56,   57,   58,    0,   91,    0,    0,    0,    0,
    0,    0,   59,   38,   33,   39,    0,   40,   36,    0,
   34,    0,   37,   60,   61,   62,   63,   64,   65,    0,
    0,    0,   78,    0,    0,    0,    0,    0,    0,    0,
    0,    0,   29,   30,   28,   24,   31,    0,    2,    0,
   25,    0,   27,   32,    5,   15,    0,   99,    0,  100,
  102,  103,  101,    0,    0,  104,    0,    0,   80,    0,
    0,    0,    0,    0,    0,    0,   46,   41,   47,   48,
   44,   42,    0,   45,    0,  111,  112,  114,  115,  113,
  116,    0,    0,  117,    0,   76,   79,   68,    0,   66,
   72,   74,   70,  129,    0,  128,    0,    0,    3,    0,
   92,   93,   94,  105,   95,   96,  106,  108,   97,    0,
  109,  107,   84,  110,    0,    0,   77,   81,   69,   67,
   73,   75,   71,  130,   50,    0,  118,  119,  121,  122,
  120,  123,   86,  124,    0,   82,    0,  127,   85,    0,
  125,   83,   87,  126,   98,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyDgoto']  = array(            20,
   64,   22,   80,   23,   65,   24,   25,   26,   27,   28,
   50,   51,   52,   53,   29,   30,   31,   32,   33,   34,
   54,   55,   56,   57,   58,   59,   62,   98,   63,   99,
   35,   94,  153,  122,   95,   96,  124,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yySindex'] = array(          231,
    0,    0,    0,  269,  684,   38,  721,  721,  721,  721,
  721,    0,    0,    0,    0,    0,  721,  -20,  -24,    0,
  355,    0,   76,    0,    0,  269,    0,    0,    0,    0,
    0,    0,    0,    0,  800,    0,   42,  684,  684,  684,
  684,  684,    0,    0,    0,    0,   18,    0,    0,  392,
    0,  269,    0,    0,    0,    0,    0,    0,    0,  770,
  721,  103,    0,  429,   73,  106,  138,   57,  153,   54,
  721,   -8,    0,    0,    0,    0,    0,  721,    0,   55,
    0,  269,    0,    0,    0,    0,  800,    0,  256,    0,
    0,    0,    0,   30,  800,    0,  684,  169,    0,  462,
  499,  536,  573,  610,    7,  108,    0,    0,    0,    0,
    0,    0,  269,    0,  770,    0,    0,    0,    0,    0,
    0,   -4,  770,    0,   69,    0,    0,    0,  721,    0,
    0,    0,    0,    0,  107,    0,  140,  107,    0,   30,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  187,
    0,    0,    0,    0,   30,  647,    0,    0,    0,    0,
    0,    0,    0,    0,    0,   -4,    0,    0,    0,    0,
    0,    0,    0,    0,   -4,    0,  429,    0,    0,  170,
    0,    0,    0,    0,    0,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyRindex'] = array(            0,
    0,    0,    0,    0,    0,    0,   74,  122,  195,   59,
  192,    0,    0,    0,    0,    0,  127,  206,    0,    0,
  209,    0,    0,    0,    0,  280,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,   88,
    0,  824,    0,    0,    0,    0,    0,    0,    0,    0,
   72,    0,    0,  190,    0,    0,    0,    0,    0,    0,
   39,    0,    0,    0,    0,    0,    0,   29,    0,  210,
    0,  318,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,   93,    0,    0,    0,    0,
    0,    0,  853,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  228,    0,    0,   45,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  741,    0,    0,    0,
    0,    0,    0,    0,    0,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyGindex'] = array(            0,
    3,   -1,    0,  184,  158,  -18,  -12,  -14,   16,   -3,
  145,  100,  -31,   51,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  173,  139,
   95,   53,    4,   90,  -17,  -77,  -98,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyTable'] = array(           167,
  145,  146,   21,   89,   86,   37,   82,   38,   81,   39,
   71,   40,   41,   42,   72,    5,  154,   84,  113,   79,
   49,   85,   92,  174,   43,  168,    5,  169,   11,  136,
  170,  137,   19,  144,  145,  146,   83,   89,    9,    6,
  164,    7,  123,    8,    7,    9,   10,   11,   61,   82,
   93,   81,   97,   49,   49,   49,   49,   49,   13,  147,
   84,  148,  154,   11,   11,  111,   19,  174,  113,  113,
  113,  113,  113,   11,   92,  120,  174,  154,  139,   83,
    7,  151,   92,  132,    5,   11,   86,  134,  129,  176,
   18,  129,   11,   11,  128,   11,   51,  123,   36,   60,
  114,   49,   93,  129,  123,  123,   11,  129,   11,  152,
   93,   18,   49,   61,  165,  111,  111,  111,  111,  111,
   87,   51,  126,   51,  113,  173,   49,  151,   49,  130,
  120,  177,   60,   60,   60,   60,   60,  171,  120,  140,
  129,  129,  151,  179,   60,   11,  115,  155,  123,  112,
  114,  114,  114,  114,  114,  152,   11,  123,  181,  121,
   11,   11,   82,  131,   81,   66,   67,   68,   69,  183,
  152,  111,  129,   84,   70,  185,   87,  178,  184,   97,
  133,  171,  100,  101,  102,  103,  104,  129,  157,   12,
  171,   60,   83,  180,   60,   60,   60,   60,   60,  112,
  112,  112,  112,  112,  166,    8,  114,  115,    1,    4,
   12,   12,  175,   12,  121,   12,   12,   12,  125,   11,
   11,  172,  121,   12,   12,   12,   11,   10,  135,   11,
  105,    1,    2,    3,  127,  138,  158,    4,    0,    5,
    6,  156,    7,    0,    8,    0,    9,   10,   11,   12,
   60,    0,  150,  149,    0,  112,  141,  142,  143,   13,
   14,   15,   16,   17,    0,  172,   18,   19,    0,    1,
    2,    3,    0,    0,  172,    4,    0,    0,    0,   18,
    0,    0,    0,    0,    0,    0,  150,  149,   18,   18,
    0,   18,    0,   18,    0,   18,   18,   18,   18,    0,
   18,   18,    0,   18,    0,   18,   18,   18,   18,   18,
   18,   18,   18,   18,   18,   18,   18,   26,    0,    0,
    0,    0,    0,    0,    0,    0,   26,   26,    0,   26,
    0,   26,    0,   26,   26,   26,   26,    0,   26,   26,
    0,   26,    0,   26,   26,   26,   26,   26,   26,   26,
   26,   26,   26,   26,   26,    1,    2,    3,    0,    0,
    0,    4,    0,   73,    6,    0,    7,    0,    8,    0,
    9,   10,   11,   74,    0,    0,    0,    0,    0,    0,
    0,    0,    0,   13,   75,   76,   77,   17,    0,   78,
   18,   19,    1,    2,    3,    0,    0,    0,    4,    0,
    0,   37,    0,   38,    0,   39,    0,   40,   41,   42,
  106,    0,    0,    0,    0,    0,    0,    0,    0,    0,
   43,  107,  108,  109,   47,    0,  110,    0,   19,    1,
    2,    3,    0,    0,    0,    4,    0,   73,    6,    0,
    7,    0,    8,    0,    9,   10,   11,   74,    0,    0,
    0,    0,    0,    0,    0,    0,    0,   13,   75,   76,
   77,   17,    1,    2,    3,   19,    0,    0,    4,    0,
    0,   37,    0,   38,    0,   39,    0,   40,   41,   42,
    0,    0,    0,  159,    0,    0,    0,    0,    0,    0,
   43,  107,  108,  109,   47,    0,  110,    0,   19,    1,
    2,    3,    0,    0,    0,    4,    0,    0,   37,    0,
   38,    0,   39,    0,   40,   41,   42,    0,    0,    0,
    0,    0,  160,    0,    0,    0,    0,   43,  107,  108,
  109,   47,    0,  110,    0,   19,    1,    2,    3,    0,
    0,    0,    4,    0,    0,   37,    0,   38,    0,   39,
    0,   40,   41,   42,    0,    0,    0,    0,    0,    0,
    0,  161,    0,    0,   43,  107,  108,  109,   47,    0,
  110,    0,   19,    1,    2,    3,    0,    0,    0,    4,
    0,    0,   37,    0,   38,    0,   39,    0,   40,   41,
   42,    0,    0,    0,    0,    0,    0,    0,    0,  162,
    0,   43,  107,  108,  109,   47,    0,  110,    0,   19,
    1,    2,    3,    0,    0,    0,    4,    0,    0,   37,
    0,   38,    0,   39,    0,   40,   41,   42,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  163,   43,  107,
  108,  109,   47,    0,  110,    0,   19,    1,    2,    3,
    0,    0,    0,    4,    0,    0,   37,    0,   38,    0,
   39,    0,   40,   41,   42,    0,    0,  182,    0,    0,
    0,    0,    0,    0,    0,   43,  107,  108,  109,   47,
    0,  110,    0,   19,    1,    2,    3,    0,    0,    0,
    4,    0,    0,   37,    0,   38,    0,   39,    0,   40,
   41,   42,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,   43,   44,   45,   46,   47,    0,   48,    0,
   19,    1,    2,    3,    0,    0,    0,    4,    0,    0,
    6,    0,    7,    0,    8,    0,    9,   10,   11,   12,
   13,    0,    0,    0,    0,    0,    0,    0,    0,   13,
   14,   15,   16,   17,    0,    0,    0,   19,    0,    0,
    0,   13,   13,    0,   13,    0,   13,   13,   13,    0,
    0,    0,    0,  116,   13,   13,   13,   89,    0,   37,
    0,   38,    0,   39,    0,   40,   41,   42,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,   43,  117,
    0,  118,    0,   88,  119,    0,   19,   89,    0,    6,
    0,    7,    0,    8,    0,    9,   10,   11,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,   13,   90,
    0,   91,   35,   35,    0,   35,   19,   35,    0,   35,
   35,   35,   35,    0,   35,   35,    0,   35,    0,   35,
   35,   35,   35,   35,   35,   35,   35,   35,   35,   35,
   35,   43,   43,    0,   43,    0,   43,    0,   43,   43,
   43,   43,    0,   43,   43,    0,   43,    0,   43,   43,
   43,   43,   43,   43,   43,   43,   43,   43,   43,   43,
  );
 $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyCheck'] = array(             4,
    5,    6,    0,    8,   23,   10,   21,   12,   21,   14,
   31,   16,   17,   18,   39,    9,   94,   21,   50,   21,
    5,   23,   35,  122,   29,   30,    9,   32,    0,   38,
   35,   40,   37,    4,    5,    6,   21,    8,    0,   10,
   34,   12,   60,   14,    0,   16,   17,   18,   11,   64,
   35,   64,   11,   38,   39,   40,   41,   42,   29,   30,
   64,   32,  140,   35,   36,   50,   37,  166,  100,  101,
  102,  103,  104,   35,   87,   60,  175,  155,   80,   64,
   36,   94,   95,   27,    9,   27,  105,   34,   35,   21,
   36,   35,   21,   35,   22,   22,    9,  115,    4,    5,
   50,    9,   87,   35,  122,  123,   35,   35,   35,   94,
   95,   36,   97,   11,    7,  100,  101,  102,  103,  104,
   26,   34,   20,   36,  156,  122,   34,  140,   36,   24,
  115,  129,   38,   39,   40,   41,   42,  122,  123,   87,
   35,   35,  155,  140,   50,   24,   52,   95,  166,   50,
  100,  101,  102,  103,  104,  140,   35,  175,  155,   60,
   34,   35,  177,   26,  177,    8,    9,   10,   11,  166,
  155,  156,   35,  177,   17,    6,   82,   38,  175,   11,
   28,  166,   38,   39,   40,   41,   42,   35,   20,    0,
  175,   97,  177,    7,  100,  101,  102,  103,  104,  100,
  101,  102,  103,  104,  115,    0,  156,  113,    0,    0,
   21,   22,  123,   24,  115,   26,   27,   28,   61,   28,
   26,  122,  123,   34,   35,   36,   35,    0,   71,   35,
   47,    1,    2,    3,   62,   78,   98,    7,   -1,    9,
   10,   97,   12,   -1,   14,   -1,   16,   17,   18,   19,
  156,   -1,  257,  258,   -1,  156,    1,    2,    3,   29,
   30,   31,   32,   33,   -1,  166,   36,   37,   -1,    1,
    2,    3,   -1,   -1,  175,    7,   -1,   -1,   -1,    0,
   -1,   -1,   -1,   -1,   -1,   -1,  257,  258,    9,   10,
   -1,   12,   -1,   14,   -1,   16,   17,   18,   19,   -1,
   21,   22,   -1,   24,   -1,   26,   27,   28,   29,   30,
   31,   32,   33,   34,   35,   36,   37,    0,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,    9,   10,   -1,   12,
   -1,   14,   -1,   16,   17,   18,   19,   -1,   21,   22,
   -1,   24,   -1,   26,   27,   28,   29,   30,   31,   32,
   33,   34,   35,   36,   37,    1,    2,    3,   -1,   -1,
   -1,    7,   -1,    9,   10,   -1,   12,   -1,   14,   -1,
   16,   17,   18,   19,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   29,   30,   31,   32,   33,   -1,   35,
   36,   37,    1,    2,    3,   -1,   -1,   -1,    7,   -1,
   -1,   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,
   19,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   29,   30,   31,   32,   33,   -1,   35,   -1,   37,    1,
    2,    3,   -1,   -1,   -1,    7,   -1,    9,   10,   -1,
   12,   -1,   14,   -1,   16,   17,   18,   19,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,   31,
   32,   33,    1,    2,    3,   37,   -1,   -1,    7,   -1,
   -1,   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,
   -1,   -1,   -1,   22,   -1,   -1,   -1,   -1,   -1,   -1,
   29,   30,   31,   32,   33,   -1,   35,   -1,   37,    1,
    2,    3,   -1,   -1,   -1,    7,   -1,   -1,   10,   -1,
   12,   -1,   14,   -1,   16,   17,   18,   -1,   -1,   -1,
   -1,   -1,   24,   -1,   -1,   -1,   -1,   29,   30,   31,
   32,   33,   -1,   35,   -1,   37,    1,    2,    3,   -1,
   -1,   -1,    7,   -1,   -1,   10,   -1,   12,   -1,   14,
   -1,   16,   17,   18,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   26,   -1,   -1,   29,   30,   31,   32,   33,   -1,
   35,   -1,   37,    1,    2,    3,   -1,   -1,   -1,    7,
   -1,   -1,   10,   -1,   12,   -1,   14,   -1,   16,   17,
   18,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   27,
   -1,   29,   30,   31,   32,   33,   -1,   35,   -1,   37,
    1,    2,    3,   -1,   -1,   -1,    7,   -1,   -1,   10,
   -1,   12,   -1,   14,   -1,   16,   17,   18,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   28,   29,   30,
   31,   32,   33,   -1,   35,   -1,   37,    1,    2,    3,
   -1,   -1,   -1,    7,   -1,   -1,   10,   -1,   12,   -1,
   14,   -1,   16,   17,   18,   -1,   -1,   21,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   29,   30,   31,   32,   33,
   -1,   35,   -1,   37,    1,    2,    3,   -1,   -1,   -1,
    7,   -1,   -1,   10,   -1,   12,   -1,   14,   -1,   16,
   17,   18,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   29,   30,   31,   32,   33,   -1,   35,   -1,
   37,    1,    2,    3,   -1,   -1,   -1,    7,   -1,   -1,
   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,   19,
    0,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,
   30,   31,   32,   33,   -1,   -1,   -1,   37,   -1,   -1,
   -1,   21,   22,   -1,   24,   -1,   26,   27,   28,   -1,
   -1,   -1,   -1,    4,   34,   35,   36,    8,   -1,   10,
   -1,   12,   -1,   14,   -1,   16,   17,   18,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,
   -1,   32,   -1,    4,   35,   -1,   37,    8,   -1,   10,
   -1,   12,   -1,   14,   -1,   16,   17,   18,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,
   -1,   32,    9,   10,   -1,   12,   37,   14,   -1,   16,
   17,   18,   19,   -1,   21,   22,   -1,   24,   -1,   26,
   27,   28,   29,   30,   31,   32,   33,   34,   35,   36,
   37,    9,   10,   -1,   12,   -1,   14,   -1,   16,   17,
   18,   19,   -1,   21,   22,   -1,   24,   -1,   26,   27,
   28,   29,   30,   31,   32,   33,   34,   35,   36,   37,
  );

  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyFinal'] = 20;
$GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyRule'] = array(
   "\$accept :  docblock ",
    "docblock :  paragraph ",
    "docblock :  paragraph   tags ",
    "docblock :  paragraph   text   tags ",
    "docblock :  paragraph   text ",
    "docblock :  paragraphs_with_p   tags ",
    "docblock :  tags ",
    "text :  T_DOUBLE_NL   paragraphs ",
    "tags :  T_TAG ",
    "tags :  T_TAG   T_TEXT ",
    "tags :  T_TAG   T_TEXT   paragraphs ",
    "paragraphs :",
    "paragraphs :  paragraph ",
    "paragraphs :  paragraphs   T_DOUBLE_NL   paragraph ",
    "paragraphs_with_p :  paragraph_with_p ",
    "paragraphs_with_p :  paragraphs_with_p   paragraph_with_p ",
    "paragraph :  T_TEXT ",
    "paragraph :  htmltag ",
    "paragraph :  simplelist ",
    "paragraph :  inlinetag ",
    "paragraph :  internaltag ",
    "paragraph :  T_ESCAPED_TAG ",
    "paragraph :  T_CLOSE_P ",
    "paragraph :  T_INLINE_ESC ",
    "paragraph :  paragraph   T_TEXT ",
    "paragraph :  paragraph   htmltag ",
    "paragraph :  paragraph   simplelist ",
    "paragraph :  paragraph   inlinetag ",
    "paragraph :  paragraph   T_ESCAPED_TAG ",
    "paragraph :  paragraph   T_OPEN_P ",
    "paragraph :  paragraph   T_CLOSE_P ",
    "paragraph :  paragraph   T_INLINE_ESC ",
    "paragraph :  paragraph   internaltag ",
    "text_expr_with_p :  T_TEXT ",
    "text_expr_with_p :  htmltag_with_p ",
    "text_expr_with_p :  simplelist_with_p ",
    "text_expr_with_p :  inlinetag ",
    "text_expr_with_p :  internaltag_with_p ",
    "text_expr_with_p :  T_ESCAPED_TAG ",
    "text_expr_with_p :  T_INLINE_ESC ",
    "text_expr_with_p :  T_DOUBLE_NL ",
    "text_expr_with_p :  text_expr_with_p   T_TEXT ",
    "text_expr_with_p :  text_expr_with_p   htmltag_with_p ",
    "text_expr_with_p :  text_expr_with_p   simplelist_with_p ",
    "text_expr_with_p :  text_expr_with_p   inlinetag ",
    "text_expr_with_p :  text_expr_with_p   internaltag_with_p ",
    "text_expr_with_p :  text_expr_with_p   T_ESCAPED_TAG ",
    "text_expr_with_p :  text_expr_with_p   T_INLINE_ESC ",
    "text_expr_with_p :  text_expr_with_p   T_DOUBLE_NL ",
    "paragraph_with_p :  T_OPEN_P   text_expr_with_p   T_CLOSE_P ",
    "paragraph_with_p :  T_OPEN_P   text_expr_with_p   T_CLOSE_P   T_WHITESPACE ",
    "paragraph_with_p :  T_OPEN_P   text_expr_with_p ",
    "htmltag :  T_XML_TAG ",
    "htmltag :  btag ",
    "htmltag :  codetag ",
    "htmltag :  samptag ",
    "htmltag :  kbdtag ",
    "htmltag :  vartag ",
    "htmltag :  htmllist ",
    "htmltag_with_p :  T_XML_TAG ",
    "htmltag_with_p :  btag_with_p ",
    "htmltag_with_p :  codetag_with_p ",
    "htmltag_with_p :  samptag_with_p ",
    "htmltag_with_p :  kbdtag_with_p ",
    "htmltag_with_p :  vartag_with_p ",
    "htmltag_with_p :  htmllist_with_p ",
    "btag :  T_OPEN_B   paragraphs   T_CLOSE_B ",
    "btag_with_p :  T_OPEN_B   text_expr_with_p   T_CLOSE_B ",
    "codetag :  T_OPEN_CODE   paragraphs   T_CLOSE_CODE ",
    "codetag_with_p :  T_OPEN_CODE   text_expr_with_p   T_CLOSE_CODE ",
    "samptag :  T_OPEN_SAMP   paragraphs   T_CLOSE_SAMP ",
    "samptag_with_p :  T_OPEN_SAMP   text_expr_with_p   T_CLOSE_SAMP ",
    "kbdtag :  T_OPEN_KBD   paragraphs   T_CLOSE_KBD ",
    "kbdtag_with_p :  T_OPEN_KBD   text_expr_with_p   T_CLOSE_KBD ",
    "vartag :  T_OPEN_VAR   paragraphs   T_CLOSE_VAR ",
    "vartag_with_p :  T_OPEN_VAR   text_expr_with_p   T_CLOSE_VAR ",
    "htmllist :  T_OPEN_LIST   listitems   T_CLOSE_LIST ",
    "htmllist_with_p :  T_OPEN_LIST   listitems_with_p   T_CLOSE_LIST ",
    "listitems :  listitem ",
    "listitems :  listitems   listitem ",
    "listitems_with_p :  listitem_with_p ",
    "listitems_with_p :  listitems_with_p   listitem_with_p ",
    "listitem :  T_OPEN_LI   paragraphs   T_CLOSE_LI ",
    "listitem_with_p :  T_OPEN_LI   text_expr_with_p   T_CLOSE_LI ",
    "simplelist :  bullet   simplelist_contents   simplelistend ",
    "simplelist :  simplelist   bullet   simplelist_contents   simplelistend ",
    "simplelist_with_p :  bullet   simplelist_contents_with_p   simplelistend ",
    "simplelist_with_p :  simplelist_with_p   bullet   simplelist_contents_with_p   simplelistend ",
    "bullet :  T_BULLET ",
    "bullet :  T_NBULLET ",
    "bullet :  T_NDBULLET ",
    "bullet :  T_WHITESPACE   bullet ",
    "nested_bullet :  T_NESTED_WHITESPACE   T_BULLET ",
    "nested_bullet :  T_NESTED_WHITESPACE   T_NBULLET ",
    "nested_bullet :  T_NESTED_WHITESPACE   T_NDBULLET ",
    "simplelistend :  T_SIMPLELIST_NL ",
    "simplelistend :  T_SIMPLELIST_END ",
    "simplelistend :  EOF ",
    "simplelistend :  T_SIMPLELIEST_NL   T_WHITESPACE   T_SIMPLELIST_END ",
    "simplelist_contents :  T_SIMPLELIST ",
    "simplelist_contents :  T_ESCAPED_TAG ",
    "simplelist_contents :  inlinetag ",
    "simplelist_contents :  T_INLINE_ESC ",
    "simplelist_contents :  htmltag ",
    "simplelist_contents :  nested_simplelist ",
    "simplelist_contents :  simplelist_contents   T_SIMPLELIST ",
    "simplelist_contents :  simplelist_contents   T_ESCAPED_TAG ",
    "simplelist_contents :  simplelist_contents   inlinetag ",
    "simplelist_contents :  simplelist_contents   T_INLINE_ESC ",
    "simplelist_contents :  simplelist_contents   htmltag ",
    "simplelist_contents :  simplelist_contents   nested_simplelist ",
    "simplelist_contents_with_p :  T_SIMPLELIST ",
    "simplelist_contents_with_p :  T_ESCAPED_TAG ",
    "simplelist_contents_with_p :  inlinetag ",
    "simplelist_contents_with_p :  T_INLINE_ESC ",
    "simplelist_contents_with_p :  T_DOUBLE_NL ",
    "simplelist_contents_with_p :  htmltag_with_p ",
    "simplelist_contents_with_p :  nested_simplelist_with_p ",
    "simplelist_contents_with_p :  simplelist_contents_with_p   T_SIMPLELIST ",
    "simplelist_contents_with_p :  simplelist_contents_with_p   T_ESCAPED_TAG ",
    "simplelist_contents_with_p :  simplelist_contents_with_p   inlinetag ",
    "simplelist_contents_with_p :  simplelist_contents_with_p   T_INLINE_ESC ",
    "simplelist_contents_with_p :  simplelist_contents_with_p   T_DOUBLE_NL ",
    "simplelist_contents_with_p :  simplelist_contents_with_p   htmltag_with_p ",
    "simplelist_contents_with_p :  simplelist_contents_with_p   nested_simplelist_with_p ",
    "nested_simplelist :  nested_bullet   simplelist_contents   simplelistend ",
    "nested_simplelist_with_p :  nested_bullet   simplelist_contents_with_p   simplelistend ",
    "inlinetag :  T_INLINE_TAG_OPEN   T_INLINE_TAG_NAME   T_INLINE_TAG_CONTENTS   T_INLINE_TAG_CLOSE ",
    "inlinetag :  T_INLINE_TAG_OPEN   T_INLINE_TAG_NAME   T_INLINE_TAG_CLOSE ",
    "internaltag :  T_INTERNAL   paragraphs   T_ENDINTERNAL ",
    "internaltag_with_p :  T_INTERNAL   paragraphs_with_p   T_ENDINTERNAL ",
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyName'] =array(    
    "end-of-file","T_BULLET","T_NBULLET","T_NDBULLET","T_SIMPLELIST",
    "T_SIMPLELIST_NL","T_SIMPLELIST_END","T_WHITESPACE",
    "T_NESTED_WHITESPACE","T_OPEN_P","T_OPEN_LIST","T_OPEN_LI",
    "T_OPEN_CODE","T_OPEN_PRE","T_OPEN_B","T_OPEN_I","T_OPEN_KBD",
    "T_OPEN_VAR","T_OPEN_SAMP","T_CLOSE_P","T_CLOSE_LIST","T_CLOSE_LI",
    "T_CLOSE_CODE","T_CLOSE_PRE","T_CLOSE_B","T_CLOSE_I","T_CLOSE_KBD",
    "T_CLOSE_VAR","T_CLOSE_SAMP","T_XML_TAG","T_ESCAPED_TAG","T_TEXT",
    "T_INLINE_ESC","T_INTERNAL","T_ENDINTERNAL","T_DOUBLE_NL","T_TAG",
    "T_INLINE_TAG_OPEN","T_INLINE_TAG_CLOSE","T_INLINE_TAG_NAME",
    "T_INLINE_TAG_CONTENTS",null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,null,null,null,
    null,null,null,null,null,null,null,null,null,null,null,
    "T_SIMPLELIEST_NL","EOF",
  );
 ?>
