# Backoffice

- Laravel 9.52.4

## Requirements

- PHP 8.1
- Composer 2.0.11
- Node 18.12.1
- NPM 8.19.2
- DB: PostgreSQL 15.2

## Installation

- Clone the repository
- Copy `.env.example` to `.env`
- Set the database credentials in `.env`
- Run `composer install`
- Run `npm install`
- Run `php artisan key:generate`
- Run `php artisan migrate:fresh --seed`
