# Symfony 7 Application with PHP 8.3.4, MySQL, PHPUnit

Welcome to our Symfony 7 application repository! This repository contains a Symfony web application built using Symfony 7, PHP 8, MySQL, and PHPUnit for testing. The application provides various endpoints to retrieve specific information about employees and departments.

## Prerequisites
Before you begin, ensure you have the following installed on your local machine:

   - PHP 8.3.*
   - Composer
   - Docker (for running the database with Docker)
   - Symfony CLI
   - PHPUnit

## Installation

1. Clone the repository to your local machine:

   - git clone https://github.com/zoleikha-mousavipak/Symfony7_EmployeeManagement.git


2. Navigate to the project directory:

   - cd Symfony7_EmployeeManagement

3. Run Docker to start the database:

   - docker compose up -d

4. Install dependencies using Composer:

   - composer install

5. Configure your database connection in .env file:

   - DATABASE_URL="mysql://root:root@127.0.0.1:3306/employment_db?serverVersion=10.8.3-MariaDB&charset=utf8mb4"

6. Create the database schema and migrate:

   - php bin/console doctrine:database:create
   - php bin/console make:migration
   - php bin/console doctrine:migrations:migrate

7. Insert Departments and Employees Data with loading fixtures

   - php bin/console doctrine:fixtures:load


10. Insert users with  App Command (params: username: admin@test.com, password: 123456):

   - symfony console app:create-user admin@test.com 123456
   - symfony console app:create-user manager@test.com 123456
   - symfony console app:create-user user@test.com 123456
  

## Running the App

   - symfony server:start

## Database

   - Link: http://localhost:8080/
   - In User-table:
      1. add ["ROLE_ADMIN"] to rolls field for admin-user(admin@test.com)
      2. add ["ROLE_MANAGER"] to rolls field for manager-user(manager@test.com)

## Testing

To demonstrate how the various endpoints behave, a PHPUnit test has been provided. Run the test with:

   - php bin/phpunit