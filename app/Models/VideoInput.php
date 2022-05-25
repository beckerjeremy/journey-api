<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $this->morphOne(Input::class, 'data_type');
    }
}