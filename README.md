# Movies Reviews Management System

This project is a simple Movies Reviews Management System built using PHP and SQLite for the purpose of the subject "Implementing systems with open source code" at FSCE.
The full requirements are located in the `INSTRUCTIONS.md` file, but in short, the system allows users to:

- Add, update and delete movie reviews (only if they are the author),
- A user cannot delete a movie review with a rating higher than 8,
- Store movie reviews data (title, director, genre, rating, date, description, username) in an SQLite database,
- Use JWT for authentication,
- All sensitive configuration is managed through the `.env` file,
- Unauthorized users can only view the movie reviews.

## Requirements

- PHP 7.4 or higher
- Composer (for dependency management)
- SQLite

## Installation

### 1. Clone the repository

Clone the project repository to your local machine

```bash
git clone https://github.com/tkovachka/phpProject.git
cd phpProject
git checkout project-movie-reviews
```

### 2. Install dependencies
```bash
composer install
```


### 3. Create an .env file
Copy the necessary variables from `.env.example` to an `.env` file (in the root folder) and give them values
```bash
cp .env.example .env
```
- JWT_SECRET: A secret key for signing JWT tokens (use a strong, random key, you can execute the `generate_key.php` function).


### 4. Setting up the database
The database connection is handled in the `database/db.php` file.
To create the necessary tables for the project, execute the 2 migrations in the `database/migrations` folder.
If your current location is the root folder, you can use:
```bash
php database/migrations create_movies_table.php
php database/migrations create_users_table.php
```
You should now have a `db.sqlite` file in the `database` folder.
You can try to run some SQL commands to make sure the tables are set up correctly:
```sql
SELECT * FROM movies
SELECT * FROM users
```


### 5. Running the project and using the application
You can use run the project on the server:
```
php -S localhost:8000 
```
By visiting `http://localhost:8000` you can use the app.
