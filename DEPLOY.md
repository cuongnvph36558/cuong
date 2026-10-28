# ROOTBIO - Hướng dẫn deploy lên shared hosting (cPanel)

Dự án Laravel 13 + Inertia 3 + Vue 3 + Tailwind 4 (giống hệt bản gốc `tungg`).

## 1. Yêu cầu hosting

| Thành phần | Yêu cầu tối thiểu |
|---|---|
| PHP | 8.3+ (khuyến nghị 8.4/8.5) |
| Extension | `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `curl`, `zip` |
| Database | MySQL 5.7+ / MariaDB 10.3+ |
| Web server | Apache (có `mod_rewrite`) |

Trong cPanel → **Select PHP Version**, chọn PHP 8.3+ và bật các extension trên.

## 2. Deploy

### Bước 1 — Build trên máy local

```bash
cd C:\Users\nvcuo\Herd\tungg-hosting

# Tạo file .env.production từ .env.production.example, điền thông tin DB + domain
copy .env.production.example .env.production

deploy.bat   # Windows
# hoặc
bash deploy.sh   # Git Bash / WSL
```

Lệnh này sẽ:
- `npm install` + `npm run build` → sinh `public/build`
- `composer install --no-dev --optimize-autoloader`
- `php artisan app:build-deploy-archive` → đóng gói thành `rootbio-deploy.zip`

Archive **đã kèm sẵn `vendor/`**, nên trên hosting **không cần chạy composer** (nhiều shared host không cho cài extension).
Tất cả entry trong zip dùng dấu `/` nên giải nén trên Linux không bị lỗi thư mục.

### Bước 2 — Upload lên hosting

Upload `rootbio-deploy.zip` qua **cPanel → File Manager** hoặc FileZilla, giải nén vào `public_html`.

### Bước 3 — Cấu hình `.env` trên hosting

Đổi tên `.env.deploy` → `.env`, sửa lại:

```
APP_URL=https://ten-domain-cua-ban/
APP_ENV=production
APP_DEBUG=false

DB_DATABASE=user_tenhosting_db
DB_USERNAME=user_tenhosting
DB_PASSWORD=mat_khau
```

Sinh `APP_KEY` mới (KHÔNG dùng key của bản local):

```bash
php artisan key:generate
```

### Bước 4 — Tạo database

Trong cPanel → **MySQL Databases**:
1. Tạo database (vd: `cocxinh_rootbio`) và user, gán user vào database với đủ quyền.
2. Dùng **phpMyAdmin** → import `database/production_import.sql` (file này có sẵn schema + dữ liệu users/leads/nội dung trang chủ).

Nếu muốn database trống: chỉ cần chạy `php artisan migrate --force` bên dưới.

### Bước 5 — Migrate & tối ưu

SSH vào hosting rồi chạy trong thư mục project:

```bash
php artisan migrate --force
php artisan optimize
chmod -R 775 storage bootstrap/cache
```

### Bước 6 — Domain

Trong cPanel → **Domains** → trỏ domain về `public_html`. Nếu domain dùng SSL (AutoSSL), bật **Force HTTPS Redirect**.

## 3. Vài lưu ý quan trọng

### Layout thư mục
Bản này dùng layout **project root = document root** (toàn bộ project nằm trong `public_html`):
- File `.htaccess` ở root sẽ tự forward request về `public/index.php` (shim `index.php` ở root).
- Assets (`/build`, `/images`, `/storage`) được serve từ thư mục `public/`.
- `.htaccess` chặn truy cập `app/`, `config/`, `database/`, `storage/`, `vendor/`, `.env`, `composer.json`…

Nếu hosting cho phép trỏ document root vào thư mục `public` (khuyến nghị hơn), chỉ cần copy nội dung `public/` lên `public_html` và bỏ `.htaccess`/`index.php` ở root.

### Upload ảnh
Cấu hình `config/filesystems.php` đã đổi disk `public` sang `root => public_path('storage')` để không phụ thuộc symlink `storage:link` (shared hosting thường không cho tạo symlink).

Thư mục `public/storage/.htaccess` đã chặn thực thi PHP để an toàn.

### Mail
Mặc định `MAIL_MAILER=log`. Nếu cần gửi mail thật (đặt lại mật khẩu, xác minh email), đổi sang `smtp` và điền thông tin SMTP của hosting.

### Queue
Mặc định `QUEUE_CONNECTION=database`. Nếu hosting có cron job, thêm:

```
* * * * * cd /home/user/public_html && php artisan schedule:run >> /dev/null 2>&1
* * * * * cd /home/user/public_html && php artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

## 4. Tài khoản admin mặc định (đã import sẵn)

| Email | Mật khẩu |
|---|---|
| `admin@rootbio.test` | `password` |
| `test@example.com` | `password` |

**Đổi mật khẩu ngay sau khi deploy** (đăng nhập → Settings → Security).

## 5. Cập nhật code sau khi đã deploy

```bash
# Sửa code trên local
cd C:\Users\nvcuo\Herd\tungg-hosting
deploy.bat

# Upload lại file .zip, giải nén đè lên (KHÔNG xóa .env trên hosting)
```

Trên hosting sau khi giải nén lần 2:

```bash
php artisan optimize:clear
php artisan migrate --force
php artisan optimize
```

## 6. Các lệnh Artisan hữu ích

```bash
# Xuất lại database MySQL từ dữ liệu local (đã cập nhật nội dung trên hosting)
php artisan app:export-production-sql

# Đóng gói lại archive deploy
php artisan app:build-deploy-archive
```
