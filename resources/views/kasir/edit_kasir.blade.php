@extends('layouts.kasir')
@section('title', 'Edit Profile Kasir')

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endpush

@section('content')

    <div class="edit-container">
        <h2>Edit Profile Kasir</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group" style="text-align:center;">
                
                <img src="<?= $display_profile_picture ?>" alt="Foto Profil" style="width:90px;height:90px;border-radius:50%;object-fit:cover;margin-bottom:10px;">
                <br>
                <input type="file" name="foto" accept="image/*">
                <small style="color:#aaa;">(Kosongkan jika tidak ingin mengubah foto)</small>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" value="" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="" required>
            </div>
            <div class="form-group">
                <label>No Telepon</label>
                <input type="text" name="no_telp" value="" required>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    
                        <option value="<?= htmlspecialchars($gender_option['gender_name']) ?>" 
                            >
                            <?= htmlspecialchars($gender_option['gender_name']) ?>
                        </option>
                    
                </select>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" value="" required>
            </div>
            <button type="submit" name="save_profile" class="btn-save"><i class="fas fa-save"></i> Simpan</button>
        </form>
    </div>

@endsection

