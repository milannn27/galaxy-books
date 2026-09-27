<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $table = 'payment_settings';

    protected $guarded = [];

    protected $casts = [
        'qris_enabled' => 'boolean',
        'transfer_enabled' => 'boolean',
        'cod_enabled' => 'boolean',
    ];
}