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
            if (isset($request->input_id)) $journeyAction->input_it = $request->input_id;
            $journeyAction->save();
            
            return new JourneyActionResource($journeyAction);
        } else {
            abort(404);
        }
    }

    /**
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
