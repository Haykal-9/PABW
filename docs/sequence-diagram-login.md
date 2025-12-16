# Sequence Diagram - Login

Sequence diagram ini menunjukkan alur proses **Login** pada aplikasi Tapal Kuda.

---

## Aktor dan Komponen

| Komponen | Deskripsi |
|----------|-----------|
| **User** | Pengguna yang ingin login ke sistem |
| **LoginView** | Halaman login (login.blade.php) |
| **AuthController** | Controller yang menangani autentikasi |
| **User Model** | Model User untuk query database |
| **Database** | Database MySQL |
| **Hash Facade** | Laravel Hash untuk verifikasi password |
| **Auth Facade** | Laravel Auth untuk mengelola session login |
| **Session** | Session management |

---

## Sequence Diagram

```mermaid
sequenceDiagram
    autonumber
    
    actor User as User
    participant View as LoginView<br/>(login.blade.php)
    participant Controller as AuthController
    participant Model as User Model
    participant DB as Database
    participant Hash as Hash Facade
    participant Auth as Auth Facade
    participant Session as Session

    %% Show Login Page
    rect rgb(240, 248, 255)
        Note over User, View: Menampilkan Halaman Login
        User->>Controller: GET /login
        Controller->>View: return view('login')
        View-->>User: Tampilkan form login
    end

    %% Submit Login
    rect rgb(255, 250, 240)
        Note over User, Session: Proses Login
        User->>Controller: POST /login (username, password)
        
        Controller->>Model: where('username', $username)->first()
        Model->>DB: SELECT * FROM users WHERE username = ?
        DB-->>Model: User data / null
        Model-->>Controller: $user / null
    end

    %% Validation
    alt User ditemukan
        rect rgb(240, 255, 240)
            Note over Controller, Hash: Verifikasi Password
            Controller->>Hash: check($password, $user->password)
            Hash-->>Controller: true/false
        end
        
        alt Password benar
            rect rgb(220, 255, 220)
                Note over Controller, Session: Login Berhasil
                Controller->>Auth: login($user)
                Auth->>Session: Set user session
                Session-->>Auth: Session created
                Auth-->>Controller: User logged in
                
                Controller->>Session: regenerate()
                Session-->>Controller: New session ID
                
                alt role_id = 1 (Admin)
                    Controller-->>User: Redirect to /admin/dashboard
                else role_id = 2 (Kasir)
                    Controller-->>User: Redirect to /kasir
                else role_id = 3 (Customer)
                    Controller-->>User: Redirect to /
                end
            end
        else Password salah
            rect rgb(255, 220, 220)
                Note over Controller, User: Login Gagal - Password Salah
                Controller-->>User: Redirect to /login + error message
            end
        end
    else User tidak ditemukan
        rect rgb(255, 220, 220)
            Note over Controller, User: Login Gagal - User Tidak Ada
            Controller-->>User: Redirect to /login + error message
        end
    end
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

### 3. Validasi User
1. Controller mencari user berdasarkan username di database
2. Jika user tidak ditemukan → redirect dengan pesan error

### 4. Verifikasi Password
1. Jika user ditemukan, password diverifikasi menggunakan `Hash::check()`
2. Jika password salah → redirect dengan pesan error

### 5. Login Berhasil
1. `Auth::login($user)` dipanggil untuk membuat session
2. Session di-regenerate untuk mencegah session fixation
3. User di-redirect berdasarkan role:
   - **Admin (role_id=1)** → `/admin/dashboard`
   - **Kasir (role_id=2)** → `/kasir`
   - **Customer (role_id=3)** → `/`

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
