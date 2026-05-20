# Project Documentation

This document summarizes the **Campus Health Appointment System (CHAS)** based on the requirements in the final examination rubric. Deployment is intentionally excluded from this copy, as requested.

## 1. Project Title

**Campus Health Appointment System (CHAS)**

## 2. Course Context

- **Course:** IT 318L - Web Development
- **Assessment Type:** Final Term Examination (Project-Based Assessment)
- **Project Requirement:** Laravel-based web system using PHP, CRUD operations, MySQL integration, migrations, and responsive interface design

## 3. Project Overview

CHAS is a web-based student health portal designed to help campus clinic users manage appointments and health-related records online. The system reduces manual clinic processes by allowing students to request services, maintain health records, and organize emergency contact information in one account.

## 4. Project Objectives

The project was developed to:

- apply PHP programming inside the Laravel framework
- implement CRUD operations in a working web application
- integrate MySQL using Laravel migrations and Eloquent ORM
- build a responsive and organized user interface
- demonstrate proper Laravel MVC structure and routing
- support testing and project documentation for academic presentation

## 5. Target Users

- students using campus clinic services
- clinic staff during demonstrations and system presentation
- instructors evaluating Laravel, CRUD, and database integration

## 6. Technologies Used

- **Backend:** PHP, Laravel 10
- **Frontend:** Blade templates, Tailwind CSS, Vite
- **Database:** MySQL
- **ORM / Query Handling:** Eloquent ORM
- **Testing:** PHPUnit feature tests
- **Version Control:** Git-based project repository

## 7. Laravel and MVC Implementation

The system follows Laravel conventions and MVC structure:

- **Models**
  - `User`
  - `Appointment`
  - `HealthRecord`
  - `MedicalServiceRequest`
  - `EmergencyContact`
  - `LoginActivity`
- **Controllers**
  - `DashboardController`
  - `BookingController`
  - `MedicalServiceController`
  - `MyHealthController`
  - `EmergencyInfoController`
  - authentication and profile controllers
- **Views**
  - landing page
  - dashboard
  - booking page
  - medical services page
  - my health page
  - emergency info page
  - authentication screens
- **Routing**
  - public routes for landing page and auth
  - protected routes for dashboard and modules
  - middleware for authenticated access and email verification

## 8. System Modules and Functionalities

### 8.1 Dashboard

- displays total upcoming appointments
- displays pending service requests
- displays active health records
- displays emergency contact count
- shows recent user health and service activity

### 8.2 Booking Module

- book an appointment
- view scheduled appointments
- reschedule an appointment
- cancel an appointment
- generate queue numbers
- prevent duplicate time-slot conflicts for the same user

### 8.3 Medical Services Module

- submit a medical service request
- choose a preferred date and priority level
- view request history
- update request status
- delete old requests

### 8.4 My Health Module

- add health records
- categorize health entries
- store titles, values, dates, notes, and statuses
- update health record status
- delete records

### 8.5 Emergency Info Module

- save emergency contacts
- mark a primary emergency contact
- store phone, email, address, and notes
- remove contacts when needed

### 8.6 Authentication and Account Features

- register a new account
- log in and log out
- edit profile information
- update password
- request password reset
- verify email address
- record login activity and logout timestamps

## 9. CRUD Matrix

| Module | Create | Read | Update | Delete |
| --- | --- | --- | --- | --- |
| Medical Services | Yes | Yes | Yes | Yes |
| My Health | Yes | Yes | Yes | Yes |
| Emergency Contacts | Yes | Yes | Yes | Yes |
| Booking | Yes | Yes | Yes | User cancellation |

## 10. Database Design

The database uses Laravel migrations and foreign-key relationships.

### Main Tables

- `users`
  - stores account information and login tracking metadata
- `appointments`
  - stores appointment details, queue numbers, dates, times, concerns, and statuses
- `health_records`
  - stores categorized personal health data
- `medical_service_requests`
  - stores service requests with priority and status
- `emergency_contacts`
  - stores student emergency contact details
- `login_activities`
  - stores login and logout history

### Relationships

- one user has many appointments
- one user has many health records
- one user has many medical service requests
- one user has many emergency contacts
- one user has many login activity entries

### Database Features

- migration-based table creation
- indexed columns for common lookups
- foreign keys with cascading or null-on-delete behavior
- Eloquent relationships for data access

## 11. Validation and Error Handling

The system uses Laravel validation rules to ensure input quality.

Examples include:

- required fields for forms
- date validation for appointments and service requests
- allowed status and category values
- max-length limits for text fields
- ownership checks to prevent unauthorized edits or deletions
- conflict checking for duplicate appointment time slots

Validation errors are displayed directly in the user interface to support usability and better data entry.

## 12. UI/UX Notes

The interface was designed to be:

- responsive on desktop and mobile screens
- consistent across dashboard and module pages
- easy to navigate through a shared portal layout
- form-driven with clear labels and validation feedback
- visually aligned with a campus health theme

## 13. Security and Access Control

- authenticated middleware protects student-only pages
- verified middleware protects dashboard access
- ownership checks prevent cross-user record manipulation
- CSRF protection is enabled through Laravel's default middleware
- password handling uses Laravel hashing and auth features

## 14. Testing and Quality Checks

The project includes PHPUnit feature tests for:

- authentication
- dashboard metrics
- booking
- medical services
- my health records
- emergency contacts
- profile actions
- login activity behavior

## 15. Version Control Notes

For rubric alignment, the project repository should show:

- organized Laravel project structure
- meaningful commit history
- updated README and project documentation

This codebase now includes project-specific repository documentation instead of the default Laravel starter README.

## 16. Team Roles

Use this section in your final printed or submitted copy if your instructor asks for explicit role assignment:

- Project Manager: ____________________
- Backend Developer: ____________________
- Frontend / UI Designer: ____________________
- Tester: ____________________
- Documentation Lead: ____________________

## 17. Conclusion

CHAS satisfies the core academic requirements of a Laravel-based CRUD web system by combining PHP application logic, MySQL-backed storage, migrations, Eloquent ORM, validation, responsive design, and multiple student-health modules in one integrated platform.

## 18. Scope Note

Deployment details are intentionally omitted from this documentation file, based on the current project request.
