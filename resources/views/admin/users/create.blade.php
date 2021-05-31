@include('admin.layouts.head')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header">
            <h4 class="page-title">Add New User</h4>
        </div>
    </div>
</div>
<!-- Page Title Header Ends-->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                @if(Session::has('Success'))
                    <div class="alert alert-success">
                        <strong>Success ! </strong> {{Session::get('Success')}}
                    </div>
                @endif
                @if(Session::has('Failed'))
                    <div class="alert alert-danger">
                        <strong>Failed ! </strong> {{Session::get('Failed')}}
                    </div>
                @endif
                <form class="form-sample js-form" method="post" action="{{route('admin.users.store')}}" data-validate>
                    @csrf
                    <div class="errormessage" id="selfRegMessage">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">First Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('fname') redborder @enderror" name="fname" minlength="4" maxlength="15" required
                                           value="{{Request::old('fname')}}">
                                    <div class="hintinput">( Hint : Do not use #?!@$%^&*- and numbers )</div>
                                    @error('fname')
                                    <div class="rederror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Last Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('lname') redborder @enderror" name="lname" minlength="4" maxlength="15" required
                                           value="{{Request::old('lname')}}">
                                    <div class="hintinput">( Hint : Do not use #?!@$%^&*- and numbers )</div>
                                    @error('lname')
                                    <div class="rederror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email Address</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control @error('email') redborder @enderror" name="email" minlength="4" maxlength="50" required
                                           value="{{Request::old('email')}}" autocomplete="off">
                                    @error('email')
                                    <div class="rederror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Password </label>
                                <div class="col-sm-9">
                                    <input id="password-field" type="password" class="form-control pr30px @error('password') redborder @enderror"
                                           name="password" minlength="8" maxlength="16" required autocomplete="off">
                                    <i toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></i>
                                    <div class="hintinput">( Hint : 8 to 16 characters which contain numeric digit, alphabet and special character)</div>
                                    @error('password')
                                    <div class="rederror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row" >
                                <label class="col-sm-3 col-form-label month">Mobile Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('mobile') redborder @enderror" name="mobile" required
                                           value="{{Request::old('mobile')}}" pattern="^[0-9]\d{9}$">
                                    <div class="hintinput">( Hint : Do not use +91 or 0 before number)</div>
                                        @error('mobile')
                                            <div class="rederror">{{ $message }}</div>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date of Birth</label>
                                <div class="col-sm-9">
                                    <input class="form-control datepkr @error('dob') redborder @enderror" type="date" name="dob" placeholder="dd/mm/yyyy" required
                                           value="{{Request::old('dob')}}" >
                                    @error('dob')
                                    <div class="rederror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Adhaar Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('adhaar') redborder @enderror" name="adhaar" required
                                           value="{{Request::old('adhaar')}}" pattern="^[0-9]\d{15}$">
                                    <div class="hintinput">( Hint : Only Numbers Allowed, having 16 Digits )</div>
                                    @error('adhaar')
                                    <div class="rederror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Address</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control @error('address') redborder @enderror" name="address"
                                              placeholder="Address" required minlength="4" maxlength="250">{{Request::old('address')}}</textarea>
                                    <div class="hintinput">( Hint : Max 250 characters Allowed )</div>
                                    @error('address')
                                    <div class="rederror">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-fw mr-3">Save</button>
                        <a href="{{route('admin.users.index')}}" class="btn btn-success btn-fw">Go Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('admin.layouts.footer')

<script>
    var bouncer = new Bouncer('[data-validate]', {
        disableSubmit: false,
        customValidations: {
            valueMismatch: function (field) {

                // Look for a selector for a field to compare
                // If there isn't one, return false (no error)
                var selector = field.getAttribute('data-bouncer-match');
                if (!selector) return false;

                // Get the field to compare
                var otherField = field.form.querySelector(selector);
                if (!otherField) return false;

                // Compare the two field values
                // We use a negative comparison here because if they do match, the field validates
                // We want to return true for failures, which can be confusing
                return otherField.value !== field.value;

            }
        },
        messages: {
            valueMismatch: function (field) {
                var customMessage = field.getAttribute('data-bouncer-mismatch-message');
                return customMessage ? customMessage : 'Please make sure the fields match.'
            }
        }
    });

    document.addEventListener('bouncerFormInvalid', function (event) {
        console.log(event.detail.errors);
        console.log(event.detail.errors[0].offsetTop);
        window.scrollTo(0, event.detail.errors[0].offsetTop);
    }, false);

    document.addEventListener('bouncerFormValid', function () {
        // alert('Form submitted successfully!');
        // window.location.reload();
    }, false);



</script>
