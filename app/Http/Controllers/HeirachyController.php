<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Event;
use App\Http\Resources\EventCollection;
use App\Heirachy;

class HeirachyController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|max:255',
            'heirachy_group_id' => 'integer|exists:heirachy_groups,id',
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
        $result = Heirachy::create($data);
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
            'id' => 'integer|required|exists:heirachies,id',
            'name' => 'string|required|max:255',
            'heirachy_group_id' => 'integer|exists:heirachy_groups,id',
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
        $result = Heirachy::find($id);
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
        if ($heirachy = Heirachy::find($id)) {
            return response()->json([
            'data' => $heirachy
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
        'heirachy_group_id' => 'nullable|integer|exists:heirachy_groups,id'
    ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $query = $request['q'];
        $heirachy_group_id = (int)$request['heirachy_group_id'];
        $heirachies = Heirachy::where('heirachies.id', '>', '0');
        if ($query) {
            $heirachies = $heirachies->search($query);
        }
        //getting heirachies for just a particular group id
        // which is mainly the default implementation
        if ($heirachy_group_id) {
            $heirachies = $heirachies->where('heirachy_group_id', $heirachy_group_id);
        }
        //here insert search parameters and stuff
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $data = $heirachies->paginate($length);
       // $data = new EventCollection($events);
        return response()->json($data);
    }


    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($heirachy = Heirachy::find($id)) {
            $heirachy->delete();
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
