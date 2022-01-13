<?php

namespace App\Http\Controllers\Api;

use App\Actions\CreateInvoice;
use App\Http\Controllers\Controller;
use App\Jobs\CreateInvoiceJob;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function store(Order $order)
    {
        if ($order->invoice()->exists()) {
            return response()->json(['error' => 'Order already has an invoice'], 422);
        }

        $invoice = DB::transaction(function() use ($order) {
            $invoice = $order->invoice()->create();
            $order->pushStatus(2);

            return $invoice;
        });

//         With Model:
//        try {
//            $invoice = $order->createInvoice();
//        } catch (\Exception $exception) {
//            return response()->json(['error' => $exception->getMessage()], 422);
//        }

        // With Service class
//        try {
//            $invoice = $orderService->createInvoice($order);
//        } catch (\Exception $exception) {
//            return response()->json(['error' => $exception->getMessage()], 422);
//        }

        // With Action class
//        try {
//            $invoice = $createInvoice->execute($order);
//        } catch (\Exception $exception) {
//            return response()->json(['error' => $exception->getMessage()], 422);
//        }

        // With Job class
//        dispatch(new CreateInvoiceJob($order);

        return $invoice->invoice_number;
    }
}
