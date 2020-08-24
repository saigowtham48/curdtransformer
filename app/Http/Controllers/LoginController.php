<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

use App\User;
use App\Http\Resources\UserResource;

use Validator;

class LoginController extends Controller
{
    public function login(Request $request) {
    	$validator = Validator::make($request->all(), [
                        'email' => 'required|email',
                        'password' => 'required'
                    ]);
    	$validationFailed = $validator->fails();
        $validationErrors = $validator->errors()->all();

        if ($validationFailed) {
            $this->output($request, false, $validationErrors, 200, 'Login Failed');
            exit;
        }
        $user = User::where('email',$request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
 			 $this->output($request, false, 'Invalid credentials', 200, 'Login Failed');
            exit;
        } else {
			$token = $user->createToken('accces_token')->accessToken;
        }

        return response(['data' => new UserResource($user), 'authToken' => $token, 'success' => true]);
    }
}
