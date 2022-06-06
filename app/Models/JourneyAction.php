<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  required={"journey_activity", "action", "status"},
 *  @OA\Xml(name="JourneyAction"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="journey_activity", ref="#/components/schemas/JourneyActivity"),
 *  @OA\Property(property="action", ref="#/components/schemas/Action"),
 *  @OA\Property(property="started_at", type="date", example="2022-05-25 22:15:23"),
 *  @OA\Property(property="status", ref="#/components/schemas/Status"),
 *  @OA\Property(property="input", ref="#/components/schemas/Input"),
 *  @OA\Property(property="created_at", type="date", example="2022-05-25 22:15:23"),
 *  @OA\Property(property="updated_at", type="date", example="2022-05-25 22:15:23"),
 * )
 */
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
        return $this->belongsTo(Action::class);
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
