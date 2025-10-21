# Panduan Kontribusi

Terima kasih atas minat Anda untuk berkontribusi pada Sistem Keuangan! Kami menyambut kontribusi dari siapa saja.

## Cara Berkontribusi

### Melaporkan Bug

Jika Anda menemukan bug, silakan buat issue baru dengan:
- Deskripsi jelas tentang bug
- Langkah-langkah untuk mereproduksi
- Expected behavior vs actual behavior
- Screenshot (jika relevan)
- Environment details (OS, PHP version, browser, dll)

### Mengusulkan Fitur Baru

Untuk mengusulkan fitur baru:
1. Buat issue dengan label "feature request"
2. Jelaskan fitur yang diusulkan
3. Jelaskan use case dan manfaatnya
4. Diskusikan dengan maintainer sebelum mulai coding

### Pull Request Process

1. **Fork repository**
   ```bash
   git clone https://github.com/your-username/finance-system.git
   ```

2. **Buat branch baru**
   ```bash
   git checkout -b feature/nama-fitur
   ```

3. **Commit changes**
   ```bash
   git commit -m "Add: deskripsi perubahan"
   ```

4. **Push ke branch**
   ```bash
   git push origin feature/nama-fitur
   ```

5. **Buat Pull Request**
   - Jelaskan perubahan yang dibuat
   - Reference issue yang terkait
   - Tambahkan screenshot jika ada perubahan UI

### Coding Standards

#### PHP
- Follow PSR-12 coding standard
- Use type hints
- Write docblocks untuk methods
- Keep methods small and focused

```php
/**
 * Get user transactions
 *
 * @param int $userId
 * @return Collection
 */
public function getUserTransactions(int $userId): Collection
{
    return Transaction::where('user_id', $userId)->get();
}
```

#### JavaScript
- Use ES6+ syntax
- Use const/let instead of var
- Use meaningful variable names
- Add comments for complex logic

```javascript
// Good
const userTransactions = transactions.filter(t => t.userId === currentUser.id);

// Bad
var x = transactions.filter(function(t) { return t.userId === y; });
```

#### CSS
- Use BEM naming convention
- Keep selectors specific but not too nested
- Use CSS variables for colors and spacing
- Mobile-first approach

```css
/* Good */
.card {
    background: var(--white);
    border-radius: var(--border-radius);
}

.card__header {
    padding: var(--spacing-md);
}

/* Bad */
.card .header .title {
    color: #333;
}
```

### Testing

- Write tests untuk fitur baru
- Pastikan semua tests pass sebelum submit PR
- Test di multiple browsers (Chrome, Firefox, Safari)
- Test responsive design

```bash
# Run tests
php artisan test
```

### Database Migrations

- Buat migration yang reversible
- Gunakan descriptive names
- Test rollback

```bash
# Create migration
php artisan make:migration create_example_table

# Run migration
php artisan migrate

# Test rollback
php artisan migrate:rollback
```

### Commit Messages

Gunakan format commit message yang jelas:

```
Type: Short description

Longer description if needed

Fixes #123
```

**Types:**
- `Add:` untuk fitur baru
- `Fix:` untuk bug fixes
- `Update:` untuk perubahan pada fitur existing
- `Remove:` untuk menghapus fitur
- `Refactor:` untuk refactoring code
- `Docs:` untuk perubahan dokumentasi
- `Style:` untuk perubahan formatting
- `Test:` untuk menambah/update tests

### Code Review

Semua PR akan di-review oleh maintainer. Harap:
- Respond to feedback dengan konstruktif
- Make requested changes
- Keep PR focused (satu fitur per PR)

### Documentation

- Update README.md jika ada perubahan setup
- Update FEATURES.md untuk fitur baru
- Update CHANGELOG.md
- Add inline comments untuk logic yang complex

### Questions?

Jika ada pertanyaan, silakan:
- Buat issue dengan label "question"
- Join discussion di issue yang ada
- Contact maintainer

## Code of Conduct

### Our Pledge

Kami berkomitmen untuk membuat partisipasi dalam proyek ini bebas dari harassment untuk semua orang.

### Our Standards

**Positive behavior:**
- Menggunakan bahasa yang welcoming dan inclusive
- Menghormati sudut pandang dan pengalaman yang berbeda
- Menerima kritik konstruktif dengan baik
- Fokus pada yang terbaik untuk komunitas

**Unacceptable behavior:**
- Trolling, insulting, atau derogatory comments
- Personal atau political attacks
- Public atau private harassment
- Publishing others' private information

### Enforcement

Pelanggaran code of conduct dapat dilaporkan ke maintainer. Semua laporan akan di-review dan diselidiki.

## License

Dengan berkontribusi, Anda setuju bahwa kontribusi Anda akan dilisensikan di bawah MIT License.

## Terima Kasih!

Kontribusi Anda membuat proyek ini lebih baik. Terima kasih atas waktu dan usaha Anda! 🎉
