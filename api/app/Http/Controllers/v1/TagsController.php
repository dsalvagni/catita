<?php

namespace App\Http\Controllers\v1;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TagsController extends \App\Http\Controllers\Controller
{
    protected $validation = [
        'description' => 'required',
        'started_at' => 'datetime',
        'finished_at' => 'datetime'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Tag $tag)
    {

        $this->middleware('auth');
        $this->tag = $tag;
        $this->user = Auth::user();
    }
   /**
    * List all user's tag
    * @param Request $request
    * @return Response
    *
    * @api {get} /tags Request all user's tags
    * @apiVersion 0.0.1
    * @apiName GetTags
    * @apiGroup Tags
    *
    * @apiSuccess {Integer} id           Tag's id
    * @apiSuccess {String}  description  Tag's description
    * @apiSuccess {Integer} user_id      User's id
    * @apiSuccess {String}  created_at   Tag created time
    * @apiSuccess {String}  updated_at   Tag updated time
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     [{
    *       "id": 1,
    *       "user_id": 1,
    *       "description": "Lorem ipsum dolor sit amet",
    *       "created_at": "2016-08-01 13:59:59",
    *       "updated_at": "2016-08-02 13:59:59"
    *     },
    *     {
    *       "id": 2,       
    *       "user_id": 1,
    *       "description": "Ipsum dolor sit amet",
    *       "created_at": "2016-08-01 13:59:59",
    *       "updated_at": "2016-08-02 13:59:59"
    *     },
    *     ...]
    */
    public function index(Request $request)
    {
        return response($request->user()->tags);
    }

    /**
    * Show a tag by a given id
    * @param integer $id
    * @return Response
    *
    * @api {get} /tags/:id Request a tag
    * @apiVersion 0.0.1
    * @apiParam {Integer} id Tag's unique ID.
    * @apiName GetTag
    * @apiGroup Tags
    *
    * @apiSuccess {Integer} id           Tag's id
    * @apiSuccess {String}  description  Tag's description
    * @apiSuccess {Integer} user_id      User's id
    * @apiSuccess {String}  created_at   Tag created time
    * @apiSuccess {String}  updated_at   Tag updated time
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       "id": 1,
    *       "user_id": 1,
    *       "description": "Lorem ipsum dolor sit amet",
    *       "created_at": "2016-08-01 13:59:59",
    *       "updated_at": "2016-08-02 13:59:59"
    *     }
    *
    * @apiError TagNotFound The <code>id</code> of the Tag was not found.
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 404 Not Found
    *
    * @apiError Forbidden The <code>id</code> of the Tag wasn't related to the requester
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 403 Forbidden
    */
    public function show($id)
    {
        $tag = $this->tag->find($id);

        if (Gate::denies('show', $tag)) {
            return response('', Response::HTTP_FORBIDDEN);
        }

        if (!$tag) {
            return response('', Response::HTTP_NOT_FOUND);
        }
        return response($tag);
    }

    /**
    * Delete a tag from the database
    * @param Request $request
    * @param $id
    * @return Response
    *
    * @api {delete} /tags/:id Delete a tag
    * @apiVersion 0.0.1
    * @apiParam {Integer} id Tag's unique ID.
    * @apiName DeleteTag
    * @apiGroup Tags
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 204 OK
    *
    * @apiError TagNotFound The <code>id</code> of the Tag was not found.
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 404 Not Found
    *
    * @apiError Forbidden The <code>id</code> of the Tag wasn't related to the requester
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 403 Forbidden
    */
    public function destroy(Request $request, $id)
    {
        $tag = $this->tag->find($id);

        if(!$tag) {
            return response('', Response::HTTP_NOT_FOUND);
        }

        if (Gate::denies('destroy', $tag)) {
            return response('', Response::HTTP_FORBIDDEN);
        }

        $tag->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
    * Update a given tag
    * @param Request $request
    * @param $id
    * @return Response
    *
    * @api {put} /tags/:id Update a tag 
    * @apiVersion 0.0.1   
    * @apiParam {Integer} id             Tag's unique ID.
    * @apiParam {String}  description    Tag's description
    * @apiParam {Integer} user_id        User's id
    * @apiParam {String}  created_at     Tag created time
    * @apiParam {String}  updated_at     Tag updated time
    *
    * @apiName UpdateTag
    * @apiGroup Tags
    * 
    * @apiSuccess {Integer} id           Tag's id
    * @apiSuccess {String}  description  Tag's description
    * @apiSuccess {Integer} user_id      User's id
    * @apiSuccess {String}  created_at   Tag created time
    * @apiSuccess {String}  updated_at   Tag updated time
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       "id": 1,
    *       "user_id": 1,
    *       "description": "Lorem ipsum dolor sit amet",
    *       "created_at": "2016-08-01 13:59:59",
    *       "updated_at": "2016-08-02 13:59:59"
    *     }
    *
    * @apiError TagNotFound The <code>id</code> of the Tag was not found.
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 404 Not Found
    *
    * @apiError Forbidden The <code>id</code> of the Tag wasn't related to the requester
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 403 Forbidden
    */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validation);
        $tag = $this->tag->find($id);

        if(!$tag) {
            return response('', Response::HTTP_NOT_FOUND);
        }

        if (Gate::denies('update', $tag)) {
            return response('', Response::HTTP_FORBIDDEN);
        }

        $input = $request->all();
        $tag->update($input);

        return response($tag);
    }

    /**
    * Create new tag
    * @param Request $request
    * @return Response
    * @api {post} /tags Create a tag
    * @apiVersion 0.0.1
    *
    * @apiParam {String}  description    Tag's description
    * @apiParam {Integer} user_id        User's id
    * @apiParam {String}  created_at     Tag created time
    * @apiParam {String}  updated_at     Tag updated time
    *
    * @apiName CreateTag
    * @apiGroup Tags
    * 
    * @apiSuccess {Integer} id           Tag's id
    * @apiSuccess {String}  description  Tag's description
    * @apiSuccess {Integer} user_id      User's id
    * @apiSuccess {String}  created_at   Tag created time
    * @apiSuccess {String}  updated_at   Tag updated time
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       "id": 1,
    *       "user_id": 1,
    *       "description": "Lorem ipsum dolor sit amet",
    *       "created_at": "2016-08-01 13:59:59",
    *       "updated_at": "2016-08-02 13:59:59"
    *     }
    *
    */
    public function create(Request $request)
    {

        $this->validate($request, $this->validation);

        $input = $request->all();
        $model = $this->user->tags()->save(new Tag($input));
        return response($model, Response::HTTP_CREATED);
    }
}
