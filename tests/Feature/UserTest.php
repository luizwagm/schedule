<?php

namespace Tests\Feature;

use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $server = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    private $cnpjFaker = '30403877000194';

    private function setupUser(
        string $userType = 'seller',
        string $documentType = 'cpf',
        string $documentValue = '05127574020'
    ) {
        $this->setUpFaker();

        $payload = [
            'fullname' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            $documentType => $documentValue,
            'email' => $this->faker->email,
            'password' => $this->faker->password(6, 20),
            'user_type' => $userType,
            'document_type' => $documentType,
            'phone' => $this->faker->phoneNumber
        ];

        if ($documentType == User::DOCUMENT_TYPE_CNPJ) {
            $payload['company_name'] = $this->faker->firstName() . ' ' . $this->faker->lastName();
            $payload['state_registration'] = $this->faker->numberBetween(1000, 10000);
        }

        return new UserRequest($payload);        
    }

    /**
     * Create user seller with cpf and return 201
     * @test
     */
    public function create_user_seller_with_cpf_successfully(): void
    {
        $payload = $this->setupUser();

        $response = $this->call('POST', route('user.create'), $payload->toArray(), [], [], $this->server);

        $response->assertStatus(201);
    }

    /**
     * Create user seller with cnpj and return 201
     * @test
     */
    public function create_user_seller_with_cnpj_successfully(): void
    {
        $payload = $this->setupUser('seller', 'cnpj', $this->cnpjFaker);

        $response = $this->call('POST', route('user.create'), $payload->toArray(), [], [], $this->server);

        $response->assertStatus(201);
    }

    /**
     * Do not create an existing user with cpf
     * @test
     */
    public function do_not_create_an_existing_user_with_cpf(): void
    {
        $payload = $this->setupUser();

        $response = $this->call('POST', route('user.create'), $payload->toArray(), [], [], $this->server);

        $response->assertStatus(201);

        $response2 = $this->call('POST', route('user.create'), $payload->toArray(), [], [], $this->server);

        $response2->assertStatus(302);
    }

    /**
     * Do not create an existing user with cnpj
     * @test
     */
    public function do_not_create_an_existing_user_with_cnpj(): void
    {
        $payload = $this->setupUser('seller', 'cnpj', $this->cnpjFaker);

        $response = $this->call('POST', route('user.create'), $payload->toArray(), [], [], $this->server);

        $response->assertStatus(201);

        $response2 = $this->call('POST', route('user.create'), $payload->toArray(), [], [], $this->server);

        $response2->assertStatus(302);
    }

    /**
     * Do not create an user with user type not accept
     * @test
     */
    public function do_not_create_an_user_with_user_type_not_accept(): void
    {
        $payload = $this->setupUser('buyee', 'cpf');

        $response = $this->call('POST', route('user.create'), $payload->toArray(), [], [], $this->server);

        $response->assertStatus(302);
    }
}
