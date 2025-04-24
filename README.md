# Laravel_vue_CURD_innobot
Laravel vue CURD innobot

# Full Stack CRUD Application with Laravel & Vue.js

This is a full-stack CRUD application built using **Laravel (PHP)** for the backend and **Vue.js (JavaScript)** for the frontend. The application allows users to create, read, update, and delete data, including uploading a profile picture. It includes proper form validation, error handling, and paginated data display.

---

## 📁 Project Structure

project-root/ │ ├── Backend/ # Laravel application │ ├── Frontend/ # Vue.js (Quasar or Vue CLI) application │ └── README.md


---

## 🚀 Features

- Create a new user with fields:
  - Name (required)
  - Email (required, valid email format)
  - Phone Number (optional, numeric)
  - Address (optional)
  - Age (optional, numeric)
  - Profile Picture (optional, image upload)
- View saved data in a paginated table
- Update existing user information
- Delete a user
- Client-side and server-side validation
- Error message display for invalid input
- File upload support with public storage access

---

## 🛠️ Tech Stack

| Layer      | Tech        |
|------------|-------------|
| Frontend   | Vue.js      |
| Backend    | Laravel     |
| Database   | MySQL       |
| API        | RESTful     |
| File Upload | Laravel Filesystem (public disk) |

---

## ⚙️ Setup Guide

---

## 📦 Backend (Laravel)

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL
- Laravel CLI

### Installation

```bash
cd Backend

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your .env with correct DB credentials
# DB_DATABASE=your_db
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations
php artisan migrate

# (Optional) Create symbolic link for file uploads
php artisan storage:link

# Serve the app
php artisan serve

 Frontend (Vue.js)
Prerequisites
Node.js >= 18.x

npm or yarn

Vue CLI or Quasar CLI (depending on setup)

Installation

cd Frontend

# Install dependencies
npm install

# Run the app
npm run dev

Ensure API endpoints in your frontend point to the Laravel backend URL (e.g., http://localhost:8000/api/users).

API Endpoints

Method	Endpoint	Description
GET	/api/users	Get all users (paginated)
GET	/api/users/{id}	Get a single user
POST	/api/users	Create a new user
PUT	/api/users/{id}	Update a user
DELETE	/api/users/{id}	Delete a user

File Upload
Profile pictures are stored in storage/app/public/profile_pictures

Publicly accessible via http://localhost:8000/storage/profile_pictures/{filename}

Validation Rules

Name: Required

Email: Required, valid email format

Phone Number: Optional, must be numeric if provided

Age: Optional, must be numeric if provided

Profile Picture: Optional, must be a valid image file

 Testing
You can run backend tests (unit and feature) from the Laravel app directory:

bash
Copy
Edit
php artisan test

 License
This project is open-source and available under the MIT license.