Higher Education Website Inventory
=============

A list of all .edu domains and information about them.


Files
-------------
* edu-list.txt - List of all .edu domains one per line.
* edu-info.csv - Information about each domain. URL, Title, Response, Size, Speed.
* snapshots/[domain] - Collection of screenshots for each valid domain. Filename is unix timestamp.



Command Line Tools
-------------
* php update/edu-list.php - Update the list from the most recent EDUCAUSE database.
* php update/edu-info.php - Updates the csv with all meta information about each domain.
* php update/edu-snapshots.php - Takes a screenshot of each valid website from the CSV and saves it to the snapshots/[domain]/timestamp.jpg directory.