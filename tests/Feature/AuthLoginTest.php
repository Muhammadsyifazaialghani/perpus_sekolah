<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_and_redirect_to_user_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'user',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/user/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function admin_can_login_and_redirect_to_admin_dashboard()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);
    }
}
