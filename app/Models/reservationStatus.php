<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reservationStatus extends Model
{
    protected $table = 'reservation_status';
    public $timestamps = false; // Karena tabel ini tidak memiliki kolom created_at/updated_at
}