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
     * @var PHP_Parser_Stack
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
        $this->_errorStack = &PHP_Parser_Stack::singleton('PHP_Parser_Docblock_Default');
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

    function _98($yyTop)  					// line 1033 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _99($yyTop)  					// line 1037 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array(str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]));
        }

    function _100($yyTop)  					// line 1041 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _101($yyTop)  					// line 1045 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _102($yyTop)  					// line 1055 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _103($yyTop)  					// line 1059 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _104($yyTop)  					// line 1063 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _105($yyTop)  					// line 1068 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _106($yyTop)  					// line 1077 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _107($yyTop)  					// line 1082 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _108($yyTop)  					// line 1098 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _109($yyTop)  					// line 1103 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _111($yyTop)  					// line 1112 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
        }

    function _112($yyTop)  					// line 1116 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _113($yyTop)  					// line 1120 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _114($yyTop)  					// line 1130 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _115($yyTop)  					// line 1134 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _116($yyTop)  					// line 1138 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _117($yyTop)  					// line 1142 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _118($yyTop)  					// line 1147 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _119($yyTop)  					// line 1157 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _120($yyTop)  					// line 1162 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _121($yyTop)  					// line 1179 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _122($yyTop)  					// line 1189 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _123($yyTop)  					// line 1194 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _124($yyTop)  					// line 1202 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _125($yyTop)  					// line 1209 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _126($yyTop)  					// line 1216 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->_parseInlineTag($this->yyVals[-2+$yyTop], $this->yyVals[-1+$yyTop]);
        }

    function _127($yyTop)  					// line 1220 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->_parseInlineTag($this->yyVals[-1+$yyTop], array());
        }

    function _128($yyTop)  					// line 1227 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->_options['parseInternal']) {
                $this->yyVal = $this->yyVals[-1+$yyTop];
            } else {
                $this->yyVal = '';
            }
        }

    function _129($yyTop)  					// line 1238 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->_options['parseInternal']) {
                $this->yyVal = $this->yyVals[-1+$yyTop];
            } else {
                $this->yyVal = '';
            }
        }
					// line 1454 "-"

					// line 1246 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"

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
   31,   35,   35,   35,   33,   33,   33,   32,   32,   32,
   32,   32,   32,   32,   32,   32,   32,   32,   32,   34,
   34,   34,   34,   34,   34,   34,   34,   34,   34,   34,
   34,   34,   34,   36,   37,    9,    9,   10,   14,
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
    2,    2,    2,    2,    1,    1,    1,    1,    1,    1,
    1,    1,    1,    2,    2,    2,    2,    2,    2,    1,
    1,    1,    1,    1,    1,    1,    2,    2,    2,    2,
    2,    2,    2,    3,    3,    4,    3,    3,    3,
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
   25,    0,   27,   32,    5,   15,    0,   98,    0,   99,
  101,  102,  100,    0,    0,  103,    0,    0,   80,    0,
    0,    0,    0,    0,    0,    0,   46,   41,   47,   48,
   44,   42,    0,   45,    0,  110,  111,  113,  114,  112,
  115,    0,    0,  116,    0,   76,   79,   68,    0,   66,
   72,   74,   70,  128,    0,  127,    0,    0,    3,    0,
   92,   93,   94,  104,   95,   96,  105,  107,   97,  108,
  106,   84,  109,    0,    0,   77,   81,   69,   67,   73,
   75,   71,  129,   50,    0,  117,  118,  120,  121,  119,
  122,   86,  123,    0,   82,    0,  126,   85,  124,   83,
   87,  125,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyDgoto']  = array(            20,
   64,   22,   80,   23,   65,   24,   25,   26,   27,   28,
   50,   51,   52,   53,   29,   30,   31,   32,   33,   34,
   54,   55,   56,   57,   58,   59,   62,   98,   63,   99,
   35,   94,  152,  122,   95,   96,  124,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yySindex'] = array(          342,
    0,    0,    0,  255,  671,   82,  708,  708,  708,  708,
  708,    0,    0,    0,    0,    0,  708,   59,   73,    0,
  305,    0,   72,    0,    0,  255,    0,    0,    0,    0,
    0,    0,    0,    0,  803,    0,  119,  671,  671,  671,
  671,  671,    0,    0,    0,    0,  168,    0,    0,  379,
    0,  255,    0,    0,    0,    0,    0,    0,    0,  773,
  708,  152,    0,  416,   80,  102,  -15,   65,   79,   34,
  708,   -8,    0,    0,    0,    0,    0,  708,    0,  155,
    0,  255,    0,    0,    0,    0,  803,    0,   14,    0,
    0,    0,    0,   30,  803,    0,  671,  158,    0,  449,
  486,  523,  560,  597,   55,  190,    0,    0,    0,    0,
    0,    0,  255,    0,  773,    0,    0,    0,    0,    0,
    0,   -4,  773,    0,   18,    0,    0,    0,  708,    0,
    0,    0,    0,    0,  163,    0,  162,  163,    0,   30,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,   30,  634,    0,    0,    0,    0,    0,
    0,    0,    0,    0,   -4,    0,    0,    0,    0,    0,
    0,    0,    0,   -4,    0,  416,    0,    0,    0,    0,
    0,    0,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyRindex'] = array(            0,
    0,    0,    0,    0,    0,    0,  139,  125,  153,  185,
  147,    0,    0,    0,    0,    0,  123,  201,    0,    0,
  210,    0,    0,    0,    0,  213,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  159,
    0,  827,    0,    0,    0,    0,    0,    0,    0,    0,
   28,    0,    0,  728,    0,    0,    0,    0,    0,    0,
   43,    0,    0,    0,    0,    0,    0,  105,    0,  217,
    0,  268,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  180,    0,    0,    0,    0,
    0,    0,  856,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  221,    0,    0,    5,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  744,    0,    0,    0,    0,
    0,    0,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyGindex'] = array(            0,
    3,    6,    0,  177,  194,    1,  -12,  -14,   16,   -3,
   32,   44,   -5,   51,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  164,  135,
   83,  120,   54,  136,  -38,  -75,  -31,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyTable'] = array(           166,
  145,  146,   21,   89,    7,   37,   82,   38,   81,   39,
  131,   40,   41,   42,  141,  142,  143,   84,  153,  129,
   49,  123,   92,   86,   43,  167,   79,  168,   85,  136,
  169,  137,   19,  144,  145,  146,   83,   89,  175,    6,
    7,    7,    9,    8,  113,    9,   10,   11,   11,   82,
   93,   81,  129,   49,   49,   49,   49,   49,   13,  147,
   84,  148,   11,    5,  153,  111,   19,  134,  129,  100,
  101,  102,  103,  104,   92,  120,  123,   11,  153,   83,
    5,  150,   92,  123,  123,  139,   36,   60,  163,   71,
  173,  132,   61,  112,  113,  113,  113,  113,  113,  129,
  114,  128,   93,  121,   11,   86,  133,   18,   87,  151,
   93,   72,   49,  129,  129,  111,  111,  111,  111,  111,
   60,   60,   60,   60,   60,  130,  123,  150,  155,   97,
  120,  176,   60,  173,  115,  123,  129,  170,  120,   11,
   11,  150,  173,  112,  112,  112,  112,  112,   11,  113,
  114,  114,  114,  114,  114,  151,   11,   11,  121,   11,
   11,   82,   61,   81,   87,  171,  121,   51,   97,  151,
  111,  126,   84,   11,   11,  172,    5,  156,   11,   60,
  170,   11,   60,   60,   60,   60,   60,   11,   49,  170,
   18,   83,   51,  178,   51,  115,  164,  129,  112,  177,
    8,   66,   67,   68,   69,  114,  140,  179,  171,    1,
   70,   11,   18,   49,  154,   49,    4,  171,  181,   11,
   10,   18,   18,  105,   18,  127,   18,  182,   18,   18,
   18,   18,  157,   18,   18,    0,   18,   60,   18,   18,
   18,   18,   18,   18,   18,   18,   18,   18,   18,   18,
  165,    0,    0,  149,  125,    1,    2,    3,  174,    0,
    0,    4,    0,    0,  135,    0,    0,   26,    0,    0,
    0,  138,    0,    0,    0,    0,   26,   26,    0,   26,
    0,   26,    0,   26,   26,   26,   26,  149,   26,   26,
    0,   26,    0,   26,   26,   26,   26,   26,   26,   26,
   26,   26,   26,   26,   26,    1,    2,    3,    0,    0,
    0,    4,    0,   73,    6,    0,    7,    0,    8,    0,
    9,   10,   11,   74,    0,    0,    0,    0,    0,    0,
    0,    0,    0,   13,   75,   76,   77,   17,    0,   78,
   18,   19,    1,    2,    3,    0,    0,    0,    4,    0,
    5,    6,    0,    7,    0,    8,    0,    9,   10,   11,
   12,    0,    0,    0,    0,    0,    0,    0,    0,    0,
   13,   14,   15,   16,   17,    0,    0,   18,   19,    1,
    2,    3,    0,    0,    0,    4,    0,    0,   37,    0,
   38,    0,   39,    0,   40,   41,   42,  106,    0,    0,
    0,    0,    0,    0,    0,    0,    0,   43,  107,  108,
  109,   47,    0,  110,    0,   19,    1,    2,    3,    0,
    0,    0,    4,    0,   73,    6,    0,    7,    0,    8,
    0,    9,   10,   11,   74,    0,    0,    0,    0,    0,
    0,    0,    0,    0,   13,   75,   76,   77,   17,    1,
    2,    3,   19,    0,    0,    4,    0,    0,   37,    0,
   38,    0,   39,    0,   40,   41,   42,    0,    0,    0,
  158,    0,    0,    0,    0,    0,    0,   43,  107,  108,
  109,   47,    0,  110,    0,   19,    1,    2,    3,    0,
    0,    0,    4,    0,    0,   37,    0,   38,    0,   39,
    0,   40,   41,   42,    0,    0,    0,    0,    0,  159,
    0,    0,    0,    0,   43,  107,  108,  109,   47,    0,
  110,    0,   19,    1,    2,    3,    0,    0,    0,    4,
    0,    0,   37,    0,   38,    0,   39,    0,   40,   41,
   42,    0,    0,    0,    0,    0,    0,    0,  160,    0,
    0,   43,  107,  108,  109,   47,    0,  110,    0,   19,
    1,    2,    3,    0,    0,    0,    4,    0,    0,   37,
    0,   38,    0,   39,    0,   40,   41,   42,    0,    0,
    0,    0,    0,    0,    0,    0,  161,    0,   43,  107,
  108,  109,   47,    0,  110,    0,   19,    1,    2,    3,
    0,    0,    0,    4,    0,    0,   37,    0,   38,    0,
   39,    0,   40,   41,   42,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  162,   43,  107,  108,  109,   47,
    0,  110,    0,   19,    1,    2,    3,    0,    0,    0,
    4,    0,    0,   37,    0,   38,    0,   39,    0,   40,
   41,   42,    0,    0,  180,    0,    0,    0,    0,    0,
    0,    0,   43,  107,  108,  109,   47,    0,  110,    0,
   19,    1,    2,    3,    0,    0,    0,    4,    0,    0,
   37,    0,   38,    0,   39,    0,   40,   41,   42,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,   43,
   44,   45,   46,   47,    0,   48,    0,   19,    1,    2,
    3,    0,    0,    0,    4,    0,    0,    6,    0,    7,
    0,    8,    0,    9,   10,   11,   12,   12,    0,    0,
    0,    0,    0,    0,    0,    0,   13,   14,   15,   16,
   17,    0,    0,   13,   19,    0,    0,    0,   12,   12,
    0,   12,    0,   12,   12,   12,    0,    0,    0,    0,
    0,   12,   12,   12,   13,   13,    0,   13,    0,   13,
   13,   13,    0,    0,    0,    0,  116,   13,   13,   13,
   89,    0,   37,    0,   38,    0,   39,    0,   40,   41,
   42,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,   43,  117,    0,  118,    0,   88,  119,    0,   19,
   89,    0,    6,    0,    7,    0,    8,    0,    9,   10,
   11,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,   13,   90,    0,   91,   35,   35,    0,   35,   19,
   35,    0,   35,   35,   35,   35,    0,   35,   35,    0,
   35,    0,   35,   35,   35,   35,   35,   35,   35,   35,
   35,   35,   35,   35,   43,   43,    0,   43,    0,   43,
    0,   43,   43,   43,   43,    0,   43,   43,    0,   43,
    0,   43,   43,   43,   43,   43,   43,   43,   43,   43,
   43,   43,   43,
  );
 $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyCheck'] = array(             4,
    5,    6,    0,    8,    0,   10,   21,   12,   21,   14,
   26,   16,   17,   18,    1,    2,    3,   21,   94,   35,
    5,   60,   35,   23,   29,   30,   21,   32,   23,   38,
   35,   40,   37,    4,    5,    6,   21,    8,   21,   10,
   36,   12,    0,   14,   50,   16,   17,   18,   21,   64,
   35,   64,   35,   38,   39,   40,   41,   42,   29,   30,
   64,   32,   35,    9,  140,   50,   37,   34,   35,   38,
   39,   40,   41,   42,   87,   60,  115,   35,  154,   64,
    9,   94,   95,  122,  123,   80,    4,    5,   34,   31,
  122,   27,   11,   50,  100,  101,  102,  103,  104,   35,
   50,   22,   87,   60,    0,  105,   28,   36,   26,   94,
   95,   39,   97,   35,   35,  100,  101,  102,  103,  104,
   38,   39,   40,   41,   42,   24,  165,  140,   97,   11,
  115,  129,   50,  165,   52,  174,   35,  122,  123,   35,
   36,  154,  174,  100,  101,  102,  103,  104,   24,  155,
  100,  101,  102,  103,  104,  140,   34,   35,  115,   35,
   22,  176,   11,  176,   82,  122,  123,    9,   11,  154,
  155,   20,  176,   35,   28,  122,    9,   20,   26,   97,
  165,   35,  100,  101,  102,  103,  104,   35,    9,  174,
   36,  176,   34,  140,   36,  113,    7,   35,  155,   38,
    0,    8,    9,   10,   11,  155,   87,  154,  165,    0,
   17,   27,    0,   34,   95,   36,    0,  174,  165,   35,
    0,    9,   10,   47,   12,   62,   14,  174,   16,   17,
   18,   19,   98,   21,   22,   -1,   24,  155,   26,   27,
   28,   29,   30,   31,   32,   33,   34,   35,   36,   37,
  115,   -1,   -1,  258,   61,    1,    2,    3,  123,   -1,
   -1,    7,   -1,   -1,   71,   -1,   -1,    0,   -1,   -1,
   -1,   78,   -1,   -1,   -1,   -1,    9,   10,   -1,   12,
   -1,   14,   -1,   16,   17,   18,   19,  258,   21,   22,
   -1,   24,   -1,   26,   27,   28,   29,   30,   31,   32,
   33,   34,   35,   36,   37,    1,    2,    3,   -1,   -1,
   -1,    7,   -1,    9,   10,   -1,   12,   -1,   14,   -1,
   16,   17,   18,   19,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   29,   30,   31,   32,   33,   -1,   35,
   36,   37,    1,    2,    3,   -1,   -1,   -1,    7,   -1,
    9,   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,
   19,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   29,   30,   31,   32,   33,   -1,   -1,   36,   37,    1,
    2,    3,   -1,   -1,   -1,    7,   -1,   -1,   10,   -1,
   12,   -1,   14,   -1,   16,   17,   18,   19,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,   31,
   32,   33,   -1,   35,   -1,   37,    1,    2,    3,   -1,
   -1,   -1,    7,   -1,    9,   10,   -1,   12,   -1,   14,
   -1,   16,   17,   18,   19,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   29,   30,   31,   32,   33,    1,
    2,    3,   37,   -1,   -1,    7,   -1,   -1,   10,   -1,
   12,   -1,   14,   -1,   16,   17,   18,   -1,   -1,   -1,
   22,   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,   31,
   32,   33,   -1,   35,   -1,   37,    1,    2,    3,   -1,
   -1,   -1,    7,   -1,   -1,   10,   -1,   12,   -1,   14,
   -1,   16,   17,   18,   -1,   -1,   -1,   -1,   -1,   24,
   -1,   -1,   -1,   -1,   29,   30,   31,   32,   33,   -1,
   35,   -1,   37,    1,    2,    3,   -1,   -1,   -1,    7,
   -1,   -1,   10,   -1,   12,   -1,   14,   -1,   16,   17,
   18,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   26,   -1,
   -1,   29,   30,   31,   32,   33,   -1,   35,   -1,   37,
    1,    2,    3,   -1,   -1,   -1,    7,   -1,   -1,   10,
   -1,   12,   -1,   14,   -1,   16,   17,   18,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   27,   -1,   29,   30,
   31,   32,   33,   -1,   35,   -1,   37,    1,    2,    3,
   -1,   -1,   -1,    7,   -1,   -1,   10,   -1,   12,   -1,
   14,   -1,   16,   17,   18,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   28,   29,   30,   31,   32,   33,
   -1,   35,   -1,   37,    1,    2,    3,   -1,   -1,   -1,
    7,   -1,   -1,   10,   -1,   12,   -1,   14,   -1,   16,
   17,   18,   -1,   -1,   21,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   29,   30,   31,   32,   33,   -1,   35,   -1,
   37,    1,    2,    3,   -1,   -1,   -1,    7,   -1,   -1,
   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,
   30,   31,   32,   33,   -1,   35,   -1,   37,    1,    2,
    3,   -1,   -1,   -1,    7,   -1,   -1,   10,   -1,   12,
   -1,   14,   -1,   16,   17,   18,   19,    0,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,   31,   32,
   33,   -1,   -1,    0,   37,   -1,   -1,   -1,   21,   22,
   -1,   24,   -1,   26,   27,   28,   -1,   -1,   -1,   -1,
   -1,   34,   35,   36,   21,   22,   -1,   24,   -1,   26,
   27,   28,   -1,   -1,   -1,   -1,    4,   34,   35,   36,
    8,   -1,   10,   -1,   12,   -1,   14,   -1,   16,   17,
   18,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   29,   30,   -1,   32,   -1,    4,   35,   -1,   37,
    8,   -1,   10,   -1,   12,   -1,   14,   -1,   16,   17,
   18,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   29,   30,   -1,   32,    9,   10,   -1,   12,   37,
   14,   -1,   16,   17,   18,   19,   -1,   21,   22,   -1,
   24,   -1,   26,   27,   28,   29,   30,   31,   32,   33,
   34,   35,   36,   37,    9,   10,   -1,   12,   -1,   14,
   -1,   16,   17,   18,   19,   -1,   21,   22,   -1,   24,
   -1,   26,   27,   28,   29,   30,   31,   32,   33,   34,
   35,   36,   37,
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
    null,null,null,null,null,null,null,null,null,null,null,null,"EOF",
  );
 ?>
