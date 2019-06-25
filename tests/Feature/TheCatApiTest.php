<?php

namespace Tests\Feature;

use App\Service\BreedService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TheCatApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/breeds');

        $response->assertStatus(200);
    }

    public function testApiCatService()
    {
        $service = new BreedService();
        $this->assertArrayHasKey('1',$service->getTest());

    }


}
