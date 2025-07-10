# Employee Time Tracking System (Pointage Employee)

A comprehensive Laravel-based employee time tracking and management system. This application provides a complete solution for managing employee attendance, timesheets, leave requests, and administrative oversight.

## 🚀 Features

### For Employees
- **Time Tracking**: Clock in/out functionality with real-time status
- **Timesheet Management**: View personal timesheet history and records
- **Leave Management**: Submit and track leave requests
- **Profile Management**: Update personal information and settings
- **Dashboard**: Overview of current status and recent activities

### For Administrators
- **Employee Management**: Complete CRUD operations for employee records
- **Real-time Dashboard**: Live statistics and system overview
- **Timesheet Reports**: Detailed reporting with filtering and export options
- **Leave Approval**: Review and manage employee leave requests
- **User Management**: Control user accounts and permissions
- **Department Management**: Organize employees by departments and positions

### System Features
- **Role-based Access Control**: Admin and Employee user roles
- **Responsive Design**: Mobile-friendly interface
- **Secure Authentication**: Laravel's built-in authentication system
- **Data Validation**: Comprehensive input validation and error handling
- **Modern UI**: Clean and intuitive user interface

## 🛠️ Technology Stack

- **Backend**: Laravel 12.x (PHP 8.2+)
- **Frontend**: Blade templates with Bootstrap/Sass
- **Database**: SQLite (configurable for MySQL/PostgreSQL)
- **Authentication**: Laravel UI
- **Build Tools**: Vite for asset compilation
- **Testing**: PHPUnit for unit and feature tests

## 📋 Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and npm
- SQLite (or MySQL/PostgreSQL if preferred)

## 🔧 Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd pointageEmployee
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database**
   - Edit `.env` file with your database configuration
   - For SQLite (default): The database file is already included

6. **Run Database Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed Database (Optional)**
   ```bash
   php artisan db:seed
   ```

8. **Compile Assets**
   ```bash
   npm run dev
   # or for production
   npm run build
   ```

9. **Start Development Server**
   ```bash
   php artisan serve
   ```

The application will be available at `http://localhost:8000`

## 👥 Default User Accounts

After seeding the database, you can use these credentials:

### Administrator Account
- **Email**: admin@example.com
- **Password**: password
- **Role**: Admin (full system access)

### Employee Accounts
- **John Doe**
  - Email: john@example.com
  - Password: password
  - Role: Employee

- **Jane Smith**
  - Email: jane@example.com
  - Password: password
  - Role: Employee

## 📱 Usage Guide

### Employee Workflow
1. **Login** with employee credentials
2. **Clock In/Out** from the dashboard
3. **View Timesheets** to track work hours
4. **Submit Leave Requests** through the leave management system
5. **Update Profile** information as needed

### Administrator Workflow
1. **Login** with admin credentials
2. **Monitor Dashboard** for system overview and statistics
3. **Manage Employees** - add, edit, or deactivate employee records
4. **Review Timesheets** and generate reports
5. **Process Leave Requests** - approve or deny employee requests
6. **System Administration** - manage users and system settings

## 🗃️ Database Schema

### Core Tables
- **users**: User authentication and basic info
- **employees**: Employee details and department information
- **timesheets**: Time tracking records (clock in/out)
- **leaves**: Leave request management
- **cache/jobs**: Laravel system tables

### Key Relationships
- User → Employee (One-to-One)
- Employee → Timesheets (One-to-Many)
- Employee → Leaves (One-to-Many)

## 🧪 Testing

Run the test suite:
```bash
# Run all tests
php artisan test

# Run specific test types
./vendor/bin/phpunit tests/Feature
./vendor/bin/phpunit tests/Unit
```

## 🚀 Deployment

### Production Setup
1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Configure production database
4. Run optimizations:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   composer install --optimize-autoloader --no-dev
   ```

### Server Requirements
- PHP 8.2+
- Web server (Apache/Nginx)
- Database server
- SSL certificate (recommended)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/new-feature`)
3. Commit your changes (`git commit -am 'Add new feature'`)
4. Push to the branch (`git push origin feature/new-feature`)
5. Create a Pull Request

## 📁 Project Structure

```
pointageEmployee/
├── app/
│   ├── Http/Controllers/    # Application controllers
│   ├── Models/             # Eloquent models
│   └── Providers/          # Service providers
├── database/
│   ├── migrations/         # Database schema migrations
│   └── seeders/           # Database seeders
├── resources/
│   ├── views/             # Blade templates
│   ├── css/               # Stylesheets
│   └── js/                # JavaScript files
├── routes/
│   └── web.php            # Web routes
└── tests/                 # Test files
```

## 🐛 Troubleshooting

### Common Issues
- **Permission errors**: Ensure `storage/` and `bootstrap/cache/` are writable
- **Database connection**: Check `.env` database configuration
- **Asset compilation**: Run `npm run dev` if styles/scripts aren't loading

### Support
For issues and questions, please open an issue in the repository.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 📊 Version History

- **v1.0.0** - Initial release with core time tracking features
- **v1.1.0** - Added leave management system
- **v1.2.0** - Enhanced reporting and dashboard features
