<? 
/**
 * test
 */
class testClass {
   var $_type;
   var $_vars;
   var $_methods;
   var $_implements;
   var $_extends;
   var $_referencedVars;
   
   function setType($type = null)
   {
       $this->_type = $type;
   }
   
   function setVars($vars)
   {
       $this->_vars = $vars;
   }
   
   function setMethods($vars)
   {
       $this->_methods = $vars;
   }
   
   function setImplements($vars)
   {
       $this->_implements = $vars;
   }
      
   function setExtends($name)
   {
       $this->_extends = $name;
   }
   
   function setReferencedVars($vars)
   {
        $this->_referencedVars = $vars;
   }
}


require_once 'PHP/Parser.php';
$a = new    PHP_Parser_Core;
$start = explode(' ',microtime());
echo "\nloaded ".
$r = PHP_Parser::parseFile($_SERVER['argv'][1]);
if (PEAR::isError($r)) {
    echo $r->getMessage(). "\n";
    exit;
}
 print_r($r);
$end =  explode(' ',microtime() );


 
echo "\nparsed in " . ($end[0]+$end[1]-($start[0]+$start[1])). "\n";
//xdebug_dump_function_profile(8);
?>
