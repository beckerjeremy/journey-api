<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JourneyAction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'journey_activity_id', 'action_id', 'started_at', 'status_id', 'input_id',
    ];

    /**
     * The journey activity the action belongs to.
     * 
     * @return JourneyActivity
     */
    public function journey_activity() {
        return $this->belongsTo(JourneyActivity::class);
    }

    /**
     * The action the user can perform.
     * 
     * @return Action
     */
    public function action() {
        return $this->belongsTo(Actions::class);
    }

    /**
     * The status of the action.
     * 
     * @return Status
     */
    public function status() {
        return $this->belongsTo(Status::class);
    }

    /**
     * The input attached to the action.
     * 
     * @return Input
     */
    public function input() {
        return $this->belongsTo(Input::class);
    }
}
