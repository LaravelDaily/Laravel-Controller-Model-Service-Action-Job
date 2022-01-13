<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'invoice_number'];

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $model->invoice_number = self::max('invoice_number') + 1;
        });
    }
}
