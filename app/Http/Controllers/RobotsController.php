<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RobotsController extends Controller
{
    public function index() {
        return response(view("robots"))->header("Content-Type", "text/plain");
    }
}
