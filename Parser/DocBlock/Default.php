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


    function _1($yyTop)  					// line 537 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->paragraphs = array($this->yyVals[0+$yyTop]);
        }

    function _2($yyTop)  					// line 541 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->paragraphs = $this->yyVals[-1+$yyTop];
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _3($yyTop)  					// line 546 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            array_unshift($this->yyVals[-1+$yyTop], $this->yyVals[-2+$yyTop]);
            $this->paragraphs = $this->yyVals[-1+$yyTop];
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _4($yyTop)  					// line 552 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            array_unshift($this->yyVals[0+$yyTop], $this->yyVals[-1+$yyTop]);
            $this->paragraphs = $this->yyVals[0+$yyTop];
        }

    function _5($yyTop)  					// line 557 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->paragraphs = $this->yyVals[-1+$yyTop];
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _6($yyTop)  					// line 562 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->tags = $this->yyVals[0+$yyTop];
        }

    function _7($yyTop)  					// line 570 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
        $this->yyVal = $this->yyVals[0+$yyTop];
    }

    function _8($yyTop)  					// line 577 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->tags[] = $this->_parseTag($this->yyVals[0+$yyTop], array());
        }

    function _9($yyTop)  					// line 581 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->tags[] = $this->_parseTag($this->yyVals[-1+$yyTop], $this->yyVals[0+$yyTop]);
        }

    function _10($yyTop)  					// line 585 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if (is_string($this->yyVals[0+$yyTop][0])) {
                $this->yyVals[0+$yyTop][0] = $this->yyVals[-1+$yyTop] . $this->yyVals[0+$yyTop][0];
            }
            $this->tags[] = $this->_parseTag($this->yyVals[-2+$yyTop], $this->yyVals[0+$yyTop]);
        }

    function _12($yyTop)  					// line 595 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _13($yyTop)  					// line 599 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _14($yyTop)  					// line 607 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _15($yyTop)  					// line 611 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _16($yyTop)  					// line 619 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _17($yyTop)  					// line 623 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _18($yyTop)  					// line 627 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _19($yyTop)  					// line 631 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _20($yyTop)  					// line 635 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _21($yyTop)  					// line 639 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
        }

    function _22($yyTop)  					// line 643 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _23($yyTop)  					// line 647 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _24($yyTop)  					// line 657 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _25($yyTop)  					// line 667 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
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
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _29($yyTop)  					// line 692 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _30($yyTop)  					// line 702 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _31($yyTop)  					// line 712 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _32($yyTop)  					// line 729 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _33($yyTop)  					// line 737 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _34($yyTop)  					// line 741 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _35($yyTop)  					// line 745 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _36($yyTop)  					// line 749 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _37($yyTop)  					// line 753 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _38($yyTop)  					// line 757 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
        }

    function _39($yyTop)  					// line 761 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _40($yyTop)  					// line 771 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _41($yyTop)  					// line 775 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _42($yyTop)  					// line 785 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
         }

    function _43($yyTop)  					// line 790 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _44($yyTop)  					// line 795 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _45($yyTop)  					// line 800 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _46($yyTop)  					// line 805 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _47($yyTop)  					// line 815 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _48($yyTop)  					// line 831 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _49($yyTop)  					// line 844 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _50($yyTop)  					// line 848 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-2+$yyTop];
        }

    function _51($yyTop)  					// line 852 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[0+$yyTop];
        }

    function _52($yyTop)  					// line 859 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['completeTagClass'];
            if ($tag) {
                $this->yyVal = array(new $tag($this->yyVals[0+$yyTop]));
            } else {
                $this->yyVal = array(array('completetag' => $this->yyVals[0+$yyTop]));
            }
        }

    function _59($yyTop)  					// line 877 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['completeTagClass'];
            if ($tag) {
                $this->yyVal = array(new $tag($this->yyVals[0+$yyTop]));
            } else {
                $this->yyVal = array(array('completetag' => $this->yyVals[0+$yyTop]));
            }
        }

    function _66($yyTop)  					// line 895 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['boldClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('strong' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _67($yyTop)  					// line 907 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['boldClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('strong' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _68($yyTop)  					// line 919 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['codeClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('code' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _69($yyTop)  					// line 931 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['codeClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('code' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _70($yyTop)  					// line 943 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['sampClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('samp' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _71($yyTop)  					// line 955 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['sampClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('samp' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _72($yyTop)  					// line 967 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['kbdClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('kbd' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _73($yyTop)  					// line 979 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['kbdClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('kbd' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _74($yyTop)  					// line 991 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['varClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('var' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _75($yyTop)  					// line 1003 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $tag = $this->_options['varClass'];
            if ($tag) {
                $this->yyVal = new $tag($this->yyVals[-1+$yyTop]);
            } else {
                $this->yyVal = array('var' =>  $this->yyVals[-1+$yyTop]);
            }
        }

    function _76($yyTop)  					// line 1015 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $list = $this->_options['listClass'];
            if ($list) {
                $this->yyVal = new $list(2);
            } else {
                $this->yyVal = array('list' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _77($yyTop)  					// line 1027 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $list = $this->_options['listClass'];
            if ($list) {
                $this->yyVal = new $list(2);
            } else {
                $this->yyVal = array('list' => $this->yyVals[-1+$yyTop]);
            }
        }

    function _78($yyTop)  					// line 1039 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _79($yyTop)  					// line 1043 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _80($yyTop)  					// line 1051 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _81($yyTop)  					// line 1055 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _82($yyTop)  					// line 1063 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _83($yyTop)  					// line 1070 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
        }

    function _84($yyTop)  					// line 1077 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _85($yyTop)  					// line 1081 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-3+$yyTop];
            $this->yyVal[] = $this->yyVals[-1+$yyTop];
        }

    function _86($yyTop)  					// line 1089 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _87($yyTop)  					// line 1093 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-3+$yyTop];
            $this->yyVal[] = $this->yyVals[-1+$yyTop];
        }

    function _88($yyTop)  					// line 1101 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'unordered';
        }

    function _89($yyTop)  					// line 1105 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'ordered';
        }

    function _90($yyTop)  					// line 1109 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'ordered';
        }

    function _92($yyTop)  					// line 1117 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'unordered';
        }

    function _93($yyTop)  					// line 1121 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'ordered';
        }

    function _94($yyTop)  					// line 1125 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = 'ordered';
        }

    function _99($yyTop)  					// line 1140 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _100($yyTop)  					// line 1144 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array(str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]));
        }

    function _101($yyTop)  					// line 1148 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _102($yyTop)  					// line 1152 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _103($yyTop)  					// line 1162 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _104($yyTop)  					// line 1166 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _105($yyTop)  					// line 1170 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _106($yyTop)  					// line 1175 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _107($yyTop)  					// line 1184 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _108($yyTop)  					// line 1189 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _109($yyTop)  					// line 1205 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _110($yyTop)  					// line 1210 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _112($yyTop)  					// line 1219 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
        }

    function _113($yyTop)  					// line 1223 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _114($yyTop)  					// line 1227 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->yyVals[0+$yyTop] == '{@}') {
                $this->yyVal = array('{@');
            } elseif ($this->yyVals[0+$yyTop] == '{@*}') {
                $this->yyVal = array('*/');
            } else {
                $this->yyVal = array('');
            }
        }

    function _115($yyTop)  					// line 1237 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _116($yyTop)  					// line 1241 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _117($yyTop)  					// line 1245 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array($this->yyVals[0+$yyTop]);
        }

    function _118($yyTop)  					// line 1249 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _119($yyTop)  					// line 1254 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            } else {
                $this->yyVal[] = str_replace(array('<<', '>>', '/'), array('<', '>', ''), $this->yyVals[0+$yyTop]);
            }
        }

    function _120($yyTop)  					// line 1264 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _121($yyTop)  					// line 1269 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
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

    function _122($yyTop)  					// line 1286 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $index = count($this->yyVal) - 1;
            if (is_string($this->yyVal[$index])) {
                $this->yyVal[$index] .= $this->yyVals[0+$yyTop];
            } else {
                $this->yyVal[] = $this->yyVals[0+$yyTop];
            }
        }

    function _123($yyTop)  					// line 1296 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _124($yyTop)  					// line 1301 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->yyVals[-1+$yyTop];
            $this->yyVal[] = $this->yyVals[0+$yyTop];
        }

    function _125($yyTop)  					// line 1309 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _126($yyTop)  					// line 1316 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = array('list' => $this->yyVals[-1+$yyTop], 'type' => $this->yyVals[-2+$yyTop]);
        }

    function _127($yyTop)  					// line 1323 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->_parseInlineTag($this->yyVals[-2+$yyTop], $this->yyVals[-1+$yyTop]);
        }

    function _128($yyTop)  					// line 1327 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            $this->yyVal = $this->_parseInlineTag($this->yyVals[-1+$yyTop], array());
        }

    function _129($yyTop)  					// line 1334 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->_options['parseInternal']) {
                $this->yyVal = $this->yyVals[-1+$yyTop];
            } else {
                $this->yyVal = '';
            }
        }

    function _130($yyTop)  					// line 1345 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"
    {
            if ($this->_options['parseInternal']) {
                $this->yyVal = $this->yyVals[-1+$yyTop];
            } else {
                $this->yyVal = '';
            }
        }
					// line 1560 "-"

					// line 1353 "C:/devel/PHP_Parser/Parser/DocBlock/Default.jay"

    /**#@-*/
}
					// line 1566 "-"

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
   92,   93,   94,  105,    0,   96,  106,  108,   97,  109,
  107,   84,  110,    0,    0,   77,   81,   69,   67,   73,
   75,   71,  130,   50,    0,  118,  119,  121,  122,  120,
  123,   86,  124,    0,   82,    0,  127,   85,    0,  125,
   83,   87,  126,   98,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyDgoto']  = array(            20,
   64,   22,   80,   23,   65,   24,   25,   26,   27,   28,
   50,   51,   52,   53,   29,   30,   31,   32,   33,   34,
   54,   55,   56,   57,   58,   59,   62,   98,   63,   99,
   35,   94,  152,  122,   95,   96,  124,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yySindex'] = array(          387,
    0,    0,    0,  210,  716,   13,  753,  753,  753,  753,
  753,    0,    0,    0,    0,    0,  753,   30,  112,    0,
  278,    0,   71,    0,    0,  210,    0,    0,    0,    0,
    0,    0,    0,    0,  848,    0,  129,  716,  716,  716,
  716,  716,    0,    0,    0,    0,  187,    0,    0,  424,
    0,  210,    0,    0,    0,    0,    0,    0,    0,  818,
  753,  119,    0,  461,   28,   31,  -14,   85,  193,  131,
  753,  194,    0,    0,    0,    0,    0,  753,    0,   74,
    0,  210,    0,    0,    0,    0,  848,    0,  238,    0,
    0,    0,    0,   69,  848,    0,  716,  162,    0,  494,
  531,  568,  605,  642,  107,  147,    0,    0,    0,    0,
    0,    0,  210,    0,  818,    0,    0,    0,    0,    0,
    0,   35,  818,    0,   33,    0,    0,    0,  753,    0,
    0,    0,    0,    0,  165,    0,  170,  165,    0,   69,
    0,    0,    0,    0,  209,    0,    0,    0,    0,    0,
    0,    0,    0,   69,  679,    0,    0,    0,    0,    0,
    0,    0,    0,    0,   35,    0,    0,    0,    0,    0,
    0,    0,    0,   35,    0,  461,    0,    0,  230,    0,
    0,    0,    0,    0,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyRindex'] = array(            0,
    0,    0,    0,    0,    0,    0,   36,   99,   82,  101,
  202,    0,    0,    0,    0,    0,  145,  242,    0,    0,
  244,    0,    0,    0,    0,  312,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,   75,
    0,  872,    0,    0,    0,    0,    0,    0,    0,    0,
   97,    0,    0,  773,    0,    0,    0,    0,    0,    0,
  100,    0,    0,    0,    0,    0,    0,   89,    0,  245,
    0,  350,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,   95,    0,    0,    0,    0,
    0,    0,  901,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,  246,    0,    0,   56,    0,    0,
    0,    0,    0,    0,    1,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  789,    0,    0,    0,    0,
    0,    0,    0,    0,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyGindex'] = array(            0,
    8,   23,    0,  207,  136,  -23,   27,   -7,   55,   -5,
  222,   83,   88,  149,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,  203,  157,
  122,  106,   93,   79,   53,  -52,  -96,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyTable'] = array(            86,
   95,   95,   95,   95,   95,   95,   95,   21,   95,   95,
   95,  131,   95,   82,   95,   84,   95,   95,   95,   95,
  129,   95,   95,   61,   95,  173,   95,   95,   95,   95,
   95,   95,   95,   95,   95,   95,   95,   95,  166,  145,
  146,  153,   89,   79,   37,   85,   38,   81,   39,  128,
   40,   41,   42,  175,  130,    7,   82,   11,   84,   49,
   71,   92,  129,   43,  167,  129,  168,  129,  173,  169,
   11,   19,  144,  145,  146,   83,   89,  173,    6,    5,
    7,   86,    8,   51,    9,   10,   11,  153,   11,   93,
   81,    7,   49,   49,   49,   49,   49,   13,  147,    9,
  148,  153,  139,   49,  111,   19,   18,   11,   51,   18,
   51,  132,  123,   92,  120,    5,   11,   11,   83,  129,
  150,   92,   11,   11,   11,   36,   60,   11,   49,   61,
   49,   11,  112,   11,   11,   11,  176,  113,  126,   97,
  163,   93,  121,   66,   67,   68,   69,   87,  151,   93,
   72,   49,   70,  164,  111,  111,  111,  111,  111,   60,
   60,   60,   60,   60,  134,  129,  150,  123,   82,  120,
   84,   60,   97,  115,  123,  123,  170,  120,   11,   11,
  150,  156,  112,  112,  112,  112,  112,  113,  113,  113,
  113,  113,  140,  165,  151,    5,  125,  121,  114,  129,
  154,  174,   81,   87,  171,  121,  135,  177,  151,  111,
    1,    2,    3,  138,  172,  179,    4,  123,   60,  170,
  133,   60,   60,   60,   60,   60,  123,  129,  170,   11,
   83,  136,  178,  137,  115,  184,   11,  112,  141,  142,
  143,    8,  113,    1,    4,   10,  180,  171,  114,  114,
  114,  114,  114,  105,  157,    0,  171,  182,   95,  100,
  101,  102,  103,  104,  127,    0,  183,    0,    0,    0,
    0,    0,    0,    0,    0,    0,   60,    0,    1,    2,
    3,    0,    0,    0,    4,    0,   73,    6,    0,    7,
    0,    8,  149,    9,   10,   11,   74,    0,    0,    0,
    0,    0,    0,  114,    0,    0,   13,   75,   76,   77,
   17,   18,   78,   18,   19,    0,    0,    0,  155,    0,
   18,   18,    0,   18,    0,   18,  149,   18,   18,   18,
   18,    0,   18,   18,    0,   18,    0,   18,   18,   18,
   18,   18,   18,   18,   18,   18,   18,   18,   18,   26,
    0,    0,    0,    0,    0,    0,    0,    0,   26,   26,
    0,   26,    0,   26,    0,   26,   26,   26,   26,    0,
   26,   26,    0,   26,    0,   26,   26,   26,   26,   26,
   26,   26,   26,   26,   26,   26,   26,    1,    2,    3,
    0,    0,    0,    4,    0,    5,    6,    0,    7,    0,
    8,    0,    9,   10,   11,   12,    0,    0,    0,    0,
    0,    0,    0,    0,    0,   13,   14,   15,   16,   17,
    0,    0,   18,   19,    1,    2,    3,    0,    0,    0,
    4,    0,    0,   37,    0,   38,    0,   39,    0,   40,
   41,   42,  106,    0,    0,    0,    0,    0,    0,    0,
    0,    0,   43,  107,  108,  109,   47,    0,  110,    0,
   19,    1,    2,    3,    0,    0,    0,    4,    0,   73,
    6,    0,    7,    0,    8,    0,    9,   10,   11,   74,
    0,    0,    0,    0,    0,    0,    0,    0,    0,   13,
   75,   76,   77,   17,    1,    2,    3,   19,    0,    0,
    4,    0,    0,   37,    0,   38,    0,   39,    0,   40,
   41,   42,    0,    0,    0,  158,    0,    0,    0,    0,
    0,    0,   43,  107,  108,  109,   47,    0,  110,    0,
   19,    1,    2,    3,    0,    0,    0,    4,    0,    0,
   37,    0,   38,    0,   39,    0,   40,   41,   42,    0,
    0,    0,    0,    0,  159,    0,    0,    0,    0,   43,
  107,  108,  109,   47,    0,  110,    0,   19,    1,    2,
    3,    0,    0,    0,    4,    0,    0,   37,    0,   38,
    0,   39,    0,   40,   41,   42,    0,    0,    0,    0,
    0,    0,    0,  160,    0,    0,   43,  107,  108,  109,
   47,    0,  110,    0,   19,    1,    2,    3,    0,    0,
    0,    4,    0,    0,   37,    0,   38,    0,   39,    0,
   40,   41,   42,    0,    0,    0,    0,    0,    0,    0,
    0,  161,    0,   43,  107,  108,  109,   47,    0,  110,
    0,   19,    1,    2,    3,    0,    0,    0,    4,    0,
    0,   37,    0,   38,    0,   39,    0,   40,   41,   42,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  162,
   43,  107,  108,  109,   47,    0,  110,    0,   19,    1,
    2,    3,    0,    0,    0,    4,    0,    0,   37,    0,
   38,    0,   39,    0,   40,   41,   42,    0,    0,  181,
    0,    0,    0,    0,    0,    0,    0,   43,  107,  108,
  109,   47,    0,  110,    0,   19,    1,    2,    3,    0,
    0,    0,    4,    0,    0,   37,    0,   38,    0,   39,
    0,   40,   41,   42,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,   43,   44,   45,   46,   47,    0,
   48,    0,   19,    1,    2,    3,    0,    0,    0,    4,
    0,    0,    6,    0,    7,    0,    8,    0,    9,   10,
   11,   12,   12,    0,    0,    0,    0,    0,    0,    0,
    0,   13,   14,   15,   16,   17,    0,    0,   13,   19,
    0,    0,    0,   12,   12,    0,   12,    0,   12,   12,
   12,    0,    0,    0,    0,    0,   12,   12,   12,   13,
   13,    0,   13,    0,   13,   13,   13,    0,    0,    0,
    0,  116,   13,   13,   13,   89,    0,   37,    0,   38,
    0,   39,    0,   40,   41,   42,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,   43,  117,    0,  118,
    0,   88,  119,    0,   19,   89,    0,    6,    0,    7,
    0,    8,    0,    9,   10,   11,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,   13,   90,    0,   91,
   35,   35,    0,   35,   19,   35,    0,   35,   35,   35,
   35,    0,   35,   35,    0,   35,    0,   35,   35,   35,
   35,   35,   35,   35,   35,   35,   35,   35,   35,   43,
   43,    0,   43,    0,   43,    0,   43,   43,   43,   43,
    0,   43,   43,    0,   43,    0,   43,   43,   43,   43,
   43,   43,   43,   43,   43,   43,   43,   43,
  );
 $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyCheck'] = array(            23,
    0,    1,    2,    3,    4,    5,    6,    0,    8,    9,
   10,   26,   12,   21,   14,   21,   16,   17,   18,   19,
   35,   21,   22,   11,   24,  122,   26,   27,   28,   29,
   30,   31,   32,   33,   34,   35,   36,   37,    4,    5,
    6,   94,    8,   21,   10,   23,   12,   21,   14,   22,
   16,   17,   18,   21,   24,    0,   64,   22,   64,    5,
   31,   35,   35,   29,   30,   35,   32,   35,  165,   35,
   35,   37,    4,    5,    6,   21,    8,  174,   10,    9,
   12,  105,   14,    9,   16,   17,   18,  140,    0,   35,
   64,   36,   38,   39,   40,   41,   42,   29,   30,    0,
   32,  154,   80,    9,   50,   37,   36,   26,   34,   36,
   36,   27,   60,   87,   60,    9,   35,   21,   64,   35,
   94,   95,   24,   35,   36,    4,    5,   27,   34,   11,
   36,   35,   50,   35,   35,   35,  129,   50,   20,   11,
   34,   87,   60,    8,    9,   10,   11,   26,   94,   95,
   39,   97,   17,    7,  100,  101,  102,  103,  104,   38,
   39,   40,   41,   42,   34,   35,  140,  115,  176,  115,
  176,   50,   11,   52,  122,  123,  122,  123,   34,   35,
  154,   20,  100,  101,  102,  103,  104,  100,  101,  102,
  103,  104,   87,  115,  140,    9,   61,  115,   50,   35,
   95,  123,  176,   82,  122,  123,   71,   38,  154,  155,
    1,    2,    3,   78,  122,    7,    7,  165,   97,  165,
   28,  100,  101,  102,  103,  104,  174,   35,  174,   28,
  176,   38,  140,   40,  113,    6,   35,  155,    1,    2,
    3,    0,  155,    0,    0,    0,  154,  165,  100,  101,
  102,  103,  104,   47,   98,   -1,  174,  165,  258,   38,
   39,   40,   41,   42,   62,   -1,  174,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,  155,   -1,    1,    2,
    3,   -1,   -1,   -1,    7,   -1,    9,   10,   -1,   12,
   -1,   14,  258,   16,   17,   18,   19,   -1,   -1,   -1,
   -1,   -1,   -1,  155,   -1,   -1,   29,   30,   31,   32,
   33,    0,   35,   36,   37,   -1,   -1,   -1,   97,   -1,
    9,   10,   -1,   12,   -1,   14,  258,   16,   17,   18,
   19,   -1,   21,   22,   -1,   24,   -1,   26,   27,   28,
   29,   30,   31,   32,   33,   34,   35,   36,   37,    0,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,    9,   10,
   -1,   12,   -1,   14,   -1,   16,   17,   18,   19,   -1,
   21,   22,   -1,   24,   -1,   26,   27,   28,   29,   30,
   31,   32,   33,   34,   35,   36,   37,    1,    2,    3,
   -1,   -1,   -1,    7,   -1,    9,   10,   -1,   12,   -1,
   14,   -1,   16,   17,   18,   19,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   29,   30,   31,   32,   33,
   -1,   -1,   36,   37,    1,    2,    3,   -1,   -1,   -1,
    7,   -1,   -1,   10,   -1,   12,   -1,   14,   -1,   16,
   17,   18,   19,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   29,   30,   31,   32,   33,   -1,   35,   -1,
   37,    1,    2,    3,   -1,   -1,   -1,    7,   -1,    9,
   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,   19,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,
   30,   31,   32,   33,    1,    2,    3,   37,   -1,   -1,
    7,   -1,   -1,   10,   -1,   12,   -1,   14,   -1,   16,
   17,   18,   -1,   -1,   -1,   22,   -1,   -1,   -1,   -1,
   -1,   -1,   29,   30,   31,   32,   33,   -1,   35,   -1,
   37,    1,    2,    3,   -1,   -1,   -1,    7,   -1,   -1,
   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,   -1,
   -1,   -1,   -1,   -1,   24,   -1,   -1,   -1,   -1,   29,
   30,   31,   32,   33,   -1,   35,   -1,   37,    1,    2,
    3,   -1,   -1,   -1,    7,   -1,   -1,   10,   -1,   12,
   -1,   14,   -1,   16,   17,   18,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   26,   -1,   -1,   29,   30,   31,   32,
   33,   -1,   35,   -1,   37,    1,    2,    3,   -1,   -1,
   -1,    7,   -1,   -1,   10,   -1,   12,   -1,   14,   -1,
   16,   17,   18,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   27,   -1,   29,   30,   31,   32,   33,   -1,   35,
   -1,   37,    1,    2,    3,   -1,   -1,   -1,    7,   -1,
   -1,   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   28,
   29,   30,   31,   32,   33,   -1,   35,   -1,   37,    1,
    2,    3,   -1,   -1,   -1,    7,   -1,   -1,   10,   -1,
   12,   -1,   14,   -1,   16,   17,   18,   -1,   -1,   21,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,   31,
   32,   33,   -1,   35,   -1,   37,    1,    2,    3,   -1,
   -1,   -1,    7,   -1,   -1,   10,   -1,   12,   -1,   14,
   -1,   16,   17,   18,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   29,   30,   31,   32,   33,   -1,
   35,   -1,   37,    1,    2,    3,   -1,   -1,   -1,    7,
   -1,   -1,   10,   -1,   12,   -1,   14,   -1,   16,   17,
   18,   19,    0,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   29,   30,   31,   32,   33,   -1,   -1,    0,   37,
   -1,   -1,   -1,   21,   22,   -1,   24,   -1,   26,   27,
   28,   -1,   -1,   -1,   -1,   -1,   34,   35,   36,   21,
   22,   -1,   24,   -1,   26,   27,   28,   -1,   -1,   -1,
   -1,    4,   34,   35,   36,    8,   -1,   10,   -1,   12,
   -1,   14,   -1,   16,   17,   18,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,   -1,   32,
   -1,    4,   35,   -1,   37,    8,   -1,   10,   -1,   12,
   -1,   14,   -1,   16,   17,   18,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,   -1,   32,
    9,   10,   -1,   12,   37,   14,   -1,   16,   17,   18,
   19,   -1,   21,   22,   -1,   24,   -1,   26,   27,   28,
   29,   30,   31,   32,   33,   34,   35,   36,   37,    9,
   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,   19,
   -1,   21,   22,   -1,   24,   -1,   26,   27,   28,   29,
   30,   31,   32,   33,   34,   35,   36,   37,
  );

  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyFinal'] = 20;
//t$GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULT']['yyRule'] = array(
//t   "\$accept :  docblock ",
//t    "docblock :  paragraph ",
//t    "docblock :  paragraph   tags ",
//t    "docblock :  paragraph   text   tags ",
//t    "docblock :  paragraph   text ",
//t    "docblock :  paragraphs_with_p   tags ",
//t    "docblock :  tags ",
//t    "text :  T_DOUBLE_NL   paragraphs ",
//t    "tags :  T_TAG ",
//t    "tags :  T_TAG   T_TEXT ",
//t    "tags :  T_TAG   T_TEXT   paragraphs ",
//t    "paragraphs :",
//t    "paragraphs :  paragraph ",
//t    "paragraphs :  paragraphs   T_DOUBLE_NL   paragraph ",
//t    "paragraphs_with_p :  paragraph_with_p ",
//t    "paragraphs_with_p :  paragraphs_with_p   paragraph_with_p ",
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
//t    "simplelist :  bullet   simplelist_contents   simplelistend ",
//t    "simplelist :  simplelist   bullet   simplelist_contents   simplelistend ",
//t    "simplelist_with_p :  bullet   simplelist_contents_with_p   simplelistend ",
//t    "simplelist_with_p :  simplelist_with_p   bullet   simplelist_contents_with_p   simplelistend ",
//t    "bullet :  T_BULLET ",
//t    "bullet :  T_NBULLET ",
//t    "bullet :  T_NDBULLET ",
//t    "bullet :  T_WHITESPACE   bullet ",
//t    "nested_bullet :  T_NESTED_WHITESPACE   T_BULLET ",
//t    "nested_bullet :  T_NESTED_WHITESPACE   T_NBULLET ",
//t    "nested_bullet :  T_NESTED_WHITESPACE   T_NDBULLET ",
//t    "simplelistend :  T_SIMPLELIST_NL ",
//t    "simplelistend :  T_SIMPLELIST_END ",
//t    "simplelistend :  EOF ",
//t    "simplelistend :  T_SIMPLELIST_NL   T_WHITESPACE   T_SIMPLELIST_END ",
//t    "simplelist_contents :  T_SIMPLELIST ",
//t    "simplelist_contents :  T_ESCAPED_TAG ",
//t    "simplelist_contents :  inlinetag ",
//t    "simplelist_contents :  T_INLINE_ESC ",
//t    "simplelist_contents :  htmltag ",
//t    "simplelist_contents :  nested_simplelist ",
//t    "simplelist_contents :  simplelist_contents   T_SIMPLELIST ",
//t    "simplelist_contents :  simplelist_contents   T_ESCAPED_TAG ",
//t    "simplelist_contents :  simplelist_contents   inlinetag ",
//t    "simplelist_contents :  simplelist_contents   T_INLINE_ESC ",
//t    "simplelist_contents :  simplelist_contents   htmltag ",
//t    "simplelist_contents :  simplelist_contents   nested_simplelist ",
//t    "simplelist_contents_with_p :  T_SIMPLELIST ",
//t    "simplelist_contents_with_p :  T_ESCAPED_TAG ",
//t    "simplelist_contents_with_p :  inlinetag ",
//t    "simplelist_contents_with_p :  T_INLINE_ESC ",
//t    "simplelist_contents_with_p :  T_DOUBLE_NL ",
//t    "simplelist_contents_with_p :  htmltag_with_p ",
//t    "simplelist_contents_with_p :  nested_simplelist_with_p ",
//t    "simplelist_contents_with_p :  simplelist_contents_with_p   T_SIMPLELIST ",
//t    "simplelist_contents_with_p :  simplelist_contents_with_p   T_ESCAPED_TAG ",
//t    "simplelist_contents_with_p :  simplelist_contents_with_p   inlinetag ",
//t    "simplelist_contents_with_p :  simplelist_contents_with_p   T_INLINE_ESC ",
//t    "simplelist_contents_with_p :  simplelist_contents_with_p   T_DOUBLE_NL ",
//t    "simplelist_contents_with_p :  simplelist_contents_with_p   htmltag_with_p ",
//t    "simplelist_contents_with_p :  simplelist_contents_with_p   nested_simplelist_with_p ",
//t    "nested_simplelist :  nested_bullet   simplelist_contents   simplelistend ",
//t    "nested_simplelist_with_p :  nested_bullet   simplelist_contents_with_p   simplelistend ",
//t    "inlinetag :  T_INLINE_TAG_OPEN   T_INLINE_TAG_NAME   T_INLINE_TAG_CONTENTS   T_INLINE_TAG_CLOSE ",
//t    "inlinetag :  T_INLINE_TAG_OPEN   T_INLINE_TAG_NAME   T_INLINE_TAG_CLOSE ",
//t    "internaltag :  T_INTERNAL   paragraphs   T_ENDINTERNAL ",
//t    "internaltag_with_p :  T_INTERNAL   paragraphs_with_p   T_ENDINTERNAL ",
//t  );
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
