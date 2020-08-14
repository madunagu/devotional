<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\HierarchyGroup;

class HierarchyGroupController extends Controller
{
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
        $result = HierarchyGroup::create($data);
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
            'id' => 'integer|required|exists:hierarchy_groups,id',
            'name' => 'string|required|max:255',
            'description'=> 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $id = $request->route('id');
        $result = HierarchyGroup::find($id);
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
        if ($hierarchyGroup = HierarchyGroup::find($id)->with('heirarchies')->get()) {
            return response()->json([
            'data' => $hierarchyGroup
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
    ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $query = $request['q'];
        $hierarchy_groups = HierarchyGroup::where('hierarchy_groups.id', '>', '0')->with('heirarchies');
        if ($query) {
            $hierarchy_groups = $hierarchy_groups->search($query);
        }
        //here insert search parameters and stuff
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $data = $hierarchy_groups->paginate($length);
       // $data = new EventCollection($events);
        return response()->json($data);
    }


    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($heirachy_group = HierarchyGroup::find($id)) {
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
}
