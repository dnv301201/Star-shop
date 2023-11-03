<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Dd;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.users.login',
        ['title' => 'Quản lý hệ thống']);
    }
}