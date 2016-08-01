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
    * Create e-mail reset password token
    * @param Request $request
    * @return Response
    * @apiVersion 0.0.1
    * @api {post} /password/request Create a reset password request
    *
    * @apiParam {String}  email    Users's description
    *
    * @apiName CreatePasswordResetRequest
    * @apiGroup Password
    * @apiDescription This service should create a new password reset request.
    * It will send an e-mail to the request with an token and a link to set 
    * a new password.
    * 
    * @apiSuccess {Integer} id           Tag's id
    * @apiSuccess {String}  description  Tag's description
    * @apiSuccess {Integer} user_id      User's id
    * @apiSuccess {String}  created_at   Tag created time
    * @apiSuccess {String}  updated_at   Tag updated time
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 201 OK
    *
    * @apiError UserNotFound The <code>email</code> was not found.
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 400 Bad Request
    *
    * @apiError Conflict There's a request to reset password already
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 410 Conflict
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
    * Update an user password
    * @param Request $request
    * @return Response
    * @apiVersion 0.0.1
    * @api {post} /password/reset Update an user password
    *
    * @apiParam {String}  email                    Users's description
    * @apiParam {String}  password                 Users's description
    * @apiParam {String}  password_confirmation    Users's description
    * @apiParam {String}  reset_token              Users's description
    *
    * @apiName UpdateUserPassword
    * @apiGroup Password
    *
    * @apiSuccessExample {json} Success-Response:
    *     HTTP/1.1 204 No Content
    *
    * @apiError UserNotFound The <code>email</code> was not found.
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 400 Bad Request
    *
    * @apiError Gone The token was expired
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 410 Gone
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