# 🌐 FixIt - API & Vercel Quick Reference

## ⚡ Quick Start

### 1. Start Locally

```bash
# Option A: PHP built-in server
cd complaint_web
php -S localhost:8000

# Option B: Docker
docker-compose up -d
# Then access: http://localhost:8000
# phpMyAdmin: http://localhost:8080
```

### 2. Test API

```bash
# Register
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John","email":"john@example.com","password":"pass123","roll_number":"CSE001","department":"CSE","phone":"9999999999"}'

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"pass123"}'

# Get complaints
curl http://localhost:8000/api/complaints

# Create complaint
curl -X POST http://localhost:8000/api/complaints \
  -H "Content-Type: application/json" \
  -d '{"category":"WiFi Problems","title":"No WiFi","description":"Internet down","priority":"High"}'
```

---

## 🚀 Deploy to Vercel

### Prerequisites
- GitHub account
- Vercel account (free)
- External database (PlanetScale recommended)

### Steps

1. **Push to GitHub**
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git remote add origin https://github.com/your-username/complaint_web.git
   git push -u origin main
   ```

2. **Create PlanetScale Database**
   - Go to [planetscale.com](https://planetscale.com)
   - Create account
   - Create database "complaint_system"
   - Get credentials (host, user, password)
   - Import schema from `sql/database.sql`

3. **Deploy on Vercel**
   - Go to [vercel.com/new](https://vercel.com/new)
   - Import GitHub repo
   - Add environment variables:
     ```
     DB_HOST=your-ps-host.psdb.cloud
     DB_USER=your-user
     DB_PASS=your-pass
     DB_NAME=complaint_system
     APP_URL=https://your-app.vercel.app
     ```
   - Click "Deploy"

4. **Test Deployment**
   ```bash
   curl https://your-app.vercel.app/api/stats
   ```

---

## 📱 API Endpoints Summary

| Endpoint | Method | Auth | Purpose |
|----------|--------|------|---------|
| `/api/auth/register` | POST | ❌ | Register user |
| `/api/auth/login` | POST | ❌ | Login user |
| `/api/auth/me` | GET | ✅ | Get current user |
| `/api/complaints` | GET | ✅ | List complaints |
| `/api/complaints` | POST | ✅ | Create complaint |
| `/api/complaints?id=X` | GET | ✅ | Get complaint |
| `/api/complaints?id=X` | PUT | ✅ Admin | Update complaint |
| `/api/complaints?id=X` | DELETE | ✅ Admin | Delete complaint |
| `/api/contact` | POST | ❌ | Submit message |
| `/api/contact` | GET | ✅ Admin | Get messages |
| `/api/stats` | GET | ✅ | Get statistics |

---

## 🎯 Alternative Deployment Platforms

### Railway.app (⭐ Recommended)
- Best for PHP projects
- Built-in MySQL
- Free tier
- Auto-deploy from GitHub

**Deploy:**
1. Go to [railway.app](https://railway.app)
2. Create new project
3. Import GitHub repo
4. Add MySQL plugin
5. Deploy

### Render.com
- Full PHP support
- Free tier available
- Easy setup

### Docker Hub
- Build image: `docker build -t fixit .`
- Push: `docker push your-username/fixit`
- Deploy anywhere with Docker

---

## 🔧 Environment Variables

**Local (.env)**
```
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=complaint_system
APP_URL=http://localhost:8000
```

**Vercel/Production**
```
DB_HOST=your-db-host.com
DB_USER=production_user
DB_PASS=strong_password
DB_NAME=complaint_system
APP_URL=https://your-domain.com
```

---

## 🐛 Troubleshooting

### "Database connection failed"
- ✅ Check credentials in environment variables
- ✅ Verify database is running
- ✅ Check firewall rules
- ✅ Test connection: `mysql -h $DB_HOST -u $DB_USER -p`

### "404 Not Found"
- ✅ Verify `vercel.json` routing rules
- ✅ Check file paths
- ✅ Ensure `.htaccess` is configured

### "500 Internal Server Error"
- ✅ Check Vercel logs: `vercel logs`
- ✅ Verify PHP errors: `error_log`
- ✅ Test locally first

### "CORS errors"
- ✅ Headers already set in `api/*.php`
- ✅ Verify origin in request
- ✅ Check browser console for details

---

## 📚 Documentation Files

- **[README.md](./README.md)** - Main documentation
- **[API_DOCUMENTATION.md](./API_DOCUMENTATION.md)** - Complete API reference
- **[VERCEL_DEPLOYMENT.md](./VERCEL_DEPLOYMENT.md)** - Detailed deployment guide
- **[SETUP.md](./SETUP.md)** - Quick setup guide
- **[PROJECT_STRUCTURE.md](./PROJECT_STRUCTURE.md)** - Architecture overview

---

## 🎓 Frontend Integration Examples

### React/Vue/Angular
```javascript
const API = 'https://your-app.vercel.app/api';

// Register
async function register(user) {
  const res = await fetch(`${API}/auth/register`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(user)
  });
  return res.json();
}

// Get complaints
async function getComplaints() {
  const res = await fetch(`${API}/complaints`);
  return res.json();
}

// Create complaint
async function createComplaint(complaint) {
  const res = await fetch(`${API}/complaints`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(complaint)
  });
  return res.json();
}
```

### Mobile App (React Native/Flutter)
```dart
final apiUrl = 'https://your-app.vercel.app/api';

// Login
Future login(String email, String password) async {
  final response = await http.post(
    Uri.parse('$apiUrl/auth/login'),
    headers: {'Content-Type': 'application/json'},
    body: jsonEncode({'email': email, 'password': password}),
  );
  return jsonDecode(response.body);
}

// Get complaints
Future getComplaints() async {
  final response = await http.get(Uri.parse('$apiUrl/complaints'));
  return jsonDecode(response.body);
}
```

---

## 💾 Database Backup

```bash
# Local
mysqldump -u root complaint_system > backup.sql

# Vercel/Production
mysqldump -h your-db-host -u your-user -p complaint_system > backup.sql

# Restore
mysql -h your-db-host -u your-user -p complaint_system < backup.sql
```

---

## ✅ Deployment Checklist

- [ ] Code pushed to GitHub
- [ ] Database created and schema imported
- [ ] Environment variables configured
- [ ] Vercel project created
- [ ] Environment variables added to Vercel
- [ ] Deployment successful
- [ ] API endpoints responding
- [ ] Login/register working
- [ ] Complaints CRUD working
- [ ] Admin functions working
- [ ] SSL/HTTPS enabled
- [ ] Monitoring enabled
- [ ] Backups scheduled

---

## 🚀 Next Steps

1. **Deploy to Vercel** using [VERCEL_DEPLOYMENT.md](./VERCEL_DEPLOYMENT.md)
2. **Test API** using [API_DOCUMENTATION.md](./API_DOCUMENTATION.md)
3. **Build Frontend** to consume API
4. **Set up monitoring** for production
5. **Enable backups** for database

---

## 📞 Need Help?

- Check [API_DOCUMENTATION.md](./API_DOCUMENTATION.md) for endpoints
- See [TROUBLESHOOTING section](#-troubleshooting) above
- Review [DEPLOYMENT.md](./DEPLOYMENT.md) for other platforms
- Check logs: `vercel logs`

---

**Ready to deploy?** 🚀 Start with Railway.app or Vercel!

---

**Version**: 1.0.0  
**Last Updated**: May 5, 2026
