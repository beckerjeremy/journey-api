<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoInputBasicResource;
use App\Http\Resources\VideoInputResource;
use App\Models\Input;
use App\Models\VideoInput;
use Illuminate\Http\Request;

class VideoInputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VideoInputBasicResource::collection(VideoInput::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1',
            'video' => 'required|file|mimes:avi,mp4,wav,mov,wmv',
        ]);

        $video = $request->file('video');
        $video_path = 'uploads' . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR;
        $video_extension = $video->extension();
        $video_name = uniqid() . $video_extension;
        $destination = public_path($video_path);
        File::makeDirectory($destination, 0777, true, true);
        $request->file('video')->move($destination, $video_name);

        $videoInput = new VideoInput;
        $videoInput->file_url = 'public\/' . $video_path . '\/' .$video_name;
        $videoInput->type = $video_extension;
        $videoInput->size = $video->getSize();
        $videoInput->save();

        $input = new Input;
        $input->name = $request->name;
        $input->data_type_id = $videoInput->id;
        $input->data_type_type = "App\\Models\\VideoInput";
        $input->save();

        return new VideoInputResource($videoInput);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new VideoInputResource(VideoInput::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1',
            'video' => 'required|file|mimes:avi,mp4,wav,mov,wmv',
        ]);

        $video = $request->file('video');
        $video_path = 'uploads' . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR;
        $video_extension = $video->extension();
        $video_name = uniqid() . $video_extension;
        $destination = public_path($video_path);
        File::makeDirectory($destination, 0777, true, true);
        $request->file('video')->move($destination, $video_name);

        $videoInput = new VideoInput;
        $videoInput->file_url = 'public\/' . $video_path . '\/' .$video_name;
        $videoInput->type = $video_extension;
        $videoInput->size = $video->getSize();
        $videoInput->save();

        return new VideoInputResource($videoInput);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $videoInput = VideoInput::findOrFail($id);
        if ($videoInput->input) $videoInput->input->delete();
        $videoInput->delete();
    }
}
