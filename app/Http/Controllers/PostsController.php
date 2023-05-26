<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Repositories\PostRepository;
use App\Http\Resources\{PostResource, EmptyPostResource};
use App\Http\Requests\{StorePostRequest, SearchPostRequest, UpdatePostRequest};
use Symfony\Component\HttpKernel\Exception\HttpException;

class PostsController extends Controller
{
    public function repositoryClass(): string
    {
        return PostRepository::class;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchPostRequest $request)
    {
        return new PostResource($this->getRepository()->getAll($request->validated()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return new EmptyPostResource([]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        return new PostResource($this->getRepository()->store($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $locale, int $id)
    {
        return new PostResource($this->getRepository()->get($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $locale, int $id)
    {
        if (!$this->getRepository()->checkIsAvailable($id)) {
            throw new HttpException(404, 'Post not found by this ID or is already deleted.');
        }

        return new PostResource($this->getRepository()->update($id, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $locale, int $id)
    {
        if (!$this->getRepository()->checkIsAvailable($id)) {
            throw new HttpException(422, 'Post not found by this ID or is already deleted.');
        }
        return new PostResource($this->getRepository()->delete($id));
    }
}
