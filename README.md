<br />
<p align="center">
  <h3 align="center">Kampus API</h3>
  <p align="center">
    <a href="https://documenter.getpostman.com/view/25619202/2s9YRFUVLX">Api Demo</a>
  </p>
</p>

## List Contents

- [List Contents](#list-contents)
- [About](#about)
  - [List Library](#list-library)
- [Installation](#installation)
  - [Requirement](#requirement)
  - [Setitng Up The Database](#setting-up-the-database)
  - [Cloning The Project](#cloning-this-project)
  - [Enviroment Configuration](#enviroment-configuration)
  - [Installing Dependencies](#installing-dependencies)
  - [Starting The Server](#starting-the-server)
- [Documentation](#documentation)

# About

Campus API adalah proyek pengelolaan dan tampilan data yang dirancang untuk menyederhanakan proses administrasi kampus. API ini telah dikembangkan dengan cermat untuk menyediakan antarmuka yang ramah pengguna bagi Pengembang Frontend, memfasilitasi pengelolaan dan presentasi data yang efisien.

## List Library

These are the libraries and service used for building this backend API
- [Fakerphp](https://fakerphp.github.io)
- [Mockery](https://vektra.github.io)
- [Nunomaduro](https://packagist.org/packages/nunomaduro/collision)
- [Phpunit](https://phpunit.de/getting-started/phpunit-10.html)
- [Spatie](https://spatie.be)

# Installation

To run this project locally, follow these steps:

## 1. Requirement
- [Laragon](https://laragon.org/index.html): You will need Laragon as database. If you don't have it installed, download and set it up or if you have another database.
- [Composer](https://getcomposer.org/): Composer is a PHP dependency management tool that is essential for managing and installing the required packages for this Laravel project. If you haven't already installed Composer, you can download it from the official website.

## 2. Setting Up the Database

1. Ensure you have a database server (e.g., MySQL) installed and running.
2. Create a new database for this project, example name (campus).

## 3. Cloning This Project

1. Clone the repository:
```sh
git clone https://github.com/Razha90/vercel-laravel-api.git
``` 

## 4. Enviroment Configuration

Create a copy of the .env.example file and name it .env. Update the following variables in the .env file:

- DB_CONNECTION: Set this to your database connection (e.g., mysql).
- DB_HOST: Set this to the database host.
- DB_PORT: Set this to the database port (default is 3306).
- DB_DATABASE: Set this to the name of the database you created.
- DB_USERNAME: Set this to your database username.
- DB_PASSWORD: Set this to your database password.

## 5. Installing Dependencies

1. Install Composer Dependencies:
```sh
composer install
```

2. Run Database Migrations:
```
php artisan migrate
```

## 6. Starting The Server
1. Start your Database and ensure your environment is up and running.
2. Start the Laravel development server:
```
php artisan serve
```
The project should now be accessible at http://localhost:8000.

## Documentation

Documentation files are provided in the [docs](./docs) folder

- [Postman API colletion](./docs/Campus_Bridge_API.postman_collection.json)
- [SQL database Struktur](./docs/Struktur-Data.sql)
- [Database diagram](./docs/RelasiDatabase.png)

API endpoint list are also available as published postman documentation

[![Run in Postman](https://run.pstmn.io/button.svg)](https://documenter.getpostman.com/view/25619202/2s9YRFUVLX)


Project link : [https://github.com/Razha90/vercel-laravel-api](https://github.com/Razha90/vercel-laravel-api)
