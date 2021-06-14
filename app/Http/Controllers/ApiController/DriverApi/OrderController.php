<?php

namespace App\Http\Controllers\ApiController\DriverApi;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\ApiController\BaseController as BaseController;
use App\Models\OrderHd;
use App\Models\OrderDt;
use App\Http\Resources\AssignOrder;
use App\Http\Resources\OngoingOrder;
use App\Http\Resources\CompletedOrder;
use DB;

class OrderController extends BaseController
{
	public function __construct() 
	{
		$this->OrderHd 		= new OrderHd;
		$this->OrderDt 		= new OrderDt;
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

	public function AssignOrder(Request $request)
	{
		try
		{
            $order_list = AssignOrder::collection(OrderHd::where('order_status',config('constant.ORDER_STATUS.PLACED'))->Where('driver_id',$request->driver_id)->get());
            if(count($order_list) > 0)
            {
                return $this->sendSuccess($order_list, 'Order listed successfully');
            }
            else
            {
                return $this->sendSuccess('', 'No new order found...');
            }
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function AcceptRejectOrder(Request $request)
	{
		if($request->order_status == config('constant.DRIVER_ORDER_STATUS.ACCEPT'))
		{
			$request['accetped_at'] 	= date('Y-m-d H:i:s');
			$request['order_status'] 	= config('constant.ORDER_STATUS.ON_WAY');
			$request['driver_id'] 		= $request->driver_id;
			$message = 'Order accepted successfylly...';
		}
		else
		{
			$request['accetped_at'] 	= NULL;
			$request['order_status'] 	= config('constant.ORDER_STATUS.PLACED');
			$request['driver_id'] 		= NULL;
			$message = 'Order rejected successfylly...';
		}
		
		try
		{
			\DB::beginTransaction();
				$count_row      = OrderHd::findOrfail($request->order_id)->update($request->only(['accetped_at','order_status','driver_id']));
				$order_list 	= AssignOrder::collection(OrderHd::where('order_status',config('constant.ORDER_STATUS.PLACED'))->Where('driver_id',$request->driver_id)->get());		
			\DB::commit();
			return $this->sendSuccess($order_list, $message);
		}
		catch (\Throwable $e)
    	{
            \DB::rollback();
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function OngoingOrder(Request $request)
	{
		try
		{
			$ongoin_order 		= OngoingOrder::collection(OrderHd::where('driver_id',$request->driver_id)->where('order_status', config('constant.ORDER_STATUS.ON_WAY'))->get());
			if(count($ongoin_order) > 0)
			{
				return $this->sendSuccess($ongoin_order, 'Order listed successfully...');
			}
			else
			{
				return $this->sendFailed('No order for you..', 200);  
			}
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function CompletedOrder(Request $request)
	{
		try
		{
			$completed_order 	= CompletedOrder::collection(OrderHd::where('driver_id',$request->driver_id)->whereIn('order_status', [config('constant.ORDER_STATUS.DELIVERED'),config('constant.ORDER_STATUS.CANCELLED')])->get());
			if(count($completed_order) > 0)
			{
				return $this->sendSuccess($completed_order, 'Order listed successfully...');
			}
			else
			{
				return $this->sendFailed('No order for you..', 200);  
			}
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function CompleteOrder(Request $request)
	{
		if($request->delivery_type == config('constant.DEL_TYPE.DOORSTAP'))
		{
			$error_message = 	[
				'required' 		=> 'Doorstap image shoud be required',
			];

			$rules = [
				'neighbour_image' 	=> 'required',
			];

			$validator = Validator::make($request->all(), $rules, $error_message);
   
			if($validator->fails()){
				return $this->sendFailed($validator->errors()->all(), 200);       
			}
		}

		try
		{
			\DB::beginTransaction();
				$count_row      = OrderHd::findOrfail($request->order_id)->update($request->only(['neighbour_image','order_status']));
				$order_list 	= AssignOrder::collection(OrderHd::where('order_status',config('constant.ORDER_STATUS.PLACED'))->Where('driver_id',$request->driver_id)->get());		
			\DB::commit();
			return $this->sendSuccess($order_list, 'Order deliverd successfully...'); 
		}
		catch (\Throwable $e)
    	{
            \DB::rollback();
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}
}