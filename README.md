# Finance Tracker - Backend API

REST API untuk aplikasi Finance Tracker menggunakan PHP & MySQL dengan fitur CRUD lengkap.

## 📸 Screenshot
![API Response](screenshot-api.png)

## 🚀 Teknologi
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Library**: PDO (PHP Data Objects)
- **Server**: Apache

## ✨ Fitur
- ✅ **Create** - Menambah transaksi baru (pemasukan/pengeluaran)
- ✅ **Read** - Menampilkan semua transaksi dengan filter
- ✅ **Update** - Mengubah data transaksi yang sudah ada
- ✅ **Delete** - Menghapus transaksi
- ✅ **Statistics** - Menghitung total pemasukan, pengeluaran, dan saldo
- ✅ **CORS Enabled** - Dapat diakses dari frontend (React)
- ✅ **Error Handling** - Validasi input dan error handling lengkap

## 📁 Struktur Folder
```
finance-tracker-backend/
├── config/
│   └── database.php          # Koneksi database
├── api/
│   └── transactions/
│       ├── create.php        # Create transaction
│       ├── read.php          # Read all transactions
│       ├── update.php        # Update transaction
│       ├── delete.php        # Delete transaction
│       └── stats.php         # Get statistics
├── .htaccess                 # CORS & Apache config
└── README.md
```

## 🔧 Setup Lokal

### Requirements
- XAMPP (Apache + MySQL)
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi

### Instalasi

**1. Clone repository:**
```bash
git clone https://github.com/USERNAME/finance-tracker-backend.git
```

**2. Copy ke folder htdocs XAMPP:**
```bash
# Windows
copy finance-tracker-backend C:\xampp\htdocs\finance-tracker-api

# Mac/Linux
cp -r finance-tracker-backend /Applications/XAMPP/htdocs/finance-tracker-api
```

**3. Buat database:**
- Buka phpMyAdmin: http://localhost/phpmyadmin
- Klik **"New"**
- Database name: `finance_tracker`
- Collation: `utf8mb4_general_ci`
- Klik **"Create"**

**4. Buat tabel `transactions`:**
Klik database `finance_tracker` → tab **SQL** → paste query ini:
```sql
CREATE TABLE transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type ENUM('income', 'expense') NOT NULL,
  amount DECIMAL(15, 2) NOT NULL,
  category VARCHAR(100) NOT NULL,
  description TEXT NOT NULL,
  date DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**5. Konfigurasi database (jika perlu):**
Edit `config/database.php` sesuai kredensial MySQL Anda:
```php
private $host = "localhost";
private $db_name = "finance_tracker";
private $username = "root";
private $password = ""; // Ganti jika ada password
```

**6. Test API:**
```
http://localhost/finance-tracker-api/api/transactions/read.php
```

Response yang benar:
```json
{
  "success": true,
  "data": [],
  "count": 0
}
```

## 📡 API Endpoints

### Base URL (Development)
```
http://localhost/finance-tracker-api/api/transactions
```

### Base URL (Production)
```
https://your-domain.com/api/transactions
```

---

### **1. Get All Transactions**
**Endpoint:** `GET /read.php`

**Query Parameters:**
- `filter` (optional): `all` | `income` | `expense`

**Request:**
```bash
GET /read.php?filter=all
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "type": "income",
      "amount": 5000000,
      "category": "Gaji",
      "description": "Gaji Bulan Desember",
      "date": "2024-12-01",
      "created_at": "2024-12-01 10:30:00"
    }
  ],
  "count": 1
}
```

---

### **2. Create Transaction**
**Endpoint:** `POST /create.php`

**Request Body:**
```json
{
  "type": "income",
  "amount": 5000000,
  "category": "Gaji",
  "description": "Gaji Bulan Desember",
  "date": "2024-12-01"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Transaction created successfully.",
  "id": 1
}
```

---

### **3. Update Transaction**
**Endpoint:** `POST /update.php`

**Request Body:**
```json
{
  "id": 1,
  "type": "expense",
  "amount": 150000,
  "category": "Makanan",
  "description": "Makan siang",
  "date": "2024-12-15"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Transaction updated successfully."
}
```

---

### **4. Delete Transaction**
**Endpoint:** `POST /delete.php`

**Request Body:**
```json
{
  "id": 1
}
```

**Response:**
```json
{
  "success": true,
  "message": "Transaction deleted successfully."
}
```

---

### **5. Get Statistics**
**Endpoint:** `GET /stats.php`

**Response:**
```json
{
  "success": true,
  "data": {
    "income": 10000000,
    "expense": 3500000,
    "balance": 6500000,
    "transaction_count": 15
  }
}
```

## 🗃️ Database Schema

### Tabel: `transactions`

| Column | Type | Description |
|--------|------|-------------|
| `id` | INT (PK, AI) | Primary key, auto increment |
| `type` | ENUM | Tipe: 'income' atau 'expense' |
| `amount` | DECIMAL(15,2) | Jumlah uang |
| `category` | VARCHAR(100) | Kategori transaksi |
| `description` | TEXT | Deskripsi transaksi |
| `date` | DATE | Tanggal transaksi |
| `created_at` | TIMESTAMP | Waktu data dibuat |
| `updated_at` | TIMESTAMP | Waktu data terakhir diupdate |

## 🔐 CORS Configuration

File `.htaccess` sudah dikonfigurasi untuk mengizinkan akses dari frontend:
```apache
Header always set Access-Control-Allow-Origin "*"
Header always set Access-Control-Allow-Methods "GET, POST, PUT, DELETE, OPTIONS"
Header always set Access-Control-Allow-Headers "Content-Type, Authorization"
```

## 🐛 Troubleshooting

### Problem: CORS Error
**Solusi:**
1. Pastikan file `.htaccess` ada di root folder
2. Enable mod_rewrite dan mod_headers di Apache
3. Restart Apache

### Problem: Database Connection Failed
**Solusi:**
1. Cek MySQL sudah running
2. Cek kredensial di `config/database.php`
3. Cek database `finance_tracker` sudah dibuat

### Problem: 404 Not Found
**Solusi:**
1. Cek folder di `htdocs` namanya `finance-tracker-api`
2. Akses dengan URL yang benar: `http://localhost/finance-tracker-api/...`

## 🔗 Links

- **Frontend Repository**: [finance-tracker-frontend](https://github.com/USERNAME/finance-tracker-frontend)
- **Live Demo**: [https://finance-tracker.vercel.app](https://finance-tracker.vercel.app)
- **API Documentation**: [Postman Collection](https://www.postman.com/...)

## 👤 Author

**Nama Anda**
- GitHub: [@username](https://github.com/username)
- Email: your.email@example.com

## 📄 License

MIT License - bebas digunakan untuk keperluan pembelajaran dan portfolio.

## 📝 Notes

Project ini dibuat untuk memenuhi tugas Ujian Praktikum Pemrograman Web dengan implementasi:
- ✅ CRUD lengkap
- ✅ Database MySQL
- ✅ REST API dengan PHP
- ✅ Error handling & validation
- ✅ CORS enabled untuk frontend

---

⭐ **Jangan lupa beri star jika project ini membantu!**