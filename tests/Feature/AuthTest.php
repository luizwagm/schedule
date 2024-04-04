<?php

namespace Tests\Feature;

use App\Http\Requests\User\UserRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $server = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    /**
     * Login existing
     * @test
     */
    public function login_existing(): void
    {
        $this->setUpFaker();

        $email = $this->faker->email;
        $password = $this->faker->password(6, 20);

        $payload = new UserRequest([
            'fullname' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $email,
            'password' => $password,
        ]);

        $response = $this->call('POST', route('user.create'), $payload->toArray(), [], [], $this->server);
        $response->assertStatus(201);

        $payloadLogin = new Request([
            'email' => $email,
            'password' => $password,
        ]);

        $login = $this->call('POST', route('auth.login'), $payloadLogin->toArray(), [], [], $this->server);
        $login->assertStatus(200);      
    }

    /**
     * Login error
     * @test
     */
    public function login_error(): void
    {
        $this->setUpFaker();

        $email = $this->faker->email;
        $password = $this->faker->password(6, 20);

        $payload = new UserRequest([
            'fullname' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $email,
            'password' => $password,
        ]);
        $response = $this->call('POST', route('user.create'), $payload->toArray(), [], [], $this->server);
        $response->assertStatus(201);

        $payloadLogin = new Request([
            'email' => 'manelson@emailson.conson',
            'password' => $password,
        ]);
        $login = $this->call('POST', route('auth.login'), $payloadLogin->toArray(), [], [], $this->server);
        $login->assertStatus(401);    
    }
}
