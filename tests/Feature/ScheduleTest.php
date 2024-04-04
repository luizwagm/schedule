<?php

namespace Tests\Feature;

use App\Http\Requests\Schedule\ScheduleFilterRequest;
use App\Http\Requests\Schedule\ScheduleRequest;
use App\Http\Requests\Schedule\ScheduleUpdateRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class ScheduleTest extends TestCase
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
     * Create schedule
     * @test
     */
    public function create_schedule(): void
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

        $payloadSchedule = new ScheduleRequest([
            'start_date' => '2024-04-05 01:00:00',
            'end_date' => '2024-04-05 10:00:00',
            'title' => 'test agenda',
            'type' => 'agenda',
            'description' => 'description to test agenda',
        ]);
        $agenda = $this->call('POST', route('schedule.create'), $payloadSchedule->toArray(), [], [], $this->server);
        $agenda->assertStatus(201);
    }

    /**
     * Update schedule existing
     * @test
     */
    public function update_schedule_existing(): void
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

        $payloadSchedule = new ScheduleRequest([
            'start_date' => '2024-04-05 01:00:00',
            'end_date' => '2024-04-05 10:00:00',
            'title' => 'test agenda',
            'type' => 'agenda',
            'description' => 'description to test agenda',
        ]);
        $agenda = $this->call('POST', route('schedule.create'), $payloadSchedule->toArray(), [], [], $this->server);
        $agenda->assertStatus(201);

        $payloadScheduleUpdate = new ScheduleUpdateRequest([
            'title' => 'test agenda2',
        ]);
        $agenda = $this->call('PUT', route('schedule.update', ['id' => $agenda->json()['id']]), $payloadScheduleUpdate->toArray(), [], [], $this->server);
        $agenda->assertStatus(200);
    }

    /**
     * Delete schedule existing
     * @test
     */
    public function delete_schedule_existing(): void
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

        $payloadSchedule = new ScheduleRequest([
            'start_date' => '2024-04-05 01:00:00',
            'end_date' => '2024-04-05 10:00:00',
            'title' => 'test agenda',
            'type' => 'agenda',
            'description' => 'description to test agenda',
        ]);
        $agenda = $this->call('POST', route('schedule.create'), $payloadSchedule->toArray(), [], [], $this->server);
        $agenda->assertStatus(201);

        $update = $this->call('POST', route('schedule.delete', ['id' => $agenda->json()['id']]), [], [], [], $this->server);
        $update->assertStatus(200);     
    }

    /**
     * Get schedule existing
     * @test
     */
    public function get_schedule_existing(): void
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

        $payloadSchedule = new ScheduleRequest([
            'start_date' => '2024-04-05 01:00:00',
            'end_date' => '2024-04-05 10:00:00',
            'title' => 'test agenda',
            'type' => 'agenda',
            'description' => 'description to test agenda',
        ]);
        $agenda = $this->call('POST', route('schedule.create'), $payloadSchedule->toArray(), [], [], $this->server);
        $agenda->assertStatus(201);

        $update = $this->call('GET', route('schedule.get', ['id' => $agenda->json()['id']]), [], [], [], $this->server);
        $update->assertStatus(200);     
    }

    /**
     * Get all schedule existing
     * @test
     */
    public function get_all_schedule_existing(): void
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

        $payloadSchedule = new ScheduleRequest([
            'start_date' => '2024-04-05 01:00:00',
            'end_date' => '2024-04-05 10:00:00',
            'title' => 'test agenda',
            'type' => 'agenda',
            'description' => 'description to test agenda',
        ]);
        $agenda = $this->call('POST', route('schedule.create'), $payloadSchedule->toArray(), [], [], $this->server);
        $agenda->assertStatus(201);

        $update = $this->call('GET', route('schedule.all'), [], [], [], $this->server);
        $update->assertStatus(200);     
    }

    /**
     * Filter schedule to interval
     * @test
     */
    public function filter_schedule_to_interval(): void
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

        $payloadSchedule = new ScheduleRequest([
            'start_date' => '2024-04-05 01:00:00',
            'end_date' => '2024-04-05 10:00:00',
            'title' => 'test agenda',
            'type' => 'agenda',
            'description' => 'description to test agenda',
        ]);
        $agenda = $this->call('POST', route('schedule.create'), $payloadSchedule->toArray(), [], [], $this->server);
        $agenda->assertStatus(201);

        $payloadScheduleFilter = new ScheduleFilterRequest([
            'from_date' => '2024-04-01 01:00:00',
            'to_date' => '2024-04-10 10:00:00',
        ]);
        $agenda = $this->call('POST', route('schedule.filter'), $payloadScheduleFilter->toArray(), [], [], $this->server);
        $agenda->assertStatus(200);  
    }
}
