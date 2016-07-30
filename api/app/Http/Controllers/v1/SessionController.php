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
     * Delete an user session
     * @return Response
     */
    public function destroy()
    {
        Token::clear();
        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Get an user session
     * @return Response
     */
    public function show()
    {
        $User = Auth::user();
        return response([
            'id' => $User->id,
            'name' => $User->name,
            'email' => $User->email,
            'api_token' => (string) Token::getToken()
        ]);
    }

    /**
     * Create new user
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|max:255',
            'email' => 'required|email|min:6',
        ]);

        $input = $request->all();

        $User = User::where('email', $input['email'])->first();

        if (Hash::check($input['password'], $User->password)) {

            Token::create($User->id);

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
