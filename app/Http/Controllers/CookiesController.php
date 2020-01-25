<?php

namespace App\Http\Controllers;

use App;

class CookiesController extends Controller
{
    public function index() {
        $https = App::environment() != "local";
        $cookie = cookie("_cookies", true, 1440 * 365, null, null, $https, false);
        return response()->json(["success" => true])->withCookie($cookie);
    }
}
