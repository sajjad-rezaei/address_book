## Simple symfony Address Book

This is a sample address book using symfony 3.4.49 and Sqlite

## Technologies:
 -  symfony 3.4.49
 -  Sqlite
 -  php7.4
  - Bootstrap 4
  - JQuery
  - Data table

## How to use:

  - download the git repository
  - open your terminal in project directory
  - run `composer install` command
     
    - if your php is lower than 7.4 run `composer install --ignore-platform-reqs` (Tested on php7.2)
    
  - run `php bin/console doctrine:schema:update --force` to create database
  - run `php bin/console server:run`
  - application is now running `http://127.0.0.1:8000` address

Live demo can be found [here](https://address.devbase.ir)

