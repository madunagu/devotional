<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Address;

class AddressController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address1' => 'string|required|max:255',
            'address2' => 'nullable|string|max:255',
            'country' => 'string|required|max:255',
            'state' => 'string|required|max:255',
            'city' => 'string|required|max:255',
            'postal_code' => 'nullable|string|max:20',
            'default_address' => 'nullable|boolean',
            'name' =>  'nullable|string|max:255',
            'longitude' => 'nullable|numeric|max:255',
            'latitude' => 'nullable|numeric|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;

        $result = Address::create($data);
        //obtain longitude and latitude if they werent set
        if (!$result->longitude || !$result->latitude) {
            //que set latitude and longitude event
            $this->find_address_geolocation($result);
        }

        if ($result) {
            return response()->json(['data'=>$result], 201);
        } else {
            return response()->json(['data'=>false,'errors'=>'unknown error occured'], 400);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=> 'integer|required|exists:addresses,id',
            'address1' => 'string|required|max:255',
            'address2' => 'nullable|string|max:255',
            'country' => 'string|required|max:255',
            'state' => 'string|required|max:255',
            'city' => 'string|required|max:255',
            'postal_code' => 'nullable|integer|max:20',
            'default_address' => 'nullable|boolean',
            'name' =>  'nullable|string|max:255',
            'longitude' => 'nullable|float|max:255',
            'latitude' => 'nullable|float|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $id = $request->route('id');

        $data = collect($request->all())->toArray();
        $data['user_id'] = Auth::user()->id;
        $result = Address::find($id);
        //obtain longitude and latitude if they werent set
        if (!$result->longitude || !$result->latitude) {
            //que set latitude and longitude event
            $this->find_address_geolocation($result);
        }
        $result = $result->update($data);
        if ($result) {
            return response()->json(['data'=>true], 201);
        } else {
            return response()->json(['data'=>false,'errors'=>'unknown error occured'], 400);
        }
    }

    public function find_address_geolocation(Address $address)
    {
    }

    public function get(Request $request)
    {
        $id = (int)$request->route('id');
        // $address = Address::find($id);
        // return response()->json([
        //         'data' => $address
        //     ], 200);
       
        if ($address = Address::find($id)) {
            return response()->json([
                'data' => $address
            ], 200);
        } else {
            return response()->json([
                'data' => false
            ], 404);
        }
    }

    public function list(Request $request)
    {
        //here insert search parameters and stuff
        $length = (int)(empty($request['perPage']) ? 15 : $request['perPage']);
        $data = Address::paginate($length);
        return response()->json(compact('data'));
    }

    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        if ($address = Address::find($id)) {
            $address->delete();
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
