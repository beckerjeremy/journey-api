<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *  path="/user",
     *  summary="List users",
     *  description="Get a list of all users.",
     *  operationId="userList",
     *  tags={"user"},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/User"),
     *      ),
     *  ),
     * )
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * @OA\Post(
     *  path="/user",
     *  summary="Create user",
     *  description="Create a new user.",
     *  operationId="userCreate",
     *  tags={"user"},
     *  @OA\Parameter(
     *      name="first_name",
     *      description="The first name of the user.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="family_name",
     *      description="The family name of the user.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="email",
     *      description="The email address of the user.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="password",
     *      description="The password of the user to log in.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="password_confirmation",
     *      description="The confirmed password of the user to log in.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="language",
     *      description="The preferred language of the user.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="is_admin",
     *      description="If the user account is an admin account.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="boolean",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="email",
     *      description="The token of the user.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/User"),
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     * )
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|min:1',
            'family_name' => 'required|string|min:1',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|string',
            'language' => 'string|min:2',
            'is_admin' => 'boolean',
            'token' => 'string|unique:users,token',
        ]);

        $user = new User;
        $user->first_name = $request->first_name;
        $user->family_name = $request->family_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->language = $request->language;
        $user->is_admin = $request->is_admin;
        $user->token = $request->token;
        $user->save();

        return new UserResource($user);
    }

    /**
     * @OA\Get(
     *  path="/user/{id}",
     *  summary="Show user",
     *  description="Get a single user by id.",
     *  operationId="userShow",
     *  tags={"user"},
     *  @OA\Parameter(
     *      name="id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/User"),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The user does not exist.",
     *  ),
     * )
     * 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * @OA\Patch(
     *  path="/user/{id}",
     *  summary="Update user",
     *  description="Update an existing user.",
     *  operationId="userUpdate",
     *  tags={"user"},
     *  @OA\Parameter(
     *      name="id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="first_name",
     *      description="The first name of the user.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="family_name",
     *      description="The family name of the user.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="email",
     *      description="The email address of the user.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="password",
     *      description="The password of the user to log in.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="password_confirmation",
     *      description="The confirmed password of the user to log in.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="language",
     *      description="The preferred language of the user.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="is_admin",
     *      description="If the user account is an admin account.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="boolean",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="email",
     *      description="The token of the user.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/User"),
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The user does not exist.",
     *  ),
     * )
     * 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'string|min:1',
            'family_name' => 'string|min:1',
            'password' => 'confirmed|string',
            'language' => 'string|min:2',
            'is_admin' => 'boolean',
            'token' => 'string|unique:users,token',
        ]);

        $user = User::findOrFail($id);
        if (isset($request->first_name)) $user->first_name = $request->first_name;
        if (isset($request->family_name)) $user->family_name = $request->family_name;
        if (isset($request->password)) $user->password = Hash::make($request->password);
        if (isset($request->language)) $user->language = $request->language;
        if (isset($request->is_admin)) $user->is_admin = $request->is_admin;
        if (isset($request->token)) $user->token = $request->token;
        $user->save();

        return new UserResource($user);
    }

    /**
     * @OA\Delete(
     *  path="/user/{id}",
     *  summary="Delete user",
     *  description="Delete an user.",
     *  operationId="userDelete",
     *  tags={"user"},
     *  @OA\Parameter(
     *      name="id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The user does not exist.",
     *  ),
     * )
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}
