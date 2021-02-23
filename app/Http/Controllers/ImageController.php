<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;

use App\Image;

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
                $name = time() . '.' . $photo->extension();
                $photoSrc =  'images/full/';
                $ss = $photo->getClientOriginalName();
                Storage::putFileAs('public/images/full', $photo, $name);
                // $image = Image::find(1)->resizeImage($photo, ['width' => 120, 'crop' => true]);
                // $image->uploadImage();
                $image = Image::create(['full_url' => $photoSrc . $name, 'avatar_url' => $ss, 'user_id' => $userId]);
                $data[] = $image;
            }
        }


        // $result = Image::insert($data);

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
