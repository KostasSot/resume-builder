# CV Builder App

A fully responsive, real-time CV builder built with Laravel, Livewire, and Tailwind CSS. Features include dynamic form inputs, PDF parsing/extraction, and pixel-perfect PDF generation.

## Prerequisites

* **PHP** (v8.2 or higher)
* **Composer**
* **Node.js & NPM**
* **MySQL**
* **Git**

## Installation

**1. Clone the repository and navigate into it:**
```bash
git clone https://github.com/YOUR-USERNAME/cv-builder-app.git
cd cv-builder-app
```

**2. Install PHP and Node dependencies:**
```bash
composer install
npm install
```

**3. Set up your environment file:**
```bash
cp .env.example .env
```
*Open the new .env file and update your database credentials to match your local setup.*

**4. Generate the application key:**
```bash
php artisan key:generate
```

**5. Create the database and run migrations:**
*Ensure you have created an empty database in MySQL that matches your .env configuration, then run:*
```bash
php artisan migrate
```

**6. Start the development servers:**
*Run the following commands in two separate terminal windows to boot the frontend and backend:*
```bash
npm run dev
```
```bash
php artisan serve
```
