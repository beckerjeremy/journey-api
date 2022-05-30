<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageInputBasicResource;
use App\Http\Resources\ImageInputResource;
use App\Models\ImageInput;
use App\Models\Input;
use Illuminate\Http\Request;

class ImageInputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ImageInputBasicResource::collection(ImageInput::all());
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
            'image' => 'required|image',
        ]);

        $image = $request->file('image');
        $image_path = 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
        $image_extension = $image->extension();
        $image_name = uniqid() . $image_extension;
        $destination = public_path($image_path);
        File::makeDirectory($destination, 0777, true, true);
        $request->file('image')->move($destination, $image_name);

        $imageInput = new ImageInput;
        $imageInput->file_url = 'public\/' . $image_path . '\/' .$image_name;
        $imageInput->type = $image_extension;
        $imageInput->size = $image->getSize();
        $imageInput->save();

        $input = new Input;
        $input->name = $request->name;
        $input->data_type_id = $imageInput->id;
        $input->data_type_type = "App\\Models\\ImageInput";
        $input->save();

        return new ImageInputResource($imageInput);
    }

    /**
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
        $image_path = 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
        $image_extension = $image->extension();
        $image_name = uniqid() . $image_extension;
        $destination = public_path($image_path);
        File::makeDirectory($destination, 0777, true, true);
        $request->file('image')->move($destination, $image_name);

        $imageInput = new ImageInput;
        $imageInput->file_url = 'public\/' . $image_path . '\/' .$image_name;
        $imageInput->type = $image_extension;
        $imageInput->size = $image->getSize();
        $imageInput->save();

        return new ImageInputResource($imageInput);
    }

    /**
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
