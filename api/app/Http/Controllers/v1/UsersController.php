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
    *
    * @api {get} /me Request the logged user
    * @apiVersion 0.0.1
    * @apiName GetUser
    * @apiGroup Users
    * @apiDescription This service should return the current information about the logged user.
    *
    * @apiSuccess {Integer} id           User's id
    * @apiSuccess {String}  name         User's name
    * @apiSuccess {String}  email        User's email
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       "id": 1,
    *       "name": "Daniel Salvagni",
    *       "email": "danielsalvagni@gmail.com"
    *     }
    *
    * @apiError Forbidden The <code>id</code> of the User wasn't related to the requester token
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 403 Forbidden
    */
    public function show()
    {
        $user = $this->user->find(Auth::user()->id);

        if (!$user) {
            return response('', Response::HTTP_FORBIDDEN);
        }

        if (Gate::denies('show', $user)) {
            return response('', Response::HTTP_FORBIDDEN);
        }
        return response($user);
    }
    /**
    * Soft-delete an user
    * @return Response
    *
    * @api {delete} /me Delete an user
    * @apiVersion 0.0.1
    * @apiName DeleteUser
    * @apiGroup Users
    * @apiDescription This service will soft-delete the logged user. It means that the user 
    * won't be removed from the database. There's no option to undo this action.
    * 
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 204 OK
    *
    * @apiError Forbidden The <code>id</code> of the User wasn't related to the requester token
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 403 Forbidden
    */
    public function destroy()
    {
        $user = $this->user->find(Auth::user()->id);      

        if (!$user) {
            return response('', Response::HTTP_FORBIDDEN);
        }

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
    * @api {put} /me Update an User
    * @apiVersion 0.0.1
    * @apiDescription This service should update the user information based in the new data inputs.
    * It can be used to update the user password, as well.
    *
    * (*) Password confirmation is only required when `password` is sent.
    *
    * @apiParam {String}  [name]                      User's name
    * @apiParam {String}  [email]                     User's email
    * @apiParam {String}  [password]                  User's password
    * @apiParam {String}  [password_confirmation]     User's password confirmation
    *
    * @apiName CreateUser
    * @apiGroup Users
    * 
    * @apiSuccess {Integer} id           User's id
    * @apiSuccess {String}  name         User's name
    * @apiSuccess {String}  email        User's email
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       "id": 1,
    *       "name": "Daniel Salvagni",
    *       "email": "danielsalvagni@gmail.com"
    *     }
    *
    * @apiError Forbidden The <code>id</code> of the User wasn't related to the requester token
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 403 Forbidden
    */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'min:3',
            'password'=> 'confirmed|min:6|max:255',
            'email' => 'email|unique:users|min:6',
        ]);

        $user = $this->user->find(Auth::user()->id);        

        if (!$user) {
            return response('', Response::HTTP_FORBIDDEN);
        }

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
    *
    * @api {post} /users Create an User
    * @apiVersion 0.0.1
    * @apiDescription This service should register a new user to the system.
    * It will return a token to the client and it must be used on each request.
    *
    * @apiParam {String}  name                      User's name
    * @apiParam {String}  email                     User's email
    * @apiParam {String}  password                  User's password
    * @apiParam {String}  password_confirmation     User's password confirmation
    *
    * @apiName CreateUser
    * @apiGroup Users
    * 
    * @apiSuccess {Integer} id           User's id
    * @apiSuccess {String}  name         User's name
    * @apiSuccess {String}  email        User's email
    * @apiSuccess {String}  api_token    Session's Token
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       "id": 1,
    *       "name": "Daniel Salvagni",
    *       "email": "danielsalvagni@gmail.com",
    *       "api_token": "..."
    *     }
    *
    */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'password'=> 'required|confirmed|min:6|max:255',
            'email' => 'required|email|unique:users|min:6',
        ]);

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $model = $this->user->create($input);

        $Token = Token::create($model->id, $model->password);

        return response([
            'id'           =>   $model->id,
            'name'         =>   $model->name,
            'email'        =>   $model->email,
            'api_token'    =>   $model->getApiToken()
        ], Response::HTTP_CREATED);
    }
}
