<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class MeTest extends TestCase
{
    public function test_it_fails_if_user_isnt_authenticated(): void
    {
        $this->json('GET', 'api/auth/me')
            ->assertStatus(401);
    }

    public function test_it_returns_user_details(): void
    {
        $user = User::factory()->create();

        $this->jsonAs($user, 'GET', 'api/auth/me')
            ->assertJsonFragment([
                'email' => $user->email
            ]);
    }
}