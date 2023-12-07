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
        $this->assertEquals(302, $response->getStatusCode());
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
}
