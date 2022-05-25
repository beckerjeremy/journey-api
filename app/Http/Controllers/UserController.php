<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
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
        ]);

        $user = new User;
        $user->first_name = $request->first_name;
        $user->family_name = $request->family_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->language = $request->language;
        $user->is_admin = $request->is_admin;
        $user->save();

        return new UserResource($user);
    }

    /**
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
        ]);

        $user = User::findOrFail($id);
        if (isset($request->first_name)) $user->first_name = $request->first_name;
        if (isset($request->family_name)) $user->family_name = $request->family_name;
        if (isset($request->password)) $user->password = Hash::make($request->password);
        if (isset($request->language)) $user->language = $request->language;
        if (isset($request->is_admin)) $user->is_admin = $request->is_admin;
        $user->save();

        return new UserResource($user);
    }

    /**
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
