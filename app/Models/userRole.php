<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class userRole extends Model
{
    protected $table = 'user_roles';
    protected $guarded = ['id'];
    public $timestamps = false;
}
