# 🌐 FixIt - Deployment Guide

## Deployment Platforms Overview

| Platform | Difficulty | Cost | Best For | URL |
|----------|-----------|------|----------|-----|
| XAMPP (Local) | ⭐ Easy | Free | Development & Testing | http://localhost |
| 000webhost | ⭐⭐ Easy | Free | Learning | 000webhost.com |
| InfinityFree | ⭐⭐ Easy | Free | Production | infinityfree.com |
| Bluehost | ⭐⭐⭐ Medium | $2.95/mo | Production | bluehost.com |
| SiteGround | ⭐⭐⭐ Medium | $2.99/mo | Production | siteground.com |
| DigitalOcean | ⭐⭐⭐⭐ Hard | $5/mo | Advanced | digitalocean.com |

---

## 1. 📱 Local Deployment (XAMPP)

### Prerequisites
- XAMPP installed (https://www.apachefriends.org/)
- PHP 7.4+ and MySQL 5.7+ included

### Step-by-Step

**1. Copy Project**
```bash
# Copy to XAMPP htdocs directory
C:\xampp\htdocs\complaint_web
```

**2. Start Services**
- Open XAMPP Control Panel
- Click "Start" next to Apache
- Click "Start" next to MySQL

**3. Create Database**
```
1. Open http://localhost/phpmyadmin
2. Click "Databases"
3. Enter: complaint_system
4. Click "Create"
5. Select database
6. Go to "Import" tab
7. Choose file: sql/database.sql
8. Click "Import"
```

**4. Configure**
- Edit: `includes/config.php`
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'complaint_system');
define('APP_URL', 'http://localhost/complaint_web');
```

**5. Test**
```
http://localhost/complaint_web
```

✅ **Local deployment complete!**

---

## 2. ☁️ Free Hosting Deployment (000webhost)

### Prerequisites
- 000webhost account (https://www.000webhost.com/)
- FTP client (FileZilla recommended)

### Step-by-Step

**1. Create Account**
- Sign up at 000webhost.com
- Choose a domain
- Confirm email

**2. Get FTP Credentials**
- Login to 000webhost dashboard
- Go to "File Manager" or "FTP"
- Note credentials:
  - FTP Host: `ftpX.000webhost.com`
  - Username: Your account email
  - Password: Your account password
  - Port: `21`

**3. Upload Files**
```
Option A: Web File Manager
1. Login to 000webhost
2. Open "File Manager"
3. Upload all files and folders
4. Verify structure

Option B: FTP (Recommended)
1. Open FileZilla
2. File → Site Manager
3. Enter FTP credentials
4. Connect
5. Drag and drop complaint_web folder
6. Wait for upload to complete
```

**4. Create Database**
```
1. In 000webhost dashboard
2. Go to "Databases"
3. Create new MySQL database
4. Name: complaint_system
5. Get credentials (host, user, password)
6. Download phpMyAdmin or use web interface
7. Import sql/database.sql
```

**5. Configure**
- Edit: `includes/config.php`
```php
define('DB_HOST', '000webhost_db_host');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_pass');
define('DB_NAME', 'your_db_name');
define('APP_URL', 'http://your-domain.000webhostapp.com/complaint_web');
```

**6. Upload Updated config.php**
- Overwrite via FTP or File Manager

**7. Test**
```
http://your-domain.000webhostapp.com/complaint_web
```

✅ **000webhost deployment complete!**

---

## 3. ☁️ InfinityFree Deployment

### Prerequisites
- InfinityFree account (https://www.infinityfree.com/)
- FTP client

### Step-by-Step

**1. Create Account**
- Sign up at infinityfree.com
- Choose domain
- Verify email

**2. Get Access Details**
- Login to InfinityFree control panel
- Go to "Account"
- Note:
  - cPanel URL
  - cPanel username
  - cPanel password
  - FTP details

**3. Upload Files (via FTP)**
```
1. Open FileZilla
2. Host: ftp.infinityfree.com
3. Username: infinityfree_username
4. Password: infinityfree_password
5. Port: 21
6. Upload to: htdocs/ folder
```

**4. Create Database**
```
1. Open cPanel
2. Search for "MySQL Databases"
3. Create new database
4. Name: prefix_complaint_system
5. Get connection details
```

**5. Import SQL**
```
1. In cPanel, find "phpMyAdmin"
2. Select database
3. Go to Import tab
4. Upload sql/database.sql
5. Click Import
```

**6. Configure**
- Edit: `includes/config.php`
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'prefix_user');
define('DB_PASS', 'your_password');
define('DB_NAME', 'prefix_complaint_system');
define('APP_URL', 'http://yourdomain.infinityfree.com/complaint_web');
```

**7. Test**
```
http://yourdomain.infinityfree.com/complaint_web
```

✅ **InfinityFree deployment complete!**

---

## 4. 🚀 Premium Hosting (Bluehost/SiteGround)

### Prerequisites
- Bluehost or SiteGround account
- Domain configured
- cPanel/hosting control panel

### Step-by-Step

**1. Access cPanel**
- Login to hosting control panel
- Find "cPanel"

**2. Create Database**
```
1. Find "MySQL Databases"
2. Create new database
3. Create new user
4. Add user to database with all privileges
5. Note credentials
```

**3. Upload Files**
```
Option A: File Manager (cPanel)
1. Open File Manager
2. Navigate to public_html
3. Upload complaint_web folder

Option B: FTP
1. Get FTP credentials from cPanel
2. Use FileZilla
3. Upload to public_html
```

**4. Import SQL**
```
1. Open phpMyAdmin
2. Select your database
3. Go to Import
4. Upload sql/database.sql
5. Click Import
```

**5. Configure**
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'cpanel_username_dbuser');
define('DB_PASS', 'database_password');
define('DB_NAME', 'cpanel_username_complaint_system');
define('APP_URL', 'https://yourdomain.com/complaint_web');
```

**6. Enable HTTPS**
```
1. In cPanel, find "AutoSSL"
2. Install SSL certificate (usually free)
3. Update APP_URL to use https://
```

**7. Test**
```
https://yourdomain.com/complaint_web
```

✅ **Premium hosting deployment complete!**

---

## 5. 🐳 Docker Deployment

### Prerequisites
- Docker installed
- Docker Compose installed

### Step-by-Step

**1. Create docker-compose.yml**
```yaml
version: '3'
services:
  web:
    image: php:7.4-apache
    container_name: fixit_web
    ports:
      - "80:80"
    volumes:
      - ./:/var/www/html
    environment:
      APACHE_RUN_USER: www-data
      APACHE_RUN_GROUP: www-data
    depends_on:
      - db
    networks:
      - fixit_network

  db:
    image: mysql:5.7
    container_name: fixit_db
    ports:
      - "3306:3306"
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: complaint_system
      MYSQL_USER: fixit_user
      MYSQL_PASSWORD: fixit_pass
    volumes:
      - ./sql:/docker-entrypoint-initdb.d
      - mysql_data:/var/lib/mysql
    networks:
      - fixit_network

networks:
  fixit_network:
    driver: bridge

volumes:
  mysql_data:
```

**2. Start Services**
```bash
docker-compose up -d
```

**3. Configure**
```php
define('DB_HOST', 'db');
define('DB_USER', 'fixit_user');
define('DB_PASS', 'fixit_pass');
define('DB_NAME', 'complaint_system');
define('APP_URL', 'http://localhost/complaint_web');
```

**4. Access**
```
http://localhost/complaint_web
```

✅ **Docker deployment complete!**

---

## 🔐 Production Checklist

Before going live, ensure:

- [ ] Change all default passwords
- [ ] Update APP_URL to production domain
- [ ] Enable HTTPS/SSL certificate
- [ ] Set `error_reporting(0)` in config.php
- [ ] Move uploads directory outside web root
- [ ] Set proper file permissions (644 files, 755 directories)
- [ ] Backup database regularly
- [ ] Monitor error logs
- [ ] Implement rate limiting
- [ ] Enable firewall rules
- [ ] Use environment variables for secrets
- [ ] Update PHP to latest version
- [ ] Configure automated backups
- [ ] Set up email notifications
- [ ] Test all functionality end-to-end

---

## 📝 Environment Variables (.env)

Create `.env` file for production:

```
APP_ENV=production
APP_DEBUG=false

DB_HOST=localhost
DB_USER=username
DB_PASS=strong_password
DB_NAME=complaint_system

ADMIN_EMAIL=admin@yourdomain.com
ADMIN_PASSWORD=hash_generated_password

APP_URL=https://yourdomain.com/complaint_web
SESSION_TIMEOUT=3600
```

---

## 🆘 Deployment Issues

### Issue: 500 Internal Server Error
```
Solution:
1. Check error logs (error_log or cPanel error logs)
2. Verify PHP version compatibility
3. Check file permissions
4. Verify database connection
5. Enable error reporting temporarily
```

### Issue: Database Connection Failed
```
Solution:
1. Verify database credentials
2. Check MySQL server status
3. Verify database exists
4. Check user has proper permissions
5. Test connection from command line
```

### Issue: File Upload Not Working
```
Solution:
1. Check uploads/ directory permissions (755)
2. Verify disk space available
3. Check PHP upload settings
4. Clear browser cache
5. Try different file
```

### Issue: HTTPS Not Working
```
Solution:
1. Ensure SSL certificate is installed
2. Update APP_URL to https://
3. Force HTTPS in .htaccess
4. Check certificate expiration
5. Clear browser cache
```

---

## 📊 Performance Optimization

### Database Optimization
```sql
-- Add indexes for faster queries
ALTER TABLE complaints ADD INDEX idx_user_id (user_id);
ALTER TABLE complaints ADD INDEX idx_status (status);
ALTER TABLE complaints ADD INDEX idx_created_at (created_at);
```

### Apache Optimization
```apache
# Enable compression
mod_deflate

# Enable caching
mod_expires
mod_cache

# Optimize PHP
php_value memory_limit 256M
php_value max_execution_time 300
```

### CSS & JS Minification
```bash
# Minify CSS
npx csso-cli assets/css/style.css -o assets/css/style.min.css

# Minify JS
npx uglify-js assets/js/validation.js -o assets/js/validation.min.js
```

---

## 🔄 Backup & Restore

### Backup Database
```bash
mysqldump -u root -p complaint_system > backup_$(date +%Y%m%d).sql
```

### Restore Database
```bash
mysql -u root -p complaint_system < backup_20240101.sql
```

### Backup Files
```bash
tar -czf complaint_web_backup_$(date +%Y%m%d).tar.gz complaint_web/
```

---

## 📱 Monitoring & Logging

### Enable Logging
```php
// In includes/config.php
define('LOG_FILE', __DIR__ . '/../logs/app.log');
define('LOG_ERRORS', true);

ini_set('log_errors', 1);
ini_set('error_log', LOG_FILE);
```

### Monitor Errors
```bash
# Watch error log in real-time
tail -f logs/app.log
```

---

## 🎯 Go Live Checklist

- [ ] Database fully set up and tested
- [ ] All files uploaded
- [ ] Configuration updated for production
- [ ] SSL certificate installed
- [ ] DNS configured
- [ ] Email notifications working
- [ ] Backups scheduled
- [ ] Monitoring enabled
- [ ] Performance optimized
- [ ] Security headers configured
- [ ] Admin panel tested
- [ ] All pages accessible
- [ ] Mobile responsiveness verified

---

## 📞 Support

For deployment issues:
- Check logs first
- Verify credentials
- Test database connection
- Review server requirements
- Contact hosting support

---

**Successfully deployed! 🎉**
