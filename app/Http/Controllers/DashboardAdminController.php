<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAdminController extends Controller
{
    public $data = [
        'title' => 'Dashboard',
        'modul' => 'Dashboard',
        'parent' => 'DashBoard',
    ];
    public function index()
    {
        return view('dashboardAdmin', $this->data);
    }
}
