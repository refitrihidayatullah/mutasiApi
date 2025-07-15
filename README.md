Laravel REST API - Mutasi_Api
Proyek ini adalah REST API sederhana menggunakan Laravel 11, yang mencakup manajemen:

✅ User (register/login)

✅ Produk

✅ Lokasi

✅ Mutasi (stok masuk/keluar)

✅ Relasi Many-to-Many Produk-Lokasi dengan Pivot stok

Fitur Utama
Autentikasi via Sanctum (Bearer Token)

CRUD Produk, Lokasi, User, Mutasi

History mutasi per produk & user

Validasi input & middleware proteksi

JSON API response

Docker-ready

Dokumentasi API via Postman

Clone Project
SSH => git clone git@github.com:refitrihidayatullah/mutasiApi.git
HTTPS => git clone https://github.com/refitrihidayatullah/mutasiApi.git
cd mutasiApi

Jalankan dengan Docker
Pastikan kamu sudah install Docker Desktop

docker compose up -d --build

Setup .env
Salin .env.example ke .env

Sesuaikan variabel database jika perlu:

env
Salin
Edit
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=mutasi_api
DB_USERNAME=root
DB_PASSWORD=

Jalankan Composer & Migrate

docker exec -it laravel-app composer install
docker exec -it laravel-app php artisan key:generate
docker exec -it laravel-app php artisan migrate --seed

Dokumentasi API (Postman)
👉 Link Postman: https://refitrihidayatullah.postman.co/workspace/117435ea-8e35-4386-86c1-ef7bd79711a2/collection/46730229-47557914-db3b-451b-aab8-73df26b943cc?action=share&source=copy-link&creator=46730229

Berisi semua endpoint: login, CRUD, mutasi, dan history.

Author
Nama: Refi Tri Hidayatullah

Email: refitrihidayatullah@gmail.com
