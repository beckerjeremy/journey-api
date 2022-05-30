<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  required={"name", "status"},
 *  @OA\Xml(name="Journey"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="name", type="string", example="Selfie-box Journey"),
 *  @OA\Property(property="started_at", type="date", example="2022-05-25 22:15:23"),
 *  @OA\Property(property="status", ref="#/components/schemas/Status"),
 *  @OA\Property(property="user", ref="#/components/schemas/User"),
 *  @OA\Property(property="created_at", type="date", example="2022-05-25 22:15:23"),
 *  @OA\Property(property="updated_at", type="date", example="2022-05-25 22:15:23"),
 * )
 */
class Journey extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'started_at', 'status_id', 'user_id',
    ];

    /**
     * The status of the journey.
     * 
     * @return Status
     */
    public function status() {
        return $this->belongsTo(Status::class);
    }

    /**
     * The user the journey belongs to.
     * 
     * @return User
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * The activities of the journey.
     * 
     * @return JourneyActivity[]
     */
    public function journey_activities() {
        return $this->hasMany(JourneyActivity::class);
    }
}
