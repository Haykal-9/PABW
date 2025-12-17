# Sequence Diagram - Membatalkan Reservasi

Sequence diagram ini menunjukkan alur proses **Membatalkan Reservasi** pada aplikasi Tapal Kuda.

---

## Aktor dan Komponen

| Komponen | Notasi | Deskripsi |
|----------|--------|-----------|
| **Member** | Actor | Pengguna yang ingin membatalkan reservasi |
| **:V_homepage** | View | Halaman utama (homepage) |
| **:V_profile** | View | Halaman profile member |
| **:C_Profile** | Controller | ProfileController |
| **:C_Reservasi** | Controller | ReservasiController |
| **:M_Reservasi** | Model | Model Reservasi |

---

## Sequence Diagram

```mermaid
sequenceDiagram
    actor Member
    participant V_homepage as :V_homepage
    participant C_Profile as :C_Profile
    participant V_profile as :V_profile
    participant C_Reservasi as :C_Reservasi
    participant M_Reservasi as :M_Reservasi

    Member->>V_homepage: 1. memilih menu Profile
    V_homepage->>C_Profile: 2. show(id)
    C_Profile->>V_profile: 3. return view profile
    V_profile-->>Member: return view profile
    
    Member->>V_profile: 4. memilih submenu Reservasi (daftar riwayat)
    
    Member->>V_profile: 5. memilih reservasi berstatus "Diterima" atau "Menunggu Konfirmasi"
    Member->>V_profile: 6. menekan tombol "Batalkan Reservasi"
    V_profile-->>Member: 7. menampilkan pop-up konfirmasi
    Member->>V_profile: 8. menekan tombol "Ya, Batalkan"
    
    V_profile->>C_Reservasi: 9. cancel(id)
    C_Reservasi->>C_Reservasi: 10. memeriksa aturan bisnis (pembatalan diizinkan?)
    C_Reservasi->>M_Reservasi: 11. update status menjadi "Dibatalkan"
    M_Reservasi-->>C_Reservasi: return
    C_Reservasi-->>V_profile: 12. redirect dengan pesan sukses
    V_profile-->>Member: "Reservasi Anda telah berhasil dibatalkan"
```

---

## Deskripsi Alur

### Aktor (Member)
1. **Memilih reservasi** - Memilih salah satu reservasi berstatus "Diterima" atau "Menunggu Konfirmasi" dari daftar riwayat
2. **Menekan tombol "Batalkan Reservasi"** - Klik tombol batalkan
4. **Menekan tombol "Ya, Batalkan"** - Konfirmasi pembatalan

### Sistem
3. **Menampilkan pop-up konfirmasi** - "Apakah Anda yakin ingin membatalkan reservasi ini?"
5. **cancel(id)** - Controller menerima request pembatalan
6. **Memeriksa aturan bisnis** - Validasi:
   - Reservasi belum dibatalkan sebelumnya (status_id != 3)
   - Tanggal reservasi belum lewat
   - Pembatalan minimal 2 jam sebelum waktu reservasi
7. **Mengubah status reservasi** - Update `status_id = 3` (Dibatalkan)
8. **Menampilkan pesan** - "Reservasi Anda telah berhasil dibatalkan"

---

## Kode Terkait

### Routes (web.php)
```php
Route::post('/reservasi/{id}/cancel', [ReservasiController::class, 'cancel'])->name('reservations.cancel');
```

### ReservasiController::cancel()
```php
public function cancel($id)
{
    // Check authentication
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Get reservation with authorization check
    $reservasi = Reservasi::where('user_id', Auth::id())->findOrFail($id);

    // Check if reservation can be cancelled (status pending/confirmed only)
    if ($reservasi->status_id == 3) {
        return redirect()->back()->with('error', 'Reservasi ini sudah dibatalkan sebelumnya.');
    }

    // Check if reservation date is not in the past
    if (Carbon::parse($reservasi->tanggal_reservasi)->isPast()) {
        return redirect()->back()->with('error', 'Tidak dapat membatalkan reservasi yang sudah lewat.');
    }

    // Update status to cancelled (status_id = 3)
    $reservasi->status_id = 3;
    $reservasi->save();

    return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan.');
}
```
