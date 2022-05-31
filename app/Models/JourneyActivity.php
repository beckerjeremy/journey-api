<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  required={"journey", "activity", "status"},
 *  @OA\Xml(name="JourneyActivity"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="journey", ref="#/components/schemas/Journey"),
 *  @OA\Property(property="activity", ref="#/components/schemas/Activity"),
 *  @OA\Property(property="started_at", type="date", example="2022-05-25 22:15:23"),
 *  @OA\Property(property="status", ref="#/components/schemas/Status"),
 *  @OA\Property(property="created_at", type="date", example="2022-05-25 22:15:23"),
 *  @OA\Property(property="updated_at", type="date", example="2022-05-25 22:15:23"),
 * )
 */
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
