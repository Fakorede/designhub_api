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

Run database migrations

```
$ php artisan migrate
```

Run the app

```
$ php artisan serve
```

## Built With

-   Laravel - The PHP framework for building the API endpoints needed for the application.
-   Nuxt - The Intuitive Vue Framework for building the interactive interfaces.