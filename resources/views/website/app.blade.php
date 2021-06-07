<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sandhesh Home page</title>
    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    @yield('headerscripts')
    <link rel="stylesheet" href=" https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('website/font/flaticon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('website/css/style.css') }}">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}"><img class="img-fluid" src="{{ asset('website/images/logo.svg') }}"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto justify-content-end">
                    <li class="nav-item  {{Request::is('/') ? 'active' : '' }}">
                        <a class="nav-item nav-link {{Request::is('/') ? 'active' : '' }}" href="{{ route('sitehome') }}">Home</a>
                    </li>
                    <li class="nav-item {{Request::is('/#aboutUs') ? 'active' : '' }}">
                        <a class="nav-item nav-link {{Request::is('/#aboutUs') ? 'active' : '' }}" href="{{ route('sitehome') }}#aboutUs">About</a>
                    </li>
                    <li class="nav-item {{Request::is('/#questionPage') ? 'active' : '' }}">
                        <a class="nav-item nav-link {{Request::is('/#questionPage') ? 'active' : '' }}" href="{{ route('sitehome') }}#questionPage">Faq</a>
                    </li>
                    <li class="nav-item {{Request::is('/#contactFeedback') ? 'active' : '' }}">
                        <a class="nav-item nav-link {{Request::is('/#contactFeedback') ? 'active' : '' }}" href="{{ route('sitehome') }}#contactFeedback">Contact Us</a>
                    </li>
                    <li class="nav-item {{Request::is('posts') ? 'active' : '' }}">
                        <a class="nav-item nav-link {{Request::is('posts') ? 'active' : '' }}" href="{{ route('showpublicpost') }}">Posts</a>
                    </li>

                    @auth
                        @php
                          $roles = Auth::check() ? Auth::user()->userRole->pluck('name')->toArray() : [];
                        @endphp 
                        @if (in_array('user', $roles))
                        <!-- My Account -->
                            <li class="nav-item navbar-dropdown ">
                                <a class="nav-item nav-link sub-add" href="#">{{Auth::user()->fname. ' '. Auth::user()->lname}}<span class="down-caretmen"></span></a>

                                <div class="dropdown">
                                    <a href="#" id="showprofilemodal">My Profile</a>
                                    <a href="{{ route('showmypost') }}">My Post</a>
                                    <a href="{{ route('showmydraft') }}">My Draft</a>
                                    <a href="#" id="showpasswordmodal">Change Password</a>
                                   
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="menu-icon typcn typcn-user-outline"></i>
                                        <span class="menu-title">Logout</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </li>
                                </div>
                            </li>

                            <li class="nav-item last">
                                <a class="nav-item nav-link last" href="{{ route('addmypost') }}">Create Post</a>
                            </li>
                        @else
                            <li class="nav-item last">
                                <a class="nav-item nav-link last" href="{{ route('admindashboard') }}">Dashboard</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>  
         
    @yield('content')
    <footer id="footer" class="footer" role="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <a href="{{ route('sitehome') }}">
                        <img class="img-fluid m-auto" src="{{ asset('website/images/logo.svg') }}">
                    </a>

                    <div class="footerLink">
                        <ul>
                            <li>
                                <a href="{{ route('sitehome') }}">Home</a>
                            </li>
                            <li>
                                <a href="{{ route('sitehome') }}#aboutUs">About</a>
                            </li>
                            <li>
                                <a href="{{ route('sitehome') }}#questionPage">Faq</a>
                            </li>
                            <li >
                                <a href="{{ route('sitehome') }}#contactFeedback">Contact Us</a>
                            </li>
                            <li >
                                <a href="{{ route('showpublicpost') }}">Posts</a>
                            </li>
                        </ul>
                    </div>

                    <div class="footerSocialIcon mt-4">
                        <ul>
                            <li><a href="https://fb.me/Hamaresandesh"><i class="fa fa-facebook" aria-hidden="true"></i></li>
                            <li><a href="https://twitter.com/hamaresandesh"><i class="fa fa-twitter" aria-hidden="true"></i></li>
                            <!-- <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></li> -->
                        </ul>
                    </div>
                    <hr>
                    <div class="col-sm-12">
                        <div class="cptext">
                            <ul>
                                <li><span class="footerContact"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                21st A Main Rd Vanganahalli; Banglore; Karnataka; India
                                </li>
                                <li><span class="footerContact"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                    <a class="phoneControl" href="mailto: connect@hmaresandesh.com">connect@hmaresandesh.com</a>

                                </li>
                            </ul>
                            <p>© @php echo date('Y'); @endphp SANDESH</p>
                        </div>
                    </div>
                </div>
            </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/owl.carousel.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/cferdinandi/bouncer@1/dist/bouncer.polyfills.min.js"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>

    @auth
        @php
            $roles = Auth::check() ? Auth::user()->userRole->pluck('name')->toArray() : [];
        @endphp
        @if (in_array('user', $roles))
            <style>
                .pac-container {
                    z-index: 2000 !important;
                }
            </style>
            <div class="modal fade" id="myProfileModal" tabindex="-1" role="dialog" aria-labelledby="myProfileModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <section id="verifyOtp" class="verifyOtp p-5" role="verifyOtp">
                                <div class="container p-0">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            
                                            @if(Session::has('FailedError'))
                                                <div class="alert alert-danger hide500">
                                                    <strong>Failed ! </strong> {{Session::get('FailedError')}}
                                                </div>
                                            @endif 
                                            <div class="forgotPage">
                                                <button type="submit" class="close1" data-dismiss="modal" onClick="window.location.reload();" aria-label="Close"><i class="flaticon-cancel"></i></button>
                                                <h4>Edit Profile</h4>
                                                <form class="form-sample js-form formForgot" method="post" action="{{route('myprofileUpdate')}}" data-validate >
                                                    @csrf
                                                    <div class="form-group showind mb-2">
                                                        <input type="text" class="form-control @error('fname') redborder @enderror"
                                                               onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                                                               placeholder="First Name * " name="fname" minlength="4" maxlength="50" required
                                                               value="{{ empty(Request::old('fname')) ? Auth::user()->fname : Request::old('fname') }}">
                                                        @error('fname')
                                                            <div class="rederror">{{ $message }}</div>
                                                        @enderror
                                                        <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Please enter valid first name">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                </span>
                                                    </div>

                                                    <div class="form-group showind mb-2">
                                                        <input type="text" class="form-control @error('lname') redborder @enderror"
                                                               onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                                                               placeholder="Last Name *" name="lname" minlength="4" maxlength="50" required
                                                               value="{{ empty(Request::old('lname')) ? Auth::user()->lname : Request::old('lname') }}">
                                                               <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Please enter valid last name">
                                                                    <i class="fa fa-info" aria-hidden="true"></i>
                                                                </span>
                                                        @error('lname')
                                                        <div class="rederror">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group mb-2">
                                                        <input type="email" class="form-control @error('email') redborder @enderror"
                                                               onkeydown="limit(this, 50);" onkeyup="limit(this, 50);" required
                                                               placeholder="Email Address" name="email" minlength="4" maxlength="50"
                                                               value="{{ empty(Request::old('email')) ? Auth::user()->email : Request::old('email') }}" autocomplete="off">
                                                               <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Please provide a valid email address for verification">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                </span>
                                                        @error('email')
                                                            <div class="rederror">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group mb-2">
                                                        <input class="form-control datepkr @error('dob') redborder @enderror" type="date"
                                                               placeholder="Date Of Birth" name="dob"  required disabled
                                                               value="{{ empty(Request::old('dob')) ? date('Y-m-d', strtotime(Auth::user()->dob)) : Request::old('dob') }}" >
                                                        @error('dob')
                                                            <div class="rederror">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group showind mb-2">
                                                        <input type="text" class="form-control onlydigits @error('mobile') redborder @enderror"
                                                               placeholder="Mobile Number *" name="mobile" required disabled
                                                               onkeydown="limit(this, 10);" onkeyup="limit(this, 10);"
                                                               value="{{ empty(Request::old('mobile')) ? Auth::user()->mobile : Request::old('mobile') }}"
                                                               pattern="^[0-9]\d{9}$">
                                                        <span class="infoicos" data-toggle="tooltip" data-placement="top"
                                                              title="Hint : Do not use +91 or 0 before number">
                                                            <i class="fa fa-info" aria-hidden="true"></i>
                                                        </span>
                                                        @error('mobile')
                                                            <div class="rederror">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group mb-2 showind">
                                                        <input id="searchTextField" type="text" class="form-control @error('address') redborder @enderror"
                                                               placeholder="Location" name="address" required
                                                               onkeydown="limit(this, 250);" onkeyup="limit(this, 250);"
                                                               value="{{ empty(Request::old('address')) ? Auth::user()->address : Request::old('address') }}" >
                                                        <span class="infoicos" onclick="autoDetectPickup()">
                                                            <i class="fa fa-location-arrow"  aria-hidden="true"></i>
                                                        </span>
                                                        <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Enter manually or allow GPS to fetch your location">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                </span>
                                                        <input type="hidden" id="ulocationlat" name="lat"
                                                               onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
                                                               value="{{ empty(Request::old('lat')) ? Auth::user()->lat : Request::old('lat') }}">
                                                        <input type="hidden" id="ulocationlong" name="long"
                                                               onkeydown="limit(this, 30);" onkeyup="limit(this, 30);"
                                                               value="{{ empty(Request::old('long')) ? Auth::user()->long : Request::old('long') }}">
                                                        @error('address')
                                                            <div class="rederror">{{ $message }}</div>
                                                        @enderror
                                                        <div id="map" style="height:600px;display:none;"> </div>
                                                    </div>

                                                    <div class="form-group showind mb-2">
                                                        <input type="text" class="form-control adharinput @error('adhaar') redborder @enderror"
                                                               placeholder="Aadhaar Number" name="adhaar" required disabled
                                                               onkeydown="limit(this, 14);" onkeyup="limit(this, 14);"
                                                               value="{{ empty(Request::old('adhaar')) ? Auth::user()->adhaar : Request::old('adhaar') }}"
                                                                >
                                                        <<span class="infoicos" data-toggle="tooltip" data-placement="top" title="We do not disclose your Aadhar to anyone ">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                </span>
                                                        @error('adhaar')
                                                            <div class="rederror">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="Loginbtn mt-3 mr-3">Save Changes</button>
                                                    <button type="button" onClick="window.location.reload();" class="Loginbtn mt-3"  data-dismiss="modal" aria-label="Close"> Cancel </button>
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
            <div class="modal fade" id="passwordmodal" tabindex="-1" role="dialog" aria-labelledby="passwordmodalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <section id="verifyOtp" class="verifyOtp p-5" role="verifyOtp">
                                <div class="container p-0">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- @if(Session::has('Succcesspassword'))
                                                <div class="alert alert-success hide500">
                                                    <strong>Success ! </strong> {{Session::get('Succcesspassword')}}
                                                </div>
                                            @endif-->
                                            @if(Session::has('Failedpassword'))
                                                <div class="alert alert-danger hide500">
                                                    <strong>Failed ! </strong> {{Session::get('Failedpassword')}}
                                                </div>
                                            @endif 
                                            <div class="forgotPage">
                                                <button type="submit" onClick="window.location.reload();" class="close1" data-dismiss="modal" aria-label="Close"><i class="flaticon-cancel"></i></button>
                                                <h4>Change Password</h4>
                                                <p class="changeP">To change your account password please
                                                    fill in fields below</p>
                                                <form class="form-sample js-form formForgot" method="post" action="{{route('passwordupdate')}}" data-validate >
                                                    @csrf
                                                    <div class="form-group showind mb-2" style="position: relative;">
                                                        <input id="password-field1" type="password" value="{{old('current_password')}}"
                                                               onkeydown="limit(this, 16);" onkeyup="limit(this, 16);"
                                                               class="form-control pr30px @error('current_password') redborder @enderror"
                                                               placeholder="Current Password"  name="current_password"
                                                               minlength="8" maxlength="16" required autocomplete="off">
                                                        <i toggle="#password-field1" class="fa fa-fw fa-eye field-icon toggle-password"></i>
                                                        <span class="infoicos" data-toggle="tooltip" data-placement="top"
                                                              title="Hint : 8 to 16 characters which contain numeric digit, alphabet and special character">
                                                            <i class="fa fa-info" aria-hidden="true"></i>
                                                        </span>
                                                        @error('current_password')
                                                            <div class="rederror">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <!-- onkeyup="limit(this, 16);" -->
                                                    <div class="form-group showind mb-2" style="position: relative;">
                                                        <input id="password-field2" type="password" value="{{old('password')}}"
                                                               onkeydown="limit(this, 16);"  onkeyup="trigger()"
                                                               class="form-control pr30px @error('password') redborder @enderror"
                                                               placeholder="New Password"  name="password"
                                                               minlength="8" maxlength="16" required autocomplete="off">
                                                        <i toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password"></i>
                                                        <span class="infoicos" data-toggle="tooltip" data-placement="top"
                                                              title="Hint : 8 to 16 characters which contain numeric digit, alphabet and special character">
                                                            <i class="fa fa-info" aria-hidden="true"></i>
                                                        </span>
                                                        <!-- <div class="indicator">
                                                            <span class="week"></span>
                                                            <span class="medium"></span>
                                                            <span class="strong"></span> 
                                                        </div>
                                                        <div class="text"> Your password is too week</div>  -->
                                                        @error('password')
                                                            <div class="rederror">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group showind mb-2" style="position: relative;">
                                                        <input id="password-field3" type="password"
                                                               onkeydown="limit(this, 16);" onkeyup="limit(this, 16);" value="{{old('password_confirmation')}}"
                                                               class="form-control pr30px @error('password_confirmation') redborder @enderror"
                                                               placeholder="Confirm Password"  name="password_confirmation"
                                                               minlength="8" maxlength="16" required autocomplete="off">
                                                        <i toggle="#password-field3" class="fa fa-fw fa-eye field-icon toggle-password"></i>
                                                        <span class="infoicos" data-toggle="tooltip" data-placement="top"
                                                              title="Hint : 8 to 16 characters which contain numeric digit, alphabet and special character">
                                                            <i class="fa fa-info" aria-hidden="true"></i>
                                                        </span>
                                                        @error('password_confirmation')
                                                            <div class="rederror">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="Loginbtn mt-3 mr-3"> Save Password </button>
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
                const indicator = document.querySelector(".indicator");
                const input = document.querySelector("input");
                const weak = document.querySelector(".weak");
                const medium = document.querySelector(".medium");
                const strong = document.querySelector(".strong");
                const text = document.querySelector(".text");
                let regExpWeek = /[a-z]/;
                let regExpMedium = /\d+/;
                let regExpStrong = /[#?!@$%^&*-]/;
                function trigger(){
                    if(input.value != ""){
                        indicator.style.display = "block";
                        indicator.style.display = "flex";
                        if(regExpWeek == input.value){

                        }
                    }else{
                        indicator.style.display= "none";
                    }
                }
                (function ($) {
                    $('#showprofilemodal').on('click', function(){
                        $('#myProfileModal').modal({backdrop: 'static', keyboard: false});
                    });

                    @if(Session::has('openprofilemodal'))
                        $('#myProfileModal').modal({backdrop: 'static', keyboard: false});
                    @endif

                    $('#showpasswordmodal').on('click', function(){
                        $('#passwordmodal').modal({backdrop: 'static', keyboard: false});
                    });

                    @if(Session::has('openpasswordmodal'))
                    $('#passwordmodal').modal({backdrop: 'static', keyboard: false});
                    @endif

                    

                })(jQuery);
            </script>
        @endif
    @endauth

            

    <script>
        var swiper = new Swiper(".swiper-container", {
            slidesPerView: 1,
            centeredSlides: true,
            freeMode: true,
            grabCursor: true,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            autoplay: {
                delay: 4000,
                disableOnInteraction: false
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            breakpoints: {
                500: {
                    slidesPerView: 1
                },
                700: {
                    slidesPerView: 1
                }
            }
        });
    </script>
    <script src="{{ asset('website/js/main.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCNdiZ-QFwFBld5GxQAs0XiDQF5G8NE0U&libraries=places" async></script>
    @yield('pagescripts')
</body>
</html>
