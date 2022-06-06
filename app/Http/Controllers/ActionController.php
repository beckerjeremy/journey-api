<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActionBasicResource;
use App\Http\Resources\ActionResource;
use App\Models\Action;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    /**
     * @OA\Get(
     *  path="/activity/{activity}/action",
     *  summary="List Actions",
     *  description="Get a list of all actions from the activity.",
     *  operationId="actionList",
     *  tags={"action"},
     *  @OA\Parameter(
     *      name="activity",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Action"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The activity does not exist.",
     *  ),
     * )
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($activity)
    {
        $activity = Activity::findOrFail($activity);
        return ActionBasicResource::collection($activity->actions);
    }

    /**
     * @OA\Post(
     *  path="/activity/{activity}/action",
     *  summary="Create action",
     *  description="Create a new action for the activity.",
     *  operationId="actionCreate",
     *  tags={"action"},
     *  @OA\Parameter(
     *      name="activity",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="input_type_id",
     *      description="The reference to the input type.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="input_required",
     *      description="If the input is required or not.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="boolean",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="name",
     *      description="The name of the action.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="description",
     *      description="A short description of the action.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Created",
     *      @OA\JsonContent(ref="#/components/schemas/Action"),
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $activity)
    {
        $activity = Activity::findOrFail($activity);

        $this->validate($request, [
            'input_type_id' => 'exists:input_types,id',
            'input_required' => 'boolean',
            'name' => 'required|string|min:1',
            'description' => 'string',
            'order_weight' => 'integer|nullable',
        ]);

        $action = new Action;
        $action->activity_id = $activity->id;
        $action->input_type_id = $request->input_type_id;
        $action->input_required = $request->input_required;
        $action->name = $request->name;
        $action->description = $request->description;
        $action->order_weight = $request->order_weight;
        $action->save();

        return new ActionResource($action);
    }

    /**
     * @OA\Get(
     *  path="/activity/{activity}/action/{id}",
     *  summary="Show action",
     *  description="Get a single action from an activity by id.",
     *  operationId="actionShow",
     *  tags={"action"},
     *  @OA\Parameter(
     *      name="activity",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
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
     *      description="The activity or action does not exist.",
     *  ),
     * )
     * 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($activity, $id)
    {
        $activity = Activity::findOrFail($activity);
        $action = Action::findOrFail($id);

        if ($activity->actions->contains($action)) {
            return new ActionResource($action);
        } else {
            abort(404);
        }
    }

    /**
     * @OA\Patch(
     *  path="/activity/{activity}/action/{id}",
     *  summary="Update action",
     *  description="Update an existing action of an activity.",
     *  operationId="actionUpdate",
     *  tags={"action"},
     *  @OA\Parameter(
     *      name="activity",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="input_type_id",
     *      description="The reference to the input type.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="input_required",
     *      description="If the input is required or not.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="boolean",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="name",
     *      description="The name of the action.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="description",
     *      description="A short description of the action.",
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
     *      description="The activity or action does not exist.",
     *  ),
     * )
     * 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $activity, $id)
    {
        $activity = Activity::findOrFail($activity);
        $action = Action::findOrFail($id);

        if ($activity->actions->contains($action)) {
            $this->validate($request, [
                'input_type_id' => 'exists:input_types,id',
                'input_required' => 'boolean',
                'name' => 'string|min:1',
                'description' => 'string',
                'order_weight' => 'integer|nullable',
            ]);

            if (isset($request->input_type_id)) $action->input_type_id = $request->input_type_id;
            if (isset($request->input_required)) $action->input_required = $request->input_required;
            if (isset($request->name)) $action->name = $request->name;
            if (isset($request->description)) $action->description = $request->description;
            if (isset($request->order_weight)) $action->order_weight = $request->order_weight;
            $action->save();

            return new ActionResource($action);
        } else {
            abort(404);
        }
    }

    /**
     * @OA\Delete(
     *  path="/activity/{activity}/action/{id}",
     *  summary="Delete action",
     *  description="Delete an action of an activity.",
     *  operationId="actionDelete",
     *  tags={"action"},
     *  @OA\Parameter(
     *      name="activity",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
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
     *      description="The activity or action does not exist.",
     *  ),
     * )
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($activity, $id)
    {
        $activity = Activity::findOrFail($activity);
        $action = Action::findOrFail($id);
        
        if ($activity->actions->contains($action)) {
            $action->delete();
        } else {
            abort(404);
        }
    }
}
