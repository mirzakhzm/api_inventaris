<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
    <a href="#"><img src="https://img.shields.io/badge/Project-API%20Inventaris-blue" alt="Project Badge"></a>
    <a href="#"><img src="https://img.shields.io/badge/Status-Development-yellow" alt="Status Badge"></a>
    <a href="#"><img src="https://img.shields.io/badge/Laravel-Framework-red" alt="Laravel Badge"></a>
</p>

---

## 📦 Laravel Inventaris REST API

**Laravel Inventaris REST API** adalah backend berbasis Laravel untuk mengelola data inventaris barang secara efisien. Sistem ini menyediakan endpoint untuk melakukan operasi CRUD (Create, Read, Update, Delete) terhadap data seperti:

- Barang (Items)
- User (pengguna)
- Transaksi keluar/masuk

## 🚀 Fitur Utama

- Autentikasi User (Login, Register, Logout)
- Manajemen data barang
- Validasi input menggunakan Form Request
- Response API terstruktur menggunakan Laravel Resource
- Pengujian API Menggunakna Feature Test
- Dokumentasi OpenAPI

---

## 📘 Dokumentasi API

Berikut adalah tampilan dokumentasi API yang telah dibuat menggunakan OpenAPI:

![OpenAPI Screenshot](public/doc/Doc OpenAPI_Inventaris.png)

---

## ⚙️ Instalasi

```bash
git clone https://github.com/username/inventaris-api.git
cd inventaris-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
