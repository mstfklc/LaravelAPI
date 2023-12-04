<?php


namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
class DeviceTest extends TestCase
{
    /** @test */
    public function login_new_device()
    {
        $response = $this->post('/api/device/login');
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function login_device()
    {
        $requestData = ['uuid' => '837645ce-bdd4-47f0-8287-feca6549220b'];
        $request = new Request();
        $request->json()->add($requestData);
        $response = $this->post('/api/device/login', $requestData);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function login_device_not_found1()
    {
        $requestData = ['uuid' => 'ec903a48-48aa-abe2-ccbf6de0f0a6'];
        $request = new Request();
        $request->json()->add($requestData);
        $response = $this->post('/api/device/login', $requestData);
        $this->assertEquals(404, $response->getStatusCode());
    }

}
