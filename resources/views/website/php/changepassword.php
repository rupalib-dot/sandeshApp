<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<section id="changePassword" class="changePassword" role="changePassword">

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="forgotPage">
                    <button class="close1"><i class="flaticon-cancel"></i></button>
                    <h4>Reset Password</h4>
                    <p class="changeP">To change your account password please
                        fill in fields below</p>
                    <form action="/action_page.php" class="formForgot">
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="input-group mb-4">
                                    <input type="text" class="form-control" placeholder="Current Password"
                                        aria-label="Current Password" aria-describedby="basic-addon1">
                                    <span class="checkright2"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" placeholder="New Password"
                                        aria-label="New Password" aria-describedby="basic-addon1">
                                    <span class="checkright2"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" placeholder="Confirm Password"
                                        aria-label="Confirm Password" aria-describedby="basic-addon1">
                                    <span class="checkright2"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
    
                            </div>
                            <button class="Loginbtn">Change Password</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>