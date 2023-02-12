<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {


        $user = User::where('email', $request->email)->first();
        if ($user){

            if(Hash::check($request->password , $user->password)){

                $token = $user->createToken('login');

                    return ['token' => $token->plainTextToken];

            }else{
                return[
                    'messege' => 'Password wrong'
                ];
            }


        }else{
            return [
                'messege' => 'User not found'
            ];
        }

    }


        public function register(Request $request)
        {
            $request->validate([
                'name'=> 'required',
                'email'=> 'required|unique:users,email',
                'password'=> 'required',
                'phone'=> 'required',
            ]);
            
            return [
                'messege' => 'Process Done',
                'Process'=>  User::create([
                        'name'=> $request->name,
                        'email'=> $request->email,
                        'phone'=> $request->phone,
                        'password'=> Hash::make($request->password),
                     ])
                ];
        }

}
