<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaksi extends Model
{
    use HasFactory;
    public function detail():HasOne {
        return $this->hasOne(DetailTransaksi::class, 'transaksi_id');
    }

    public function customer():BelongsTo {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    protected $table = 'transaksi';
    public $timestamps = false;
}
