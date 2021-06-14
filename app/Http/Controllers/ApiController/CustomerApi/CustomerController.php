<?php

namespace App\Http\Controllers\ApiController\CustomerApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Validator;
use App\Http\Controllers\ApiController\BaseController as BaseController;
use App\Models\Customers;
use App\Models\Address;
use App\Models\Feedback;
use App\Http\Resources\Customer As ArticalCustomer;
use App\Http\Resources\Address As ArticalAddress;
use DB;

class CustomerController extends BaseController
{
	public function __construct() 
	{
		$this->Customers 	= new Customers;
		$this->Address 		= new Address;
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

	public function CreateAcount(Request $request)
	{
		$error_message = 	[
			'full_name.required' 		=> 'Full name can not be blank',
			'email_address.required' 	=> 'Email address can not be blank',
			'mobile_number.required' 	=> 'Mobile number can not be blank',
			'full_name.min' 			=> 'Full name :min characters required',
			'full_name.max' 			=> 'Full name :max characters',
			'email_address.max' 		=> 'Email address :max characters',
			'email_address.unique' 		=> 'Email address already exist',
			'digits' 					=> 'Mobile number shold be :digits digits',
			'mobile_number.unique' 		=> 'Mobile number already exist',
		];

		$rules = [
			'full_name' 		=> 'required|min:3|max:32',
			'email_address' 	=> 'required|unique:customers,email_address,0,customer_id,deleted_at,NULL|max:50',
			'mobile_number' 	=> 'required|unique:customers,mobile_number,0,customer_id,deleted_at,NULL|digits:10',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			\DB::beginTransaction();
				$customer = new Customers();
				$customer->full_name 		= $request->full_name;
				$customer->email_address 	= $request->email_address;
				$customer->mobile_number 	= $request->mobile_number;
				$customer->save();
			\DB::commit();
			$oGetUser = new ArticalCustomer(Customers::find($customer->customer_id));
			return $this->sendSuccess(['customer_data' => $oGetUser, 'mobile_otp' => rand(1111,9999)], 'Account created successfully');
		}
		catch (\Throwable $e)
    	{
            \DB::rollback();
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function LoginAcount(Request $request)
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
			$oGetUser = Customers::where('mobile_number',$request->mobile_number)->first();
			if(isset($oGetUser))
			{
				$oGetUser = new ArticalCustomer($oGetUser);
				return $this->sendSuccess(['customer_data' => $oGetUser, 'mobile_otp' => rand(1111,9999)], 'OTP sent on your registered mobile number');
			}
			else
			{
				return $this->sendFailed('We could not found any account with that mobile number',200);  
			}
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function CustomerProfile(Request $request)
	{
		$error_message = 	[
			'required' 	=> 'Login to your account',
		];

		$rules = [
			'customer_id' 	=> 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			$oGetUser = $this->Customers->CustomerProfile($request->customer_id);
			if(isset($oGetUser))
			{
				$oGetUser = new ArticalCustomer($oGetUser);
				return $this->sendSuccess($oGetUser, 'Profile listed successfully');
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

	public function CreateAddress(Request $request)
	{
		$error_message = 	[
			'customer_id.required'		=> 'Customer id should be required',
			'full_name.required'		=> 'Full name should be required',
			'house_number.required'		=> 'House / Flat number should be required',
			'street_name.required'		=> 'Street name should be required',
			'full_address.required'		=> 'Address should be required',
			'full_name.min'				=> 'Full name should be minimum :min characters',
			'full_name.max'				=> 'Full name maximum :max characters',
			'house_number.min'			=> 'House number should be minimum :min characters',
			'house_number.max'			=> 'House number maximum :max characters',
			'street_name.min'			=> 'Street name should be minimum :min characters',
			'street_name.max'			=> 'Street name maximum :max characters',
			'full_address.min'			=> 'Address should be minimum :min characters',
		];

		$rules = [
			'customer_id' 	=> 'required',
			'full_name' 	=> 'required|min:3|max:32',
			'house_number'  => 'required|min:1|max:15',
			'street_name' 	=> 'required|min:5|max:30',
			'full_address' 	=> 'required|min:5',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);

		if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			\DB::beginTransaction();
				$address = new Address();
				$address->customer_id 	= $request->customer_id;
				$address->full_name 	= $request->full_name;
				$address->house_number 	= $request->house_number;
				$address->street_name 	= $request->street_name;
				$address->full_address 	= $request->full_address;
				$address->save();
			\DB::commit();

			return $this->sendSuccess('', 'Address saved successfully');
		}
		catch (\Throwable $e)
    	{
            \DB::rollback();
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function UpdateAddress(Request $request)
	{
		$error_message = 	[
			'customer_id.required'		=> 'Customer id should be required',
			'full_name.required'		=> 'Full name should be required',
			'house_number.required'		=> 'House / Flat number should be required',
			'street_name.required'		=> 'Street name should be required',
			'full_address.required'		=> 'Address should be required',
			'full_name.min'				=> 'Full name should be minimum :min characters',
			'full_name.max'				=> 'Full name maximum :max characters',
			'house_number.min'			=> 'House number should be minimum :min characters',
			'house_number.max'			=> 'House number maximum :max characters',
			'street_name.min'			=> 'Street name should be minimum :min characters',
			'street_name.max'			=> 'Street name maximum :max characters',
			'full_address.min'			=> 'Address should be minimum :min characters',
		];

		$rules = [
			'customer_id' 	=> 'required',
			'full_name' 	=> 'required|min:3|max:32',
			'house_number'  => 'required|min:1|max:15',
			'street_name' 	=> 'required|min:5|max:30',
			'full_address' 	=> 'required|min:5',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);

		if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			\DB::beginTransaction();
				$count_row  = Address::findOrFail($request->address_id)->update($request->only(['full_name','house_number','street_name','full_address']));
			\DB::commit();

			$oGetAddress = ArticalAddress::collection(Address::Where('customer_id',$request->customer_id)->get());
			return $this->sendSuccess($oGetAddress, 'Address updated successfully....');
		}
		catch (\Throwable $e)
    	{
            \DB::rollback();
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function AddressList(Request $request)
	{
		$error_message = 	[
			'required'			=> 'Login your accout',
		];

		$rules = [
			'customer_id' 		=> 'required',		
		];

		$validator = Validator::make($request->all(), $rules, $error_message);

		if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }		

		try
		{
			$oGetAddress = ArticalAddress::collection(Address::Where('customer_id',$request->customer_id)->get());
			return $this->sendSuccess($oGetAddress, 'Address listed successfully....');
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}

	}

	public function AddressDelete(Request $request)
	{
		$error_message = 	[
			'required'			=> 'Login your account',
		];

		$rules = [
			'address_id' 		=> 'required',		
			'customer_id' 		=> 'required',		
		];

		$validator = Validator::make($request->all(), $rules, $error_message);

		if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }		

		try
		{
			$address = Address::findOrfail($request->address_id);
			$address->delete();
			$oGetAddress = ArticalAddress::collection(Address::Where('customer_id',$request->customer_id)->get());
			return $this->sendSuccess($oGetAddress, 'Address deleted successfully....');
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function UpdateProfileImage(Request $request)
	{
		$error_message = 	[
			'customer_image.required'			=> 'Profile image required',
		];

		$rules = [
			'customer_id' 			=> 'required',		
			'customer_file' 		=> 'required',		
		];

		$validator = Validator::make($request->all(), $rules, $error_message);

		if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }		

		try
		{
			$imageName = time().'_'.rand(1111,9999).'.'.$request->file('customer_file')->getClientOriginalExtension();  
			$request->file('customer_file')->storeAs('customer_images', $imageName, 'public');  
            $request['customer_image'] = $imageName;

			$customer_data = Customers::findOrfail($request->customer_id);
			if(!empty($customer_data->customer_image) && Storage::disk('public')->exists('customer_images/'.$customer_data->customer_image))
			{
				Storage::disk('public')->delete('customer_images/'.$customer_data->customer_image);
			}
			Customers::findOrFail($request->customer_id)->update($request->only(['customer_image']));
			$customer_data = new ArticalCustomer(Customers::find($request->customer_id));

			return $this->sendSuccess($customer_data, 'Profile image updated successfully....');
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function SaveFeedback(Request $request)
	{
		$error_message = 	[
			'full_name.required' 		=> 'Full name can not be blank',
			'email_address.required' 	=> 'Email address can not be blank',
			'mobile_number.required' 	=> 'Mobile number can not be blank',
			'full_name.min' 			=> 'Full name :min characters required',
			'full_name.max' 			=> 'Full name :max characters',
			'email_address.max' 		=> 'Email address :max characters',
			'email_address.unique' 		=> 'Email address already exist',
			'digits' 					=> 'Mobile number shold be :digits digits',
			'comment_dtl.required' 		=> 'Comment can not be blank',
		];

		$rules = [
			'full_name' 		=> 'required|min:3|max:32',
			'email_address' 	=> 'required|max:50',
			'mobile_number' 	=> 'required|digits:10',
			'comment_dtl' 		=> 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);
   
        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			\DB::beginTransaction();
				$feedback = new Feedback();
				$feedback->full_name 		= $request->full_name;
				$feedback->email_address 	= $request->email_address;
				$feedback->mobile_number 	= $request->mobile_number;
				$feedback->comment_dtl 		= $request->comment_dtl;
				$feedback->save();
			\DB::commit();
			return $this->sendSuccess('', 'Feedback sent successfully');
		}
		catch (\Throwable $e)
    	{
            \DB::rollback();
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}
}