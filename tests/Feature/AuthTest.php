<?php

use App\Models\User;

class AuthTest extends TestCase
{

    /** @test */
    public function Authenticatable()
    {
        $user = User::factory()->create();

        $this->json('POST', '/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ])->assertResponseOk();
    }

    /** @test */
    public function WrongAuthentication()
    {
        $user = User::factory()->create();

        $this->json('POST', '/auth/login', [
            'email' => $user->email,
            'password' => 'pasword'
        ])->assertResponseStatus(401);
    }

}
