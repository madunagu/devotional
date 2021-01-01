<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Image;

class ImageController extends Controller
{

    public function create(Request $request)
    {
        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;
        $result = Image::create($data);

        if ($result) {
            return response()->json(['data'=>true], 201);
        } else {
            return response()->json(['data'=>false,'errors'=>'unknown error occured'], 400);
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
