[![Open Source Love](https://badges.frapsoft.com/os/v1/open-source.svg?v=103)](https://github.com/ellerbrock/open-source-badges/)

# Design Hub

Design Hub is ...

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

## Pre-requisites

What things you need to install the software.

-   Git
-   PHP
-   Composer
-   Web Server like Nginx or Apache
-   Npm or Yarn

## Installation

Clone the git repository on your computer

```
$ git clone https://github.com/fakorede/designhub.git
```

You can also download the entire repository as a zip file and unpack in on your computer if you do not have git

After cloning the application, you need to install it's dependencies.

```
$ cd designhub
$ composer install
$ npm install && npm run dev
```

## Setup

When you are done with installation, copy the .env.example file to .env

```
$ cp .env.example .env
```

Add Client URL

```
CLIENT_URL=http://localhost:3000
```

Generate the application key

```
$ php artisan key:generate
```

Generate JWT secret

```
$ php artisan jwt:secret
```

Create database and add its configuration

```
DB_DATABASE=your_db_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

Configure test Smtp server

```
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

Create an Amazon account and add the ff:

```
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_BUCKET=
```

Set QUEUE_CONNECTION to use `database`

```
QUEUE_CONNECTION=database
```

Run database migrations

```
$ php artisan migrate
```

Run the app

```
$ php artisan serve
```

## Built With

-   [Laravel](https://laravel.com/) - The PHP framework for Web Artisans.
<!-- -   Nuxt - The Intuitive Vue Framework for building the interactive interfaces. -->

### Other Packages Used

- [JWT](https://github.com/tymondesigns/jwt-auth) - JSON Web Token Authentication for Laravel & Lumen.
- [AWS S3 SDK](https://github.com/thephpleague/flysystem-aws-s3-v3) - Flysystem Adapter for AWS SDK V3.
- [Eloquent Taggable](https://github.com/cviebrock/eloquent-taggable) - Easily add the ability to tag your Eloquent models in Laravel.
- [Laravel MySql Spatial](https://github.com/grimzy/laravel-mysql-spatial) - MySQL Spatial Data Extension integration with Laravel.