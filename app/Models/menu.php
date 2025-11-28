<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini

class menu extends Model
{
    protected $table = 'menu';
    protected $guarded = ['id'];
    
    public function type(): BelongsTo
    {
        return $this->belongsTo(menuType::class, 'type_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(menuStatus::class, 'status_id');
    }

    // Relasi ke Reviews
    public function reviews(): HasMany
    {
        return $this->hasMany(review::class, 'menu_id');
    }
    
    // Fungsi untuk mendapatkan rating rata-rata
    public function getAverageRatingAttribute()
    {
        // Hitung rata-rata rating, bulatkan ke 1 angka di belakang koma
        return $this->reviews()->avg('rating');
    }
}