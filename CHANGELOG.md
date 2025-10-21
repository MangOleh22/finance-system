# Changelog

Semua perubahan penting pada proyek ini akan didokumentasikan di file ini.

## [1.0.0] - 2024-10-18

### Added
- ✨ Sistem autentikasi dengan multi-role (Admin, User, Viewer)
- ✨ Dashboard untuk setiap role dengan statistik real-time
- ✨ Manajemen transaksi (Pemasukan & Pengeluaran)
- ✨ Manajemen hutang dengan tracking status
- ✨ Manajemen akun bank
- ✨ Sistem feedback user ke admin
- ✨ Sharing system untuk berbagi data dengan viewer
- ✨ UI/UX bersih dengan CSS murni (tanpa framework)
- ✨ JavaScript vanilla untuk interaksi (tanpa framework)
- ✨ Responsive design untuk mobile dan desktop
- ✨ Role-based access control
- ✨ Session management dengan online status
- ✨ Last activity tracking
- ✨ CSRF protection
- ✨ Password hashing dengan bcrypt

### Database
- 📦 Migration untuk users table
- 📦 Migration untuk transactions table
- 📦 Migration untuk debts table
- 📦 Migration untuk bank_accounts table
- 📦 Migration untuk feedback table
- 📦 Migration untuk shared_items table
- 📦 Migration untuk password_reset_requests table
- 📦 Seeder untuk user default (admin, user, viewer)

### Models
- 🔧 User model dengan role methods
- 🔧 Transaction model dengan relationships
- 🔧 Debt model dengan relationships
- 🔧 BankAccount model dengan relationships
- 🔧 Feedback model dengan relationships
- 🔧 SharedItem model dengan polymorphic relationships
- 🔧 PasswordResetRequest model

### Controllers
- 🎮 AuthController untuk login/logout
- 🎮 Dashboard controllers untuk setiap role

### Middleware
- 🛡️ RoleMiddleware untuk role-based access
- 🛡️ UpdateLastActivity untuk tracking user activity

### Views
- 🎨 Login page dengan desain modern
- 🎨 Dashboard admin dengan statistik
- 🎨 Dashboard user dengan statistik personal
- 🎨 Dashboard viewer
- 🎨 Layout template yang reusable

### Documentation
- 📚 README.md dengan panduan lengkap
- 📚 QUICK_START.md untuk setup cepat
- 📚 FEATURES.md dengan dokumentasi fitur lengkap
- 📚 CHANGELOG.md (file ini)

### Security
- 🔒 Password hashing
- 🔒 CSRF protection
- 🔒 Role-based access control
- 🔒 Session security
- 🔒 SQL injection prevention

## [Planned] - Future Releases

### Version 1.1.0
- [ ] Implementasi CRUD lengkap untuk transaksi
- [ ] Implementasi CRUD lengkap untuk hutang
- [ ] Implementasi CRUD lengkap untuk akun bank
- [ ] Filter dan pencarian transaksi
- [ ] Export ke Excel
- [ ] Import dari Excel

### Version 1.2.0
- [ ] Laporan keuangan dengan grafik
- [ ] Laporan per kategori
- [ ] Laporan per periode
- [ ] Export laporan ke PDF

### Version 1.3.0
- [ ] Notifikasi real-time
- [ ] Email notifications
- [ ] Reminder untuk hutang jatuh tempo

### Version 2.0.0
- [ ] API REST untuk integrasi
- [ ] Mobile app
- [ ] Multi-currency support
- [ ] Recurring transactions
- [ ] Budget planning
- [ ] Financial goals tracking

## Notes

Format changelog mengikuti [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
dan proyek ini menggunakan [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

### Tipe Perubahan
- `Added` untuk fitur baru
- `Changed` untuk perubahan pada fitur yang ada
- `Deprecated` untuk fitur yang akan dihapus
- `Removed` untuk fitur yang dihapus
- `Fixed` untuk bug fixes
- `Security` untuk perbaikan keamanan
