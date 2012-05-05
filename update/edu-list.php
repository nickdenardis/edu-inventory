<?php
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

	// The basics
	$alpha = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	$alpha_b = array('','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	$limit = 6;
	$i = 0;
	$edu_list = array();
	
	// Let's build some combos
	foreach ($alpha as $first){
		foreach ($alpha_b as $second){
			if ($i < $limit){
				//Pre($first . $second);
			
				// Define the POST vars
				$params = array('domain' => $first . $second . '%.edu', 'searchtype' => 'domain');
				
				// Grab the returned results
				$return = $myCurl->post($endpoint, http_build_query($params), $endpoint);
				
				// Parse the HTML for the <pre> block with the domain list
				$html = str_get_html($return);
				$ret = $html->find('pre', 0);
				
				//echo $ret . '<br />';
				
				// Get all the URL's that end in .edu
				preg_match_all('/ (\w+)\.edu/', strtolower($ret), $matches);
				
				//Pre($matches[0]);
				
				$edu_list = array_merge($edu_list, $matches[0]);
				
				$i++;
			}
		}
	}
	
	// Remove the duplicates
	$edu_list = array_unique($edu_list);
	
	$edu_string = '';
	
	foreach ($edu_list as $domain){
		$edu_string .= $domain . "\n";
	}
	
	// Display the full list without dupes
	Pre($edu_string);
	
	Pre('Total: ' . count($edu_list));
	
	// Write the list to the file
	if(!file_put_contents('../edu-list.txt', $edu_string)){
		echo 'ERROR';
	}
?>