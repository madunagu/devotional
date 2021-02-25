<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Validator;

use Intervention\Image\ImageManagerStatic as ImageManager;
use App\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function create(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'photos' => 'required',
            'photos.*' => 'mimes:jpg,png,gif'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $userId = Auth::user()->id;
        $data = [];

        if ($request->hasfile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $name = time() . '.' . $photo->getClientOriginalExtension();
                Storage::putFileAs('public/images/full', $photo, $name);
                $image_resize = ImageManager::make($photo->getRealPath());

                $image_resize->resize(500, 500);
                $image_resize->save('images/replacer');
                $save = Storage::putFileAs("public/images/large", new File('images/replacer'), $name);

                $image_resize->resize(200, 200);
                $image_resize->save('images/replacer');
                $save = Storage::putFileAs("public/images/medium", new File('images/replacer'), $name);

                $image_resize->resize(100, 100);
                $image_resize->save('images/replacer');

                $save = Storage::putFileAs("public/images/small", new File('images/replacer'), $name);

                $image = Image::create([
                    'photo' => $photo,
                    'full' => 'images/full/' . $name,
                    'large' => 'images/large/' . $name,
                    'medium' => 'images/medium/' . $name,
                    'small' => 'images/small/' . $name,
                    'user_id' => $userId
                ]);

                $data[] = $image;
            }
        }


        if ($data) {
            return response()->json(['data' => $data], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }



    public function get(Request $request)
    {
        $id = (int)$request->route('id');
        if ($image = Image::find($id)) {
            return response()->json([
                'data' => $image
            ], 200);
        } else {
            return response()->json([
                'data' => false
            ], 404);
        }
    }


    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($image = Image::find($id)) {
            $image->delete();
            return response()->json([
                'data' => true
            ], 200);
        } else {
            return response()->json([
                'data' => false
            ], 404);
        }
    }
}
