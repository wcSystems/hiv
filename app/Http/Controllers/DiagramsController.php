<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;

class DiagramsController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('diagrams.index')->with('teams',$teams);
    }
}
