<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_page_requires_authentication(): void
    {
        $response = $this->get('/booking');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_booking_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/booking');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_booking(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/booking', [
            'service' => 'General Consultation',
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '10:30',
            'concern' => 'Headache and dizziness',
        ]);

        $response->assertRedirect(route('booking.index'));
        $this->assertDatabaseCount('appointments', 1);
        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'service' => 'General Consultation',
            'status' => 'pending',
        ]);
    }

    public function test_user_can_cancel_own_booking(): void
    {
        $user = User::factory()->create();
        $appointment = Appointment::create([
            'user_id' => $user->id,
            'service' => 'Dental Care',
            'appointment_date' => now()->addDays(2)->toDateString(),
            'appointment_time' => '09:00',
            'queue_number' => 'CHAS-TEST-1001',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->patch(route('booking.cancel', $appointment));

        $response->assertRedirect(route('booking.index'));
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_user_cannot_cancel_another_users_booking(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $appointment = Appointment::create([
            'user_id' => $owner->id,
            'service' => 'Dental Care',
            'appointment_date' => now()->addDays(2)->toDateString(),
            'appointment_time' => '09:00',
            'queue_number' => 'CHAS-TEST-2001',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($otherUser)->patch(route('booking.cancel', $appointment));

        $response->assertForbidden();
    }
}
