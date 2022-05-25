<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'description',
    ];

    /**
     * The list of actions of the activity.
     * 
     * @return Action[]
     */
    public function actions() {
        return $this->hasMany(Action::class);
    }
}
