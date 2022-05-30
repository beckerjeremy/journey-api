<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  required={"name"},
 *  @OA\Xml(name="InputType"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="name", type="string", example="Image"),
 *  @OA\Property(property="description", type="string", example="The user has to submit an image input."),
 *  @OA\Property(property="class_name", type="string", example="App\\Models\\ImageInput"),
 *  @OA\Property(property="created_at", type="date", example="2022-05-25 22:15:23"),
 *  @OA\Property(property="updated_at", type="date", example="2022-05-25 22:15:23"),
 * )
 */
class InputType extends Model
{
    //
}
