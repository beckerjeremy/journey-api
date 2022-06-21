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
     * @OA\Get(
     *  path="/text",
     *  summary="List text inputs",
     *  description="Get a list of all text inputs.",
     *  operationId="textInputList",
     *  tags={"textInput"},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/TextInput"),
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
        return TextInputBasicResource::collection(TextInput::paginate(100));
    }

    /**
     * @OA\Post(
     *  path="/text",
     *  summary="Create text input",
     *  description="Create a new text input.",
     *  operationId="textInputCreate",
     *  tags={"textInput"},
     *  @OA\Parameter(
     *      name="name",
     *      description="The name of the input.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="text",
     *      description="The text entered by the user.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Created",
     *      @OA\JsonContent(ref="#/components/schemas/TextInput"),
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
            'name' => 'required|string|min:1',
            'text' => 'string',
        ]);

        $textInput = new TextInput;
        $textInput->text = $request->text;
        $textInput->save();

        $input = new Input;
        $input->name = $request->name;
        $input->input_type_id = $textInput->id;
        $input->input_type_type = "App\\Models\\TextInput";
        $input->save();

        return new TextInputResource($textInput);
    }

    /**
     * @OA\Get(
     *  path="/text/{id}",
     *  summary="Show text input",
     *  description="Get a single text input by id.",
     *  operationId="textInputShow",
     *  tags={"textInput"},
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
     *      @OA\JsonContent(ref="#/components/schemas/TextInput"),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The text input does not exist.",
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
        return new TextInputResource(TextInput::findOrFail($id));
    }

    /**
     * @OA\Patch(
     *  path="/text/{id}",
     *  summary="Update text input",
     *  description="Update an existing text input.",
     *  operationId="textInputUpdate",
     *  tags={"textInput"},
     *  @OA\Parameter(
     *      name="id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="text",
     *      description="The text entered by the user.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/TextInput"),
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The text input does not exist.",
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
            'text' => 'string',
        ]);

        $textInput = TextInput::findOrFail($id);
        if (isset($request->text)) $textInput->text = $request->text;
        $textInput->save();

        return new TextInputResource($textInput);
    }

    /**
     * @OA\Delete(
     *  path="/text/{id}",
     *  summary="Delete text input",
     *  description="Delete a text input.",
     *  operationId="textInputDelete",
     *  tags={"textInput"},
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
     *      description="The text input does not exist.",
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
        $textInput = TextInput::findOrFail($id);
        if ($textInput->input) $textInput->input->delete();
        $textInput->delete();
    }
}
