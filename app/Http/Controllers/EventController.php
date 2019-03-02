<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\Http\Resources\EventCollection;

class EventController extends Controller
{
  public function create(Request $request){

  $validator = Validator::make($request->all(), [
      'name' => 'string|required|max:255',
      'church_id' => 'nullable|integer|exists:churches,id',
      'starting_at' => 'nullable|string|max:255',
      'ending_at' => 'nullable|string|max:255',
      'address_id' => 'nullable|integer|exists:addresses,id',
      'profile_media_id' => 'nullable|integer|exists:profile_media,id',
      'heirachy_group_id' => 'nullable|integer|exists:heirachy_groups,id',
  ]);

  if ($validator->fails()) {
      return response()->json($validator->messages(), 422);
  }

  $data = collect($request->all())->toArray();
  $data['uploader_id'] = Auth::user()->id;
  $result = Event::create($data);
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
      'id' => 'integer|required|exists:events,id',
      'name' => 'string|required|max:255',
      'church_id' => 'nullable|integer|exists:churches,id',
      'starting_at' => 'nullable|string|max:255',
      'ending_at' => 'nullable|string|max:255',
      'address_id' => 'nullable|integer|exists:addresses,id',
      'profile_media_id' => 'nullable|integer|exists:profile_media,id',
      'heirachy_group_id' => 'nullable|integer|exists:heirachy_groups,id',
  ]);

    if ($validator->fails()) {
        return response()->json($validator->messages(), 422);
    }

    $data = collect($request->all())->toArray();
    $data['user_id'] = Auth::user()->id;
    $id = $request->route('id');
    $result = Event::find($id);
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
    if ($event = Event::find($id)) {
        return response()->json([
            'data' => $event
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
        'q' => 'nullable|string|min:3'
    ]);
    if ($validator->fails()) {
        return response()->json($validator->messages(), 422);
    }

    $query = $request['q'];
    $events = Event::where('events.id','>','0')->with('church')->with('participants');
    if($query){
        $events = $events->search($query);
    }
    //here insert search parameters and stuff
    $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
    $events = $events->paginate($length);
    $data = new EventCollection($events);
    return response()->json($data);
}


public function delete(Request $request)
{
    $id = (int)$request->route('id');
    if ($event = Event::find($id)) {
        $event->delete();
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
