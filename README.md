# Laravel Project Setup Guide

## 🧩 Requirements
- PHP >= 8.1  
- Composer  
- MySQL or compatible database  
- Node.js & npm  
- Laravel >= 10.x  

## 🚀 Installation Steps

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/your-laravel-project.git
cd your-laravel-project

### Installation
composer install
npm install && npm run build

### Environment setup
cp .env.example .env
php artisan key:generate

### Then update the .env file with your database credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

## after run this command inside project folder terminal
php artisan migrate
php artisan migrate --seed
php artisan queue:work
php artisan schedule:run

## Application run
php artisan serve

### Open Application
http://127.0.0.1:8000


