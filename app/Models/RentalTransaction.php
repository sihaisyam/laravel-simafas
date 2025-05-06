<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'total_biaya',
        'status_pembayaran',
        'kasir_id',
    ];

    protected $casts = [
        'total_biaya' => 'decimal:2',
        'status_pembayaran' => 'string',
    ];

    // Relationship with RentalDetail
    public function rentalDetails()
    {
        return $this->hasMany(RentalDetail::class);
    }

    // Payment status constants
    const STATUS_PENDING = 'PENDING';
    const STATUS_PAID = 'PAID';
    const STATUS_CANCELLED = 'CANCELLED';

    public static function getPaymentStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_PAID,
            self::STATUS_CANCELLED,
        ];
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id', 'id');
    }
}
