<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  required={"name"},
 *  @OA\Xml(name="Activity"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="name", type="string", example="Photos"),
 *  @OA\Property(property="description", type="string", example="Take two photos in the selfie box."),
 *  @OA\Property(property="created_at", type="date", example="2022-05-25 22:15:23"),
 *  @OA\Property(property="updated_at", type="date", example="2022-05-25 22:15:23"),
 * )
 */
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
