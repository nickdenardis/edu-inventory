<?php
	// Force the script to run in Command Line only
	if (php_sapi_name() != 'cli')
		die('This script must be run in the command line');
	
	// Use CURL
	include_once('curl.php');
	$myCurl = new cURL;
	
	// Open the CSV with domain information
	$row = 1;
	if (($handle = fopen(realpath(__DIR__) . '/../edu-info.csv', 'r')) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			
			// Only get screenshots from domains that were successful
			if ($data[3] == '200'){
				// Make sure the snapshots directory exists
				if (!is_dir(realpath(__DIR__) . '/../snapshots/html/')){
					// Need to do some more work to ensure it is writable
					mkdir(realpath(__DIR__) . '/../snapshots/html/');
				}
				
				// Get the HTML of the homepage
				if (!$myCurl->save($data[1], realpath(__DIR__) . '/../snapshots/html/' . $data[0] . '.html'))
					print_r('Error creating file: ' . realpath(__DIR__) . '/../snapshots/html/' . $data[0] . '.html' . "\n");
				
				// Report Success
				print_r('Saved HTML for: ' . $data[0] . "\n");
			}
		}
		// Close the CSV
		fclose($handle);
	}
?>