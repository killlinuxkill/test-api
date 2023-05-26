<?php

namespace App\Repositories;

use \Illuminate\Support\Collection;
use App\Models\{Post, PostTranslation, Language, Tag};
use Illuminate\Contracts\Database\Eloquent\Builder;
use \Illuminate\Pagination\LengthAwarePaginator;

class TagRepository extends BaseRepository
{
    public function store(array $attributes): Collection
    {
        $tag = Tag::create([
            'name' => $attributes['name'],
            'language_id' => $this->getLanguage()->id
        ]);
        return $this->beCollection($tag);
    }

    public function get(int $id): Collection
    {
        $tag = Tag::where('id', $id)->withTrashed()->byLanguage($this->getLanguage())->first();
        return $this->beCollection($tag);
    }

    public function getAll(array $attrubutes): LengthAwarePaginator
    {
        $paginate = Tag::byLanguage($this->getLanguage())->withTrashed()
            ->paginate($this->getPerPage());
        $paginate->getCollection()
            ->transform(function ($item) {
                return $this->beCollection($item);
            });
        return $paginate;
    }

    public function update(int $id, array $attrubutes): Collection
    {
        $tag = Tag::where('id', $id)->withTrashed()->first();
        $tag->name = $attrubutes['name'];
        $tag->save();
        return $this->beCollection($tag);
    }

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
        return Tag::where('name', $attributes['name'])->withTrashed()->byLanguage($this->getLanguage())->count();
    }

    public function beCollection(\Illuminate\Database\Eloquent\Model $tag): Collection
    {
        return collect([
            'id' => $tag->id,
            'name' => $tag->name,
            'created_at' => $tag->created_at,
            'updated_at' => $tag->updated_at,
            'deleted_at' => $tag->deleted_at
        ]);
    }
}
