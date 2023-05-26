<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\{TraitAnyTag, TraitAnyPost, TraitAllRequests};

class PostsRequestTest extends TestCase
{
    use WithFaker, TraitAnyPost, TraitAnyTag, TraitAllRequests;

    public function requestIndex($locale): void
    {
        $response = $this->getJson('/'.$locale.'/posts');
        $response->assertStatus(200);
    }

    public function requestStore($locale): void
    {
        $response = $this->postJson('/'.$locale.'/posts', [
            "title" => "Lorem ipsum dolor sit amet",
            "description" => "Lorem ipsum dolor sit amet",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipiscing e.",
            "tags" => [
                ["id" => "1"]
            ]
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "title",
                    "description",
                    "content",
                    "created_at",
                    "updated_at",
                    "deleted_at",
                    "tags"
                ]
            ]);
    }

    public function requestShow($locale): void
    {
        $data = $this->getAnyPost($locale);
        $response = $this->getJson('/'.$locale.'/posts/' . $data['id']);
        $response->assertStatus(200)
            ->assertExactJson(['data' => $data]);
    }

    public function requestUpdate($locale): void
    {
        $data = $this->getAnyPost($locale);
        $data['title'] = 'ddddddddd dddddd';
        $response = $this->putJson('/'.$locale.'/posts/' . $data['id'], $data);
        $response->assertStatus(200)
            ->assertExactJson(['data' => $data]);
    }

    public function requestDestroy($locale): void
    {
        $data = $this->getAnyPost($locale);
        $response = $this->delete('/'.$locale.'/posts/' . $data['id']);
        $response->assertStatus(200);
    }
}
