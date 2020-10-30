<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function getUserInfo(Request $request){
        $user =  $request->user();
        $result =  [
            "sub" => $user["id"],
        ];
        if ($user->tokenCan('email')) {
            $result["email"] = $user["user_name"];
        }
        if ($user->tokenCan('profile')) {
            $result["first_name"] = $user["first_name"];
            $result["last_name"] = $user["last_name"];
            $result["name"] = isset($user["full_name"]) ? $user["full_name"] : $user["first_name"]." ".$user["last_name"];
            $result["avatar"] = $user["avatar"];
        }
        return $result;
    }

    public static function quickRandom($length = 32)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
    public function createUsers(Request $request) {

        $input = $request->all();
        $validationRule = [
            "user_name" => "required",
            "password" => "required",

        ];
        $validator = Validator::make($input, $validationRule);

        if ($validator->fails()) {
            $response = [ "status" => false, "error" => $validator->errors()->all()];
        } else {
            $user = User::create([
                'id'         => UserApiController::quickRandom(),
                'user_name'  => $input['user_name'],
                'password'   => Hash::make($input['password']),
                'first_name' => isset($input['first_name']) ? $input['first_name'] : NULl,
                'last_name'  => isset($input['last_name']) ? $input['last_name'] : NULL,
                'avatar'     => isset($input['avatar']) ? $input['avatar'] : NULL,
            ]);
            $response = [ "status" => true, "data" => $user];
        }

        return response()->json($response);
        
    }
}
