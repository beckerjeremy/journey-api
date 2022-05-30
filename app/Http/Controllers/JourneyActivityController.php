<?php

namespace App\Http\Controllers;

use App\Http\Resources\JourneyActivityBasicResource;
use App\Http\Resources\JourneyActivityResource;
use App\Models\Journey;
use App\Models\JourneyActivity;
use Illuminate\Http\Request;

class JourneyActivityController extends Controller
{
    /**
     * @OA\Get(
     *  path="/journey/{journey}/activity",
     *  summary="List activities",
     *  description="Get a list of all activities of a journey.",
     *  operationId="journeyActivityList",
     *  tags={"journeyActivity"},
     *  @OA\Parameter(
     *      name="journey",
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
     *          @OA\Items(ref="#/components/schemas/JourneyActivity"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The journey does not exist.",
     *  ),
     * )
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($journey)
    {
        $journey = Journey::findOrFail($journey);
        return JourneyActivityBasicResource::collection($journey->journey_activities);
    }

    /**
     * @OA\Post(
     *  path="/journey/{journey}/activity",
     *  summary="Create activity",
     *  description="Create a new activity for the journey.",
     *  operationId="journeyActivityCreate",
     *  tags={"journeyActivity"},
     *  @OA\Parameter(
     *      name="journey",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="activity_id",
     *      description="The reference to the activity the user starts.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="started_at",
     *      description="The date and time the activity was started.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="date",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="status_id",
     *      description="The reference to the status of the activity.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/JourneyActivity"),
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $journey)
    {
        $journey = Journey::findOrFail($journey);

        $this->validate($request, [
            'activity_id' => 'required|exists:activities,id',
            'started_at' => 'date',
            'status_id' => 'required|exists:status,id',
        ]);

        $journeyActivity = new JourneyActivity;
        $journeyActivity->journey_id = $journey->id;
        $journeyActivity->activity_id = $request->activity_id;
        $journeyActivity->started_at = $request->started_at;
        $journeyActivity->status_id = $request->status_id;
        $journeyActivity->save();

        return new JourneyActivityResource($journeyActivity);
    }

    /**
     * @OA\Get(
     *  path="/journey/{journey}/activity/{id}",
     *  summary="Show activity",
     *  description="Get a single activity from a journey by id.",
     *  operationId="journeyActivityShow",
     *  tags={"journeyActivity"},
     *  @OA\Parameter(
     *      name="journey",
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
     *      @OA\JsonContent(ref="#/components/schemas/JourneyActivity"),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The journey or activity does not exist.",
     *  ),
     * )
     * 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($journey, $id)
    {
        $journey = Journey::findOrFail($journey);
        $journeyActivity = JourneyActivity::findOrFail($id);

        if ($journey->journey_activities->contains($journeyActivity)) {
            return new JourneyActivityResource($journeyActivity);
        } else {
            abort(404);
        }
    }

    /**
     * @OA\Patch(
     *  path="/journey/{journey}/activity/{id}",
     *  summary="Update activity",
     *  description="Update an existing activity of a journey.",
     *  operationId="journeyActivityUpdate",
     *  tags={"journeyActivity"},
     *  @OA\Parameter(
     *      name="journey",
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
     *      name="activity_id",
     *      description="The reference to the activity the user starts.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="started_at",
     *      description="The date and time the activity was started.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="date",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="status_id",
     *      description="The reference to the status of the activity.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/JourneyActivity"),
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $journey, $id)
    {
        $journey = Journey::findOrFail($journey);
        $journeyActivity = JourneyActivity::findOrFail($id);

        if ($journey->journey_activities->contains($journeyActivity)) {
            $this->validate($request, [
                'activity_id' => 'exists:activities,id',
                'started_at' => 'date',
                'status_id' => 'exists:status,id',
            ]);

            if (isset($request->activity_id)) $journeyActivity->activity_id = $request->activity_id;
            if (isset($request->started_at)) $journeyActivity->started_at = $request->started_at;
            if (isset($request->status_id)) $journeyActivity->status_id = $request->status_id;
            $journeyActivity->save();

            return new JourneyActivityResource($journeyActivity);
        } else {
            abort(404);
        }
    }

    /**
     * @OA\Delete(
     *  path="/journey/{journey}/activity/{id}",
     *  summary="Delete activity",
     *  description="Delete an activity of a journey.",
     *  operationId="journeyActivityDelete",
     *  tags={"journeyActivity"},
     *  @OA\Parameter(
     *      name="journey",
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
     *      description="The journey or activity does not exist.",
     *  ),
     * )
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($journey, $id)
    {
        $journey = Journey::findOrFail($journey);
        $journeyActivity = JourneyActivity::findOrFail($id);

        if ($journey->journey_activities->contains($journeyActivity)) {
            $journeyActivity->delete();
        } else {
            abort(404);
        }
    }
}
