<?php
	// Force the script to run in Command Line only
	if (php_sapi_name() != 'cli')
		die('This script must be run in the command line');

	// Screenshot tool
	// http://immediatenet.com/t/fs?Size=1024x768&URL=http://aa.edu/
	
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
				if (!is_dir(realpath(__DIR__) . '/../snapshots/' . $data[0] . '/')){
					// Need to do some more work to ensure it is writable
					mkdir(realpath(__DIR__) . '/../snapshots/' . $data[0] . '/');
				}
				
				// Get the screenshot for the website
				if (!$myCurl->save('http://immediatenet.com/t/fs?Size=1024x768&URL=' . $data[1], realpath(__DIR__) . '/../snapshots/' . $data[0] . '/' . time() . '.jpg'))
					print_r('Error creating file: ' . realpath(__DIR__) . '/../snapshots/' . $data[0] . '/' . time() . '.jpg' . "\n");
				
				// Report Success
				print_r('Saved snapshot for: ' . $data[0] . "\n");
				//print_r($data);
			}
		}
		// Close the CSV
		fclose($handle);
	}
?>