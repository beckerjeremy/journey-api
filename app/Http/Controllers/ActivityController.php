<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityBasicResource;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * @OA\Get(
     *  path="/activity",
     *  summary="List activities",
     *  description="Get a list of all activities.",
     *  operationId="activityList",
     *  tags={"activity"},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Activity"),
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
        return ActivityBasicResource::collection(Activity::all());
    }

    /**
     * @OA\Post(
     *  path="/activity",
     *  summary="Create activity",
     *  description="Create a new activity.",
     *  operationId="activityCreate",
     *  tags={"activity"},
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
     *      name="description",
     *      description="A short description of the activity.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/Activity"),
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
            'description' => 'string',
        ]);

        $activity = new Activity;
        $activity->name = $request->name;
        $activity->description = $request->description;
        $activity->save();

        return new ActivityResource($activity);
    }

    /**
     * @OA\Get(
     *  path="/activity/{id}",
     *  summary="Show activity",
     *  description="Get a single activity by id.",
     *  operationId="activityShow",
     *  tags={"activity"},
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
     *      @OA\JsonContent(ref="#/components/schemas/Activity"),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The activity does not exist.",
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
        return new ActivityResource(Activity::findOrFail($id));
    }

    /**
     * @OA\Patch(
     *  path="/activity/{id}",
     *  summary="Update activity",
     *  description="Update an existing activity.",
     *  operationId="activityUpdate",
     *  tags={"activity"},
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
     *      name="description",
     *      description="A short description of the activity.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/Activity"),
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The activity does not exist.",
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
            'description' => 'string',
        ]);

        $activity = Activity::findOrFail($id);
        if (isset($request->name)) $activity->name = $request->name;
        if (isset($request->description)) $activity->description = $request->description;
        $activity->save();

        return new ActivityResource($activity);
    }

    /**
     * @OA\Delete(
     *  path="/activity/{id}",
     *  summary="Delete activity",
     *  description="Delete an activity.",
     *  operationId="activityDelete",
     *  tags={"activity"},
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
     *      description="The activity does not exist.",
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
        $activity = Activity::findOrFail($id);
        $activity->delete();
    }
}
