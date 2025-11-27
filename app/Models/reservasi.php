<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class reservasi extends Model
{
    protected $table = 'reservasi';
    // FIX: Gunakan $guarded untuk mengizinkan mass assignment, kecuali 'id'
    protected $guarded = ['id']; 
    
    // Relasi ke tabel reservation_status
    public function status(): BelongsTo
    {
        return $this->belongsTo(reservationStatus::class, 'status_id');
    }
    
    // Asumsi relasi ke User (jika reservasi hanya boleh dilakukan oleh user yang sudah login)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}