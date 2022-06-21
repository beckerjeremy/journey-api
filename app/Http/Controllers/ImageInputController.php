<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageInputBasicResource;
use App\Http\Resources\ImageInputResource;
use App\Models\ImageInput;
use App\Models\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageInputController extends Controller
{
    /**
     * @OA\Get(
     *  path="/image",
     *  summary="List images",
     *  description="Get a list of all image inputs.",
     *  operationId="imageInputList",
     *  tags={"imageInput"},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/ImageInput"),
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
        return ImageInputBasicResource::collection(ImageInput::paginate(100));
    }

    /**
     * @OA\Post(
     *  path="/image",
     *  summary="Create image",
     *  description="Create a new image input.",
     *  operationId="imageInputCreate",
     *  tags={"imageInput"},
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
     *      name="image",
     *      description="The image file.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="file",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Created",
     *      @OA\JsonContent(ref="#/components/schemas/ImageInput"),
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
            'image' => 'required|image',
        ]);

        $image = $request->file('image');
        $image_size = $request->file('image')->getSize();
        $image_path = 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
        $image_extension = $image->extension();
        $image_unique = uniqid();
        $image_name = $image_unique . '.' . $image_extension;
        $destination = public_path($image_path);
        File::makeDirectory($destination, 0777, true, true);

        $thumbnail_name = $image_unique . '_thumbnail.' . $image_extension;
        $img = Image::make($image->path());
        $img->resize(200, 200, function ($const) {
            $const->aspectRatio();
        })->save($destination . $thumbnail_name);

        $request->file('image')->move($destination, $image_name);

        $imageInput = new ImageInput;
        $imageInput->file_url = $image_path . $image_name;
        $imageInput->thumbnail_url = $image_path . $thumbnail_name;
        $imageInput->type = $image_extension;
        $imageInput->size = $image_size;
        $imageInput->save();

        $input = new Input;
        $input->name = $request->name;
        $input->input_type_id = $imageInput->id;
        $input->input_type_type = "App\\Models\\ImageInput";
        $input->save();

        return new ImageInputResource($imageInput);
    }

    /**
     * @OA\Get(
     *  path="/image/{id}",
     *  summary="Show image",
     *  description="Get a single image input by id.",
     *  operationId="imageInputShow",
     *  tags={"imageInput"},
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
     *      @OA\JsonContent(ref="#/components/schemas/ImageInput"),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The image input does not exist.",
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
        return new ImageInputResource(ImageInput::findOrFail($id));
    }

    /**
     * @OA\Patch(
     *  path="/image/{id}",
     *  summary="Update image",
     *  description="Update an existing image input.",
     *  operationId="imageInputUpdate",
     *  tags={"imageInput"},
     *  @OA\Parameter(
     *      name="id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="image",
     *      description="The image file.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="file",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/ImageInput"),
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The image input does not exist.",
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
            'image' => 'required|image',
        ]);

        $image = $request->file('image');
        $image_size = $request->file('image')->getSize();
        $image_path = 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
        $image_extension = $image->extension();
        $image_unique = uniqid();
        $image_name = $image_unique . '.' . $image_extension;
        $destination = public_path($image_path);
        File::makeDirectory($destination, 0777, true, true);

        $thumbnail_name = $image_unique . '_thumbnail.' . $image_extension;
        $img = Image::make($image->path());
        $img->resize(200, 200, function ($const) {
            $const->aspectRatio();
        })->save($destination . $thumbnail_name);

        $request->file('image')->move($destination, $image_name);

        $imageInput = ImageInput::findOrFail($id);
        $imageInput->file_url = $image_path . $image_name;
        $imageInput->thumbnail_url = $image_path . $thumbnail_name;
        $imageInput->type = $image_extension;
        $imageInput->size = $image_size;
        $imageInput->save();

        return new ImageInputResource($imageInput);
    }

    /**
     * @OA\Delete(
     *  path="/image/{id}",
     *  summary="Delete image",
     *  description="Delete an image input.",
     *  operationId="imageInputDelete",
     *  tags={"imageInput"},
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
     *      description="The image input does not exist.",
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
        $imageInput = ImageInput::findOrFail($id);
        if ($imageInput->input) $imageInput->input->delete();
        $imageInput->delete();
    }
}
