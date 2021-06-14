<?php

namespace App\Http\Controllers\ApiController\CustomerApi;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\ApiController\BaseController as BaseController;
use App\Models\OrderHd;
use App\Models\OrderDt;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\CancelReason;
use App\Models\VendorCoupon;
use App\Http\Resources\Customer As ArticalCustomer;
use App\Http\Resources\Address As ArticalAddress;
use App\Http\Resources\CustomerOrder;
use App\Http\Resources\CancelReason as ArticalCancelReason;
use App\Http\Resources\OrderDetail;
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

	public function PlaceOrder(Request $request)
	{
		try
		{
			$order_data 	= json_decode($request->order_data, true);
			$order_data		= $order_data['order_data'];
			\DB::beginTransaction();
				$order_hd = new OrderHd();
				$order_hd->customer_id		= $order_data['customer_id'];
				$order_hd->vendor_id		= $order_data['vendor_id'];
				$order_hd->order_number 	= $order_data['order_number'];
				$order_hd->full_name 		= $order_data['full_name'];
				$order_hd->mobile_number	= $order_data['mobile_number'];
				$order_hd->house_number 	= $order_data['house_number'];
				$order_hd->street_name 		= $order_data['street_name'];
				$order_hd->full_address 	= $order_data['full_address'];
				$order_hd->sub_total 		= $order_data['sub_total'];
				$order_hd->txn_id 			= $order_data['txn_id'];
				$order_hd->discount_amount 	= $order_data['discount_amount'];
				$order_hd->coupon_id 		= empty($order_data['coupon_id']) ? NULL : $order_data['coupon_id'];
				$order_hd->coupon_code 		= $order_data['coupon_code'];
				$order_hd->order_status 	= config('constant.ORDER_STATUS.PLACED');
				$order_hd->save();

				foreach($order_data['product_list'] as $product_list)
				{
					$product_details = Product::find($product_list['product_id']);
					$order_dt = new OrderDt;
					$order_dt->order_id 		= $order_hd->order_id;
					$order_dt->product_id 		= $product_list['product_id'];
					$order_dt->product_name 	= $product_list['product_name'];
					$order_dt->price_id 		= $product_list['price_id'];
					$order_dt->price_tag 		= $product_list['price_tag'];
					$order_dt->tag_amount 		= $product_list['tag_amount'];
					$order_dt->product_qty 		= $product_list['product_qty'];
					$order_dt->product_total 	= $product_list['product_qty'] * $product_list['tag_amount'];
					$order_dt->product_image 	= $product_details->product_image;
					$order_dt->save();
				}
			\DB::commit();
			$order_data     = new OrderDetail(OrderHd::find($order_hd->order_id));
			return $this->sendSuccess($order_data, 'Order placed successfully');
		}
		catch (\Throwable $e)
    	{
            \DB::rollback();
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function OrderList(Request $request)
    {
        $error_message = 	[
			'required'   => 'Customer id is required',
		];

		$rules = [
			'customer_id'   => 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);

        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			$ongoing_order_list = CustomerOrder::collection(OrderHd::Where('customer_id',$request->customer_id)->whereIn('order_status',[config('constant.ORDER_STATUS.PLACED'),config('constant.ORDER_STATUS.ON_THE_WAY')])->OrderBy('created_at','DESC')->get());
			$completed_order_list = CustomerOrder::collection(OrderHd::Where('customer_id',$request->customer_id)->whereIn('order_status',[config('constant.ORDER_STATUS.DELIVERED'),config('constant.ORDER_STATUS.CANCELLED')])->OrderBy('created_at','DESC')->get());
			if(count($ongoing_order_list) > 0 || count($completed_order_list) > 0)
			{
				return $this->sendSuccess(['ongoin_orders' => $ongoing_order_list, 'completed_orders' => $completed_order_list], 'Order listed successfully...');
			}
			else
			{
				return $this->sendFailed('No order found', 200);  	
			}
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }

	public function OrderDetail(Request $request)
    {
        $error_message = 	[
			'required'   => 'Order id is required',
		];

		$rules = [
			'order_id'   => 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);

        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			$order_data     = new OrderDetail(OrderHd::find($request->order_id));
			return $this->sendSuccess($order_data, 'Order details listed successfully...');
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
    }

	public function ApplyCoupon(Request $request)
	{
		$error_message = 	[
			'coupon_code.required'   	=> 'Coupon code is required',
			'order_amount.required'   	=> 'Order amount is required',
			'vendor_id.required'   		=> 'Restaurant id required',
		];

		$rules = [
			'coupon_code'   	=> 'required',
			'order_amount'   	=> 'required',
			'vendor_id'   		=> 'required',
		];

		$validator = Validator::make($request->all(), $rules, $error_message);

        if($validator->fails()){
            return $this->sendFailed($validator->errors()->all(), 200);       
        }

		try
		{
			$coupon_data = Coupon::where('coupon_code',$request->coupon_code)->first();
			if(isset($coupon_data))
			{
				$vendor_coupon = VendorCoupon::where('coupon_id',$coupon_data->coupon_id)->where('vendor_id',$request->vendor_id)->first();
				if(isset($vendor_coupon))
				{
					if($request->order_amount >= $coupon_data->order_amount)
					{
						$discount_amount = number_format(($request->order_amount * $coupon_data->discount_per) / 100);
						if($discount_amount > $coupon_data->max_discount)
						{
							$discount_amount = $coupon_data->max_discount;
						}
						return $this->sendSuccess(['coupon_id' => $coupon_data->coupon_id, 'coupon_code' => $coupon_data->coupon_code, 'discount_amount' => $discount_amount], 'Coupon applied successfully');
					}
					else
					{
						return $this->sendFailed('Minimum order amount '.$coupon_data->order_amount,200);	
					}
				}
				else
				{
					return $this->sendFailed('This coupon code not applicable for that restaurant',200);
				}
			}
			else
			{
				return $this->sendFailed('Invalid coupon code',200);
			}
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function CancelReason()
	{
		$cancel_reason = ArticalCancelReason::collection(CancelReason::all());
		return $this->sendSuccess($cancel_reason, 'Cancel reason listed successfully...');	
	}
}