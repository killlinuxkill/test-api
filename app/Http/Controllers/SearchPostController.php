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

    /**
     * Search only by title
     */
    public function byTitle(SearchPostRequest $request): PostsResource
    {
        return new PostsResource($this->getRepository()->search($request->input('query'), 'title'));
    }

    /**
     * Search only by description
     */
    public function byDescription(SearchPostRequest $request): PostsResource
    {
        return new PostsResource($this->getRepository()->search($request->input('query'), 'description'));
    }

    /**
     * Search only by content
     */
    public function byContent(SearchPostRequest $request): PostsResource
    {
        return new PostsResource($this->getRepository()->search($request->input('query'), 'content'));
    }

    /**
     * Search by all contents like title, description and content
     */
    public function byAllContents(SearchPostRequest $request): PostsResource
    {
        return new PostsResource($this->getRepository()->search($request->input('query'), 'all'));
    }
}

 /**
 * @api {GET} /search/posts Search Posts by all types
 * @apiVersion 1.0.0
 * @apiGroup Search Posts
 * @apiName Search Posts by all types
 * @apiDescription Search Posts by all types
 * @apiPermission none
 *
 * @apiHeader {String} Accept=application/json
 * @apiHeader {String} Content-Type=application/json
 *
 * @apiParam {String} query search query string
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
 *      },
 *      ...
 *    ]
 * }
 */


 /**
 * @api {GET} /search/posts-by-title Search Posts by title
 * @apiVersion 1.0.0
 * @apiGroup Search Posts
 * @apiName Search Posts by title
 * @apiDescription Search Posts by title
 * @apiPermission none
 *
 * @apiHeader {String} Accept=application/json
 * @apiHeader {String} Content-Type=application/json
 *
 * @apiParam {String} query search query string
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
 *      },
 *      ...
 *    ]
 * }
 */

 /**
 * @api {GET} /search/posts-by-description Search Posts by description
 * @apiVersion 1.0.0
 * @apiGroup Search Posts
 * @apiName Search Posts by description
 * @apiDescription Search Posts by description
 * @apiPermission none
 *
 * @apiHeader {String} Accept=application/json
 * @apiHeader {String} Content-Type=application/json
 *
 * @apiParam {String} query search query string
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
 *      },
 *      ...
 *    ]
 * }
 */

 /**
 * @api {GET} /search/posts-by-content Search Posts by content
 * @apiVersion 1.0.0
 * @apiGroup Search Posts
 * @apiName Search Posts by content
 * @apiDescription Search Posts by content
 * @apiPermission none
 *
 * @apiHeader {String} Accept=application/json
 * @apiHeader {String} Content-Type=application/json
 *
 * @apiParam {String} query search query string
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
 *      },
 *      ...
 *    ]
 * }
 */
