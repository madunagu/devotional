<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Traits\Interactable;
use App\Traits\Orderable;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;


class CommentController extends Controller
{
    use Interactable, Orderable;
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'string|required',
            'parent_id' => 'nullable|numeric|max:255',
            'commentable_id' => 'numeric',
            'commentable_type' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;

        $result = Comment::create($data);
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
            'id' => 'integer|required|exists:addresses,id',
            'parent_id' => 'nullable|numeric|max:255',
            'comment_group_id' => 'numeric|exists:comment_groups,id',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $id = $request->route('id');

        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;
        $result = Comment::find($id);

        $result = $result->update($data);
        if ($result) {
            return response()->json(['data' => true], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function notify_relevant(Comment $comment)
    {
        $url = 'https://getgooglegeourl.com';
        //TODO: find all geolocations for this address
    }

    public function get(Request $request)
    {
        $id = (int)$request->route('id');
        // $address = Address::find($id);
        // return response()->json([
        //         'data' => $address
        //     ], 200);

        if ($comment = Comment::find($id)) {
            return response()->json([
                'data' => $comment
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


        $comments =
            DB::table('comments')
            ->select('comments.id', 'comments.comment', 'comments.user_id', DB::raw('COUNT(cc.id ) AS comments'), DB::raw('COUNT(likes.id) AS likes'))
            ->leftJoin('comments AS cc', 'comments.parent_id', '=', 'comments.id')
            ->leftJoin('likes', 'comments.like_group_id', '=', 'likes.like_group_id')
            ->groupBy('comments.parent_id')
            ->groupBy('likes.like_group_id')
            ->orderBy('comments.' . $orderParams->order,  $orderParams->direction)
            ->get();
        //TODO: check if this is a valid condition

        $length = (int) (empty($request['perPage']) ? 15 : $request['perPage']);
        $data = $comments->paginate($length);

        return response()->json(compact('data'));
    }

    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($comment = Comment::find($id)) {
            $comment->delete();
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
