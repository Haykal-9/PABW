# Class Diagram - Modul Kasir

Class diagram ini menunjukkan struktur class dan relasi antar entitas pada modul **Kasir** aplikasi Tapal Kuda.

## Diagram

```mermaid
classDiagram
    direction TB
    
    %% Controllers
    class KasirController {
        +index() View
        +riwayat() View
        +processPayment(Request) JsonResponse
    }
    
    class KasirReservasiController {
        +index() View
        +approve(id) Redirect
        +reject(Request, id) Redirect
    }
    
    %% Main Models
    class User {
        -int id
        -int role_id
        -string username
        -string password
        -string nama
        -string email
        -string no_telp
        -int gender_id
        -string alamat
        -string profile_picture
        +role() BelongsTo
        +gender() BelongsTo
        +reservasi() HasMany
        +pembayaran() HasMany
    }
    
    class Pembayaran {
        -int id
        -int user_id
        -datetime order_date
        -int status_id
        -int payment_method_id
        -int order_type_id
        +user() BelongsTo
        +payment_method() BelongsTo
        +status() BelongsTo
        +order_type() BelongsTo
        +details() HasMany
    }
    
    class DetailPembayaran {
        -int id
        -int pembayaran_id
        -int menu_id
        -int quantity
        -decimal price_per_item
        -string item_notes
        +pembayaran() BelongsTo
        +menu() BelongsTo
    }
    
    class Menu {
        -int id
        -string nama
        -decimal price
        -string url_foto
        -int type_id
        -int status_id
        +type() BelongsTo
        +status() BelongsTo
        +reviews() HasMany
        +getAverageRatingAttribute() float
    }
    
    class Reservasi {
        -int id
        -string kode_reservasi
        -int user_id
        -int jumlah_orang
        -datetime tanggal_reservasi
        -string message
        -int status_id
        +user() BelongsTo
        +status() BelongsTo
    }
    
    %% Reference/Lookup Models
    class PaymentMethods {
        -int id
        -string method_name
    }
    
    class PaymentStatus {
        -int id
        -string status_name
    }
    
    class OrderType {
        -int id
        -string type_name
    }
    
    class MenuType {
        -int id
        -string type_name
        +menus() HasMany
    }
    
    class MenuStatus {
        -int id
        -string status_name
    }
    
    class ReservationStatus {
        -int id
        -string status_name
    }
    
    %% Relationships - Controllers to Models
    KasirController ..> Menu : uses
    KasirController ..> Pembayaran : uses
    KasirController ..> DetailPembayaran : uses
    KasirReservasiController ..> Reservasi : uses
    
    %% Relationships - Models
    User "1" --> "*" Pembayaran : has
    User "1" --> "*" Reservasi : has
    
    Pembayaran "1" --> "*" DetailPembayaran : has
    Pembayaran "*" --> "1" User : belongs to
    Pembayaran "*" --> "1" PaymentMethods : uses
    Pembayaran "*" --> "1" PaymentStatus : has
    Pembayaran "*" --> "1" OrderType : has
    
    DetailPembayaran "*" --> "1" Pembayaran : belongs to
    DetailPembayaran "*" --> "1" Menu : contains
    
    Menu "*" --> "1" MenuType : has
    Menu "*" --> "1" MenuStatus : has
    
    Reservasi "*" --> "1" User : belongs to
    Reservasi "*" --> "1" ReservationStatus : has
```

## Penjelasan Komponen

### Controllers

| Controller | Deskripsi |
|------------|-----------|
| **KasirController** | Mengelola halaman kasir utama, riwayat pesanan, dan proses pembayaran |
| **KasirReservasiController** | Mengelola reservasi pelanggan (approve/reject) |

### Models Utama

| Model | Deskripsi |
|-------|-----------|
| **User** | Data pengguna (kasir/pelanggan) |
| **Pembayaran** | Transaksi pembayaran |
| **DetailPembayaran** | Detail item dalam pembayaran |
| **Menu** | Daftar menu yang tersedia |
| **Reservasi** | Data reservasi pelanggan |

### Models Referensi

| Model | Deskripsi |
|-------|-----------|
| **PaymentMethods** | Metode pembayaran (Cash, E-Wallet, QRIS) |
| **PaymentStatus** | Status pembayaran (Pending, Completed, Cancelled) |
| **OrderType** | Tipe pesanan (Dine In, Take Away) |
| **MenuType** | Kategori menu |
| **MenuStatus** | Status menu (Tersedia, Tidak Tersedia) |
| **ReservationStatus** | Status reservasi |

## Alur Kerja Kasir

1. **Proses Pembayaran**: `KasirController.processPayment()` → Membuat `Pembayaran` → Membuat `DetailPembayaran` untuk setiap item
2. **Lihat Riwayat**: `KasirController.riwayat()` → Query `Pembayaran` dengan relasi
3. **Manajemen Reservasi**: `KasirReservasiController` → Update status `Reservasi`
