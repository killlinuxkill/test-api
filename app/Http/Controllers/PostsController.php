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
    public function show(int $id)
    {
        return new PostResource($this->getRepository()->get($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, int $id)
    {
        if (!$this->getRepository()->checkIsAvailable($id)) {
            throw new HttpException(404, 'Post not found by this ID or is already deleted.');
        }

        return new PostResource($this->getRepository()->update($id, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if (!$this->getRepository()->checkIsAvailable($id)) {
            throw new HttpException(422, 'Post not found by this ID or is already deleted.');
        }
        return new PostResource($this->getRepository()->delete($id));
    }
}

 /**
 * @api {GET} /posts List All Posts
 * @apiVersion 1.0.0
 * @apiGroup Post
 * @apiName List All Posts
 * @apiDescription List All Posts
 * @apiPermission none
 *
 * @apiHeader {String} Accept=application/json
 * @apiHeader {String} Content-Type=application/json
 *
 * @apiParam {Number} [page] page number
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *     "data": [
 *        {
 *           "id": 5,
 *           "translations": [
 *              {
 *                  "title": "test 1",
 *                  "description": "test 1 test 1 test 1 test 1 test 1",
 *                  "content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
 *                  "language":ua
 *              },
 *           ],
 *           "created_at": "2023-05-26T14:00:27.000000Z",
 *           "updated_at": "2023-05-26T14:00:33.000000Z",
 *           "deleted_at": "2023-05-26T14:00:33.000000Z",
 *           "tags": []
 *         }
 *      ]
 * }
 */

 /**
 * @api {GET} /posts/{id} Show One Post
 * @apiVersion 1.0.0
 * @apiGroup Post
 * @apiName Show One Post
 * @apiDescription Show One Post
 * @apiPermission none
 *
 * @apiHeader {String} Accept=application/json
 * @apiHeader {String} Content-Type=application/json
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *     "data":{
 *           "id": 5,
 *           "translations": [
 *              {
 *                  "title": "test 1",
 *                  "description": "test 1 test 1 test 1 test 1 test 1",
 *                  "content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
 *                  "language":ua
 *              },
 *           ],
 *           "created_at": "2023-05-26T14:00:27.000000Z",
 *           "updated_at": "2023-05-26T14:00:33.000000Z",
 *           "deleted_at": "2023-05-26T14:00:33.000000Z",
 *           "tags": []
 *         }
 * }
 */

 /**
 * @api {POST} /posts Create One Post
 * @apiVersion 1.0.0
 * @apiGroup Post
 * @apiName Create One Post
 * @apiDescription Create One Post
 * @apiPermission none
 *
 * @apiHeader {String} Accept=application/json
 * @apiHeader {String} Content-Type=application/json
 *
 * @apiParam {Array} translitions
 * @apiParam {String} translitions.0.title min:5|max:255
 * @apiParam {String} translitions.0.description min:10|max:500
 * @apiParam {String} translitions.0.content
 * @apiParam {String} translitions.0.language min:1|max:2
 * @apiParam {Array} tags
 * @apiParam {Number} tags.0.id
 * @apiParam {String} tags.0.name
 *
 * @apiParamExample {json} Request-Example:
 * {
 *       "translations": [
 *              {
 *                  "title": "test 1",
 *                  "description": "test 1 test 1 test 1 test 1 test 1",
 *                  "content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
 *                  "language":ua
 *              },
 *           ],
 *       "tags": [
 *          {"id": "1", "name": "name"},
 *          {"id": "2", "name": "name"}
 *          ...
 *      ]
 * }
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *     "data":{
 *           "id": 5,
 *           "translations": [
 *              {
 *                  "title": "test 1",
 *                  "description": "test 1 test 1 test 1 test 1 test 1",
 *                  "content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
 *                  "language":ua
 *              },
 *           ],
 *           "created_at": "2023-05-26T14:00:27.000000Z",
 *           "updated_at": "2023-05-26T14:00:33.000000Z",
 *           "deleted_at": "2023-05-26T14:00:33.000000Z",
 *           "tags": []
 *         }
 * }
 */

 /**
 * @api {PUT} /posts/{id} Update One Post
 * @apiVersion 1.0.0
 * @apiGroup Post
 * @apiName Update One Post
 * @apiDescription Update One Post
 * @apiPermission none
 *
 * @apiHeader {String} Accept=application/json
 * @apiHeader {String} Content-Type=application/json
 *
 * @apiParam {Array} translitions
 * @apiParam {String} translitions.0.title min:5|max:255
 * @apiParam {String} translitions.0.description min:10|max:500
 * @apiParam {String} translitions.0.content
 * @apiParam {String} translitions.0.language min:1|max:2
 * @apiParam {Array} tags
 * @apiParam {Number} tags[].id
 * @apiParam {String} tags[].name
 *
 * @apiParamExample {json} Request-Example:
 * {
 *       "translations": [
 *              {
 *                  "title": "test 1",
 *                  "description": "test 1 test 1 test 1 test 1 test 1",
 *                  "content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
 *                  "language":ua
 *              },
 *       ],
 *      "tags": [
 *          {"id": "1", "name": "name"},
 *          {"id": "2", "name": "name"}
 *          ...
 *      ]
 * }
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *     "data":{
 *           "id": 5,
 *           "translations": [
 *              {
 *                  "title": "test 1",
 *                  "description": "test 1 test 1 test 1 test 1 test 1",
 *                  "content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
 *                  "language":ua
 *              },
 *           ],
 *           "created_at": "2023-05-26T14:00:27.000000Z",
 *           "updated_at": "2023-05-26T14:00:33.000000Z",
 *           "deleted_at": "2023-05-26T14:00:33.000000Z",
 *           "tags": []
 *         }
 * }
 */

/**
 * @api {DELETE} /posts/{id} Delete One Post
 * @apiVersion 1.0.0
 * @apiGroup Post
 * @apiName Delete One Post
 * @apiDescription Delete One Post
 * @apiPermission none
 *
 * @apiHeader {String} Accept=application/json
 * @apiHeader {String} Content-Type=application/json
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *     "data":{
 *           "id": 5,
 *           "translations": [
 *              {
 *                  "title": "test 1",
 *                  "description": "test 1 test 1 test 1 test 1 test 1",
 *                  "content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
 *                  "language":ua
 *              },
 *           ],
 *           "created_at": "2023-05-26T14:00:27.000000Z",
 *           "updated_at": "2023-05-26T14:00:33.000000Z",
 *           "deleted_at": "2023-05-26T14:00:33.000000Z",
 *           "tags": []
 *         }
 * }
 */


