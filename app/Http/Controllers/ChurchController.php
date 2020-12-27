<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Church;
use App\Http\Resources\ChurchCollection;
use App\Traits\Interactable;

class ChurchController extends Controller
{
    use Interactable;
    public function create(Request $request)
    {
        $validationMessages = [
            'required' => 'The :attribute field is required.',
            'exists' => 'The specified :attribute reference id does not exist',
            'integer' => 'The :attribute is of invalid type'
        ];
        $validator = Validator::make(request()->all(), [
            'name' => 'string|required|max:255',
            'alternate_name' => 'nullable|string',
            'slogan' => 'nullable|string',
            'parent_id' => 'nullable|integer|exists:churches,id',
            'leader_id' => 'nullable|integer|exists:users,id',
            'address_id' => 'nullable|integer|exists:addresses,id',
            'profile_media_id' => 'nullable|integer|exists:profile_media,id',
            'description' => 'nullable|string'
        ], $validationMessages);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;
        $result = Church::create($data);

        $saved = $this->saveRelated($data, $result);
        if ($result) {
            return response()->json(['data' => $saved], 201);
        } else {
            return response()->json(false, 500);
        }
    }


    public function update(Request $request)
    {
        //first check if the updater is the creating user here

        $id = $request->route('id');
        $validationMessages = [
            'required' => 'The :attribute field is required.',
            'exists' => 'The specified :attribute field reference id does not exist',
            'integer' => 'The :attribute is of invalid type'
        ];
        $validator = Validator::make($request->all(), [
            'id' => 'integer|required|exists:churches,id',
            'name' => 'string|required',
            'slogan' => 'nullable|string',
            'parent_id' => 'nullable|integer|exists:churches,id',
            'leader_id' => 'nullable|integer|exists:users,id',
            'address_id' => 'nullable|integer|exists:addresses,id',
            'profile_media_id' => 'nullable|integer|exists:profile_media,id',
            'description' => 'nullable|string'
        ], $validationMessages);


        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $data = collect($request->all())->toArray();

        $church = Church::find($id);

        $saved = $this->saveRelated($church);
        $result = $church->update($data);

        if ($result) {
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }

    public function get(Request $request)
    {
        $userId = Auth::user()->id;
        $id = (int)$request->route('id');
        if ($church = Church::withCount('comments')
            ->with('comments')
            ->with('leader')
            ->with('user')
            ->with('addresses')
            ->with('profileMedia')
            ->withCount([
                'likes',
                'likes as liked' => function (Builder $query) use ($userId) {
                    $query->where('user_id', $userId);
                },
            ])->withCount([
                'views',
                'views as viewed' => function (Builder $query) use ($userId) {
                    $query->where('user_id', $userId);
                },
            ])->find($id)

        ) {
            $church->views()->create([
                'user_id' => $userId,
                'viewable_id' => $id,
                'viewable_type' => 'audio'
            ]);
            return response()->json([
                'data' => $church
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
        //hq is true when searching for only mother churches
        $hq = $request['hq'];
        // parent_id  is set when searching through the children of a particular mother church
        $parent_id = (int)$request['parent_id'];
        $churches = Church::where('churches.id', '>', '0')->with('addresses')->with('profileMedia');
        if ($query) {
            // $churches = $churches->search($query);
            $churches = Church::search($query)->get();
        }

        if ($hq) {
            $churches->where('parent_id', '0');
        }

        if ($parent_id) {
            $churches->where('parent_id', $parent_id);
        }
        //here insert search parameters and stuff
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        // $churches = $churches->paginate($length);
        // $data = new ChurchCollection($churches);
        return response()->json($churches);
    }

    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($church = Church::find($id)) {
            $church->delete();
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
