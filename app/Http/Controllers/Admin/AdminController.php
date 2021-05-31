<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function login() {
        if(Auth::check()) {

            $roles = Auth::check() ? Auth::user()->userRole->pluck('name')->toArray() : [];

            if (in_array('admin', $roles)) {
                return redirect()->route('admindashboard');
            } else if (in_array('subAdmin', $roles)) {
                return redirect()->route('admindashboard');
            } else {
                return redirect()->route('userdashboard');
            }

            return redirect('/');
        }else{
            return view('admin.auth.login');
        }

    }

//    public function authenticate(Request $request){
////        dd($request);
//        // Retrive Input
//        $credentials = $request->only('email', 'password');
//
//        if (Auth::attempt($credentials)) {
//            dd('dd');
//            // if success login
//            $roles = Auth::check() ? Auth::user()->userRole->pluck('name')->toArray() : [];
//
//            dd($roles);
//            return redirect()->route('admindashboard');
//
//            //return redirect()->intended('/details');
//        }
//        // if failed login
////        return redirect('login');
//    }

    public function dashboard() {
 
        $subadmin = User::select('users.*')->leftJoin('role_user','role_user.user_id','=','users.id')->where('users.id', '!=', Auth::id())->where('role_user.role_id', 3)->get();
        $users = User::select('users.*')->leftJoin('role_user','role_user.user_id','=','users.id')->where('users.id', '!=', Auth::id())->where('role_user.role_id', 2)->get();
        $posts = Post::select('posts.*')->get();
        $lastSevenDayPosts = Post::select('posts.*')->whereDate('created_at','>=',date("Y-m-d", strtotime("-7 days")))->whereDate('created_at','<=',date('Y-m-d'))->get();
        $todaysPosts = Post::select('posts.*')->whereDate('created_at','=',date('Y-m-d'))->get();
        $lastOneMonthPosts = Post::select('posts.*')->whereDate('created_at','>=',date("Y-m-d", strtotime("-30 days")))->whereDate('created_at','<=',date('Y-m-d'))->get();
        $userCreatedToday = User::select('users.*')->leftJoin('role_user','role_user.user_id','=','users.id')->where('users.id', '!=', Auth::id())->whereDate('users.created_at','=',date('Y-m-d'))->where('role_user.role_id', 3)->get();

        return view('admin.dashboard',compact('subadmin','users','posts','lastSevenDayPosts','todaysPosts','lastOneMonthPosts','userCreatedToday'));
    }
}
