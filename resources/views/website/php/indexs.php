<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<section id="bannerInner" class="bannerInner" role="banner"
 style="background-image:url(images/bannerimage.png);">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">

            </div>
            <div class="col-md-5">
                <form method="POST" action="{{ route('login') }}" class="formContact">
                    @csrf
                    <h3>welcome Sandesh </h3>
                    <p>Lorem ipsum dolor sit amet, labores nostrum eam te.</p>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Phone*" name="email">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Password*" name="password">
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="forgotPwd"><span class="forgotpassword">Forgot password ?</span>
                            <a href="#">
                                <p> <span class="anaccount">Don't have an account?</span> <span class="forgotpassword">Sign Up</span> </p>
                            </a>
                    </div>
                    <button class="Loginbtn" type="submit">Log In</button>
                </form>
            </div>
        </div>
    </div>
</section>
<section id="aboutUs" class="aboutus" role="about">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="aboutPara">
                    <h4 class="sefeHeading">About</h4>
                    <h2 class="customHeading">labores nostrum eam te.
                        Mel tantas alienum pertinacia
                    </h2>
                    <p>Lorem ipsum dolor sit amet, labores nostrum eam te. Mel tantas alienum pertinacia id. Lorem ipsum
                        dolor sit amet, labores nostrum eam te. Mel tantas alienum pertinacia i Lorem ipsum dolor sit
                        amet, labores nostrum eam te. Mel tantas alienum pertinacia id.d.
                    </P>
                    <ul>
                        <li><span class="checkImage"><img src="images/checkimg.png" class="img-fluid" alt="">
                            </span>
                            We provide the best logistic service for globally
                        </li>
                        <li><span class="checkImage"><img src="images/checkimg.png" class="img-fluid" alt="">
                            </span>
                            We know how to make it in time and set the right terms
                        </li>
                        <li><span class="checkImage"><img src="images/checkimg.png" class="img-fluid" alt="">
                            </span>
                            All payment methods are acceptable for ordering our services.
                        </li>
                    </ul>
                    <hr>
                </div>

                <div class="signImage">
                    <img src="images/signimg.png" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="aboutImage">
                    <img src="images/img1.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<section id="questionPage" class="questionPage" role=Faq>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="questionPara">
                    <h2 class="customHeading">FAQ</h2>
                    <p>Lorem ipsum dolor sit amet, labores nostrum eam te. Mel tantas alienum pertinacia id.Lorem ipsum
                        dolor sit amet, labores nostrum eam te. Mel tantas </p>
                </div>


                <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

                    <!-- Accordion card -->
                    <div class="card">

                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headingOne1">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1"
                                aria-expanded="true" aria-controls="collapseOne1">
                                <span class="number">1</span>
                                <h5 class="cardHeading mb-0">
                                    Lorem ipsum dolor sit amet, labores nostrum eam te. <i
                                        class="fa fa-angle-down rotate-icon rotate-icon fa-1x"></i>
                                </h5>
                            </a>
                        </div>

                        <!-- Card body -->
                        <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1"
                            data-parent="#accordionEx">
                            <div class="card-body">
                                Lorem ipsum dolor sit amet, labores nostrum eam te. Mel tantas alienum
                                pertinacia
                                id.Lorem ipsum dolor sit amet, labores nostrum eam te. Mel tantas Mel tantas
                                alienum
                                pertinacia id.Lorem ipsum dolor sit amet, labores nostrum eam te.
                            </div>
                        </div>

                    </div>

                    <!-- Accordion card -->

                    <!-- Accordion card -->

                    <div class="card">

                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headingTwo2">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2"
                                aria-expanded="false" aria-controls="collapseTwo2">
                                <span class="number">2</span>
                                <h5 class="cardHeading mb-0">
                                    Lorem ipsum dolor sit amet, labores nostrum eam te. Mel
                                    tantas alienum pertinacia id.Lorem ipsum dolor sit amet, <i
                                        class="fa fa-angle-down rotate-icon"></i>
                                </h5>
                            </a>
                        </div>

                        <!-- Card body -->
                        <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2"
                            data-parent="#accordionEx">
                            <div class="card-body">
                                Lorem ipsum dolor sit amet, labores nostrum eam te. Mel tantas alienum pertinacia
                                id.Lorem ipsum dolor sit amet, labores nostrum eam te. Mel tantas Mel tantas alienum
                                pertinacia id.Lorem ipsum dolor sit amet, labores nostrum eam te.
                            </div>
                        </div>

                    </div>

                    <!-- Accordion card -->

                    <!-- Accordion card -->

                    <div class="card">

                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headingThree3">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx"
                                href="#collapseThree3" aria-expanded="false" aria-controls="collapseThree3">
                                <span class="number">3</span>
                                <h5 class="cardHeading mb-0">
                                    All payment methods are acceptable for ordering our services. <i
                                        class="fa fa-angle-down rotate-icon"></i>
                                </h5>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3"
                            data-parent="#accordionEx">
                            <div class="card-body">
                                Lorem ipsum dolor sit amet, labores nostrum eam te. Mel tantas alienum pertinacia
                                id.Lorem ipsum dolor sit amet, labores nostrum eam te. Mel tantas Mel tantas alienum
                                pertinacia id.Lorem ipsum dolor sit amet, labores nostrum eam te.
                            </div>
                        </div>

                    </div>

                    <!-- Accordion card -->

                    <div class="card">

                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headingOne4">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne4"
                                aria-expanded="true" aria-controls="collapseOne1">
                                <span class="number">4</span>
                                <h5 class="cardHeading mb-0">
                                    All payment methods are acceptable for ordering our services.<i
                                        class="fa fa-angle-down rotate-icon"></i>
                                </h5>
                            </a>
                        </div>

                        <!-- Card body -->
                        <div id="collapseOne4" class="collapse show" role="tabpanel" aria-labelledby="headingOne4"
                            data-parent="#accordionEx">
                            <div class="card-body">
                                Lorem ipsum dolor sit amet, labores nostrum eam te. Mel tantas alienum pertinacia
                                id.Lorem ipsum dolor sit amet, labores nostrum eam te. Mel tantas Mel tantas alienum
                                pertinacia id.Lorem ipsum dolor sit amet, labores nostrum eam te.
                            </div>
                        </div>

                    </div>

                    <div class="card">

                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headingOne5">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne5"
                                aria-expanded="true" aria-controls="collapseOne1">
                                <span class="number">5</span>
                                <h5 class="cardHeading mb-0">
                                    All payment methods are acceptable for ordering our services. <i
                                        class="fa fa-angle-down rotate-icon"></i>
                                </h5>
                            </a>
                        </div>

                        <!-- Card body -->
                        <div id="collapseOne5" class="collapse show" role="tabpanel" aria-labelledby="headingOne5"
                            data-parent="#accordionEx">
                            <div class="card-body">
                                Lorem ipsum dolor sit amet, labores nostrum eam te. Mel tantas alienum pertinacia
                                id.Lorem ipsum dolor sit amet, labores nostrum eam te. Mel tantas Mel tantas alienum
                                pertinacia id.Lorem ipsum dolor sit amet, labores nostrum eam te.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="questionimage">
                    <img src="images/questionimg.png" alt="">
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<section id="contactFeedback" class="contactFeedback" role="feedback">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="googlemap">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3671.606112739776!2d72.52113961403036!3d23.03823028494509!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e84b45f72b935%3A0x8701ed08268cf6a7!2sSandesh%20Press%20Rd%2C%20Vastrapur%2C%20Ahmedabad%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1617195035975!5m2!1sen!2sin"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
            <div class="col-md-6">
                <div class="feedbackPara">
                    <h2 class="customHeading">Give Us Feedback</h2>
                    <p>How satisfied update blog posts and spccial offers in your inbox</p>
                    <ul>
                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                    </ul>
                    <form>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"placeholder="Message"></textarea>
                        <button class="submit1 btn">Submit Now</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>
<?php include('footerbottom.php'); ?>
