

# Laravel REST API - Mutasi_Api

Proyek ini merupakan REST API yang dibangun menggunakan **Laravel 11**, dirancang untuk mengelola data berikut:

- ✅ **Pengguna** (registrasi dan login)
- ✅ **Produk**
- ✅ **Lokasi**
- ✅ **Mutasi** (stok masuk dan keluar)
- ✅ **Relasi Many-to-Many** antara Produk dan Lokasi dengan pivot stok

## Fitur Utama
- **Autentikasi**: Menggunakan Laravel Sanctum dengan Bearer Token.
- **Operasi CRUD**: Untuk Pengguna, Produk, Lokasi, dan Mutasi.
- **Riwayat Mutasi**: Melacak mutasi per produk dan pengguna.
- **Validasi Input**: Validasi ketat untuk semua input dengan middleware proteksi.
- **Respons API**: Menggunakan format JSON yang terstruktur.
- **Docker-Ready**: Siap digunakan dengan Docker untuk pengembangan dan produksi.
- **Dokumentasi API**: Tersedia melalui koleksi Postman.

## Prasyarat
- **PHP** >= 8.2
- **Composer**
- **Docker** dan **Docker Compose** (opsional, untuk menjalankan aplikasi di container)
- **MySQL** atau database lain yang kompatibel dengan Laravel

## Cara Instalasi

### 1. Clone Repositori
Gunakan salah satu perintah berikut untuk meng-clone proyek:

```bash
# Via SSH
git clone git@github.com:refitrihidayatullah/mutasiApi.git

# Via HTTPS
git clone https://github.com/refitrihidayatullah/mutasiApi.git
```

Masuk ke direktori proyek:
```bash
cd mutasiApi
```

### 2. Menjalankan dengan Docker
Pastikan **Docker Desktop** sudah terinstal di sistem Anda.

Jalankan perintah berikut untuk membangun dan menjalankan container:
```bash
docker compose up -d --build
```

### 3. Konfigurasi `.env`
Salin file `.env.example` ke `.env`:
```bash
cp .env.example .env
```

Sesuaikan konfigurasi database di file `.env` jika diperlukan:
```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=mutasi_api
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Instalasi Dependensi dan Migrasi Database
Jalankan perintah berikut untuk menginstal dependensi dan menjalankan migrasi database:

```bash
# Instal dependensi PHP
docker exec -it laravel-app composer install

# Generate application key
docker exec -it laravel-app php artisan key:generate

# Jalankan migrasi dan seeder
docker exec -it laravel-app php artisan migrate --seed
```

### 5. Akses Dokumentasi API
Dokumentasi lengkap API tersedia melalui Postman:

👉 [Link Koleksi Postman](https://refitrihidayatullah.postman.co/workspace/117435ea-8e35-4386-86c1-ef7bd79711a2/collection/46730229-47557914-db3b-451b-aab8-73df26b943cc?action=share&source=copy-link&creator=46730229)

Koleksi ini mencakup semua endpoint, termasuk:
- Autentikasi (login/register)
- Operasi CRUD untuk Pengguna, Produk, Lokasi, dan Mutasi
- Riwayat mutasi per produk dan pengguna

## Struktur Proyek
- **`app/`**: Berisi logika aplikasi, model, controller, dan middleware.
- **`routes/api.php`**: Mendefinisikan semua endpoint API.
- **`database/migrations/`**: Berisi migrasi database untuk struktur tabel.
- **`docker-compose.yml`**: Konfigurasi untuk menjalankan aplikasi dengan Docker.

## Penggunaan
1. Jalankan aplikasi menggunakan Docker atau server lokal (misalnya `php artisan serve`).
2. Gunakan Postman untuk menguji endpoint API dengan token autentikasi yang dihasilkan dari endpoint login.
3. Pastikan header `Authorization: Bearer <token>` disertakan untuk endpoint yang memerlukan autentikasi.

## Kontribusi
Jika ingin berkontribusi:
1. Fork repositori ini.
2. Buat branch baru (`git checkout -b fitur-baru`).
3. Commit perubahan (`git commit -m 'Menambahkan fitur baru'`).
4. Push ke branch (`git push origin fitur-baru`).
5. Buat Pull Request di GitHub.

## Kontak
**Author**: Refi Tri Hidayatullah  
**Email**: refitrihidayatullah@gmail.com

