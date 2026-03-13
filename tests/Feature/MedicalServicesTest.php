<?php

namespace Tests\Feature;

use App\Models\MedicalServiceRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MedicalServicesTest extends TestCase
{
    use RefreshDatabase;

    public function test_medical_services_page_requires_authentication(): void
    {
        $response = $this->get('/medical-services');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_service_request(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/medical-services', [
            'service' => 'General Consultation',
            'preferred_date' => now()->addDay()->toDateString(),
            'priority' => 'medium',
            'notes' => 'Need consultation for recurring headache.',
        ]);

        $response->assertRedirect(route('medical-services.index'));
        $this->assertDatabaseHas('medical_service_requests', [
            'user_id' => $user->id,
            'service' => 'General Consultation',
            'priority' => 'medium',
            'status' => 'pending',
        ]);
    }

    public function test_user_can_update_own_service_request_status(): void
    {
        $user = User::factory()->create();
        $requestRecord = MedicalServiceRequest::create([
            'user_id' => $user->id,
            'service' => 'Dental Care',
            'preferred_date' => now()->addDays(2)->toDateString(),
            'priority' => 'high',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->patch(route('medical-services.update-status', $requestRecord), [
            'status' => 'scheduled',
        ]);

        $response->assertRedirect(route('medical-services.index'));
        $this->assertDatabaseHas('medical_service_requests', [
            'id' => $requestRecord->id,
            'status' => 'scheduled',
        ]);
    }

    public function test_user_cannot_update_another_users_service_request(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $requestRecord = MedicalServiceRequest::create([
            'user_id' => $owner->id,
            'service' => 'Dental Care',
            'preferred_date' => now()->addDays(2)->toDateString(),
            'priority' => 'high',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($otherUser)->patch(route('medical-services.update-status', $requestRecord), [
            'status' => 'scheduled',
        ]);

        $response->assertForbidden();
    }
}
