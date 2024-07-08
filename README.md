
---

# Bookvault

Bookvault is a web application designed for book enthusiasts to manage their reading lists, keep track of books they have read, want to read, and mark their favorite books.

## Prerequisites

Before you begin, ensure you have met the following requirements:

- You have installed [XAMPP](https://www.apachefriends.org/index.html).
- You have cloned the repository from GitHub.
- You have basic knowledge of PHP and MySQL.

## Installation

To install Bookvault, follow these steps:

1. **Clone the Repository:**
    ```bash
    git clone https://github.com/zubeir-adan/Bookvault.git
    ```

2. **Start XAMPP:**
    - Open XAMPP Control Panel.
    - Start Apache and MySQL modules.

3. **Import the Database:**
    - Open your web browser and go to [phpMyAdmin](http://localhost/phpmyadmin).
    - Create a new database named `bookvault`.
    - Import the `bookvault.sql` file located in the `database` folder of the project into the `bookvault` database.

4. **Configure the Project:**
    - Open the project folder in your preferred code editor.
    - Navigate to the `config` folder and open `config.php`.
    - Update the database connection details if necessary:
    ```php
    <?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'bookvault');
    ?>
    ```

5. **Run the Project:**
    - Place the project folder into the `htdocs` directory of your XAMPP installation (e.g., `C:\xampp\htdocs\Bookvault`).
    - Open your web browser and go to [http://localhost/Bookvault](http://localhost/Bookvault).

## Database Structure

The `bookvault` database includes the following tables:

### admin
- `admin_id` (int, AUTO_INCREMENT, Primary Key)
- `admin_name` (varchar(50), NOT NULL)
- `email` (varchar(50), NOT NULL)
- `password_hash` (varchar(255), NOT NULL)

### favorite_books
- `id` (int, AUTO_INCREMENT, Primary Key)
- `user_id` (int, NOT NULL, Index)
- `book_img` (varchar(255), NOT NULL)
- `book_title` (varchar(255), NOT NULL)
- `timestamp` (timestamp, NOT NULL, Default: current_timestamp())

### haveread
- `id` (int, AUTO_INCREMENT, Primary Key)
- `user_id` (int, NOT NULL, Index)
- `book_img` (varchar(500), NOT NULL)
- `book_title` (varchar(255), NOT NULL)
- `book_author` (varchar(255), NOT NULL)
- `book_date` (varchar(255), NOT NULL)
- `timestamp` (timestamp, NOT NULL, Default: current_timestamp())

### search_history
- `id` (int, AUTO_INCREMENT, Primary Key)
- `user_id` (int, NOT NULL, Index)
- `search_query` (varchar(255), NOT NULL)
- `search_time` (timestamp, NOT NULL, Default: current_timestamp())

### users
- `user_id` (int, AUTO_INCREMENT, Primary Key)
- `username` (varchar(255), NOT NULL)
- `email` (varchar(255), NOT NULL)
- `password_hash` (varchar(255), NOT NULL)

### want_to_read
- `id` (int, AUTO_INCREMENT, Primary Key)
- `user_id` (int, NOT NULL, Index)
- `book_img` (varchar(200), NOT NULL)
- `book_title` (varchar(200), NOT NULL)
- `book_author` (varchar(200), NOT NULL)
- `book_date` (varchar(200), NOT NULL)
- `timestamp` (timestamp, NOT NULL, Default: current_timestamp())

## Database Schema

To set up the database schema, use the following SQL queries:

```sql
-- Create the database
CREATE DATABASE IF NOT EXISTS bookvault;

-- Use the database
USE bookvault;

-- Create the admin table
CREATE TABLE admin (
    admin_id INT(11) NOT NULL AUTO_INCREMENT,
    admin_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    PRIMARY KEY (admin_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the favorite_books table
CREATE TABLE favorite_books (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    book_img VARCHAR(255) NOT NULL,
    book_title VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the haveread table
CREATE TABLE haveread (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    book_img VARCHAR(500) NOT NULL,
    book_title VARCHAR(255) NOT NULL,
    book_author VARCHAR(255) NOT NULL,
    book_date VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the search_history table
CREATE TABLE search_history (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    search_query VARCHAR(255) NOT NULL,
    search_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the users table
CREATE TABLE users (
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    PRIMARY KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the want_to_read table
CREATE TABLE want_to_read (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    book_img VARCHAR(200) NOT NULL,
    book_title VARCHAR(200) NOT NULL,
    book_author VARCHAR(200) NOT NULL,
    book_date VARCHAR(200) NOT NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

## Usage

### Admin Panel:

- Access the admin panel at [http://localhost/Bookvault/admin](http://localhost/Bookvault/admin).
- Log in with admin credentials to manage the application.

### User Registration and Login:

- Users can register for an account and log in to manage their book lists.

### Managing Books:

- Users can add books to their favorite list, mark books as read, and add books they want to read.

## Contributing

To contribute to Bookvault, follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes and commit them (`git commit -m 'Add feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.

## License

This project is licensed under the MIT License. See the LICENSE file for details.

---

This README provides a comprehensive guide for setting up, using, and contributing to the Bookvault project. If you have any additional details or specific instructions, feel free to include them.
