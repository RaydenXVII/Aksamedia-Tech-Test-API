# Documentation - API Employee Management

Sebuah RESTful API yang dibangun menggunakan Laravel 10 untuk sistem manajemen karyawan. API ini menyediakan backend service untuk mengelola data karyawan dan divisi dalam sebuah organisasi.

-----------

## 🔐 Authentication

Menggunakan Laravel Sanctum untuk otentikasi berbasis token.
Gunakan token bearer untuk akses API setelah login.

## 🌐 Endpoint API

Berikut adalah daftar *endpoint* API yang telah dibuat:

| Metode   | URL                  | Deskripsi                        |
| :------- | :------------------- | :------------------------------- |
| `GET`    | `/api/products`      | Mendapatkan semua data produk.   |
| `POST`   | `/api/products`      | Menambahkan produk baru.         |
| `GET`    | `/api/products/{id}` | Mendapatkan detail satu produk.  |
| `PUT`    | `/api/products/{id}` | Memperbarui data produk.         |
| `DELETE` | `/api/products/{id}` | Menghapus sebuah produk.         |

---

### 👤 Akun Admin

- username : Admin
- password : pastibisa

