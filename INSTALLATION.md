# Panduan Instalasi Lengkap

## Persyaratan Sistem

### Minimum Requirements
- **PHP**: >= 8.2
- **Composer**: >= 2.0
- **MySQL**: >= 5.7 atau MariaDB >= 10.3
- **Web Server**: Apache/Nginx
- **Node.js**: >= 18.0 (untuk Vite)
- **NPM**: >= 9.0

### Recommended
- **PHP**: 8.3
- **MySQL**: 8.0
- **RAM**: 2GB minimum
- **Storage**: 500MB minimum

### PHP Extensions Required
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML

## Instalasi Step-by-Step

### 1. Clone atau Download Project

#### Via Git
```bash
git clone <repository-url> finance-system
cd finance-system
```

#### Via Download
1. Download ZIP file
2. Extract ke folder `finance-system`
3. Buka terminal di folder tersebut

### 2. Install Dependencies

#### Install PHP Dependencies
```bash
composer install
```

Jika ada error, coba:
```bash
composer install --ignore-platform-reqs
```

#### Install Node Dependencies (Optional)
```bash
npm install
```

### 3. Setup Environment

#### Copy Environment File
```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

#### Generate Application Key
```bash
php artisan key:generate
```

### 4. Konfigurasi Database

#### Buat Database
Buka MySQL client (phpMyAdmin, MySQL Workbench, atau command line):

```sql
CREATE DATABASE finance_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Edit File .env
Buka file `.env` dan sesuaikan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=finance_system
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

**Catatan**: Ganti `your_password_here` dengan password MySQL Anda

### 5. Jalankan Migrasi

#### Migrate Database
```bash
php artisan migrate
```

Jika berhasil, Anda akan melihat:
```
Migration table created successfully.
Migrating: 2024_01_01_000001_create_users_table
Migrated:  2024_01_01_000001_create_users_table
...
```

#### Seed Data Awal
```bash
php artisan db:seed
```

Ini akan membuat 3 user default:
- Admin (username: admin, password: admin123)
- User (username: user, password: user123)
- Viewer (username: viewer, password: viewer123)

### 6. Setup Storage

#### Create Storage Link
```bash
php artisan storage:link
```

#### Set Permissions (Linux/Mac)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 7. Jalankan Aplikasi

#### Development Server
```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

#### Custom Host/Port
```bash
php artisan serve --host=0.0.0.0 --port=8080
```

### 8. Build Assets (Optional)

Jika ingin build assets untuk production:

```bash
npm run build
```

Untuk development dengan hot reload:
```bash
npm run dev
```

## Verifikasi Instalasi

### 1. Cek Aplikasi
Buka browser dan akses: `http://localhost:8000`

Anda harus melihat halaman login.

### 2. Test Login
Login dengan salah satu akun:
- Username: `admin`
- Password: `admin123`

### 3. Cek Dashboard
Setelah login, Anda harus melihat dashboard sesuai role.

## Troubleshooting

### Error: "No application encryption key"
**Solusi:**
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [1045] Access denied"
**Penyebab**: Kredensial database salah

**Solusi:**
1. Cek username dan password di `.env`
2. Pastikan MySQL service berjalan
3. Test koneksi:
```bash
php artisan tinker
DB::connection()->getPdo();
```

### Error: "Class 'PDO' not found"
**Penyebab**: PHP PDO extension tidak terinstall

**Solusi:**
- Windows: Enable di `php.ini`
  ```ini
  extension=pdo_mysql
  ```
- Linux: Install via package manager
  ```bash
  sudo apt-get install php8.2-mysql
  ```

### Error: "Permission denied" (Linux/Mac)
**Solusi:**
```bash
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache
```

### Error: Migration Failed
**Solusi:**
1. Drop database dan buat ulang:
```sql
DROP DATABASE finance_system;
CREATE DATABASE finance_system;
```

2. Jalankan ulang migrasi:
```bash
php artisan migrate:fresh --seed
```

### Error: "Composer not found"
**Solusi:**
Install Composer dari: https://getcomposer.org/download/

### Error: "PHP version too old"
**Solusi:**
Update PHP ke versi 8.2 atau lebih baru

**Windows (XAMPP/Laragon):**
- Download PHP 8.2+ dari php.net
- Replace folder PHP di XAMPP/Laragon

**Linux:**
```bash
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install php8.2
```

**Mac:**
```bash
brew install php@8.2
```

## Konfigurasi Production

### 1. Environment
Edit `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 2. Optimize
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 3. Security
- Ganti `APP_KEY` dengan yang baru
- Set permission yang ketat
- Enable HTTPS
- Setup firewall

### 4. Web Server

#### Apache (.htaccess)
File `.htaccess` sudah ada di folder `public`

#### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/finance-system/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Backup & Restore

### Backup Database
```bash
php artisan db:backup
```

Atau manual:
```bash
mysqldump -u root -p finance_system > backup.sql
```

### Restore Database
```bash
mysql -u root -p finance_system < backup.sql
```

## Update Aplikasi

### Pull Update
```bash
git pull origin main
```

### Update Dependencies
```bash
composer update
npm update
```

### Run Migrations
```bash
php artisan migrate
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Uninstall

### 1. Backup Data
Backup database dan files penting

### 2. Drop Database
```sql
DROP DATABASE finance_system;
```

### 3. Delete Files
Hapus folder `finance-system`

## Support

Jika masih ada masalah:
1. Cek log: `storage/logs/laravel.log`
2. Buat issue di repository
3. Baca dokumentasi Laravel: https://laravel.com/docs

## Checklist Instalasi

- [ ] PHP >= 8.2 terinstall
- [ ] Composer terinstall
- [ ] MySQL terinstall dan berjalan
- [ ] Clone/download project
- [ ] `composer install` berhasil
- [ ] `.env` file sudah dikonfigurasi
- [ ] `php artisan key:generate` berhasil
- [ ] Database sudah dibuat
- [ ] `php artisan migrate` berhasil
- [ ] `php artisan db:seed` berhasil
- [ ] `php artisan storage:link` berhasil
- [ ] `php artisan serve` berjalan
- [ ] Bisa akses http://localhost:8000
- [ ] Bisa login dengan akun default

Selamat! Aplikasi sudah siap digunakan! 🎉
