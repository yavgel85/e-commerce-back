<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_it_requires_a_name(): void
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_a_email(): void
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_valid_email(): void
    {
        $this->json('POST', 'api/auth/register', [
            'email' => 'nope'
        ])
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_unique_email(): void
    {
        $user = User::factory()->create();

        $this->json('POST', 'api/auth/register', [
            'email' => $user->email
        ])
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password(): void
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['password']);
    }

    public function test_it_registers_a_user(): void
    {
        $this->json('POST', 'api/auth/register', [
            'name'     => $name = 'Eugene',
            'email'    => $email = 'eugene.yavgel@gmail.com',
            'password' => 'secret'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name'  => $name
        ]);
    }

    public function test_it_returns_a_user_on_registration(): void
    {
        $this->json('POST', 'api/auth/register', [
            'name'     => 'Eugene',
            'email'    => $email = 'eugene.yavgel@gmail.com',
            'password' => 'secret'
        ])
            ->assertJsonFragment([
                'email' => $email
            ]);
    }
}
