<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
       try {
         //validator
         $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'email'=> 'required|email',
            'password'=> 'required',
            'c_password'   => 'required|same:password'
        ]);

        if($validator->fails()){
            $response = [
                'success'=> false,
                'message'=> $validator->errors()
            ];

            return response()->json($response, 400);
        }

        $input = $request->all();

        $input["password"] = bcrypt($input["password"]);

        $user = User::create($input);


        $success["token"] = $user->createToken('MyApp')->plainTextToken;

        $reponse = [
            "success" => true,
            "data" => $success,
            "message" => "User Registered succesfully"
        ];


        return response()->json($reponse, 200);
       } catch (\Throwable $e) {
        return response()->json(["status"=> false, "message"=> $e->getMessage()], 400);
    }

    }

    public function login(Request $request)
    {
        try {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user = $request->user();

                $success['token'] = $user->createToken('MyAPP')->plainTextToken;

                $success["name"] = $user->name;

                $response = [
                    "success" => true,
                    "data"=> $success,
                    "message"=> "User login succesfully",
                ];

                return response()->json($response, 200);
            }

            $response = [
                'success' => false,
                'message' => "Unauthorized"
            ];

            return  response()->json($response, 400);

        }
        catch (\Throwable $e) {
            return response()->json(["success"=> false, "message"=> $e->getMessage()], 400);
        }

    }
}
