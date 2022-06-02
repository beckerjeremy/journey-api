<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserSummaryResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TokenController extends Controller
{
    /**
     * @OA\Post(
     *  path="/token",
     *  summary="Create user with token",
     *  description="Create a new user with token.",
     *  operationId="tokenCreate",
     *  tags={"token"},
     *  @OA\Parameter(
     *      name="token",
     *      description="The token the user gets.",
     *      required=true,
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
            'token' => 'required|string|unique:users,token',
        ]);

        $user = new User;
        $user->token = $request->token;
        $user->save();

        return new UserResource($user);
    }

    /**
     * @OA\Get(
     *  path="/token/{token}",
     *  summary="Show user with token",
     *  description="Get a single user by token.",
     *  operationId="tokenShow",
     *  tags={"token"},
     *  @OA\Parameter(
     *      name="token",
     *      required=true,
     *      in="path",
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
     *      response=404,
     *      description="The user does not exist.",
     *  ),
     * )
     * 
     * Display the specified resource.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        $user = User::where('token', '=', $token)->firstOrFail();

        return new UserSummaryResource($user);
    }
}
