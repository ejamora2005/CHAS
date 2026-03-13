<?php

namespace Tests\Feature;

use App\Models\EmergencyContact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmergencyInfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_emergency_info_page_requires_authentication(): void
    {
        $response = $this->get('/emergency-info');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_add_emergency_contact(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/emergency-info/contacts', [
            'name' => 'Juan Dela Cruz',
            'relationship' => 'Parent',
            'phone' => '+63 912 345 6789',
            'email' => 'juan@example.com',
            'is_primary' => '1',
        ]);

        $response->assertRedirect(route('emergency-info.index'));
        $this->assertDatabaseHas('emergency_contacts', [
            'user_id' => $user->id,
            'name' => 'Juan Dela Cruz',
            'is_primary' => true,
        ]);
    }

    public function test_setting_contact_as_primary_updates_others(): void
    {
        $user = User::factory()->create();
        $primary = EmergencyContact::create([
            'user_id' => $user->id,
            'name' => 'Primary Contact',
            'relationship' => 'Parent',
            'phone' => '111111',
            'is_primary' => true,
        ]);
        $secondary = EmergencyContact::create([
            'user_id' => $user->id,
            'name' => 'Secondary Contact',
            'relationship' => 'Sibling',
            'phone' => '222222',
            'is_primary' => false,
        ]);

        $response = $this->actingAs($user)->patch(route('emergency-info.set-primary', $secondary));

        $response->assertRedirect(route('emergency-info.index'));
        $this->assertDatabaseHas('emergency_contacts', [
            'id' => $secondary->id,
            'is_primary' => true,
        ]);
        $this->assertDatabaseHas('emergency_contacts', [
            'id' => $primary->id,
            'is_primary' => false,
        ]);
    }

    public function test_user_cannot_delete_another_users_contact(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $contact = EmergencyContact::create([
            'user_id' => $owner->id,
            'name' => 'Owner Contact',
            'relationship' => 'Parent',
            'phone' => '123456',
            'is_primary' => false,
        ]);

        $response = $this->actingAs($otherUser)->delete(route('emergency-info.destroy-contact', $contact));

        $response->assertForbidden();
    }
}
