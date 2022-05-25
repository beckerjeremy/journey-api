<?php

namespace Database\Seeders;

use App\Models\InputType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InputTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (InputType::where('name', 'Image')->count() === 0) InputType::create(['id' => 1, 'name' => 'Image', 'class_name' => 'App\\Models\\ImageInput']);
        if (InputType::where('name', 'Video')->count() === 0) InputType::create(['id' => 2, 'name' => 'Video', 'class_name' => 'App\\Models\\VideoInput']);
        if (InputType::where('name', 'Text')->count() === 0) InputType::create(['id' => 3, 'name' => 'Text', 'class_name' => 'App\\Models\\TextInput']);
    }
}
