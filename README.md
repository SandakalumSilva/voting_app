🚀 Laravel Project

A Laravel-based web application built with Laravel 10.x (update version accordingly).

📌 Requirements

Before running the project, make sure you have installed:

PHP >= 8.1

Composer

MySQL / PostgreSQL

Node.js & NPM

Laravel Installer (optional)

Install dependencies:

composer install
npm install && npm run dev

Create a .env file from the example:

cp .env.example .env

Generate application key:

php artisan key:generate

php artisan migrate --seed

php artisan serve
