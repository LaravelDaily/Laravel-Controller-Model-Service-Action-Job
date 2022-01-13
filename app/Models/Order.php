<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'details', 'status'];

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function pushStatus(int $status): void
    {
        $this->update(['status' => $status]);

        // Maybe some other actions?
    }

    public function createInvoice(): Invoice
    {
        if ($this->invoice()->exists()) {
            throw new \Exception('Order already has an invoice');
        }

        return DB::transaction(function() {
            $invoice = $this->invoice()->create();
            $this->pushStatus(2);

            return $invoice;
        });
    }
}
