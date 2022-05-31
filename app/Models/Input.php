<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  required={"name"},
 *  @OA\Xml(name="Input"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="name", type="string", example="Take Photo"),
 *  @OA\Property(property="data_type_id", type="integer", example="1"),
 *  @OA\Property(property="data_type_type", type="string", example="App\\Models\\ImageInput"),
 *  @OA\Property(property="created_at", type="date", example="2022-05-25 22:15:23"),
 *  @OA\Property(property="updated_at", type="date", example="2022-05-25 22:15:23"),
 * )
 */
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
