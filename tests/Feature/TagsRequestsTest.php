<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\{TraitAnyTag, TraitAnyPost, TraitAllRequests};

class TagsRequestsTest extends TestCase
{
    use WithFaker, TraitAnyTag, TraitAllRequests;

    public function requestIndex($locale): void
    {
        $response = $this->getJson('/'.$locale.'/tags');
        $response->assertStatus(200);
    }

    public function requestStore($locale): void
    {
        $this->setUpFaker();
        $name = $this->faker->name();
        $response = $this->postJson('/'.$locale.'/tags', ['name' => $name]);
        $response->assertStatus(200)
        ->assertJsonStructure([
            "data" => [
                "id",
                "name",
                "created_at",
                "updated_at",
                "deleted_at"
            ]
        ]);
    }

    public function requestShow($locale): void
    {
        $data = $this->getAnyTag($locale);
        $response = $this->getJson('/'.$locale.'/tags/' . $data['id']);
        $response->assertStatus(200)
        ->assertJson(['data' => $data]);
    }

    public function requestUpdate($locale): void
    {
        $name = $this->faker->name();
        $data = $this->getAnyTag($locale);
        $data['name'] = $name;
        $response = $this->putJson('/'.$locale.'/tags/' . $data['id'], [
            'name' => $name
        ]);
        $response->assertStatus(200)
        ->assertJson(['data' => $data]);
    }

    public function requestDestroy($locale): void
    {
        $data = $this->getAnyTag($locale);
        $response = $this->deleteJson('/'.$locale.'/tags/' . $data['id']);
        $response->assertStatus(200);
    }
}
