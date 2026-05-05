# 🚀 FixIt API Documentation

> RESTful API for FixIt Complaint Management System

## 📋 Base URL

**Local**: `http://localhost:8000/api`  
**Vercel**: `https://your-app.vercel.app/api`

---

## 🔐 Authentication

All requests require `Authorization` header (except registration and contact form).

```bash
# Login first to get session
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password123"
  }'
```

---

## 📚 API Endpoints

### Authentication Endpoints

#### 1️⃣ Register User
```
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "roll_number": "CSE2021001",
  "department": "Computer Science",
  "phone": "9876543210"
}

Response: 201 Created
{
  "message": "User registered successfully"
}
```

#### 2️⃣ Login User
```
POST /api/auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password123"
}

Response: 200 OK
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "user_type": "student"
  }
}
```

#### 3️⃣ Get Current User
```
GET /api/auth/me

Response: 200 OK
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "user_type": "student",
    "created_at": "2026-05-05 10:00:00"
  }
}
```

#### 4️⃣ Change Password
```
POST /api/auth/change-password
Content-Type: application/json

{
  "old_password": "oldpassword123",
  "new_password": "newpassword123",
  "confirm_password": "newpassword123"
}

Response: 200 OK
{
  "message": "Password changed successfully"
}
```

#### 5️⃣ Logout
```
POST /api/auth/logout

Response: 200 OK
{
  "message": "Logged out successfully"
}
```

---

### Complaints Endpoints

#### 6️⃣ Get All Complaints
```
GET /api/complaints

Response: 200 OK
{
  "complaints": [
    {
      "id": 1,
      "user_id": 1,
      "category": "WiFi Problems",
      "title": "WiFi not working in hostel",
      "description": "Internet connectivity is very slow",
      "priority": "High",
      "status": "Pending",
      "created_at": "2026-05-05 10:00:00"
    }
  ]
}
```

#### 7️⃣ Get Single Complaint
```
GET /api/complaints?id=1

Response: 200 OK
{
  "complaint": {
    "id": 1,
    "user_id": 1,
    "category": "WiFi Problems",
    "title": "WiFi not working in hostel",
    "description": "Internet connectivity is very slow",
    "priority": "High",
    "status": "Pending",
    "resolution_notes": null,
    "created_at": "2026-05-05 10:00:00"
  }
}
```

#### 8️⃣ Create Complaint
```
POST /api/complaints
Content-Type: application/json

{
  "category": "WiFi Problems",
  "title": "WiFi not working",
  "description": "Internet is very slow in the hostel",
  "priority": "High"
}

Response: 201 Created
{
  "message": "Complaint created successfully",
  "complaint_id": 42
}
```

#### 9️⃣ Update Complaint (Admin Only)
```
PUT /api/complaints?id=1
Content-Type: application/json

{
  "status": "In Progress",
  "resolution_notes": "We are working on fixing the WiFi router"
}

Response: 200 OK
{
  "message": "Complaint updated successfully"
}
```

#### 🔟 Delete Complaint (Admin Only)
```
DELETE /api/complaints?id=1

Response: 200 OK
{
  "message": "Complaint deleted successfully"
}
```

---

### Contact Endpoints

#### 1️1️⃣ Submit Contact Message
```
POST /api/contact
Content-Type: application/json

{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "subject": "Feature Request",
  "message": "Can you add email notifications?"
}

Response: 201 Created
{
  "message": "Message sent successfully"
}
```

#### 1️2️⃣ Get All Messages (Admin Only)
```
GET /api/contact

Response: 200 OK
{
  "messages": [
    {
      "id": 1,
      "name": "Jane Doe",
      "email": "jane@example.com",
      "subject": "Feature Request",
      "message": "Can you add email notifications?",
      "read_status": false,
      "created_at": "2026-05-05 10:00:00"
    }
  ]
}
```

---

### Statistics Endpoints

#### 1️3️⃣ Get Dashboard Statistics
```
GET /api/stats

Response: 200 OK (Student)
{
  "total_complaints": 5,
  "pending": 2,
  "in_progress": 1,
  "resolved": 2,
  "user_type": "student"
}

Response: 200 OK (Admin)
{
  "total_complaints": 45,
  "pending": 15,
  "in_progress": 20,
  "resolved": 10,
  "total_users": 120,
  "unread_messages": 8,
  "user_type": "admin"
}
```

---

## 🔴 Error Responses

### 400 Bad Request
```json
{
  "error": "Missing required fields"
}
```

### 401 Unauthorized
```json
{
  "error": "Unauthorized"
}
```

### 403 Forbidden
```json
{
  "error": "Access denied"
}
```

### 404 Not Found
```json
{
  "error": "Complaint not found"
}
```

### 409 Conflict
```json
{
  "error": "Email already exists"
}
```

### 500 Internal Server Error
```json
{
  "error": "Internal server error message"
}
```

---

## 📝 Request Examples

### cURL

```bash
# Register
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "roll_number": "CSE2021001",
    "department": "CSE",
    "phone": "9876543210"
  }'

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'

# Get complaints
curl -X GET http://localhost:8000/api/complaints \
  -H "Content-Type: application/json"

# Create complaint
curl -X POST http://localhost:8000/api/complaints \
  -H "Content-Type: application/json" \
  -d '{
    "category": "WiFi Problems",
    "title": "WiFi down",
    "description": "WiFi not working",
    "priority": "High"
  }'
```

### JavaScript/Fetch

```javascript
// Register
fetch('http://localhost:8000/api/auth/register', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    name: 'John Doe',
    email: 'john@example.com',
    password: 'password123',
    roll_number: 'CSE2021001',
    department: 'CSE',
    phone: '9876543210'
  })
})
.then(r => r.json())
.then(data => console.log(data));

// Get complaints
fetch('http://localhost:8000/api/complaints')
  .then(r => r.json())
  .then(data => console.log(data.complaints));

// Create complaint
fetch('http://localhost:8000/api/complaints', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    category: 'WiFi Problems',
    title: 'WiFi not working',
    description: 'Internet is down',
    priority: 'High'
  })
})
.then(r => r.json())
.then(data => console.log(data));
```

### Python/Requests

```python
import requests

# Base URL
BASE_URL = 'http://localhost:8000/api'

# Register
response = requests.post(f'{BASE_URL}/auth/register', json={
    'name': 'John Doe',
    'email': 'john@example.com',
    'password': 'password123',
    'roll_number': 'CSE2021001',
    'department': 'CSE',
    'phone': '9876543210'
})
print(response.json())

# Login
response = requests.post(f'{BASE_URL}/auth/login', json={
    'email': 'john@example.com',
    'password': 'password123'
})
print(response.json())

# Get complaints
response = requests.get(f'{BASE_URL}/complaints')
print(response.json()['complaints'])
```

---

## 🔒 Security Notes

- ✅ CORS enabled for all origins
- ✅ JSON response format
- ✅ Session-based authentication
- ✅ Password hashing with bcrypt
- ✅ SQL injection prevention
- ✅ Input validation

---

## 🚀 Deployment

See [VERCEL_DEPLOYMENT.md](./VERCEL_DEPLOYMENT.md) for deployment instructions.

---

**Version**: 1.0.0  
**Last Updated**: May 5, 2026
