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
     * @var MsgServer
     */
    var $_server;
    
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
        //$this->_server = &MsgServer::getServer();
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
        return PHP_Parser_Stack::staticPush('PHP_Parser_Docblock_Default',
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
            $this->_server->sendMessage(PHPDOCUMENTOR_PARSED_DOCTEMPLATE, $parsed_docs);
        } else {
            if (!isset($options['tagdesc'])) {
                $this->_server->sendMessage(PHPDOCUMENTOR_PARSED_DOCBLOCK, $parsed_docs);
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
					// line 384 "-"

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


    function _1($yyTop)  					// line 424 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->paragraphs = array($this->yyVals[0+$yyTop]);
        }

    function _2($yyTop)  					// line 428 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->paragraphs = $this->yyVals[-1+$yyTop];
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _3($yyTop)  					// line 433 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            array_unshift($this->yyVals[-1+$yyTop], $this->yyVals[-2+$yyTop]);
            $this->paragraphs = $this->yyVals[-1+$yyTop];
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _4($yyTop)  					// line 439 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            array_unshift($this->yyVals[0+$yyTop], $this->yyVals[-1+$yyTop]);
            $this->paragraphs = $this->yyVals[0+$yyTop];
        }

    function _5($yyTop)  					// line 444 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->paragraphs = $this->yyVals[-1+$yyTop];
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _6($yyTop)  					// line 449 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _7($yyTop)  					// line 457 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
        $this->yyVal = $this->yyVals[0+$yyTop];
    }

    function _8($yyTop)  					// line 464 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->tags[] = $this->_parseTag($this->yyVals[0+$yyTop], array());
        }

    function _9($yyTop)  					// line 468 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->tags[] = $this->_parseTag($this->yyVals[-1+$yyTop], $this->yyVals[0+$yyTop]);
        }

    function _10($yyTop)  					// line 472 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if (is_string($this->yyVals[0+$yyTop][0])) {
                $this->yyVals[0+$yyTop][0] = $this->yyVals[-1+$yyTop] . $this->yyVals[0+$yyTop][0];
            }
            $this->tags[] = $this->_parseTag($this->yyVals[-2+$yyTop], $this->yyVals[0+$yyTop]);
        }

    function _12($yyTop)  					// line 482 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _13($yyTop)  					// line 486 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _14($yyTop)  					// line 494 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _15($yyTop)  					// line 498 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _16($yyTop)  					// line 506 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _17($yyTop)  					// line 510 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _18($yyTop)  					// line 514 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _19($yyTop)  					// line 518 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _20($yyTop)  					// line 522 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _21($yyTop)  					// line 526 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
        }

    function _22($yyTop)  					// line 530 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _23($yyTop)  					// line 534 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _24($yyTop)  					// line 544 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _25($yyTop)  					// line 548 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _26($yyTop)  					// line 558 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _27($yyTop)  					// line 563 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _28($yyTop)  					// line 568 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _29($yyTop)  					// line 573 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _30($yyTop)  					// line 583 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _31($yyTop)  					// line 593 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _32($yyTop)  					// line 603 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _33($yyTop)  					// line 620 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _34($yyTop)  					// line 630 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _35($yyTop)  					// line 638 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _36($yyTop)  					// line 642 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _37($yyTop)  					// line 646 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _38($yyTop)  					// line 650 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _39($yyTop)  					// line 654 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _40($yyTop)  					// line 658 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
        }

    function _41($yyTop)  					// line 662 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _42($yyTop)  					// line 672 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _43($yyTop)  					// line 676 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _44($yyTop)  					// line 686 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
         }

    function _45($yyTop)  					// line 691 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _46($yyTop)  					// line 696 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _47($yyTop)  					// line 701 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _48($yyTop)  					// line 706 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _49($yyTop)  					// line 716 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _50($yyTop)  					// line 732 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _51($yyTop)  					// line 745 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _52($yyTop)  					// line 749 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
        }

    function _53($yyTop)  					// line 753 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[0+$yyTop];
        }

    function _54($yyTop)  					// line 760 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['completeTagClass'];
            if ($tag) {
                $this->yyVal = array(new $tag($this->yyVals[0+$yyTop]));
            } else {
                $this->yyVal = array(array('completetag' => $this->yyVals[0+$yyTop]));
            }
        }

    function _61($yyTop)  					// line 778 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['completeTagClass'];
            if ($tag) {
                $this->yyVal = array(new $tag($this->yyVals[0+$yyTop]));
            } else {
                $this->yyVal = array(array('completetag' => $this->yyVals[0+$yyTop]));
            }
        }

    function _68($yyTop)  					// line 796 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['boldClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('strong' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _69($yyTop)  					// line 808 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['boldClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('strong' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _70($yyTop)  					// line 820 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['codeClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('code' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _71($yyTop)  					// line 832 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['codeClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('code' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _72($yyTop)  					// line 844 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['sampClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('samp' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _73($yyTop)  					// line 856 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['sampClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('samp' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _74($yyTop)  					// line 868 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['kbdClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('kbd' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _75($yyTop)  					// line 880 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['kbdClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('kbd' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _76($yyTop)  					// line 892 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['varClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('var' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _77($yyTop)  					// line 904 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['varClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('var' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _78($yyTop)  					// line 916 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $list = $this->_options['listClass'];
            if ($list) {
                $this->yyVal = new $list(2);
            } else {
                $this->yyVal = array('list' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _79($yyTop)  					// line 928 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $list = $this->_options['listClass'];
            if ($list) {
                $this->yyVal = new $list(2);
            } else {
                $this->yyVal = array('list' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _80($yyTop)  					// line 940 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _81($yyTop)  					// line 944 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _82($yyTop)  					// line 952 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _83($yyTop)  					// line 956 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _84($yyTop)  					// line 964 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _85($yyTop)  					// line 971 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _86($yyTop)  					// line 978 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _87($yyTop)  					// line 982 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-3+$yyTop];
            $this->yyVal[] = $this->yyVals[-1+$yyTop];
        }

    function _88($yyTop)  					// line 990 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _89($yyTop)  					// line 994 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-3+$yyTop];
            $this->yyVal[] = $this->yyVals[-1+$yyTop];
        }

    function _90($yyTop)  					// line 1002 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'unordered';
        }

    function _91($yyTop)  					// line 1006 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'ordered';
        }

    function _92($yyTop)  					// line 1010 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'ordered';
        }

    function _94($yyTop)  					// line 1018 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'unordered';
        }

    function _95($yyTop)  					// line 1022 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'ordered';
        }

    function _96($yyTop)  					// line 1026 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'ordered';
        }

    function _100($yyTop)  					// line 1040 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _101($yyTop)  					// line 1044 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array(str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]));
        }

    function _102($yyTop)  					// line 1048 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _103($yyTop)  					// line 1052 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _104($yyTop)  					// line 1062 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _105($yyTop)  					// line 1066 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _106($yyTop)  					// line 1070 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _107($yyTop)  					// line 1075 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _108($yyTop)  					// line 1084 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _109($yyTop)  					// line 1089 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _110($yyTop)  					// line 1105 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _111($yyTop)  					// line 1110 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _113($yyTop)  					// line 1119 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
        }

    function _114($yyTop)  					// line 1123 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _115($yyTop)  					// line 1127 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _116($yyTop)  					// line 1137 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _117($yyTop)  					// line 1141 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _118($yyTop)  					// line 1145 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _119($yyTop)  					// line 1149 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _120($yyTop)  					// line 1154 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _121($yyTop)  					// line 1164 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _122($yyTop)  					// line 1169 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _123($yyTop)  					// line 1186 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _124($yyTop)  					// line 1196 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _125($yyTop)  					// line 1201 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _126($yyTop)  					// line 1209 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _127($yyTop)  					// line 1216 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _128($yyTop)  					// line 1223 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->_parseInlineTag($this->yyVals[-2+$yyTop], $this->yyVals[-1+$yyTop]);
        }

    function _129($yyTop)  					// line 1227 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->_parseInlineTag($this->yyVals[-1+$yyTop], array());
        }

    function _130($yyTop)  					// line 1234 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->_options['parseInternal']) {
                $this->yyVal = $this->yyVals[-1+$yyTop];
            } else {
                $this->yyVal = '';
            }
        }

    function _131($yyTop)  					// line 1245 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->_options['parseInternal']) {
                $this->yyVal = $this->yyVals[-1+$yyTop];
            } else {
                $this->yyVal = '';
            }
        }
					// line 1462 "-"

					// line 1253 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"

    /**#@-*/
}
					// line 1468 "-"

  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyLhs']  = array(              -1,
    0,    0,    0,    0,    0,    0,    3,    2,    2,    2,
    5,    5,    5,    4,    4,    1,    1,    1,    1,    1,
    1,    1,    1,    1,    1,    1,    1,    1,    1,    1,
    1,    1,    1,    1,   11,   11,   11,   11,   11,   11,
   11,   11,   11,   11,   11,   11,   11,   11,   11,   11,
    6,    6,    6,    7,    7,    7,    7,    7,    7,    7,
   12,   12,   12,   12,   12,   12,   12,   15,   21,   16,
   22,   17,   23,   18,   24,   19,   25,   20,   26,   27,
   27,   28,   28,   29,   30,    8,    8,   13,   13,   31,
   31,   31,   31,   35,   35,   35,   33,   33,   33,   32,
   32,   32,   32,   32,   32,   32,   32,   32,   32,   32,
   32,   34,   34,   34,   34,   34,   34,   34,   34,   34,
   34,   34,   34,   34,   34,   36,   37,    9,    9,   10,
   14,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyLen'] = array(           2,
    1,    2,    3,    2,    2,    1,    2,    1,    2,    3,
    0,    1,    3,    1,    2,    1,    1,    1,    1,    1,
    1,    1,    1,    1,    2,    2,    2,    2,    2,    2,
    2,    2,    2,    2,    1,    1,    1,    1,    1,    1,
    1,    1,    2,    2,    2,    2,    2,    2,    2,    2,
    3,    4,    2,    1,    1,    1,    1,    1,    1,    1,
    1,    1,    1,    1,    1,    1,    1,    3,    3,    3,
    3,    3,    3,    3,    3,    3,    3,    3,    3,    1,
    2,    1,    2,    3,    3,    3,    4,    3,    4,    1,
    1,    1,    2,    2,    2,    2,    1,    1,    1,    1,
    1,    1,    1,    1,    1,    2,    2,    2,    2,    2,
    2,    1,    1,    1,    1,    1,    1,    1,    2,    2,
    2,    2,    2,    2,    2,    3,    3,    4,    3,    3,
    3,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyDefRed'] = array(            0,
   90,   91,   92,    0,    0,    0,    0,    0,    0,    0,
    0,   22,   54,   21,   16,   24,   23,    0,    0,    0,
    0,    0,    6,    0,   14,   17,    0,   19,   20,   55,
   56,   57,   58,   59,   60,    0,   93,    0,    0,    0,
    0,    0,    0,   61,   40,   35,   41,    0,   42,   38,
    0,   36,    0,   39,   62,   63,   64,   65,   66,   67,
    0,    0,    0,   80,    0,    0,    0,    0,    0,    0,
    0,    0,    0,   30,   31,   29,   25,   33,   32,    0,
    2,    0,   26,    0,   28,   34,    5,   15,    0,  100,
    0,  101,  103,  104,  102,    0,    0,  105,    0,    0,
   82,    0,    0,    0,    0,    0,    0,    0,   48,   43,
   49,   50,   46,   44,    0,   47,    0,  112,  113,  115,
  116,  114,  117,    0,    0,  118,    0,   78,   81,   70,
    0,   68,   74,   76,   72,  130,    0,  129,    0,    0,
    3,    0,   94,   95,   96,  106,   97,   98,  107,  109,
   99,  110,  108,   86,  111,    0,    0,   79,   83,   71,
   69,   75,   77,   73,  131,   52,    0,  119,  120,  122,
  123,  121,  124,   88,  125,    0,   84,    0,  128,   87,
  126,   85,   89,  127,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyDgoto']  = array(            21,
   65,   23,   82,   24,   66,   25,   26,   27,   28,   29,
   51,   52,   53,   54,   30,   31,   32,   33,   34,   35,
   55,   56,   57,   58,   59,   60,   63,  100,   64,  101,
   36,   96,  154,  124,   97,   98,  126,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yySindex'] = array(          397,
    0,    0,    0,  227,  692,    6,  469,  469,  469,  469,
  469,    0,    0,    0,    0,    0,    0,  469,   58,   85,
    0,  359,    0,   73,    0,    0,  227,    0,    0,    0,
    0,    0,    0,    0,    0,  786,    0,   95,  692,  692,
  692,  692,  692,    0,    0,    0,    0,  122,    0,    0,
  245,    0,  227,    0,    0,    0,    0,    0,    0,    0,
  759,  469,  118,    0,  435,  -13,   64,    4,  121,  119,
   56,  469,   27,    0,    0,    0,    0,    0,    0,  469,
    0,  129,    0,  227,    0,    0,    0,    0,  786,    0,
  194,    0,    0,    0,    0,   31,  786,    0,  692,  154,
    0,  503,  528,  553,  591,  629,   18,  171,    0,    0,
    0,    0,    0,    0,  227,    0,  759,    0,    0,    0,
    0,    0,    0,   -4,  759,    0,   -5,    0,    0,    0,
  469,    0,    0,    0,    0,    0,  143,    0,  142,  143,
    0,   31,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,   31,  667,    0,    0,    0,
    0,    0,    0,    0,    0,    0,   -4,    0,    0,    0,
    0,    0,    0,    0,    0,   -4,    0,  435,    0,    0,
    0,    0,    0,    0,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyRindex'] = array(            0,
    0,    0,    0,    0,    0,    0,   68,  128,   88,  149,
  152,    0,    0,    0,    0,    0,    0,  126,  184,    0,
    0,  198,    0,    0,    0,    0,  282,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
   74,    0,  811,    0,    0,    0,    0,    0,    0,    0,
    0,   66,    0,    0,  711,    0,    0,    0,    0,    0,
    0,   15,    0,    0,    0,    0,    0,    0,    0,   42,
    0,  200,    0,  321,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  114,    0,    0,
    0,    0,    0,    0,  841,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  203,    0,    0,   28,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,  729,    0,    0,
    0,    0,    0,    0,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyGindex'] = array(            0,
    5,   -2,    0,  156,  215,   -6,   -3,  -19,   16,  -15,
   33,   65,   -7,  109,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  147,  116,
  103,  102,  -39,   76,   10,  -72, -113,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyTable'] = array(           168,
  147,  148,   84,   91,   22,   38,   86,   39,  130,   40,
  175,   41,   42,   43,    9,  177,   62,   88,   83,   81,
   50,   87,  131,  155,   44,  169,    5,    7,  170,  133,
  131,  171,   94,   20,  146,  147,  148,   85,   91,  131,
    6,   11,    7,  115,    8,   84,    9,   10,   11,   86,
   11,   95,  165,  175,   50,   50,   50,   50,   50,   13,
  149,   83,  175,  150,    7,  138,  113,  139,   20,  155,
  125,  102,  103,  104,  105,  106,  122,   11,   11,  141,
   85,    5,   53,  155,  174,   94,   11,  132,   72,   11,
  136,  131,  152,   94,  115,  115,  115,  115,  115,  131,
   88,   11,  180,   11,   95,   99,   37,   61,   53,   19,
   53,  153,   95,   11,   50,  114,  181,  113,  113,  113,
  113,  113,   51,   11,   73,  123,  125,  183,   62,   89,
    5,  157,  122,  125,  125,  178,  184,  128,  152,  172,
  122,   61,   61,   61,   61,   61,  135,  134,   51,  115,
   51,   11,  152,   61,  131,  117,  131,  153,   84,  116,
   11,   11,   86,   11,   99,   19,  114,  114,  114,  114,
  114,  153,  113,  158,   83,   11,  125,  166,  131,   11,
  179,  123,  172,    8,   11,  125,   89,   11,  173,  123,
  142,  172,  167,   85,  143,  144,  145,    1,  156,    4,
  176,   61,   10,  107,   61,   61,   61,   61,   61,  129,
  116,  116,  116,  116,  116,  159,    0,  117,    0,    0,
    0,  114,   67,   68,   69,   70,    0,    1,    2,    3,
    0,  173,   71,    4,    0,    0,    0,    0,    0,    0,
  173,    0,    0,    0,    0,    1,    2,    3,    0,    0,
    0,    4,    0,  151,   38,    0,   39,    0,   40,   61,
   41,   42,   43,  108,    0,  116,    0,    0,    0,    0,
    0,    0,    0,   44,  109,  110,  127,  111,   48,    0,
  112,   18,   20,    0,    0,    0,  137,    0,  151,    0,
   18,   18,    0,   18,  140,   18,    0,   18,   18,   18,
   18,    0,   18,   18,    0,   18,    0,   18,   18,   18,
   18,   18,   18,   18,   18,   18,   18,   18,   18,   18,
   27,    0,    0,    0,    0,    0,    0,    0,    0,   27,
   27,    0,   27,    0,   27,    0,   27,   27,   27,   27,
    0,   27,   27,    0,   27,    0,   27,   27,   27,   27,
   27,   27,   27,   27,   27,   27,   27,   27,   27,    1,
    2,    3,    0,    0,    0,    4,    0,   74,    6,    0,
    7,    0,    8,    0,    9,   10,   11,   75,    0,    0,
    0,    0,    0,    0,    0,    0,    0,   13,   76,   77,
   78,   79,   18,    0,   80,   19,   20,    1,    2,    3,
    0,    0,    0,    4,    0,    5,    6,    0,    7,    0,
    8,    0,    9,   10,   11,   12,    0,    0,    0,    0,
    0,    0,    0,    0,    0,   13,   14,   15,   16,   17,
   18,    0,    0,   19,   20,    1,    2,    3,    0,    0,
    0,    4,    0,   74,    6,    0,    7,    0,    8,    0,
    9,   10,   11,   75,    0,    0,    0,    0,    0,    0,
    0,    0,    0,   13,   76,   77,   78,   79,   18,    1,
    2,    3,   20,    0,    0,    4,    0,    0,    6,    0,
    7,    0,    8,    0,    9,   10,   11,   12,    0,    0,
    0,    0,    0,    0,    0,    0,    0,   13,   14,   15,
   16,   17,   18,    1,    2,    3,   20,    0,    0,    4,
    0,    0,   38,    0,   39,    0,   40,    0,   41,   42,
   43,    0,    0,    0,  160,    0,    0,    0,    1,    2,
    3,   44,  109,  110,    4,  111,   48,   38,  112,   39,
   20,   40,    0,   41,   42,   43,    0,    0,    0,    0,
    0,  161,    0,    1,    2,    3,   44,  109,  110,    4,
  111,   48,   38,  112,   39,   20,   40,    0,   41,   42,
   43,    0,    0,    0,    0,    0,    0,    0,  162,    0,
    0,   44,  109,  110,    0,  111,   48,    0,  112,    0,
   20,    1,    2,    3,    0,    0,    0,    4,    0,    0,
   38,    0,   39,    0,   40,    0,   41,   42,   43,    0,
    0,    0,    0,    0,    0,    0,    0,  163,    0,   44,
  109,  110,    0,  111,   48,    0,  112,    0,   20,    1,
    2,    3,    0,    0,    0,    4,    0,    0,   38,    0,
   39,    0,   40,    0,   41,   42,   43,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  164,   44,  109,  110,
    0,  111,   48,    0,  112,    0,   20,    1,    2,    3,
    0,    0,    0,    4,    0,    0,   38,    0,   39,    0,
   40,    0,   41,   42,   43,    0,    0,  182,    0,    0,
    0,    0,    1,    2,    3,   44,  109,  110,    4,  111,
   48,   38,  112,   39,   20,   40,    0,   41,   42,   43,
   12,    0,    0,    0,    0,    0,    0,    0,    0,    0,
   44,   45,   46,    0,   47,   48,    0,   49,   13,   20,
    0,   12,   12,    0,   12,    0,   12,   12,   12,    0,
    0,    0,    0,    0,    0,   12,   12,   12,    0,   13,
   13,    0,   13,    0,   13,   13,   13,    0,    0,    0,
    0,    0,  118,   13,   13,   13,   91,    0,   38,    0,
   39,    0,   40,    0,   41,   42,   43,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,   44,  119,   90,
    0,  120,    0,   91,  121,    6,   20,    7,    0,    8,
    0,    9,   10,   11,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,   13,   92,    0,    0,   93,   37,
   37,    0,   37,   20,   37,    0,   37,   37,   37,   37,
    0,   37,   37,    0,   37,    0,   37,   37,   37,   37,
   37,   37,    0,   37,   37,   37,   37,   37,   37,   45,
   45,    0,   45,    0,   45,    0,   45,   45,   45,   45,
    0,   45,   45,    0,   45,    0,   45,   45,   45,   45,
   45,   45,    0,   45,   45,   45,   45,   45,   45,
  );
 $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyCheck'] = array(             4,
    5,    6,   22,    8,    0,   10,   22,   12,   22,   14,
  124,   16,   17,   18,    0,   21,   11,   24,   22,   22,
    5,   24,   36,   96,   29,   30,    9,    0,   33,   26,
   36,   36,   36,   38,    4,    5,    6,   22,    8,   36,
   10,    0,   12,   51,   14,   65,   16,   17,   18,   65,
   36,   36,   35,  167,   39,   40,   41,   42,   43,   29,
   30,   65,  176,   33,   37,   39,   51,   41,   38,  142,
   61,   39,   40,   41,   42,   43,   61,   36,   37,   82,
   65,    9,    9,  156,  124,   89,   21,   24,   31,   22,
   35,   36,   96,   97,  102,  103,  104,  105,  106,   36,
  107,   36,  142,   36,   89,   11,    4,    5,   35,   37,
   37,   96,   97,   26,   99,   51,  156,  102,  103,  104,
  105,  106,    9,   36,   40,   61,  117,  167,   11,   27,
    9,   99,  117,  124,  125,  131,  176,   20,  142,  124,
  125,   39,   40,   41,   42,   43,   28,   27,   35,  157,
   37,   24,  156,   51,   36,   53,   36,  142,  178,   51,
   35,   36,  178,   36,   11,   37,  102,  103,  104,  105,
  106,  156,  157,   20,  178,   27,  167,    7,   36,   28,
   39,  117,  167,    0,   36,  176,   84,   36,  124,  125,
   89,  176,  117,  178,    1,    2,    3,    0,   97,    0,
  125,   99,    0,   48,  102,  103,  104,  105,  106,   63,
  102,  103,  104,  105,  106,  100,   -1,  115,   -1,   -1,
   -1,  157,    8,    9,   10,   11,   -1,    1,    2,    3,
   -1,  167,   18,    7,   -1,   -1,   -1,   -1,   -1,   -1,
  176,   -1,   -1,   -1,   -1,    1,    2,    3,   -1,   -1,
   -1,    7,   -1,  258,   10,   -1,   12,   -1,   14,  157,
   16,   17,   18,   19,   -1,  157,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   29,   30,   31,   62,   33,   34,   -1,
   36,    0,   38,   -1,   -1,   -1,   72,   -1,  258,   -1,
    9,   10,   -1,   12,   80,   14,   -1,   16,   17,   18,
   19,   -1,   21,   22,   -1,   24,   -1,   26,   27,   28,
   29,   30,   31,   32,   33,   34,   35,   36,   37,   38,
    0,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,    9,
   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,   19,
   -1,   21,   22,   -1,   24,   -1,   26,   27,   28,   29,
   30,   31,   32,   33,   34,   35,   36,   37,   38,    1,
    2,    3,   -1,   -1,   -1,    7,   -1,    9,   10,   -1,
   12,   -1,   14,   -1,   16,   17,   18,   19,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,   31,
   32,   33,   34,   -1,   36,   37,   38,    1,    2,    3,
   -1,   -1,   -1,    7,   -1,    9,   10,   -1,   12,   -1,
   14,   -1,   16,   17,   18,   19,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   29,   30,   31,   32,   33,
   34,   -1,   -1,   37,   38,    1,    2,    3,   -1,   -1,
   -1,    7,   -1,    9,   10,   -1,   12,   -1,   14,   -1,
   16,   17,   18,   19,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   29,   30,   31,   32,   33,   34,    1,
    2,    3,   38,   -1,   -1,    7,   -1,   -1,   10,   -1,
   12,   -1,   14,   -1,   16,   17,   18,   19,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,   31,
   32,   33,   34,    1,    2,    3,   38,   -1,   -1,    7,
   -1,   -1,   10,   -1,   12,   -1,   14,   -1,   16,   17,
   18,   -1,   -1,   -1,   22,   -1,   -1,   -1,    1,    2,
    3,   29,   30,   31,    7,   33,   34,   10,   36,   12,
   38,   14,   -1,   16,   17,   18,   -1,   -1,   -1,   -1,
   -1,   24,   -1,    1,    2,    3,   29,   30,   31,    7,
   33,   34,   10,   36,   12,   38,   14,   -1,   16,   17,
   18,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   26,   -1,
   -1,   29,   30,   31,   -1,   33,   34,   -1,   36,   -1,
   38,    1,    2,    3,   -1,   -1,   -1,    7,   -1,   -1,
   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   27,   -1,   29,
   30,   31,   -1,   33,   34,   -1,   36,   -1,   38,    1,
    2,    3,   -1,   -1,   -1,    7,   -1,   -1,   10,   -1,
   12,   -1,   14,   -1,   16,   17,   18,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   28,   29,   30,   31,
   -1,   33,   34,   -1,   36,   -1,   38,    1,    2,    3,
   -1,   -1,   -1,    7,   -1,   -1,   10,   -1,   12,   -1,
   14,   -1,   16,   17,   18,   -1,   -1,   21,   -1,   -1,
   -1,   -1,    1,    2,    3,   29,   30,   31,    7,   33,
   34,   10,   36,   12,   38,   14,   -1,   16,   17,   18,
    0,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   29,   30,   31,   -1,   33,   34,   -1,   36,    0,   38,
   -1,   21,   22,   -1,   24,   -1,   26,   27,   28,   -1,
   -1,   -1,   -1,   -1,   -1,   35,   36,   37,   -1,   21,
   22,   -1,   24,   -1,   26,   27,   28,   -1,   -1,   -1,
   -1,   -1,    4,   35,   36,   37,    8,   -1,   10,   -1,
   12,   -1,   14,   -1,   16,   17,   18,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,    4,
   -1,   33,   -1,    8,   36,   10,   38,   12,   -1,   14,
   -1,   16,   17,   18,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   29,   30,   -1,   -1,   33,    9,
   10,   -1,   12,   38,   14,   -1,   16,   17,   18,   19,
   -1,   21,   22,   -1,   24,   -1,   26,   27,   28,   29,
   30,   31,   -1,   33,   34,   35,   36,   37,   38,    9,
   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,   19,
   -1,   21,   22,   -1,   24,   -1,   26,   27,   28,   29,
   30,   31,   -1,   33,   34,   35,   36,   37,   38,
  );

  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyFinal'] = 21;
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
    "paragraph :  T_NL ",
    "paragraph :  paragraph   T_TEXT ",
    "paragraph :  paragraph   htmltag ",
    "paragraph :  paragraph   simplelist ",
    "paragraph :  paragraph   inlinetag ",
    "paragraph :  paragraph   T_ESCAPED_TAG ",
    "paragraph :  paragraph   T_OPEN_P ",
    "paragraph :  paragraph   T_CLOSE_P ",
    "paragraph :  paragraph   T_INLINE_ESC ",
    "paragraph :  paragraph   T_NL ",
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
    "T_NL","T_INLINE_ESC","T_INTERNAL","T_ENDINTERNAL","T_DOUBLE_NL",
    "T_TAG","T_INLINE_TAG_OPEN","T_INLINE_TAG_CLOSE","T_INLINE_TAG_NAME",
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
    null,null,null,null,null,null,null,null,null,null,null,"EOF",
  );
 ?>
