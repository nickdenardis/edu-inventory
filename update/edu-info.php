<?php
	// Force the script to run in Command Line only
	if (php_sapi_name() != 'cli')
		die('This script must be run in the command line');

	// Use CURL
	include_once('curl.php');
	$myCurl = new cURL;

	// Include the DOM functions
	include_once('simple_html_dom.php');
	
	// Open up the edu list
	$handle = fopen(realpath(__DIR__) . '/../edu-list.txt', 'r');
	if ($handle) {
	    while (($buffer = fgets($handle, 4096)) !== false) {
	        echo $buffer;
	        die();
	    }
	    if (!feof($handle)) {
	        echo "Error: unexpected fgets() fail\n";
	    }
	    fclose($handle);
	}
?>