<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileFinance extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'package_name',
        'amount_paid',
        'payment_date',
        'payment_mode',
        'expiry_date',
        'remarks'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'expiry_date' => 'date',
        'amount_paid' => 'decimal:2',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public static function getPaymentModes()
    {
        return [
            'Cash' => 'Cash',
            'UPI' => 'UPI',
            'Bank' => 'Bank Transfer'
        ];
    }

    public static function getPackageOptions()
    {
        return [
            'Basic' => 'Basic Package',
            'Standard' => 'Standard Package',
            'Premium' => 'Premium Package',
            'Custom' => 'Custom Package'
        ];
    }
}