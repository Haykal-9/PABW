# Sequence Diagram - Modul Kasir

Sequence diagram untuk alur proses pada modul **Kasir** aplikasi Tapal Kuda.

---

## 1. Proses Pembayaran (Process Payment)

```mermaid
sequenceDiagram
    autonumber
    participant Kasir
    participant View as kasir.blade.php
    participant KC as KasirController
    participant P as Pembayaran
    participant DP as DetailPembayaran
    participant DB as Database

    Kasir->>View: Pilih menu & klik Bayar
    View->>KC: POST /kasir/payment (items, total, payment_method)
    KC->>KC: validate(request)
    
    KC->>P: create(user_id, order_date, status_id, payment_method_id)
    P->>DB: INSERT INTO pembayaran
    DB-->>P: payment object
    P-->>KC: payment created
    
    loop Setiap Item Pesanan
        KC->>DP: create(pembayaran_id, menu_id, quantity, price)
        DP->>DB: INSERT INTO detail_pembayaran
        DB-->>DP: detail created
    end
    
    KC-->>View: JSON Response (success, invoice_number)
    View-->>Kasir: Tampilkan Struk
```

---

## 2. Lihat Riwayat Pesanan

```mermaid
sequenceDiagram
    autonumber
    participant Kasir
    participant KC as KasirController
    participant P as Pembayaran
    participant DB as Database
    participant View as riwayat.blade.php

    Kasir->>KC: GET /kasir/riwayat
    KC->>P: with(['user', 'details.menu', 'payment_method', 'status'])
    P->>DB: SELECT * FROM pembayaran JOIN ...
    DB-->>P: Collection<Pembayaran>
    P-->>KC: pembayaranData
    
    KC->>KC: Format data riwayat & detailStruk
    KC->>View: return view('kasir.riwayat', data)
    View-->>Kasir: Tampilkan Tabel Riwayat
    
    opt Lihat Detail Struk
        Kasir->>View: Klik tombol detail
        View-->>Kasir: Tampilkan Modal Struk
    end
```

---

## 3. Manajemen Reservasi - Approve

```mermaid
sequenceDiagram
    autonumber
    participant Kasir
    participant KRC as KasirReservasiController
    participant R as Reservasi
    participant DB as Database

    Kasir->>KRC: GET /kasir/reservasi
    KRC->>R: where('status_id', 1)->get()
    R->>DB: SELECT * FROM reservasi WHERE status_id = 1
    DB-->>R: Collection<Reservasi>
    R-->>KRC: reservasiData
    KRC-->>Kasir: Tampilkan Daftar Reservasi Pending

    Kasir->>KRC: POST /kasir/reservasi/{id}/approve
    KRC->>R: findOrFail(id)
    R->>DB: SELECT * FROM reservasi WHERE id = ?
    DB-->>R: reservasi object
    KRC->>R: status_id = 2 (approved)
    R->>DB: UPDATE reservasi SET status_id = 2
    DB-->>R: success
    KRC-->>Kasir: Redirect dengan pesan sukses
```

---

## 4. Manajemen Reservasi - Reject

```mermaid
sequenceDiagram
    autonumber
    participant Kasir
    participant KRC as KasirReservasiController
    participant R as Reservasi
    participant RD as reservasi_ditolak
    participant DB as Database

    Kasir->>KRC: POST /kasir/reservasi/{id}/reject (alasan)
    KRC->>R: findOrFail(id)
    R->>DB: SELECT * FROM reservasi WHERE id = ?
    DB-->>R: reservasi object
    
    KRC->>R: status_id = 3 (rejected)
    R->>DB: UPDATE reservasi SET status_id = 3
    DB-->>R: success
    
    alt Ada Alasan Penolakan
        KRC->>RD: insert(reservation_id, alasan, ditolak_oleh)
        RD->>DB: INSERT INTO reservasi_ditolak
        DB-->>RD: success
    end
    
    KRC-->>Kasir: Redirect dengan pesan sukses
```

---

## 5. Halaman Utama Kasir (Index)

```mermaid
sequenceDiagram
    autonumber
    participant Kasir
    participant KC as KasirController
    participant M as Menu
    participant DB as Database
    participant View as kasir.blade.php

    Kasir->>KC: GET /kasir
    KC->>M: where('status_id', 1)->orderBy('type_id')->get()
    M->>DB: SELECT * FROM menu WHERE status_id = 1
    DB-->>M: Collection<Menu>
    M-->>KC: menuData
    
    KC->>KC: Format menu untuk JavaScript
    KC->>View: return view('kasir.kasir', [menu, order_items])
    View-->>Kasir: Tampilkan Halaman POS Kasir
```

---

## Ringkasan Alur

| Proses | Endpoint | Method | Deskripsi |
|--------|----------|--------|-----------|
| Halaman Kasir | `/kasir` | GET | Menampilkan menu & form pesanan |
| Proses Pembayaran | `/kasir/payment` | POST | Menyimpan transaksi |
| Riwayat | `/kasir/riwayat` | GET | Melihat histori transaksi |
| Reservasi | `/kasir/reservasi` | GET | Daftar reservasi pending |
| Approve | `/kasir/reservasi/{id}/approve` | POST | Konfirmasi reservasi |
| Reject | `/kasir/reservasi/{id}/reject` | POST | Tolak reservasi |
