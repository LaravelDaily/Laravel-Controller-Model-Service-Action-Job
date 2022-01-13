<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoicesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test to create the invoice from existing order
     *
     * @return void
     */
    public function test_invoice_created_successfully()
    {
        $user = User::factory()->create();
        $order = $user->orders()->create([
            'details' => 'Some fake order details',
        ]);

        $response = $this->post('/api/invoices/' . $order->id);
        $response->assertStatus(200);
        $response->assertSee(1); // ID of new invoice
    }

    /**
     * Test to create the duplicate invoice from existing order
     *
     * @return void
     */
    public function test_duplicate_invoice_throws_validation_error()
    {
        $user = User::factory()->create();
        $order = $user->orders()->create([
            'details' => 'Some fake order details',
        ]);

        $response = $this->post('/api/invoices/' . $order->id);
        $response->assertStatus(200);
        $response->assertSee(1); // ID of new invoice

        $response = $this->post('/api/invoices/' . $order->id);
        $response->assertStatus(422);
    }
}
