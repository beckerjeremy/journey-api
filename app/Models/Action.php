<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  required={"name"},
 *  @OA\Xml(name="Activity"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="activity", ref="#/components/schemas/Activity"),
 *  @OA\Property(property="input_type", ref="#/components/schemas/InputType"),
 *  @OA\Property(property="input_required", type="boolean", example="true"),
 *  @OA\Property(property="name", type="string", example="Take Photo"),
 *  @OA\Property(property="description", type="string", example="Now the photo will be taken by the selfie box."),
 *  @OA\Property(property="created_at", type="date", example="2022-05-25 22:15:23"),
 *  @OA\Property(property="updated_at", type="date", example="2022-05-25 22:15:23"),
 * )
 */
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
