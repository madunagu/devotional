<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\HeirachyGroup;

class HeirachyGroupController extends Controller
{
    private $mini;
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|max:255',
            'description'=> 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $result = HeirachyGroup::create($data);
        //create event emmiter or reminder or notifications for those who may be interested

        if ($result) {
            return response()->json(['data'=>true], 201);
        } else {
            return response()->json(['data'=>false,'errors'=>'unknown error occured'], 400);
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'integer|required|exists:heirachy_groups,id',
            'name' => 'string|required|max:255',
            'description'=> 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $id = $request->route('id');
        $result = HeirachyGroup::find($id);
        //update result
        $result = $result->update($data);


        if ($result) {
            return response()->json(['data'=>true], 201);
        } else {
            return response()->json(['data'=>false,'errors'=>'unknown error occured'], 400);
        }
    }

    public function get(Request $request)
    {
        $id = (int)$request->route('id');
        if ($heirachyGroup = HeirachyGroup::find($id)) {
            return response()->json([
            'data' => $heirachyGroup
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
        ".env('q')"
    ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $query = $request['q'];
        $heirachy_groups = HeirachyGroup::where('heirachy_groups.id', '>', '0')->with('heirachies');
        if ($query) {
            $heirachy_groups = $heirachy_groups->search($query);
        }
        //here insert search parameters and stuff
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $data = $heirachy_groups->paginate($length);
       // $data = new EventCollection($events);
        return response()->json($data);
    }


    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($heirachy_group = HeirachyGroup::find($id)) {
            $heirachy_group->delete();
            return response()->json([
            'data' => true
        ], 200);
        } else {
            return response()->json([
            'data' => false
        ], 404);
        }
    }

    public function restore($id)
    {
        $id = HeirachyGroup::onlyTrashed()->findorFail($id)->restore();
        return response()->json([
            'data' => true
        ], 200);
    }
}
