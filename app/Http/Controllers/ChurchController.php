<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Church;
use Illuminate\Support\Facades\Auth;


class ChurchController extends Controller
{
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

        $data = collect(request()->all())->toArray();
        $data['user_id'] = Auth::user()->id;
        $result = Church::create($data);

        if ($result) {
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }


    public function update(Request $request)
    {
        $validationMessages = [
            'required' => 'The :attribute field is required.',
            'exists' => 'The specified :attribute field reference id does not exist',
            'integer' => 'The :attribute is of invalid type'
        ];
        $validator = Validator::make(request()->all(), [
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

        $data = collect(request()->all())->toArray();

        $result = $this->customer->update($data);

        if ($result) {
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }

    public function search(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'q' => 'nullable|string'
        ]);

        $q = $request->input('q');

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        return;
    }

    public function get(Request $request)
    {
        $id = (int)$request->input('id');
        if ($church = Church::find($id)) {
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
        $query = $request['q'];
        //here insert search parameters and stuff
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $churches = Church::paginate($length);
        $data = new ChurchCollection($churches);
        return response()->json($data);
    }
    public function delete(Request $request)
    {
        $id = (int)$request->input('id');
        if (Church::find($id)->delete()) {
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
