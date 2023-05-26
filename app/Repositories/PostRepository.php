<?php

namespace App\Repositories;

use App\Models\{Post, PostTranslation, Language, Tag};
use Illuminate\Contracts\Database\Eloquent\Builder;
use \Illuminate\Pagination\LengthAwarePaginator;
use \Illuminate\Support\Collection;

class PostRepository extends BaseRepository
{
    public function store(array $attrubutes): Collection
    {
        $language = $this->getLanguage();
        // Create Post
        $post = Post::create();

        // Create PostTraslation by currently language
        $post->translations()->create([
            'title' => $attrubutes['title'],
            'description' => $attrubutes['description'],
            'content' => $attrubutes['content'],
            'language_id' => $language->id
        ]);

        // Check and add tags
        if (!empty($attrubutes['tags'])) {
            $attrubutes['tags'] = array_map(function($item){
                return $item['id'];
            }, $attrubutes['tags']);

            $availableTags = Tag::where(['id' => $attrubutes['tags']])->byLanguage($this->getLanguage())->get();
            if (!empty($availableTags)) {
                $post->tags()->delete();
                $post->tags()->saveMany($availableTags);
            }
        }

        return $this->beCollection($post);
    }

    public function get(int $id): Collection
    {
        return $this->beCollection(Post::where('id', $id)->withTrashed()->first());
    }

    public function getAll(array $attrubutes): LengthAwarePaginator
    {
        $paginate = Post::whereHas('translations', $this->scopeByCurrentLanguage())
            ->withTrashed()
            ->paginate($this->getPerPage());
        $paginate->getCollection()
            ->transform(function ($post) {
                return $this->beCollection($post);
            });
        return $paginate;
    }

    public function update(int $id, array $attrubutes): Collection
    {
        $language = $this->getLanguage();
        $post = Post::where(['id' => $id])->withTrashed()->first();

        // Change or add translation
        $translation = $post->translations()->byLanguage($this->getLanguage())->first();
        if (empty($translation)) {
            $post->translations()->create([
                'title' => $attrubutes['title'],
                'description' => $attrubutes['description'],
                'content' => $attrubutes['content'],
                'language_id' => $language->id
            ]);
        } else {
            $translation->fill([
                'title' => $attrubutes['title'],
                'description' => $attrubutes['description'],
                'content' => $attrubutes['content'],
            ]);
            $translation->save();
        }

        // add or remove tags
        if (!empty($attrubutes['tags'])) {
            $attrubutes['tags'] = array_map(function($item){
                return $item['id'];
            }, $attrubutes['tags']);

            $availableTags = Tag::where(['id' => $attrubutes['tags']])->byLanguage($this->getLanguage())->get();
            if (!empty($availableTags)) {
                $post->tags()->delete();
                $post->tags()->saveMany($availableTags);
            }
        }

        return $this->beCollection($post);
    }

    public function delete(int $id): Collection
    {
        $post = Post::where(['id' => $id])->first();
        $post->delete();
        return $this->beCollection($post);
    }

    /**
     * Check if item isset and if it is not deleted
     */
    public function checkIsAvailable(int $id): bool
    {
        return Post::where(['id' => $id])->count();
    }

    public function checkDuplicate(array $attributes): bool
    {
        return false;
    }

    /**
     * Build out collection
     */
    public function beCollection(\Illuminate\Database\Eloquent\Model $post): Collection
    {
        $translation = $post->translations()->byLanguage($this->getLanguage())->first();
        $tags = $post->tags()->byLanguage($this->getLanguage())->get()->toArray();
        return collect([
            'id' => $post->id,
            'title' => $translation->title,
            'description' => $translation->description,
            'content' => $translation->content,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'deleted_at' => $post->deleted_at,
            'tags' => $tags
        ]);
    }
}
