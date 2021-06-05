<?php /** @noinspection DuplicatedCode */

namespace App\Http\Controllers\UserPanel;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\ContactInqiry;
use DB;

class HomeController extends Controller
{
    public function index(){
        return view('website.index');
    }
    public function register(){
        return view('website.register');
    }
    public function registeruserform(Request $request) { 
        $niceNames = array(
            'fname'         => "First Name",
            'lname'         => "Surname",
            'email' 		=> "Email address",
            'password'		=> "Password",
            'mobile'        => "Mobile Number",
            'adhaar_file'   => "Adhaar File",
            'adhaar'        => "Adhaar",
            'dob'           => "Date of Birth",
        );

        $request['adhaar'] = str_replace(' ', '', $request->adhaar);
        $requiredvalidation = [
            'fname'         => "required|min:4|max:50|regex:/^[\pL\s\']+$/u",
            'lname'         => "required|min:4|max:50|regex:/^[\pL\s\']+$/u",
            'password'		=> 'required|min:8|max:16|regex:/^(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'mobile'        => 'required|numeric|digits_between:8,11|unique:users,mobile',
            'adhaar_file'   => 'required|nullable|mimes:jpg,png,pdf|max:5120',
            'adhaar'        => 'required|numeric|digits:12|regex:/[0-9]{12}/',
            'dob'           => 'required|before:' . now()->toDateString(),
            'address'       => "required|min:4|max:250",
        ];

        if($request->email) {
            $requiredvalidation += array('email' => 'required|unique:users,email|min:4|max:50|regex:^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^');
        }

        $validationmessages = array(
            'adhaar_file.max' => 'The Adhaar File should not be greater than 5 MB'
        );

        $validatedData = Validator::make($request->all(), $requiredvalidation, $validationmessages)->setAttributeNames($niceNames);

        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
        }

        $addressExist = Controller::getLatLong($request->address);
        if($addressExist != ""){
            $tempUser = new User();
            $tempUser->fill($request->except(['_token']));

            if($request->file('adhaar_file')) {
                $fileName = time().'_'.rand(1111,9999).'.'.$request->file('adhaar_file')->getClientOriginalExtension();
                // $fileName = time().'_'.$request->file('adhaar_file')->getClientOriginalName();
                $request->file('adhaar_file')->storeAs('uploads', $fileName, 'public');
                $tempUser->adhaar_file = time().'_'.$request->file('adhaar_file')->getClientOriginalName();
            }
            $tempUser->lat = $addressExist['latitude'];
            $tempUser->long = $addressExist['longitude'];
            $request->session()->put('tempUser', $tempUser);
            $tempotp = rand(111111,999999);
            $request->session()->put('tempotp', $tempotp);
            $request->session()->put('showOtpModal', 1);

            return redirect()->back();
        }else{
            return redirect()->back()->withInput($request->all())->with('Failed', 'Please select proper address from suggestion list or pick current location');
        }
    }

    public function registeruserotp(Request $request) {
        if($request->otp == Session::get('tempotp')) {
            $userarray = Session::get('tempUser');
            $user = User::create([
                'fname'         => $userarray->fname,
                'lname'         => $userarray->lname,
                'email' 		=> $userarray->email,
                'mobile'        => $userarray->mobile,
                'password'      => Hash::make($userarray->password),
                'adhaar'        => $userarray->adhaar,
                'adhaar_file'   => $userarray->adhaar_file,
                'lat'           => $userarray->lat,
                'long'          => $userarray->long,
                'address'       => $userarray->address,
                'dob'           => date('Y-m-d',strtotime($userarray->dob)),
                'acc_id'        => strtoupper(substr($userarray->fname, 0, 2)."-".rand(11111,99999)),
            ]);

            if($user['id']){
                UserRole::create([
                    'user_id'       => $user['id'],
                    'role_id' 		=> 2,
                ]);
            }
            Session::forget(['tempUser', 'tempotp', 'showOtpModal']);

            return redirect()->route('sitehome')->with('Success', 'User Registered Successfully');
        }

        return redirect()->back()->with('FailedModal', 'Wrong OTP Entered ');
    }

    public function resetuserform(Request $request) {
        if(Storage::disk('public')->exists('uploads/'.Session::get('tempUser')->adhaar_file))
        {
            Storage::disk('public')->delete('uploads/'.Session::get('tempUser')->adhaar_file);
        }
        Session::forget(['tempUser', 'tempotp', 'showOtpModal']);
        return redirect()->route('registeruser');
    }

    public function resendotp(Request $request) {
        $tempotp = rand(111111,999999);
        $request->session()->put('tempotp', $tempotp);

        return redirect()->back();
    }

    public function myprofileUpdate(Request $request) {
        $niceNames = array(
            'fname'         => "First Name",
            'lname'         => "Surname",
            'email' 		=> "Email address",
            // 'dob'           => "Date of Birth",
            'address'       => "Address",
        );
        $request['adhaar'] = str_replace(' ', '', $request->adhaar);
        $requiredvalidation = [
            'fname'         => "required|min:4|max:50|regex:/^[\pL\s\']+$/u",
            'lname'         => "required|min:4|max:50|regex:/^[\pL\s\']+$/u", 
            // 'dob'           => 'required|before:' . now()->toDateString(),
            'address'       => "required|min:4|max:250",
        ];

        if($request->email != Auth::user()->email) {
            $requiredvalidation += array('email' => 'required|unique:users,email|min:4|max:50|regex:^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^');
        }

        $validatedData = Validator::make($request->all(), $requiredvalidation)->setAttributeNames($niceNames);
        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput()
                ->with('openprofilemodal', 'true');
        }
        $addressExist = Controller::getLatLong($request->address); 
        if($addressExist != ""){
            $user = DB::table('users')->where('id', Auth::user()->id)->update([
                'fname'         => $request->fname,
                'lname' 		=> $request->lname,
                'email' 		=> $request->email,
                // 'dob'           => $request->dob,
                'address'       => $request->address,
                'lat'           => $addressExist['latitude'],
                'long'          => $addressExist['longitude'],
            ]); 
            // 
            if(!empty($user)){
                    return redirect()->back()
                        ->with(['Succcessprofile'=> 'Profile Updated Successfully',]);
            }else{
                return redirect()->back()
                        ->with(['Failedprofile'=> 'No changes found in profile',]);
            }
        }else{
            return redirect()->back()->with(['FailedError'=> 'Please select proper address from suggestion list or pick current location','openprofilemodal' => 'true']);
        }
    }

    public function passwordupdate(Request $request) {
        $user = Auth::user();
      
        if( $request->current_password == $request->password ) {
            return redirect()->back()->withInput($request->all())->with(['openpasswordmodal' => 'true',
                'Failedpassword' => 'Current Password cannot be same as New Password !']);
        }
        $validatedData = Validator::make($request->all(), [
            'current_password'      => 'required|min:8|max:16|regex:/^(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'password'              => 'required|confirmed|min:8|max:16|regex:/^(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'password_confirmation'	        => 'required|required_with:password|same:password',
        ])->after(function ($validator) use ($user, $request) {
            if (! isset($request->current_password) || ! Hash::check($request->current_password, $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        });

        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput()
                ->with('openpasswordmodal', 'true');
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();
        // 'openpasswordmodal' => 'true'
        return redirect()->back()->with([
            'Succcesspassword' => 'Password Updated Successfully']);
    }

    public function viewaddmypost() {
        $templates = Template::where('block_status',config('constant.STATUS.UNBLOCK'))->get();

        return view('website.addpost',compact('templates'));
    }
    public function addmypost(Request $request) { 
        $niceNames = array(
            'person_name'       => "First Name",
            'surname'       => "Surname",
            'relation'          => "Relation",
            'description'       => "Description",
            'pocontact'         => "Point of Contact First Name",
            'lname'         => "Point of Contact Last Name",
            'institute'         => "Institute",
            'number'            => "Mobile Number",
            'age'               => "Age",
            'date_of_death'     => "Date of Demise",
            'address'           => "Location",
            'death_certificate' => "Death Certificate",
            'person_pic'        => "Person Photo",
            'swd'               => "S/O W/O D/O M/O F/O H/O", 
            'swdperson'         => "Relative Name",
            'flower_type'       => "Garland Type",
        );

        $requiredvalidation = [
            'person_name'           => "required|min:3|max:50|regex:/^[\pL\s\']+$/u",
            'surname'               => "required|min:3|max:50|regex:/^[\pL\s\']+$/u",
            'relation'              => "required|min:3|max:50|regex:/^[\pL\s\']+$/u",
            'description'           => "required|min:20|max:250",
            'pocontact'             => "required|min:3|max:50|regex:/^[\pL\s\']+$/u",
            'lname'                 => "required|min:3|max:50|regex:/^[\pL\s\']+$/u",
            'institute'             => "nullable|max:50|regex:/^[\pL\s\']+$/u",
            'number'                => 'required|numeric|digits_between:8,11|unique:users,mobile',
            'age'                   => 'date_format:Y-m-d|required|after:1920-01-01|before:date_of_death',
            'date_of_death'         => 'date_format:Y-m-d|required|after:1920-01-01|before:' . Carbon::tomorrow()->toDateString(),
            'address'               => "required|min:4|max:250",
            'death_certificate'     => 'nullable|mimes:jpg,png,pdf|max:5120',
            'person_pic'            => 'required|mimes:jpg,png|max:5120',
            'swd'                   => "required|min:1|max:10", 
            'swdperson'             => "required|min:3|max:50|regex:/^[\pL\s\']+$/u", 
        ];

        $validationmessages = array(
            'death_certificate.max' => 'The Death Certificate should not be greater than 5 MB',
            'person_pic.max'        => 'The Person Photo should not be greater than 5 MB'
        );

        // isset($request->flowers) ? '' : $requiredvalidation['flower_type'] = 'required';

        $validatedData = Validator::make($request->all(), $requiredvalidation, $validationmessages)->setAttributeNames($niceNames);

        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
        }

        $addressExist = Controller::getLatLong($request->address); 
        if($addressExist != ""){
                //        dd($request);

                $death_certificate = null;
                if($request->file('death_certificate')) {
                    $death_certificate = time().'_'.rand(1111,9999).'.'.$request->file('death_certificate')->getClientOriginalExtension();
                    //$death_certificate = time().'_'.$request->file('death_certificate')->getClientOriginalName();
                    $request->file('death_certificate')->storeAs('uploads', $death_certificate, 'public');
                }

                $person_pic = null;
                if($request->file('person_pic')) {
                    $person_pic = time().'_'.rand(1111,9999).'.'.$request->file('person_pic')->getClientOriginalExtension();
                    //$person_pic = time().'_'.$request->file('person_pic')->getClientOriginalName();
                    $request->file('person_pic')->storeAs('uploads', $person_pic, 'public');
                }

                $request['user_id'] = Auth::user()->id;
                $request['age'] = date('Y-m-d',strtotime($request->age));
                $request['date_of_death'] = date('Y-m-d',strtotime($request->date_of_death));

                $flower_type = Null;
                if(isset($request->flowers)){
                    if($request->flower_type == 'y' || $request->flower_type == 'w' || $request->flower_type == 'p'){
                        $flower_type = $request->flower_type;
                    }else{
                        $flower_type = 'y';
                    }
                }
                $request['flower_type'] = $flower_type;

            $request = $request->toArray();
            $request['death_certificate'] = $death_certificate;
            $request['person_pic'] = $person_pic;
            

            Post::create($request);

            if($request['is_draft'] == 1){
                return redirect()->route('showmydraft')->with('Success', 'Post Added To Draft Successfully');
            }else{
                return redirect()->route('showmypost')->with('Success', 'Post Added Successfully');
            }
        }else{
            return redirect()->back()->withInput($request->all())->with('Failed', 'Please select proper address from suggestion list or pick current location');
        }
    }

    public function showmypost(Request $request) {
        $current_url = collect(request()->segments())->last();
        $draft = 0;
        if($current_url == 'mydraft'){
            $draft = 1;
        }
        $myposts = Post::where('user_id', Auth::user()->id)->where('is_draft',$draft)->latest()->paginate(10);
        return view('website.mypost', compact('myposts','current_url'));
    }

    public function showpublicpost(Request $request) {
        $publicpost = Post::where('approval_status', 410)
        ->Where(function($query) use ($request) {
            if (isset($request['address']) && !empty($request['address'])) { 
                $query->where('address','LIKE', "%".$request["address"]."%");
            }  
            if (isset($request['date']) && !empty($request['date'])) { 
                $query->whereDate('created_at',$request['date']);
                $query->orWhere('date_of_death',$request['date']);
            }  
        })->where('is_draft',0)->latest()->paginate(10);
        return view('website.publicpost', compact('publicpost','request'));
    }

    public function mypostdelete( Request $request) {
        $post = Post::where('user_id', Auth::user()->id)->where('id', $request->postid)->first();
        $count = 0;
        if(isset($post)){
            $count = $post->count();
        }
        if($count) {
            $post->delete();
            return redirect()->route('showmypost')->with('Success', 'Post Deleted Successfully');
        }
        return redirect()->route('showmypost')->with('Failed', 'You are not Authorized to Delete this Post');
    }

    public function editmypost(Post $post) {
        if(Auth::user()->id != $post->user_id) {
            abort(404);
        }

        $templates = Template::where('deleted_at',NULL)->where('block_status',config('constant.STATUS.UNBLOCK'))->get();
        return view('website.addpost', compact('post','templates'));
    }
    public function updatemypost (Request $request, Post $post) {

        $niceNames = array(
            'person_name'       => "First Name",
            'surname'       => "Surname",
            'relation'          => "Relation",
            'description'       => "Description",
            'pocontact'         => "Point of Contact First Name",
            'lname'         => "Point of Contact Last Name",
            'institute'         => "Institute",
            'number'            => "Mobile Number",
            'age'               => "Age",
            'date_of_death'     => "Date of Demise",
            'address'           => "Location",
            'death_certificate' => "Death Certificate",
            'swd'                   => "required|min:1|max:10",
            'flower_type'       => "Garland Type",
            'swdperson'         => "Relative Name",
        ); 
 
        $requiredvalidation = [
            'person_name'           => "required|min:3|max:50|regex:/^[\pL\s\']+$/u",
            'surname'               => "required|min:3|max:50|regex:/^[\pL\s\']+$/u",
            'relation'              => "required|min:3|max:50|regex:/^[\pL\s\']+$/u",
            'description'           => "required|min:20|max:250",
            'pocontact'             => "required|min:3|max:50|regex:/^[\pL\s\']+$/u",
            'lname'                 => "required|min:3|max:50|regex:/^[\pL\s\']+$/u",
            'institute'             => "nullable|max:50|regex:/^[\pL\s\']+$/u",
            'number'                => 'required|numeric|digits_between:8,11|unique:users,mobile',
            'age'                   => 'date_format:Y-m-d|required|before:date_of_death',
            'date_of_death'         => 'date_format:Y-m-d|required|before:' . Carbon::tomorrow()->toDateString(),
            'address'               => "required|min:4|max:250",
            'death_certificate'     => 'nullable|mimes:jpg,png,pdf|max:5120',
            'swd'                   => "required|min:1|max:10", 
            'swdperson'                   => "required|min:3|max:50|regex:/^[\pL\s\']+$/u", 
        ];

        isset($post->person_pic) ? '' : $requiredvalidation['person_pic'] = 'required|mimes:jpg,png|max:5120';

        // isset($request->flowers) ? '' : $requiredvalidation['flower_type'] = 'required';

        $validationmessages = array(
            'death_certificate.max' => 'The Death Certificate should not be greater than 5 MB',
            'person_pic.max'        => 'The Person Photo should not be greater than 5 MB'
        );

        $validatedData = Validator::make($request->all(), $requiredvalidation, $validationmessages)->setAttributeNames($niceNames);

        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
        }

        $addressExist = Controller::getLatLong($request->address); 
        if($addressExist != ""){
            $death_certificate = isset($request->death_certificate) ? $request->death_certificate : $post->death_certificate;
            if($request->file('death_certificate')) {
            //            $death_certificate = time().'_'.$request->file('death_certificate')->getClientOriginalName();
                $death_certificate = time().'_'.rand(1111,9999).'.'.$request->file('death_certificate')->getClientOriginalExtension();
                $request->file('death_certificate')->storeAs('uploads', $death_certificate, 'public');
                if(Storage::disk('public')->exists('uploads/'.$post->death_certificate))
                {
                    Storage::disk('public')->delete('uploads/'.$post->death_certificate);
                }
            }

            $person_pic = isset($request->person_pic) ? $request->person_pic : $post->person_pic;
            if($request->file('person_pic')) {
                $person_pic = time().'_'.rand(1111,9999).'.'.$request->file('person_pic')->getClientOriginalExtension();
            //            $person_pic = time().'_'.$request->file('person_pic')->getClientOriginalName();
                $request->file('person_pic')->storeAs('uploads', $person_pic, 'public');
                if(Storage::disk('public')->exists('uploads/'.$post->person_pic))
                {
                    Storage::disk('public')->delete('uploads/'.$post->person_pic);
                }
            }

            $flowers = isset($request->flowers) ? $request->flowers : 0;
            $flower_type = Null;
            if(isset($request->flowers)){
                if($request->flower_type == 'y' || $request->flower_type == 'w' || $request->flower_type == 'p'){
                    $flower_type = $request->flower_type;
                }else{
                    $flower_type = 'y';
                }
            }

            Post::where('id',$post->id)->update([
                'user_id'              => Auth::user()->id,
                'person_name'          => $request->person_name,
                'surname'              => $request->surname,
                'relation'             => $request->relation,
                'description'          => $request->description,
                'pocontact'            => $request->pocontact,
                'lname'                => $request->lname,
                'institute'            => $request->institute,
                'number'               => $request->number,
                'age'                  => date('Y-m-d',strtotime($request->age)),
                'date_of_death'        => date('Y-m-d',strtotime($request->date_of_death)),
                'address'              => $request->address,
                'swd'                  => $request->swd, 
                'swdperson'            => $request->swdperson,
                'death_certificate'    => $death_certificate,
                'person_pic'           => $person_pic,
                'flowers'              => $flowers,
                'template_id'          => $request->template_id,
                'flower_type'          => $flower_type,
                'is_draft'             => $request->is_draft,
            ]); 

            if($request['is_draft'] == 1){
                return redirect()->route('showmydraft')->with('Success', 'Post Updated Successfully');
            }else{
                return redirect()->route('showmypost')->with('Success', 'Post Added Successfully');
            }
 
        }
        else{
            return redirect()->back()->withInput($request->all())->with('Failed', 'Please select proper address from suggestion list or pick current location');
        }
    }

    public function updatepoststatus(Post $post, $status, $created_at) {
        if(strtotime($post->created_at) == $created_at && $post->approval_status == 411) {
            $post->update(array('approval_status'=> $status ) );
            return redirect()->back()->with('Success', 'Post has been '.ucwords(strtolower(array_search($post->approval_status,config('constant.APPROVAL_STATUS')))).' Successfully');
        }
        abort(401);
    }

    public function forgotpassword(Request $request) {
        $niceNames = array( 
            'mobile'        => "Mobile Number", 
        );
 
        $requiredvalidation = [ 
            'mobile'        => 'required|numeric|digits_between:8,11', 
        ];
 
        $validatedData = Validator::make($request->all(), $requiredvalidation)->setAttributeNames($niceNames);

        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
        }

        $user = User::where('mobile',$request['mobile'])->first(); 
        if(!empty($user)){
            $tempotp = rand(111111,999999);
            Controller::sendSMS($request['mobile'],  'To reset your password OTP is : '.$tempotp,$tempotp);
            $request->session()->put('tempnumber', $request['mobile']);
            $request->session()->put('tempotp', $tempotp);
            $request->session()->put('showforgotOtpModal', 1);
            return redirect()->back();
        }else{
            return redirect()->back()->with([
            'FailedForgotpassword' => 'Mobile number does not exist','forgotpasswordmodal' => 'true']);
        }
       
    }

    public function forgotpassworduserotp(Request $request) {
        if($request->otp == Session::get('tempotp')) {
            $userarray = Session::get('tempnumber'); 

            $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
            $userpassword = substr(str_shuffle($data), 0, 8); 
            Controller::sendSMS('+91'.$userarray,  'Your new password is : '.$userpassword,$userpassword);
            // $user = User::where('mobile',$userarray)->update([ 
            //     'password'      => Hash::make($userpassword),
            //     'updated_at'    => date('Y-m-d H:i:s'), 
            // ]);  

            Session::forget(['tempnumber', 'tempotp', 'showforgotOtpModal','FailedForgotpassword','forgotpasswordmodal']);

            return redirect()->back()->with('Success', 'User password reset Successfully');
        }

        return redirect()->back()->with('FailedModal', 'Wrong OTP Entered ');
    }

    public function contactsubmit(Request $request) { 
        $niceNames = array(
            'name'         => "Name", 
            // 'email' 		=> "Email address", 
            // 'mobile'        => "Mobile Number",
            'message'   => "Message", 
            'rating' =>"Rating",
        );

        $request['adhaar'] = str_replace(' ', '', $request->adhaar);
        $requiredvalidation = [
            'name'         => "required|min:4|max:50|regex:/^[\pL\s\']+$/u", 
            // 'email' => 'required|min:4|max:50|regex:^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^',
            // 'mobile'        => 'required|numeric|digits_between:8,11',
            'message'   => 'required|max:250|min:5', 
            'rating'   => 'required',
        ];
 
        $validatedData = Validator::make($request->all(), $requiredvalidation)->setAttributeNames($niceNames);

        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
        }

        $inquiry = ContactInqiry::create([
            'name'         => $request->name,
            'mobile' 		=> $request->usermobile,
            'email' 		=> $request->useremail, 
            'message'           => $request->message,
            'rating'          => $request->rating,
        ]); 
        // 'openpasswordmodal' => 'true'
        if(!empty($inquiry)){
                return redirect()->back()
                    ->with(['SuccessContct'=> ' Inquiry sent successfully',]);
        }else{
            return redirect()->back()
                    ->with(['FailedContct'=> 'Something went wrong',]);
        }
       
    }

}


// surname,lname