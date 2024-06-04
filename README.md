<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Cochrane Review Collection
Cochrane Review Collection

Overview
PHP command line application to gather and store associated metadata from Cochrane library review collection
Prerequisites

Set Up the Environment
Required: PHP 7.2+
Required: PHP Http Guzzle Client 
Required: Composer

Set Up a PHP Project
Set up an environment as per above mentioned prerequisites. Create a folder as cochrane_rupali and let the code reside inside this folder


Run the command below and you are all set to run your project using the command line.
composer update
Run the project:
Run the command: php review.php and you will be prompted to choose a topic.
 
Choose the topic for which you want to get the reviews and you will be able to see the first 100 reviews in the text file saved in the output directory of your project named as topicname.txt for eg. for topic name Allergy & intolerance => Allergy___intolerance.txt
Note: Pagination functionality is implemented but commented in code. Uncommenting will download all the reviews in the text file.
Technical Specification


Folder Structure



Following steps are required to achieve the above discussed functionality.
review.php is the startup file that needs to be executed from the command line.


Step 1: Retrieve the HTML of Your Target Page




Step 2: Parse the html to get the required data(commented code gets all the pages and fetch the reviews for all the pagination urls)



Step 3: Export Your Data to a CSV File





