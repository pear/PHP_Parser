<?php
/**
 * HTML output for PHPUnit suite tests.
 *
 * Copied for PEAR_PackageFileManager from HTML_CSS
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_CSS
 */
require_once 'TestUnit.php';
require_once 'HTML_TestListener.php';
require_once 'PHP/Parser.php';
require_once 'PHP/Parser/DocBlock/DefaultInlineTagLexer.php';
require_once 'PHP/Parser/DocBlock/DefaultTagLexer.php';
require_once 'PHP/Parser/DocBlock/DefaultLexer.php';
require_once 'PHP/Parser/DocBlock/Default.php';

$title = 'PhpUnit test run, PHP_Parser package';
?>
<html>
<head>
<title><?php echo $title; ?></title>
<link rel="stylesheet" href="stylesheet.css" type="text/css" />
</head>
<body>
<h1><?php echo $title; ?></h1>
      <p>
	This page runs all the phpUnit self-tests, and produces nice HTML output.
      </p>
      <p>
	Unlike typical test run, <strong>expect many test cases to
	  fail</strong>.  Exactly those with <code>pass</code> in their name
	should succeed.
      </p>
      <p>
      For each test we display both the test result -- <span
      class="Pass">ok</span>, <span class="Failure">FAIL</span>, or
      <span class="Error">ERROR</span> -- and also a meta-result --
      <span class="Expected">as expected</span>, <span
      class="Unexpected">UNEXPECTED</span>, or <span
      class="Unknown">unknown</span> -- that indicates whether the
      expected test result occurred.  Although many test results will
      be 'FAIL' here, all meta-results should be 'as expected', except
      for a few 'unknown' meta-results (because of errors) when running
      in PHP3.
      </p>
      
<h2>Tests</h2>
	<?php
	$testcases = array(
    	    'PHP_Parser_test_class',
    	    'PHP_Parser_test_vars',
    	    'PHP_Parser_test_methods',
    	    'PHP_Parser_test_functions',
    	    'PHP_Parser_test_define',
	);
    
    if (version_compare(phpversion(), '4.3.5', '>')) {
        $cases = $testcases;
        foreach($cases as $case) {
            $testcases[] = $case . '_php5';
        }
    }
    
    $testcases[] = 'PHP_Parser_MsgServer_test';
    $testcases[] = 'PHP_Parser_DocBlock_DefaultInlineTagLexer_test';
    $testcases[] = 'PHP_Parser_DocBlock_DefaultTagLexer_test';
    $testcases[] = 'PHP_Parser_DocBlock_DefaultLexer_test';
    $testcases[] = 'PHP_Parser_DocBlock_DefaultLexer_tag_test';
    $testcases[] = 'PHP_Parser_DocBlock_Default_test';
    $testcases[] = 'PHP_Parser_DocBlock_Default_basic_test';

	$suite = new PHPUnit_TestSuite();

	foreach ($testcases as $testcase) {
    	    include_once $testcase . '.php';
            $suite->addTestSuite($testcase);
	}

	$listener = new HTML_TestListener();
        $result = TestUnit::run($suite, $listener);
	$result->removeListener($listener);
	$result->report();

	?>
</body>
</html>
