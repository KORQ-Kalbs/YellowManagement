<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IkanModel;

class ikanController extends Controller
{
    public function index()
    {
        $ikan = IkanModel::all();
        return view('ikan.index', compact('ikan'));
    }

    public function create()
    {
        return view('ikan.create');
    }
}
