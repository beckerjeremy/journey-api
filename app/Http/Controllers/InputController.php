<?php

namespace App\Http\Controllers;

use App\Http\Resources\InputBasicResource;
use App\Http\Resources\InputResource;
use App\Models\Input;
use Illuminate\Http\Request;

class InputController extends Controller
{
    /**
     * @OA\Get(
     *  path="/input",
     *  summary="List inputs",
     *  description="Get a list of all inputs.",
     *  operationId="inputList",
     *  tags={"input"},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Input"),
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
        return InputBasicResource::collection(Input::paginate(100));
    }

    /**
     * @OA\Post(
     *  path="/input",
     *  summary="Create input",
     *  description="Create a new input.",
     *  operationId="inputCreate",
     *  tags={"input"},
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
     *      name="input_type_id",
     *      description="The id of the specialized object.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="input_type_type",
     *      description="The class name of the specialized object.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Created",
     *      @OA\JsonContent(ref="#/components/schemas/Input"),
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
            'input_type_id' => 'required|poly_exists:input_type_type',
        ]);

        $input = new Input;
        $input->name = $request->name;
        $input->input_type_id = $request->input_type_id;
        $input->input_type_type = $request->input_type_type;
        $input->save();

        return new InputResource($input);
    }

    /**
     * @OA\Get(
     *  path="/input/{id}",
     *  summary="Show input",
     *  description="Get a single input by id.",
     *  operationId="inputShow",
     *  tags={"input"},
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
     *      @OA\JsonContent(ref="#/components/schemas/Input"),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The input does not exist.",
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
        return new InputResource(Input::findOrFail($id));
    }

    /**
     * @OA\Patch(
     *  path="/input/{id}",
     *  summary="Update input",
     *  description="Update an existing input.",
     *  operationId="inputUpdate",
     *  tags={"input"},
     *  @OA\Parameter(
     *      name="id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="name",
     *      description="The name of the input.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="input_type_id",
     *      description="The id of the specialized object.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="input_type_type",
     *      description="The class name of the specialized object.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/Input"),
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The input does not exist.",
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
            'name' => 'string|min:1',
            'input_type_id' => 'poly_exists:input_type_type',
        ]);

        $input = Input::findOrFail($id);
        if (isset($request->name)) $input->name = $request->name;
        if (isset($request->input_type_id)) $input->input_type_id = $request->input_type_id;
        if (isset($request->input_type_type)) $input->input_type_type = $request->input_type_type;
        $input->save();

        return new InputResource($input);
    }

    /**
     * @OA\Delete(
     *  path="/input/{id}",
     *  summary="Delete input",
     *  description="Delete an input.",
     *  operationId="inputDelete",
     *  tags={"input"},
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
     *      description="The input does not exist.",
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
        $input = Input::findOrFail($id);
        $input->delete();
    }
}
