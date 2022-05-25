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
