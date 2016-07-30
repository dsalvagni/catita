<?php

namespace App\Http\Controllers\v1;

use App\JWT\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UsersController extends \App\Http\Controllers\Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->middleware('auth', ['except' => 'create']);
        $this->user = $user;
    }
    /**
     * Return a user
     * @return Response
     */
    public function show()
    {
        $user = $this->user->find(Auth::user()->id);

        if (Gate::denies('show', $user)) {
            return response('', Response::HTTP_FORBIDDEN);
        }

        if (!$user) {
            return response('', Response::HTTP_NOT_FOUND);
        }
        return response($user);
    }
    /**
     * Soft-delete an user
     * @return Response
     */
    public function destroy()
    {
        $user = $this->user->find(Auth::user()->id);

        if (Gate::denies('destroy', $user)) {
            return response('', Response::HTTP_FORBIDDEN);
        }
        $user->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Update a given user
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'min:3',
            'password'=> 'confirmed|min:6|max:255',
            'email' => 'email|unique:users|min:6',
        ]);
        $user = $this->user->find(Auth::user()->id);
        if (Gate::denies('update', $user)) {
            return response('', Response::HTTP_FORBIDDEN);
        }

        $input = $request->all();

        if(isset($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }
        $user->update($input);

        return response($user);
    }

    /**
     * Create new user
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'password'=> 'required||confirmed|min:6|max:255',
            'email' => 'required|email|unique:users|min:6',
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $model = $this->user->create($input);

        $Token = Token::create($model->id);

        return response([
            'id'           =>   $model->id,
            'name'         =>   $model->name,
            'email'        =>   $model->email,
            'api_token'    =>   $model->getApiToken()
        ]);
    }
}
