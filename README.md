# MedicaLink-JIAT
This project is for the final viva for "Web Programming 1" subject in JAVA Institute for Advanced Technology.

## Project Description
MedicaLink is an innovative Electronic Health Record system designed to revolutionize the future of health management.

## Features
### Admin
- [x] Can register patients to the system
- [x] Can view all the patients that registered by admin’s hospital
- [x] Can update existing vaccination records or medical records for specific patient that inserted by admins’s hospital
- [x] Can add vaccination records or medical records for specific patient
- [x] Can search for specific vaccination record or medical record
- [x] Can view individual profiles of patients including basic information, vaccination history and medical records history
- [x] Search for any patient using NIC, Name and Registered Hospital
- [x] View all patients on the system
- [x] Can get statistics related to their medical institute
- [x] Can logged into the system

### Patient
- [x] Can search for specific vaccination record or medical record
- [x] Can view patient’s profiles including basic information, vaccination history and medical records history
- [x] Can logged into the system

## Technologies
- PHP
- Laravel
- MySQL
- HTML
- CSS
- JavaScript

## Installation
1. Clone the repository
```bash
git clone
```

2. Install the dependencies
```bash
composer install
```

3. Create a copy of your .env file
```bash
cp .env.example .env
```

4. Generate an app encryption key
```bash
php artisan key:generate
```

5. Create an empty database for our application

6. In the .env file, add database information to allow Laravel to connect to the database

7. Migrate the database
```bash
php artisan migrate
```

8. Seed the database
```bash
php artisan db:seed
```
9. Create a symbolic link
```bash
php artisan storage:link
```

10. Start the server
```bash
php artisan serve
```

11. You can now access the server at http://localhost:8000