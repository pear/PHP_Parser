<?php
 // created by jay 0.8 (c) 1998 Axel.Schreiner@informatik.uni-osnabrueck.de
 // modified by alan@akbkhome.com to try to generate php!
 // modified by cellog@users.sourceforge.net to fit PEAR CS
 // %token constants

 require_once 'PEAR/ErrorStack.php';

 if (!defined('PHP_PARSER_ERROR_UNEXPECTED')) { define('PHP_PARSER_ERROR_UNEXPECTED', 1); }
 if (!defined('PHP_PARSER_ERROR_SYNTAX')) { define('PHP_PARSER_ERROR_SYNTAX', 2); }
 if (!defined('PHP_PARSER_ERROR_SYNTAX_EOF')) { define('PHP_PARSER_ERROR_SYNTAX_EOF', 3); }
if (!defined('TOKEN_yyErrorCode')) {   define('TOKEN_yyErrorCode', 256);
}
 // Class now

					// line 1 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"

?><?php
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
        $this->_errorStack = &PEAR_ErrorStack::singleton('PHP_Parser_DocBlock_Default');
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
     * @param:array integer $commentline line number
     * @param:array array $commenttoken T_DOC_COMMENT token
     * @param:array PHP_Parser_DocBlock_Lexer $lex DocBlock lexer
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

    /**
     * Extract the summary from the description, and set it.
     *
     * This can be overridden in child classes to do other methods of
     * summary extraction, such as the doxygen method of extracting
     * a certain number of characters, or Javadoc's method of extracting
     * to the first period
     */
    function setSummary()
    {
        if (!isset($this->paragraphs[0])) {
            return;
        }
        $this->summary = $this->paragraphs[0];
        $lineindex = 0;
        $nlcount = 0;
        $oldnlcount = 0;
        $retsummary = $retdescription = array();
        foreach($this->summary as $i => $item) {
            $oldnlcount = $nlcount;
            if (is_array($item)) {
                // no way to calculate arrays since they can be nested
                $retsummary = array_slice($this->summary, 0, $i);
                $retdescription = array_slice($this->summary, $i);
                $this->summary = $retsummary;
                $this->paragraphs[0] = $retdescription;
                return;
            }
            if (is_object($item)) {
                if ((method_exists($item, 'hasmultiplecr') && $item->hasMultipleCR())
                        || is_a($item, 'PHP_Parser_DocBlock_List')) {
                    $retsummary = array_slice($this->summary, 0, $i);
                    $retdescription = array_slice($this->summary, $i);
                    $this->summary = $retsummary;
                    $this->paragraphs[0] = $retdescription;
                    return;
                }
                // all other objects can't contain \n
                continue;
            }
            if (count(explode("\n\n", $item)) - 1) {
                // contains a double newline - this is it
                $summary = array_shift($a = explode("\n\n", $item));
                $description = join($a);
                $retsummary[$i] = $summary;
                break;
            }
            if (count($a = explode("\n", $item)) - 1) {
                $nlcount += count($a) - 1;
                // contains newlines
                if ($nlcount > 3) {
                    // we've found our summary in this block
                    if ($oldnlcount == 2) {
                        $retsummary = array_slice($this->summary, 0, $i);
                        $retsummary[] = array_shift($a);
                        $retdescription = array_merge(array(join($a, "\n")),
                                                      array_slice($this->summary, $i + 1));
                    }
                    if ($oldnlcount == 3) {
                        $retsummary = array_slice($this->summary, 0, $i - 1);
                        $retdescription = array_slice($this->summary, $i - 1);
                    }
                    $this->summary = $retsummary;
                    $this->paragraphs[0] = $retdescription;
                    return;
                }
            }
        }
        if (isset($description)) {
            for($j = 0; $j < $i; $j++) {
                $retsummary[$j] = $this->summary[$i];
            }
            $retdescription = array($description);
            for($j = $i; $j < count($this->summary); $j++) {
                $retdescription[] = $this->summary[$i];
            }
            $this->summary = $retsummary;
            $this->paragraphs[0] = $retdescription;
            return;
        }
        
        
        unset($this->paragraphs[0]);
        $this->paragraphs = array_values($this->paragraphs);
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
        $comment = str_replace("\r\n", "\n", trim($comment));
        $comment = str_replace("\n\r", "\n", trim($comment));
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
					// line 498 "-"

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
//t        $this->debug = true;
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
//                            var_dump($yyToken);
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


    function _1($yyTop)  					// line 538 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->paragraphs = array($this->yyVals[0+$yyTop]);
        }

    function _2($yyTop)  					// line 542 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->paragraphs = $this->yyVals[-1+$yyTop];
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _3($yyTop)  					// line 547 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            array_unshift($this->yyVals[-1+$yyTop], $this->yyVals[-2+$yyTop]);
            $this->paragraphs = $this->yyVals[-1+$yyTop];
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _4($yyTop)  					// line 553 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            array_unshift($this->yyVals[0+$yyTop], $this->yyVals[-1+$yyTop]);
            $this->paragraphs = $this->yyVals[0+$yyTop];
        }

    function _5($yyTop)  					// line 558 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _6($yyTop)  					// line 562 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->paragraphs = array($this->yyVals[0+$yyTop]);
        }

    function _7($yyTop)  					// line 566 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->paragraphs = array($this->yyVals[-1+$yyTop]);
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _8($yyTop)  					// line 575 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
        $this->yyVal = $this->yyVals[0+$yyTop];
    }

    function _9($yyTop)  					// line 582 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->tags[] = $this->_parseTag($this->yyVals[0+$yyTop], array());
        }

    function _10($yyTop)  					// line 586 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->tags[] = $this->_parseTag($this->yyVals[-1+$yyTop], $this->yyVals[0+$yyTop]);
        }

    function _11($yyTop)  					// line 590 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if (is_string($this->yyVals[0+$yyTop][0])) {
                $this->yyVals[0+$yyTop][0] = $this->yyVals[-1+$yyTop] . $this->yyVals[0+$yyTop][0];
            }
            $this->tags[] = $this->_parseTag($this->yyVals[-2+$yyTop], $this->yyVals[0+$yyTop]);
        }

    function _13($yyTop)  					// line 600 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _14($yyTop)  					// line 604 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _15($yyTop)  					// line 612 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _16($yyTop)  					// line 616 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _17($yyTop)  					// line 624 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _18($yyTop)  					// line 628 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _19($yyTop)  					// line 632 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _20($yyTop)  					// line 636 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _21($yyTop)  					// line 640 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _22($yyTop)  					// line 644 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
        }

    function _23($yyTop)  					// line 648 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _24($yyTop)  					// line 658 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _25($yyTop)  					// line 662 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _26($yyTop)  					// line 672 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
         }

    function _27($yyTop)  					// line 677 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _28($yyTop)  					// line 682 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _29($yyTop)  					// line 687 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _30($yyTop)  					// line 692 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _31($yyTop)  					// line 702 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _32($yyTop)  					// line 718 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _33($yyTop)  					// line 731 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _34($yyTop)  					// line 735 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _35($yyTop)  					// line 739 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _36($yyTop)  					// line 743 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _37($yyTop)  					// line 747 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _38($yyTop)  					// line 751 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
        }

    function _39($yyTop)  					// line 755 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _40($yyTop)  					// line 759 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _41($yyTop)  					// line 769 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _42($yyTop)  					// line 779 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _43($yyTop)  					// line 784 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _44($yyTop)  					// line 789 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _45($yyTop)  					// line 794 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _46($yyTop)  					// line 804 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _47($yyTop)  					// line 814 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _48($yyTop)  					// line 824 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _49($yyTop)  					// line 841 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _50($yyTop)  					// line 849 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _51($yyTop)  					// line 853 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
        }

    function _52($yyTop)  					// line 857 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[0+$yyTop];
        }

    function _53($yyTop)  					// line 864 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['completeTagClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal = array('completetag' => $this->yyVals[0+$yyTop]);
            }
        }

    function _60($yyTop)  					// line 882 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['completeTagClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal = array('completetag' => $this->yyVals[0+$yyTop]);
            }
        }

    function _67($yyTop)  					// line 900 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['boldClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('strong' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _68($yyTop)  					// line 912 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['boldClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('strong' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _69($yyTop)  					// line 924 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['codeClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('code' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _70($yyTop)  					// line 936 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['codeClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('code' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _71($yyTop)  					// line 947 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['sampClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('samp' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _72($yyTop)  					// line 959 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['sampClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('samp' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _73($yyTop)  					// line 971 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['kbdClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('kbd' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _74($yyTop)  					// line 983 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['kbdClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('kbd' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _75($yyTop)  					// line 995 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['varClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('var' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _76($yyTop)  					// line 1007 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['varClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('var' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _77($yyTop)  					// line 1019 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $list = $this->_options['listClass'];
            if ($list) {
                $this->yyVal = new $list($this->yyVals[-1+$yyTop], $this->yyVals[-2+$yyTop]);
            } else {
                $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
            }
        }

    function _78($yyTop)  					// line 1031 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $list = $this->_options['listClass'];
            if ($list) {
                $this->yyVal = new $list(2);
            } else {
                $this->yyVal = array('list' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _79($yyTop)  					// line 1043 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _80($yyTop)  					// line 1047 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _81($yyTop)  					// line 1055 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _82($yyTop)  					// line 1059 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _83($yyTop)  					// line 1067 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _84($yyTop)  					// line 1074 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _85($yyTop)  					// line 1081 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _86($yyTop)  					// line 1085 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _87($yyTop)  					// line 1089 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
            $this->yyVal['list'][] = $this->yyVals[-1+$yyTop]['list'][0];
        }

    function _88($yyTop)  					// line 1097 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _89($yyTop)  					// line 1101 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _90($yyTop)  					// line 1105 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
            $this->yyVal['list'][] = $this->yyVals[-1+$yyTop]['list'][0];
        }

    function _91($yyTop)  					// line 1113 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => array($this->yyVals[0+$yyTop]), 'type' => $this->yyVals[-1+$yyTop]);
        }

    function _92($yyTop)  					// line 1120 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => array($this->yyVals[0+$yyTop]), 'type' => $this->yyVals[-1+$yyTop]);
        }

    function _93($yyTop)  					// line 1127 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _94($yyTop)  					// line 1131 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
            $this->yyVal['list'][0][] = $this->yyVals[0+$yyTop];
        }

    function _95($yyTop)  					// line 1136 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
            $this->yyVal['list'][] = $this->yyVals[-1+$yyTop]['list'][0];
        }

    function _96($yyTop)  					// line 1141 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-3+$yyTop];
            $a = count($this->yyVal['list']);
            $this->yyVal['list'][] = $this->yyVals[-2+$yyTop]['list'][0];
            $this->yyVal['list'][$a][] = $this->yyVals[0+$yyTop];
        }

    function _97($yyTop)  					// line 1151 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _98($yyTop)  					// line 1155 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
            $this->yyVal['list'][0][] = $this->yyVals[0+$yyTop];
        }

    function _99($yyTop)  					// line 1160 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
            $this->yyVal['list'][] = $this->yyVals[-1+$yyTop]['list'][0];
        }

    function _100($yyTop)  					// line 1165 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-3+$yyTop];
            $a = count($this->yyVal['list']);
            $this->yyVal['list'][] = $this->yyVals[-2+$yyTop]['list'][0];
            $this->yyVal['list'][$a][] = $this->yyVals[0+$yyTop];
        }

    function _101($yyTop)  					// line 1175 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[0+$yyTop];
        }

    function _102($yyTop)  					// line 1179 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[0+$yyTop];
        }

    function _103($yyTop)  					// line 1186 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[0+$yyTop];
        }

    function _104($yyTop)  					// line 1190 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = '#';
        }

    function _105($yyTop)  					// line 1194 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = '#';
        }

    function _106($yyTop)  					// line 1201 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[0+$yyTop];
        }

    function _107($yyTop)  					// line 1208 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[0+$yyTop];
        }

    function _108($yyTop)  					// line 1216 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _109($yyTop)  					// line 1220 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array(str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]));
        }

    function _110($yyTop)  					// line 1224 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _111($yyTop)  					// line 1228 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _112($yyTop)  					// line 1238 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _113($yyTop)  					// line 1242 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _114($yyTop)  					// line 1247 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _115($yyTop)  					// line 1256 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _116($yyTop)  					// line 1261 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _117($yyTop)  					// line 1277 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _119($yyTop)  					// line 1286 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
        }

    function _120($yyTop)  					// line 1290 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _121($yyTop)  					// line 1294 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _122($yyTop)  					// line 1304 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _123($yyTop)  					// line 1308 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _124($yyTop)  					// line 1312 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _125($yyTop)  					// line 1317 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _126($yyTop)  					// line 1327 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _127($yyTop)  					// line 1332 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _128($yyTop)  					// line 1349 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _129($yyTop)  					// line 1359 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _130($yyTop)  					// line 1367 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->_parseInlineTag($this->yyVals[-2+$yyTop], $this->yyVals[-1+$yyTop]);
        }

    function _131($yyTop)  					// line 1371 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->_parseInlineTag($this->yyVals[-1+$yyTop], array());
        }

    function _132($yyTop)  					// line 1378 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->_options['parseInternal']) {
                $this->yyVal = $this->yyVals[-1+$yyTop];
            } else {
                $this->yyVal = '';
            }
        }

    function _133($yyTop)  					// line 1389 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->_options['parseInternal']) {
                $this->yyVal = $this->yyVals[-1+$yyTop];
            } else {
                $this->yyVal = '';
            }
        }
					// line 1608 "-"

					// line 1397 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"

    /**#@-*/
}
					// line 1614 "-"

  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyLhs']  = array(              -1,
    0,    0,    0,    0,    0,    0,    0,    3,    2,    2,
    2,    5,    5,    5,    4,    4,    7,    7,    7,    7,
    7,    7,    7,    7,    7,    7,    7,    7,    7,    7,
    7,    7,    1,    1,    1,    1,    1,    1,    1,    1,
    1,    1,    1,    1,    1,    1,    1,    1,    1,    6,
    6,    6,   12,   12,   12,   12,   12,   12,   12,    8,
    8,    8,    8,    8,    8,    8,   15,   21,   16,   22,
   17,   23,   18,   24,   19,   25,   20,   26,   27,   27,
   28,   28,   29,   30,   13,   13,   13,    9,    9,    9,
   31,   33,   32,   32,   32,   32,   34,   34,   34,   34,
   35,   35,   40,   40,   40,   38,   39,   36,   36,   36,
   36,   36,   36,   36,   36,   36,   36,   37,   37,   37,
   37,   37,   37,   37,   37,   37,   37,   37,   37,   10,
   10,   14,   11,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyLen'] = array(           2,
    1,    2,    3,    2,    1,    1,    2,    2,    1,    2,
    3,    0,    1,    3,    1,    2,    1,    1,    1,    1,
    1,    1,    1,    1,    2,    2,    2,    2,    2,    2,
    2,    2,    1,    1,    1,    1,    1,    1,    1,    1,
    2,    2,    2,    2,    2,    2,    2,    2,    2,    3,
    4,    2,    1,    1,    1,    1,    1,    1,    1,    1,
    1,    1,    1,    1,    1,    1,    3,    3,    3,    3,
    3,    3,    3,    3,    3,    3,    3,    3,    1,    2,
    1,    2,    3,    3,    2,    2,    3,    2,    2,    3,
    2,    2,    2,    3,    3,    4,    2,    3,    3,    4,
    1,    2,    1,    1,    1,    2,    2,    1,    1,    1,
    1,    1,    2,    2,    2,    2,    2,    1,    1,    1,
    1,    1,    1,    2,    2,    2,    2,    2,    2,    4,
    3,    3,    3,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyDefRed'] = array(            0,
  103,  104,  105,    0,    0,    0,    0,    0,    0,    0,
    0,   39,   53,   38,   33,   40,    0,    0,    0,    0,
    0,    5,    0,   15,   36,   34,   35,   37,   54,   55,
   56,   57,   58,   59,    0,    0,    0,  101,  102,    0,
    0,    0,    0,    0,    0,   60,   22,   17,   23,    0,
   24,    0,   18,   19,   20,   21,   61,   62,   63,   64,
   65,   66,    0,    0,    0,    0,    0,   79,    0,    0,
    0,    0,    0,    0,    0,    0,    0,   46,   47,   45,
   41,   48,    0,    2,    0,   44,   42,   43,   49,    7,
   16,    0,   85,   86,    0,  108,  109,  111,  110,  112,
    0,    0,    0,   81,    0,    0,    0,    0,    0,    0,
    0,   30,   25,   31,   32,   26,   27,   28,   29,    0,
   88,   89,    0,  118,  119,  121,  122,  123,  120,    0,
    0,   77,   80,   69,    0,   67,   73,   75,   71,  132,
    0,  131,    0,    0,    3,    0,   94,    0,   87,  113,
  114,  116,  115,  117,    0,   78,   82,   70,   68,   74,
   76,   72,  133,   51,    0,   98,    0,   90,  124,  125,
  127,  128,  129,  126,   83,    0,  130,  106,   96,   84,
  107,  100,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyDgoto']  = array(            20,
   69,   22,   85,   23,   70,   24,   52,   53,   54,   25,
   56,   26,   27,   28,   29,   30,   31,   32,   33,   34,
   57,   58,   59,   60,   61,   62,   67,  103,   68,  104,
   35,   36,   63,   64,   37,  101,  130,  147,  166,   38,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yySindex'] = array(          218,
    0,    0,    0,  167,  556,   23,  594,  594,  594,  594,
  594,    0,    0,    0,    0,    0,  594,   29,  -30,    0,
  180,    0,    5,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  100,  200,  645,    0,    0,   51,
  556,  556,  556,  556,  556,    0,    0,    0,    0,   56,
    0,  256,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,  105,  238,  304,  594,   72,    0,  294,  -10,
   -2,   71,   93,  -22,   99,  594,   28,    0,    0,    0,
    0,    0,  594,    0,   54,    0,    0,    0,    0,    0,
    0,   88,    0,    0,  168,    0,    0,    0,    0,    0,
  673,  556,  112,    0,  328,  366,  404,  442,  480,   52,
  137,    0,    0,    0,    0,    0,    0,    0,    0,  116,
    0,    0,  171,    0,    0,    0,    0,    0,    0,  635,
  -19,    0,    0,    0,  594,    0,    0,    0,    0,    0,
  120,    0,   69,  120,    0,  146,    0,   88,    0,    0,
    0,    0,    0,    0,  518,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  146,    0,  116,    0,    0,    0,
    0,    0,    0,    0,    0,  294,    0,    0,    0,    0,
    0,    0,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyRindex'] = array(            0,
    0,    0,    0,    0,    0,    0,   21,   58,  101,  110,
  115,    0,    0,    0,    0,    0,  143,  184,    0,    0,
  194,    0,  196,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,   33,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  -11,    0,    0,  130,    0,
    0,    0,    0,    0,    0,   22,    0,    0,    0,    0,
    0,    0,    9,    0,  207,    0,    0,    0,    0,    0,
    0,  260,    0,    0,    0,    0,    0,    0,    0,    0,
  181,    0,    0,    0,    0,    0,    0,    0,    0,    0,
   55,    0,    0,    0,    0,    0,    0,    0,    0,  276,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  199,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  209,    0,    0,    4,    0,    0,    0,  347,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  370,    0,    0,    0,
    0,    0,    0,    0,    0,  608,    0,    0,    0,    0,
    0,    0,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyGindex'] = array(            0,
    1,   -3,    0,  165,  109,  -21,  -14,   34,  -33,   -5,
  -28,  -16,  -15,  -13,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  113,  119,
  187,    0,  160,    0,    7,    0,    0,   77,   60,  226,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyTable'] = array(            55,
   21,   91,  175,    8,   87,   88,  139,   89,   12,   77,
   12,   65,  134,  135,    5,   86,  135,   84,  117,   90,
  100,   10,  136,  119,   12,  135,  105,  106,  107,  108,
  109,   99,   52,  135,   66,   55,   55,   55,   55,   55,
    8,   18,   52,   12,   12,   12,  118,   65,   65,   65,
   65,   65,   87,   88,   50,   89,   12,   12,   65,  129,
   76,    5,  102,   86,   50,    5,  142,   52,  143,   52,
   65,  117,  117,  117,  117,  117,  119,  119,  119,  119,
  119,  145,   12,   66,  154,  116,  163,  155,   91,   50,
   18,   50,  132,   12,  146,  153,   55,  137,  128,  118,
  118,  118,  118,  118,   92,   93,  135,  177,   65,  120,
  121,   65,   65,   65,   65,   65,   71,   72,   73,   74,
  138,  117,  165,  102,  174,   75,  119,   12,  135,   13,
  178,  181,  156,  140,  135,  176,   12,   12,  116,  116,
  116,  116,  116,   12,  164,   12,    1,    2,    3,  118,
   12,   13,   13,    4,   13,  135,   13,   13,   13,   87,
   88,   65,   89,  173,   13,   13,   13,    1,    2,    3,
   86,   65,  148,  149,  131,  167,  168,   12,   12,  133,
    1,    2,    3,    9,  141,   91,   91,    4,  116,   78,
    6,  144,    7,    1,    8,    6,    9,   10,   11,   79,
    1,    2,    3,   92,   92,   94,    4,    4,   11,   13,
   80,   81,   82,   17,  110,   83,   18,   19,    1,    2,
    3,  157,   95,  123,  179,    4,  182,    5,    6,   39,
    7,    0,    8,    0,    9,   10,   11,   12,    1,    2,
    3,    0,    0,  122,    0,    4,    0,   13,   14,   15,
   16,   17,    0,    0,   18,   19,    1,    2,    3,    0,
   93,   93,   93,    4,    0,   93,   40,   93,   41,    0,
   42,    0,   43,   44,   45,  111,   97,   97,   97,    0,
    0,   97,    0,   97,    0,   46,  112,  113,  114,   50,
    0,  115,    0,   19,    1,    2,    3,    0,    0,    0,
    0,    4,    0,   78,    6,    0,    7,  124,    8,    0,
    9,   10,   11,   79,   40,    0,   41,    0,   42,    0,
   43,   44,   45,   13,   80,   81,   82,   17,    1,    2,
    3,   19,    0,   46,  125,    4,  126,    0,   40,  127,
   41,   19,   42,    0,   43,   44,   45,   95,   95,   95,
  158,    0,   95,    0,   95,    0,    0,   46,  112,  113,
  114,   50,    0,  115,    0,   19,    1,    2,    3,    0,
   99,   99,   99,    4,    0,   99,   40,   99,   41,    0,
   42,    0,   43,   44,   45,    0,    0,    0,    0,    0,
  159,    0,    0,    0,    0,   46,  112,  113,  114,   50,
    0,  115,    0,   19,    1,    2,    3,    0,    0,    0,
    0,    4,    0,    0,   40,    0,   41,    0,   42,    0,
   43,   44,   45,    0,    0,    0,    0,    0,    0,    0,
  160,    0,    0,   46,  112,  113,  114,   50,    0,  115,
    0,   19,    1,    2,    3,    0,    0,    0,    0,    4,
    0,    0,   40,    0,   41,    0,   42,    0,   43,   44,
   45,    0,    0,    0,    0,    0,    0,    0,    0,  161,
    0,   46,  112,  113,  114,   50,    0,  115,    0,   19,
    1,    2,    3,    0,    0,    0,    0,    4,    0,    0,
   40,    0,   41,    0,   42,    0,   43,   44,   45,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  162,   46,
  112,  113,  114,   50,    0,  115,    0,   19,    1,    2,
    3,    0,    0,    0,    0,    4,    0,    0,   40,    0,
   41,    0,   42,    0,   43,   44,   45,    0,    0,  180,
    0,    0,    0,    0,    0,    0,    0,   46,  112,  113,
  114,   50,    0,  115,    0,   19,    1,    2,    3,    0,
    0,    0,    0,    4,    0,    0,   40,    0,   41,    0,
   42,    0,   43,   44,   45,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,   46,   47,   48,   49,   50,
    0,   51,    0,   19,    1,    2,    3,    0,    0,    0,
    0,    4,    0,    0,    6,    0,    7,   14,    8,    0,
    9,   10,   11,   12,    0,    0,    0,    0,    0,    0,
    0,    0,    0,   13,   14,   15,   16,   17,    0,   14,
   14,   19,   14,    0,   14,   14,   14,    0,  169,    0,
    0,    0,   14,   14,   14,   40,    0,   41,   96,   42,
    0,   43,   44,   45,    0,    6,    0,    7,    0,    8,
    0,    9,   10,   11,   46,  170,    0,  171,    0,    0,
  172,    0,   19,    0,   13,   97,  150,   98,    0,    0,
    0,    0,   19,    6,    0,    7,    0,    8,    0,    9,
   10,   11,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,   13,  151,    0,  152,    0,    0,    0,    0,
   19,
  );
 $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyCheck'] = array(             5,
    0,   23,   22,    0,   21,   21,   29,   21,    0,   40,
   22,    5,   23,   36,   10,   21,   36,   21,   52,   23,
   37,    0,   25,   52,   36,   36,   41,   42,   43,   44,
   45,   37,    0,   36,   12,   41,   42,   43,   44,   45,
   37,   37,   10,   23,   36,   37,   52,   41,   42,   43,
   44,   45,   69,   69,    0,   69,   36,   36,   52,   65,
   32,   10,   12,   69,   10,   10,   39,   35,   41,   37,
   64,  105,  106,  107,  108,  109,  105,  106,  107,  108,
  109,   85,   25,   12,  101,   52,   35,  102,  110,   35,
   37,   37,   21,   36,    7,  101,  102,   27,   65,  105,
  106,  107,  108,  109,    5,    6,   36,   39,  102,    5,
    6,  105,  106,  107,  108,  109,    8,    9,   10,   11,
   28,  155,    7,   12,  130,   17,  155,   27,   36,    0,
  146,  165,   21,   35,   36,  135,   36,   28,  105,  106,
  107,  108,  109,   29,    8,   36,    1,    2,    3,  155,
   36,   22,   23,    8,   25,   36,   27,   28,   29,  176,
  176,  155,  176,  130,   35,   36,   37,    1,    2,    3,
  176,  165,    5,    6,   66,    5,    6,   35,   36,   67,
    1,    2,    3,    0,   76,    5,    6,    8,  155,   10,
   11,   83,   13,    0,   15,    0,   17,   18,   19,   20,
    1,    2,    3,    5,    6,    6,    0,    8,    0,   30,
   31,   32,   33,   34,   50,   36,   37,   38,    1,    2,
    3,  103,   36,   64,  148,    8,  167,   10,   11,    4,
   13,   -1,   15,   -1,   17,   18,   19,   20,    1,    2,
    3,   -1,   -1,    6,   -1,    8,   -1,   30,   31,   32,
   33,   34,   -1,   -1,   37,   38,    1,    2,    3,   -1,
    1,    2,    3,    8,   -1,    6,   11,    8,   13,   -1,
   15,   -1,   17,   18,   19,   20,    1,    2,    3,   -1,
   -1,    6,   -1,    8,   -1,   30,   31,   32,   33,   34,
   -1,   36,   -1,   38,    1,    2,    3,   -1,   -1,   -1,
   -1,    8,   -1,   10,   11,   -1,   13,    4,   15,   -1,
   17,   18,   19,   20,   11,   -1,   13,   -1,   15,   -1,
   17,   18,   19,   30,   31,   32,   33,   34,    1,    2,
    3,   38,   -1,   30,   31,    8,   33,   -1,   11,   36,
   13,   38,   15,   -1,   17,   18,   19,    1,    2,    3,
   23,   -1,    6,   -1,    8,   -1,   -1,   30,   31,   32,
   33,   34,   -1,   36,   -1,   38,    1,    2,    3,   -1,
    1,    2,    3,    8,   -1,    6,   11,    8,   13,   -1,
   15,   -1,   17,   18,   19,   -1,   -1,   -1,   -1,   -1,
   25,   -1,   -1,   -1,   -1,   30,   31,   32,   33,   34,
   -1,   36,   -1,   38,    1,    2,    3,   -1,   -1,   -1,
   -1,    8,   -1,   -1,   11,   -1,   13,   -1,   15,   -1,
   17,   18,   19,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   27,   -1,   -1,   30,   31,   32,   33,   34,   -1,   36,
   -1,   38,    1,    2,    3,   -1,   -1,   -1,   -1,    8,
   -1,   -1,   11,   -1,   13,   -1,   15,   -1,   17,   18,
   19,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   28,
   -1,   30,   31,   32,   33,   34,   -1,   36,   -1,   38,
    1,    2,    3,   -1,   -1,   -1,   -1,    8,   -1,   -1,
   11,   -1,   13,   -1,   15,   -1,   17,   18,   19,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,
   31,   32,   33,   34,   -1,   36,   -1,   38,    1,    2,
    3,   -1,   -1,   -1,   -1,    8,   -1,   -1,   11,   -1,
   13,   -1,   15,   -1,   17,   18,   19,   -1,   -1,   22,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   30,   31,   32,
   33,   34,   -1,   36,   -1,   38,    1,    2,    3,   -1,
   -1,   -1,   -1,    8,   -1,   -1,   11,   -1,   13,   -1,
   15,   -1,   17,   18,   19,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   30,   31,   32,   33,   34,
   -1,   36,   -1,   38,    1,    2,    3,   -1,   -1,   -1,
   -1,    8,   -1,   -1,   11,   -1,   13,    0,   15,   -1,
   17,   18,   19,   20,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   30,   31,   32,   33,   34,   -1,   22,
   23,   38,   25,   -1,   27,   28,   29,   -1,    4,   -1,
   -1,   -1,   35,   36,   37,   11,   -1,   13,    4,   15,
   -1,   17,   18,   19,   -1,   11,   -1,   13,   -1,   15,
   -1,   17,   18,   19,   30,   31,   -1,   33,   -1,   -1,
   36,   -1,   38,   -1,   30,   31,    4,   33,   -1,   -1,
   -1,   -1,   38,   11,   -1,   13,   -1,   15,   -1,   17,
   18,   19,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   30,   31,   -1,   33,   -1,   -1,   -1,   -1,
   38,
  );

  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyFinal'] = 20;
//t$GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyRule'] = array(
//t   "\$accept :  docblock ",
//t    "docblock :  paragraph ",
//t    "docblock :  paragraph   tags ",
//t    "docblock :  paragraph   text   tags ",
//t    "docblock :  paragraph   text ",
//t    "docblock :  tags ",
//t    "docblock :  paragraphs_with_p ",
//t    "docblock :  paragraphs_with_p   tags ",
//t    "text :  T_DOUBLE_NL   paragraphs ",
//t    "tags :  T_TAG ",
//t    "tags :  T_TAG   T_TEXT ",
//t    "tags :  T_TAG   T_TEXT   paragraphs ",
//t    "paragraphs :",
//t    "paragraphs :  paragraph ",
//t    "paragraphs :  paragraphs   T_DOUBLE_NL   paragraph ",
//t    "paragraphs_with_p :  paragraph_with_p ",
//t    "paragraphs_with_p :  paragraphs_with_p   paragraph_with_p ",
//t    "text_expr_with_p :  T_TEXT ",
//t    "text_expr_with_p :  htmltag_with_p ",
//t    "text_expr_with_p :  simplelist_with_p ",
//t    "text_expr_with_p :  inlinetag ",
//t    "text_expr_with_p :  internaltag_with_p ",
//t    "text_expr_with_p :  T_ESCAPED_TAG ",
//t    "text_expr_with_p :  T_INLINE_ESC ",
//t    "text_expr_with_p :  T_DOUBLE_NL ",
//t    "text_expr_with_p :  text_expr_with_p   T_TEXT ",
//t    "text_expr_with_p :  text_expr_with_p   htmltag_with_p ",
//t    "text_expr_with_p :  text_expr_with_p   simplelist_with_p ",
//t    "text_expr_with_p :  text_expr_with_p   inlinetag ",
//t    "text_expr_with_p :  text_expr_with_p   internaltag_with_p ",
//t    "text_expr_with_p :  text_expr_with_p   T_ESCAPED_TAG ",
//t    "text_expr_with_p :  text_expr_with_p   T_INLINE_ESC ",
//t    "text_expr_with_p :  text_expr_with_p   T_DOUBLE_NL ",
//t    "paragraph :  T_TEXT ",
//t    "paragraph :  htmltag ",
//t    "paragraph :  simplelist ",
//t    "paragraph :  inlinetag ",
//t    "paragraph :  internaltag ",
//t    "paragraph :  T_ESCAPED_TAG ",
//t    "paragraph :  T_CLOSE_P ",
//t    "paragraph :  T_INLINE_ESC ",
//t    "paragraph :  paragraph   T_TEXT ",
//t    "paragraph :  paragraph   htmltag ",
//t    "paragraph :  paragraph   simplelist ",
//t    "paragraph :  paragraph   inlinetag ",
//t    "paragraph :  paragraph   T_ESCAPED_TAG ",
//t    "paragraph :  paragraph   T_OPEN_P ",
//t    "paragraph :  paragraph   T_CLOSE_P ",
//t    "paragraph :  paragraph   T_INLINE_ESC ",
//t    "paragraph :  paragraph   internaltag ",
//t    "paragraph_with_p :  T_OPEN_P   text_expr_with_p   T_CLOSE_P ",
//t    "paragraph_with_p :  T_OPEN_P   text_expr_with_p   T_CLOSE_P   T_WHITESPACE ",
//t    "paragraph_with_p :  T_OPEN_P   text_expr_with_p ",
//t    "htmltag :  T_XML_TAG ",
//t    "htmltag :  btag ",
//t    "htmltag :  codetag ",
//t    "htmltag :  samptag ",
//t    "htmltag :  kbdtag ",
//t    "htmltag :  vartag ",
//t    "htmltag :  htmllist ",
//t    "htmltag_with_p :  T_XML_TAG ",
//t    "htmltag_with_p :  btag_with_p ",
//t    "htmltag_with_p :  codetag_with_p ",
//t    "htmltag_with_p :  samptag_with_p ",
//t    "htmltag_with_p :  kbdtag_with_p ",
//t    "htmltag_with_p :  vartag_with_p ",
//t    "htmltag_with_p :  htmllist_with_p ",
//t    "btag :  T_OPEN_B   paragraphs   T_CLOSE_B ",
//t    "btag_with_p :  T_OPEN_B   text_expr_with_p   T_CLOSE_B ",
//t    "codetag :  T_OPEN_CODE   paragraphs   T_CLOSE_CODE ",
//t    "codetag_with_p :  T_OPEN_CODE   text_expr_with_p   T_CLOSE_CODE ",
//t    "samptag :  T_OPEN_SAMP   paragraphs   T_CLOSE_SAMP ",
//t    "samptag_with_p :  T_OPEN_SAMP   text_expr_with_p   T_CLOSE_SAMP ",
//t    "kbdtag :  T_OPEN_KBD   paragraphs   T_CLOSE_KBD ",
//t    "kbdtag_with_p :  T_OPEN_KBD   text_expr_with_p   T_CLOSE_KBD ",
//t    "vartag :  T_OPEN_VAR   paragraphs   T_CLOSE_VAR ",
//t    "vartag_with_p :  T_OPEN_VAR   text_expr_with_p   T_CLOSE_VAR ",
//t    "htmllist :  T_OPEN_LIST   listitems   T_CLOSE_LIST ",
//t    "htmllist_with_p :  T_OPEN_LIST   listitems_with_p   T_CLOSE_LIST ",
//t    "listitems :  listitem ",
//t    "listitems :  listitems   listitem ",
//t    "listitems_with_p :  listitem_with_p ",
//t    "listitems_with_p :  listitems_with_p   listitem_with_p ",
//t    "listitem :  T_OPEN_LI   paragraphs   T_CLOSE_LI ",
//t    "listitem_with_p :  T_OPEN_LI   text_expr_with_p   T_CLOSE_LI ",
//t    "simplelist :  simplelist_entry   T_SIMPLELIST_END ",
//t    "simplelist :  simplelist_entries   T_SIMPLELIST_END ",
//t    "simplelist :  simplelist_entries   simplelist_entry   T_SIMPLELIST_END ",
//t    "simplelist_with_p :  simplelist_entry_with_p   T_SIMPLELIST_END ",
//t    "simplelist_with_p :  simplelist_entries_with_p   T_SIMPLELIST_END ",
//t    "simplelist_with_p :  simplelist_entries_with_p   simplelist_entry_with_p   T_SIMPLELIST_END ",
//t    "simplelist_entry :  bullet   simplelist_contents ",
//t    "simplelist_entry_with_p :  bullet   simplelist_contents_with_p ",
//t    "simplelist_entries :  simplelist_entry   T_SIMPLELIST_NL ",
//t    "simplelist_entries :  simplelist_entry   T_SIMPLELIST_NL   nested_simplelist ",
//t    "simplelist_entries :  simplelist_entries   simplelist_entry   T_SIMPLELIST_NL ",
//t    "simplelist_entries :  simplelist_entries   simplelist_entry   T_SIMPLELIST_NL   nested_simplelist ",
//t    "simplelist_entries_with_p :  simplelist_entry_with_p   T_SIMPLELIST_NL ",
//t    "simplelist_entries_with_p :  simplelist_entry_with_p   T_SIMPLELIST_NL   nested_simplelist_with_p ",
//t    "simplelist_entries_with_p :  simplelist_entries_with_p   simplelist_entry_with_p   T_SIMPLELIST_NL ",
//t    "simplelist_entries_with_p :  simplelist_entries_with_p   simplelist_entry_with_p   T_SIMPLELIST_NL   nested_simplelist_with_p ",
//t    "bullet :  bullet_no_whitespace ",
//t    "bullet :  T_WHITESPACE   bullet_no_whitespace ",
//t    "bullet_no_whitespace :  T_BULLET ",
//t    "bullet_no_whitespace :  T_NBULLET ",
//t    "bullet_no_whitespace :  T_NDBULLET ",
//t    "nested_simplelist :  T_SIMPLELIST_START   simplelist ",
//t    "nested_simplelist_with_p :  T_SIMPLELIST_START   simplelist_with_p ",
//t    "simplelist_contents :  T_SIMPLELIST ",
//t    "simplelist_contents :  T_ESCAPED_TAG ",
//t    "simplelist_contents :  inlinetag ",
//t    "simplelist_contents :  T_INLINE_ESC ",
//t    "simplelist_contents :  htmltag ",
//t    "simplelist_contents :  simplelist_contents   T_SIMPLELIST ",
//t    "simplelist_contents :  simplelist_contents   T_ESCAPED_TAG ",
//t    "simplelist_contents :  simplelist_contents   inlinetag ",
//t    "simplelist_contents :  simplelist_contents   T_INLINE_ESC ",
//t    "simplelist_contents :  simplelist_contents   htmltag ",
//t    "simplelist_contents_with_p :  T_SIMPLELIST ",
//t    "simplelist_contents_with_p :  T_ESCAPED_TAG ",
//t    "simplelist_contents_with_p :  inlinetag ",
//t    "simplelist_contents_with_p :  T_INLINE_ESC ",
//t    "simplelist_contents_with_p :  T_DOUBLE_NL ",
//t    "simplelist_contents_with_p :  htmltag_with_p ",
//t    "simplelist_contents_with_p :  simplelist_contents_with_p   T_SIMPLELIST ",
//t    "simplelist_contents_with_p :  simplelist_contents_with_p   T_ESCAPED_TAG ",
//t    "simplelist_contents_with_p :  simplelist_contents_with_p   inlinetag ",
//t    "simplelist_contents_with_p :  simplelist_contents_with_p   T_INLINE_ESC ",
//t    "simplelist_contents_with_p :  simplelist_contents_with_p   T_DOUBLE_NL ",
//t    "simplelist_contents_with_p :  simplelist_contents_with_p   htmltag_with_p ",
//t    "inlinetag :  T_INLINE_TAG_OPEN   T_INLINE_TAG_NAME   T_INLINE_TAG_CONTENTS   T_INLINE_TAG_CLOSE ",
//t    "inlinetag :  T_INLINE_TAG_OPEN   T_INLINE_TAG_NAME   T_INLINE_TAG_CLOSE ",
//t    "internaltag :  T_INTERNAL   paragraphs   T_ENDINTERNAL ",
//t    "internaltag_with_p :  T_INTERNAL   paragraphs_with_p   T_ENDINTERNAL ",
//t  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyName'] =array(    
    "end-of-file","T_BULLET","T_NBULLET","T_NDBULLET","T_SIMPLELIST",
    "T_SIMPLELIST_NL","T_SIMPLELIST_END","T_SIMPLELIST_START",
    "T_WHITESPACE","T_NESTED_LIST","T_OPEN_P","T_OPEN_LIST","T_OPEN_LI",
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
    null,null,null,null,null,null,null,null,null,null,null,"EOF",
  );
 ?>
