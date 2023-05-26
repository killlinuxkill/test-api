<?php

namespace Tests\Feature;

use App\Models\{Post, Language};

trait TraitAnyPost
{
    public function getAnyPost($locale)
    {
        $language = Language::where(['locale' => $locale])->first();
        $post = Post::whereHas('translations', function($query) use ($language){
            $query->byLanguage($language);
        })->first();

        $translation = $post->translations()->byLanguage($language)->first()->toArray();
        $tags = $post->tags()->byLanguage($language)->get()->toArray();

        $post = $post->toArray();
        return [
            'id' => $post['id'],
            'title' => $translation['title'],
            'description' => $translation['description'],
            'content' => $translation['content'],
            'created_at' => $post['created_at'],
            'updated_at' => $post['updated_at'],
            'deleted_at' => $post['deleted_at'],
            'tags' => $tags
        ];
    }
}
