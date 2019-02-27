<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Church;
use Illuminate\Support\Facades\Auth;


class ChurchController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'string|required',
            'alternate_name' => 'string',
            'slogan' => 'string',
            'parent_id' => 'integer|exists:churches',
            'leader_id' => 'integer | exists:users',
            'address_id' => 'integer|exists:addresses',
            'profile_media_id' => 'integer|exists:profile_media',
            'description' => 'string'
        ]);

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
        $validator = Validator::make(request()->all(), [
            'id' => 'integer|required|exists:churches',
            'name' => 'string|required',
            'slogan' => 'string',
            'parent_id' => 'integer|exists:churches',
            'leader_id' => 'integer | exists:users',
            'address_id' => 'integer|exists:addresses',
            'profile_media_id' => 'integer|exists:profile_media',
            'description' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $data = collect(request()->all())->toArray();

        if ($data['oldpassword'] == null) {
            $data = collect(request()->input())->except(['oldpassword', 'password', 'password_confirmation'])->toArray();
        } else {
            if (Hash::check($data['oldpassword'], auth()->guard('customer')->user()->password)) {
                $data = collect(request()->input())->toArray();

                $data['password'] = bcrypt($data['password']);
            } else {
                return response()->json('Old password does not match', 200);
            }
        }

        $result = $this->customer->update($data);

        if ($result) {
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }

    public function search(Request $request){
      $validator = Validator::make(request()->all(), [
          'q' => 'string|required'
      ]);

      $q = $request->input('q');

      if ($validator->fails()) {
          return response()->json($validator->messages(), 400);
      }


      return ;
    }

    public function get(Request $request){}
    public function list(Request $request){}
}
