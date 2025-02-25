<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'nama',
        'kapasitas',
        'lokasi',
        'harga_sewa',
        'status_ketersediaan'
    ];
}
