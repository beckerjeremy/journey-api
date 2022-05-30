<?php

namespace App\Http\Controllers;

use App\Http\Resources\InputTypeResource;
use App\Models\InputType;
use Illuminate\Http\Request;

class InputTypeController extends Controller
{
    /**
     * @OA\Get(
     *  path="/inputType",
     *  summary="List input types",
     *  description="Get a list of all input types.",
     *  operationId="inputTypeList",
     *  tags={"inputType"},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/InputType"),
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
        return InputTypeResource::collection(InputType::all());
    }

    /**
     * @OA\Get(
     *  path="/inputType/{id}",
     *  summary="Show input type",
     *  description="Get a single input type by id.",
     *  operationId="inputTypeShow",
     *  tags={"inputType"},
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
     *      @OA\JsonContent(ref="#/components/schemas/InputType"),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The input type does not exist.",
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
        return new InputTypeResource(InputType::findOrFail($id));
    }
}
