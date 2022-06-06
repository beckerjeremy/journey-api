<?php

namespace App\Http\Controllers;

use App\Http\Resources\JourneyActionBasicResource;
use App\Http\Resources\JourneyActionResource;
use App\Models\Journey;
use App\Models\JourneyAction;
use App\Models\JourneyActivity;
use Illuminate\Http\Request;

class JourneyActionController extends Controller
{
    /**
     * @OA\Get(
     *  path="/journey/{journey}/activity/{activity}/action",
     *  summary="List actions",
     *  description="Get a list of all actions of a journey activity.",
     *  operationId="journeyActionList",
     *  tags={"journeyAction"},
     *  @OA\Parameter(
     *      name="journey",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
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
     *          @OA\Items(ref="#/components/schemas/JourneyAction"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The journey or activity does not exist.",
     *  ),
     * )
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($journey, $activity)
    {
        $journey = Journey::findOrFail($journey);
        $activity = JourneyActivity::findOrFail($activity);

        if ($journey->journey_activities->contains($activity)) {
            return JourneyActionBasicResource::collection($activity->journey_actions);
        } else {
            abort(404);
        }
    }

    /**
     * @OA\Post(
     *  path="/journey/{journey}/activity/{activity}/action",
     *  summary="Create activity",
     *  description="Create a new action for the journey activity.",
     *  operationId="journeyActionCreate",
     *  tags={"journeyAction"},
     *  @OA\Parameter(
     *      name="journey",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="activity",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="action_id",
     *      description="The reference to the action the user starts.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="started_at",
     *      description="The date and time the action was started.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="date",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="status_id",
     *      description="The reference to the status of the action.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="input_id",
     *      description="The reference to the input attached to the action.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/JourneyAction"),
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The journey or activity does not exist.",
     *  ),
     * )
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $journey, $activity)
    {
        $journey = Journey::findOrFail($journey);
        $activity = JourneyActivity::findOrFail($activity);

        if ($journey->journey_activities->contains($activity)) {
            $this->validate($request, [
                'action_id' => 'required|exists:actions,id',
                'started_at' => 'date',
                'status_id' => 'required|exists:status,id',
                'input_id' => 'exists:inputs,id',
            ]);

            $journeyAction = new JourneyAction;
            $journeyAction->journey_activity_id = $activity->id;
            $journeyAction->action_id = $request->action_id;
            $journeyAction->started_at = $request->started_at;
            $journeyAction->status_id = $request->status_id;
            $journeyAction->input_id = $request->input_id;
            $journeyAction->save();

            return new JourneyActionResource($journeyAction);
        } else {
            abort(404);
        }
    }

    /**
     * @OA\Get(
     *  path="/journey/{journey}/activity/{activity}/action/{id}",
     *  summary="Show action",
     *  description="Get a single action from a journey activity by id.",
     *  operationId="journeyActionShow",
     *  tags={"journeyAction"},
     *  @OA\Parameter(
     *      name="journey",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
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
     *      @OA\JsonContent(ref="#/components/schemas/JourneyAction"),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The journey, activity or action does not exist.",
     *  ),
     * )
     * 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($journey, $activity, $id)
    {
        $journey = Journey::findOrFail($journey);
        $activity = JourneyActivity::findOrFail($activity);
        $journeyAction = JourneyAction::findOrFail($id);

        if ($journey->journey_activities->contains($activity) && $activity->journey_actions->contains($journeyAction)) {
            return new JourneyActionResource($journeyAction);
        } else {
            abort(404);
        }
    }

    /**
     * @OA\Patch(
     *  path="/journey/{journey}/activity/{activity}/action/{id}",
     *  summary="Update action",
     *  description="Update an existing action of a journey activity.",
     *  operationId="journeyActionUpdate",
     *  tags={"journeyAction"},
     *  @OA\Parameter(
     *      name="journey",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
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
     *      name="action_id",
     *      description="The reference to the action the user starts.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="started_at",
     *      description="The date and time the action was started.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="date",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="status_id",
     *      description="The reference to the status of the action.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="input_id",
     *      description="The reference to the input attached to the action.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/JourneyAction"),
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The journey, activity or action does not exist.",
     *  ),
     * )
     * 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $journey, $activity, $id)
    {
        $journey = Journey::findOrFail($journey);
        $activity = JourneyActivity::findOrFail($activity);
        $journeyAction = JourneyAction::findOrFail($id);

        if ($journey->journey_activities->contains($activity) && $activity->journey_actions->contains($journeyAction)) {
            $this->validate($request, [
                'action_id' => 'exists:actions,id',
                'started_at' => 'date',
                'status_id' => 'exists:status,id',
                'input_id' => 'exists:inputs,id',
            ]);

            if (isset($request->action_id)) $journeyAction->action_id = $request->action_id;
            if (isset($request->started_at)) $journeyAction->started_at = $request->started_at;
            if (isset($request->status_id)) $journeyAction->status_id = $request->status_id;
            if (isset($request->input_id)) $journeyAction->input_id = $request->input_id;
            $journeyAction->save();
            
            return new JourneyActionResource($journeyAction);
        } else {
            abort(404);
        }
    }

    /**
     * @OA\Delete(
     *  path="/journey/{journey}/activity/{activity}/action/{id}",
     *  summary="Delete action",
     *  description="Delete an action of a journey activity.",
     *  operationId="journeyActionDelete",
     *  tags={"journeyAction"},
     *  @OA\Parameter(
     *      name="journey",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
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
     *      description="The journey, activity or action does not exist.",
     *  ),
     * )
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($journey, $activity, $id)
    {
        $journey = Journey::findOrFail($journey);
        $activity = JourneyActivity::findOrFail($activity);
        $journeyAction = JourneyAction::findOrFail($id);

        if ($journey->journey_activities->contains($activity) && $activity->journey_actions->contains($journeyAction)) {
            $journeyAction->delete();
        } else {
            abort(404);
        }
    }
}
