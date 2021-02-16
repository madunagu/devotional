<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\ProfileMedia;

class ProfileMediaController extends Controller
{
    public function create(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'logo_url' =>  'nullable|string|max:255',
        //     'profile_image_url' =>  'nullable|string|max:255',
        //     'background_image_url' =>  'nullable|string|max:255',
        //     'color_choice' => 'nullable|string|max:255',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->messages(), 422);
        // }

        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;
        $result = ProfileMedia::create($data);

        if ($result) {
            return response()->json(['data' => $result], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 500);
        }
    }



    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'integer|required|exists:profile_media,id',
            'logo_url' =>  'nullable|string|max:255',
            'profile_image_url' =>  'nullable|string|max:255',
            'background_image_url' =>  'nullable|string|max:255',
            'color_choice' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;
        $id = $request->route('id');
        $result = ProfileMedia::find($id);
        //update result
        $result = $result->update($data);


        if ($result) {
            return response()->json(['data' => true], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function get(Request $request)
    {
        $id = (int)$request->route('id');
        if ($profile_media = ProfileMedia::find($id)) {
            return response()->json([
                'data' => $profile_media
            ], 200);
        } else {
            return response()->json([
                'data' => false
            ], 404);
        }
    }

    public function list(Request $request)
    {
        $profile_media = ProfileMedia::where('profile_media.id', '>', '0');
        //here insert search parameters and stuff
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $data = $profile_media->paginate($length);
        return response()->json($data);
    }


    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($profile_media = ProfileMedia::find($id)) {
            $profile_media->delete();
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
