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

					// line 1 "C:/devel/PHP_Parser/Parser/DocBlock/Extendable.jay"

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
define('PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE_ERROR_PARSE', 1);

/**
 * Default phpDocumentor DocBlock Parser
 * @package PHP_Parser
 */
class PHP_Parser_DocBlock_DefaultExtendable {

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
    var $yyGlobalName = '_PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE';

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
        return PHP_Parser_Stack::staticPush('PHP_Parser_Docblock_DefaultExtendable',
            PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE_ERROR_PARSE,
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
                        || is_a($item, 'PhpDocumentor_DocBlock_List')) {
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
     * Remove the /**, * and {@*} from the doc comment
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
					// line 489 "-"

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


					// line 787 "C:/devel/PHP_Parser/Parser/DocBlock/Extendable.jay"

    /**#@-*/
}
					// line 760 "-"

  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE']['yyLhs']  = array(              -1,
    0,    0,    0,    0,    0,    1,    2,    4,    5,    3,
    3,    7,    7,    7,    6,    6,    6,    6,    6,    6,
    6,    6,    6,    6,    6,    6,    6,    6,    6,    6,
    6,    6,    6,   10,   10,   10,   10,   10,   10,   10,
   14,   15,   16,   17,   18,   19,   20,   20,   21,   11,
   11,   22,   22,   22,   22,   25,   25,   25,   24,   24,
   24,   23,   23,   23,   23,   23,   23,   23,   23,   23,
   23,   23,   23,   26,   12,   12,   13,    9,    9,    8,
    8,    8,   27,   27,   27,   27,   27,   27,   27,   27,
   27,   27,   27,   27,   28,   28,   28,   28,   28,   28,
   28,   31,   32,   33,   34,   35,   36,   37,   37,   38,
   29,   29,   40,   40,   40,   39,   39,   39,   39,   39,
   39,   39,   39,   39,   39,   39,   39,   39,   39,   41,
   30,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE']['yyLen'] = array(           2,
    2,    3,    3,    1,    1,    1,    2,    1,    1,    1,
    3,    0,    1,    3,    1,    1,    1,    1,    1,    1,
    1,    1,    1,    2,    2,    2,    2,    2,    2,    2,
    2,    2,    2,    1,    1,    1,    1,    1,    1,    1,
    3,    3,    3,    3,    3,    3,    1,    2,    3,    3,
    4,    1,    1,    1,    2,    2,    2,    2,    1,    1,
    1,    1,    1,    1,    1,    1,    1,    2,    2,    2,
    2,    2,    2,    3,    4,    3,    3,    1,    2,    3,
    4,    2,    1,    1,    1,    1,    1,    1,    2,    2,
    2,    2,    2,    2,    1,    1,    1,    1,    1,    1,
    1,    3,    3,    3,    3,    3,    3,    1,    2,    3,
    3,    4,    1,    1,    1,    1,    1,    1,    1,    1,
    1,    1,    2,    2,    2,    2,    2,    2,    2,    3,
    3,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE']['yyDefRed'] = array(            0,
   52,   53,   54,    0,    0,    0,    0,    0,    0,    0,
    0,   21,   34,   20,   15,   23,   22,    0,    0,    0,
    0,    0,    5,    0,    0,    8,   16,    0,   18,   19,
   35,   36,   37,   38,   39,   40,    0,   55,    0,    0,
    0,    0,    0,    0,   95,   88,   83,    0,   86,    0,
    0,   84,    0,   87,   96,   97,   98,   99,  100,  101,
    0,    0,   47,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,   78,    0,   29,   30,   28,
   24,   32,   31,   25,    0,   27,   33,    0,   62,    0,
   63,   65,   66,   64,    0,    0,   67,    0,    0,  108,
    0,    0,    0,    0,    0,    0,  116,  117,  119,  120,
  118,    0,  121,    0,  122,    0,   94,   89,   92,   90,
    0,   93,    0,    0,   46,   48,   42,    0,   41,   44,
   45,   43,   77,    0,   76,    0,    0,    2,    3,   79,
    0,   56,   57,   58,   68,   59,   60,   69,   71,   61,
   72,   70,   50,   73,    0,    0,  107,  109,  103,  102,
  105,  106,  104,  131,    0,  123,  113,  114,  124,  126,
  127,  115,  125,  128,  111,  129,   81,    0,   49,    0,
   75,   51,   74,  110,  130,  112,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE']['yyDgoto']  = array(            21,
   22,   74,   23,   24,   75,   64,   65,   76,   77,   27,
   28,   29,   30,   31,   32,   33,   34,   35,   36,   62,
   63,   37,   95,  153,   96,   97,   51,   52,   53,   54,
   55,   56,   57,   58,   59,   60,   99,  100,  114,  175,
  115,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE']['yySindex'] = array(          320,
    0,    0,    0,  210,  628,   17,  392,  392,  392,  392,
  392,    0,    0,    0,    0,    0,    0,  392,   42,   -9,
    0,   41,    0,  123,  358,    0,    0,  210,    0,    0,
    0,    0,    0,    0,    0,    0,  700,    0,   90,  628,
  628,  628,  628,  628,    0,    0,    0,  123,    0,  673,
  426,    0,  210,    0,    0,    0,    0,    0,    0,    0,
  392,  114,    0,  358,   49,   48,   76,  162,  156,  179,
  392,   55,  392,   93,   93,    0,  123,    0,    0,    0,
    0,    0,    0,    0,  210,    0,    0,  700,    0,  218,
    0,    0,    0,    0,   31,  700,    0,  628,  171,    0,
  451,  476,  501,  535,  569,   18,    0,    0,    0,    0,
    0,  673,    0,   -4,    0,  129,    0,    0,    0,    0,
  210,    0,  673,   -6,    0,    0,    0,  392,    0,    0,
    0,    0,    0,  125,    0,  149,  125,    0,    0,    0,
   31,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,   31,  603,    0,    0,    0,    0,
    0,    0,    0,    0,   -4,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,   -4,    0,  358,
    0,    0,    0,    0,    0,    0,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE']['yyRindex'] = array(            0,
    0,    0,    0,    0,    0,    0,  150,  121,  143,  163,
  172,    0,    0,    0,    0,    0,    0,  187,  168,    0,
    0,  194,    0,    0,   62,    0,    0,  243,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
  117,    0,  725,    0,    0,    0,    0,    0,    0,    0,
    2,    0,    0,  209,    0,    0,    0,    0,    0,    0,
   92,    0,   78,  201,    0,    0,  188,    0,    0,    0,
    0,    0,    0,    0,  282,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,  146,    0,    0,    0,    0,
  755,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,  224,    0,    0,   63,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,    0,  643,
    0,    0,    0,    0,    0,    0,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE']['yyGindex'] = array(            0,
    0,    0,  165,    0,    0,    9,  155,   16,  184,  -20,
  -22,   15,  -18,    0,    0,    0,    0,    0,    0,    0,
  180,   46,  122,  -46,  -32,  -74,   99,   73,    3,  102,
    0,    0,    0,    0,    0,    0,    0,  128,  -90, -154,
  -95,
  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE']['yyTable'] = array(           166,
  167,  168,   85,   90,   84,   39,   87,   40,   25,   41,
  185,   42,   43,   44,  179,   26,   93,  112,  176,   49,
  154,  165,   12,  186,   45,  169,    5,   61,  170,  128,
   72,  171,  178,   20,  145,  146,  147,   12,   90,   86,
    6,   85,    7,   84,    8,   87,    9,   10,   11,   38,
   50,   94,  164,  121,   49,   49,   49,   49,   49,   13,
  148,    6,    7,  149,  111,  119,  154,   93,   20,  176,
  127,  129,   71,   88,  151,   93,   73,   12,   86,  112,
  154,  112,  176,  128,  128,   50,   50,   50,   50,   50,
  112,   12,  140,  135,  182,  136,   50,    6,  123,    7,
   98,  130,   94,  121,  121,  121,  121,  121,  183,  152,
   94,  128,   49,   12,   12,  119,  119,  119,  119,  119,
  151,  140,  113,  120,   61,   82,  111,   12,  173,   19,
   88,    5,  112,  125,  151,  177,  180,  111,  101,  102,
  103,  104,  105,   50,   12,  112,   50,   50,   50,   50,
   50,   82,  122,   82,   80,  152,   12,   85,  121,   84,
  128,   87,   66,   67,   68,   69,  123,   10,   12,  152,
  119,   12,   70,  120,  120,  120,  120,  120,   12,  173,
   80,   98,   80,  132,  113,   12,  174,  181,  131,   12,
  157,  128,  173,    4,   86,  113,  156,  128,   12,   12,
    1,   50,  122,  122,  122,  122,  122,   12,   13,  141,
    1,    2,    3,  133,  128,  124,    4,  155,  142,  143,
  144,   12,   12,   11,    9,  134,  158,  137,  120,   13,
   13,  106,   13,    0,   13,   13,   13,  174,  138,  139,
    0,  126,   17,   13,   13,   13,    0,    0,    0,    0,
  174,   17,   17,  172,   17,    0,   17,  122,   17,   17,
   17,   17,    0,   17,   17,    0,   17,    0,   17,   17,
   17,   17,   17,   17,   17,   17,   17,   17,   17,   17,
   17,   26,    0,    0,    0,    0,    0,    0,  150,    0,
   26,   26,    0,   26,    0,   26,    0,   26,   26,   26,
   26,    0,   26,   26,    0,   26,    0,   26,   26,   26,
   26,   26,   26,   26,   26,   26,   26,   26,   26,   26,
    1,    2,    3,    0,    0,    0,    4,    0,    5,    6,
    0,    7,    0,    8,    0,    9,   10,   11,   12,    0,
    0,    0,    0,    0,    0,    0,    0,    0,   13,   14,
   15,   16,   17,   18,    0,    0,   19,   20,    1,    2,
    3,    0,    0,    0,    4,    0,   78,    6,    0,    7,
    0,    8,    0,    9,   10,   11,   79,    0,    0,    0,
    0,    0,    0,    0,    0,    0,   13,   80,   81,   82,
   83,   18,    1,    2,    3,   20,    0,    0,    4,    0,
    0,    6,    0,    7,    0,    8,    0,    9,   10,   11,
   12,    0,    0,    0,    0,    0,    0,    0,    0,    0,
   13,   14,   15,   16,   17,   18,    1,    2,    3,   20,
    0,    0,    4,    0,    0,   39,    0,   40,    0,   41,
    0,   42,   43,   44,  116,    0,    0,    0,    0,    0,
    0,    1,    2,    3,   45,  117,  118,    4,    0,   48,
   39,    0,   40,   20,   41,    0,   42,   43,   44,    0,
    0,    0,  159,    0,    0,    0,    1,    2,    3,   45,
  117,  118,    4,    0,   48,   39,    0,   40,   20,   41,
    0,   42,   43,   44,    0,    0,    0,    0,    0,  160,
    0,    1,    2,    3,   45,  117,  118,    4,    0,   48,
   39,    0,   40,   20,   41,    0,   42,   43,   44,    0,
    0,    0,    0,    0,    0,    0,  161,    0,    0,   45,
  117,  118,    0,    0,   48,    1,    2,    3,   20,    0,
    0,    4,    0,    0,   39,    0,   40,    0,   41,    0,
   42,   43,   44,    0,    0,    0,    0,    0,    0,    0,
    0,  162,    0,   45,  117,  118,    0,    0,   48,    1,
    2,    3,   20,    0,    0,    4,    0,    0,   39,    0,
   40,    0,   41,    0,   42,   43,   44,    0,    0,    0,
    0,    0,    0,    0,    0,    0,  163,   45,  117,  118,
    0,    0,   48,    1,    2,    3,   20,    0,    0,    4,
    0,    0,   39,    0,   40,    0,   41,    0,   42,   43,
   44,    0,    0,  184,    0,    0,    0,    0,    1,    2,
    3,   45,  117,  118,    4,    0,   48,   39,    0,   40,
   20,   41,   14,   42,   43,   44,    0,    0,    0,    0,
    0,    0,    0,    0,    0,    0,   45,   46,   47,    0,
    0,   48,    0,   14,   14,   20,   14,    0,   14,   14,
   14,    0,    0,    0,    0,    0,  107,   14,   14,   14,
   90,    0,   39,    0,   40,    0,   41,    0,   42,   43,
   44,    0,    0,    0,    0,    0,    0,    0,    0,    0,
    0,   45,  108,   89,    0,  109,    0,   90,  110,    6,
   20,    7,    0,    8,    0,    9,   10,   11,    0,    0,
    0,    0,    0,    0,    0,    0,    0,    0,   13,   91,
    0,    0,   92,   85,   85,    0,   85,   20,   85,    0,
   85,   85,   85,   85,    0,   85,   85,    0,   85,    0,
   85,   85,   85,   85,   85,   85,    0,    0,   85,   85,
    0,   85,   85,   91,   91,    0,   91,    0,   91,    0,
   91,   91,   91,   91,    0,   91,   91,    0,   91,    0,
   91,   91,   91,   91,   91,   91,    0,    0,   91,   91,
    0,   91,   91,
  );
 $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE']['yyCheck'] = array(             4,
    5,    6,   25,    8,   25,   10,   25,   12,    0,   14,
  165,   16,   17,   18,   21,    0,   37,   50,  114,    5,
   95,  112,   21,  178,   29,   30,    9,   11,   33,   36,
   40,   36,  123,   38,    4,    5,    6,   36,    8,   25,
   10,   64,   12,   64,   14,   64,   16,   17,   18,    4,
    5,   37,   35,   51,   40,   41,   42,   43,   44,   29,
   30,    0,    0,   33,   50,   51,  141,   88,   38,  165,
   22,   24,   31,   28,   95,   96,   36,    0,   64,  112,
  155,  114,  178,   36,   36,   40,   41,   42,   43,   44,
  123,    0,   77,   39,  141,   41,   51,   36,   53,   37,
   11,   26,   88,  101,  102,  103,  104,  105,  155,   95,
   96,   36,   98,   36,   37,  101,  102,  103,  104,  105,
  141,  106,   50,   51,   11,    9,  112,   36,  114,   37,
   85,    9,  165,   20,  155,    7,  128,  123,   40,   41,
   42,   43,   44,   98,   24,  178,  101,  102,  103,  104,
  105,   35,   51,   37,    9,  141,   36,  180,  156,  180,
   36,  180,    8,    9,   10,   11,  121,    0,   26,  155,
  156,   22,   18,  101,  102,  103,  104,  105,   36,  165,
   35,   11,   37,   28,  112,   36,  114,   39,   27,   27,
   20,   36,  178,    0,  180,  123,   98,   36,   36,   28,
    0,  156,  101,  102,  103,  104,  105,   36,    0,   88,
    1,    2,    3,   35,   36,   61,    7,   96,    1,    2,
    3,   35,   36,    0,   37,   71,   99,   73,  156,   21,
   22,   48,   24,   -1,   26,   27,   28,  165,   74,   75,
   -1,   62,    0,   35,   36,   37,   -1,   -1,   -1,   -1,
  178,    9,   10,  258,   12,   -1,   14,  156,   16,   17,
   18,   19,   -1,   21,   22,   -1,   24,   -1,   26,   27,
   28,   29,   30,   31,   32,   33,   34,   35,   36,   37,
   38,    0,   -1,   -1,   -1,   -1,   -1,   -1,  258,   -1,
    9,   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,
   19,   -1,   21,   22,   -1,   24,   -1,   26,   27,   28,
   29,   30,   31,   32,   33,   34,   35,   36,   37,   38,
    1,    2,    3,   -1,   -1,   -1,    7,   -1,    9,   10,
   -1,   12,   -1,   14,   -1,   16,   17,   18,   19,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,
   31,   32,   33,   34,   -1,   -1,   37,   38,    1,    2,
    3,   -1,   -1,   -1,    7,   -1,    9,   10,   -1,   12,
   -1,   14,   -1,   16,   17,   18,   19,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,   31,   32,
   33,   34,    1,    2,    3,   38,   -1,   -1,    7,   -1,
   -1,   10,   -1,   12,   -1,   14,   -1,   16,   17,   18,
   19,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   29,   30,   31,   32,   33,   34,    1,    2,    3,   38,
   -1,   -1,    7,   -1,   -1,   10,   -1,   12,   -1,   14,
   -1,   16,   17,   18,   19,   -1,   -1,   -1,   -1,   -1,
   -1,    1,    2,    3,   29,   30,   31,    7,   -1,   34,
   10,   -1,   12,   38,   14,   -1,   16,   17,   18,   -1,
   -1,   -1,   22,   -1,   -1,   -1,    1,    2,    3,   29,
   30,   31,    7,   -1,   34,   10,   -1,   12,   38,   14,
   -1,   16,   17,   18,   -1,   -1,   -1,   -1,   -1,   24,
   -1,    1,    2,    3,   29,   30,   31,    7,   -1,   34,
   10,   -1,   12,   38,   14,   -1,   16,   17,   18,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   26,   -1,   -1,   29,
   30,   31,   -1,   -1,   34,    1,    2,    3,   38,   -1,
   -1,    7,   -1,   -1,   10,   -1,   12,   -1,   14,   -1,
   16,   17,   18,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   27,   -1,   29,   30,   31,   -1,   -1,   34,    1,
    2,    3,   38,   -1,   -1,    7,   -1,   -1,   10,   -1,
   12,   -1,   14,   -1,   16,   17,   18,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   28,   29,   30,   31,
   -1,   -1,   34,    1,    2,    3,   38,   -1,   -1,    7,
   -1,   -1,   10,   -1,   12,   -1,   14,   -1,   16,   17,
   18,   -1,   -1,   21,   -1,   -1,   -1,   -1,    1,    2,
    3,   29,   30,   31,    7,   -1,   34,   10,   -1,   12,
   38,   14,    0,   16,   17,   18,   -1,   -1,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,   31,   -1,
   -1,   34,   -1,   21,   22,   38,   24,   -1,   26,   27,
   28,   -1,   -1,   -1,   -1,   -1,    4,   35,   36,   37,
    8,   -1,   10,   -1,   12,   -1,   14,   -1,   16,   17,
   18,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,
   -1,   29,   30,    4,   -1,   33,   -1,    8,   36,   10,
   38,   12,   -1,   14,   -1,   16,   17,   18,   -1,   -1,
   -1,   -1,   -1,   -1,   -1,   -1,   -1,   -1,   29,   30,
   -1,   -1,   33,    9,   10,   -1,   12,   38,   14,   -1,
   16,   17,   18,   19,   -1,   21,   22,   -1,   24,   -1,
   26,   27,   28,   29,   30,   31,   -1,   -1,   34,   35,
   -1,   37,   38,    9,   10,   -1,   12,   -1,   14,   -1,
   16,   17,   18,   19,   -1,   21,   22,   -1,   24,   -1,
   26,   27,   28,   29,   30,   31,   -1,   -1,   34,   35,
   -1,   37,   38,
  );

  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE']['yyFinal'] = 21;
//t$GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE']['yyRule'] = array(
//t   "\$accept :  docblock ",
//t    "docblock :  shortdesc   longdesc ",
//t    "docblock :  shortdesc   longdesc   tags ",
//t    "docblock :  shortdesc_with_p   longdesc_with_p   tags ",
//t    "docblock :  shortdesc ",
//t    "docblock :  tags ",
//t    "shortdesc :  paragraph ",
//t    "longdesc :  T_DOUBLE_NL   paragraphs ",
//t    "shortdesc_with_p :  paragraph_with_p ",
//t    "longdesc_with_p :  paragraphs_with_p ",
//t    "tags :  T_TAG ",
//t    "tags :  T_TAG   T_TEXT   paragraphs ",
//t    "paragraphs :",
//t    "paragraphs :  paragraph ",
//t    "paragraphs :  paragraphs   T_DOUBLE_NL   paragraph ",
//t    "paragraph :  T_TEXT ",
//t    "paragraph :  htmltag ",
//t    "paragraph :  simplelist ",
//t    "paragraph :  inlinetag ",
//t    "paragraph :  internaltag ",
//t    "paragraph :  T_ESCAPED_TAG ",
//t    "paragraph :  T_CLOSE_P ",
//t    "paragraph :  T_INLINE_ESC ",
//t    "paragraph :  T_NL ",
//t    "paragraph :  paragraph   T_TEXT ",
//t    "paragraph :  paragraph   htmltag ",
//t    "paragraph :  paragraph   simplelist ",
//t    "paragraph :  paragraph   inlinetag ",
//t    "paragraph :  paragraph   T_ESCAPED_TAG ",
//t    "paragraph :  paragraph   T_OPEN_P ",
//t    "paragraph :  paragraph   T_CLOSE_P ",
//t    "paragraph :  paragraph   T_INLINE_ESC ",
//t    "paragraph :  paragraph   T_NL ",
//t    "paragraph :  paragraph   internaltag ",
//t    "htmltag :  T_XML_TAG ",
//t    "htmltag :  btag ",
//t    "htmltag :  codetag ",
//t    "htmltag :  samptag ",
//t    "htmltag :  kbdtag ",
//t    "htmltag :  vartag ",
//t    "htmltag :  htmllist ",
//t    "btag :  T_OPEN_B   paragraphs   T_CLOSE_B ",
//t    "codetag :  T_OPEN_CODE   paragraphs   T_CLOSE_CODE ",
//t    "samptag :  T_OPEN_SAMP   paragraphs   T_CLOSE_SAMP ",
//t    "kbdtag :  T_OPEN_KBD   paragraphs   T_CLOSE_KBD ",
//t    "vartag :  T_OPEN_VAR   paragraphs   T_CLOSE_VAR ",
//t    "htmllist :  T_OPEN_LIST   listitems   T_CLOSE_LIST ",
//t    "listitems :  listitem ",
//t    "listitems :  listitems   listitem ",
//t    "listitem :  T_OPEN_LI   paragraphs   T_CLOSE_LI ",
//t    "simplelist :  bullet   simplelist_contents   simplelistend ",
//t    "simplelist :  simplelist   bullet   simplelist_contents   simplelistend ",
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
//t    "nested_simplelist :  nested_bullet   simplelist_contents   simplelistend ",
//t    "inlinetag :  T_INLINE_TAG_OPEN   T_INLINE_TAG_NAME   T_INLINE_TAG_CONTENTS   T_INLINE_TAG_CLOSE ",
//t    "inlinetag :  T_INLINE_TAG_OPEN   T_INLINE_TAG_NAME   T_INLINE_TAG_CLOSE ",
//t    "internaltag :  T_INTERNAL   paragraphs   T_ENDINTERNAL ",
//t    "paragraphs_with_p :  paragraph_with_p ",
//t    "paragraphs_with_p :  paragraphs_with_p   paragraph_with_p ",
//t    "paragraph_with_p :  T_OPEN_P   text_expr_with_p   T_CLOSE_P ",
//t    "paragraph_with_p :  T_OPEN_P   text_expr_with_p   T_CLOSE_P   T_WHITESPACE ",
//t    "paragraph_with_p :  T_OPEN_P   text_expr_with_p ",
//t    "text_expr_with_p :  T_TEXT ",
//t    "text_expr_with_p :  htmltag_with_p ",
//t    "text_expr_with_p :  simplelist_with_p ",
//t    "text_expr_with_p :  inlinetag ",
//t    "text_expr_with_p :  internaltag_with_p ",
//t    "text_expr_with_p :  T_ESCAPED_TAG ",
//t    "text_expr_with_p :  text_expr_with_p   T_TEXT ",
//t    "text_expr_with_p :  text_expr_with_p   htmltag_with_p ",
//t    "text_expr_with_p :  text_expr_with_p   simplelist_with_p ",
//t    "text_expr_with_p :  text_expr_with_p   inlinetag ",
//t    "text_expr_with_p :  text_expr_with_p   internaltag_with_p ",
//t    "text_expr_with_p :  text_expr_with_p   T_ESCAPED_TAG ",
//t    "htmltag_with_p :  T_XML_TAG ",
//t    "htmltag_with_p :  btag_with_p ",
//t    "htmltag_with_p :  codetag_with_p ",
//t    "htmltag_with_p :  samptag_with_p ",
//t    "htmltag_with_p :  kbdtag_with_p ",
//t    "htmltag_with_p :  vartag_with_p ",
//t    "htmltag_with_p :  htmllist_with_p ",
//t    "btag_with_p :  T_OPEN_B   text_expr_with_p   T_CLOSE_B ",
//t    "codetag_with_p :  T_OPEN_CODE   text_expr_with_p   T_CLOSE_CODE ",
//t    "samptag_with_p :  T_OPEN_SAMP   text_expr_with_p   T_CLOSE_SAMP ",
//t    "kbdtag_with_p :  T_OPEN_KBD   text_expr_with_p   T_CLOSE_KBD ",
//t    "vartag_with_p :  T_OPEN_VAR   text_expr_with_p   T_CLOSE_VAR ",
//t    "htmllist_with_p :  T_OPEN_LIST   listitems_with_p   T_CLOSE_LIST ",
//t    "listitems_with_p :  listitem_with_p ",
//t    "listitems_with_p :  listitems_with_p   listitem_with_p ",
//t    "listitem_with_p :  T_OPEN_LI   text_expr_with_p   T_CLOSE_LI ",
//t    "simplelist_with_p :  bullet   simplelist_contents_with_p   simplelistend_with_p ",
//t    "simplelist_with_p :  simplelist_with_p   bullet   simplelist_contents_with_p   simplelistend_with_p ",
//t    "simplelistend_with_p :  T_SIMPLELIST_NL ",
//t    "simplelistend_with_p :  T_SIMPLELIST_END ",
//t    "simplelistend_with_p :  EOF ",
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
//t    "nested_simplelist_with_p :  nested_bullet   simplelist_contents_with_p   simplelistend_with_p ",
//t    "internaltag_with_p :  T_INTERNAL   paragraphs_with_p   T_ENDINTERNAL ",
//t  );
  $GLOBALS['_PHP_PARSER_DOCBLOCK_DEFAULTEXTENDABLE']['yyName'] =array(    
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
