<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * @OA\Get(
     *  path="/status",
     *  summary="List statuses",
     *  description="Get a list of all statuses.",
     *  operationId="statusList",
     *  tags={"status"},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Status"),
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
        return StatusResource::collection(Status::all());
    }

    /**
     * @OA\Get(
     *  path="/status/{id}",
     *  summary="Show status",
     *  description="Get a single status by id.",
     *  operationId="statusShow",
     *  tags={"status"},
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
     *      @OA\JsonContent(ref="#/components/schemas/Status"),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The status does not exist.",
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
        return new StatusResource(Status::findOrFail($id));
    }
}
