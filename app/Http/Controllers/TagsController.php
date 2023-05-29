<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TagRepository;
use App\Http\Resources\{TagResource, EmptyTagResource};
use App\Http\Requests\{StoreTagRequest, ListTagRequest, UpdateTagRequest};
use Symfony\Component\HttpKernel\Exception\HttpException;

class TagsController extends Controller
{
    public function repositoryClass(): string
    {
        return TagRepository::class;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListTagRequest $request)
    {
        return new TagResource($this->getRepository()->getAll($request->validated()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return new EmptyTagResource([]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        if($this->getRepository()->checkDuplicate($request->validated()))
        {
            throw new HttpException(422, 'Tag with this name in this location alreade exists.');
        }

        return new TagResource($this->getRepository()->store($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return new TagResource($this->getRepository()->get($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, int $id)
    {
        if (!$this->getRepository()->checkIsAvailable($id)
        || $this->getRepository()->checkDuplicate($request->validated())) {
            throw new HttpException(404, 'Tag not found by this ID, is already deleted or the tame already exists.');
        }

        return new TagResource($this->getRepository()->update($id, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if (!$this->getRepository()->checkIsAvailable($id)) {
            throw new HttpException(422, 'Tag not found by this ID or is already deleted.');
        }
        return new TagResource($this->getRepository()->delete($id));
    }
}

 /**
 * @api {GET} /tags List All Tags
 * @apiVersion 1.0.0
 * @apiGroup Tags
 * @apiName List All Tags
 * @apiDescription List All Tags
 * @apiPermission none
 *
 * @apiHeader {String} Accept=application/json
 * @apiHeader {String} Content-Type=application/json
 *
 * @apiParam {Number} [page] page number
 * @apiParam {String} language min:1|max:2
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *     "data": [
 *        {
 *           "id": 5,
 *           "name": "test",
 *           "language":"",
 *           "created_at": "2023-05-26T14:00:27.000000Z",
 *           "updated_at": "2023-05-26T14:00:33.000000Z",
 *           "deleted_at": "2023-05-26T14:00:33.000000Z",
 *         }
 *      ]
 * }
 */

 /**
 * @api {GET} /tags/{id} Show One Tags
 * @apiVersion 1.0.0
 * @apiGroup Tags
 * @apiName Show One Tags
 * @apiDescription Show One Tags
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
 *           "name": "test",
 *           "language":"",
 *           "created_at": "2023-05-26T14:00:27.000000Z",
 *           "updated_at": "2023-05-26T14:00:33.000000Z",
 *           "deleted_at": "2023-05-26T14:00:33.000000Z",
 *         }
 * }
 */

 /**
 * @api {POST} /tags Create One Tag
 * @apiVersion 1.0.0
 * @apiGroup Tags
 * @apiName Create One Tag
 * @apiDescription Create One Tag
 * @apiPermission none
 *
 * @apiHeader {String} Accept=application/json
 * @apiHeader {String} Content-Type=application/json
 *
 * @apiParam {String} name min:1|max:32
 * @apiParam {String} language min:1|max:2
 *
 * @apiParamExample {json} Request-Example:
 * {
 *      "name": "string",
 *      "language":"",
 * }
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *     "data":{
 *           "id": 5,
 *           "name": "test",
 *           "language":"",
 *           "created_at": "2023-05-26T14:00:27.000000Z",
 *           "updated_at": "2023-05-26T14:00:33.000000Z",
 *           "deleted_at": "2023-05-26T14:00:33.000000Z",
 *         }
 * }
 */

 /**
 * @api {PUT} /tags/{id} Update One Tag
 * @apiVersion 1.0.0
 * @apiGroup Tags
 * @apiName Update One Tag
 * @apiDescription Update One Tag
 * @apiPermission none
 *
 * @apiHeader {String} Accept=application/json
 * @apiHeader {String} Content-Type=application/json
 *
 * @apiParam {String} name min:1|max:32
 * @apiParam {String} language min:1|max:2
 *
 * @apiParamExample {json} Request-Example:
 * {
 *      "name": "string",
 *      "language":"",
 * }
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *     "data":{
 *           "id": 5,
 *           "name": "test",
 *           "language":"",
 *           "created_at": "2023-05-26T14:00:27.000000Z",
 *           "updated_at": "2023-05-26T14:00:33.000000Z",
 *           "deleted_at": "2023-05-26T14:00:33.000000Z",
 *         }
 * }
 */

/**
 * @api {DELETE} /tags/{id} Delete One Tag
 * @apiVersion 1.0.0
 * @apiGroup Tags
 * @apiName Delete One Tag
 * @apiDescription Delete One Tag
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
 *           "name": "test",
 *           "language":"",
 *           "created_at": "2023-05-26T14:00:27.000000Z",
 *           "updated_at": "2023-05-26T14:00:33.000000Z",
 *           "deleted_at": "2023-05-26T14:00:33.000000Z",
 *         }
 * }
 */
