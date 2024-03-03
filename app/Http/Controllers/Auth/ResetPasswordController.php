<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Hash  ;

class ResetPasswordController extends Controller
{
    private $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }

    public function resetPass(ResetPasswordRequest $request)
    {
        $otpe = $this->otp->validate($request->email , $request->otp);
        if(!$otpe->status){
            return response(['error'=>$otpe],401);
        }
        $user = User::where('email',$request->email)->first();
        $user->update(['password'=>Hash::make($request->password)]);
        $user->tokens()->delete();
        $success['success']=true;
        return response($success,201);


    }
}
