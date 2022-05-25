<?php

namespace App\Http\Controllers;

use App\Http\Resources\JourneyBasicResource;
use App\Http\Resources\JourneyResource;
use App\Models\Journey;
use Illuminate\Http\Request;

class JourneyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return JourneyBasicResource::collection(Journey::all());
    }

    /**
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new JourneyResource(Journey::findOrFail($id));
    }

    /**
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
