<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        return view('dashboard/index', [
            'set_active' => 'Dashboard'
        ]);
    }
    public function master_letters()
    {
        return view('dashboard/master_letters', [
            'set_active' => 'master_letters'
        ]);
    }
}