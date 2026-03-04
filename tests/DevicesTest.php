<?php

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\TestCase;
use Workbench\App\Models\User;

use function Orchestra\Testbench\workbench_path;

#[WithMigration]
class DevicesTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_user_can_add_a_device()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->postJson('/api/devices', [
            'name' => 'test',
            'type' => 'mobile',
            'token' => 'qwertyuiopasdfghjklzxcvbnm',
        ]);

        $response->assertStatus(201);
        $this->assertEquals(__('devices.created'), $response->json('message'));
    }

    protected function createUser(array $attributes = []): User
    {
        return User::create(array_merge([
            'email' => Factory::create()->unique()->safeEmail,
            'name' => Factory::create()->unique()->name,
            'password' => Hash::make('password123'),
        ], $attributes));
    }

    public function test_api_user_can_get_their_devices()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->get('/api/devices');

        $response->assertStatus(200);
        $this->assertEquals(__('devices.retrieved'), $response->json('message'));

    }

    public function test_api_user_can_update_their_device()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->postJson('/api/devices', [
            'name' => 'test',
            'type' => 'mobile',
            'token' => 'qwertyuiopasdfghjklzxcvbnm',
        ]);

        $response->assertStatus(201);

        $device_id = $response['data']['id'];
        $response = $this->actingAs($user)->putJson('/api/devices/'.$device_id, [
            'name' => 'test',
            'type' => 'mobile',
            'token' => 'mnbvcxzlkjhgfdsapoiuytrewq',
        ]);

        $response->assertStatus(200);
        $this->assertEquals(__('devices.updated'), $response->json('message'));

    }

    public function test_api_user_should_update_only_their_device()
    {
        $user1 = $this->createUser();
        $response = $this->actingAs($user1)->postJson('/api/devices', [
            'name' => 'test',
            'type' => 'mobile',
            'token' => 'qwertyuiopasdfghjklzxcvbnm',
        ]);

        $response->assertStatus(201);

        $user2 = $this->createUser();

        $device_id = $response['data']['id'];
        $response = $this->actingAs($user2)->putJson('/api/devices/'.$device_id, [
            'name' => 'test',
            'type' => 'mobile',
            'token' => 'mnbvcxzlkjhgfdsapoiuytrewq',
        ]);

        $response->assertStatus(404);
    }

    public function test_api_user_should_delete_only_their_device()
    {
        $user1 = $this->createUser();
        $response = $this->actingAs($user1)->postJson('/api/devices', [
            'name' => 'test',
            'type' => 'mobile',
            'token' => 'qwertyuiopasdfghjklzxcvbnm',
        ]);

        $response->assertStatus(201);

        $user2 = $this->createUser();

        $device_id = $response['data']['id'];
        $response = $this->actingAs($user2)->delete('/api/devices'.$device_id);

        $response->assertStatus(404);
    }

    public function test_api_user_can_delete_a_device()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->postJson('/api/devices', [
            'name' => 'test',
            'type' => 'mobile',
            'token' => 'qwertyuiopasdfghjklzxcvbnm',
        ]);

        $response->assertStatus(201);

        $device_id = $response['data']['id'];
        $response = $this->actingAs($user)->delete('/api/devices/'.$device_id);

        $response->assertStatus(200);
        $this->assertEquals(__('devices.deleted'), $response->json('message'));

    }

    public function test_api_user_can_update_device_by_identifier()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->postJson('/api/devices', [
            'name' => 'test',
            'type' => 'mobile',
            'token' => 'qwertyuiopasdfghjklzxcvbnm',
            'identifier' => 'device-uuid-123',
        ]);

        $response->assertStatus(201);

        $response = $this->actingAs($user)->putJson('/api/devices/identifier/device-uuid-123', [
            'token' => 'updated-token-12345',
        ]);

        $response->assertStatus(200);
        $this->assertEquals(__('devices.updated'), $response->json('message'));
        $this->assertEquals('updated-token-12345', $response['data']['token']);
    }

    public function test_api_user_cannot_update_protected_fields_by_identifier()
    {

        $user = $this->createUser();
        $response = $this->actingAs($user)->postJson('/api/devices', [
            'name' => 'test',
            'type' => 'mobile',
            'token' => 'qwertyuiopasdfghjklzxcvbnm',
            'identifier' => 'device-uuid-456',
            'platform' => 'ios',
        ]);

        $response->assertStatus(201);

        // Try to update protected fields (name, identifier, type, platform) - these should be ignored
        $response = $this->actingAs($user)->putJson('/api/devices/identifier/device-uuid-456', [
            'token' => 'new-token',
            // 'name' => 'updated-name',
            'identifier' => 'new-identifier',
            'type' => 'web',
            'platform' => 'android',
        ]);

        $response->assertStatus(200);

        // Token should be updated
        $this->assertEquals('new-token', $response['data']['token']);

        // Protected fields should remain unchanged (only token and name can be updated)
        // $this->assertEquals('updated-name', $response['data']['name']);
        $this->assertEquals('device-uuid-456', $response['data']['identifier']);
        $this->assertEquals('mobile', $response['data']['type']);
        $this->assertEquals('ios', $response['data']['platform']);
    }

    public function test_api_user_cannot_update_device_by_invalid_identifier()
    {
        $user = $this->createUser();

        // Try to update a non-existent device
        $response = $this->actingAs($user)->putJson('/api/devices/identifier/non-existent-uuid', [
            'token' => 'new-token',
        ]);

        $response->assertStatus(404);
        $this->assertEquals(__('devices.not_found'), $response->json('message'));
    }

    public function test_api_user_cannot_update_another_users_device_by_identifier()
    {
        $user1 = $this->createUser();
        $response = $this->actingAs($user1)->postJson('/api/devices', [
            'name' => 'test',
            'type' => 'mobile',
            'token' => 'qwertyuiopasdfghjklzxcvbnm',
            'identifier' => 'device-uuid-789',
        ]);

        $response->assertStatus(201);

        $user2 = $this->createUser();

        // User2 tries to update User1's device
        $response = $this->actingAs($user2)->putJson('/api/devices/identifier/device-uuid-789', [
            'token' => 'hacked-token',
        ]);

        $response->assertStatus(404);
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(
            workbench_path('database/migrations')
        );
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app)
    {
        return [
            'Whilesmart\UserDevices\UserDevicesServiceProvider',
        ];
    }
}
