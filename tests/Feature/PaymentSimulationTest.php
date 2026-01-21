<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class PaymentSimulationTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_upgrade_page_requires_login()
    {
        // Guest tidak bisa akses
        $response = $this->get(route('payment.upgrade'));
        $this->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_access_upgrade_page()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get(route('payment.upgrade'));
        $response->assertStatus(200);
        $response->assertViewIs('payment.upgrade');
    }

    public function test_midtrans_checkout_creates_payment_record()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get(route('payment.midtrans.checkout'));
        
        // Check payment record created
        $this->assertDatabaseCount('payments', 1);
        
        $payment = Payment::first();
        $this->assertEquals($user->id, $payment->user_id);
        $this->assertEquals('midtrans', $payment->method);
        $this->assertEquals(99000, $payment->amount);
        $this->assertEquals('pending', $payment->status);
        
        // Check redirect to simulate view
        $response->assertStatus(200);
        $response->assertViewIs('payment.simulate');
    }

    public function test_stripe_checkout_creates_payment_record()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get(route('payment.stripe.checkout'));
        
        $this->assertDatabaseCount('payments', 1);
        $payment = Payment::first();
        $this->assertEquals('stripe', $payment->method);
    }

    public function test_paypal_checkout_creates_payment_record()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get(route('payment.paypal.checkout'));
        
        $this->assertDatabaseCount('payments', 1);
        $payment = Payment::first();
        $this->assertEquals('paypal', $payment->method);
    }

    public function test_manual_checkout_creates_payment_record()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get(route('payment.manual.checkout'));
        
        $this->assertDatabaseCount('payments', 1);
        $payment = Payment::first();
        $this->assertEquals('transfer', $payment->method);
    }

    public function test_simulate_success_activates_premium()
    {
        $user = User::factory()->create([
            'is_premium' => false,
        ]);
        
        // Create payment record
        $payment = Payment::create([
            'user_id' => $user->id,
            'reference_code' => 'TEST-' . $user->id . '-ABC123',
            'method' => 'midtrans',
            'amount' => 99000,
            'status' => 'pending'
        ]);
        
        // Simulate success
        $response = $this->actingAs($user)->get(route('payment.simulate-success', [
            'ref' => $payment->reference_code
        ]));
        
        // Check user is premium now
        $user->refresh();
        $this->assertTrue($user->is_premium);
        $this->assertNotNull($user->premium_expires_at);
        
        // Check payment status updated
        $payment->refresh();
        $this->assertEquals('paid', $payment->status);
        
        // Check redirect to dashboard
        $response->assertRedirect(route('dashboard'));
    }

    public function test_check_status_returns_payment_info()
    {
        $user = User::factory()->create();
        
        $payment = Payment::create([
            'user_id' => $user->id,
            'reference_code' => 'TEST-' . $user->id . '-ABC123',
            'method' => 'midtrans',
            'amount' => 99000,
            'status' => 'pending'
        ]);
        
        $response = $this->actingAs($user)->json('GET', route('payment.check-status', [
            'referenceCode' => $payment->reference_code
        ]));
        
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'pending',
            'reference_code' => $payment->reference_code,
            'amount' => 99000,
            'method' => 'midtrans',
        ]);
    }

    public function test_premium_user_sees_already_premium_message()
    {
        $user = User::factory()->create([
            'is_premium' => true,
            'premium_expires_at' => Carbon::now()->addMonth(),
        ]);
        
        $response = $this->actingAs($user)->get(route('payment.upgrade'));
        
        $response->assertStatus(200);
        $response->assertSee('Anda Sudah Premium');
    }
}
