<?php

namespace App\Http\Controllers\ApiController\CustomerApi;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\ApiController\BaseController as BaseController;
use App\Models\Vendor;
use App\Http\Resources\VendorList;
use DB;

class VendorController extends BaseController
{
	public function __construct() 
	{
		$this->Vendor = new Vendor;
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

    public function VendorList(Request $request)
	{
		try
		{	
			$record_data = VendorList::collection($this->Vendor->vendor_list_api($request->user_lat, $request->user_long, $request->business_name));
			return $this->sendSuccess($record_data, 'Restaurant listed successfully');
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}
}