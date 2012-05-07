Higher Education Website Inventory
=============

A list of all .edu domains and information about them.


Files
-------------
* edu-list.txt - List of all .edu domains one per line.
* edu-info.csv - Information about each domain. URL, Title, Response, Size, Speed.
* snapshots/html/ - Collection of HTML homepages for each valid domain.
* snapshots/jpg/ - Collection of screenshots for each valid domain.



Command Line Tools
-------------
* php update/edu-info.php - Updates the csv with all meta information about each domain.
* php update/edu-snapshots.php - Takes a screenshot of each valid website from the CSV and saves it to snapshots/jpg/[site].jpg.
* php update/edu-html.php - Gets the most recent HTML code for the homepage and saves it to snapshots/html/[site].html