<?php

namespace Tests\Feature\Auth;

use App\Models\LoginActivity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_login_is_saved_to_database(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertDatabaseCount('login_activities', 1);
        $this->assertDatabaseHas('login_activities', [
            'user_id' => $user->id,
            'email' => $user->email,
            'was_successful' => true,
        ]);

        $user->refresh();
        $this->assertNotNull($user->last_login_at);
        $this->assertNotNull($user->last_login_ip);
    }

    public function test_logout_updates_logout_timestamp_for_latest_login_activity(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/dashboard');

        $activity = LoginActivity::first();
        $this->assertNotNull($activity);
        $this->assertNull($activity->logged_out_at);

        $this->post('/logout')->assertRedirect('/');

        $activity->refresh();
        $this->assertNotNull($activity->logged_out_at);
    }
}
