<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class menuType extends Model
{
    protected $table = 'menu_types';
    public $timestamps = false;
    
    public function menus(): HasMany
    {
        return $this->hasMany(menu::class, 'type_id');
    }
}