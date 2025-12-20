# 📘 API Documentation - Tapal Kuda Admin Panel

Base URL: `http://localhost:8000/api`

---

## 🔐 Authentication

### 1. Login
Mendapatkan API token untuk akses endpoint yang dilindungi.

**Endpoint:** `POST /api/login`

**Request Body:**
```json
{
  "username": "admin",
  "password": "admin123"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "username": "admin",
      "nama": "admin tapal kuda",
      "email": "tapalkuda@gmail.com",
      "role": "admin"
    },
    "token": "1|abcdef123456..."
  }
}
```

**Error Response (422):**
```json
{
  "message": "The provided credentials are incorrect.",
  "errors": {
    "username": ["The provided credentials are incorrect."]
  }
}
```

---

### 2. Logout
Menghapus token dan logout dari sistem.

**Endpoint:** `POST /api/logout`

**Headers:**
```
Authorization: Bearer {your_token}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Logout successful"
}
```

---

### 3. Get Current User
Mendapatkan informasi user yang sedang login.

**Endpoint:** `GET /api/me`

**Headers:**
```
Authorization: Bearer {your_token}
```

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "username": "admin",
    "nama": "admin tapal kuda",
    "email": "tapalkuda@gmail.com",
    "role": "admin",
    "no_telp": "06790879769",
    "gender": "Laki-laki",
    "alamat": "jl. sumedang",
    "profile_picture": "null"
  }
}
```

---

## 🍕 Menu Management

### 1. Get All Menus
Mendapatkan list semua menu.

**Endpoint:** `GET /api/admin/menus`

**Headers:**
```
Authorization: Bearer {your_token}
```

**Success Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nama": "Cappuccino",
      "kategori": "Kopi",
      "kategori_id": 1,
      "harga": 25000,
      "status": "Tersedia",
      "status_id": 1,
      "image_url": "http://localhost:8000/foto/cappuccino.jpg",
      "deskripsi": "Kopi dengan foam susu"
    }
  ]
}
```

---

### 2. Get Menu Detail
Mendapatkan detail menu berdasarkan ID.

**Endpoint:** `GET /api/admin/menus/{id}`

**Headers:**
```
Authorization: Bearer {your_token}
```

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nama": "Cappuccino",
    "kategori": "Kopi",
    "kategori_id": 1,
    "harga": 25000,
    "status": "Tersedia",
    "status_id": 1,
    "image_url": "http://localhost:8000/foto/cappuccino.jpg",
    "deskripsi": "Kopi dengan foam susu"
  }
}
```

**Error Response (404):**
```json
{
  "success": false,
  "message": "Menu not found"
}
```

---

### 3. Create Menu
Menambahkan menu baru.

**Endpoint:** `POST /api/admin/menus`

**Headers:**
```
Authorization: Bearer {your_token}
Content-Type: multipart/form-data
```

**Request Body (Form Data):**
```
nama: "Latte"
kategori: 1
harga: 28000
deskripsi: "Kopi dengan susu"
status: 1
foto_upload: [file] (optional, image: jpg,png,jpeg, max:2MB)
```

**Success Response (201):**
```json
{
  "success": true,
  "message": "Menu berhasil ditambahkan",
  "data": {
    "id": 15,
    "nama": "Latte",
    "harga": 28000,
    "image_url": "http://localhost:8000/foto/1703075200_latte.jpg"
  }
}
```

**Validation Error (422):**
```json
{
  "message": "The nama field is required.",
  "errors": {
    "nama": ["The nama field is required."],
    "harga": ["The harga field must be a number."]
  }
}
```

---

### 4. Update Menu
Memperbarui data menu.

**Endpoint:** `PUT /api/admin/menus/{id}` atau `POST /api/admin/menus/{id}` (dengan `_method=PUT`)

**Headers:**
```
Authorization: Bearer {your_token}
Content-Type: multipart/form-data
```

**Request Body (Form Data):**
```
nama: "Latte Premium"
kategori: 1
harga: 30000
deskripsi: "Kopi premium dengan susu"
status: 1
foto_upload: [file] (optional)
_method: PUT (jika pakai POST)
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Menu berhasil diperbarui",
  "data": {
    "id": 15,
    "nama": "Latte Premium",
    "harga": 30000,
    "image_url": "http://localhost:8000/foto/1703075300_latte.jpg"
  }
}
```

---

### 5. Delete Menu
Menghapus menu dan file fotonya.

**Endpoint:** `DELETE /api/admin/menus/{id}`

**Headers:**
```
Authorization: Bearer {your_token}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Menu berhasil dihapus"
}
```

**Error Response (404):**
```json
{
  "success": false,
  "message": "Menu not found"
}
```

---

## 🔒 Authorization

Semua endpoint di bawah `/api/admin/*` memerlukan:
1. **Authentication**: Token valid dari login
2. **Role Admin**: User harus memiliki role `admin`

**Unauthorized Response (401):**
```json
{
  "message": "Unauthenticated."
}
```

**Forbidden Response (403):**
```json
{
  "message": "Access denied. Admin role required."
}
```

---

## 📌 Notes

1. **Token Management:**
   - Token disimpan setelah login
   - Sertakan token di header setiap request: `Authorization: Bearer {token}`
   - Token dihapus saat logout

2. **File Upload:**
   - Format: JPG, PNG, JPEG
   - Max size: 2MB
   - Gunakan `multipart/form-data`

3. **Role Requirements:**
   - Admin: Full access ke semua endpoint
   - Kasir & Member: Belum diimplementasikan di API

4. **Logging:**
   - Semua operasi CRUD tercatat di `storage/logs/laravel.log`

---

## 🧪 Testing dengan Postman/Insomnia

### 1. Login
```
POST http://localhost:8000/api/login
Body: JSON
{
  "username": "admin",
  "password": "admin123"
}
```

### 2. Get All Menus
```
GET http://localhost:8000/api/admin/menus
Headers: Authorization: Bearer {token_dari_login}
```

### 3. Create Menu
```
POST http://localhost:8000/api/admin/menus
Headers: Authorization: Bearer {token}
Body: form-data
- nama: Americano
- kategori: 1
- harga: 20000
- status: 1
- deskripsi: Kopi hitam
- foto_upload: [select file]
```

---

## 📦 Response Format Standard

**Success:**
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { ... }
}
```

**Error:**
```json
{
  "success": false,
  "message": "Error message",
  "errors": { ... }
}
```

---

**Generated on:** December 20, 2025  
**Version:** 1.0.0  
**Base URL:** http://localhost:8000/api
