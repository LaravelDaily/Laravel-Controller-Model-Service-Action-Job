<?php

namespace App\Actions;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CreateInvoice {

    public function execute(Order $order): Invoice
    {
        if ($order->invoice()->exists()) {
            throw new \Exception('Order already has an invoice');
        }

        return DB::transaction(function() use ($order) {
            $invoice = $order->invoice()->create();
            $order->pushStatus(2);

            return $invoice;
        });
    }

}
