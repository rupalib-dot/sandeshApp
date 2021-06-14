<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
	public function sendSuccess($result, $message)
    {
    	$response = [
            'ResponseCode'      => 200,
            'Status'            => True,
            'Message'           => $message,
            'Data'              => $result,
        ];
        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendFailed($errorMessages = [], $code = 200)
    {
    	$response = [
            'ResponseCode'      => $code,
            'Status'            => False,
        ];


        if(!empty($errorMessages)){
            $response['Message'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}