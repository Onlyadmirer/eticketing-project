# 🎟️ E-Ticketing Platform

Sebuah platform e-ticketing modern yang dibangun dengan Laravel 12 untuk mengelola penjualan tiket event secara digital. Platform ini menyediakan sistem manajemen lengkap dengan role-based access control untuk Admin, Organizer, dan User.

## 🌟 Fitur Utama

### 👤 User (Pembeli Tiket)
- Browsing event yang tersedia
- Melihat detail event lengkap (tanggal, lokasi, kategori, deskripsi)
- Membeli tiket untuk event
- Menyimpan event favorit
- Melihat daftar booking/pemesanan
- Menampilkan tiket digital (QR Code)
- Membatalkan pemesanan
- Manajemen profil

### 🎪 Organizer (Penyelenggara Event)
- Membuat dan mengelola event
- Menambahkan berbagai tipe tiket untuk setiap event
- Monitoring penjualan tiket secara real-time
- Melihat laporan booking per event
- Approval/rejection pemesanan tiket
- Dashboard dengan statistik (jumlah event, tiket terjual, revenue)
- Tracking earnings dari penjualan tiket
- Proses verifikasi organizer oleh admin

### 🛡️ Admin
- Manajemen user (user biasa, organizer)
- Verifikasi dan approval organizer
- Manajemen event (create, edit, delete)
- Manajemen tiket
- Laporan dan monitoring booking
- Statistik platform (total user, total organizer, total event, revenue)
- Performa organizer dan top earner tracking

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
- **users** - Data pengguna dengan role (admin, organizer, user)
- **events** - Data event dengan kategori, deskripsi, gambar
- **tickets** - Tipe tiket per event dengan harga
- **bookings** - Record pemesanan dengan status (pending, approved, rejected, cancelled)
- **favorites** - Event favorit pengguna

## 🚀 Teknologi & Stack

### Backend
- **Laravel 12** - Framework PHP
- **PHP 8.2+** - Server-side language
- **SQLite/MySQL** - Database

### Frontend
- **Blade Templates** - Template engine Laravel
- **Tailwind CSS 3.1** - Utility-first CSS framework
- **DaisyUI 5.5.5** - Component library untuk Tailwind
- **Alpine.js 3.4.2** - Lightweight JavaScript framework
- **Vite 7** - Build tool & dev server

### Tools & Services
- **Composer** - PHP dependency manager
- **npm/Node.js** - JavaScript package manager
- **PHPUnit** - Testing framework
- **Laravel Breeze** - Authentication scaffolding
- **Laravel Sail** - Docker development environment

## 📋 Requirement & Setup

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js 16+ dan npm
- Database (SQLite atau MySQL)

### Instalasi

1. **Clone Repository**
```bash
git clone <repository-url>
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

4. **Database Migration**
```bash
php artisan migrate --seed
```

5. **Build Assets**
```bash
npm run build
```

Atau gunakan script setup otomatis:
```bash
composer run setup
```

## 🛠️ Cara Menjalankan

### Development Mode
```bash
composer run dev
```

Perintah ini menjalankan:
- Laravel development server (port 8000)
- Queue listener untuk background jobs
- Application logs (pail)
- Vite dev server untuk hot module replacement

### Production Build
```bash
npm run build
php artisan migrate --force
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
- **Admin** - Full access ke semua fitur admin panel
- **Organizer** - Manajemen event dan tiket, perlu persetujuan admin
- **User** - Browsing, booking, favorit, profile management

### Middleware
- `role:admin` - Hanya admin yang bisa akses
- `role:organizer` - Hanya organizer yang bisa akses
- `role:user` - Hanya user yang bisa akses
- `EnsureOrganizerApproved` - Organizer harus sudah approved

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
- `DatabaseSeeder` - Main seeder
- `EventSeeder` - Sample events
- `SecondOrganizerSeeder` - Sample organizer data

## 🎨 UI/UX Components

Menggunakan **DaisyUI** untuk komponen pre-built:
- Navigation bars
- Buttons
- Forms & inputs
- Cards & containers
- Modals & alerts
- Tables
- Loading states

Styling dengan **Tailwind CSS** untuk kustomisasi lebih lanjut.

## 📝 Environment Variables

Update `.env`:
```
APP_NAME=E-Ticketing
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=database.sqlite

MAIL_DRIVER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=587
...
```

## 🐛 Troubleshooting

### Database Error
```bash
php artisan migrate:fresh --seed
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Build Error
```bash
npm install
npm run build
```

## 📚 Dokumentasi Lanjutan

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com)
- [DaisyUI](https://daisyui.com)
- [Alpine.js](https://alpinejs.dev)
- [Vite Guide](https://vitejs.dev)

## 📄 Lisensi

MIT License - Silakan gunakan untuk proyek personal maupun komersial.

## 👨‍💼 Author

**Onlyadmirer** - eticketing-project

---

**Dibuat dengan ❤️ menggunakan Laravel 12**
