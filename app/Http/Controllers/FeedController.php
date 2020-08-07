<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeedController extends Controller
{
    public function load(Request $request)
    {
        $id = Auth::id();
        User::find($id)->followers()->with();
        $feed = 
    }
}
