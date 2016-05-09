# Hacker News: Who Is Hiring?
Pulls jobs from the Hacker News API for "Who Is Hiring" threads and formats the data in a friendly and searchable way. Pulls in counts for programming languages, databases, frameworks and job types. Allows you to search the results. You can view a demo of the output from http://www.gosmartsolutions.com/hn/

## Requirements
Requires PHP 5.4+ and MySQL with PDO installed.

## Installation
Upload to your server or in a sub-directory on your site in the directory structure provided and change the application/Config.php file with your database settings.

Upload the sql/hn_jobs_tables.sql file into your MySQL database in order to import the tables needed

After your database & tables are created and your config file is changed, run the get_jobs.php?id=11611867 script which will pull in and format the data. Change the id=11611867 to the HN who is hiring thread you want to pull data from.

Now you should be able to navigate to the directory where you have it installed from your browser and view/search the data

## Notes
All programming languages, frameworks, databases and job types that are checked are stored in application/Config.php. The get_jobs.php scripts checks against this list upon import.

The charts are using D3.js. All js files for these are located in vendor/d3

## No Guarantees
This is a side project we put together for fun and out of curiosity. There may be bugs that we don't know about. If you find any, please let us know. Keep in mind however that we can't guarantee we will make custom changes or additions for free. The software is provided as is. Feel free to add your own contributions and open a pull request or read below if you want to hire us for customizations.

### Want to hire us?
Would you like help with a custom web or mobile app? Contact Us at http://www.gosmartsolutions.com/#contact and we'll provide you with a quote based on your requirements.



