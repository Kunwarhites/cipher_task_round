# Secure API with Authentication in Laravel

## Overview
This project is a RESTful API built using Laravel that allows users to perform Create and Read operations on a Transaction resource. API authentication is implemented using Laravel Sanctum, ensuring only authenticated users can access the API.

## Features
- User Registration & Authentication
- API Token-Based Authentication (Laravel Sanctum)
- CRUD operations on Transactions (Create, Read)
- User-Specific Data Access (Users can only manage their own transactions)
- Middleware & Policies for Authorization
- API Rate Limiting (Bonus)

## Requirements
- PHP >= 8.1
- Composer
- Laravel latest version
- MySQL or any supported database

## Installation Instructions
### Step 1: Clone the Repository

 git clone https://github.com/Kunwarhites/cipher_task_round.git
 cd your-repository-folder


### Step 2: Install Dependencies

 composer install


### Step 3: Set Up Environment Variables
- Copy the `.env.example` file and rename it to `.env`

 cp .env.example .env

- Update the `.env` file with your database credentials.

### Step 4: Generate Application Key

 php artisan key:generate


### Step 5: Run Migrations

 php artisan migrate


### Step 6: Install Laravel Sanctum (or Passport)

 php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
 php artisan migrate


### Step 7: Start the Application

 php artisan serve


## API Endpoints

### Authentication
- **Register a new user**
  
  POST /api/register
  
- **Login and receive API token**
  
  POST /api/login
  
- **Logout (Requires Auth Token)**
  
  POST /api/logout
  

### Transactions
- **Create a new transaction (Authenticated users only)**
  
  POST /api/transactions
  
- **Retrieve a list of transactions (Authenticated users only)**
  
  GET /api/transactions
  
- **Retrieve a single transaction by ID (Authenticated users only)**
  
  GET /api/transaction/{id}
  

## Authorization & Middleware
- All transaction routes are protected using `auth:sanctum`.
- Users can only manage their own transactions.
- API rate limiting is implemented to prevent abuse.

## Running Tests
To ensure all endpoints work correctly and securely, run the following command:

 php artisan test


## Contribution
- Fork the repository
- Create a new branch (`feature-branch`)
- Commit your changes
- Push the branch and create a Pull Request


## Contact
For any inquiries, feel free to contact [singhhitesh001122@gmail.com].

