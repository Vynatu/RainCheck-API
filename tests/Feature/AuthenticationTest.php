<?php

namespace Tests\Feature;

use Laravel\Passport\ClientRepository;
use Laravel\Passport\Token;
use RainCheck\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing if the /user url returns
     * current user's login details
     *
     * @return void
     */
    public function testGetUserRoute()
    {
        $this->logIn('user');

        $this->json('GET', '/user')
             ->assertStatus(200)
             ->assertJsonStructure([
                 'data' => [
                     'id', 'email', 'first_name', 'last_name',
                     'deleted_at', 'created_at', 'updated_at',
                 ],
             ])
             ->assertUniqueToken($this->user);
    }

    public function testLogin()
    {
        $client = (new ClientRepository)
            ->createPasswordGrantClient(null, 'Password Grant', 'http://localhost');

        $user = factory(User::class)->create();

        $this->json('POST', '/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $user->email,
            'password' => 'secret',
        ])
             ->assertJsonStructure([
                 'token_type',
                 'expires_in',
                 'access_token',
                 'refresh_token',
             ]);
    }
}
