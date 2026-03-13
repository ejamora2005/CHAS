<?php

namespace Tests\Feature;

use App\Models\HealthRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyHealthTest extends TestCase
{
    use RefreshDatabase;

    public function test_my_health_page_requires_authentication(): void
    {
        $response = $this->get('/my-health');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_my_health_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/my-health');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_health_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/my-health', [
            'category' => 'Health Records',
            'title' => 'Blood Pressure Check',
            'value' => '120/80 mmHg',
            'record_date' => now()->toDateString(),
            'notes' => 'Normal reading',
        ]);

        $response->assertRedirect(route('my-health.index'));
        $this->assertDatabaseHas('health_records', [
            'user_id' => $user->id,
            'category' => 'Health Records',
            'title' => 'Blood Pressure Check',
            'status' => 'active',
        ]);
    }

    public function test_user_can_update_status_of_own_health_record(): void
    {
        $user = User::factory()->create();
        $record = HealthRecord::create([
            'user_id' => $user->id,
            'category' => 'Laboratory Results',
            'title' => 'CBC Result',
            'value' => 'Normal',
            'record_date' => now()->toDateString(),
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->patch(route('my-health.update-status', $record), [
            'status' => 'resolved',
        ]);

        $response->assertRedirect(route('my-health.index'));
        $this->assertDatabaseHas('health_records', [
            'id' => $record->id,
            'status' => 'resolved',
        ]);
    }

    public function test_user_can_delete_own_health_record(): void
    {
        $user = User::factory()->create();
        $record = HealthRecord::create([
            'user_id' => $user->id,
            'category' => 'Vital Tracker',
            'title' => 'Weight Log',
            'value' => '68kg',
            'record_date' => now()->toDateString(),
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->delete(route('my-health.destroy', $record));

        $response->assertRedirect(route('my-health.index'));
        $this->assertDatabaseMissing('health_records', [
            'id' => $record->id,
        ]);
    }

    public function test_user_cannot_modify_another_users_health_record(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $record = HealthRecord::create([
            'user_id' => $owner->id,
            'category' => 'Clearance Status',
            'title' => 'Annual Clearance',
            'record_date' => now()->toDateString(),
            'status' => 'active',
        ]);

        $updateResponse = $this->actingAs($otherUser)->patch(route('my-health.update-status', $record), [
            'status' => 'archived',
        ]);
        $deleteResponse = $this->actingAs($otherUser)->delete(route('my-health.destroy', $record));

        $updateResponse->assertForbidden();
        $deleteResponse->assertForbidden();
    }
}
