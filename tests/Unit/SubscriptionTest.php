<?php


namespace Tests\Unit;

use Tests\TestCase;
class SubscriptionTest extends TestCase
{
    /** @test */
    public function purchase_product(): void
    {
        $defaultToken= '77|XsUfVaMglwap6LY51AvvEAgxmHMK1zpf09ttAZ7F2923086d';
        $user['token'] = $defaultToken;
        $requestData = [
            'productId' => '1',
            'receiptToken' => 'testToken',
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
        ])->post('/api/purchase/product', $requestData);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function purchase_product_not_found(): void
    {
        $defaultToken= '77|XsUfVaMglwap6LY51AvvEAgxmHMK1zpf09ttAZ7F2923086d';
        $user['token'] = $defaultToken;
        $requestData = [
            'productId' => '133',
            'receiptToken' => 'testToken',
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
        ])->post('/api/purchase/product', $requestData);
        $this->assertEquals(400, $response->getStatusCode());
    }

    /** @test */
    public function purchase_device_not_found(): void
    {
        $defaultToken= '77|XMglwap6LY51AvvEAgxmHMK1zpf09ttAZ7F2923086d';
        $user['token'] = $defaultToken;
        $requestData = [
            'productId' => '13',
            'receiptToken' => 'testToken',
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
        ])->post('/api/purchase/product', $requestData);
        $this->assertEquals(401, $response->getStatusCode());
    }
}
