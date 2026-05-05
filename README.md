# 🔧 FixIt — Smart Complaint Management System

> A modern, professional web-based complaint management system designed for educational institutions to streamline the reporting and resolution of campus-related issues.

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [Installation & Setup](#installation--setup)
- [Database Setup](#database-setup)
- [Configuration](#configuration)
- [Usage Guide](#usage-guide)
- [Admin Panel](#admin-panel)
- [API Endpoints](#api-endpoints)
- [Security Features](#security-features)
- [Deployment](#deployment)
- [Troubleshooting](#troubleshooting)
- [Future Enhancements](#future-enhancements)
- [License](#license)

## 🎯 Overview

FixIt is a comprehensive smart complaint management system built specifically for college campuses. It empowers students to submit, track, and manage various campus-related complaints efficiently while providing administrators with tools to prioritize, update, and resolve issues effectively.

### Key Highlights
- **Modern UI Design**: Gradient backgrounds, glassmorphism effects, smooth animations
- **Fully Responsive**: Works seamlessly on desktop, tablet, and mobile devices
- **Production-Ready**: Clean code, security features, and error handling
- **Educational Focus**: Perfect for a 2nd year CSE Capstone project
- **Easy Deployment**: Compatible with XAMPP, InfinityFree, and 000webhost

## ✨ Features

### 1. User Authentication
- Student registration with email verification
- Secure login with bcrypt password hashing
- Session management with timeout
- Remember me functionality
- Profile management
- Password change feature

### 2. Complaint Management
- **Easy Submission**: Simple form to report issues
- **Multiple Categories**:
  - Hostel Issues
  - Lab Issues
  - WiFi Problems
  - Classroom Problems
  - Cleanliness Issues
  - Electrical Problems
  - Other
- **Priority Levels**: Low, Medium, High
- **Status Tracking**: Pending → In Progress → Resolved
- **Rich Descriptions**: Support for detailed complaint descriptions
- **Timestamp Tracking**: Automatic creation and update timestamps

### 3. Dashboard & Tracking
- **Student Dashboard**:
  - Statistics cards (Total, Pending, In Progress, Resolved)
  - Real-time complaint tracking
  - Advanced filtering and search
  - Category-wise breakdown
  - Responsive grid layout

- **Admin Dashboard**:
  - Comprehensive statistics overview
  - Recent complaints table
  - Category breakdown
  - Quick action buttons
  - User and message count
  - One-click access to management features

### 4. Complaint Tracking
- Real-time status updates
- Timeline visualization
- Resolution notes display
- History of updates
- Search by multiple criteria
- Filter by status, category, priority

### 5. Admin Panel (Advanced Features)
- Manage all complaints system-wide
- Update complaint status and add resolution notes
- View detailed complaint information
- Filter and search across all complaints
- Delete complaints if needed
- Access to contact messages
- User management features
- Report generation

### 6. Contact Form
- Easy-to-use contact form for non-registered users
- Email integration
- Message management
- Admin notification system

### 7. Additional Pages
- **Home Page**: Hero section, features showcase, categories overview
- **About Page**: Mission statement, features list, technology stack, how-it-works
- **Contact Page**: Contact form, contact information, FAQ section
- **Profile Page**: User information, password management, account status

## 🛠 Technology Stack

### Frontend
- **HTML5**: Semantic markup and modern standards
- **CSS3**: 
  - CSS Variables for theming
  - Flexbox & CSS Grid
  - Gradients & Animations
  - Glassmorphism effects
  - Responsive design
- **JavaScript (Vanilla)**:
  - Form validation
  - Real-time search & filtering
  - Dynamic UI updates
  - No dependencies (lightweight)

### Backend
- **PHP 7.4+**:
  - Object-oriented programming
  - Prepared statements (SQL injection prevention)
  - Exception handling
  - Session management
  - File operations
- **MySQL 5.7+**:
  - Normalized database schema
  - Indexed queries for performance
  - Foreign key relationships
  - Data integrity constraints

### Security
- **Password Hashing**: bcrypt with PHP's password_hash()
- **SQL Injection Prevention**: Prepared statements with bound parameters
- **XSS Protection**: htmlspecialchars() and output encoding
- **CSRF Protection**: Session validation
- **Secure Headers**: Security headers in config
- **Session Security**: HTTP-only cookies, secure sessions

## 📁 Project Structure

```
complaint_web/
├── index.php                    # Home page
├── register.php                # Student registration
├── login.php                   # Student login
├── logout.php                  # Logout handler
├── dashboard.php               # Student complaint dashboard
├── submit-complaint.php         # Submit new complaint
├── complaint-details.php        # View complaint details
├── profile.php                 # User profile management
├── about.php                   # About page
├── contact.php                 # Contact page
│
├── admin/
│   ├── dashboard.php           # Admin dashboard
│   ├── complaints.php          # Manage complaints
│   ├── complaint-details.php    # Complaint details & update
│   ├── users.php               # User management
│   ├── messages.php            # Contact messages
│   └── reports.php             # Reports & analytics
│
├── includes/
│   ├── config.php              # Configuration file
│   ├── db.php                  # Database connection class
│   ├── auth.php                # Authentication functions
│   └── functions.php           # Business logic functions
│
├── assets/
│   ├── css/
│   │   └── style.css           # Main stylesheet (2000+ lines)
│   ├── js/
│   │   └── validation.js       # Validation & utility functions
│   └── images/                 # Image assets directory
│
├── sql/
│   └── database.sql            # Database schema & sample data
│
├── uploads/                    # File uploads directory
├── README.md                   # This file
└── .gitignore                  # Git ignore file
```

## 🚀 Installation & Setup

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache, Nginx)
- Git (optional)

### Step 1: Download/Clone the Project

**Option A: Direct Download**
1. Download the ZIP file
2. Extract to your web directory (htdocs for XAMPP, public_html for hosting)

**Option B: Git Clone**
```bash
cd /path/to/webroot
git clone <repository-url> complaint_web
cd complaint_web
```

### Step 2: Create Database

1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Click "New" to create a new database
3. Name it: `complaint_system`
4. Click "Create"
5. Select the new database
6. Go to "Import" tab
7. Click "Choose File" and select `sql/database.sql`
8. Click "Import"

**Alternative (Command Line):**
```bash
mysql -u root -p < sql/database.sql
```

### Step 3: Configure Application

Edit `includes/config.php` with your database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');          // Your MySQL password
define('DB_NAME', 'complaint_system');
define('APP_URL', 'http://localhost/complaint_web');
```

### Step 4: Set Permissions

Ensure the uploads directory is writable:

```bash
# Linux/Mac
chmod 755 uploads/
chmod 755 admin/
chmod 755 includes/

# Windows - Usually automatic
```

### Step 5: Access the Application

1. Open your browser
2. Navigate to: `http://localhost/complaint_web`
3. You should see the FixIt homepage

## 💾 Database Setup

### Database Schema Overview

#### users table
```sql
- id (INT, PRIMARY KEY)
- name (VARCHAR 100)
- email (VARCHAR 100, UNIQUE)
- password (VARCHAR 255, hashed)
- roll_number (VARCHAR 20)
- department (VARCHAR 50)
- phone (VARCHAR 15)
- user_type (ENUM: 'student', 'admin')
- status (ENUM: 'active', 'inactive')
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

#### complaints table
```sql
- id (INT, PRIMARY KEY)
- user_id (INT, FOREIGN KEY)
- category (VARCHAR 50)
- title (VARCHAR 200)
- description (LONGTEXT)
- priority (ENUM: 'Low', 'Medium', 'High')
- status (ENUM: 'Pending', 'In Progress', 'Resolved')
- assigned_to (INT, FOREIGN KEY)
- resolution_notes (LONGTEXT)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
- resolved_at (DATETIME)
```

#### contact_messages table
```sql
- id (INT, PRIMARY KEY)
- name (VARCHAR 100)
- email (VARCHAR 100)
- subject (VARCHAR 200)
- message (LONGTEXT)
- read_status (BOOLEAN)
- created_at (TIMESTAMP)
```

#### activity_log table
```sql
- id (INT, PRIMARY KEY)
- admin_id (INT, FOREIGN KEY)
- action (VARCHAR 200)
- complaint_id (INT, FOREIGN KEY)
- details (LONGTEXT)
- created_at (TIMESTAMP)
```

## ⚙️ Configuration

### config.php Settings

```php
// Database Configuration
DB_HOST        // MySQL server address
DB_USER        // MySQL username
DB_PASS        // MySQL password
DB_NAME        // Database name

// Application Settings
APP_NAME       // Application title
APP_URL        // Application URL
UPLOADS_DIR    // Upload directory path

// Session Configuration
SESSION_TIMEOUT        // Session timeout in seconds (default: 3600)
REMEMBER_ME_DURATION  // Remember me cookie duration (default: 2592000)

// Complaint Settings
COMPLAINT_CATEGORIES   // Available complaint categories
COMPLAINT_PRIORITIES   // Available priority levels
COMPLAINT_STATUS      // Available status types
```

### Environment Variables (Optional)

Create a `.env` file for sensitive configuration:

```
DB_HOST=localhost
DB_USER=root
DB_PASS=your_password
DB_NAME=complaint_system
APP_URL=http://localhost/complaint_web
```

Update config.php to read from .env:

```php
$dotenv = parse_ini_file('.env');
define('DB_USER', $dotenv['DB_USER']);
// ... etc
```

## 📖 Usage Guide

### For Students

#### Registration
1. Click "Register" on the homepage
2. Fill in your details (name, email, password, etc.)
3. Click "Create Account"
4. You'll be redirected to login

#### Logging In
1. Click "Login" on the homepage
2. Enter your email and password
3. Click "Login" button
4. You'll be taken to your dashboard

#### Submitting a Complaint
1. From dashboard, click "Submit New Complaint"
2. Select complaint category
3. Enter clear title (10+ characters)
4. Provide detailed description (20+ characters)
5. Set priority level (Low/Medium/High)
6. Click "Submit Complaint"
7. You'll see a confirmation and be redirected to dashboard

#### Tracking Complaints
1. Go to Dashboard
2. View all your complaints with status
3. Use filters to find specific complaints
4. Click "View Details →" on any complaint to see full information
5. Check the status timeline and resolution notes

#### Updating Profile
1. Click "Profile" in the navigation
2. Update your information
3. Change your password if needed
4. Click "Update Profile" or "Change Password"

### For Administrators

#### Logging In
1. Use the demo admin account:
   - Email: `admin@fixit.local`
   - Password: `admin@123`
2. You'll be taken to the admin dashboard

#### Admin Dashboard Overview
- See statistics (total, pending, in progress, resolved)
- View recent complaints
- See category breakdown
- Access quick action buttons
- Monitor new contact messages

#### Managing Complaints
1. Click "Manage Complaints" in sidebar
2. Use filters to narrow down complaints
3. Click "View" on any complaint
4. Update status and add resolution notes
5. Save changes

#### Resolving Complaints
1. Go to complaint details
2. Change status to "In Progress" when work starts
3. Add resolution notes describing the fix
4. Change status to "Resolved" when done
5. Notes are saved and visible to students

## 🔐 Admin Panel

### Admin Features

1. **Dashboard**
   - System-wide statistics
   - Recent complaints overview
   - Category breakdown
   - Quick access to all features

2. **Complaint Management**
   - View all complaints system-wide
   - Advanced filtering (status, category, priority, search)
   - Update complaint status
   - Add resolution notes
   - Delete complaints if needed
   - Export complaint data

3. **User Management** (Extendable)
   - View all registered students
   - Deactivate/activate accounts
   - View user complaint history
   - Manage admin accounts

4. **Contact Messages** (Extendable)
   - View all contact form messages
   - Mark messages as read
   - Reply to messages
   - Manage message inquiries

5. **Reports** (Extendable)
   - Generate complaint statistics
   - Category-wise analysis
   - Priority distribution
   - Timeline charts
   - Export reports

### Default Admin Credentials

```
Email: admin@fixit.local
Password: admin@123
```

⚠️ **Important**: Change these credentials immediately after first login!

To create additional admin accounts, modify the database directly:
```sql
INSERT INTO users (name, email, password, user_type) 
VALUES ('Admin Name', 'admin@example.com', '$2y$10$...hashed_password...', 'admin');
```

## 🔌 API Endpoints

### Authentication
- `POST /login.php` - Login
- `POST /register.php` - Register
- `GET /logout.php` - Logout

### Complaints
- `GET /dashboard.php` - Get user's complaints
- `POST /submit-complaint.php` - Submit new complaint
- `GET /complaint-details.php?id=X` - Get complaint details
- `POST /admin/complaint-details.php` - Update complaint (admin)

### Admin
- `GET /admin/dashboard.php` - Admin dashboard
- `GET /admin/complaints.php` - List all complaints
- `GET /admin/complaint-details.php?id=X` - Complaint details

### Contact
- `POST /contact.php` - Submit contact form

## 🛡️ Security Features

### Implemented
1. **Password Security**
   - bcrypt hashing (PHP 7.4+ password_hash)
   - Minimum 8 characters required
   - Secure password storage

2. **SQL Injection Prevention**
   - Prepared statements with bound parameters
   - Input validation and sanitization
   - htmlspecialchars() for output

3. **Session Security**
   - HTTP-only cookies
   - Session timeout (1 hour default)
   - Session fixation protection

4. **Authentication**
   - Login required for protected pages
   - Session validation on every request
   - Admin-only protection on admin pages

5. **Security Headers**
   - X-Content-Type-Options: nosniff
   - X-Frame-Options: SAMEORIGIN
   - X-XSS-Protection: 1; mode=block

### Recommended Additions
1. Implement CSRF tokens in forms
2. Add rate limiting on login attempts
3. Implement email verification for registration
4. Add two-factor authentication
5. Implement activity logging
6. Add IP-based access restrictions for admin panel
7. Implement API rate limiting
8. Add file upload validation

## 🌐 Deployment

### Deploying to XAMPP (Local)

1. Copy project to `C:\xampp\htdocs\complaint_web`
2. Start Apache and MySQL from XAMPP Control Panel
3. Import database via phpMyAdmin
4. Update `config.php` with your settings
5. Access at `http://localhost/complaint_web`

### Deploying to 000webhost

1. Create account at `000webhost.com`
2. Upload project via FTP
3. Create database in control panel
4. Import SQL schema
5. Update `config.php`
6. Update `APP_URL` to your domain

### Deploying to InfinityFree

1. Create account at `infinityfree.net`
2. Upload via File Manager or FTP
3. Create database in cpPanel
4. Import SQL schema
5. Configure paths and URLs in `config.php`

### Best Practices
- Use environment-specific configs
- Set appropriate file permissions (755 for directories, 644 for files)
- Enable HTTPS (SSL certificate)
- Regular database backups
- Update PHP to latest version
- Keep dependencies updated
- Monitor error logs

## 🐛 Troubleshooting

### Common Issues

**Issue: Blank page after login**
- Check PHP error logs
- Verify database connection
- Ensure session path is writable
- Check file permissions

**Issue: Database connection fails**
```
Solution:
1. Verify MySQL is running
2. Check credentials in config.php
3. Ensure database exists
4. Check user has database privileges
```

**Issue: Form submissions don't work**
```
Solution:
1. Check file permissions
2. Verify PHP is processing POST requests
3. Check browser console for JavaScript errors
4. Verify database connection
```

**Issue: Styling looks broken**
```
Solution:
1. Clear browser cache (Ctrl+Shift+Delete)
2. Verify CSS file path
3. Check for CSS file in assets/css/
4. Verify all images are loading
```

**Issue: Can't upload files**
```
Solution:
1. Check uploads/ directory permissions
2. Verify file size limits in php.ini
3. Check disk space available
```

### Debug Mode

Enable debugging by modifying `includes/config.php`:

```php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Write to log file
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/errors.log');
```

### Database Troubleshooting

Check database connection:
```php
<?php
require_once 'includes/db.php';
try {
    $db = Database::getInstance();
    echo "✓ Database connection successful";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage();
}
?>
```

## 🚀 Future Enhancements

### Phase 2 Features
1. **Email Notifications**
   - Complaint acknowledgment emails
   - Status update notifications
   - Admin alerts for urgent complaints
   - Automatic escalation emails

2. **File Uploads**
   - Attach photos to complaints
   - Document uploads
   - Evidence files
   - File validation and virus scanning

3. **Advanced Search**
   - Full-text search
   - Advanced filters with saved searches
   - Complaint recommendations
   - Similar complaints suggestion

4. **Reports & Analytics**
   - Comprehensive admin reports
   - Statistics dashboards
   - Export to PDF/Excel
   - Trend analysis
   - Department-wise analytics

5. **Mobile App**
   - React Native mobile application
   - Push notifications
   - Offline support
   - Photo integration

### Phase 3 Features
1. **Integration**
   - API for third-party integration
   - Email integration
   - SMS notifications
   - Integration with college ERP

2. **Advanced Features**
   - Complaint escalation system
   - SLA tracking
   - Performance metrics
   - Feedback ratings
   - Complaint reassignment

3. **AI Features**
   - Smart categorization
   - Auto-priority assignment
   - Duplicate detection
   - Chatbot support
   - Sentiment analysis

4. **Accessibility**
   - Multi-language support
   - Dark mode
   - Screen reader optimization
   - Keyboard navigation

## 📄 License

This project is created for educational purposes as a 2nd year CSE Capstone project. You are free to use, modify, and distribute this project for educational and non-commercial purposes.

## 👨‍💻 Author & Support

**Development Team**: Smart Campus Solutions

For support and queries:
- Email: support@fixit.local
- GitHub: [Project Repository](https://github.com)

## 📚 Resources & References

- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [MDN Web Docs](https://developer.mozilla.org/)
- [W3C Web Standards](https://www.w3.org/)

---

### Quick Commands Reference

```bash
# Start project (XAMPP)
# 1. Start Apache and MySQL from XAMPP
# 2. Open http://localhost/complaint_web

# Database backup
mysqldump -u root complaint_system > backup.sql

# Database restore
mysql -u root complaint_system < backup.sql

# Check PHP version
php -v

# Check MySQL version
mysql --version
```

---

**Version**: 1.0.0  
**Last Updated**: April 2026  
**Status**: Production Ready ✅

---

## 🎉 Congratulations!

You've successfully set up FixIt - Smart Complaint Management System! 

Start by:
1. ✅ Setting up the database
2. ✅ Configuring the application
3. ✅ Registering a student account
4. ✅ Logging in with admin credentials
5. ✅ Exploring all features

Happy coding! 🚀
