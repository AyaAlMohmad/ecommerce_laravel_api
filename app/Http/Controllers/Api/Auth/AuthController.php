<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiResponse;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(UserRequest $request)
    {
        try{
            $user = User::create([
                'name'=> $request->name,
                'email' => $request->email,
                'password'=> Hash::make($request->password)
            ]);

            $token = $user->createToken('Register API Token')->plainTextToken ;
            $data['token'] = $token;
            $data['name'] = $user->name;

            return $this->successResponse($data, " created Successfuly",200);
        }
        catch (\Exception $e) 
        { 
            return $this->errorResponse("ERROR. ". $e->getMessage(),500);
        } 

    }

    public function login(LoginRequest $request)
    {
        if(!Auth::attempt($request->only('email','password')))
        {
            return $this->errorResponse("password or email does not match",401);
        }
        $user = User::where('email',$request->email)->first();
    
        $token = $user->createToken("Login Token")->plainTextToken;
        $data['token'] = $token;
        $data['name'] = $user->name;
        return $this->successResponse($data,"User Loged Successfully",200);
    }
    
    public function logout()
    {
        auth()->user()->tokens()->delete();

        Auth::guard('web')->logout();

        return $this->successResponse(auth()->user()->name,"Logedout Seccessfuly",200);
    
      }
    
        public function userProfile() {
            
            return response()->json(new UserResource(auth()->user()));
        }
      
}
