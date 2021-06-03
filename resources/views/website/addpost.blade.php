@extends('website.app')

@section('headerscripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.7.3/tailwind.min.css" />
@endsection

@section('title', 'Home Page')

@section('content')
<section id="registrationPage" class="registrationPage" role="registration">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(isset($post->id))
                <h3 class="addHeading">Edit Post</h3>
                @else
                <h3 class="addHeading">Create Post</h3>
                @endif
            </div>
        </div>

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

        <form class="form-sample js-form formContactregi px-0" method="post"
            action="{{route('addmypost', isset($post->id) ? $post->id : '')}}" data-validate
            enctype="multipart/form-data">
            @csrf
            @if(isset($post->id))
            <input type="hidden" name="_method" value="PUT">
            @endif
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group showind mb-4">
                        <input type="text" class="form-control @error('person_name') redborder @enderror"
                            placeholder="Name *" name="person_name" minlength="3" maxlength="50" required
                            onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                            value="{{isset($post->person_name) ? $post->person_name : Request::old('person_name')}}">
                        @error('person_name')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                        <span class="infoicos" data-toggle="tooltip" data-placement="top"
                            title="Hint : Do not use #?!@$%^&*- and numbers">
                            <i class="fa fa-info" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group showind mb-4">
                        <input type="text" class="form-control @error('surname') redborder @enderror"
                            placeholder="Surname *" name="surname" minlength="3" maxlength="50" required
                            onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                            value="{{isset($post->surname) ? $post->surname : Request::old('surname')}}">
                        @error('surname')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                        <span class="infoicos" data-toggle="tooltip" data-placement="top"
                            title="Hint : Do not use #?!@$%^&*- and numbers">
                            <i class="fa fa-info" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group mb-4">
                        <input class="form-control datepkr @error('age') redborder @enderror" type="text"
                            placeholder="Date Of Birth *" min="1920-01-01" name="age" required
                            value="{{isset($post->age) ? $post->age : Request::old('age')}}"
                            onfocus="(this.type='date')" onblur="(this.type='text')">
                        @error('age')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group mb-4">
                        <input class="form-control datepkr @error('date_of_death') redborder @enderror" type="text"
                            placeholder="Date Of Demise *" min="1920-01-01" name="date_of_death" required
                            value="{{isset($post->date_of_death) ? $post->date_of_death : Request::old('date_of_death')}}"
                            onfocus="(this.type='date')" onblur="(this.type='text')">
                        @error('date_of_death')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group mb-4">
                        <select name="swd" onchange="getplaceholder(this.value)" class="form-control @error('swd') redborder @enderror" required>
                            <option value="">Select Relation</option>
                            <option {{ Request::old('swd', isset($post) ? $post->swd : '') == 'S/O' ? 'selected' : '' }}
                                value="S/O">S/O</option>
                            <option {{ Request::old('swd', isset($post) ? $post->swd : '') == 'W/O' ? 'selected' : '' }}
                                value="W/O">W/O</option>
                            <option {{ Request::old('swd', isset($post) ? $post->swd : '') == 'D/O' ? 'selected' : '' }}
                                value="D/O">D/O</option>
                            <option {{ Request::old('swd', isset($post) ? $post->swd : '') == 'M/O' ? 'selected' : '' }}
                                value="M/O">M/O</option>
                            <option {{ Request::old('swd', isset($post) ? $post->swd : '') == 'F/O' ? 'selected' : '' }}
                                value="F/O">F/O</option>
                            <option {{ Request::old('swd', isset($post) ? $post->swd : '') == 'H/O' ? 'selected' : '' }}
                                value="H/O">H/O</option>
                        </select>
                        @error('swd')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group showind mb-4">
                        <input type="text" class="form-control @error('swdperson') redborder @enderror"
                            placeholder="Name of person" name="swdperson" minlength="4" maxlength="50"
                            onkeydown="limit(this, 50);" onkeyup="limit(this, 50);" required id="swdperson"
                            value="{{isset($post->swdperson) ? $post->swdperson : Request::old('swdperson')}}">
                        @error('swdperson')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                        <span class="infoicos" data-toggle="tooltip" data-placement="top"
                            title="Hint : Do not use #?!@$%^&*- and numbers">
                            <i class="fa fa-info" aria-hidden="true"></i>
                        </span>
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group showind mb-4">
                        <input type="text" class="form-control @error('institute') redborder @enderror"
                            placeholder="Known for position (Optional)" name="institute" minlength="4" maxlength="50"
                            onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                            value="{{isset($post->institute) ? $post->institute : Request::old('institute')}}">
                        @error('institute')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                        <span class="infoicos" data-toggle="tooltip" data-placement="top"
                            title="Hint : Do not use #?!@$%^&*- and numbers">
                            <i class="fa fa-info" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group mb-4 showind">
                        <input id="searchTextField" type="text"
                            class="form-control @error('address') redborder @enderror" onkeydown="limit(this, 250);"
                            onkeyup="limit(this, 250);" placeholder="Location *" name="address" required
                            value="{{isset($post->address) ? $post->address : Request::old('address')}}">
                        <span class="infoicos" onclick="autoDetectPickup()"><i class="fa fa-location-arrow"
                                aria-hidden="true"></i></span>
                        <input type="hidden" id="ulocationlat" onkeydown="limit(this, 30);" onkeyup="limit(this, 10);"
                            name="lat" value="{{isset($post->lat) ? $post->lat : Request::old('lat')}}">
                        <input type="hidden" id="ulocationlong" onkeydown="limit(this, 30);" onkeyup="limit(this, 10);"
                            name="long" value="{{isset($post->long) ? $post->long : Request::old('long')}}">
                        @error('address')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                        <div id="map" style="height:600px;display:none;"> </div>
                    </div>
                </div>
            </div>
            <hr>
            <h5> Point Of Contact</h5>

            <div class="row" style="margin-top:20px">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group showind mb-4">
                        <input type="text" class="form-control @error('pocontact') redborder @enderror"
                            placeholder="Contact First Name *" name="pocontact" minlength="3" maxlength="50" required
                            onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                            value="{{isset($post->pocontact) ? $post->pocontact : Request::old('pocontact')}}">
                        @error('pocontact')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                        <span class="infoicos" data-toggle="tooltip" data-placement="top"
                            title="Hint : Do not use #?!@$%^&*- and numbers">
                            <i class="fa fa-info" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group showind mb-4">
                        <input type="text" class="form-control @error('lname') redborder @enderror"
                            placeholder="Contact Last Name *" name="lname" minlength="3" maxlength="50" required
                            onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                            value="{{isset($post->lname) ? $post->lname : Request::old('lname')}}">
                        @error('lname')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                        <span class="infoicos" data-toggle="tooltip" data-placement="top"
                            title="Hint : Do not use #?!@$%^&*- and numbers">
                            <i class="fa fa-info" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group showind mb-4">
                        <input type="text" class="form-control onlydigits @error('number') redborder @enderror"
                            placeholder="Contact Number *" name="number" required onkeydown="limit(this, 10);"
                            onkeyup="limit(this, 10);"
                            value="{{isset($post->number) ? $post->number : Request::old('number')}}"
                            pattern="^[0-9]\d{9}$">
                        <span class="infoicos" data-toggle="tooltip" data-placement="top"
                            title="Hint : Do not use +91 or 0 before number">
                            <i class="fa fa-info" aria-hidden="true"></i>
                        </span>
                        @error('number')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group showind mb-4">
                        <input type="text" class="form-control @error('relation') redborder @enderror"
                            placeholder="Relation With Deceased *" name="relation" minlength="3" maxlength="50" required
                            onkeydown="limit(this, 50);" onkeyup="limit(this, 50);"
                            value="{{isset($post->relation) ? $post->relation : Request::old('relation')}}">
                        <span class="infoicos" data-toggle="tooltip" data-placement="top"
                            title="Hint : Do not use #?!@$%^&*- and numbers">
                            <i class="fa fa-info" aria-hidden="true"></i>
                        </span>
                        @error('relation')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>



            <div class=" col-12">
                <div class="form-group form-check mb-4 mt-2">
                    <input id="checkgarland" onchange="flowerSelect()" type="checkbox"
                        class="form-check-input @error('flowers') redborder @enderror" name="flowers"
                        @if(isset($post->flowers) && $post->flowers == 1 || Request::old('flowers')) checked @endif
                    value="1">
                    <label class="form-check-label" for="checkgarland">Do You Want to Customise Image With Garland
                        ?</label>
                    @error('flowers')
                    <div class="rederror">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-12" id="flower_type" @if(isset($post->flowers) && $post->flowers == 1 ||
                Request::old('flowers')) @else style="display:none" @endif>
                <div class="form-group mb-4">
                    <select name="flower_type" id="flowerTypeSelect"
                        class="form-control @error('flower_type') redborder @enderror" @if(isset($post->flowers) &&
                        $post->flowers == 1 || Request::old('flowers')) required @endif>
                        <option value="">Select Garland</option>
                        <option
                            {{ Request::old('flower_type', isset($post) ? $post->flower_type : '') == 'y' ? 'selected' : '' }}
                            value="y">Yellow Garland</option>
                        <option
                            {{ Request::old('flower_type', isset($post) ? $post->flower_type : '') == 'w' ? 'selected' : '' }}
                            value="w">White Garland</option>
                        <option
                            {{ Request::old('flower_type', isset($post) ? $post->flower_type : '') == 'p' ? 'selected' : '' }}
                            value="p">Pink Garland</option>
                    </select>
                    @error('flower_type')
                    <div class="rederror">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class=" col-12">
                <div class="form-group showind mb-4">
                    <textarea style="resize:none;"
                        class="form-control nofocus @error('description') redborder @enderror" name="description"
                        minlength="20" maxlength="250" required id="description" @if(isset($post) &&
                        $post->template_id != 0) Readonly  @endif
                                          onkeydown="limit(this, 250);" onkeyup="limit(this, 250);"
                                          placeholder="Enter message / description (Max 250 character allowed)">{{isset($post->description) ? $post->description : Request::old('description')}}</textarea>
                    @error('description')
                    <div class="rederror">{{ $message }}</div>
                    @enderror
                    <span class="infoicos" data-toggle="tooltip" data-placement="top"
                        title="Hint : Do not use #?!@$%^&*- and numbers">
                        <i class="fa fa-info" aria-hidden="true"></i>
                    </span>
                </div>

                <h4>OR</h4>
                <div class="form-group showind mb-4">
                    <select name="template_id" onchange="getMessage(this.value)" id="messagetemplate"
                        class="form-control @error('template_id') redborder @enderror">
                        <option value="0">Select Template</option>
                        @if(count($templates)>0)
                        @foreach($templates as $template)
                        <option
                            {{ Request::old('template_id', isset($post) ? $post->template_id : '') == $template->id ? 'selected' : '' }}
                            value="{{$template->id}}">{{$template->message}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group mb-4 showind">
                        <div class="pt-2">
                            <!-- If you wish to reference an existing file (i.e. from your database), pass the url into imageData() -->
                            <div x-data="imageData('{{isset($post->death_certificate) ? asset('storage/uploads/'.$post->death_certificate) : Request::old('death_certificate')}}')"
                                class="file-input flex items-center">
                                <!-- Preview Image -->
                                <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                    <!-- Placeholder image -->
                                    <div x-show="!previewPhoto">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <!-- Show a preview of the photo -->
                                    <div x-show="previewPhoto" class="h-12 w-12 rounded-full overflow-hidden">
                                        <img :src="previewPhoto" alt="" class="h-12 w-12 object-cover">
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <!-- File Input -->
                                    <div class="ml-3 rounded-md shadow-sm">
                                        <!-- Replace the file input styles with our own via the label -->
                                        <input @change="updatePreview($refs)" x-ref="input" type="file"
                                            accept="image/*,capture=camera" name="death_certificate" id="photo"
                                            class="custom customfileinput">
                                        <label for="photo" class="@error('death_certificate') redborder @enderror py-2 mb-0 px-3 border border-gray-300 rounded-md text-sm
                                                       leading-4 font-medium text-gray-700 hover:text-indigo-500 hover:border-indigo-300
                                                       focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-gray-50
                                                       active:text-indigo-800 transition duration-150 ease-in-out">
                                            Upload Death Certificate/Doctor's Note (Max : 5MB File size)
                                        </label>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500 mx-2">
                                        <!-- Display the file name when available -->
                                        <span x-text="fileName || emptyText"></span>
                                        <!-- Removes the selected file -->
                                        <button x-show="fileName" @click="clearPreview($refs)" type="button"
                                            aria-label="Remove image" class="mx-1 mt-1">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="x-circle w-4 h-4"
                                                aria-hidden="true" focusable="false">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('death_certificate')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group mb-4 showind">
                        <div class="pt-2">
                            <!-- If you wish to reference an existing file (i.e. from your database), pass the url into imageData() -->
                            <div x-data="imageData('{{isset($post->person_pic) ? asset('storage/uploads/'.$post->person_pic) : Request::old('person_pic')}}')"
                                class="file-input flex items-center">
                                <!-- Preview Image -->
                                <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-100 ">
                                    <!-- Placeholder image -->
                                    <div x-show="!previewPhoto">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <!-- Show a preview of the photo -->
                                    <div x-show="previewPhoto" class="h-12 w-12 rounded-full overflow-hidden">
                                        <img :src="previewPhoto" alt="" class="h-12 w-12 object-cover">
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <!-- File Input -->
                                    <div class="ml-3 rounded-md shadow-sm">
                                        <!-- Replace the file input styles with our own via the label -->
                                        <input @change="updatePreview($refs)" x-ref="input" type="file"
                                            accept="image/*,capture=camera" name="person_pic" id="person_pic"
                                            class="custom customfileinput">
                                        <label for="person_pic" class="@error('person_pic') redborder @enderror py-2 mb-0 px-3 border border-gray-300 rounded-md text-sm
                                                       leading-4 font-medium text-gray-700 hover:text-indigo-500 hover:border-indigo-300
                                                       focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-gray-50
                                                       active:text-indigo-800 transition duration-150 ease-in-out">
                                            Upload Photo (Max : 5MB File size) (Recommended : 6:8 Height:Width)
                                        </label>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500 mx-2">
                                        <!-- Display the file name when available -->
                                        <span x-text="fileName || emptyText"></span>
                                        <!-- Removes the selected file -->
                                        <button x-show="fileName" @click="clearPreview($refs)" type="button"
                                            aria-label="Remove image" class="mx-1 mt-1">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="x-circle w-4 h-4"
                                                aria-hidden="true" focusable="false">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('person_pic')
                        <div class="rederror">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <input value="{{isset($post->is_draft) ? $post->is_draft : Request::old('is_draft')}}" id="is_draft"
                        name="is_draft" type="hidden">
                    <button type="submit" class="signUp1 btn createpost btn postadd"
                        style="margin-right: 10px;">{{isset($post->id) ? 'Update' : 'Create'}} Post</button>
                    <button type="submit" class="signUp1 btn draft createpost btn">Save To Draft</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</section>

@endsection

@section('pagescripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.6.0/alpine.js"></script>

<script>

function getplaceholder(val){ 
    if(val == 'S/O'){
        $("#swdperson").attr('placeholder','Name of Father/Mother')
    }else if(val == 'W/O'){
        $("#swdperson").attr('placeholder','Name of Husband')
    }else if(val == 'D/O'){
        $("#swdperson").attr('placeholder','Name of Father/Mother')
    }else if(val == 'M/O'){
        $("#swdperson").attr('placeholder','Name of Son/Daughter')
    }else if(val == 'F/O'){
        $("#swdperson").attr('placeholder','Name of Son/Daughter')
    }else if(val == 'H/O'){
        $("#swdperson").attr('placeholder','Name of Wife')
    } 
}

$(".draft").click(function() {
    $("#is_draft").val(1);
});
$(".postadd").click(function() {
    $("#is_draft").val(0);
});

function getMessage(val) {
    if (val == 0) {
        $("#description").val(" ");
        $("#description").prop('readonly', false);
    } else {
        var text = $("#messagetemplate option:selected").text();
        $("#description").val(" ");
        $("#description").val(text);
        $("#description").prop('readonly', true);
    }
}

function flowerSelect() {
    if ($("#checkgarland").prop('checked') == true) {
        $("#flowerTypeSelect").attr('required', true);
        $('#flowerTypeSelect').val("");
        $("#flower_type").show();
    } else {
        $("#flowerTypeSelect").attr('required', false);
        $('#flowerTypeSelect').val("");
        $("#flower_type").hide();
    }
}

function imageData(url) {
    const originalUrl = url || '';
    return {
        previewPhoto: originalUrl,
        fileName: null,
        emptyText: originalUrl ? 'No new file chosen' : 'No file chosen',
        updatePreview($refs) {
            var reader,
                files = $refs.input.files;
            reader = new FileReader();
            reader.onload = (e) => {
                this.previewPhoto = e.target.result;
                this.fileName = files[0].name;
            };
            reader.readAsDataURL(files[0]);
        },
        clearPreview($refs) {
            $refs.input.value = null;
            this.previewPhoto = originalUrl;
            this.fileName = false;
        }
    };
}

function autoDetectPickup() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lang = position.coords.longitude;
            var geocoder = new google.maps.Geocoder();

            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: lat,
                    lng: lang
                },
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            var myLatlng = new google.maps.LatLng(lat, lang);

            marker = new google.maps.Marker({
                map: map,
                position: myLatlng,
                draggable: true,
                icon: '{{ asset("website / images / marker.png") }}'
            });

            geocoder.geocode({
                'latLng': marker.getPosition()
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        $('#searchTextField').val(results[0].formatted_address);
                        $('#ulocationlat').val(marker.getPosition().lat());
                        $('#ulocationlong').val(marker.getPosition().lng());
                    }
                }
            });

            google.maps.event.addListener(marker, 'dragend', function() {
                geocoder.geocode({
                    'latLng': marker.getPosition()
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('#searchTextField').val(results[0].formatted_address);
                            $('#ulocationlat').val(marker.getPosition().lat());
                            $('#ulocationlong').val(marker.getPosition().lng());
                        }
                    }
                });
            });

        });
    } else {
        var lat = 26.9124;
        var lang = 75.7873;
        var geocoder = new google.maps.Geocoder();

        var map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: lat,
                lng: lang
            },
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var myLatlng = new google.maps.LatLng(lat, lang);

        marker = new google.maps.Marker({
            map: map,
            position: myLatlng,
            draggable: true,
            icon: 'https://seekho.i4dev.in/public/icons/marker.png'
        });

        google.maps.event.addListener(marker, 'dragend', function() {

            geocoder.geocode({
                'latLng': marker.getPosition()
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        $('#searchTextField').val(results[0].formatted_address);
                        $('#ulocationlat').val(marker.getPosition().lat());
                        $('#ulocationlong').val(marker.getPosition().lng());
                    }
                }
            });
        });

    }
}

$(document).ready(function() {
    var input = document.getElementById('searchTextField');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', function() {

        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("No details available for input: '" + place.name + "'");
            return;
        }
        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');

        };

        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        $('#ulocationlat').val(lat);
        $('#ulocationlong').val(lng);
    });
});
</script>
@endsection