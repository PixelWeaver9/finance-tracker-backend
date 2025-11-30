# Finance Tracker - Backend API

REST API untuk aplikasi Finance Tracker menggunakan PHP & MySQL.

## 🚀 Teknologi
- PHP 7.4+
- MySQL 5.7+
- PDO (PHP Data Objects)

## 📋 Fitur
- ✅ Create Transaction
- ✅ Read All Transactions (dengan filter)
- ✅ Update Transaction
- ✅ Delete Transaction
- ✅ Get Statistics (Income, Expense, Balance)

## 🔧 Setup Lokal

### Requirements
- XAMPP (Apache + MySQL)
- PHP 7.4 atau lebih tinggi

### Instalasi

1. Clone repository:
```bash
git clone https://github.com/USERNAME/finance-tracker-backend.git
```

2. Copy ke folder htdocs:
```bash
# Copy ke C:\xampp\htdocs\finance-tracker-api
```

3. Buat database:
- Buka phpMyAdmin: http://localhost/phpmyadmin
- Buat database: `finance_tracker`
- Import atau jalankan SQL:
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

4. Test API:
```
http://localhost/finance-tracker-api/api/transactions/read.php
```

## 📡 API Endpoints

### Base URL
```
http://localhost/finance-tracker-api/api/transactions
```

### Endpoints

#### 1. Get All Transactions
```
GET /read.php?filter=all
```

#### 2. Create Transaction
```
POST /create.php
Body: {
  "type": "income",
  "amount": 5000000,
  "category": "Gaji",
  "description": "Gaji Bulan Desember",
  "date": "2024-12-01"
}
```

#### 3. Update Transaction
```
POST /update.php
Body: {
  "id": 1,
  "type": "expense",
  "amount": 150000,
  "category": "Makanan",
  "description": "Makan siang",
  "date": "2024-12-15"
}
```

#### 4. Delete Transaction
```
POST /delete.php
Body: {
  "id": 1
}
```

#### 5. Get Statistics
```
GET /stats.php
```

## 👤 Author
Nama Anda - [GitHub](https://github.com/USERNAME)

## 📄 License
MIT
