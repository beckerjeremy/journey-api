<?php

namespace App\Http\Controllers;

use App\Http\Resources\TextInputBasicResource;
use App\Http\Resources\TextInputResource;
use App\Models\Input;
use App\Models\TextInput;
use Illuminate\Http\Request;

class TextInputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TextInputBasicResource::collection(TextInput::all());
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
            'name' => 'required|string|min:1',
            'text' => 'string',
        ]);

        $textInput = new TextInput;
        $textInput->text = $request->text;
        $textInput->save();

        $input = new Input;
        $input->name = $request->name;
        $input->data_type_id = $textInput->id;
        $input->data_type_type = "App\\Models\\TextInput";
        $input->save();

        return new TextInputResource($textInput);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new TextInputResource(TextInput::findOrFail($id));
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
            'text' => 'string',
        ]);

        $textInput = TextInput::findOrFail($id);
        if (isset($request->text)) $textInput->text = $request->text;
        $textInput->save();

        return new TextInputResource($textInput);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $textInput = TextInput::findOrFail($id);
        $textInput->input->delete();
        $textInput->delete();
    }
}
