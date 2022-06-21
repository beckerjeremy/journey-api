<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoInputBasicResource;
use App\Http\Resources\VideoInputResource;
use App\Models\Input;
use App\Models\VideoInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VideoInputController extends Controller
{
    /**
     * @OA\Get(
     *  path="/video",
     *  summary="List videos",
     *  description="Get a list of all video inputs.",
     *  operationId="videoInputList",
     *  tags={"videoInput"},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/VideoInput"),
     *      ),
     *  ),
     * )
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VideoInputBasicResource::collection(VideoInput::paginate(100));
    }

    /**
     * @OA\Post(
     *  path="/video",
     *  summary="Create video",
     *  description="Create a new video input.",
     *  operationId="videoInputCreate",
     *  tags={"videoInput"},
     *  @OA\Parameter(
     *      name="name",
     *      description="The name of the input.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="video",
     *      description="The video file.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="file",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Created",
     *      @OA\JsonContent(ref="#/components/schemas/VideoInput"),
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     * )
     * 
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
        $video_size = $request->file('video')->getSize();
        $video_path = 'uploads' . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR;
        $video_extension = $video->extension();
        $video_name = uniqid() . '.' . $video_extension;
        $destination = public_path($video_path);
        File::makeDirectory($destination, 0777, true, true);
        $request->file('video')->move($destination, $video_name);

        $videoInput = new VideoInput;
        $videoInput->file_url = $video_path . '/' .$video_name;
        $videoInput->type = $video_extension;
        $videoInput->size = $video_size;
        $videoInput->save();

        $input = new Input;
        $input->name = $request->name;
        $input->input_type_id = $videoInput->id;
        $input->input_type_type = "App\\Models\\VideoInput";
        $input->save();

        return new VideoInputResource($videoInput);
    }

    /**
     * @OA\Get(
     *  path="/video/{id}",
     *  summary="Show video",
     *  description="Get a single video input by id.",
     *  operationId="videoInputShow",
     *  tags={"videoInput"},
     *  @OA\Parameter(
     *      name="id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/VideoInput"),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The video input does not exist.",
     *  ),
     * )
     * 
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
     * @OA\Patch(
     *  path="/video/{id}",
     *  summary="Update video",
     *  description="Update an existing video input.",
     *  operationId="videoInputUpdate",
     *  tags={"videoInput"},
     *  @OA\Parameter(
     *      name="id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="video",
     *      description="The video file.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="file",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/VideoInput"),
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The video input does not exist.",
     *  ),
     * )
     * 
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
        $video_size = $request->file('video')->getSize();
        $video_path = 'uploads' . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR;
        $video_extension = $video->extension();
        $video_name = uniqid() . '.' . $video_extension;
        $destination = public_path($video_path);
        File::makeDirectory($destination, 0777, true, true);
        $request->file('video')->move($destination, $video_name);

        $videoInput = VideoInput::findOrFail($id);
        $videoInput->file_url = $video_path . '/' .$video_name;
        $videoInput->type = $video_extension;
        $videoInput->size = $video_size;
        $videoInput->save();

        return new VideoInputResource($videoInput);
    }

    /**
     * @OA\Delete(
     *  path="/video/{id}",
     *  summary="Delete video",
     *  description="Delete a video input.",
     *  operationId="videoInputDelete",
     *  tags={"videoInput"},
     *  @OA\Parameter(
     *      name="id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The video input does not exist.",
     *  ),
     * )
     * 
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
