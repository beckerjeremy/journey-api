<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
