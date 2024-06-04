## Cochrane Review Collection
Cochrane Review Collection

Overview
PHP command line application to gather and store associated metadata from Cochrane library review collection
Prerequisites

## Set Up the Environment
Required: PHP 7.2+
Required: PHP Http Guzzle Client 
Required: Composer

## Set Up the project
Set up an environment as per above mentioned prerequisites.


## Run the command below and you are all set to run your project using the command line.
**composer update**

## Run the project
Run the command: 
**php artisan collect:metadata** 
and you will be prompted to choose a topic.
 
Choose the topic for which you want to get the reviews and you will be able to see the first 100 reviews in the text file saved in the output directory of your project named as topicname.txt for eg. for topic name Allergy & intolerance => Allergy___intolerance.txt


## Steps
create the command to collect metadata


Step 1: Retrieve the HTML of Your Target Page

Step 2: Parse the html to get the required data(commented code gets all the pages and fetch the reviews for all the pagination urls)

Step 3: Export Your Data to a CSV File

_Note: Pagination functionality is implemented but commented in code. Uncommenting will download all the reviews in the text file._



