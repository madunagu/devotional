<?php

namespace App\Http\Controllers;

use App\Post;
use App\Traits\Interactable;
use App\Traits\Orderable;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use Interactable, Orderable;
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|nullable',
            'body' => 'string|required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;

        $result = Post::create($data);
        //TODO: notify relevant users of activity

        if ($result) {
            return response()->json(['data' => $result], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|nullable',
            'body' => 'string|required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $id = $request->route('id');

        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;
        $result = Post::find($id);

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
        // $address = Address::find($id);
        // return response()->json([
        //         'data' => $address
        //     ], 200);

        if ($post = Post::find($id)) {
            return response()->json([
                'data' => $post
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
            'q' => 'nullable|string|min:1',
            'o' => 'nullable|string|min:1',
            'd' => 'nullable|string|min:1'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $params = $data = collect($request->all())->toArray();
        $orderParams = $this->orderParams($params);
        $length = (int) (empty($request['perPage']) ? 15 : $request['perPage']);

        $comments = Post::with('user')->withCount('likes')->withCount('comments')->withCount('views')
            ->orderBy('posts.' . $orderParams->order,  $orderParams->direction)
            ->paginate($length);

        return response()->json($comments);
    }

    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($post = Post::find($id)) {
            $post->delete();
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
