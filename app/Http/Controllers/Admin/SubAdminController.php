<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Session\Session;
use Illuminate\Auth\Events\Registered;

class SubAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *@return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $roleToInclude = 3;
        $subadmin = User::select('users.*')
        ->leftJoin('role_user','role_user.user_id','=','users.id')
        ->where('users.id', '!=', Auth::id())
        ->where('role_user.role_id', 3)
        ->orderBy('id','desc')
        ->paginate(15);

        $subadminUsers = User::select('users.*')
        ->leftJoin('role_user','role_user.user_id','=','users.id')
        ->where('users.id', '!=', Auth::id())
        ->where('role_user.role_id', 3)
        ->get();
        if(count($subadminUsers)>0){
            foreach($subadminUsers as $subadminUser){
                $date1=date_create(date('Y-m-d',strtotime($subadminUser->change_status_date)));
                $date2=date_create(date('Y-m-d'));
                $diff=date_diff($date1,$date2);
                $days = $diff->format("%R%a");
               if($days > 30){
                    $user = User::where('id',$subadminUser->id)->update([
                        'block_status'      => config('constant.STATUS.BLOCK'),
                        'updated_at'      => date('Y-m-d H:i:s'),
                    ]);
               }
            }
        }
        


        return view('admin.subadmin.index', compact('subadmin','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subadmin.create');
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
            'email' 		=> 'required|unique:users,email|min:4|max:50|regex:^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^',
            'password'		=> 'required|min:8|max:16|regex:/^(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'mobile'        => 'required|numeric|digits_between:8,10|unique:users,mobile',
            'address'       => 'required|min:8|max:255',
        ]);

        $user = User::create([
            'fname'         => $request['fname'],
            'email' 		=> $request['email'],
            'mobile'        => $request['mobile'],
            'address'       => $request['address'],
            'lat'           => $request['lat'],
            'change_status_date'=> date('Y-m-d'),
            'long'          => $request['long'],
            'password'      => Hash::make($request['password']),
            'block_status'  => config('constant.STATUS.UNBLOCK'),
            'acc_id'        => strtoupper(substr($request['fname'], 0, 2)."-".rand(11111,99999)),
        ]);

        if($user['id']){
            UserRole::create([
                'user_id'       => $user['id'],
                'role_id' 		=> 3,
            ]);
        }

        //mail to new subadmin
         $details = [
            'userName'      => $request['fname'],
            'password'      => $request['password'],
            'email' 		=> $request['email'],
        ];  
        event(new Registered($user));

        \Mail::to($request['email'])->send(new \App\Mail\SubAdminCreatedMail($details));

        Controller::writeFile($request->fname.' Account Created Successfully as SubAdmin');

        return redirect()->route('admin.subadmin.index')->with('Success','Subadmin has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subadmin = User::find($id);
        return view('admin.subadmin.show', compact('subadmin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subadmin = User::find($id);
        return view('admin.subadmin.edit', compact('subadmin','id'));
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
        $request->validate([
            'fname'         => 'required|min:4|max:50|regex:/^[\pL0-9\s]+$/u',
            'email' 		=> 'required|unique:users,id|min:4|max:50|regex:^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^',
            'mobile'        => 'required|numeric|digits_between:8,10|unique:users,id',
            'address'       => 'required|min:8|max:255',
        ]);

        User::where('id',$id)->update([
            'fname'         => $request['fname'],
            'email' 		=> $request['email'],
            'mobile'        => $request['mobile'],
            'address'       => $request['address'],
            'lat'           => $request['lat'],
            'long'          => $request['long'], 
        ]);

        Controller::writeFile($request->fname.' Account Updated Successfully');

        return redirect()->route('admin.subadmin.index')->with('Success', 'Subadmin Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeStatus($id, $status)
    {

        if( $status == config('constant.STATUS.UNBLOCK')){
            $user = User::where('id',$id)->update([
                'change_status_date'      => date('Y-m-d'),
            ]);
        }
        $user = User::where('id',$id)->update([
            'block_status'      => $status,
            'updated_at'      => date('Y-m-d H:i:s'),
        ]);

        $subadmin = User::find($id);
        Controller::writeFile('Account '.ucwords(array_search($status,config('constant.STATUS'))).' Successfully of '.$subadmin->fname);
        return redirect()->route('admin.subadmin.index')->with('Success', 'Subadmin '.ucwords(array_search($status,config('constant.STATUS'))).' Successfully');
    }
}
