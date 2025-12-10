
# Feedback Inovasi PLN

Aplikasi dashboard admin dan feedback inovasi untuk PLN, dibuat dengan Laravel 10 dan Tailwind CSS.

## Fitur Utama
- Dashboard admin dengan sidebar dan header responsif
- Manajemen Unit, Inovasi, dan Feedback
- Import data via Excel (Maatwebsite/Laravel-Excel)
- Export data ke Excel
- Hapus data dengan AJAX (tanpa reload)
- Tabel, form, dropdown, dan modal 100% responsif (mobile friendly)
- Analitik feedback inovasi

## Instalasi Lokal
1. **Clone repository**
	```bash
	git clone https://github.com/USERNAME/feedback-inovasi-pln.git
	cd feedback-inovasi-pln
	```
2. **Install dependency**
	```bash
	composer install
	npm install
	```
3. **Copy file environment**
	```bash
	cp .env.example .env
	```
4. **Generate key**
	```bash
	php artisan key:generate
	```
5. **Atur koneksi database**
	- Edit file `.env` dan sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD.
6. **Migrasi dan seed database**
	```bash
	php artisan migrate --seed
	```
7. **Jalankan server lokal**
	```bash
	php artisan serve
	```

## Akun Admin Default
- Email: admin@pln.co.id
- Password: password

## Deployment
- Bisa di-deploy ke Railway, Vercel, atau server PHP manapun.
- Untuk demo cepat, bisa gunakan XAMPP/Laragon di Windows.

## Kontribusi
Pull request dan issue sangat diterima!

## Lisensi
[MIT](LICENSE)
