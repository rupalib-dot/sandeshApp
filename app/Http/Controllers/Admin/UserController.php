<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('users.*')->where('users.id', '!=', Auth::id())->leftJoin('role_user','role_user.user_id','=','users.id')->where('role_user.role_id', 2)->orderBy('users.id','desc')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fname'         => "required|min:4|max:50|regex:/^[\pL\s\']+$/u",
            'lname'         => "required|min:4|max:50|regex:/^[\pL\s\']+$/u",
            'email' 		=> 'required|unique:users,email|min:4|max:50|regex:^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^',
            'password'		=> 'required|min:8|max:16|regex:/^(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'mobile'        => 'required|numeric|digits_between:8,10|unique:users,mobile',
            'adhaar'        => 'required|numeric|digits:16|regex:/[0-9]{12}/',
            'dob'           => 'required|before:' . now()->toDateString(),
        ]);
        $user = User::create([
            'fname'         => $request['fname'],
            'lname'         => $request['lname'],
            'email' 		=> $request['email'],
            'mobile'        => $request['mobile'],
            'password'      => Hash::make($request['password']),
            'adhaar'        => $request['adhaar'],
            'address'       => $request['address'],
            'dob'           => $request['dob'],
            'acc_id'        => strtoupper(substr($request['fname'], 0, 2)."-".rand(11111,99999)),
        ]);
 
        if($user['id']){
            UserRole::create([
                'user_id'       => $user['id'],
                'role_id' 		=> 3,
            ]);
        }


        return redirect()->route('admin.users.index')->with('Success', 'User has been added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('Success', 'User Deleted Successfully');
    }

    public function changeStatus($id, $status)
    {
        $user = User::where('id',$id)->update([
            'block_status'      => $status,
            'updated_at'      => date('Y-m-d H:i:s'),
        ]);

        $user = User::find($id);
        Controller::writeFile('Account '.ucwords(array_search($status,config('constant.STATUS'))).' Successfully of '.$user->fname);

        return redirect()->route('admin.users.index')->with('Success', 'User '.ucwords(array_search($status,config('constant.STATUS'))).' Successfully');
    }
}
