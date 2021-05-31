<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function dashRedirect() {

        $roles = Auth::check() ? Auth::user()->userRole->pluck('name')->toArray() : [];

        if (in_array('admin', $roles)) {
            return redirect()->route('admindashboard');
        } else if (in_array('subAdmin', $roles)) {
            return redirect()->route('admindashboard');
        }

        return redirect()->route('sitehome');
    }
}
