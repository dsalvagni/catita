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
     */
    public function index(Request $request)
    {
        return response($request->user()->workLogs);
    }

    /**
     * Return a worklog
     * @param $id worklog id
     * @return Response
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
     */
    public function destroy(Request $request, $id)
    {
        $workLog = $this->workLog->find($id);
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
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validation);
        $workLog = $this->workLog->find($id);
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
        return response($model->load('tags'), Response::HTTP_CREATED);
    }
}
