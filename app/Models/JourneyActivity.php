<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JourneyActivity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'journey_id', 'activity_id', 'started_at', 'status_id',
    ];

    /**
     * The journey the activity belongs to.
     * 
     * @return Journey
     */
    public function journey() {
        return $this->belongsTo(Journey::class);
    }

    /**
     * The activity the user has can do.
     * 
     * @return Activity
     */
    public function activity() {
        return $this->belongsTo(Activity::class);
    }

    /**
     * The status of the activity.
     * 
     * @return Status
     */
    public function status() {
        return $this->belongsTo(Status::class);
    }

    /**
     * The list of actions the user can perform.
     * 
     * @return JourneyAction[]
     */
    public function journey_actions() {
        return $this->hasMany(JourneyAction::class);
    }
}
