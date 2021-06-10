@extends('website.app')

@section('title', 'Home Page')

@section('content')

    <section id="bannerInner" class="bannerInner" role="banner" style="background-image:url({{ asset('website/images/bannerimage.png') }}); min-height: 400px">
        <div class="container-fluid">
            <div class="row">
                @if (Auth::check())
                    <div class="col-md-7"> 
                    </div>
                    <div class="col-md-5">
                        @if(Session::has('SuccessContct'))
                            <div class="alert alert-success hide500">
                                <strong>Success ! </strong> {{Session::get('SuccessContct')}}
                            </div>
                        @endif
                        @if(Session::has('FailedContct'))
                            <div class="alert alert-danger hide500">
                                <strong>Failed ! </strong> {{Session::get('FailedContct')}}
                            </div>
                        @endif
                        @if(Session::has('Succcessprofile'))
                            <div class="alert alert-success hide500">
                                <strong>Success ! </strong> {{Session::get('Succcessprofile')}}
                            </div>
                        @endif
                        @if(Session::has('Failedprofile'))
                            <div class="alert alert-danger hide500">
                                <strong>Failed ! </strong> {{Session::get('Failedprofile')}}
                            </div>
                        @endif
                        @if(Session::has('Succcesspassword'))
                            <div class="alert alert-success hide500">
                                <strong>Success ! </strong> {{Session::get('Succcesspassword')}}
                            </div>
                        @endif 
                    </div>
                @endif
                @if (!Auth::check())
                    <div class="col-md-7"> 
                    </div>
                    <div class="col-md-5">
                        @if(Session::has('SuccessNew'))
                            <div class="alert alert-success hide500">
                                <strong>Success ! </strong> {{Session::get('SuccessNew')}}
                            </div>
                        @endif
                        @if(Session::has('SuccessContct'))
                            <div class="alert alert-success hide500">
                                <strong>Success ! </strong> {{Session::get('SuccessContct')}}
                            </div>
                        @endif
                        @if(Session::has('FailedContct'))
                            <div class="alert alert-danger hide500">
                                <strong>Failed ! </strong> {{Session::get('FailedContct')}}
                            </div>
                        @endif
                        @if (!Auth::check())
                            <form method="POST" action="{{ route('login') }}" class="formContact" data-validate>
                                @csrf
                                @if ($errors->any())
                                    <ul class="mt-1 mb-2 list-disc list-inside text-sm text-red-600 hide500">
                                        @foreach ($errors->all() as $error)
                                            <li class="rederror">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if(Session::has('Success'))
                                    <div class="alert alert-success hide500">
                                        <strong>Success ! </strong> {{Session::get('Success')}}
                                    </div>
                                @endif
                                @if(Session::has('Failed'))
                                    <div class="alert alert-danger hide500">
                                        <strong>Failed ! </strong> {{Session::get('Failed')}}
                                    </div>
                                @endif
                                <h3>Welcome Sandesh </h3>
                                <p>Please provide your login details to access account.</p>
                                <div class="form-group showind ">
                                    <input type="text" class="form-control @error('otp') redborder @enderror"
                                        placeholder="Phone or Email address *"  onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                                        name="email" required value="{{Request::old('email')}}"
                                        minlength="4" maxlength="50">
                                    <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Please provide your verified email address or the 10 digit mobile number">
                                        <i class="fa fa-info" aria-hidden="true"></i>
                                    </span>
                                    @error('otp')
                                        <div class="rederror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group showind" style="position: relative;">
                                    <input id="password-field" type="password" class="form-control pr30px @error('password') redborder @enderror"
                                        onkeydown="limit(this, 16);" onkeyup="limit(this, 16);"
                                        placeholder="Password *"  name="password" minlength="8" maxlength="16" required autocomplete="off">
                                        <i toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></i>
                                    <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Please enter an alphanumeric password with at least one special and length of 8-16 characters">
                                        <i class="fa fa-info" aria-hidden="true"></i>
                                    </span>
                                    @error('password')
                                        <div class="rederror">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-between">
                                <a href="#" id="showforgotpasswordmodal">Forgot Password</a>
                                    <p> <span class="anaccount">Don't have an account?</span>
                                        <a href="{{ route('registeruser') }}">
                                            <span class="forgotpassword">Sign Up</span>
                                        </a>
                                    </p>
                                </div>
                                <button class="Loginbtn" type="submit">Sign In</button>
                            </form>
                        @endif 
                    </div>
                @else
                    <div style="margin:auto"><h3 class="welcome-msg"> <p  class="welcome-p">Welcome {{Auth::user()->fname. ' '. Auth::user()->lname}} To Sandesh</p></h3></div>
                @endif
            </div>
        </div>
    </section> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <div class="modal fade" id="forgotpasswordmodal" tabindex="-1" role="dialog" aria-labelledby="forgotpasswordmodalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <section id="verifyOtp" class="verifyOtp p-5" role="verifyOtp">
                                <div class="container p-0">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            @if(Session::has('SucccessForgotpassword'))
                                                <div class="alert alert-success hide500">
                                                    <strong>Success ! </strong> {{Session::get('SucccessForgotpassword')}}
                                                </div>
                                            @endif
                                            @if(Session::has('FailedForgotpassword'))
                                                <div class="alert alert-danger hide500">
                                                    <strong>Failed ! </strong> {{Session::get('FailedForgotpassword')}}
                                                </div>
                                            @endif
                                            <div class="forgotPage">
                                                <button type="submit" onClick="window.location.reload();" class="close1" data-dismiss="modal" aria-label="Close"><i class="flaticon-cancel"></i></button>
                                                <h4>Reset Password</h4>
                                                <p class="changeP">To rest your account password please fill in field below</p>
                                                <form class="form-sample js-form formForgot" method="post" action="{{route('forgotpassword')}}" data-validate >
                                                    @csrf
                                                    <div class="form-group showind mb-2">
                                                        <input type="text" class="form-control onlydigits @error('mobile') redborder @enderror"
                                                               placeholder="Mobile Number *" name="mobile" required
                                                               onkeydown="limit(this, 10);" onkeyup="limit(this, 10);"
                                                               value="{{ old('mobile') }}"
                                                               pattern="^[0-9]\d{9}$">
                                                        <span class="infoicos" data-toggle="tooltip" data-placement="top"
                                                              title="Please enter 10 digit mobile number without using (+91) or (0)">
                                                            <i class="fa fa-info" aria-hidden="true"></i>
                                                        </span> 

                                                        @error('mobile')
                                                            <div class="rederror">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="Loginbtn mt-3 mr-3"> Reset Password </button>
                                                    <button type="button" onClick="window.location.reload();" class="Loginbtn mt-3" data-dismiss="modal" aria-label="Close"> Cancel </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
    <script>
     
        (function ($) { 
            $('#showforgotpasswordmodal').on('click', function(){ 
                $('#forgotpasswordmodal').modal({backdrop: 'static', keyboard: false});
            });

            @if(Session::has('forgotpasswordmodal'))
            $('#forgotpasswordmodal').modal({backdrop: 'static', keyboard: false});
            @endif

        })(jQuery);
    </script>
    <div class="modal fade" id="forgototpModal" tabindex="-1" role="dialog" aria-labelledby="forgototpModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <section id="verifyOtp" class="verifyOtp p-5" role="verifyOtp">
                        <div class="container p-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    @if(Session::has('SuccessModal'))
                                        <div class="alert alert-success hide500">
                                            <strong>Success ! </strong> {{Session::get('SuccessModal')}}
                                        </div>
                                    @endif
                                    @if(Session::has('FailedModal'))
                                        <div class="alert alert-danger hide500">
                                            <strong>Failed ! </strong> {{Session::get('FailedModal')}}
                                        </div>
                                    @endif
                                    <div class="forgotPage">
                                         
                                        <button type="submit" class="close1" data-dismiss="modal" onClick="window.location.reload();" ><i class="flaticon-cancel"></i></button> 
                                        <h4>Verify Forgot OTP</h4>
                                        <p>We have sent you an OTP on</p>
                                        <p class="otpNumber">+91 @if(Session::has('tempnumber')) {{ Session::get('tempnumber')}} @endif</p>
                                        @if(Session::has('tempotp'))
                                            <p>  Your Temp OTP is : {{ Session::get('tempotp') }} </p>
                                        @endif
                                        <form class="form-sample js-form formForgot" method="post" action="{{route('forgotPassuserotp')}}" data-validate >
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>OTP</label>
                                                    <div class="form-group showind ">
                                                        <input type="text" class="form-control @error('otp') redborder @enderror"
                                                               placeholder="Please enter the 6 digit OTP here to verify"
                                                               name="otp" required value="{{Request::old('otp')}}"
                                                               pattern="^[0-9]\d{5}$">
                                                        <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Hint : Only Numbers Allowed, Minimum 6 Digits">
                                                            <i class="fa fa-info" aria-hidden="true"></i>
                                                        </span>
                                                        @error('otp')
                                                            <div class="rederror">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div style="text-align: right;">
                                                        <p>Still not received OTP?  
                                                            <a href="#"class="byCall" style=" margin-left: 8px;"
                                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >
                                                                Resend OTP
                                                            </a>
                                                        </p>
                                                    </div>
                                                    <button type="submit" class="Loginbtn mt-2">Verify OTP</button>
                                                </div>
                                            </div>
                                        </form>
                                        <form id="logout-form" action="{{ route('resendotp') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    @if(Session::has('showforgotOtpModal'))
        <script>
            (function ($) {
                $('#forgototpModal').modal({backdrop: 'static', keyboard: false});
            })(jQuery);
        </script>
    @endif
    <section id="aboutUs" class="aboutus" role="about" style="padding-bottom:0px">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="aboutPara">
                        <h4 class="sefeHeading"></h4>
                        <h2 class="customHeading">About Us </h2>
                        <p>Sandesh is an effort to provide a digital platform for obituaries.</p>

                        <p>In an unfortunate bereavement; informing the kith and kin is an important aspect. Without undermining its importance; Sandesh lets you inform the concerned people with the least effort.</p>
                        
                        <p>Sandesh is an interactive online solution that allows users to put obituaries. Contrary to the existing trend of setting status & posting a story, Sandesh serves as a dedicated platform and an appropriate channel to connect and condole. </p>
                        
                        <p>Following the approval and due validation of an obituary; Sandesh ensures that the concerned people are informed of the loss. Sandesh allows people to join in sorrow and provide strength to the grieving souls through their personalized texts and tributes.</p>
                        
                    </div>
                </div>
                <div class="col-md-6" style="max-width: 47.5%;">
                    <div class="aboutImage">
                        <img src="{{ asset('website/images/img1.png') }}" class="img-fluid" alt="">
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
                        <h2 class="customHeading">FAQs</h2> 
                    </div>


                    <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

                        <!-- Accordion card -->
                        <div class="card">

                            <!-- Card header -->
                            <div class="card-header" role="tab" id="headingOne1">
                                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1"
                                   aria-expanded="true" aria-controls="collapseOne1">
                                    <span class="number">1</span>
                                    <h5 class="cardHeading mb-0">What is a digital obituary platform? <i class="fa fa-angle-down rotate-icon rotate-icon fa-1x"></i></h5>
                                </a>
                            </div>

                            <!-- Card body -->
                            <div id="collapseOne1" class="collapse " role="tabpanel" aria-labelledby="headingOne1"
                                 data-parent="#accordionEx">
                                <div class="card-body"> 
                                    It is an effort to create an online platform where users can create and post an obituary digitally.
                                </div>
                            </div>

                        </div>

                        <!-- Accordion card -->

                        <!-- Accordion card -->
                        <div class="card">

                            <!-- Card header -->
                            <div class="card-header" role="tab" id="headingOne2">
                                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne2"
                                aria-expanded="true" aria-controls="collapseOne2">
                                    <span class="number">2</span>
                                    <h5 class="cardHeading mb-0">How to sign up?<i class="fa fa-angle-down rotate-icon"></i> </h5>
                                </a>
                            </div>

                            <!-- Card body -->
                            <div id="collapseOne2" class="collapse" role="tabpanel" aria-labelledby="headingOne2"
                                data-parent="#accordionEx">
                                <div class="card-body">
                                Signing up to Sandesh requires an OTP validation of your mobile number and an Aadhar copy.
                                </div>
                            </div>

                        </div>

                        <div class="card"> 
                            <!-- Card header -->
                            <div class="card-header" role="tab" id="headingOne3">
                                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne3"
                                aria-expanded="true" aria-controls="collapseOne3">
                                    <span class="number">3</span>
                                    <h5 class="cardHeading mb-0"> How does Sandesh validate/approve an obituary? <i class="fa fa-angle-down rotate-icon"></i> </h5>
                                </a>
                            </div>

                            <!-- Card body -->
                            <div id="collapseOne3" class="collapse" role="tabpanel" aria-labelledby="headingOne3"
                                data-parent="#accordionEx">
                                <div class="card-body">
                                Sandesh requires a copy of the death certificate or doctor’s note to be uploaded to the platform. Following which we wait for manual approval from the point of contact.
                                </div>
                            </div>
                        </div> 

                        <!-- Accordion card -->

                        <div class="card">

                            <!-- Card header -->
                            <div class="card-header" role="tab" id="headingOne4">
                                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne4"
                                   aria-expanded="true" aria-controls="collapseOne4">
                                    <span class="number">4</span>
                                    <h5 class="cardHeading mb-0">Who is a point of contact?<i class="fa fa-angle-down rotate-icon"></i> </h5>
                                </a>
                            </div>

                            <!-- Card body -->
                            <div id="collapseOne4" class="collapse" role="tabpanel" aria-labelledby="headingOne4"
                                 data-parent="#accordionEx">
                                <div class="card-body">
                                    Anyone among the relatives or close friends can approve the obituary without hassle. 
                                </div>
                            </div>

                        </div>

                        <div class="card"> 
                            <!-- Card header -->
                            <div class="card-header" role="tab" id="headingOne5">
                                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne5"
                                   aria-expanded="true" aria-controls="collapseOne5">
                                    <span class="number">5</span>
                                    <h5 class="cardHeading mb-0"> What is the duty of the point of contact? <i class="fa fa-angle-down rotate-icon"></i> </h5>
                                </a>
                            </div>

                            <!-- Card body -->
                            <div id="collapseOne5" class="collapse" role="tabpanel" aria-labelledby="headingOne5"
                                 data-parent="#accordionEx">
                                <div class="card-body">
                                    Acting as a point of contact; it is his/her duty to approve the obituary through a link sent via SMS. Following the approval his/her contact will be sent along with obituary to the people for further communication and coordination
                                </div>
                            </div>
                        </div>

                        <div class="card"> 
                            <!-- Card header -->
                            <div class="card-header" role="tab" id="headingOne6">
                                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne6"
                                   aria-expanded="true" aria-controls="collapseOne6">
                                    <span class="number">6</span>
                                    <h5 class="cardHeading mb-0"> How does Sandesh inform people about the loss of life?  <i class="fa fa-angle-down rotate-icon"></i> </h5>
                                </a>
                            </div>

                            <!-- Card body -->
                            <div id="collapseOne6" class="collapse" role="tabpanel" aria-labelledby="headingOne6"
                                 data-parent="#accordionEx">
                                <div class="card-body">
                                    Sandesh uses SMS and Whatsapp channels for broadcasting the messages to the concerned groups. 
                                    Simultaneously; the obituary will be put on a publicly accessible website of Sandesh.
                                </div>
                            </div>
                        </div>

                        <div class="card"> 
                            <!-- Card header -->
                            <div class="card-header" role="tab" id="headingOne7">
                                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne7"
                                   aria-expanded="true" aria-controls="collapseOne7">
                                    <span class="number">7</span>
                                    <h5 class="cardHeading mb-0"> How long does the post stay on the publicly accessible page?  <i class="fa fa-angle-down rotate-icon"></i> </h5>
                                </a>
                            </div>

                            <!-- Card body -->
                            <div id="collapseOne7" class="collapse" role="tabpanel" aria-labelledby="headingOne5"
                                 data-parent="#accordionEx">
                                <div class="card-body">
                                    Following the approval; the post would be visible for 20 days
                                </div>
                            </div>
                        </div>

                        <div class="card"> 
                            <!-- Card header -->
                            <div class="card-header" role="tab" id="headingOne8">
                                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne8"
                                   aria-expanded="true" aria-controls="collapseOne8">
                                    <span class="number">8</span>
                                    <h5 class="cardHeading mb-0"> What happens if the obituary is rejected? <i class="fa fa-angle-down rotate-icon"></i> </h5>
                                </a>
                            </div>

                            <!-- Card body -->
                            <div id="collapseOne8" class="collapse" role="tabpanel" aria-labelledby="headingOne5"
                                 data-parent="#accordionEx">
                                <div class="card-body">
                                    An obituary can be rejected either by the point of contact or on the basis of Sandesh guidelines.
                                    In either case; the user can follow the note/remarks to make corrections and submit for approval again.     
                                </div>
                            </div>
                        </div>

                        <div class="card"> 
                            <!-- Card header -->
                            <div class="card-header" role="tab" id="headingOne5">
                                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne9"
                                   aria-expanded="true" aria-controls="collapseOne9">
                                    <span class="number">9</span>
                                    <h5 class="cardHeading mb-0">How to report an abuse of Sandesh? <i class="fa fa-angle-down rotate-icon"></i> </h5>
                                </a>
                            </div>

                            <!-- Card body -->
                            <div id="collapseOne9" class="collapse" role="tabpanel" aria-labelledby="headingOne5"
                                 data-parent="#accordionEx">
                                <div class="card-body">
                                    Anyone can report the abuse of Sandesh. Use email and other communication channels mentioned on our contacts page.Further; users can also report abuse via links sent to them in SMS and Whatsapp channels.Sandesh ensures that strict legal action will be taken against violators of guidelines.     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="questionimage">
                        <img src="{{ asset('website/images/questionimg.png') }}" alt="">
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
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.852528546875!2d77.64406621464464!3d12.917198290891495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae148440ff34fd%3A0xd6bed09c5399614e!2s21st%20A%20Main%20Rd%2C%201st%20Sector%2C%20HSR%20Layout%2C%20Bengaluru%2C%20Karnataka%20560102!5e0!3m2!1sen!2sin!4v1622781850498!5m2!1sen!2sin"
                            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <!-- 21st A Main Rd Vanganahalli; Banglore; Karnataka; India -->
                </div>
                <div class="col-md-6">
                    <div class="feedbackPara">
                        <h2 class="customHeading">Give Us Feedback</h2>
                        <p>How satisfied update blog posts and spccial offers in your inbox</p>
                        <form class="form-sample js-form formContactregi px-0"
                              method="post" action="{{route('contactsubmit')}}" >
                            @csrf
                            <div class="star-rating">
                                <fieldset>
                                    <input type="radio"  @if(old('rating') == 5 || old('rating') == 4 || old('rating') == 3 || old('rating') == 2 || old('rating') == 1) checked @endif class="@error('rating') redborder @enderror" id="star5" name="rating" value="5" /><label for="star5" title="Outstanding" class="bstar"></label>
                                    <input type="radio"   @if(old('rating') == 5 || old('rating') == 4 || old('rating') == 3 || old('rating') == 2) checked @endif class="@error('rating') redborder @enderror" id="star4" name="rating" value="4" /><label for="star4" title="Very Good" class="bstar"></label>
                                    <input type="radio"  @if(old('rating') == 5 || old('rating') == 4 || old('rating') == 3) checked @endif class="@error('rating') redborder @enderror" id="star3" name="rating" value="3" /><label for="star3" title="Good" class="bstar"></label>
                                    <input type="radio"  @if(old('rating') == 5 || old('rating') == 4 ) checked @endif class="@error('rating') redborder @enderror" id="star2" name="rating" value="2" /><label for="star2" title="Poor" class="bstar"></label>
                                    <input type="radio"  @if(old('rating') == 5 ) checked @endif class="@error('rating') redborder @enderror" id="star1" name="rating" value="1" /><label for="star1" title="Very Poor" class="bstar"></label>
                                </fieldset>
                                @error('rating')
                                <div class="rederror">{{ $message }}</div>
                            @enderror
                            </div>
                            <input type="text" class="form-control @error('name') redborder @enderror"
                                    onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                                    placeholder="Name * " name="name" minlength="3" maxlength="50" 
                                    value="{{old('name') }}">
                            @error('name')
                                <div class="rederror">{{ $message }}</div>
                            @enderror

                            <input type="email" class="form-control @error('useremail') redborder @enderror"
                                    onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                                    placeholder="Email Address" name="useremail" minlength="4" maxlength="50"
                                    value="{{old('useremail') }}" autocomplete="off">
                            @error('useremail')
                                <div class="rederror">{{ $message }}</div>
                            @enderror

                            <input type="text" class="form-control onlydigits @error('usermobile') redborder @enderror"
                                    placeholder="Mobile Number *" name="usermobile"
                                    onkeydown="limit(this, 10);" onkeyup="limit(this, 10);"
                                    value="{{Request::old('usermobile') }}"
                                    pattern="^[0-9]\d{9}$">
                            @error('usermobile')
                                <div class="rederror">{{ $message }}</div>
                            @enderror
                                
                            <textarea type="text" class="form-control @error('name') redborder @enderror"
                            style="margin-top:35px" rows="3" placeholder="Message*" name="message" 
                                    onkeydown="limit(this, 250);" onkeyup="limit(this, 250);"
                                    > {{Request::old('message') }} </textarea>
                            @error('message')
                                <div class="rederror">{{ $message }}</div>
                            @enderror 
                            <button class="submit1 btn" type="submit">Submit Now</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- <script src="{{ asset('website/js/main.js') }}"></script> -->
@endsection
