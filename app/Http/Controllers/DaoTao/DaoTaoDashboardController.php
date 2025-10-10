<?php

namespace App\Http\Controllers\DaoTao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaoTaoDashboardController extends Controller
{
    public function index()
    {
        return view('dao-tao.dashboard');
    }
}
