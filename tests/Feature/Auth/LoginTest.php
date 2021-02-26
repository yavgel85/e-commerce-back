<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_it_requires_an_email(): void
    {
        $this->json('POST', 'api/auth/login')
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password(): void
    {
        $this->json('POST', 'api/auth/login')
            ->assertJsonValidationErrors(['password']);
    }

    public function test_it_returns_a_validation_error_if_credentials_dont_match(): void
    {
        $user = User::factory()->create();

        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'nope'
        ])
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_returns_a_token_if_credentials_do_match(): void
    {
        $user = User::factory()->create([
            'password' => 'cats'
        ]);

        $this->json('POST', 'api/auth/login', [
            'email'    => $user->email,
            'password' => 'cats'
        ])
            ->assertJsonStructure([
                'meta' => [
                    'token'
                ]
            ]);
    }

    public function test_it_returns_a_user_if_credentials_do_match(): void
    {
        $user = User::factory()->create([
            'password' => 'cats'
        ]);

        $this->json('POST', 'api/auth/login', [
            'email'    => $user->email,
            'password' => 'cats'
        ])
            ->assertJsonFragment([
                'email' => $user->email
            ]);
    }
}
