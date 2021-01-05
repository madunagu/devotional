<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Validator;

use App\Event;
use App\Http\Resources\EventCollection;
use App\Traits\Interactable;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    use Interactable;

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|max:255',
            'church_id' => 'nullable|integer|exists:churches,id',
            'starting_at' => 'nullable|date',
            'ending_at' => 'nullable|date',
            'address_id' => 'nullable|integer|exists:addresses,id',
            'profile_media_id' => 'nullable|integer|exists:profile_media,id',
            'hierarchy_group_id' => 'nullable|integer|exists:hierarchy_groups,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $data['uploader_id'] = Auth::user()->id;
        $result = Event::create($data);
        $saved = $this->saveRelated($data, $result);
        //create event emmiter or reminder or notifications for those who may be interested

        if ($result) {
            return response()->json(['data' => true], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'integer|required|exists:events,id',
            'name' => 'string|required|max:255',
            'church_id' => 'nullable|integer|exists:churches,id',
            'starting_at' => 'nullable|date',
            'ending_at' => 'nullable|date',
            'address_id' => 'nullable|integer|exists:addresses,id',
            'profile_media_id' => 'nullable|integer|exists:profile_media,id',
            'hierarchy_group_id' => 'nullable|integer|exists:hierarchy_groups,id',
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
            return response()->json(['data' => true], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }

    public function get(Request $request)
    {
        $id = (int) $request->route('id');
        $userId = Auth::user()->id;
        if ($event = Event::withCount('comments')
            ->with(['comments', 'user', 'churches', 'addresses'])
            ->with(['attendees' => function ($query) {
                $query->limit(7);
            }])
            ->withCount([
                'attendees',
                'attendees as attending' => function (Builder $query) use ($userId) {
                    $query->where('user_id', $userId);
                },
            ])
            ->withCount([
                'views',
                'views as viewed' => function (Builder $query) use ($userId) {
                    $query->where('user_id', $userId);
                },
            ])->find($id)
        ) {
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

        $userId = Auth::id();
        $query = $request['q'];
        $events = Event::with('user')->with(['attendees' => function ($query) {
            $query->limit(7);
        }])->withCount([
            'attendees',
            'attendees as attending' => function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            },
        ])->with('profileMedia'); //TODO: add participants to the search using heirarchies
        if (!empty($query)) {
            $events = $events->search($query);
        }
        //here insert search parameters and stuff
        $length = (int) (empty($request['perPage']) ? 15 : $request['perPage']);
        $events = $events->paginate($length);
        $data = new EventCollection($events);
        return response()->json($data);
    }

    // this is a bool function
    public function attend(Request $request)
    {
        $id = $request->route('id');
        $userId = Auth::id();
        $event = Event::find((int)$id);
        $event->attendees()->toggle($userId);


        return response()->json(['data' => true]);
    }


    public function delete(Request $request)
    {
        $id = (int) $request->route('id');
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
