# Employee Time Tracker

A simple Laravel application for tracking employee work hours. Employees can clock in and out, and administrators can manage employees and view timesheet reports.

## Features

- User authentication (admin and employee roles)
- Employee clock in/out functionality
- Employee timesheet history
- Admin dashboard with real-time statistics
- Employee management (add, edit, view, delete)
- Reporting with filtering options

## Installation

1. Clone the repository
2. Navigate to the project directory
3. Install dependencies:
   ```
   composer install
   ```
4. Create and configure your .env file (copy from .env.example)
5. Generate application key:
   ```
   php artisan key:generate
   ```
6. Run database migrations:
   ```
   php artisan migrate
   ```
7. Seed the database with sample data (optional):
   ```
   php artisan db:seed
   ```
8. Install and compile frontend assets:
   ```
   npm install && npm run dev
   ```
9. Start the development server:
   ```
   php artisan serve
   ```

## Default Users

After running the database seeder, you can log in with these credentials:

- Admin:
  - Email: admin@example.com
  - Password: password

- Employee (John):
  - Email: john@example.com
  - Password: password

- Employee (Jane):
  - Email: jane@example.com
  - Password: password

## Usage

### For Employees
- Log in with your employee account
- Use the dashboard to clock in and out
- View your timesheet history

### For Administrators
- Log in with your admin account
- Dashboard shows real-time statistics
- Manage employees (add, edit, view, delete)
- Access detailed timesheet reports with filtering options

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
