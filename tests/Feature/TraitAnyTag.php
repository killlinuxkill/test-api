<?php

namespace Tests\Feature;

use App\Models\{Tag, Language};

trait TraitAnyTag
{
    public function getAnyTag($locale)
    {
        $language = Language::where(['locale' => $locale])->first();
        $tag = Tag::where(['language_id' => $language->id])->first()->toArray();

        return [
            'id' => $tag['id'],
            'name' => $tag['name'],
            'created_at' => $tag['created_at'],
            //'updated_at' => $tag['updated_at'],
            'deleted_at' => $tag['deleted_at']
        ];
    }
}
