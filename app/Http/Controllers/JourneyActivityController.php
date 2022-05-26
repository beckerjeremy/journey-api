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
