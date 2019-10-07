@extends('layouts.app')
@section('page_css')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery-ui-timepicker-addon.css') }}">
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<style>
    #map_wrapper { height: 620px; }
    #map_canvas { width: 100%; height: 100%; }
</style>
@endsection

@section('content')
<div class="main-content">
    <div class="container-fluid">
        <!-- PROFILE DETAIL -->
            <div class="row">
                <div class="col-md-12">

                    @include('alerts.alert')
                </div>
            </div>

            <div class="panel panel-headline requirements-table">
                <div class="panel-heading">
                    <h3 class="panel-title">Map</h3>
                </div>

                <div class="panel-body">
                    

                    <div id="map_wrapper">
                        <div id="map_canvas" class="mapping"></div>
                    </div>

                </div>
            </div>
    </div>
</div>

@endsection

@section('page_js')

<script src="{{ asset('assets/scripts/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/scripts/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/scripts/jquery-ui-timepicker-addon.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=GoogleAPIKey&sensor=false" type="text/javascript"></script>

<script type="text/javascript">

var address = '{{ $property_lat_lng }}'  //property address enter here
var locations = $.parseJSON(address.replace(/&quot;/g,'"'));

var map = new google.maps.Map(document.getElementById('map_canvas'), {
  zoom: 13,
  center: new google.maps.LatLng(  51.50772318197178 , -0.12797699290740816 ),
  mapTypeId: google.maps.MapTypeId.ROADMAP
});

var infowindow = new google.maps.InfoWindow();

var marker, i;

for (i = 0; i < locations.length; i++) {  

  marker = new google.maps.Marker({
    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
    map: map
  });

  google.maps.event.addListener(marker, 'click', (function(marker, i) {
    return function() {
      infowindow.setContent(locations[i][0]);
      infowindow.open(map, marker);
    }
  })(marker, i));
}

var applicant = '{{ $cricle_count_maker }}' // applicant details marker
var applicantall = $.parseJSON(applicant.replace(/&quot;/g,'"'));

var infowindow1 = new google.maps.InfoWindow();

var marker, i;
 
for (i = 0; i < applicantall.length; i++) {  

  marker = new google.maps.Marker({
    position: new google.maps.LatLng(applicantall[i][1], applicantall[i][2]),
    //position: new google.maps.LatLng(circle.getCenter().applicantall[i][1], circle.getBounds().getNorthEast().applicantall[i][2]),
    map: map
  });

  // Add circle overlay and bind to marker
  var circle = new google.maps.Circle({
    map: map,
    radius: 3170.56, //0.5 miles in metres
    fillColor: '#AA0000'
  });
  circle.bindTo('center', marker, 'position');

  marker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png') // you can enter different type of markers

  google.maps.event.addListener(marker, 'click', (function(marker, i) {
    return function() {
      infowindow1.setContent(applicantall[i][0]);
      infowindow1.open(map, marker);
    }
  })(marker, i));
}
</script>
@endsection
