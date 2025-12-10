<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Redirect ke analytics
        return redirect()->route('admin.analytics');
    }
}