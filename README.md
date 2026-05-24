# Campus Health Appointment System

Campus Health Appointment System (CHAS) is a Laravel-based web application for managing campus clinic appointments, student health records, medical service requests, and emergency contact information. The project was built for **IT 318L - Web Development** as a CRUD-focused Laravel and MySQL system.

## Project Overview

The system provides a centralized student health portal where authenticated users can:

- book clinic appointments and track queue numbers
- request campus medical services
- maintain personal health records
- manage emergency contact information
- monitor account activity from a user dashboard

The application follows Laravel's MVC architecture and uses PHP, Blade, MySQL, migrations, Eloquent ORM, and built-in validation features.

## Core Features

- **Authentication and profile management**
  - registration, login, logout, password reset, profile update, and email verification
- **Dashboard**
  - summary cards for appointments, service requests, health records, and emergency contacts
  - latest activity and appointment timeline
- **Medical Services module**
  - create service requests
  - view submitted requests
  - update request status
  - delete outdated requests
- **Booking module**
  - create appointments
  - view current bookings
  - reschedule appointments
  - cancel appointments
- **My Health module**
  - create health records
  - view saved records
  - update record status
  - delete records
- **Emergency Info module**
  - create emergency contacts
  - view saved contacts
  - set a primary contact
  - delete contacts
- **Login activity tracking**
  - stores login metadata and logout timestamps

## Technology Stack

- PHP 8.1+
- Laravel 10
- Blade templating
- MySQL
- Eloquent ORM
- Laravel Migrations
- Tailwind CSS / Vite
- PHPUnit feature tests

## Database Summary

Main tables used by the system:

- `users`
- `appointments`
- `health_records`
- `medical_service_requests`
- `emergency_contacts`
- `login_activities`

Relationships are centered on the `users` table through one-to-many Eloquent relationships for appointments, health records, service requests, emergency contacts, and login activity records.

## CRUD Coverage

The rubric requires at least one complete CRUD module. CHAS includes multiple CRUD-capable modules:

- **Medical Services**
  - Create: submit a service request
  - Read: view service request history
  - Update: change request status
  - Delete: remove a request
- **My Health**
  - Create: add a health record
  - Read: view record history
  - Update: change record status
  - Delete: remove a record
- **Emergency Contacts**
  - Create: save a contact
  - Read: view contact list
  - Update: set a contact as primary
  - Delete: remove a contact

## Validation and Access Control

- Form validation is handled through Laravel request validation rules.
- Authenticated routes are protected with middleware.
- Record ownership checks prevent users from editing or deleting other users' data.
- Email verification is supported for protected dashboard access.

## Local Setup

1. Install dependencies:

```bash
composer install
npm install
```

2. Create your environment file and update database credentials:

```bash
copy .env.example .env
php artisan key:generate
```

3. Run migrations:

```bash
php artisan migrate
```

4. Start the application:

```bash
php artisan serve
npm run dev
```

## Free Render Deploy

This repository includes a `render.yaml` Blueprint and Docker setup for a free Render deployment.

- Free Render web service
- Free Render Postgres database
- Auto-generated `APP_KEY`
- Automatic database migrations during startup
- Database-backed sessions for more reliable logins on Render

Use this one-click link:

`https://render.com/deploy?repo=https://github.com/ejamora2005/CHAS/tree/render-free-deploy`

## Testing

Run the automated tests with:

```bash
php artisan test
```

The test suite is configured to use SQLite in memory by default. If your PHP installation does not include the SQLite driver, enable `pdo_sqlite` / `sqlite3` or configure a dedicated testing database before running the tests.

## Repository Notes

- This repository contains the Laravel source code, migrations, tests, and project documentation.
- The project documentation aligned to the exam rubric is available in [PROJECT_DOCUMENTATION.md](PROJECT_DOCUMENTATION.md).
- Deployment details are intentionally excluded from this repository documentation for this version of the project.
