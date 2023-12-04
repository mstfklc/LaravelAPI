<?php


namespace Tests\Unit;

use App\Http\Controllers\AdminController;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /** @test */
    public function register_admin()
    {
        $faker = Faker::create();
        $requestData = [
            'name' => $faker->firstName,
            'email' => $faker->email,
            'password' => $faker->password,
            'is_admin' => true,
        ];

        $request = new Request($requestData);
        $userController = new AdminController();
        $response = $userController->adminRegister($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('token', $response->getData(true));

    }

    /** @test */
    public function register_fail_admin()
    {
        $requestData = [
            'name' => 'TestAdmin',
            'email' => 'admin@test.com',
            'password' => 'password123',
            'is_admin' => true,
        ];

        $request = new Request($requestData);
        $userController = new AdminController();
        $response = $userController->adminRegister($request);
        $this->assertEquals(400, $response->getStatusCode());
    }

    /** @test */
    public function login_admin_user()
    {
        $requestData = [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ];
        $request = new Request($requestData);
        $userController = new AdminController();
        $response = $userController->adminLogin($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('token', $response->getData(true));
    }

    /** @test */
    public function login_fail_admin_password_mismatch()
    {
        $requestData = [
            'email' => 'admin@test.com',
            'password' => 'password13',
        ];

        $request = new Request($requestData);
        $userController = new AdminController();
        $response = $userController->adminLogin($request);
        $this->assertEquals(422, $response->getStatusCode());
    }

    /** @test */
    public function login_fail_admin_not_exist()
    {
        $requestData = [
            'email' => 'admin@tt.com',
            'password' => 'password13',
        ];
        $request = new Request($requestData);
        $userController = new AdminController();
        $response = $userController->adminLogin($request);
        $this->assertEquals(422, $response->getStatusCode());
    }

    /** @test */
    public function list_order_history()
    {
        $defaultToken= '18|6C3Hv0VjDM0pGDEjUPUBsJONRmhGxCRBKiPsHw4wc9f4c212';
        $user['token'] = $defaultToken;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
        ])->get('/api/admin/list-order');
        $response->assertStatus(200);
    }

    /** @test */
    public function list_order_history_unauthorized()
    {
        $defaultToken= '';
        $user['token'] = $defaultToken;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
        ])->get('/api/admin/list-order');
        $response->assertStatus(401);
    }

    /** @test */
    public function list_order_history_forbidden()
    {
        $defaultToken= '39|tHOe7oq8k8NMUIVFIJJlB7GRa7z55sU4U5gYOEAV94d4d784';
        $user['token'] = $defaultToken;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
        ])->get('/api/admin/list-order');
        $response->assertStatus(403);
    }
}
