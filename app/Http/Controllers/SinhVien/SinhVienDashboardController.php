<?php

namespace App\Http\Controllers\SinhVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SinhVienDashboardController extends Controller
{
    public function index()
    {
        return view('sinh-vien.dashboard');
    }
}
