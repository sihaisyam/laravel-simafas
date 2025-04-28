<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_id',
        'rental_transaction_id',
        'durasi_jam',
        'tanggal_mulai',
        'tanggal_selesai',
        'catatan_tambahan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    // Relationship with RentalTransaction
    public function rentalTransaction()
    {
        return $this->belongsTo(RentalTransaction::class);
    }

    // Relationship with Facility (assuming you have a Facility model)
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
