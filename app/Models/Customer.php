<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    public function membership():BelongsTo {
        return $this->belongsTo(Membership::class, 'tipe_member');
    }
    protected $table = 'customers';
    public $timestamps = false;
}
