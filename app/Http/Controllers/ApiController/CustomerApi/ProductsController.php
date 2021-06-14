<?php

namespace App\Http\Controllers\ApiController\CustomerApi;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\ApiController\BaseController as BaseController;
use App\Models\Category;
use App\Models\CategoryPromotion;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Vendor;
use App\Models\ProductImages;
use App\Http\Resources\Category As ArticalCategory;
use App\Http\Resources\CategoryPromotion As ArticalCategoryPromotion;
use App\Http\Resources\Product As ArticalProduct;
use App\Http\Resources\Banner As ArticalBanner;
use App\Http\Resources\ProductImages As ArticalProductImages;
use App\Http\Resources\VendorDetails;
use App\Http\Resources\VendorList;
use DB;

class ProductsController extends BaseController
{
	public function __construct() 
	{
		$this->Category 			= new Category;
		$this->Vendor 				= new Vendor;
		$this->CategoryPromotion 	= new CategoryPromotion;
		$this->Product  			= new Product;
		$this->Banner  				= new Banner;
		$this->ProductImages  		= new ProductImages;
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

	public function HomePage(Request $request)
	{
		try
		{
			$banner_data 	= ArticalBanner::collection(Banner::where('banner_type',101)->get());
			$category_data 	= ArticalCategory::collection(Category::take(6)->get());
			$vendor_data 	= VendorList::collection($this->Vendor->vendor_list_api($request->user_lat, $request->user_long));
			return $this->sendSuccess(['banner_data' => $banner_data, 'category_data' => $category_data, 'vendor_data' => $vendor_data], 'Data listed successfully');
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function CategoryList(Request $request)
	{
		try
		{
			$category_data   = ArticalCategory::collection(Category::get());
			if(count($category_data) > 0)
			{
				$banner_data 	= ArticalBanner::collection(Banner::where('banner_type',101)->get());
				return $this->sendSuccess(['category_offer' => $banner_data, 'category_data' => $category_data], 'Category listed successfully');
			}
			else
			{
				return $this->sendFailed('Category not found');  
			}
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

    public function ProductList(Request $request)
	{
		try
		{
			$user_lat_long = self::get_lat_long($request->user_address);
			$vendor_data = Vendor::
						selectRaw("*, ".$user_lat_long['latitude']." as user_lat, ".$user_lat_long['longitude']." as user_long,
						(((acos(sin((".$user_lat_long['latitude']."*pi()/180)) * sin((`vendor_lat`*pi()/180)) + cos((".$user_lat_long['latitude']."*pi()/180)) * cos((`vendor_lat`*pi()/180)) * cos(((".$user_lat_long['longitude']."- `vendor_long`) * pi()/180)))) * 180/pi()) * 60 * 1.1515 * 1.609344) as distance_km")
						->orderBy("distance_km")->first();
			$record_data = new VendorDetails($vendor_data);
			return $this->sendSuccess($record_data, 'Products listed successfully');
		}
		catch (\Throwable $e)
    	{
    		return $this->sendFailed($e->getMessage().' on line '.$e->getLine(), 400);  
    	}
	}

	public function get_lat_long($user_address)
	{
		if(!empty($user_address)){
            //Formatted address
            $formattedAddr = str_replace(' ','+',$user_address);
            //Send request and receive json data by address
            $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCU4syOOvy3vyUZf7n1eg8C1l28zX0v1h4&address='.$formattedAddr.'&sensor=false'); 
            $output = json_decode($geocodeFromAddr);
            //Get latitude and longitute from json data
            $data['latitude']  = $output->results[0]->geometry->location->lat; 
            $data['longitude'] = $output->results[0]->geometry->location->lng;
            //Return latitude and longitude of the given address
            if(!empty($data)) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;   
        }
	}
}