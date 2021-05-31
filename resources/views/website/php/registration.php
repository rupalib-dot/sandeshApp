<?php include('header.php'); ?>
<?php include('nav.php'); ?>

<section id="registrationPage" class="registrationPage" role="registration">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="registForm">
                    <img class="img-fluid" src="images/logo.svg">
                    <form action="/action_page.php" class="formContactregi">
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Name*" aria-label="Name*"
                                aria-describedby="basic-addon1">
                            <span class="checkright"><i class="fa fa-check" aria-hidden="true"></i></span>
                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Surname*" aria-label="Surname*"
                                aria-describedby="basic-addon1">
                                <span class="checkright"><i class="fa fa-check" aria-hidden="true"></i></span>
                        </div>
                       
                        <div class="input-group mb-4">
                            <input type="date" class="form-control" placeholder="Date Of Birth" aria-label="Date Of Birth"
                                aria-describedby="basic-addon1">
                                <span class="checkright2"> <i class="flaticon-calendar-interface-symbol-tool"></i></span>
                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Mobile*" aria-label="Mobile*"
                                aria-describedby="basic-addon1">
                                <span class="checkright"><i class="fa fa-check" aria-hidden="true"></i></span>
                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Aadhar Number" aria-label="Aadhar Number"
                                aria-describedby="basic-addon1">
                                <span class="checkright"><i class="fa fa-check" aria-hidden="true"></i></span>
                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Location" aria-label="Location"
                                aria-describedby="basic-addon1">
                        </div>
                    </form>
                    <div class="d-flex justify-content-around" >
                      <button class="signUp1 btn">Sign Up</button> 
                      <a href="#" class="memberSign">Already a member? Sign In</a> 
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="regiFormImage" style="background-image:url(images/regiimg.png)">
                    <div class="regiText">
                        <h5>Welcome</h5>
                        <h3>Sandesh</h3>
                        <p>Have a Project're interested in discussing with us?</p>
                        <div class="d-flex">
                            <a href="#" class="helpAny">Need Any Help?</a>
                            <button class="contacthelp btn">Contact</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('footer.php'); ?>