<?php

namespace RainCheck\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function currentUser(Request $request)
    {
        if ($request->user()->can('view', $request->user()))
            return $request->user();

        return ['no'];
    }
}
