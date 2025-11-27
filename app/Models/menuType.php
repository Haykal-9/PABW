<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini

class menuType extends Model
{
    // FIX: Tentukan nama tabel secara eksplisit (dari perbaikan sebelumnya)
    protected $table = 'menu_types';
    public $timestamps = false;
    
    // Relasi untuk mendapatkan semua menu di bawah tipe ini (opsional, tapi baik)
    public function menus(): HasMany
    {
        return $this->hasMany(menu::class, 'type_id');
    }
}