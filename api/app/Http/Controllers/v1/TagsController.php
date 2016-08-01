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
     * Return all work logs
     * @return Response
     */
    public function index(Request $request)
    {
        return response($request->user()->tags);
    }

    /**
     * Return a tag
     * @param $id tag id
     * @return Response
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
     */
    public function destroy(Request $request, $id)
    {
        $tag = $this->tag->find($id);
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
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validation);
        $tag = $this->tag->find($id);
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
     */
    public function create(Request $request)
    {

        $this->validate($request, $this->validation);

        $input = $request->all();
        $model = $this->user->tags()->save(new Tag($input));
        return response($model, Response::HTTP_CREATED);
    }
}
