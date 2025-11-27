<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Diperlukan

class review extends Model
{
    protected $table = 'reviews';
    protected $guarded = ['id'];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function menu_item(): BelongsTo
    {
        return $this->belongsTo(menu::class, 'menu_id');
    }
}