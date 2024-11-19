# Expense Management System

This project is a simple Expense Management System built using PHP and SQLite for the purpose of the subject "Implementing systems with open source code" at FSCE.
The system allows users to:

- Add, update, and delete expenses.
- Store expense data (name, date, amount, and payment method) in an SQLite database.
- Use JWT for authentication.
- All sensitive configuration is managed through the `.env` file.

## Requirements

- PHP 7.4 or higher
- Composer (for dependency management)
- SQLite (or another database since the project uses PDO for database connection. If you use another database, make sure to change the driver `$dsn` in the `db.php` file)

## Installation

### 1. Clone the repository

Clone the project repository to your local machine

```
git clone https://github.com/tkovachka/phpProject.git
cd phpProject
git checkout project-expense-system
```

### 2. Install dependencies
```
composer install
```

### 3. Create an .env file
Copy the necessary variables from `.env.example` to an `.env` file and give them values
```
cp .env.example .env
```
- JWT_SECRET: A secret key for signing JWT tokens (use a strong, random key, you can execute the `generate_key.php` function).
- WEBSITE_URL: The URL where you want to run the app. (example `http://localhost:8000`)


### 4. Setting up the database
The database connection is handled in the `db.php` file.
To create the necessary tables for the project, execute this file.
If your current location is the root folder, you can use:
```bash
php db.php
```
You should now have a `database.sqlite` file in the `database` folder.
You can try to run some SQL commands to make sure the tables are set up correctly:
```sql
SELECT * FROM expenses
SELECT * FROM users
```

### 5. Running the project and using the application
You can use the built-in PHP server to run the project
```
php -S localhost:8000
```
By visiting `http://localhost:8000` you can use the app.

