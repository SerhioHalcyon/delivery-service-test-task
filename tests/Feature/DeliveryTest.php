<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DeliveryTest extends TestCase
{
    public function test_success_request(): void
    {
        Http::fake([
            'novaposhta.test/*' => Http::response(
                ['success' => 'true'],
                200,
                ['Headers']
            ),
        ]);

        $data = [
            'parcel' => [
                'title' => fake()->word(),
                'length' => fake()->randomFloat(2, 10, 50),
                'width' => fake()->randomFloat(2, 10, 50),
                'height' => fake()->randomFloat(2, 10, 50),
                'weight' => fake()->randomFloat(2, 10, 50),
            ],
            'user' => [
                'name' => fake()->name(),
                'phone' => fake()->phoneNumber(),
                'email' => fake()->email(),
                'address' => fake()->address(),
            ],
        ];

        $response = $this->post('/delivery', $data);

        $response->assertStatus(200);
    }

    public function test_fail_request(): void
    {
        Http::fake([
            'novaposhta.test/*' => Http::response(
                ['success' => 'false'],
                500,
                ['Headers']
            ),
        ]);

        $data = [
            'parcel' => [
                'title' => fake()->word(),
                'length' => fake()->randomFloat(2, 10, 50),
                'width' => fake()->randomFloat(2, 10, 50),
                'height' => fake()->randomFloat(2, 10, 50),
                'weight' => fake()->randomFloat(2, 10, 50),
            ],
            'user' => [
                'name' => fake()->name(),
                'phone' => fake()->phoneNumber(),
                'email' => fake()->email(),
                'address' => fake()->address(),
            ],
        ];

        $response = $this->post('/delivery', $data);

        $response->assertStatus(200);
    }
}
