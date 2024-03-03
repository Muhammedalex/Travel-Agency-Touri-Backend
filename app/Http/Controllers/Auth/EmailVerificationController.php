<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest as RequestsEmailVerificationRequest;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;

class EmailVerificationController extends Controller
{
    private $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }

    public function sendEmailVerifiy(Request $request)
    {
        $request->user()->notify(new EmailVerificationNotification());
        return response(['message'=>'Code Have Been Sent Please Check Your Email'],200);
 
    }
    public function email(RequestsEmailVerificationRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $otpe = $this->otp->validate($request->email, $request->otp);
        if ($otpe->status) {
            return response(['error' => 'something went wrong', 'status' => $otpe], 404);
        }
        if($user->is_verified == true){
            
            return response(['error' => 'This Account Already Verified'] , 404);
        }
        $user->is_verified = true;
        $user->save();
        return response(['message' => 'Account Have Been Activeted'], 200);
    }
}
