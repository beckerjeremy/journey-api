<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'data_type_id', 'data_type_type',
    ];

    /**
     * The journey action the input belongs to.
     * 
     * @return JourneyAction
     */
    public function journey_action() {
        return $this->hasOne(JourneyAction::class);
    }

    /**
     * The specialized type of the input.
     * 
     * @return Object
     */
    public function data_type() {
        return $this->morphTo();
    }
}
