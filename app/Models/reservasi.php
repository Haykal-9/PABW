<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class reservasi extends Model
{
    protected $table = 'reservasi';
    protected $guarded = ['id'];

    public function status(): BelongsTo
    {
        return $this->belongsTo(reservationStatus::class, 'status_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}