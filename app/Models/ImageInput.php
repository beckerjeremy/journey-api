<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  required={"name"},
 *  @OA\Xml(name="ImageInput"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="file_url", type="string", example="http://targeturl.com/uploads/images/name.png"),
 *  @OA\Property(property="type", type="string", example="png"),
 *  @OA\Property(property="size", type="integer", example="3453979"),
 *  @OA\Property(property="created_at", type="date", example="2022-05-25 22:15:23"),
 *  @OA\Property(property="updated_at", type="date", example="2022-05-25 22:15:23"),
 * )
 */
class ImageInput extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'file_url', 'type', 'width', 'height',
    ];

    /**
     * The parent input object.
     * 
     * @return Input
     */
    public function input() {
        return $this->morphOne(Input::class, 'data_type');
    }
}
