<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  @OA\Xml(name="TextInput"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="text", type="string", example="Take Photo"),
 *  @OA\Property(property="created_at", type="date", example="2022-05-25 22:15:23"),
 *  @OA\Property(property="updated_at", type="date", example="2022-05-25 22:15:23"),
 * )
 */
class TextInput extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'text',
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
