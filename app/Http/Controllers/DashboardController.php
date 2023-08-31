<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public $data = [
        'title' =>'Dashboard',
        'modul' => 'home',
        'parent' => 'dashboard',
    ];

    public function index()
    {
        return view('dashboard', $this->data);
    }
}
