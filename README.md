# EXPENSES-WEB-APP-PHP-101
### I decided to learn PHP and then i found [Learn PHP The Right Way](https://youtube.com/playlist?list=PLr3d3QYzkw2xabQRUpcZ_IBk9W50M9pe-).
### This is a project from the playlist so i could practice.
#### Its an app that takes multiple csv files containing transactions composed from ***(Date, Check, Description, Amount)***.

<hr>

## Setting up in:
### `Docker` <- [in 100 Seconds ?](https://youtu.be/Gjnup-PuquQ):
* Clone project wherever you want.
* Install [Docker](https://www.docker.com/get-started).
* From project path:
```bash 
  cd docker
```
* To build docker image and run it:
```bash
  docker-compose up -d
```
* SSH into docker container:
```bash
  docker exec -it EXPENSES-WEB-APP-PHP-101-app bash
```
* Installing project dependencies:
```bash
  composer install
```
### `XAMPP` or alternatives:
* Clone project inside htdocs or the alternative default folder.
* [Get composer](https://getcomposer.org/).
* From project path:
```bash
  composer install
```
* using host: `localhost`, port: `3306`, user: `root`, password: `root` connect to `MySQL` database and launch this script:
```mysql
create database if not exists expensesApp;
use expensesApp;
create table if not exists invoice(
    id int unsigned primary key auto_increment,
    date int unsigned,
    t_check int,
    description varchar(255),
    amount double
);
```
* Test this out in [localhost](http://localhost:8000/).
