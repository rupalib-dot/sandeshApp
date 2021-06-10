<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Forgot Password</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<style type="text/css">
	*{font-family: 'Roboto', sans-serif;margin:0px;padding: 0px;}
	h2{color: #000; font-size: 34px;font-weight: 400;margin-bottom: 10px;}
	strong{color: #000; font-size: 18px;font-weight: 300;margin-bottom: 15px;}
	p{color: #555555;font-size: 15px;font-weight: 300;margin-bottom: 20px;line-height: 25px;}
</style>
</head>
 
<body>
	<div style="max-width: 600px; margin:0 auto;">
		<div style ="display:block; position:relative; padding:25px; background-color: #eef0f3">
			  <div style="display: block; position: relative;padding: 32px;background-color: #fff;border-radius: 10px;box-shadow: 0px 0px 10px #e2e2e2;">
			  	  	<p><strong>Dear {{$details['name']}}</strong></p>
			  	  	<p>You recently requested to reset your password for your account.</p>   
					<p style="text-align: left;">So your password has been reset successfully</p>
					<p style="text-align: left;">{{$details['msg']}}</p>
                    <p style="text-align: left;">If you did not request a password reset, please ignore this email.</p>
					<p style="padding-top: 20px;">Kind Regards,</p>
					<p><b>Sandesh</b></p>
				</div>
			   <!-- <div style="display:block; position:relative; padding: 15px;">
			   	  <div style="display: block; text-align: center; margin-bottom: 20px">
			   	  	<a href="#" style="display: inline-block;margin:8px 5px; background-image: url(https://mylunchorder.online/images/social-media.jpg); background-repeat: no-repeat; width: 33px; height: 33px; background-position:-13px -6px; font-size: 0px">facebook</a>
			   	  	<a href="#" style="display: inline-block;margin:8px 5px; background-image: url(https://mylunchorder.online/images/social-media.jpg); background-repeat: no-repeat; width: 33px; height: 33px; background-position: -58px -6px; font-size: 0px">instagram</a>
			   	  	<a href="#" style="display: inline-block;margin:8px 5px; background-image: url(https://mylunchorder.online/images/social-media.jpg); background-repeat: no-repeat; width: 33px; height: 33px; background-position: -103px -6px; font-size: 0px">twitter</a>
			   	  	<a href="#" style="display: inline-block;margin:8px 5px; background-image: url(https://mylunchorder.online/images/social-media.jpg); background-repeat: no-repeat; width: 33px; height: 33px; background-position: -148px -6px; font-size: 0px">pintrest</a>
			   	  	<a href="#" style="display: inline-block;margin:8px 5px; background-image: url(https://mylunchorder.online/images/social-media.jpg); background-repeat: no-repeat; width: 33px; height: 33px; background-position: -193px -6px; font-size: 0px">youtube</a>
			   	  </div>
			   </div> -->
		</div>
	</div>
</body>
</html>