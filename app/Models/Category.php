<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Kolom yang bisa diisi massal

    // Relasi ke Facility
    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }
}
