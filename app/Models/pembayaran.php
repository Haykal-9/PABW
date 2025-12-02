<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan import ini
use Illuminate\Database\Eloquent\Relations\HasMany;

class pembayaran extends Model
{
    protected $table = 'pembayaran';

    public $timestamps = false;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment_method(): BelongsTo
    {
        return $this->belongsTo(paymentMethods::class, 'payment_method_id');
    }

    public function paymentMethod(): BelongsTo
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

    public function orderType(): BelongsTo
    {
        return $this->belongsTo(orderType::class, 'order_type_id');
    }

    // app/Models/pembayaran.php
    public function details(): HasMany
    {
        return $this->hasMany(detailPembayaran::class, 'pembayaran_id');
    }
}