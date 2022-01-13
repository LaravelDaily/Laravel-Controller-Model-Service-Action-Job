<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService {

    public function pushStatus(Order $order, int $status): void
    {
        $order->update(['status' => $status]);

        // Maybe some other actions?
    }

    public function createInvoice(Order $order): Invoice
    {
        if ($order->invoice()->exists()) {
            throw new \Exception('Order already has an invoice');
        }

        return DB::transaction(function() use ($order) {
            $invoice = $order->invoice()->create();
            $this->pushStatus($order, 2);

            return $invoice;
        });
    }


}
