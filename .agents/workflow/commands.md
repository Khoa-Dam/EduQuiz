# EduQuiz Commands

This file stores standard commands for running, migrating, testing, and building the project.

## Install Dependencies

```bash
composer install
npm install
```

## Environment

```bash
cp .env.example .env
php artisan key:generate
```

## Database

Database name:

```text
eduquiz_db
```

MySQL example:

```sql
CREATE DATABASE eduquiz_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Migrate:

```bash
php artisan migrate
```

Fresh migrate with seed:

```bash
php artisan migrate:fresh --seed
```

Warning:

* `migrate:fresh --seed` deletes existing database tables/data.

## Run Development Server

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

## Build Assets

```bash
npm run build
```

## Route Check

```bash
php artisan route:list
```

## Tests

```bash
php artisan test
```

## Clear Cache

```bash
php artisan optimize:clear
```

## Useful Artisan Commands

Create model with migration, controller, and resource methods:

```bash
php artisan make:model Course -mcr
```

Create middleware:

```bash
php artisan make:middleware AdminMiddleware
```

Create seeder:

```bash
php artisan make:seeder DemoDataSeeder
```

## Demo Accounts

Admin:

```text
email: admin@example.com
password: password
```

Student:

```text
email: student@example.com
password: password
```
