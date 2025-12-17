# Sequence Diagram - Login

Sequence diagram ini menunjukkan alur proses **Login** pada aplikasi Tapal Kuda.

---

## Aktor dan Komponen

| Komponen | Notasi | Deskripsi |
|----------|--------|-----------|
| **User** | Actor | Pengguna yang ingin login ke sistem |
| **:V_homepage** | View | Halaman utama (homepage.blade.php) |
| **:V_login** | View | Halaman login (login.blade.php) |
| **:C_Auth** | Controller | AuthController untuk autentikasi |
| **:M_Users** | Model | Model User untuk query database |

---

## Sequence Diagram

```mermaid
sequenceDiagram
    actor User
    participant V_homepage as :V_homepage
    participant V_login as :V_login
    participant C_Auth as :C_Auth
    participant M_Users as :M_Users

    User->>V_homepage: 1. menekan tombol login
    V_homepage->>C_Auth: 2. showLogin()
    C_Auth->>V_login: 3. return view login
    V_login-->>User: return view login

    User->>C_Auth: 4. input username & password
    C_Auth->>M_Users: 5. processLogin(request)
    M_Users-->>C_Auth: return user data
    C_Auth-->>User: 6. redirect sesuai role
```

---

## Deskripsi Alur

### 1. Menampilkan Halaman Login
1. User mengakses URL `/login`
2. `AuthController::showLogin()` dipanggil
3. Controller mengembalikan view `login.blade.php`

### 2. Proses Submit Login
1. User mengisi username dan password, lalu submit
2. `AuthController::processLogin()` dipanggil
3. Controller mencari user berdasarkan username

### 3. Validasi & Redirect
- **Sukses** → Redirect berdasarkan role (Admin/Kasir/Customer)
- **Gagal** → Redirect ke /login dengan pesan error

---

## Kode Terkait

### Routes (web.php)
```php
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);
```

### AuthController Methods
```php
public function showLogin()
{
    return view('login');
}

public function processLogin(Request $request)
{
    $user = User::where('username', $request->username)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user);
        $request->session()->regenerate();

        return match ($user->role_id) {
            1 => redirect()->route('admin.dashboard'),
            2 => redirect()->route('kasir.index'),
            3 => redirect('/'),
            default => redirect('/'),
        };
    }
    return redirect('/login')->with('error', 'Username atau password salah!');
}
```

