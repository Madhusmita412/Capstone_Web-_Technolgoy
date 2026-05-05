# FixIt Smart Complaint Management System - Setup & Installation Guide

## 🚀 Quick Start (5 Minutes)

### 1️⃣ Install Database

**Step 1: Open phpMyAdmin**
- Go to: http://localhost/phpmyadmin (if using XAMPP)

**Step 2: Create Database**
- Click "Databases"
- Enter name: `complaint_system`
- Click "Create"

**Step 3: Import Schema**
- Select the new database
- Go to "Import" tab
- Click "Choose File" → select `sql/database.sql`
- Click "Import"

✅ Database ready!

---

### 2️⃣ Configure Application

Edit `includes/config.php`:

```php
define('DB_HOST', 'localhost');      // Your MySQL host
define('DB_USER', 'root');           // Your MySQL username
define('DB_PASS', '');               // Your MySQL password
define('DB_NAME', 'complaint_system');
define('APP_URL', 'http://localhost/complaint_web');
```

✅ Configuration done!

---

### 3️⃣ Start Using

**Open your browser:**
```
http://localhost/complaint_web
```

**Login with demo account:**
```
Email: admin@fixit.local
Password: admin@123
```

✅ All set! 🎉

---

## 📋 Default Test Accounts

### Admin Account
```
Email: admin@fixit.local
Password: admin@123
Type: Administrator
```

### How to Create Student Account
1. Click "Register" on homepage
2. Fill in details
3. Submit registration
4. Login with your credentials

---

## 🛠 File Permissions (Linux/Mac)

```bash
# Make uploads directory writable
chmod 755 uploads/
chmod 755 admin/
chmod 755 includes/

# Make config writable for setup
chmod 644 includes/config.php
```

---

## 📱 Features to Try

### As Student
1. ✅ Register and login
2. ✅ Submit a complaint
3. ✅ View dashboard
4. ✅ Track complaints
5. ✅ Update profile
6. ✅ Change password

### As Admin
1. ✅ View admin dashboard
2. ✅ Manage complaints
3. ✅ Update complaint status
4. ✅ Add resolution notes
5. ✅ View reports
6. ✅ Manage users

---

## 🆘 Troubleshooting

### MySQL Error
```
Solution:
1. Ensure MySQL is running
2. Check database credentials in config.php
3. Verify database was imported successfully
```

### Blank Page
```
Solution:
1. Check browser console (F12)
2. Enable error display in config.php
3. Check htdocs/error.log
4. Verify file permissions
```

### Can't Login
```
Solution:
1. Verify database has users table
2. Check email and password match
3. Clear browser cookies
4. Try incognito/private browsing
```

---

## 📚 Key Files

| File | Purpose |
|------|---------|
| `includes/config.php` | Configuration settings |
| `includes/db.php` | Database connection |
| `includes/auth.php` | Authentication logic |
| `includes/functions.php` | Business logic |
| `assets/css/style.css` | All styling |
| `assets/js/validation.js` | Frontend validation |
| `sql/database.sql` | Database schema |

---

## 🔐 Security Notes

⚠️ **Important for Production:**

1. Change admin password immediately
2. Update `APP_URL` to your domain
3. Enable HTTPS/SSL
4. Set `error_reporting(0)` before deployment
5. Move sensitive files outside web root
6. Use environment variables for secrets

---

## 📞 Contact & Support

- **Email**: support@fixit.local
- **Documentation**: See README.md
- **Issues**: Check Troubleshooting section

---

## ✨ Project Structure

```
complaint_web/
├── 📄 .htaccess
├── 📄 index.php
├── 📄 login.php
├── 📄 register.php
├── 📄 dashboard.php
│
├── 📁 admin/
│   ├── dashboard.php
│   └── complaints.php
│
├── 📁 includes/
│   ├── config.php          ← Edit this!
│   ├── db.php
│   ├── auth.php
│   └── functions.php
│
├── 📁 assets/
│   ├── css/style.css
│   ├── js/validation.js
│   └── images/
│
├── 📁 sql/
│   └── database.sql        ← Import this!
│
└── 📄 README.md
```

---

## 🎯 Next Steps

1. ✅ Follow the "Quick Start" section above
2. ✅ Read the main README.md for complete documentation
3. ✅ Explore the admin panel
4. ✅ Create test complaints
5. ✅ Customize to your needs

---

**Good luck with your FixIt project! 🚀**

Made with ❤️ for campus improvement
