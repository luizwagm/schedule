<?php

namespace Tests\Feature;

use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $server = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    private function setupUser()
    {
        $this->setUpFaker();

        $payload = [
            'fullname' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->email,
            'password' => $this->faker->password(6, 20),
        ];

        return new UserRequest($payload);        
    }

    /**
     * Create user successfully
     * @test
     */
    public function create_user_successfully(): void
    {
        $payload = $this->setupUser();

        $response = $this->call('POST', route('user.create'), $payload->toArray(), [], [], $this->server);

        $response->assertStatus(201);
    }

    /**
     * Create user erro some field
     * @test
     */
    public function create_user_error_some_field(): void
    {
        $this->setUpFaker();

        $payload = new UserRequest([
            'fullname' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => '',
            'password' => $this->faker->password(6, 20),
        ]);

        $response = $this->call('POST', route('user.create'), $payload->toArray(), [], [], $this->server);

        $response->assertStatus(302);
    }

    /**
     * Cannot Create user already existing
     * @test
     */
    public function cannot_create_user_already_existing(): void
    {
        $payload = $this->setupUser();

        $response = $this->call('POST', route('user.create'), $payload->toArray(), [], [], $this->server);
        $response->assertStatus(201);
        
        $response2 = $this->call('POST', route('user.create'), $payload->toArray(), [], [], $this->server);
        $response2->assertStatus(302);
    }

    /**
     * Get user existing
     * @test
     */
    public function get_user_existing(): void
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

        $getUser = $this->call('GET', route('user.get'), [], [], [], $this->server);
        $getUser->assertStatus(200);        
    }

    /**
     * Update user existing
     * @test
     */
    public function update_user_existing(): void
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

        $payloadUpdate = new UserUpdateRequest([
            'fullname' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'password' => '123456',
        ]);
        $update = $this->call('PUT', route('user.update'), $payloadUpdate->toArray(), [], [], $this->server);
        $update->assertStatus(200);     
    }

    /**
     * Delete user existing
     * @test
     */
    public function delete_user_existing(): void
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

        $update = $this->call('POST', route('user.delete'), [], [], [], $this->server);
        $update->assertStatus(200);     
    }
}
