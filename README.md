# Laravel Midtrans Payment Gateway Integration

Project ini adalah contoh implementasi integrasi **Midtrans Payment Gateway** dengan framework **Laravel**. Proyek ini mencakup proses checkout, callback notifikasi pembayaran, status transaksi, dan tampilan riwayat transaksi.

## ✨ Fitur

- Checkout dengan Midtrans Snap
- Halaman sukses setelah pembayaran
- Callback/notification handler
- Cek status transaksi berdasarkan `order_id`
- Riwayat transaksi
- Struktur Laravel standar
- (Optional) Integrasi Notifikasi WhatsApp menggunakan Twilio (dalam pengembangan)

## 🛠️ Teknologi

- Laravel 10+
- Midtrans Snap API
- Blade templating
- Tailwind CSS (default Laravel)
- Git + GitHub

## 🧾 Instalasi

1. **Clone repositori**

```bash
git clone https://github.com/muhammadfaizz02/Laravel-Midtrans-Payment.git
cd Laravel-Midtrans-Payment

composer install
npm install && npm run dev

cp .env.example .env
php artisan key:generate

MIDTRANS_SERVER_KEY=your_midtrans_server_key
MIDTRANS_CLIENT_KEY=your_midtrans_client_key
MIDTRANS_IS_PRODUCTION=false

php artisan migrate

php artisan serve

📄 Struktur Routing
URL	Deskripsi
/	Halaman utama & pilihan pembayaran
/checkout	Proses checkout Snap Midtrans (POST)
/payment/callback	Endpoint notifikasi callback Midtrans
/payment/success	Halaman sukses pembayaran
/transactions	Menampilkan daftar riwayat transaksi
/transactions/check/{id}	Cek status transaksi berdasarkan ID

🧑‍💻 Kontributor
Muhammad Faiz Akbar Kamil
