<?php

namespace App\Repositories;

use App\Models\{Post, PostTranslation, Language, Tag};
use Illuminate\Contracts\Database\Eloquent\Builder;
use \Illuminate\Pagination\LengthAwarePaginator;
use \Illuminate\Support\Collection;

class PostRepository extends BaseRepository
{
    /**
     * Prepare list of translites
     */
    public function prepareTranslations(array $listAttributes): array
    {
        $languages = $this->getLanguages();

        //filter by available languages
        $listAttributes = array_filter($listAttributes, function($item) use ($languages){
            return array_key_exists($item['language'], $languages);
        });
        if (empty($listAttributes)) {
            return [];
        }

        // Prepare language for each items
        $listAttributes = array_map(function($item) use ($languages) {
            $item['language_id'] = $languages[$item['language']]->id;
            unset($item['language']);
            return $item;
        }, $listAttributes);

        return $listAttributes;
    }

    /**
     * CREATE New Post
     */
    public function store(array $attrubutes): Collection
    {
        // Create Post
        $post = Post::create();

        if (!empty($attrubutes['translations'])) {
            $attrubutes['translations'] = $this->prepareTranslations($attrubutes['translations']);
        }

        $post->translations()->createMany($attrubutes['translations']);

        // Check and add tags
        if (!empty($attrubutes['tags'])) {
            $attrubutes['tags'] = array_map(function($item){
                return $item['id'];
            }, $attrubutes['tags']);

            $attrubutes['tags'] = array_unique($attrubutes['tags']);

            $availableTags = Tag::whereIn('id', $attrubutes['tags'])->get();

            if (!empty($availableTags)) {
                $post->tags()->saveMany($availableTags);
            }
        }

        return $this->beCollection($post);
    }

    /**
     * GET One
     */
    public function get(int $id): Collection
    {
        return $this->beCollection(Post::where('id', $id)->withTrashed()->first());
    }

    /**
     * GET More
     */
    public function getAll(array $attrubutes): LengthAwarePaginator
    {
        $paginate = Post::withTrashed()
            ->paginate($this->getPerPage());
        $paginate->getCollection()
            ->transform(function ($post) {
                return $this->beCollection($post);
            });
        return $paginate;
    }

    /**
     * UPDATE One
     */
    public function update(int $id, array $attrubutes): Collection
    {
        $post = Post::where(['id' => $id])->withTrashed()->first();

        // Prepare translations
        if (!empty($attrubutes['translations'])) {
            $attrubutes['translations'] = $this->prepareTranslations($attrubutes['translations']);
        }

        // Change or add translation
        $translations = $post->translations;
        if (!empty($translations)) {
            $post->translations()->delete();
        }
        $post->translations()->createMany($attrubutes['translations']);

        // add or remove tags
        if (!empty($attrubutes['tags'])) {
            $attrubutes['tags'] = array_map(function($item){
                return $item['id'];
            }, $attrubutes['tags']);

            $availableTags = Tag::where(['id' => $attrubutes['tags']])->get();
            if (!empty($availableTags)) {
                $post->tags()->delete();
                $post->tags()->saveMany($availableTags);
            }
        }

        $post->refresh();

        return $this->beCollection($post);
    }

    /**
     * DELETE One
     */
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
    public static function beCollection(\Illuminate\Database\Eloquent\Model $post): Collection
    {
        $translations = $post->translations->transform(function ($item) {
            return [
                'title' => $item->title,
                'description' => $item->description,
                'content' => $item->content,
                'language' => $item->language->locale
            ];
        })->toArray();

        $tags = $post->tags->toArray();
        return collect([
            'id' => $post->id,
            'translations' => $translations,
            'created_at' => (string)$post->created_at,
            'updated_at' => (string)$post->updated_at,
            'deleted_at' => (string)$post->deleted_at,
            'tags' => $tags
        ]);
    }
}
