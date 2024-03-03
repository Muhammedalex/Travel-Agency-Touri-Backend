<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use App\Notifications\ResetPassNotification;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function forgotPass(ForgotPasswordRequest $request)
    {
        $input = $request->only('email');
        $user = User::where('email',$input)->first();
        $user->notify(new ResetPassNotification());
        $success['success']=true;
        return response($success,200);
    }
}
