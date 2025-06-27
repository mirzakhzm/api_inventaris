<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterSuccess()
    {
        $this->post('api/users/register', [
            'username' => 'johndoe',
            'email' => 'johndoe@gmail.com',
            'first_name' => 'johndoe',
            'last_name' => 'kennedy',
            'phone' => '081234567890',
            'role' => 'pegawai',
            'password' => 'securepassword123',
        ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'username' => 'johndoe',
                    'email' => 'johndoe@gmail.com',
                    'first_name' => 'johndoe',
                    'last_name' => 'kennedy',
                    'phone' => '081234567890',
                    'role' => 'pegawai',
                ],
            ]);
    }
    public function testLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        $this->post('api/users/login', [
            'username' => 'testuser',
            'password' => 'testpassword123',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'testuser',
                    'role' => 'pegawai',
                ],
            ]);

        $user = User::where('username', 'testuser')->first();
        self::assertNotNull($user->token);
    }
    public function testLoginFailedUsernameNotFound()
    {
        $this->post('api/users/login', [
            'username' => 'testuser',
            'password' => 'testpassword123',
        ])
            ->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => ['Username or password is incorrect'],
                ],
            ]);
    }
    public function testLoginFailedPasswordWrong()
    {
        $this->seed(UserSeeder::class);
        $this->post('api/users/login', [
            'username' => 'testuser',
            'password' => 'test1234',
        ])
            ->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => ['Username or password is incorrect'],
                ],
            ]);
    }

    public function testGetUserSuccess()
    {
        $this->seed(UserSeeder::class);
        $this->get('api/users/current', [
            'Authorization' => 'test',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'testuser',
                    'email' => 'test@gmail.com',
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'phone' => '081234567890',
                ],
            ]);
    }

    public function testGetUnauthorized()
    {
        $this->seed(UserSeeder::class);
        $this->get('api/users/current', [])
            ->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => ['Unauthorized'],
                ],
            ]);
    }

    public function testGetInvalidToken()
    {
        $this->seed(UserSeeder::class);
        $this->get('api/users/current', [
            'Authorization' => 'salah',
        ])
            ->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => ['Unauthorized'],
                ],
            ]);
    }
    public function testLogoutSuccess()
    {
        $this->seed(UserSeeder::class);
        $this->delete(
            'api/users/logout',
            headers: [
                'Authorization' => 'test',
            ],
        )
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logout successful',
            ]);
    }

    public function testLogoutUnauthorized()
    {
        $this->seed(UserSeeder::class);
        $this->delete('api/users/logout', [], [
            'Authorization' => 'salah',
        ])
            ->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'Unauthorized',
                    ],
                ],
            ]);
    }

    public function testGetUserByIdSuccess()
    {
        $this->seed(UserSeeder::class);
        $user = User::where('username', 'testuser')->first();
        $this->get("api/users/{$user->id}", [
            'Authorization' => 'test',
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'testuser',
                    'email' => 'test@gmail.com',
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'phone' => '081234567890',
                    'role' => 'pegawai',
                ],
            ]);
    }
    public function testUpdateUserSuccess()
    {
        $this->seed(UserSeeder::class);
        $this->put(
            'api/users/update',
            [
                'username' => 'updateduser',
                'email' => 'updatetest@gmail.com',
                'first_name' => 'Test',
                'last_name' => 'User',
                'phone' => '081234567890',
            ],
            [
                'Authorization' => 'test',
            ],
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'updateduser',
                    'email' => 'updatetest@gmail.com',
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'phone' => '081234567890',
                ],
            ]);
    }

    public function testDeleteUserSuccess()
    {
        $this->seed(UserSeeder::class);
        $user = User::where('username', 'testuser')->first();
        $this->delete(
            "api/users/{$user->id}",
            [],
            [
                'Authorization' => 'test',
            ],
        )
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User deleted successfully',
            ]);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function testDeleteUserNotFound()
    {
        $this->seed(UserSeeder::class);
        $user = User::where('username', 'testuser')->first();
        $InvalidUserId = $user->id + 1;
        $response = $this->delete(
            "api/users/{$InvalidUserId}",
            [],
            [
                'Authorization' => 'test',
            ],
        );
        dump($response->json());
        $response->assertStatus(404);
        $response->assertJson([
            'errors' => [
                'message' => 'User not found',
            ],
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }
}
