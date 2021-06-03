@extends('website.app')

@section('title', 'Home Page')

@section('content')
    <section id="postWall" class="postWall" role="post wall"
             style="background: url({{ asset('website/images/backimg2.png') }}) no-repeat center;
                 background-size: cover;">
        <div class="container">
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
            <form action="{{route('showpublicpost')}}" method="get">
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-12">
                        <div class="form-group mb-4 showind">
                            <input id="searchTextField filter" style="width: 104%;padding: 22px;margin-top: .5px;" type="text" class="form-control @error('address') redborder @enderror"
                                    onkeydown="limit(this, 250);" onkeyup="limit(this, 250);"
                                    placeholder="Location *" name="address" value="{{old('address',$request->address)}}" >
                            <span class="infoicos" onclick="autoDetectPickup()"><i class="fa fa-location-arrow" aria-hidden="true"></i></span> 
                            <div id="map" style="height:600px;display:none;"> </div> 
                        </div> 
                    </div> 
                    <div class="col-md-2 col-sm-2 col-12 pr-0">
                        <div class="form-group mb-4 showind">
                            <input id="searchTextField filter" style="width: 104%;padding: 22px;margin-top: .5px;" type="date" class="form-control @error('address') redborder @enderror"
                                    placeholder="Date *" name="date" value="{{old('date',$request->date)}}" > 
                        </div> 
                    </div>
                    <div class="col-md-2 col-sm-2 col-12 pl-0"> 
                        <button style="margin-top:0px" type="submit" class="signUp1 btn createpost btn">Filter</button>  
                    </div>
                </div> 
            </form>
            <div class="row">
                @if(count($publicpost) >0)
                    @foreach($publicpost as $post)
                        <div class="col-md-6 pb-4">
                            <div class="sandeshBox2 bg-white" >
                                <div class="d-flex">
                                    <div class="imghodl flowerss @if($post->flowers) @if($post->flower_type == 'w') whiteflowersss @elseif($post->flower_type == 'p') pinkflowersss @else  flowersss @endif @endif"
                                         style=" background: url({{  isset($post->person_pic) ?
                                                                    asset('storage/uploads/'.$post->person_pic) :
                                                                    asset('website/images/profile-placeholder.jpg') }}) no-repeat center;
                                             background-size:cover;
                                             min-width: 150px;
                                             min-height: 190px;
                                             width: 150px;
                                             height: 190px;
                                             position: relative;
                                             margin-bottom: 30px;">
                                    </div>
                                    <div class="sandeshpara">
                                        <h6>{{ date('d-m-Y', strtotime($post->date_of_death)) }} </h6>
                                        <p class="text-bold">{{ $post->person_name }}</p>
                                        <p class="sub-add"> {{ $post->description }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4>No Posts Found </h4>
                @endif
            </div>
        </div>
    </section>
    <section id="paginationPage">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="paginationPara">
                        {{ $publicpost->links('website.defaultpagination') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection

@section('pagescripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.6.0/alpine.js"></script>

    <script>
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

        function autoDetectPickup(){
            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat=position.coords.latitude;
                    var lang=position.coords.longitude;
                    var geocoder = new google.maps.Geocoder();

                    var map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: lat, lng: lang},
                        zoom: 13,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                    var myLatlng = new google.maps.LatLng(lat,lang);

                    marker = new google.maps.Marker({
                        map: map,
                        position: myLatlng,
                        draggable: true,
                        icon:'{{ asset('website/images/marker.png') }}'
                    });

                    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                $('#searchTextField').val(results[0].formatted_address);
                                $('#ulocationlat').val(marker.getPosition().lat());
                                $('#ulocationlong').val(marker.getPosition().lng());
                            }
                        }
                    });

                    google.maps.event.addListener(marker, 'dragend', function() {
                        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
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
            }else{
                var lat=26.9124;
                var lang=75.7873;
                var geocoder = new google.maps.Geocoder();

                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: lat, lng: lang},
                    zoom: 13,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                var myLatlng = new google.maps.LatLng(lat,lang);

                marker = new google.maps.Marker({
                    map: map,
                    position: myLatlng,
                    draggable: true,
                    icon:'https://seekho.i4dev.in/public/icons/marker.png'
                });

                google.maps.event.addListener(marker, 'dragend', function() {

                    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
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

                }
                ;

                var lat= place.geometry.location.lat();
                var lng= place.geometry.location.lng();
                $('#ulocationlat').val(lat);
                $('#ulocationlong').val(lng);
            });
        });
    </script>
@endsection
    