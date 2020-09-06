<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'User_Name' => 'required',
            'Passwd' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Bad Request',
                'error' => $validator->errors(),
            ],401);
        }

        $check_user = User::where('User_Name', $input['User_Name'])->where('Passwd', $input['Passwd'])->first();

        if (@count($check_user) > 0) {
            $response['token'] = $check_user->createToken('userlogin')->accessToken;
            $response['status'] = 200;
            $response['message'] = "Login Successfully";
            return response()->json($response,200);
        } else {
            $response['status'] = 401;
            $response['message'] = "Login detail not match";
            return response()->json($response,401);
        }
    }
}
