<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'activity_id', 'input_type_id', 'input_required', 'name', 'description', 'order_weight',
    ];

    /**
     * The activity the action belongs to.
     * 
     * @return Activity
     */
    public function activity() {
        return $this->belongsTo(Activity::class);
    }

    /**
     * The input type of the action.
     * 
     * @return InputType
     */
    public function input_type() {
        return $this->belongsTo(InputType::class);
    }
}
