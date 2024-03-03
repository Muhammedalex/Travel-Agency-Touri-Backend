<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Notifications\RegisterNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['message' => 'Email or Password not correct'], 401);
        }
    
        $token = $user->createToken($user->first_name);
        
        // Send a login notification
        // $user->notify(new RegisterNotification());
    
        return response([
            'message' => __('auth.Welcome') .' ' .$user->first_name,
            'token' => $token->plainTextToken,
            'user' => $user,
        ], 201);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if ($user) {
            $request->user()->tokens()->delete();
        }

        return response(['message' => 'User logged out successfully','success'=>true],200);
    }
}
