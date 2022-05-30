<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * * @OA\Post(
     *  path="/login",
     *  summary="Log in",
     *  description="Log in and get an access token.",
     *  operationId="authLogin",
     *  tags={"auth"},
     *  @OA\Parameter(
     *      name="email",
     *      description="The email of the user.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="password",
     *      description="The chosen password of the user.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Login successful.",
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="The given e-mail and password do not match.",
     *  ),
     * )
     *
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     *  path="/me",
     *  summary="Me",
     *  description="Get the user of the current token.",
     *  operationId="authMe",
     *  tags={"auth"},
     *  security={{"apiAuth": {}}},
     *  @OA\Response(
     *      response=200,
     *      description="Your access token time is refreshed.",
     *      @OA\JsonContent(ref="#/components/schemas/User"),
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     * )
     * 
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *  path="/logout",
     *  summary="Log out",
     *  description="Log out and make the token invalid.",
     *  operationId="authLogout",
     *  tags={"auth"},
     *  security={{"apiAuth": {}}},
     *  @OA\Response(
     *      response=200,
     *      description="Log out successful.",
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     * )
     * 
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     *  path="/refresh",
     *  summary="Refresh",
     *  description="Refresh the time on the access token.",
     *  operationId="authRefresh",
     *  tags={"auth"},
     *  security={{"apiAuth": {}}},
     *  @OA\Response(
     *      response=200,
     *      description="Your access token time is refreshed.",
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     * )
     * 
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
