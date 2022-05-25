<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Status::where('name', 'created')->count() === 0) Status::create(['id' => 1, 'name' => 'created']);
        if (Status::where('name', 'started')->count() === 0) Status::create(['id' => 2, 'name' => 'started']);
        if (Status::where('name', 'finished')->count() === 0) Status::create(['id' => 3, 'name' => 'finished']);
        if (Status::where('name', 'closed')->count() === 0) Status::create(['id' => 4, 'name' => 'closed']);
    }
}
