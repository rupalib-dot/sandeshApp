<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function writeFile($message){
        $user = Auth::user();
        if(empty($user['fname'])){
            $user = 'Admin';
        }else {
            $user = $user['fname'];
        }

        $message=date('H:i A').' ('.$user.')'."\t\t".$message;
        $date=date('Y-m-d');
        if (is_file(public_path('assets/logfiles/'.$date.'.txt'))) {
            $myfile = fopen(public_path('assets/logfiles/'.$date.'.txt'), 'a');
            fwrite($myfile, $message."\n");
            fclose($myfile);
        }else{
            $myfile = fopen(public_path('assets/logfiles/'.$date.'.txt'), "w");
            fwrite($myfile, $message."\n");
            fclose($myfile);
        }
    }

    public function sendSMS_old($sMblNum,$sMsg)
	{
		$API_KEY    = "350642AwlhUoOG9W5fec5ceaP1";
        $SENDER_ID  = "LOOPTZ";
        $ROUTE      = 4;

		$postData = array(
            'mobiles' => $sMblNum,
            'message' => $sMsg,
            'sender' => $SENDER_ID,
            'route' => $ROUTE,
          	'country'=>91,
        );
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.msg91.com/api/v2/sendsms",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "authkey: $API_KEY",
                "content-type: multipart/form-data"
            ),
        ));

		$response = curl_exec($curl);
        $err = curl_error($curl);
		curl_close($curl); 
		return $response;
	} 

    public static function sendSMS($mob_no, $message, $otp)
    {   
        $curl = curl_init();
        //Msg91 Account configuration
        $senderId = 'LOOPST';
        $authKey = '350642AwlhUoOG9W5fec5ceaP1';
        $message = "Use OTP ". $otp." to reset your password";
        
        $url = "http://api.msg91.com/api/v5/otp?template_id=60027617b80c47415c040111&mobile=+91 ".$mob_no."&authkey=350642AwlhUoOG9W5fec5ceaP1&otp=".$otp;
        
        $ch = curl_init($url);
    	curl_setopt($ch, CURLOPT_HEADER, 0);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	$output = curl_exec($ch);       
    	curl_close($ch); 
 		
 		return $output;
    }


    public function getLatLong($address){
		if(!empty($address)){
			//Formatted address
			$formattedAddr = str_replace(' ','+',$address);
			//Send request and receive json data by address 
			$geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCCNdiZ-QFwFBld5GxQAs0XiDQF5G8NE0U&address='.$formattedAddr.'&sensor=false'); 
			$output = json_decode($geocodeFromAddr);
			if(count($output->results)>0){
                //Get latitude and longitute from json data
                $data['latitude']  = $output->results[0]->geometry->location->lat; 
                $data['longitude'] = $output->results[0]->geometry->location->lng;
                //Return latitude and longitude of the given address
                if(!empty($data)){
                    return $data;
                }else{
                    return false;
                }
            }else{
                return false;
            }
		}else{
			return false;   
		}
	}
}
