<?php

namespace Tests\Unit;

use App\Breed;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BreedTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testCreateBreed()
    {
        $breed = factory(Breed::class)->create();
        $this->assertDatabaseHas('breeds', [
            'name' => $breed->name
        ]);
    }

    public function testShowBreed()
    {
        $breed = factory(Breed::class)->create();

        $this->get('/breeds/' . $breed->id)
            ->assertStatus(404);
    }
}
