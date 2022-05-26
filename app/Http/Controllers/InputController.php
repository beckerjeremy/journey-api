<?php

namespace App\Http\Controllers;

use App\Http\Resources\InputBasicResource;
use App\Http\Resources\InputResource;
use App\Models\Input;
use Illuminate\Http\Request;

class InputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InputBasicResource::collection(Input::all());
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
            'data_type_id' => 'required|poly_exists:data_type_type',
        ]);

        $input = new Input;
        $input->name = $request->name;
        $input->data_type_id = $request->data_type_id;
        $input->data_type_type = $request->data_type_type;
        $input->save();

        return new InputResource($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new InputResource(Input::findOrFail($id));
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
            'name' => 'string|min:1',
            'data_type_id' => 'poly_exists:data_type_type',
        ]);

        $input = Input::findOrFail($id);
        if (isset($request->name)) $input->name = $request->name;
        if (isset($request->data_type_id)) $input->data_type_id = $request->data_type_id;
        if (isset($request->data_type_type)) $input->data_type_type = $request->data_type_type;
        $input->save();

        return new InputResource($input);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $input = Input::findOrFail($id);
        $input->delete();
    }
}
