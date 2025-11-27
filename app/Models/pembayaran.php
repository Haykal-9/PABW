<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan import ini

class pembayaran extends Model
{
    // FIX: Tentukan nama tabel secara eksplisit
    protected $table = 'pembayaran';

    // Menonaktifkan timestamps karena tabel tidak memilikinya
    public $timestamps = false;
    
    protected $guarded = ['id'];
    
    // Relasi untuk AdminController::orders()
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment_method(): BelongsTo
    {
        return $this->belongsTo(paymentMethods::class, 'payment_method_id');
    }
    
    public function status(): BelongsTo
    {
        return $this->belongsTo(paymentStatus::class, 'status_id');
    }
    
    public function order_type(): BelongsTo
    {
        return $this->belongsTo(orderType::class, 'order_type_id');
    }
}