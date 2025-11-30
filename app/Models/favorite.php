<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';
    public $incrementing = false; 
    protected $primaryKey = null;
    protected $fillable = ['user_id', 'menu_id'];
    public $timestamps = true;
    const UPDATED_AT = null;
}