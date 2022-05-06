<?php

namespace App\Http\Controllers\Sieges;

use App\Http\Controllers\Controller;
use App\Models\Siege;

class ViewController extends Controller
{
    public function __invoke(Siege $siege)
    {
        return view('siege.details', compact('siege'));
    }
}
