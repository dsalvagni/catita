<?php

namespace App\Http\Controllers\v1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordController extends \App\Http\Controllers\Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Create e-mail reset password token
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|min:6',
        ]);

        $input = $request->all();
        $Token = Hash::make($input['email'].time());

        $User = User::where('email', $input['email'])->first();

        if(!$User) {
            return response('',Response::HTTP_BAD_REQUEST);
        }

        /**
         * There is a token already
         */
        if($User->reset_token !== null) {
            $RequestedAt = new \DateTime($User->updated_at);
            $Today = new \DateTime();
            /**
            * The token wasn't expired yet
            */
            if($RequestedAt <= $Today) {
                return response("A token was set lately and didn't expired yet.", Response::HTTP_CONFLICT);
            }
        }

        $User->update(['reset_token'=>$Token]);

        Mail::send('emails.reset_password', ['user' => $User, 'token'=>$Token], function ($m) use ($User) {
            $m->from(env('APP_DEFAULT_SENDER'), env('APP_NAME'));

            $m->to($User->email, $User->name)->subject('Reset your password');
        });

        return response('', Response::HTTP_CREATED);
    }


    /**
     * Create e-mail reset password token
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {

        $input = $request->all();

        $this->validate($request, [
            'password'=> 'required|confirmed|min:6|max:255'
        ]);

        $User = User::where('reset_token', $input['token'])->first();

        if(!$User) {
            return response('',Response::HTTP_BAD_REQUEST);
        }

        $NewPassword = Hash::make($input['password']);

        $RequestedAt = new \DateTime($User->updated_at);
        $Today = new \DateTime();

        if($RequestedAt > $Today) {
            return response('This token was expired', Response::HTTP_GONE);
        }

        $User->update(['reset_token'=>null,'password'=>$NewPassword]);

        Mail::send('emails.reset_password_confirmation', ['user' => $User], function ($m) use ($User) {
            $m->from(env('APP_DEFAULT_SENDER'), env('APP_NAME'));

            $m->to($User->email, $User->name)->subject('Your password was successfully reseted!');
        });

        return response('', Response::HTTP_NO_CONTENT);
    }
}