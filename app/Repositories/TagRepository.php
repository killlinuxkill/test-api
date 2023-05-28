<?php

namespace App\Repositories;

use \Illuminate\Support\Collection;
use App\Models\{Post, PostTranslation, Language, Tag};
use Illuminate\Contracts\Database\Eloquent\Builder;
use \Illuminate\Pagination\LengthAwarePaginator;

class TagRepository extends BaseRepository
{
    /**
     * CREATE New
     */
    public function store(array $attributes): Collection
    {
        $tag = Tag::create([
            'name' => $attributes['name'],
            'language_id' => $this->getLanguage($attributes['language'])->id
        ]);
        return $this->beCollection($tag);
    }

    /**
     * GET One
     */
    public function get(int $id): Collection
    {
        $tag = Tag::where('id', $id)->withTrashed()->first();
        return $this->beCollection($tag);
    }

    /**
     * GET More
     */
    public function getAll(array $attrubutes): LengthAwarePaginator
    {
        $paginate = Tag::withTrashed()
            ->paginate($this->getPerPage());
        $paginate->getCollection()
            ->transform(function ($item) {
                return $this->beCollection($item);
            });
        return $paginate;
    }

    /**
     * UPDATE One
     */
    public function update(int $id, array $attrubutes): Collection
    {
        $tag = Tag::where('id', $id)->withTrashed()->first();
        $tag->name = $attrubutes['name'];
        $tag->save();
        return $this->beCollection($tag);
    }

    /**
     * DELETE One
     */
    public function delete(int $id): Collection
    {
        $tag = Tag::where('id', $id)->first();
        $tag->delete();
        return $this->beCollection($tag);
    }

    public function checkIsAvailable(int $id): bool
    {
        return Tag::where('id', $id)->count();
    }

    public function checkDuplicate(array $attributes): bool
    {
        return Tag::where('name', $attributes['name'])->withTrashed()->count();
    }

    public static function beCollection(\Illuminate\Database\Eloquent\Model $tag): Collection
    {
        return collect([
            'id' => $tag->id,
            'name' => $tag->name,
            'language' => $tag->language->locale,
            'created_at' => (string)$tag->created_at,
            'updated_at' => (string)$tag->updated_at,
            'deleted_at' => (string)$tag->deleted_at
        ]);
    }
}
