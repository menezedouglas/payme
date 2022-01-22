<?php

use App\Models\User;

class AuthTest extends TestCase
{

    /** @test */
    public function Authenticatable()
    {
        $user = User::factory()->create();

        $this->json('POST', '/auth', [
            'email' => $user->email,
            'password' => 'password'
        ])->assertResponseOk();
    }

    /** @test */
    public function WrongPassword()
    {
        $user = User::factory()->create();

        $this->json('POST', '/auth', [
            'email' => $user->email,
            'password' => 'pasword'
        ])->assertResponseStatus(401);
    }

    /** @test */
    public function WrongEmailAddress()
    {
        $this->json('POST', '/auth', [
            'email' => 'new@dsfdsfds.com',
            'password' => 'password'
        ])->assertResponseStatus(401);
    }

    /** @test */
    public function withoutEmail()
    {
        $this->json('POST', '/auth', [
            'password' => 'password'
        ])->assertResponseStatus(422);
    }

    /** @test */
    public function withoutPassword()
    {
        $this->json('POST', '/auth', [
            'email' => 'new@example.com',
        ])->assertResponseStatus(422);
    }

    /** @test */
    public function withoutEmailAndPassword()
    {
        $this->json('POST', '/auth', [])->assertResponseStatus(422);
    }

    /** @test */
    public function invalidEmail()
    {
        $this->json('POST', '/auth', [
            'email' => 'new@example.',
            'password' => 'password'
        ])->assertResponseStatus(422);
    }

}
