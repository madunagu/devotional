<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Event;
use App\Http\Resources\EventCollection;
use App\Hierarchy;

class HierarchyController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hierarchy_group_id' => 'integer|exists:hierarchy_groups,id',
            'rank' => 'nullable|integer',
            'position_name'=> 'string|max:255',
            'position_slang' => 'nullable|string|max:255',
            'person_name' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id' //TODO: add required if to this
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $result = Hierarchy::create($data);
        //create event emitter or reminder or notifications for those who may be interested

        if ($result) {
            return response()->json(['data'=>true], 201);
        } else {
            return response()->json(['data'=>false,'errors'=>'unknown error occurred'], 400);
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'integer|required|exists:heirarchies,id',
            'hierarchy_group_id' => 'integer|exists:hierarchy_groups,id',
            'rank' => 'nullable|integer',
            'position_name'=> 'string|max:255',
            'position_slang' => 'nullable|string|max:255',
            'person_name' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id' //TODO: add required if to this
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $id = $request->route('id');
        $result = Hierarchy::find($id);
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
        if ($Hierarchy = Hierarchy::find($id)) {
            return response()->json([
            'data' => $Hierarchy
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
        'q' => 'nullable|string|min:3',
        'hierarchy_group_id' => 'nullable|integer|exists:hierarchy_groups,id'
    ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $query = $request['q'];
        $hierarchy_group_id = (int)$request['hierarchy_group_id'];
        $heirarchies = Hierarchy::where('hierarchies.id', '>', '0');
        if ($query) {
            $heirarchies = $heirarchies->search($query);
        }
        //getting heirarchies for just a particular group id
        // which is mainly the default implementation
        if ($hierarchy_group_id) {
            $heirarchies = $heirarchies->where('hierarchy_group_id', $hierarchy_group_id);
        }
        //here insert search parameters and stuff
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $data = $heirarchies->paginate($length);
       // $data = new EventCollection($events);
        return response()->json($data);
    }


    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($hierarchy = Hierarchy::find($id)) {
            $hierarchy->delete();
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
