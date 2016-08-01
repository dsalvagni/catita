<?php

namespace App\Http\Controllers\v1;

use App\Models\Worklog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class WorklogsController extends \App\Http\Controllers\Controller
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
    public function __construct(Worklog $workLog)
    {

        $this->middleware('auth');
        $this->workLog = $workLog;
        $this->user = Auth::user();
    }

    /**
    * Return all work logs
    * @return Response
    *
    * @api {get} /worklogs Request all user's worklogs
    * @apiName GetWorklogs
    * @apiGroup Worklogs
    *
    * @apiSuccess {Integer} id           Worklog's id
    * @apiSuccess {String}  description  Worklog's description
    * @apiSuccess {Integer} user_id      User's id
    * @apiSuccess {String}  created_at   Worklog's created time
    * @apiSuccess {String}  updated_at   Worklog's updated time
    * @apiSuccess {String}  started_at   Worklog's started time
    * @apiSuccess {String}  finished_at  Worklog's finished time
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     [{
    *       "id": 1,
    *       "user_id": 1,
    *       "description": "Lorem ipsum dolor sit amet",
    *       "created_at": "2016-08-01 13:59:59",
    *       "updated_at": "2016-08-02 13:59:59",
    *       "started_at": "2016-08-01 13:59:59",
    *       "finished_at": "2016-08-01 13:59:59"
    *     },
    *     {
    *       "id": 2,
    *       "user_id": 1,
    *       "description": "Ipsum dolor sit amet",
    *       "created_at": "2016-08-01 13:59:59",
    *       "updated_at": "2016-08-02 13:59:59",
    *       "started_at": "2016-08-01 13:59:59",
    *       "finished_at": "2016-08-01 13:59:59"
    *     },
    *     ...]
    */
    public function index(Request $request)
    {
        return response($request->user()->workLogs);
    }

    /**
    * Return a worklog
    * @param $id worklog id
    * @return Response
    * 
    * @api {get} /worklogs/:id Request all user's worklogs
    * @apiVersion 0.0.1
    *    
    * @apiParam {Integer} id Worklog's unique ID.
    * @apiName GetWorklog
    * @apiGroup Worklogs
    *
    * @apiSuccess {Integer} id           Worklog's id
    * @apiSuccess {String}  description  Worklog's description
    * @apiSuccess {Integer} user_id      User's id
    * @apiSuccess {String}  created_at   Worklog's created time
    * @apiSuccess {String}  updated_at   Worklog's updated time
    * @apiSuccess {String}  started_at   Worklog's started time
    * @apiSuccess {String}  finished_at  Worklog's finished time
    * @apiSuccess {Tag[]}   tags         Related worklog's tags
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       "id": 1,
    *       "user_id": 1,
    *       "description": "Lorem ipsum dolor sit amet",
    *       "created_at": "2016-08-01 13:59:59",
    *       "updated_at": "2016-08-02 13:59:59",
    *       "started_at": "2016-08-01 13:59:59",
    *       "finished_at": "2016-08-01 13:59:59",
    *       "tags": [{Tag}]
    *     }
    *
    * @apiError WorkLogNotFound The <code>id</code> of the Worklog was not found.
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 404 Not Found
    *
    * @apiError Forbidden The <code>id</code> of the Worklog wasn't related to the requester
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 403 Forbidden
    */
    public function show($id)
    {
        $workLog = $this->workLog->find($id);

        if (Gate::denies('show', $workLog)) {
            return response('', Response::HTTP_FORBIDDEN);
        }

        if (!$workLog) {
            return response('', Response::HTTP_NOT_FOUND);
        }
        return response($workLog->load('tags'));
    }

    /**
    * Delete a worklog from the database
    * @param Request $request
    * @param $id
    * @return Response
    *
    * @api {delete} /worklogs/:id Delete a worklog
    * @apiVersion 0.0.1
    *
    * @apiParam {Integer} id Worklog's unique ID.
    * @apiName DeleteWorklog
    * @apiGroup Worklogs
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 204 OK
    *
    * @apiError WorklogNotFound The <code>id</code> of the Worklog was not found.
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 404 Not Found
    *
    * @apiError Forbidden The <code>id</code> of the Worklog wasn't related to the requester
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 403 Forbidden
    */
    public function destroy(Request $request, $id)
    {
        $workLog = $this->workLog->find($id);

        if(!$workLog) {
            return response('', Response::HTTP_NOT_FOUND);
        }

        if (Gate::denies('destroy', $workLog)) {
            return response('', Response::HTTP_FORBIDDEN);
        }

        $workLog->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
    * Update a given worklog
    * @param Request $request
    * @param $id
    * @return Response
    *
    * @api {put} /worklogs/:id Update a worklog   
    * @apiVersion 0.0.1 
    * @apiParam {Integer} id Worklog's unique ID.
    * @apiName UpdateWorklog
    * @apiGroup Worklogs
    * 
    * @apiSuccess {Integer} id           Worklog's id
    * @apiSuccess {String}  description  Worklog's description
    * @apiSuccess {Integer} user_id      User's id
    * @apiSuccess {String}  created_at   Worklog's created time
    * @apiSuccess {String}  updated_at   Worklog's updated time
    * @apiSuccess {String}  started_at   Worklog's started time
    * @apiSuccess {String}  finished_at  Worklog's finished time
    * @apiSuccess {Tag[]}   tags         Related worklog's tags
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       "id": 1,
    *       "user_id": 1,
    *       "description": "Lorem ipsum dolor sit amet",
    *       "created_at": "2016-08-01 13:59:59",
    *       "updated_at": "2016-08-02 13:59:59",
    *       "started_at": "2016-08-01 13:59:59",
    *       "finished_at": "2016-08-01 13:59:59",
    *       "tags": [{Tag}]
    *     }
    *
    * @apiError WorklogNotFound The <code>id</code> of the Worklog was not found.
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 404 Not Found
    *
    * @apiError Forbidden The <code>id</code> of the Worklog wasn't related to the requester
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 403 Forbidden
    */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validation);
        $workLog = $this->workLog->find($id);

        if(!$workLog) {
            return response('', Response::HTTP_NOT_FOUND);
        }

        if (Gate::denies('update', $workLog)) {
            return response('', Response::HTTP_FORBIDDEN);
        }

        $input = $request->all();

        if($request->has('tags')) {
            $workLog->tags()->sync($request->get('tags'));
        }

        $workLog->update($input);

        return response($workLog->load('tags'));
    }

    /**
    * Create new worklog
    * @param Request $request
    * @return Response
    *
    * @api {post} /worklogs Create a worklog    
    * @apiVersion 0.0.1
    * @apiParam {Integer} id Worklog's unique ID.
    * @apiName CreateWorklog
    * @apiGroup Worklogs
    * 
    * @apiSuccess {Integer} id           Worklog's id
    * @apiSuccess {String}  description  Worklog's description
    * @apiSuccess {Integer} user_id      User's id
    * @apiSuccess {String}  created_at   Worklog's created time
    * @apiSuccess {String}  updated_at   Worklog's updated time
    * @apiSuccess {String}  started_at   Worklog's started time
    * @apiSuccess {String}  finished_at  Worklog's finished time
    * @apiSuccess {Tag[]}   tags         Related worklog's tags
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       "id": 1,
    *       "user_id": 1,
    *       "description": "Lorem ipsum dolor sit amet",
    *       "created_at": "2016-08-01 13:59:59",
    *       "updated_at": "2016-08-02 13:59:59",
    *       "started_at": "2016-08-01 13:59:59",
    *       "finished_at": "2016-08-01 13:59:59",
    *       "tags": [{Tag}]
    *     }
    */
    public function create(Request $request)
    {

        $this->validate($request, $this->validation);

        $input = $request->all();
        $model = new Worklog($input);
        $this->user->workLogs()->save($model);
        if($request->has('tags')) {
            $model->tags()->attach($request->get('tags'));
        }
        return response($model->load('tags'));
    }
}
