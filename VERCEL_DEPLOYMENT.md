# 🚀 FixIt on Vercel - Deployment Guide

> Deploy FixIt to Vercel serverless platform

## ⚠️ Important Note

Vercel's PHP support is limited. For production, consider these alternatives:
- **Railway.app** - Full PHP support
- **Heroku** - Full PHP support
- **PlanetScale** - For database
- **Render.com** - Full PHP support

However, you can still deploy on Vercel using community runtimes.

---

## 📋 Prerequisites

- [Vercel Account](https://vercel.com) (free)
- [Git](https://git-scm.com/)
- Project pushed to GitHub/GitLab
- Database server (external like PlanetScale or AWS RDS)

---

## 🔧 Setup Steps

### Step 1: Prepare Your Project

```bash
# Navigate to project
cd complaint_web

# Initialize git (if not already)
git init

# Add all files
git add .

# Commit
git commit -m "Initial commit"

# Add remote (replace with your repo)
git remote add origin https://github.com/your-username/complaint_web.git

# Push to GitHub
git push -u origin main
```

### Step 2: Set Up External Database

**Option A: Using PlanetScale (MySQL Compatible)**

1. Create account at [planetscale.com](https://planetscale.com)
2. Create new database "complaint_system"
3. Get connection credentials
4. Import schema: `sql/database.sql`
5. Note the credentials (host, user, password)

**Option B: Using AWS RDS**

1. Create RDS MySQL instance
2. Get endpoint and credentials
3. Import schema
4. Enable public access

**Option C: Using DigitalOcean Managed Database**

1. Create managed database cluster
2. Create database "complaint_system"
3. Get connection details
4. Import schema

### Step 3: Deploy to Vercel

**Option A: Vercel CLI**

```bash
# Install Vercel CLI
npm i -g vercel

# Login to Vercel
vercel login

# Deploy
vercel --prod
```

**Option B: Vercel Dashboard**

1. Go to [vercel.com/new](https://vercel.com/new)
2. Import GitHub repository
3. Click "Import"
4. Continue to deployment settings
5. Add environment variables (see Step 4)
6. Click "Deploy"

### Step 4: Configure Environment Variables

In Vercel Dashboard:

1. Go to Settings → Environment Variables
2. Add the following:

```
DB_HOST=your-db-host.com
DB_USER=your-db-user
DB_PASS=your-db-password
DB_NAME=complaint_system
APP_URL=https://your-app.vercel.app
```

### Step 5: Update Configuration

Edit `includes/config.php` to use environment variables:

```php
<?php
// Database Configuration from Environment
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'complaint_system');

define('APP_URL', getenv('APP_URL') ?: 'http://localhost');
// ... rest of config
?>
```

---

## 🎯 Testing Locally Before Deployment

### With PHP Built-in Server

```bash
# Set environment variables
$env:DB_HOST = "your-db-host"
$env:DB_USER = "your-db-user"
$env:DB_PASS = "your-db-pass"
$env:DB_NAME = "complaint_system"

# Start PHP server
php -S localhost:8000

# Test API
curl http://localhost:8000/api/auth/login
```

### Using Docker

```bash
# Build Docker image
docker build -t fixit .

# Run container
docker run -p 8000:80 \
  -e DB_HOST=your-db-host \
  -e DB_USER=your-db-user \
  -e DB_PASS=your-db-pass \
  -e DB_NAME=complaint_system \
  fixit

# Access at http://localhost:8000
```

---

## 📡 API Endpoints on Vercel

After deployment, access your API at:

```
https://your-app.vercel.app/api/auth/login
https://your-app.vercel.app/api/complaints
https://your-app.vercel.app/api/contact
https://your-app.vercel.app/api/stats
```

---

## 🔍 Troubleshooting

### Issue: 500 Internal Server Error

```bash
# Check Vercel logs
vercel logs

# Check environment variables are set
vercel env list

# Verify database connection
mysql -h $DB_HOST -u $DB_USER -p$DB_PASS -D $DB_NAME
```

### Issue: Database Connection Failed

```bash
# Verify credentials
echo "Host: $DB_HOST"
echo "User: $DB_USER"
echo "Database: $DB_NAME"

# Test connection from CLI
mysql -h your-db-host -u your-db-user -p

# Check security groups/firewall
# Allow Vercel IPs: 76.75.0.0/16
```

### Issue: CORS Errors

The API headers are already set. If you get CORS errors:

```php
// vercel.json already has this, but verify:
{
  "headers": [
    {
      "key": "Access-Control-Allow-Origin",
      "value": "*"
    }
  ]
}
```

### Issue: Files Not Found

```bash
# Verify files are pushed to GitHub
git status

# Add missing files
git add .
git commit -m "Add missing files"
git push

# Redeploy
vercel --prod
```

---

## 🚀 Alternative Platforms (Easier)

### Railway.app (Recommended for PHP)

1. Go to [railway.app](https://railway.app)
2. Create new project
3. Connect GitHub repository
4. Add MySQL plugin
5. Set environment variables
6. Deploy (auto-deploys on push)

**Advantages:**
- ✅ Full PHP support
- ✅ Built-in MySQL
- ✅ Auto-deploy on GitHub push
- ✅ Free tier available
- ✅ Simple setup

### Render.com

1. Go to [render.com](https://render.com)
2. Create new Web Service
3. Connect GitHub
4. Select PHP runtime
5. Add environment variables
6. Deploy

**Advantages:**
- ✅ Full PHP support
- ✅ Easy deployment
- ✅ Built-in database options
- ✅ Free tier

### Heroku (Legacy)

Heroku retired free tier, but still supports PHP with paid plans.

---

## 📊 Deployment Comparison

| Platform | PHP Support | MySQL | Ease | Cost |
|----------|------------|-------|------|------|
| **Vercel** | Limited | External | Medium | Free |
| **Railway** | ✅ Full | ✅ Built-in | Easy | Free |
| **Render** | ✅ Full | ✅ Add-on | Easy | Free |
| **Heroku** | ✅ Full | ✅ Add-on | Easy | $7/mo |
| **AWS** | ✅ Full | ✅ RDS | Hard | Variable |

**Best Recommendation: Railway.app** ⭐

---

## 🎯 Deployment with Railway (Easiest)

### Step 1: Create Railway Project

```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Create project
railway init
```

### Step 2: Add Services

```bash
# Add MySQL service
railway add

# Select MySQL
# Select PostgreSQL (if you prefer)
```

### Step 3: Deploy

```bash
# Push to GitHub first
git push

# From Railway dashboard:
# 1. Connect GitHub
# 2. Select repository
# 3. Select branch
# 4. Click Deploy
```

### Step 4: Set Environment Variables

In Railway Dashboard:

1. Go to Variables
2. Add:
   - `DB_HOST` - MySQL host
   - `DB_USER` - MySQL user
   - `DB_PASS` - MySQL password
   - `DB_NAME` - complaint_system
   - `APP_URL` - Your Railway URL

---

## ✅ Post-Deployment Checklist

- [ ] Database imported successfully
- [ ] Environment variables set
- [ ] Test login endpoint: `GET /api/auth/me`
- [ ] Test complaint endpoint: `GET /api/complaints`
- [ ] Test statistics endpoint: `GET /api/stats`
- [ ] CORS working properly
- [ ] SSL certificate active
- [ ] Backups scheduled
- [ ] Monitoring enabled
- [ ] Documentation updated

---

## 🔐 Security Checklist

- [ ] Change default admin password
- [ ] Enable HTTPS (auto with most platforms)
- [ ] Set strong database password
- [ ] Configure firewall rules
- [ ] Enable logging
- [ ] Regular backups enabled
- [ ] Environment variables not in code
- [ ] `.env` file in `.gitignore`

---

## 📈 Performance Tips

1. **Enable Caching**
   ```php
   header('Cache-Control: public, max-age=3600');
   ```

2. **Optimize Database Queries**
   - Use indexes on frequently queried columns
   - Implement pagination for large datasets

3. **Use CDN**
   - Serve static assets from CDN
   - Configure in Vercel/Railway settings

4. **Monitor Performance**
   - Use platform's performance dashboard
   - Set up alerts for errors

---

## 🆘 Support

### Documentation
- [Vercel PHP Support](https://vercel.com/docs)
- [Railway Documentation](https://docs.railway.app/)
- [Render Documentation](https://render.com/docs)

### API Examples
See [API_DOCUMENTATION.md](./API_DOCUMENTATION.md)

### Community
- Stack Overflow: `php vercel deployment`
- GitHub Issues: Ask in your repo

---

## 🎓 Learning Resources

- [PHP Deployment Guide](https://www.php.net/manual/en/)
- [REST API Best Practices](https://restfulapi.net/)
- [MySQL Optimization](https://dev.mysql.com/doc/)

---

**Version**: 1.0.0  
**Last Updated**: May 5, 2026  
**Recommended**: Use Railway.app for easiest deployment ⭐
