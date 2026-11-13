<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableController extends Controller
{
    
    public function index()
    {
        if (user() && user()->hasRole('Super Admin')) {
            return redirect()->route('superadmin.dashboard');
        }

        if (!restaurant() || !branch()) {
            return redirect()->route('dashboard');
        }

        abort_if(!in_array('Table', restaurant_modules()), 403);
        abort_if((!user_can('Show Table')), 403);
        return view('table.index');
    }

}
