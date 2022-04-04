<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Services\PlaceToPayClient;
use Tests\Fakes\PlaceToPayClientFake;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_filter_orders_by_customer_email(): void
    {
        Order::factory()->count(3)->create();

        $customerEmail = 'felipe@testing.co';

        $order = Order::factory()->state([
            'customer_email' => $customerEmail,
        ])->create();

        $this->post(route('order.filter'), [
            'filter_email' => $customerEmail,
        ])->assertOk()
            ->assertViewIs('order.index')
            ->assertSee($order->customer_email)
            ->assertSee($order->customer_name)
            ->assertSee($order->customer_mobile)
            ->assertSee($order->product->product_name)
            ->assertSee(number_format($order->product->price, 0, ",", "."))
            ->assertSee($order->status)
            ->assertSee('View order');

        $this->post(route('order.filter'), [
            'filter_email' => 'abc',
        ])->assertOk()
            ->assertDontSee($order->customer_email)
            ->assertDontSee('View order')
        ;
    }

    /**
     * @test
     */
    public function can_pay_order_with_approved_transaction(): void
    {
        $placeToPayFake = new PlaceToPayClientFake();
        $placeToPayFake->setType(PlaceToPayClientFake::TRANSACTION_APPROVED);

        $this->swap(PlaceToPayClient::class, $placeToPayFake);

        $product = Product::factory()->state([
            'price' => 5000,
        ])->create();

        $this->post(route('order.pay'), [
            "product_id" => $product->id,
            "product_price" => $product->price,
            "customer_name" => 'Felipe Penna',
            "customer_email" => 'felipe.penna@testing.co',
            "customer_mobile" => '3215871400',
        ])->assertStatus(302)
        ->assertRedirect("https://checkout-co.placetopay.com/session/1/cc9b8690b1f7228c78b759ce27d7e80a");

        $this->assertDatabaseHas('orders', [
            'status' => Order::STATUS_CREATED,
            "customer_name" => 'Felipe Penna',
            "customer_email" => 'felipe.penna@testing.co',
            "customer_mobile" => '3215871400',
        ]);


        $order = Order::query()->first();

        $this->get(route('order.detail', $order->reference))
            ->assertOk()
            ->assertViewIs('order.detail')
            ->assertSee('PAYED')
            ->assertSee($order->customer_email)
            ->assertSee($order->customer_name)
            ->assertSee($order->customer_mobile)
            ->assertSee($order->product->product_name)
            ->assertSee(number_format($order->product->price, 0, ",", "."));

       $this->assertDatabaseHas('orders', [
           'status' => Order::STATUS_PAYED
       ]);
    }

    /**
     * @test
     */
    public function can_see_order_detail_with_rejected_transaction(): void
    {
        $placeToPayFake = new PlaceToPayClientFake();
        $this->swap(PlaceToPayClient::class, $placeToPayFake);
        $placeToPayFake->setType(PlaceToPayClientFake::TRANSACTION_REJECTED);
        $order = Order::factory()->state([
            'status' => Order::STATUS_CREATED,
            'transaction_id' => 43,
        ])->create();

        $this->get(route('order.detail', $order->reference))
            ->assertOk()
            ->assertViewIs('order.detail')
            ->assertSee('REJECTED');

        $this->assertDatabaseHas('orders', [
            'status' => Order::STATUS_REJECTED
        ]);
    }

    /**
     * @test
     */
    public function can_see_order_detail_with_pending_transaction(): void
    {
        $placeToPayFake = new PlaceToPayClientFake();
        $this->swap(PlaceToPayClient::class, $placeToPayFake);
        $placeToPayFake->setType(PlaceToPayClientFake::TRANSACTION_PENDING);
        $order = Order::factory()->state([
            'status' => Order::STATUS_PENDING,
            'transaction_id' => 43,
        ])->create();

        $this->get(route('order.detail', $order->reference))
            ->assertOk()
            ->assertViewIs('order.detail')
            ->assertSee('PENDING');

        $this->assertDatabaseHas('orders', [
            'status' => Order::STATUS_PENDING
        ]);
    }

    /**
     * @test
     */
    public function cannot_pay_order_because_payment_request_fail(): void
    {
        $placeToPayFake = new PlaceToPayClientFake();
        $placeToPayFake->setSucessRequest(false);
        $this->swap(PlaceToPayClient::class, $placeToPayFake);
        $product = Product::factory()->state([
            'price' => 5000,
        ])->create();

        $this->post(route('order.pay'), [
            "product_id" => $product->id,
            "product_price" => $product->price,
            "customer_name" => 'Felipe Penna',
            "customer_email" => 'felipe.penna@testing.co',
            "customer_mobile" => '3215871400',
        ])->assertStatus(302)->assertSessionHasErrors();
    }

    /**
     * @test
     */
    public function can_retry_payment_order(): void
    {
        $placeToPayFake = new PlaceToPayClientFake();
        $this->swap(PlaceToPayClient::class, $placeToPayFake);
        $order = Order::factory()->state([
            'status' => Order::STATUS_REJECTED,
            'transaction_id' => 43,
        ])->create();

        $this->get(route('order.retry', $order))
            ->assertStatus(302)
            ->assertRedirect("https://checkout-co.placetopay.com/session/1/cc9b8690b1f7228c78b759ce27d7e80a");
    }

    /**
     * @test
     */
    public function cannot_retry_payment_order_because_it_is_pending(): void
    {
        $placeToPayFake = new PlaceToPayClientFake();
        $this->swap(PlaceToPayClient::class, $placeToPayFake);
        $order = Order::factory()->state([
            'status' => Order::STATUS_PENDING,
            'transaction_id' => 43,
        ])->create();
        $this->get(route('order.retry', $order))
            ->assertStatus(302)
            ->assertSessionHasErrors();
    }

    /**
     * @test
     */
    public function cannot_see_order_detail_because_it_not_found(): void
    {
        $this->get(route('order.detail', "reference_one_order"))->assertStatus(404);
    }
}
