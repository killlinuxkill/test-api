<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostRepository;
use App\Http\Requests\SearchPostRequest;
use App\Http\Resources\PostsResource;

class SearchPostController extends Controller
{
    public function repositoryClass(): string
    {
        return PostRepository::class;
    }

    public function byTitle(SearchPostRequest $request)
    {
        return new PostsResource($this->getRepository()->search($request->input('query'), 'title'));
    }

    public function byDescription(SearchPostRequest $request)
    {
        return new PostsResource($this->getRepository()->search($request->input('query'), 'description'));
    }

    public function byContent(SearchPostRequest $request)
    {
        return new PostsResource($this->getRepository()->search($request->input('query'), 'content'));
    }

    public function byAllContents(SearchPostRequest $request)
    {
        return new PostsResource($this->getRepository()->search($request->input('query'), 'all'));
    }
}
