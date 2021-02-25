<?php

namespace App\Http\Controllers;

use App\Devotional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Validator;

use App\Http\Resources\DevotionalCollection;
use App\Traits\Interactable;


class DevotionalController extends Controller
{
    use Interactable;

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|required|max:255',
            'opening_prayer' => 'string|nullable',
            'closing_prayer' => 'string|nullable',
            'body' => 'string|required',
            'memory_verse' => 'string|nullable|max:255',
            'day' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $data['poster_id'] = Auth::user()->id;
        $data['poster_type'] = 'user';
        $result = Devotional::create($data);
        //$saved = $this->saveRelated($data, $result);
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
            'id' => 'integer|required|exists:devotionals,id',
            'title' => 'string|required|max:255',
            'opening_prayer' => 'string',
            'closing_prayer' => 'string',
            'body' => 'string|required',
            'memory_verse' => 'string|required|max:255',
            'day' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $data = collect($request->all())->toArray();
        $data['poster_id'] = Auth::user()->id;
        $data['poster_type'] = 'user';
        $id = $request->route('id');
        $result = Devotional::find($id);
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
        if ($event = Devotional::withCount('comments')
            ->with(['comments', 'poster', 'churches'])
            ->with(['devotees' => function ($query) {
                $query->limit(7);
            }])
            ->withCount([
                'devotees',
                'devotees as devoted' => function (Builder $query) use ($userId) {
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
        $events = Devotional::with('poster')->with(['devotees' => function ($query) {
            $query->limit(7);
        }])->withCount([
            'devotees',
            'devotees as devoted' => function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            },
        ]); //TODO: add participants to the search using heirarchies
        if (!empty($query)) {
            $events = $events->search($query);
        }
        //here insert search parameters and stuff
        $length = (int) (empty($request['perPage']) ? 15 : $request['perPage']);
        $events = $events->paginate($length);
        $data = new DevotionalCollection($events);
        return response()->json($data);
    }

    public function devote(Request $request)
    {
        $id = $request->route('id');
        $tog = $request['value'];
        $userId = Auth::id();
        $event = Devotional::find((int)$id);
        if ($tog) {
            $event->devotees()->attach($userId);
            return response()->json(['data' => true]);
        }
        $event->devotees()->detach($userId);
        return response()->json(['data' => false]);
    }


    public function delete(Request $request)
    {
        $id = (int) $request->route('id');
        if ($devotional = Devotional::find($id)) {
            $devotional->delete();
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
