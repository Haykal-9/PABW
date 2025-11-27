<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Diperlukan

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
}