<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors:  nobody <nobody@localhost>                                  |
// +----------------------------------------------------------------------+
//
// $Id$
//
//  PHP Parser
//
 
/*
* usage :
*   print_r(PHP_Parser:;parseFile($filename),null);      // no caching
*   print_r(PHP_Parser:;parseFile($filename),'');       // caches to filename + .wddx
*   print_r(PHP_Parser:;parseFile($filename),'/tmp/);   // caches to /tmp/filename + .wddx
*   print_r(PHP_Parser:;parse($string));                // parses a string.
*/
 
require_once 'System.php';
     

class PHP_Parser {
    var $_parser;
    var $_tokenizer;

    /**
     * Choose the parser and tokenizer
     * @static
     * @return PHP_Parser
     */
    function &factory($parser, $tokenizer)
    {
        $ret = new PHP_Parser;
        $a = $ret->setParser($parser);
        // trick: a PEAR_Error evaluates to true, so we use false as success
        if ($a) {
            return $a;
        }
        $a = $ret->setTokenizer($tokenizer);
        if ($a) {
            return $a;
        }
        return $ret;
    }
    
    /**
     * @param string|object
     * @return PEAR_Error|false
     */
    function setParser($parser)
    {
        if (is_object($parser)) {
            $this->_parser = $parser;
            return false;
        }
        if ($this->isIncludeable('PHP/Parser/' . $parser . '.php')) {
            include_once 'PHP/Parser/' . $parser . '.php';
        }
        if (!class_exists($parser)) {
            return $this->raiseError('no parser driver found');
        }
        $this->_parser = new $parser;
        return false;
    }
    
    /**
     * @param string|object
     * @return PEAR_Error|false
     */
    function setTokenizer($tokenizer)
    {
        if (is_object($tokenizer)) {
            $this->_tokenizer = $tokenizer;
            return false;
        }
        if ($this->isIncludeable('PHP/Parser/Tokenizer' . $tokenizer . '.php')) {
            include_once 'PHP/Parser/Tokenizer/' . $tokenizer . '.php';
        }
        if (!class_exists($tokenizer)) {
            return $this->raiseError('no tokenizer driver found');
        }
        $this->_tokenizer = new $tokenizer;
        return false;
    }
    
    function raiseError($msg, $code)
    {
        require_once 'PEAR.php';
        return PEAR::raiseError($msg, $code);
    }
    
    /**
     * @param string $path relative or absolute include path
     * @return boolean
     * @static
     */
    function isIncludeable($path)
    {
        if (file_exists($path) && is_readable($path)) {
            return true;
        }
        $ipath = explode(PATH_SEPARATOR, ini_get('include_path'));
        foreach ($ipath as $include) {
            $test = realpath($include . DIRECTORY_SEPARATOR . $path);
            if (file_exists($test) && is_readable($test)) {
                return true;
            }
        }
        return false;
    }

    /**
    * Parse a file with wddx caching options.
    *
    * parses a php file, 
    * 
    * 
    * @param    string  name of file to parse
    * @param    false|string  false = no caching, '' = write to same directory, '/some/dir/' - cache directory
    * 
    *
    * @return   array| object PEAR_Error   should return an array of includes and classes.. will grow...
    * @access   public
    */
  
   
    function parseFile($file,$cacheDir=false)
    {
        
        require_once 'PHP/Parser/Core.php';
        require_once 'PHP/Parser/Tokenizer.php';
    
        if ($cacheDir === false) {
            return PHP_Parser::parse(file_get_contents($file));
        }
        if (!strlen($cacheDir)) {
            $cacheFile = dirname($file).'/.PHP_Parser/' . basename($file) . '.wddx';
        } else {
            $cacheFile = $cacheDir . $file . '.wddx';
        }
        if (!file_exists(dirname($cacheFile))) {
            System::mkdir(dirname($cacheFile) ." -p");
        }
        
        //echo "Cache = $cacheFile\n";
        if (file_exists($cacheFile) && (filemtime($cacheFile) > filemtime($file))) {
            //echo "get cache";
            return wddx_deserialize(file_get_contents($cacheFile));
        }
        
        // this whole caching needs a much nicer logic to it..
        // but for the time being test the filename as md5 in /tmp/
        $tmpCacheFile = '/tmp/'.md5($file).'.wddx';
        if (file_exists($tmpCacheFile) && (filemtime($tmpCacheFile) > filemtime($file))) {
            //echo "get cache";
            return wddx_deserialize(file_get_contents($tmpCacheFile));
        }
        
        
         
        $result = PHP_Parser::parse(file_get_contents($file));
        if (function_exists('wddx_set_indent')) {
            wddx_set_indent(2);
        }
        //echo "Writing Cache = $cacheFile\n";
        $fh = @fopen ($cacheFile,'w');
        if (!$fh) {
            $fh = fopen ($tmpCacheFile,'w');
        }
        fwrite($fh,wddx_serialize_value($result));
        fclose($fh);
        return $result;
    }
       
    
    /**
    * Parse a string
    *
    * parses a php file, 
    * 
    * 
    * @param    string  name of file to parse
    * 
    *
    * @return   array| object PEAR_Error   should return an array of includes and classes.. will grow...
    * @access   public
    */
  
    
    function parse($string, $options = array(), $tokenizeroptions = array())
    {
        
        require_once 'PHP/Parser/Core.php';
        require_once 'PHP/Parser/Tokenizer.php';

        if (!trim($string)) {
            return PEAR::raiseError('No thing to parse');
        }
    
        
        $yyInput = new PHP_Parser_Tokenizer($string, $tokenizeroptions);
        //xdebug_start_profiling();
        $t = new PHP_Parser_Core($options);
        if (PEAR::isError($e = $t->yyparse($yyInput))) {
            return $e;
        }
        
        return array(
                'classes'  => $t->classes,
                'includes' => $t->includes,
                'functions' => $t->functions,
                'constants' => $t->constants,
                'globals' => $t->globals
            );
          
    }
}     
 
?>