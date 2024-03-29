 (function ($) {

    // Max date to today
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();

    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;
    $('.datepkr').attr('max', maxDate);


    // Toggle Password Icon
    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        console.log(input);
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    // Hide Message of Session
    $(".hide500").delay(5000).fadeOut(800);

    $('[data-toggle="tooltip"]').tooltip();

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
        // console.log(event.detail.errors);
        // console.log(event.detail.errors[0].offsetTop);
        window.scrollTo(0, event.detail.errors[0].offsetTop);
    }, false);

    document.addEventListener('bouncerFormValid', function () {
        // alert('Form submitted successfully!');
        // window.location.reload();
    }, false);



})(jQuery);

 function limit(element, max_chars)
 {
     if(element.value.length > max_chars) {
         element.value = element.value.substr(0, max_chars);
     }
 }
 // Prevent Form submit on enter key
 $('form input').on('keypress', function(e) {
     return e.which !== 13;
 });

 // Restricts input for each element in the set of matched elements to the given inputFilter.
 (function($) {
     $.fn.inputFilter = function(inputFilter) {
         return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
             if (inputFilter(this.value)) {
                 this.oldValue = this.value;
                 this.oldSelectionStart = this.selectionStart;
                 this.oldSelectionEnd = this.selectionEnd;
             } else if (this.hasOwnProperty("oldValue")) {
                 this.value = this.oldValue;
                 this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
             } else {
                 this.value = "";
             }
         });
     };
 }(jQuery));

 // Install input filters.
 $(".onlydigits").inputFilter(function(value) {
     return /^-?\d*$/.test(value); });
 $(".onlychar").inputFilter(function(value) {
     return /^[a-z]*$/i.test(value); });

 // // Install input filters.
 // $("#intTextBox").inputFilter(function(value) {
 //     return /^-?\d*$/.test(value); });
 // $("#uintTextBox").inputFilter(function(value) {
 //     return /^\d*$/.test(value); });
 // $("#intLimitTextBox").inputFilter(function(value) {
 //     return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500); });
 // $("#floatTextBox").inputFilter(function(value) {
 //     return /^-?\d*[.,]?\d*$/.test(value); });
 // $("#currencyTextBox").inputFilter(function(value) {
 //     return /^-?\d*[.,]?\d{0,2}$/.test(value); });
 // $("#latinTextBox").inputFilter(function(value) {
 //     return /^[a-z]*$/i.test(value); });
 // $("#hexTextBox").inputFilter(function(value) {
 //     return /^[0-9a-f]*$/i.test(value); });

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
     var siteurl = window.location.origin;
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
                 icon: siteurl+'/website/images/marker.png'
         });

             geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                 if (status == google.maps.GeocoderStatus.OK) {
                     if (results[0]) {
                         console.log(results[0]);
                         $('#searchTextField').val(results[0].formatted_address);
                         $('#ulocationlat').val(marker.getPosition().lat());
                         $('#ulocationlong').val(marker.getPosition().lng());
                     }
                 }
             });

             google.maps.event.addListener(marker, 'dragend', function() {
                 //console.log(marker.getPosition());
                 geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                     if (status == google.maps.GeocoderStatus.OK) {
                         if (results[0]) {
                             console.log(results[0]);
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
 $(document).ready(function (){
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

 $(".adharinput").inputmask({"mask": "9999 9999 9999"});
