<?php

namespace App\Http\Controllers\Api\Role;


use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User = UserResource::collection(User::all());
        return $this->apiResponse($User);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $token = $user->createToken('Register API Token')->plainTextToken;
            $data['token'] = $token;
            $data['name'] = $user->name;

            return $this->successResponse($data, " created Successfuly", 200);
        } catch (\Exception $e) {
            return $this->errorResponse("ERROR. " . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $User = new UserResource(User::find($id));

        if ($User) {
            return $this->successResponse($User, 'ok');
        }
        return $this->errorResponse('the User Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $User = User::find($id);
        if (!$User) {
            return $this->errorResponse('the User Not Found', 404);
        }

        if ($User->id === Auth::id()) {
            $User->update([
                'name' => $request->name ?? $User->name,
                'email' => $request->email ?? $User->email,
                'password' => Hash::make($request->password) ?? $User->password
                

            ]);
            $array = [
                new UserResource($User),

            ];
            if ($User) {
                return $this->successResponse($array, 'the User update');
            }
        }
        return $this->errorResponse('you con not updet the User Because you are not authorized', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $User = User::find($id);

        if ($User->user_id === Auth::id()) {
            $User->delete();
            if ($User) {
                return $this->successResponse(null, 'the User deleted');
            }
            return $this->errorResponse('you con not delete the User', 400);
        }
        return $this->errorResponse('you con not delete the User Because you are not authorized', 401);
    }
}
