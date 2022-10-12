# ToDo & Co

> A simple to-do list app which may have needed some enhancements here & there!

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/30d28b33b7fd4fbb92d0a523cff172eb)](https://www.codacy.com/gh/EstelleMyddleware/todo/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=EstelleMyddleware/todo&amp;utm_campaign=Badge_Grade)
[![GitHub release (latest by date)](https://img.shields.io/github/v/release/EstelleMyddleware/todo)](https://github.com/EstelleMyddleware/todo)
![GitHub package.json dependency version (prod)](https://img.shields.io/github/package-json/dependency-version/EstelleMyddleware/todo/bootstrap)
![GitHub repo size](https://img.shields.io/github/repo-size/EstelleMyddleware/todo)
[![GitHub issues](https://img.shields.io/github/issues/EstelleMyddleware/todo)](https://github.com/EstelleMyddleware/todo/issues)
[![GitHub closed issues](https://img.shields.io/github/issues-closed/EstelleMyddleware/todo)](https://github.com/EstelleMyddleware/todo/issues?q=is%3Aissue+is%3Aclosed)
![GitHub last commit](https://img.shields.io/github/last-commit/EstelleMyddleware/todo)
[![docsify](https://img.shields.io/badge/documented%20with-docsify-cc00ff.svg)](https://docsify.js.org/)

!> This project is part of the Openclassrooms PHP / Symfony Apps Developer training course. It consists in auditing, 
unit-testing, profiling & making improvements to an existing to-do list app built in Symfony 3.1 
(available [here](https://github.com/saro0h/projet8-TodoList)).

You can view the detailed documentation of this project [here](https://estellemyddleware.github.io/todo/)

## Installation

### Downloading the project

If you would like to install this project on your computer, you will first need to [clone the repo](https://github.com/EstelleMyddleware/snowtricks) of this project using Git.

At the root of your project, you need to create a .env.local file (same level as .env) in which you need to configure the 
appropriate values for your blog to run. Specifically, you need to override the following variables :

```text
DATABASE_URL="mysql://root:password@localhost:3306/todo"
ADMIN_EMAIL=youremail@example.com
ADMIN_PASSWORD=ChooseAStrongPersonalPasswordHere
ADMIN_USERNAME=youradminusername
 ```

### Requirements

* PHP 8.0 or above
* yarn & Node.js
* [composer](https://getcomposer.org/download/)
* Download the [Symfony CLI](https://symfony.com/download).
* Run this command will guide you in cases there are missing extensions or parameters you need to tweek on your machine

```bash
symfony check:requirements  
```

### Install dependencies

Before running the project, you need to run the following commands in order to install the appropriate dependencies.

```bash
composer install
```

#### Create a database

Now let's create our database. This will use the DATABASE_URL you've provided in .env.local file.

```bash
php bin/console doctrine:database:create
```

### Generating the database schema

```bash
 php bin/console doctrine:schema:update --force
 ```

### Loading the initial data (initial tasks & anonymous user)

```bash
php bin/console doctrine:fixtures:load --append
```

### Install & build web assets

```bash
yarn install
yarn build
```

Now you should be ready to launch the dev webserver using

```bash
symfony serve
```

The ```symfony serve``` command will start a PHP webserver.
You can now go to your localhost URL : <http://127.0.0.1:8000> where the app should be displayed.

>NB: alternatively, if you do not wish to use the Symfony webserver, you can always use WAMP / Laragon / MAMP or a similar webserver suite.

## Success Criteria

The aim of this project is to evaluate the following skills :

- to set up & implement unit & functional tests
- to implement new features on an existing app 
- to read & describe pieces of code written by other developers
- to make a test results report
- to evaluate code quality & app performance
- to set up an action plan in order to reduce an app's technical debt
- to provide corrective patches when tests suggest so
- to give advice on how to improve the project even further

## Credits

Created by [Estelle Gaits](http://estellegaits.fr) as the eigth project of the Openclassrooms PHP / Symfony Apps Developer training course.