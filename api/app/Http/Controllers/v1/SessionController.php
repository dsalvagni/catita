<?php

namespace App\Http\Controllers\v1;

use App\JWT\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class SessionController extends \App\Http\Controllers\Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'create']);
    }

    /**
    * Get an user session
    *
    * @api {get} /session/ Request a Session
    * @apiName GetSession
    * @apiGroup Session
    *
    * @apiSuccess {Integer} id         User's id
    * @apiSuccess {String}  name       User's name
    * @apiSuccess {Integer} email      User's email
    * @apiSuccess {Integer} api_token  Session api_token
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       "id": 1,
    *       "name": "Daniel Salvagni",
    *       "email": "danielsalvagni@gmail.com",
    *       "api_token": "..."
    *     }

    * @apiError Forbidden The <code>user</code> are not authenticated
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 403 Forbidden
    */
    public function show()
    {
        $User = Auth::user();

        if(!$User) {
            return response('', Response::HTTP_FORBIDDEN);
        }

        return response([
            'id' => $User->id,
            'name' => $User->name,
            'email' => $User->email,
            'api_token' => (string) Token::getToken()
        ]);
    }

    /**
    * Create new session
    * @param Request $request
    * @return Response
    *
    * @api {post} /session/ Create a Session
    * @apiName CreateSession
    * @apiGroup Session
    *
    * @apiParam {String}  email        User's email
    * @apiParam {String} password      User's password
    *
    * @apiSuccess {Integer} id         User's id
    * @apiSuccess {String}  name       User's name
    * @apiSuccess {Integer} email      User's email
    * @apiSuccess {Integer} api_token  Session api_token
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       "id": 1,
    *       "name": "Daniel Salvagni",
    *       "email": "danielsalvagni@gmail.com",
    *       "api_token": "..."
    *     }

    * @apiError Forbidden The <code>user</code> are not authenticated
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 403 Forbidden
    */
    public function create(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|max:255',
            'email' => 'required|email|min:6',
        ]);

        $input = $request->all();

        if(!$User) {
            return response('', Response::HTTP_FORBIDDEN);
        }

        if (Hash::check($input['password'], $User->password)) {
            Token::create($User->id,$User->password);

            return response([
                'id' => $User->id,
                'name' => $User->name,
                'email' => $User->email,
                'api_token' => (string) Token::getToken()
            ]);
        }
        return response('', Response::HTTP_FORBIDDEN);
    }
}
