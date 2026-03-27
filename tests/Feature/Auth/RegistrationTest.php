<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'iin' => '123456789012',
            'first_name' => 'Иван',
            'last_name' => 'Иванов',
            'middle_name' => '',
            'email' => 'test@example.com',
            'phone' => '+7 700 123 45 67',
            'graduation_year' => 2020,
            'school' => 'ША',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'phone' => '77001234567',
        ]);
    }
}
