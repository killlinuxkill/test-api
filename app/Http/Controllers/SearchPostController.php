<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostRepository;

class SearchPostController extends Controller
{
    public function repositoryClass(): string
    {
        return PostRepository::class;
    }

    public function byTitle()
    {

    }

    public function byDescription()
    {

    }

    public function byContent()
    {

    }

    public function byAllContents()
    {

    }
}
