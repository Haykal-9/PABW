<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class detailPembayaran extends Model
{
    protected $table = 'detail_pembayaran';
    public $timestamps = false; // Karena tabel tidak menggunakan timestamps()
    protected $guarded = ['id'];

    public function pembayaran() {
        return $this->belongsTo(pembayaran::class, 'pembayaran_id');
    }
    public function menu() {
        return $this->belongsTo(menu::class, 'menu_id');
    }
}