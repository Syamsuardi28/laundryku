<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = ['nama_layanan', 'harga_per_kg', 'deskripsi'];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
