<?php

namespace Tests\Feature;

use App\Models\{Tag, Language};

trait TraitAnyTag
{
    public function getAnyTag($locale)
    {
        $language = Language::where(['locale' => $locale])->first();
        $tag = Tag::where(['language_id' => $language->id])->first();

        $out = \App\Repositories\TagRepository::beCollection($tag)->toArray();
        unset($out['updated_at']);
        return $out;
    }
}
