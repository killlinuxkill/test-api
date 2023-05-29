<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\{TraitAnyTag, TraitAnyPost, TraitAllRequests};

class PostsRequestTest extends TestCase
{
    use WithFaker, TraitAnyPost, TraitAnyTag, TraitAllRequests;

    public function requestIndex(): void
    {
        $response = $this->getJson('posts');
        $response->assertStatus(200);
    }

    public function requestStore($locale): void
    {
        $response = $this->postJson('posts', [

                "translations"=> [
                    [
                        "language"=> "ru",
                        "title"=>"test RU 1",
                        "description"=>"test 1 test 1 test 1 test 1 test 1",
                        "content"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    ],
                    [
                        "language"=> "en",
                        "title"=>"test EN 1",
                        "description"=>"test 1 test 1 test 1 test 1 test 1",
                        "content"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    ],
                    [
                        "language"=> "ua",
                        "title"=>"test UA 1",
                        "description"=>"test 1 test 1 test 1 test 1 test 1",
                        "content"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    ],
                    [
                        "language"=> "es",
                        "title"=>"test ES 1",
                        "description"=>"test 1 test 1 test 1 test 1 test 1",
                        "content"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    ]
                ],
                "tags" => [["id"=> "3"], ["id"=> 3]]

        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "translations",
                    "created_at",
                    "updated_at",
                    "deleted_at",
                    "tags"
                ]
            ]);
    }

    public function requestShow($locale): void
    {
        $data = $this->getAnyPost();
        $response = $this->getJson('posts/' . $data['id']);
        $response->assertStatus(200)
            ->assertExactJson(['data' => $data]);
    }

    public function requestUpdate($locale): void
    {
        $this->setUpFaker();

        $data = $this->getAnyPost();
        foreach ($data['translations'] as &$item) {
            $item['title'] = $this->faker->name() . ' ' . $item['language'];
        }

        $requestData = $data;
        unset($requestData['id']);
        $response = $this->putJson('posts/' . $data['id'], $requestData);
        $response->assertStatus(200)
            ->assertExactJson(['data' => $data]);
    }

    public function requestDestroy($locale): void
    {
        $data = $this->getAnyPost();
        $response = $this->delete('posts/' . $data['id']);
        $response->assertStatus(200);
    }
}
