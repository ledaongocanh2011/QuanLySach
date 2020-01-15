<?php

namespace App\Http\Controllers;

use App\User;

class BookUserController extends Controller
{
    function getUser()
    {
        $user = User::find(1);
        dd($user);
    }
}
