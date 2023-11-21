# Project Title

Real Estate System

## Description

This Real Estate Management System is specifically made for real estate agencies. Its user interface is simple and easy to use for both agency owners and clients. To maintain the website, owners can log in here using their email and password after registering with the system. The property that has to be sold by the agent might be listed in the real estate listings. Buyers have the ability to register and use the website to view the property details and contact the agent.

## Getting Started

### Dependencies

* Install XAMPP (Reference: https://www.ionos.ca/digitalguide/server/tools/xampp-tutorial-create-your-own-local-test-server/)
* Install MySQL Workbench or setup PhpMyAdmin to be used

### Setup Instructions

* Clone the repository to htdocs folder which is under xampp folder where you have installed xampp
* Switch to the dev branch
* Replace the database credentials in your init.php file
* Open MySQL Workbench or PhpMyAdmin and create a new database
* Execute the database scripts which resides inside database folder to your newly created database
* Replace the database name in init.php file
* Update the url which use to load the website as 'base_url' constant in init.php file
* Load the website 
* Register users of type Buyer and Agent
* Login to the system with the given email and password

