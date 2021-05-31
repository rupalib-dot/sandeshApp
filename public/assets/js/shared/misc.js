var ChartColor = ["#5D62B4", "#54C3BE", "#EF726F", "#F9C446", "rgb(93.0, 98.0, 180.0)", "#21B7EC", "#04BCCC"];
var primaryColor = getComputedStyle(document.body).getPropertyValue('--primary');
var secondaryColor = getComputedStyle(document.body).getPropertyValue('--secondary');
var successColor = getComputedStyle(document.body).getPropertyValue('--success');
var warningColor = getComputedStyle(document.body).getPropertyValue('--warning');
var dangerColor = getComputedStyle(document.body).getPropertyValue('--danger');
var infoColor = getComputedStyle(document.body).getPropertyValue('--info');
var darkColor = getComputedStyle(document.body).getPropertyValue('--dark');
var lightColor = getComputedStyle(document.body).getPropertyValue('--light');
(function ($) {
  'use strict';
  $(function () {
    var body = $('body');
    var contentWrapper = $('.content-wrapper');
    var scroller = $('.container-scroller');
    var footer = $('.footer');
    var sidebar = $('#sidebar');

    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required
    if (!$('#sidebar').hasClass("dynamic-active-class-disabled")) {
      var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
      $('#sidebar >.nav > li:not(.not-navigation-link) a').each(function () {
        var $this = $(this);
        if (current === "") {
          //for root url
          if ($this.attr('href').indexOf("index.html") !== -1) {
            $(this).parents('.nav-item').last().addClass('active');
            if ($(this).parents('.sub-menu').length) {
              $(this).addClass('active');
            }
          }
        } else {
          //for other url
          if ($this.attr('href').indexOf(current) !== -1) {
            $(this).parents('.nav-item').last().addClass('active');
            if ($(this).parents('.sub-menu').length) {
              $(this).addClass('active');
            }
            if (current !== "index.html") {
              $(this).parents('.nav-item').last().find(".nav-link").attr("aria-expanded", "true");
              if ($(this).parents('.sub-menu').length) {
                $(this).closest('.collapse').addClass('show');
              }
            }
          }
        }
      })
    }

    //Close other submenu in sidebar on opening any
    $("#sidebar > .nav > .nav-item > a[data-toggle='collapse']").on("click", function () {
      $("#sidebar > .nav > .nav-item").find('.collapse.show').collapse('hide');
    });

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

  });
  $('.dropdown-toggle').dropdown()

    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    $(".hide500").delay(5000).fadeOut(800);

    $('.datatableinit').DataTable( );
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
