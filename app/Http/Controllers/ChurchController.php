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
            'exists' => 'The specified :attribute field does not exist',
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
            return response()->json($validator->messages(), 400);
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
            'exists' => 'The specified :attribute field does not exist',
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
            'q' => 'string|required'
        ]);

        $q = $request->input('q');

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }


        return;
    }

    public function get(Request $request)
    { }
    public function list(Request $request)
    { }
}
