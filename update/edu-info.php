<?php
	// Force the script to run in Command Line only
	if (php_sapi_name() != 'cli')
		die('This script must be run in the command line');

	// Use CURL
	include_once('curl.php');
	$myCurl = new cURL;

	// Include the DOM functions
	include_once('simple_html_dom.php');
	
	// Reset the edu-info.csv file
	$fp = fopen(realpath(__DIR__) . '/../edu-info.csv', 'w');
	
	// Write the column headers
	fwrite($fp, 'URL,Final URL,Title,HTTP Code,File Size,Speed' . "\n");
	
	// Open up the edu list
	$handle = fopen(realpath(__DIR__) . '/../edu-list.txt', 'r');
	if ($handle) {
	    while (($url = fgets($handle, 4096)) !== false) {
	        // Grab the homepage to get all the info about it
	        $page = $myCurl->get('http://' . trim($url) . '/', NULL, true);
	        
	        //print_r($page['response']);
	        
	        // If the page is returned successfully
	        if ($page['info']['http_code'] == '200'){
				// Grab the page title
				$html = str_get_html($page['response']);
				$title = trim($html->find('title', 0)->plaintext);
			}

			// Compile the info for each line item
	        $info = array('url' => 'http://' . trim($url) . '/',
	        			'url_final' => $page['info']['url'],
	        			'title' => $title,
	        			'http_code' => $page['info']['http_code'],
	        			'file_size' => $page['info']['download_content_length'],
	        			'response_time' => $page['info']['total_time']);
	        
	        // Write the CSV fields	
			fputcsv($fp, $info);

	        //print_r($info);
	    }
	    if (!feof($handle)) {
	        echo "Error: unexpected fgets() fail\n";
	    }
	    fclose($handle);
	}
	
	fclose($fp);
?>