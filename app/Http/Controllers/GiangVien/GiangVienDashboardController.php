<?php

namespace App\Http\Controllers\GiangVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GiangVienDashboardController extends Controller
{
    public function index()
    {
        return view('giang-vien.dashboard');
    }
}
