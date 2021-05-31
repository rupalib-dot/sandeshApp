<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<section id="verifyOtp" class="verifyOtp" role="verifyOtp">  
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="forgotPage">
                        <button class="close1"><i class="flaticon-cancel"></i></button>
                            <h4>Verify OTP</h4>
                            <p>We have sent you an OTP on</p>
                            <p class="otpNumber">+9198289588</p>
                            <p>OTP</p>
                        <form action="/action_page.php" class="formForgot">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-4">
                                        <input type="number" class="form-control"
                                            placeholder="Please enter the 6 digit OTP here to verify"
                                            aria-label="Please enter the 6 digit OTP here to verify"
                                            aria-describedby="basic-addon1">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                       <p>Still not received OTP? </p>
                                        <p><a href="#" class="byCall">Resend OTP</a></p>
                                    </div>
                                </div>
                                <button class="Loginbtn">Verify OTP</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>