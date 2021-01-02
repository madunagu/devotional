<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tag' => 'string|required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $result = Tag::create($data);

        if ($result) {
            return response()->json(['data' => $result], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function get(Request $request)
    {
        $id = (int)$request->route('id');

        if ($tag = Tag::find($id)) {
            return response()->json([
                'data' => $tag
            ], 200);
        } else {
            return response()->json([
                'data' => false
            ], 404);
        }
    }

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'q' => 'nullable|string|min:1'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $query = $request['q'];
        $tags = Tag::where('id', '>', '1'); //TODO: check if this is a valid condition
        if ($query) {
            $tags = $tags->search($query);
        }
        $length = (int) (empty($request['perPage']) ? 15 : $request['perPage']);
        $data = $tags->paginate($length);

        return response()->json(compact('data'));
    }

    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($tag = Tag::find($id)) {
            $tag->delete();
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
