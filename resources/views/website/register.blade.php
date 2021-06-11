@extends('website.app')

@section('headerscripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.7.3/tailwind.min.css" />
@endsection

@section('title', 'Home Page')

@section('content')

    <section id="registrationPage" class="registrationPage" role="registration">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 d-flex align-items-center ">
                    <div class="registForm w-100">
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

                        <form class="form-sample js-form formContactregi" method="post" action="{{route('registeruserform')}}"
                              data-validate enctype="multipart/form-data">
                            @csrf

                            <div class="form-group showind mb-2">
                                <input type="text" class="form-control @error('fname') redborder @enderror"
                                       placeholder="First Name * " name="fname" required
                                       onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                                       value="{{Request::old('fname')}}">
                                @error('fname')
                                    <div class="rederror">{{ $message }}</div>
                                @enderror
                                <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Please enter valid first name">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                </span>
                            </div>

                            <div class="form-group showind mb-2">
                                <input type="text" class="form-control @error('lname') redborder @enderror"
                                       placeholder="Last Name *" name="lname"  required
                                       onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                                       value="{{Request::old('lname')}}">
                                <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Please enter valid last name">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                </span>
                                @error('lname')
                                    <div class="rederror">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group  showind mb-2">
                                <input type="text" class="form-control @error('email') redborder @enderror"
                                       placeholder="Email Address" name="email" 
                                       onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                                       value="{{Request::old('email')}}" autocomplete="off">
                                <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Please provide a valid email address for verification">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                </span>
                                @error('email')
                                    <div class="rederror">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group showind mb-2" style="position: relative;">
                                <input id="password-field" type="password" class="form-control pr30px @error('password') redborder @enderror"
                                       placeholder="Password *"  name="password" required autocomplete="off"
                                       onkeydown="limit(this, 16);" onkeyup="limit(this, 16);">
                                <i toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></i>
                                <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Please enter an alphanumeric password with at least one special and length of 8-16 characters">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                </span>
                                @error('password')
                                    <div class="rederror">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group showind mb-2">
                                <input class="form-control datepkr @error('dob') redborder @enderror" min="1920-01-01" type="date"
                                       placeholder="Date Of Birth" name="dob" required
                                       value="{{Request::old('dob')}}">
                                       <!-- <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Enter manually in dd/mm/yyyy format or click on calendar icon to choose year-month-day">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                </span>        -->
                                @error('dob')
                                    <div class="rederror">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group showind mb-2">
                                <input type="text" class="form-control onlydigits @error('mobile') redborder @enderror"
                                       placeholder="Mobile Number *" name="mobile" required
                                       onkeydown="limit(this, 10);" onkeyup="limit(this, 10);"
                                       value="{{Request::old('mobile')}}" pattern="^[0-9]\d{9}$">
                                <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Do not use (+91) or (0)">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                </span>
                                @error('mobile')
                                    <div class="rederror">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-2 showind">
                                <input id="searchTextField" type="text" class="form-control @error('address') redborder @enderror"
                                       placeholder="Location *" name="address" required value="{{Request::old('address')}}"
                                       onkeydown="limit(this, 250);" onkeyup="limit(this, 250);">
                                <span class="infoicos" onclick="autoDetectPickup()"><i class="fa fa-location-arrow field-icon" style="top:3px;" aria-hidden="true"></i></span>
                                <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Enter manually or allow GPS to fetch your location">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                </span>
                                <input type="hidden" id="ulocationlat" name="lat" value="{{Request::old('lat')}}"
                                       onkeydown="limit(this, 30);" onkeyup="limit(this, 30);">
                                <input type="hidden" id="ulocationlong" name="long" value="{{Request::old('long')}}"
                                       onkeydown="limit(this, 30);" onkeyup="limit(this, 30);">
                                @error('address')
                                    <div class="rederror">{{ $message }}</div>
                                @enderror
                                <div id="map" style="height:600px;display:none;"> </div>
                            </div>

                            <div class="form-group showind mb-2">
                                <input type="text" class="form-control adharinput   @error('adhaar') redborder @enderror"
                                       placeholder="Aadhaar Number" name="adhaar" required
                                       value="{{Request::old('adhaar')}}"
                                       onkeydown="limit(this, 14);" onkeyup="limit(this, 14);">
                                <span class="infoicos" data-toggle="tooltip" data-placement="top" title="We do not disclose your Aadhar to anyone ">
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                </span>
                                @error('adhaar')
                                    <div class="rederror">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4 showind">
                                <div class="pt-2">
                                    <!-- If you wish to reference an existing file (i.e. from your database), pass the url into imageData() -->
                                    <div x-data="imageData('{{Request::old('adhaar_file')}}')" class="file-input flex items-center">
                                        <!-- Preview Image -->
                                        <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                            <!-- Placeholder image -->
                                            <div x-show="!previewPhoto" >
                                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            </div>
                                            <!-- Show a preview of the photo -->
                                            <div x-show="previewPhoto" class="h-12 w-12 rounded-full overflow-hidden">
                                                <img :src="previewPhoto" alt="" class="h-12 w-12 object-cover">
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <!-- File Input -->
                                            <div class="ml-5 rounded-md shadow-sm">
                                                <!-- Replace the file input styles with our own via the label -->
                                                <input @change="updatePreview($refs)" x-ref="input"
                                                       type="file"
                                                       accept="image/*,capture=camera"
                                                       name="adhaar_file" id="photo"
                                                       class="custom customfileinput"
                                                       required>
                                                <label for="photo" class="@error('adhaar_file') redborder @enderror py-2 mb-0 px-3 border border-gray-300 rounded-md text-sm
                                                       leading-4 font-medium text-gray-700 hover:text-indigo-500 hover:border-indigo-300
                                                       focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-gray-50
                                                       active:text-indigo-800 transition duration-150 ease-in-out">
                                                       We do not disclose your Aadhar to anyone (Max : 5MB File size)
                                                </label>
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500 mx-2">
                                                <!-- Display the file name when available -->
                                                <span x-text="fileName || emptyText"></span>
                                                <!-- Removes the selected file -->
                                                <button x-show="fileName"
                                                        @click="clearPreview($refs)"
                                                        type="button"
                                                        aria-label="Remove image"
                                                        class="mx-1 mt-1">
                                                    <svg viewBox="0 0 20 20" fill="currentColor" class="x-circle w-4 h-4"
                                                         aria-hidden="true" focusable="false">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                              clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('adhaar_file')
                                    <div class="rederror">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-5" >
                                <button type="submit" class="signUp1 btn">Sign Up</button>
                                <span> Already have an account ?
                                    <a href="{{ route('sitehome') }}" class="memberSign"> Sign In </a>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="regiFormImage" style="background-image:url({{ asset('website/images/regiimg.png') }})">
                        <div class="regiText">
                            <h5>Welcome</h5>
                            <h3>Sandesh</h3>
                            <p>Have a Project're interested in discussing with us?</p>
                            <div class="d-flex">
                                <p class="helpAny">Need Any Help?</p>
                                <a href="{{ route('sitehome') }}#contactFeedback" class="contacthelp btn">Contact</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pagescripts')

    <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalTitle" aria-hidden="true">
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
                                        <form id="reset-data" action="{{ route('resetuserform') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="close1"><i class="flaticon-cancel"></i></button>
                                        </form>
                                        <h4>Verify OTP</h4>
                                        <p>We have sent you an OTP on</p>
                                        <p class="otpNumber">+91 @if(Session::has('tempUser')) {{ Session::get('tempUser')->mobile }} @endif</p>
                                        @if(Session::has('tempotp'))
                                            <p>  Your Temp OTP is : {{ Session::get('tempotp') }} </p>
                                        @endif
                                        <form class="form-sample js-form formForgot" method="post" action="{{route('registeruserotp')}}" data-validate >
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
                                                    <div class="d-flex justify-content-between">
                                                        <p>Still not received OTP? </p>
                                                        <p>
                                                            <a href="#"class="byCall"
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

    @if(Session::has('showOtpModal'))
        <script>
            (function ($) {
                $('#otpModal').modal({backdrop: 'static', keyboard: false});
            })(jQuery);
        </script>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.6.0/alpine.js"></script>
@endsection
