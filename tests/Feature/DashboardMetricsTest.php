<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\EmergencyContact;
use App\Models\HealthRecord;
use App\Models\MedicalServiceRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardMetricsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_dashboard_metrics_are_based_on_user_records(): void
    {
        $user = User::factory()->create();

        Appointment::create([
            'user_id' => $user->id,
            'service' => 'General Consultation',
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '09:30',
            'queue_number' => 'CHAS-TST-3001',
            'status' => 'pending',
        ]);
        Appointment::create([
            'user_id' => $user->id,
            'service' => 'Dental Care',
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '10:30',
            'queue_number' => 'CHAS-TST-3002',
            'status' => 'cancelled',
        ]);

        HealthRecord::create([
            'user_id' => $user->id,
            'category' => 'Health Records',
            'title' => 'BP Check',
            'record_date' => now()->toDateString(),
            'status' => 'active',
        ]);
        HealthRecord::create([
            'user_id' => $user->id,
            'category' => 'Laboratory Results',
            'title' => 'CBC',
            'record_date' => now()->toDateString(),
            'status' => 'resolved',
        ]);

        MedicalServiceRequest::create([
            'user_id' => $user->id,
            'service' => 'Vaccination Services',
            'preferred_date' => now()->addDays(2)->toDateString(),
            'priority' => 'medium',
            'status' => 'pending',
        ]);

        EmergencyContact::create([
            'user_id' => $user->id,
            'name' => 'Parent Contact',
            'relationship' => 'Parent',
            'phone' => '12345',
            'is_primary' => true,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);

        $metrics = $response->viewData('metrics');
        $moduleCounts = $response->viewData('moduleCounts');

        $this->assertEquals(1, $metrics['upcoming_appointments']);
        $this->assertEquals(1, $metrics['pending_service_requests']);
        $this->assertEquals(1, $metrics['active_health_records']);
        $this->assertEquals(1, $metrics['emergency_contacts']);

        $this->assertEquals(1, $moduleCounts['services']);
        $this->assertEquals(1, $moduleCounts['bookings']);
        $this->assertEquals(2, $moduleCounts['health']);
        $this->assertEquals(1, $moduleCounts['emergency']);
    }
}
