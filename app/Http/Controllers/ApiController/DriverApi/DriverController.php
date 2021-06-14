<?php

namespace App\Http\Controllers\ApiController\DriverApi;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\ApiController\BaseController as BaseController;
use App\Models\Driver;
use App\Http\Resources\Driver As ArticalDriver;
use DB;

class DriverController extends BaseController
{
	public function __construct() 
	{
		$this->Driver = new Driver;
		//header("Content-Type: application/json");
		$valid_passwords = array ("halal" => "026866326a9d1d2b23226e4e5317569f");
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

	public function LoginAcount(Request $request)
	{
		$error_message = 	[
			'digits' 					=> 'Mobile number shold be :digits digits',
			'required' 					=> 'Mobile number shold be required',
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
			$oGetUser = $this->Driver->LoginAccount($request->mobile_number);
			if(isset($oGetUser))
			{
				return $this->sendSuccess(['driver_id' => $oGetUser->driver_id, 'mobile_number' => $oGetUser->mobile_number, 'mobile_otp' => rand(1111,9999)], 'OTP sent on your registered mobile number');
			}
			else
			{
				return $this->sendFailed('We could not found any account with that mobile number');  
			}
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function DriverProfile(Request $request)
	{
		$error_message = 	[
			'required' 	=> 'Login to your account',
		];

		$rules = [
			'driver_id' 	=> 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			$oGetUser = new ArticalDriver(Driver::find($request->driver_id));
			if(isset($oGetUser->driver_id))
			{
				return $this->sendSuccess($oGetUser, 'Profile listed successfully');
			}
			else
			{
				return $this->sendFailed('Unauthorized access');  
			}
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function ResendOTP(Request $request)
	{
		$error_message = 	[
			'required'	=> 'Mobile number missing',
			'digits' 	=> 'Mobile number shold be :digits digits',
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
			return $this->sendSuccess(['mobile_otp' => rand(1111,9999)], 'OTP sent successfully');
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function ChangeStatus(Request $request)
	{
		$error_message = 	[
			'driver_id.required'		=> 'Your account id missing',
			'driver_status.required' 	=> 'Status missing',
		];

		$rules = [
			'driver_id' 		=> 'required',
			'driver_status' 	=> 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);

		if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			$count_row  	= Driver::findOrFail($request->driver_id)->update($request->only(['driver_status']));
			$get_data		= Driver::select('driver_status')->find($request->driver_id);
			return $this->sendSuccess($get_data, 'Status changed successfully...');
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function UpdateToken(Request $request)
	{
		$error_message = 	[
			'driver_id.required'		=> 'Your account id missing',
			'driver_token.required' 	=> 'Toekn missing',
		];

		$rules = [
			'driver_id' 		=> 'required',
			'driver_token' 	    => 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);

		if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			$count_row  	= Driver::findOrFail($request->driver_id)->update($request->only(['driver_token']));
			return $this->sendSuccess('', 'Token updated successfully...');
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}
}