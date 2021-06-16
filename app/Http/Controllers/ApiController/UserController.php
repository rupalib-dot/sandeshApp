<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Validator;
use App\Http\Controllers\ApiController\BaseController as BaseController;
use App\Models\User;
use App\Models\UserRole;
use App\Http\Resources\Users;
use Hash;
use DB;

class UserController extends BaseController
{
	public function __construct() 
	{
		//header("Content-Type: application/json");
		$valid_passwords = array ("sandesh" => "026866326a9d1d2b23226e4e5317569f");
		$valid_users = array_keys($valid_passwords);

		$user = request()->server('PHP_AUTH_USER');
		$pass = request()->server('PHP_AUTH_PW');

		$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

		if (!$validated) {
		  header('WWW-Authenticate: Basic realm="My Realm"');
		  header('HTTP/1.0 401 Unauthorized');
		  $re = array(
		  	"status" 	=> false,
		  	"message"	=> "You're not authorized to access."
		  );
		  echo json_encode($re, JSON_PRETTY_PRINT);
		  die;
		}
	}

	public function register_otp(Request $request)
	{
		$error_message = 	[
			'fname.required' 		=> 'First name should be required',
			'lname.required' 		=> 'Last name should be required',
			'mobile.required' 		=> 'Mobile number should be required',
			'dob.required' 			=> 'Date of birth should be required',
			'address.required' 		=> 'Address should be required',
			'adhaar.required' 		=> 'Aadhar card number should be required',
			'adhaar_image.required' => 'Aadhar card image should be required',
			'mimes' 				=> 'Aadhar card in jpg, jpeg,png',
			'max' 					=> 'Aadhar card file max 2MB',
			'regex' 				=> 'Alphanumeric password with at least one special and length of 8-16 characters',
		];

		$rules = [
			'fname' 			=> 'required',
			'lname' 			=> 'required',
			'address' 			=> 'required',
			'adhaar' 			=> 'required',
			'password' 			=> 'required|regex:/^(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
			'adhaar_image' 		=> 'required|mimes:jpg,jpeg,png|max:2000',
			'email' 			=> 'required|unique:users,email,0,customer_id,deleted_at,NULL',
			'mobile' 			=> 'required|unique:users,mobile,0,customer_id,deleted_at,NULL',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			return $this->sendSuccess(['mobile' => $request->mobile, 'mobile_otp' => rand(11111,99999)], 'OTP sent successfully');
		}
		catch (\Throwable $e)
    	{
            \DB::rollback();
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
		
	}

	public function register_account(Request $request)
	{
		$error_message = 	[
			'fname.required' 		=> 'First name should be required',
			'lname.required' 		=> 'Last name should be required',
			'mobile.required' 		=> 'Mobile number should be required',
			'dob.required' 			=> 'Date of birth should be required',
			'address.required' 		=> 'Address should be required',
			'adhaar.required' 		=> 'Aadhar card number should be required',
			'adhaar_image.required' => 'Aadhar card image should be required',
			'mimes' 				=> 'Aadhar card in jpg, jpeg,png',
			'max' 					=> 'Aadhar card file max 2MB',
			'regex' 				=> 'Alphanumeric password with at least one special and length of 8-16 characters',
		];

		$rules = [
			'fname' 			=> 'required',
			'lname' 			=> 'required',
			'address' 			=> 'required',
			'adhaar' 			=> 'required',
			'lat' 				=> 'required',
			'long' 				=> 'required',
			'password' 			=> 'required|regex:/^(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
			'adhaar_image' 		=> 'required|mimes:jpg,jpeg,png|max:2000',
			'email' 			=> 'required|unique:users,email,0,customer_id,deleted_at,NULL',
			'mobile' 			=> 'required|unique:users,mobile,0,customer_id,deleted_at,NULL',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			$imageName = time().'_'.rand(1111,9999).'.'.$request->file('adhaar_image')->getClientOriginalExtension();  
            $request->file('adhaar_image')->storeAs('uploads', $imageName, 'public');  

			\DB::beginTransaction();
				$user = new User();
				$user->fill($request->all());
				$user->password 	= Hash::make($request->password);
				$user->adhaar_file 	= $imageName;
				$user->save();

				$user_role = new UserRole;
				$user_role->user_id	= $user->id;
				$user_role->role_id	= 2;
				$user_role->save();

				$user_data = new Users(User::find($user->id));
			\DB::commit();
			return $this->sendSuccess($user_data, 'Account created successfully');
		}
		catch (\Throwable $e)
    	{
            \DB::rollback();
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function update_account(Request $request)
	{
		$error_message = 	[
			'fname.required' 		=> 'First name should be required',
			'lname.required' 		=> 'Last name should be required',
			'address.required' 		=> 'Address should be required',
		];

		$rules = [
			'fname' 			=> 'required',
			'lname' 			=> 'required',
			'address' 			=> 'required',
			'lat' 				=> 'required',
			'long' 				=> 'required',
			'email' 			=> 'required|unique:users,email,0,customer_id,deleted_at,NULL',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			\DB::beginTransaction();
				User::findOrfail($request->user_id)->update($request->all());
				$user_data = new Users(User::find($request->user_id));
			\DB::commit();
			return $this->sendSuccess($user_data, 'Profile updated successfully');
		}
		catch (\Throwable $e)
    	{
            \DB::rollback();
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function login_account(Request $request)
	{
		$error_message = 	[
			'digits' 					=> 'Mobile number shold be :digits digits',
		];

		$rules = [
			'mobile_number' 	=> 'required|digits:10',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			$user_data = User::where('mobile',$request->mobile)->orWhere('email',$request->email)->where('password',Hash::make($request->password))->first();
			if(isset($user_data))
			{
				$user_data = new User($user_data);
				return $this->sendSuccess($user_data, 'Account login successfully');
			}
			else
			{
				return $this->sendFailed('We could not found any account with that info',200);  
			}
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function user_profile(Request $request)
	{
		$error_message = 	[
			'required' 	=> 'Login to your account',
		];

		$rules = [
			'user_id' 	=> 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			$user_data = User::find($request->user_id);
			if(isset($user_data))
			{
				$user_data = new Users($user_data);
				return $this->sendSuccess($user_data, 'Profile listed successfully');
			}
			else
			{
				return $this->sendFailed('Unauthorized access',200);  
			}
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function resend_otp(Request $request)
	{
		$error_message = 	[
			'required'	=> 'Mobile number should be',
		];

		$rules = [
			'mobile' 	=> 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
		
		if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			return $this->sendSuccess(['mobile_otp' => rand(1111,9999)], 'OTP sent successfully');
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function change_password(Request $request)
	{
		$error_message = 	[
			'regex' 		=> 'Alphanumeric password with at least one special and length of 8-16 characters',
			'different'		=> 'New password should not be same as old password',
		];

		$rules = [
			'password' 				=> 'required',
			'new_password' 			=> 'required|regex:/^(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/|different:login_password',
			'confirm_password' 		=> 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			$user_data	= User::find($request->id);
			if(!Hash::check($request->password, $user_data->password))
			{
				return $this->sendFailed('Current password did not matched', 200);       
			}
			else
			{
				$request['password'] = Hash::make($request->password);
				User::findOrfail($request->id)->update($request->only(['password']));
				return $this->sendSuccess('', 'Password updated successfully');
			}
		}
		catch (\Throwable $e)
    	{
            \DB::rollback();
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}
}