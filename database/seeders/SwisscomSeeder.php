<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SwisscomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Activities
        if (Activity::where('name', 'Selfie-box Photo')->count() === 0) Activity::create(['id' => 1, 'name' => 'Selfie-box Photo', 'description' => 'Take two photos in the selfie-box.']);
        if (Activity::where('name', 'Selfie-box Video')->count() === 0) Activity::create(['id' => 2, 'name' => 'Selfie-box Video', 'description' => 'Film a short video in the selfie-box.']);

        // Create Actions
        if (Action::where('name', 'First photo aspect ratio')->count() === 0) Action::create(['activity_id' => 1, 'input_type_id' => 3, 'input_required' => 1, 'name' => 'First photo aspect ratio', 'description' => 'Choose the aspect ratio the first photo will be shot with.']);
        if (Action::where('name', 'First photo background image')->count() === 0) Action::create(['activity_id' => 1, 'input_type_id' => 1, 'input_required' => 1, 'name' => 'First photo background image', 'description' => 'Choose the background image for the first photo.']);
        if (Action::where('name', 'First photo')->count() === 0) Action::create(['activity_id' => 1, 'input_type_id' => 1, 'input_required' => 1, 'name' => 'First photo', 'description' => 'Take the first photo.']);
        if (Action::where('name', 'Second photo aspect ratio')->count() === 0) Action::create(['activity_id' => 1, 'input_type_id' => 3, 'input_required' => 1, 'name' => 'Second photo aspect ratio', 'description' => 'Choose the aspect ratio the second photo will be shot with.']);
        if (Action::where('name', 'Second photo background image')->count() === 0) Action::create(['activity_id' => 1, 'input_type_id' => 1, 'input_required' => 1, 'name' => 'Second photo background image', 'description' => 'Choose the background image for the second photo.']);
        if (Action::where('name', 'Second photo')->count() === 0) Action::create(['activity_id' => 1, 'input_type_id' => 1, 'input_required' => 1, 'name' => 'Second photo', 'description' => 'Take the second photo.']);

        if (Action::where('name', 'Video aspect ratio')->count() === 0) Action::create(['activity_id' => 2, 'input_type_id' => 3, 'input_required' => 1, 'name' => 'Video aspect ratio', 'description' => 'Choose the aspect ratio the Video will be shot with.']);
        if (Action::where('name', 'Video background image')->count() === 0) Action::create(['activity_id' => 2, 'input_type_id' => 1, 'input_required' => 1, 'name' => 'Video background image', 'description' => 'Choose the background image for the video.']);
        if (Action::where('name', 'Video')->count() === 0) Action::create(['activity_id' => 2, 'input_type_id' => 2, 'input_required' => 1, 'name' => 'Video photo', 'description' => 'Shoot video.']);
    }
}
