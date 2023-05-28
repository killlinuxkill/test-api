<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmptyPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'translations' => [
                [
                    'title' => '',
                    'description' => '',
                    'content' => '',
                    'language' => ''
                ]
            ],
            'tags' => [],
            'created_at' => '',
            'updated_at' => '',
            'deleted_at' => '',
        ];
    }
}
