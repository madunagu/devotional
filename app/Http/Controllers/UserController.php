<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|max:255',
            'email' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
     
        $result = User::create($data);

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
            'name' => 'string|required|max:255',
            'email' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $id = $request->route('id');

        $data = collect($request->all())->toArray();
        $result = User::find($id);
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

        if ($user = User::find($id)) {
            return response()->json([
                'data' => $user
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
        $users = User::where('id', '>', '1'); //TODO: check if this is a valid condition
        if ($query) {
            $users = $users->search($query);
        }
        $length = (int) (empty($request['perPage']) ? 15 : $request['perPage']);
        $data = $users->paginate($length);

        return response()->json(compact('data'));
    }

    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($user = User::find($id)) {
            $user->delete();
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
