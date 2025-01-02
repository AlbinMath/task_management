# Task Management Application

A simple task management application built with PHP, MySQL, and basic HTML/CSS for managing user tasks. 

## Features
- User authentication (register, login, logout).
- Add, edit, delete, and mark tasks as complete.
- Responsive and user-friendly design.
- Secure session handling.
- Gradient-based modern UI.

## Getting Started

### Prerequisites
- Web server (e.g., Apache or Nginx).
- PHP 7.4 or higher.
- MySQL database.
- Composer (optional, for dependency management).

### Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/AlbinMath/task_management.git
   cd task_management

2. **Set Up the Database**

Create the database by running the SQL commands in database.sql:

CREATE DATABASE task_management;

USE task_management;

-- Table for storing user information
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for storing tasks
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    task VARCHAR(255) NOT NULL,
    status ENUM('pending', 'done') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

3. **Update the Database Connection**

Edit db.php and update the database credentials:

<?php
$host = 'localhost';
$db = 'task_management';
$user = 'your-username';
$pass = 'your-password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

4. **Deploy the Project**

Place the project files in your web server's root directory (e.g., htdocs for XAMPP).
Access the application in your browser: http://localhost/task_management.
Project Structure

.
├── db.php                 # Database connection file
├── register.php           # User registration page
├── login.php              # User login page
├── logout.php             # Logout script
├── dashboard.php          # User dashboard for managing tasks
├── complete_task.php      # Script for marking tasks as complete
├── delete_task.php        # Script for deleting tasks
├── update_task.php        # Script for updating tasks
├── style.css              # CSS for styling the application
└── README.md              # Project documentation

##Usage

Register: Create an account.
Login: Access your account.
Dashboard:
Add new tasks.
Mark tasks as complete.
Edit or delete tasks.

##Security Features

Password hashing using password_hash.
Secure session handling to prevent unauthorized access.
Proper SQL query preparation to prevent SQL injection.
