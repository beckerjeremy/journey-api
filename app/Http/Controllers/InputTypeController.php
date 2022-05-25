<?php

namespace App\Http\Controllers;

use App\Http\Resources\InputTypeResource;
use App\Models\InputType;
use Illuminate\Http\Request;

class InputTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InputTypeResource::collection(InputType::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new InputTypeResource(InputType::findOrFail($id));
    }
}
