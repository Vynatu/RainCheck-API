<?php

namespace RainCheck\Http\Controllers;

use Illuminate\Http\Request;
use RainCheck\Http\Resources\User\UserResource;

class UsersController extends Controller
{
    public function create(Request $request)
    {
    }

    public function currentUser(Request $request)
    {
        if ($request->user()->can('view', $request->user())) {
            return UserResource::make($request->user());
        }
    }
}
