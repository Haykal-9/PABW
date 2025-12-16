# Class Diagram - Relasi Antar Model (Simplified)

Diagram relasi sederhana yang fokus pada model-model utama aplikasi Tapal Kuda.

---

## 1. Diagram Inti - User & Transaksi

```mermaid
classDiagram
    direction TB
    
    User "1" --> "0..*" Pembayaran : memiliki
    User "1" --> "0..*" Reservasi : membuat
    User "1" --> "0..*" Review : menulis
    
    Pembayaran "1" --> "1..*" DetailPembayaran : berisi
    DetailPembayaran "*" --> "1" Menu : mereferensikan
    Menu "1" --> "0..*" Review : menerima
    
    class User {
        +id : int
        +nama : string
        +email : string
        +role_id : int
    }
    
    class Pembayaran {
        +id : int
        +user_id : int
        +order_date : datetime
        +status_id : int
    }
    
    class DetailPembayaran {
        +id : int
        +pembayaran_id : int
        +menu_id : int
        +quantity : int
        +price_per_item : decimal
    }
    
    class Menu {
        +id : int
        +nama : string
        +price : decimal
        +type_id : int
    }
    
    class Reservasi {
        +id : int
        +user_id : int
        +kode_reservasi : string
        +tanggal_reservasi : datetime
    }
    
    class Review {
        +id : int
        +user_id : int
        +menu_id : int
        +rating : int
    }
```

---

## 2. Diagram User & Reference Tables

```mermaid
classDiagram
    direction LR
    
    User "*" --> "1" UserRole : memiliki
    User "*" --> "1" GenderType : memiliki
    
    class User {
        +id : int
        +role_id : int
        +gender_id : int
        +nama : string
    }
    
    class UserRole {
        +id : int
        +role_name : string
    }
    
    class GenderType {
        +id : int
        +gender_name : string
    }
```

**Role Values:** Admin (1), Kasir (2), Customer (3)

---

## 3. Diagram Pembayaran & Status

```mermaid
classDiagram
    direction LR
    
    Pembayaran "*" --> "1" PaymentMethods : menggunakan
    Pembayaran "*" --> "1" PaymentStatus : memiliki
    Pembayaran "*" --> "1" OrderType : tipe
    
    class Pembayaran {
        +id : int
        +payment_method_id : int
        +status_id : int
        +order_type_id : int
    }
    
    class PaymentMethods {
        +id : int
        +method_name : string
    }
    
    class PaymentStatus {
        +id : int
        +status_name : string
    }
    
    class OrderType {
        +id : int
        +type_name : string
    }
```

**Payment Methods:** Cash (1), E-Wallet (2), QRIS (3)
**Order Types:** Dine In (1), Take Away (2)

---

## 4. Diagram Menu & Kategori

```mermaid
classDiagram
    direction LR
    
    Menu "*" --> "1" MenuType : kategori
    Menu "*" --> "1" MenuStatus : status
    MenuType "1" --> "*" Menu : memiliki
    
    class Menu {
        +id : int
        +nama : string
        +price : decimal
        +type_id : int
        +status_id : int
    }
    
    class MenuType {
        +id : int
        +type_name : string
    }
    
    class MenuStatus {
        +id : int
        +status_name : string
    }
```

**Menu Status:** Tersedia (1), Habis (2)

---

## 5. Diagram Reservasi

```mermaid
classDiagram
    direction LR
    
    User "1" --> "*" Reservasi : membuat
    Reservasi "*" --> "1" ReservationStatus : memiliki
    
    class User {
        +id : int
        +nama : string
    }
    
    class Reservasi {
        +id : int
        +user_id : int
        +kode_reservasi : string
        +jumlah_orang : int
        +status_id : int
    }
    
    class ReservationStatus {
        +id : int
        +status_name : string
    }
```

**Reservation Status:** Pending (1), Confirmed (2), Cancelled (3)

---

## 6. Diagram Favorite (Many-to-Many)

```mermaid
classDiagram
    direction LR
    
    User "1" --> "*" Favorite : menyimpan
    Favorite "*" --> "1" Menu : mereferensikan
    
    class User {
        +id : int
        +nama : string
    }
    
    class Favorite {
        +user_id : int
        +menu_id : int
    }
    
    class Menu {
        +id : int
        +nama : string
    }
```

---

## Ringkasan Relasi

| Dari | Ke | Tipe | Keterangan |
|------|-----|------|------------|
| User | Pembayaran | 1 : N | 1 user bisa buat banyak order |
| User | Reservasi | 1 : N | 1 user bisa buat banyak reservasi |
| User | Review | 1 : N | 1 user bisa buat banyak review |
| User | Favorite | 1 : N | 1 user bisa punya banyak favorite |
| Pembayaran | DetailPembayaran | 1 : N | 1 order punya banyak item |
| Menu | Review | 1 : N | 1 menu bisa punya banyak review |
| Menu | DetailPembayaran | 1 : N | 1 menu bisa ada di banyak order |
| User | UserRole | N : 1 | Banyak user punya 1 role |
| Pembayaran | PaymentStatus | N : 1 | Banyak order punya 1 status |
| Menu | MenuType | N : 1 | Banyak menu punya 1 kategori |
| User | Menu | M : N | (via Favorite) |
