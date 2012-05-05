<?php	
	// Force the script to run in Command Line only
	if (php_sapi_name() != 'cli')
		die('This script must be run in the command line');

	// Use CURL
	include_once('curl.php');
	$myCurl = new cURL;

	include_once('simple_html_dom.php');
	
	// Setup the defaults
	$endpoint = 'http://whois.educause.net/index.asp';

	// Testing only
	function Pre($data){
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}

	// The alphas
	$alpha = array('','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

	// Reset the edu-list.txt file
	$fp = fopen(realpath(__DIR__) . '../edu-list.txt', 'w');

	// Let's build some combos
	foreach ($alpha as $first){
		$edu_list = array();
		$edu_string = '';
	
		if ($first != ''){
			foreach ($alpha as $second){
				//Pre($first . $second);
				
				// Define the POST vars
				$params = array('domain' => $first . $second . '%.edu', 'searchtype' => 'domain');
				
				// Grab the returned results
				$return = $myCurl->post($endpoint, http_build_query($params), $endpoint);
				
				// Parse the HTML for the <pre> block with the domain list
				$html = str_get_html($return);
				$ret = $html->find('pre', 0);
				
				//Pre($ret);
				
				// Get all the URL's that end in .edu
				preg_match_all('/ (\w+)\.edu/', strtolower($ret), $matches);
				
				//Pre($matches[0]);
				
				// Add the matched domains to the list
				$edu_list = array_merge($edu_list, $matches[0]);
			}
			
			// Remove the duplicates
			$edu_list = array_unique($edu_list);
			
			// Create a string of all the domains
			foreach ($edu_list as $domain){
				// Write the list to the file
				fwrite($fp, $domain . "\n");
			}
			
			// Display the count per letter
			echo 'Count ' . strtoupper($first) . ': ' . count($edu_list) . "\n";
			
			// Unset the data to start all over at the next letter
			unset($edu_list);
			unset($html);
			unset($ret);

			// Let's be nice to the server
			sleep(10);
		}
	}
	
	// Close up the file
	fclose($fp);
?>