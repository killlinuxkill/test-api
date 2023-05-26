<?php

namespace App\Http\Controllers;

use App\Repositories\BaseRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $repository = null;

    /**
     * All children must have own repository
     */
    abstract public function repositoryClass(): string;

    /**
     * Init and Get
     */
    public function getRepository(): BaseRepository
    {
        if (is_null($this->repository)) {
            $this->repository = new ($this->repositoryClass())(App::currentLocale());
        }
        return $this->repository;
    }
}
