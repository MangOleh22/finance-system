# Panduan Cepat - Sistem Keuangan

## Setup Cepat (5 Menit)

### 1. Persiapan Database
Buat database MySQL baru:
```sql
CREATE DATABASE finance_system;
```

### 2. Konfigurasi Environment
Edit file `.env`:
```env
DB_DATABASE=finance_system
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Install & Setup
```bash
# Generate key
php artisan key:generate

# Jalankan migrasi dan seeder
php artisan migrate --seed

# Jalankan server
php artisan serve
```

### 4. Login
Buka browser: `http://localhost:8000`

**Login sebagai Admin:**
- Username: `admin`
- Password: `admin123`

**Login sebagai User:**
- Username: `user`
- Password: `user123`

**Login sebagai Viewer:**
- Username: `viewer`
- Password: `viewer123`

## Struktur Folder Penting

```
finance-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controller untuk logika bisnis
│   │   └── Middleware/      # Middleware untuk autentikasi & role
│   └── Models/              # Model database
├── database/
│   ├── migrations/          # Skema database
│   └── seeders/             # Data awal
├── public/
│   ├── css/                 # CSS murni
│   └── js/                  # JavaScript vanilla
├── resources/
│   └── views/               # Blade templates
└── routes/
    └── web.php              # Routing aplikasi
```

## Fitur Per Role

### Admin
✓ Kelola semua user
✓ Lihat semua transaksi
✓ Kelola feedback
✓ Lihat laporan global
✓ Backup & restore

### User
✓ Kelola transaksi pribadi
✓ Kelola hutang
✓ Kelola akun bank
✓ Lihat laporan pribadi
✓ Kirim feedback
✓ Share data ke viewer

### Viewer
✓ Lihat transaksi yang dibagikan
✓ Lihat hutang yang dibagikan
✓ Lihat akun bank yang dibagikan
✓ Lihat laporan

## Tips Penggunaan

1. **Menambah Transaksi**: Dashboard User → Transaksi → Tambah Baru
2. **Melihat Laporan**: Dashboard → Laporan → Pilih periode
3. **Export Data**: Laporan → Export ke Excel
4. **Berbagi Data**: Edit transaksi → Centang "Bagikan" → Pilih viewer

## Troubleshooting

### Error: "No application encryption key"
```bash
php artisan key:generate
```

### Error: Database connection
Pastikan MySQL berjalan dan kredensial di `.env` benar

### Error: Permission denied
```bash
chmod -R 775 storage bootstrap/cache
```

### Lupa Password
Login sebagai admin, lalu reset password user dari menu Manajemen User

## Customisasi

### Mengubah Warna Tema
Edit file: `public/css/app.css`
```css
:root {
    --primary: #3b82f6;  /* Ubah warna primary */
    --success: #10b981;  /* Ubah warna success */
}
```

### Menambah Kategori Transaksi
Edit migration: `database/migrations/*_create_transactions_table.php`
Tambahkan kategori baru di enum 'category'

### Mengubah Logo
Ganti SVG di file: `resources/views/layouts/app.blade.php`

## Support

Jika mengalami masalah, periksa:
1. Log Laravel: `storage/logs/laravel.log`
2. PHP version: `php -v` (harus >= 8.2)
3. Composer version: `composer --version`
4. Database connection: `php artisan tinker` → `DB::connection()->getPdo();`

## Update Aplikasi

```bash
# Pull perubahan terbaru
git pull origin main

# Update dependencies
composer update

# Jalankan migrasi baru
php artisan migrate

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

Selamat menggunakan Sistem Keuangan! 🎉
