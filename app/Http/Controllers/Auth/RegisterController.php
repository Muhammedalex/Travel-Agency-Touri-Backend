<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterationRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Support\Facades\Hash  ;

class RegisterController extends Controller
{
    public function register(RegisterationRequest $request){
        $newUser = $request->validated();
        $newUser['password'] = Hash::make($newUser['password']);
        $user = User::create($newUser);
        $user->notify(new EmailVerificationNotification());
        return response(['message'=>'user created successfully','user'=>$user],201);
    }
}
