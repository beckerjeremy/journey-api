<?php

namespace App\Http\Controllers;

use App\Http\Resources\JourneyBasicResource;
use App\Http\Resources\JourneyResource;
use App\Http\Resources\JourneySummaryResource;
use App\Models\Journey;
use Illuminate\Http\Request;

class JourneyController extends Controller
{
    /**
     * @OA\Get(
     *  path="/journey",
     *  summary="List journeys",
     *  description="Get a list of all journeys.",
     *  operationId="journeyList",
     *  tags={"journey"},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Journey"),
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
        return JourneyBasicResource::collection(Journey::all());
    }

    /**
     * @OA\Post(
     *  path="/journey",
     *  summary="Create journey",
     *  description="Create a new journey.",
     *  operationId="journeyCreate",
     *  tags={"journey"},
     *  @OA\Parameter(
     *      name="name",
     *      description="The name of the activity.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="started_at",
     *      description="The date and time when the journey has been started.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="date",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="status_id",
     *      description="The id of the status of the journey.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="user_id",
     *      description="The id of the user the journey belongs to.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/Journey"),
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
            'started_at' => 'date',
            'status_id' => 'required|exists:status,id',
            'user_id' => 'exists:users,id',
        ]);

        $journey = new Journey;
        $journey->name = $request->name;
        $journey->started_at = $request->started_at;
        $journey->status_id = $request->status_id;
        $journey->user_id = $request->user_id;
        $journey->save();

        return new JourneyResource($journey);
    }

    /**
     * @OA\Get(
     *  path="/journey/{id}",
     *  summary="Show journey",
     *  description="Get a single journey by id.",
     *  operationId="journeyShow",
     *  tags={"journey"},
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
     *      @OA\JsonContent(ref="#/components/schemas/Journey"),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The journey does not exist.",
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
        return new JourneySummaryResource(Journey::findOrFail($id));
    }

    /**
     * @OA\Patch(
     *  path="/journey/{id}",
     *  summary="Update journey",
     *  description="Update an existing journey.",
     *  operationId="journeyUpdate",
     *  tags={"journey"},
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
     *      description="The name of the activity.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="started_at",
     *      description="The date and time when the journey has been started.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="date",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="status_id",
     *      description="The id of the status of the journey.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="user_id",
     *      description="The id of the user the journey belongs to.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/Journey"),
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The journey does not exist.",
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
            'started_at' => 'date',
            'status_id' => 'required|exists:status,id',
            'user_id' => 'exists:users,id',
        ]);

        $journey = Journey::findOrFail($id);
        if (isset($request->name)) $journey->name = $request->name;
        if (isset($request->started_at)) $journey->started_at = $request->started_at;
        if (isset($request->status_id)) $journey->status_id = $request->status_id;
        if (isset($request->user_id)) $journey->user_id = $request->user_id;
        $journey->save();

        return new JourneyResource($journey);
    }

    /**
     * @OA\Delete(
     *  path="/journey/{id}",
     *  summary="Delete journey",
     *  description="Delete a journey.",
     *  operationId="journeyDelete",
     *  tags={"journey"},
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
     *      description="The journey does not exist.",
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
        $journey = Journey::findOrFail($id);
        $journey->delete();
    }
}
