# Admin Dashboard - Sistem Manajemen Produk & Transaksi

Aplikasi Admin Dashboard berbasis Laravel untuk mengelola produk dan transaksi penjualan.

## Requirements / Persyaratan

### Server Requirements

- **PHP**: ^8.2
- **Database**: PostgreSQL (default) atau SQLite/MySQL
- **Web Server**: Apache/Nginx atau Laravel Valet
- **Node.js**: ^18.x (untuk asset compilation)
- **Composer**: ^2.x

### Dependencies (Sudah termasuk via Composer)

- **Laravel Framework**: ^12.0
- **Laravel Breeze**: ^2.4 (Authentication)
- **Laravel Sail**: ^1.41 (Database GUI)
- **Tailwind CSS**: ^3.x (Frontend Framework)
- **Vite**: ^5.x (Build Tool)

## Cara Menjalankan Project

### 1. Clone & Install Dependencies

```bash
# Masuk ke directory project
cd admin-dashboard

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 2. Setup Environment

```bash
# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Setup Database

**Opsi A - PostgreSQL (Default):**
```bash
# Buat database di PostgreSQL
psql -U postgres -c "CREATE DATABASE admin_dashboard;"

# Edit .env, konfigurasi:
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=admin_dashboard
# DB_USERNAME=postgres
# DB_PASSWORD=your_password

# Jalankan migration
php artisan migrate
```

**Opsi B - SQLite:**
```bash
# Buat file database SQLite
touch database/database.sqlite

# Edit .env:
# DB_CONNECTION=sqlite

# Jalankan migration
php artisan migrate
```

**Opsi C - MySQL:**
```bash
# Buat database di MySQL
mysql -u root -p -e "CREATE DATABASE admin_dashboard"

# Edit .env:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=admin_dashboard
# DB_USERNAME=root
# DB_PASSWORD=

# Jalankan migration
php artisan migrate
```

### 4. Seed Database (Opsional)

```bash
# Seed data dummy
php artisan db:seed

# Atau seed specific seeder
php artisan db:seed --class=ProductSeeder
php artisan db:seed --class=TransactionSeeder
```

### 5. Build Assets

```bash
# Build assets untuk production
npm run build

# Atau untuk development dengan hot reload
npm run dev
```

### 6. Jalankan Server

```bash
# Development server
php artisan serve

# Akan menampilkan: http://localhost:8000
```

### 7. Akses Aplikasi

1. Buka browser ke `http://localhost:8000`
2. Register akun baru atau login
3. Akses dashboard admin di `/admin/dashboard`

## Available Commands

```bash
# Clear cache
php artisan config:clear
php artisan cache:clear

# Fresh migration dengan seed
php artisan migrate:fresh --seed

# Create admin user
php artisan make:filament-user

# Test application
php artisan test
```

## Default Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | / | Home page |
| GET | /dashboard | Redirect ke admin dashboard |
| GET | /admin/dashboard | Admin Dashboard |
| GET | /admin/products | List Products |
| GET | /admin/products/create | Create Product |
| GET | /admin/products/{id} | View Product |
| GET | /admin/products/{id}/edit | Edit Product |
| GET | /admin/products/trashed | Soft Deleted Products |
| POST | /admin/products | Store Product |
| PUT | /admin/products/{id} | Update Product |
| DELETE | /admin/products/{id} | Delete Product (Soft Delete) |
| POST | /admin/products/{id}/restore | Restore Product |
| DELETE | /admin/products/{id}/force-delete | Permanent Delete |
| GET | /admin/transactions | List Transactions |
| GET | /admin/transactions/create | Create Transaction |
| GET | /admin/transactions/{id} | View Transaction |
| POST | /admin/transactions | Store Transaction |

## Project Structure

```
admin-dashboard/
├── app/
│   ├── Http/
│   │   ├── Controllers/Admin/    # Admin Controllers
│   │   └── Requests/              # Form Requests
│   ├── Models/                    # Eloquent Models
│   ├── Services/                  # Business Logic
│   └── Traits/                   # Reusable Traits
├── database/
│   ├── factories/                # Model Factories
│   ├── migrations/               # Database Migrations
│   └── seeders/                  # Database Seeders
├── resources/
│   └── views/admin/              # Admin Blade Views
└── routes/
    ├── web.php                   # Web Routes
    └── admin.php                 # Admin Routes
```

## Troubleshooting

### Error: Permission Denied pada storage/
```bash
chmod -R 775 storage bootstrap/cache
```

### Error: Database not found
```bash
php artisan migrate
php artisan db:seed
```

### Clear semua cache
```bash
php artisan optimize:clear
```
