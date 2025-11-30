# 🎟️ E-Ticketing Platform

Sebuah platform e-ticketing modern yang dibangun dengan Laravel 11 untuk mengelola penjualan tiket event secara digital. Platform ini menyediakan sistem manajemen lengkap dengan role-based access control untuk Admin, Organizer, dan User.

## 🌟 Fitur Utama

### 👤 User (Pembeli Tiket)

-   Browsing event yang tersedia
-   Melihat detail event lengkap (tanggal, lokasi, kategori, deskripsi)
-   Membeli tiket untuk event
-   Menyimpan event favorit
-   Melihat daftar booking/pemesanan
-   Menampilkan tiket digital (QR Code)
-   Membatalkan pemesanan
-   Manajemen profil

### 🎪 Organizer (Penyelenggara Event)

-   Membuat dan mengelola event
-   Menambahkan berbagai tipe tiket untuk setiap event
-   Monitoring penjualan tiket secara real-time
-   Melihat laporan booking per event
-   Approval/rejection pemesanan tiket
-   Dashboard dengan statistik (jumlah event, tiket terjual, revenue)
-   Tracking earnings dari penjualan tiket
-   Proses verifikasi organizer oleh admin

### 🛡️ Admin

-   Manajemen user (user biasa, organizer)
-   Verifikasi dan approval organizer
-   Manajemen event (create, edit, delete)
-   Manajemen tiket
-   Laporan dan monitoring booking
-   Statistik platform (total user, total organizer, total event, revenue)
-   Performa organizer dan top earner tracking

## 🏗️ Arsitektur & Database

### Model Relasi

```
User (1) -> (Many) Event (Organizer)
User (1) -> (Many) Booking
User (1) -> (Many) Favorite

Event (1) -> (Many) Ticket
Event (1) -> (Many) Favorite

Ticket (1) -> (Many) Booking
Booking (Many) -> (1) User
Booking (Many) -> (1) Ticket
```

### Tabel Utama

-   **users** - Data pengguna dengan role (admin, organizer, user)
-   **events** - Data event dengan kategori, deskripsi, gambar
-   **tickets** - Tipe tiket per event dengan harga
-   **bookings** - Record pemesanan dengan status (pending, approved, rejected, cancelled)
-   **favorites** - Event favorit pengguna

## 🚀 Teknologi & Stack

### Backend

-   **Laravel 11** - Framework PHP
-   **PHP 8.2+** - Server-side language
-   **SQLite/MySQL** - Database

### Frontend

-   **Blade Templates** - Template engine Laravel
-   **Tailwind CSS 3.1** - Utility-first CSS framework
-   **DaisyUI 4.12.14** - Component library untuk Tailwind
-   **Alpine.js 3.4.2** - Lightweight JavaScript framework
-   **Vite 5** - Build tool & dev server

### Tools & Services

-   **Composer** - PHP dependency manager
-   **npm/Node.js** - JavaScript package manager
-   **PHPUnit** - Testing framework
-   **Laravel Breeze** - Authentication scaffolding
-   **Laravel Sail** - Docker development environment

## 📋 Requirement & Setup

### Prerequisites

-   PHP 8.2 atau lebih tinggi
-   Composer
-   Node.js 18+ dan npm
-   Database (SQLite atau MySQL)

### Instalasi

1. **Clone Repository**

```bash
git clone https://github.com/Onlyadmirer/eticketing-project.git
cd eticketing-project
```

2. **Install Dependencies**

```bash
composer install
npm install
```

3. **Setup Environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**

Edit file `.env` dan sesuaikan konfigurasi database:

**Untuk SQLite (default):**

```env
DB_CONNECTION=sqlite
```

**Untuk MySQL:**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eticketing
DB_USERNAME=root
DB_PASSWORD=
```

Buat database SQLite jika belum ada:

```bash
touch database/database.sqlite
```

5. **Database Migration & Seeding**

```bash
php artisan migrate --seed
```

6. **Link Storage**

```bash
php artisan storage:link
```

7. **Build Assets**

```bash
npm run build
```

## 🛠️ Cara Menjalankan

### Development Mode

**Opsi 1: Menggunakan Laravel Development Server**

```bash
php artisan serve
```

Kemudian di terminal terpisah, jalankan Vite dev server:

```bash
npm run dev
```

Akses aplikasi di: `http://localhost:8000`

**Opsi 2: Menggunakan Script Composer**

```bash
composer run dev
```

Perintah ini akan menjalankan:

-   Laravel development server (port 8000)
-   Vite dev server untuk hot module replacement

### Production Build

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📁 Struktur Direktori

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── EventController.php
│   │   ├── BookingController.php
│   │   ├── TicketController.php
│   │   ├── FavoriteController.php
│   │   ├── ProfileController.php
│   │   ├── ReportController.php
│   │   ├── Admin/
│   │   │   └── ManageUserController.php
│   │   └── Organizer/
│   │       └── StatusController.php
│   ├── Middleware/
│   └── Requests/
├── Models/
│   ├── User.php
│   ├── Event.php
│   ├── Ticket.php
│   ├── Booking.php
│   └── Favorite.php
└── Providers/

database/
├── migrations/ - Schema database
├── seeders/ - Data seeder
└── factories/ - Model factories untuk testing

resources/
├── views/ - Blade templates
│   ├── layouts/ - Layout template
│   ├── admin/ - Admin pages
│   ├── organizer/ - Organizer pages
│   ├── user/ - User pages
│   ├── events/ - Event pages
│   ├── tickets/ - Ticket pages
│   └── profile/ - Profile pages
├── css/ - Tailwind CSS
└── js/ - Alpine.js scripts

routes/
├── web.php - Web routes
├── auth.php - Authentication routes
└── console.php - Artisan commands

tests/ - Unit dan feature tests
```

## 🔐 Authentication & Authorization

### Role-Based Access Control (RBAC)

-   **Admin** - Full access ke semua fitur admin panel
-   **Organizer** - Manajemen event dan tiket, perlu persetujuan admin
-   **User** - Browsing, booking, favorit, profile management

### Middleware

-   `role:admin` - Hanya admin yang bisa akses
-   `role:organizer` - Hanya organizer yang bisa akses
-   `role:user` - Hanya user yang bisa akses
-   `EnsureOrganizerApproved` - Organizer harus sudah approved

## 📊 Route & Endpoint

### Public Routes

```
GET  /                    - Homepage
GET  /events              - Browse events
GET  /event/{id}          - Event detail
```

### User Routes (Authenticated)

```
GET    /my-bookings                    - List booking
POST   /booking                        - Create booking
PATCH  /booking/{booking}/cancel       - Cancel booking
GET    /booking/{booking}              - Show ticket digital
GET    /my-favorites                   - List favorite events
POST   /events/{event}/favorite        - Toggle favorite
```

### Organizer Routes (Approved)

```
GET    /organizer/dashboard            - Dashboard
GET    /organizer/events               - List events
POST   /organizer/events               - Create event
GET    /organizer/events/{event}/edit  - Edit event
DELETE /organizer/events/{event}       - Delete event
GET    /organizer/events/{event}/tickets         - List tickets
POST   /organizer/events/{event}/tickets        - Create ticket
DELETE /organizer/tickets/{ticket}    - Delete ticket
GET    /organizer/events/{event}/bookings       - Booking report
PATCH  /organizer/bookings/{booking}/status     - Update booking status
```

### Admin Routes

```
GET    /admin/dashboard               - Admin dashboard
GET    /admin/users                   - Manage users
PATCH  /admin/users/{id}/verify       - Verify organizer
DELETE /admin/users/{id}              - Delete user
GET    /admin/events                  - List all events
POST   /admin/events                  - Create event
DELETE /admin/events/{event}          - Delete event
GET    /admin/events/{event}/tickets           - List tickets
POST   /admin/events/{event}/tickets          - Create ticket
DELETE /admin/tickets/{ticket}        - Delete ticket
GET    /admin/events/{event}/bookings         - Booking report
PATCH  /admin/bookings/{booking}/status       - Update booking status
```

## 🧪 Testing

### Jalankan Test

```bash
composer run test
```

### File Struktur Test

```
tests/
├── Feature/
│   ├── Auth/
│   ├── ExampleTest.php
│   └── ProfileTest.php
└── Unit/
```

## 📦 Migration & Seeding

### Jalankan Migration

```bash
php artisan migrate
```

### Jalankan Seeder

```bash
php artisan db:seed
```

### Seeder yang Tersedia

-   `DatabaseSeeder` - Main seeder
-   `EventSeeder` - Sample events
-   `SecondOrganizerSeeder` - Sample organizer data

## 🎨 UI/UX Components

Menggunakan **DaisyUI** untuk komponen pre-built:

-   Navigation bars
-   Buttons
-   Forms & inputs
-   Cards & containers
-   Modals & alerts
-   Tables
-   Loading states

Styling dengan **Tailwind CSS** untuk kustomisasi lebih lanjut.

## 📝 Environment Variables

Update file `.env` sesuai kebutuhan:

```env
APP_NAME="E-Ticketing Platform"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database.sqlite

# Untuk MySQL, uncomment dan sesuaikan:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=eticketing
# DB_USERNAME=root
# DB_PASSWORD=

# Session & Cache
SESSION_DRIVER=file
CACHE_DRIVER=file

# Mail Configuration (opsional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
```

## 🐛 Troubleshooting

### Database Error

```bash
# Reset database dan jalankan ulang migration dengan seeding
php artisan migrate:fresh --seed
```

### Permission Error pada Storage/Bootstrap

```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache

# Windows (jalankan sebagai Administrator)
icacls storage /grant Users:F /t
icacls bootstrap/cache /grant Users:F /t
```

### Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Asset Build Error

```bash
# Hapus node_modules dan reinstall
rm -rf node_modules package-lock.json
npm install
npm run build
```

### SQLite Database Not Found

```bash
# Buat file database SQLite
touch database/database.sqlite

# Atau di Windows
type nul > database/database.sqlite

# Kemudian jalankan migration
php artisan migrate --seed
```

## 📚 Dokumentasi Lanjutan

-   [Laravel Documentation](https://laravel.com/docs)
-   [Tailwind CSS](https://tailwindcss.com)
-   [DaisyUI](https://daisyui.com)
-   [Alpine.js](https://alpinejs.dev)
-   [Vite Guide](https://vitejs.dev)

## 📄 Lisensi

MIT License - Silakan gunakan untuk proyek personal maupun komersial.

## 🔑 Default Akun Login

Setelah menjalankan seeder, gunakan akun berikut untuk testing:

### Admin

-   Email: `admin@example.com`
-   Password: `password`

### Organizer

-   Email: `organizer@example.com`
-   Password: `password`

### User

-   Email: `user@example.com`
-   Password: `password`

## 🤝 Kontribusi

Kontribusi selalu diterima! Silakan:

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

## 👨‍💼 Author

**Onlyadmirer**

-   GitHub: [@Onlyadmirer](https://github.com/Onlyadmirer)
-   Repository: [eticketing-project](https://github.com/Onlyadmirer/eticketing-project)

---

**Dibuat dengan ❤️ menggunakan Laravel 11**
