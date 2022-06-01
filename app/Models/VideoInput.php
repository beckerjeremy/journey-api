<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  required={"name"},
 *  @OA\Xml(name="VideoInput"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="file_url", type="string", example="http://targeturl.com/uploads/videos/name.png"),
 *  @OA\Property(property="type", type="string", example="mp4"),
 *  @OA\Property(property="size", type="integer", example="29480381"),
 *  @OA\Property(property="duration", type="integer", example="10"),
 *  @OA\Property(property="created_at", type="date", example="2022-05-25 22:15:23"),
 *  @OA\Property(property="updated_at", type="date", example="2022-05-25 22:15:23"),
 * )
 */
class VideoInput extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'file_url', 'type', 'width', 'height', 'duration',
    ];

    /**
     * The parent input object.
     * 
     * @return Input
     */
    public function input() {
        return $this->morphOne(Input::class, 'input_type');
    }
}
