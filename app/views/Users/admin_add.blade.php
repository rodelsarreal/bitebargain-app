@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Add Restaurant')
@extends('layouts/adminlayout')
@section('content')
<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
        width:100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .custom-map{
        height: 50%;
        width: 50%;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 100%;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
    </style>
<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>


<script type="text/javascript">

$(document).ready(function () {
    $("#adminAdd").validate();
    $(".chosen-select").chosen();
    $(".chosen-selects").chosen();
    $.validator.addMethod("pass", function (value, element) {
        return  this.optional(element) || (/.{8,}/.test(value) && /([0-9].*[a-z])|([a-z].*[0-9])/.test(value));
    }, "Password minimum length must be 8 characters and contain at least 1 number.");

    $.validator.addMethod("contact", function (value, element) {
        return  this.optional(element) || (/^[0-9-]+$/.test(value));
    }, "Contact Number is not valid.");

    $.validator.addMethod('numbers', function (value, element) {
        return this.optional(element) || /^\d+(\.\d{0,2})?$/.test(value);
    }, "Please enter a correct number, format xxxx.xx");


    $.validator.addMethod('sales_tax',
            function (value) {
                return Number(value) >= 0 && Number(value) <= 100;
            }, 'Entered valid tax.');


    $.validator.addMethod("noSpace", function (value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "No space please and don't leave it empty");



});

function setSathours(val)
{
    var length = val.indexOf(":");
    var new_str = val.substring(0, length);
    if (new_str <= 9) {
        val = new_str + ':00';
    } else {

        val = new_str + ':00';
    }

    var val12 = (parseInt(new_str) + 1) + ':00';
    $("#delivery_hours_end").val(val12);
    $("#delivery_hours_end option").prop("disabled", false);
    $("#delivery_hours_end option[value='" + val + "']").each(function () {

        $(this).parent().each(function () {

            $(this.options).each(function () {
                var val1 = $(this).val();
                var length1 = val1.indexOf(":");
                var new_str1 = val1.substring(0, length1);
                if (parseInt(new_str1) <= parseInt(new_str)) {
                    $(this).prop("disabled", true);
                }
            })
        });
    });
}

function sePickhours(val)
{
    var length = val.indexOf(":");
    var new_str = val.substring(0, length);
    if (new_str <= 9) {
        val = new_str + ':00';
    } else {

        val = new_str + ':00';
    }

    var val12 = (parseInt(new_str) + 1) + ':00';
    $("#pickup_hour_end").val(val12);
    $("#pickup_hour_end option").prop("disabled", false);
    $("#pickup_hour_end option[value='" + val + "']").each(function () {

        $(this).parent().each(function () {

            $(this.options).each(function () {
                var val1 = $(this).val();
                var length1 = val1.indexOf(":");
                var new_str1 = val1.substring(0, length1);
                if (parseInt(new_str1) <= parseInt(new_str)) {
                    $(this).prop("disabled", true);
                }
            })
        });
    });
}
</script>


<script>
    $(document).on('keypress', '.positiveNumber', function (event) {
        // alert('hii');
        var $this = $(this);
        if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
                ((event.which < 48 || event.which > 57) &&
                        (event.which != 0 && event.which != 8))) {
            event.preventDefault();
        }

        var text = $(this).val();
        if ((event.which == 46) && (text.indexOf('.') == -1)) {
            setTimeout(function () {
                if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                    $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
                }
            }, 1);
        }

        if ((text.indexOf('.') != -1) &&
                (text.substring(text.indexOf('.')).length > 2) &&
                (event.which != 0 && event.which != 8) &&
                ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
        }
    });

</script>
<script>
    $(function () {
        $('#select_delivery_type').change(function () {
            var type = $(this).val();
            if (type == 'paid')
                $('#delivery_type').show();
            else
                $('#delivery_type').hide();
            $('#delivery_cost').val('');
        });
    });

</script>
{{ HTML::style('public/css/front/chosen.css'); }}
{{ HTML::script('public/js/front/chosen.jquery.js'); }}
<script src="{{ URL::asset('public/js/bootstrap-inputmask.min.js') }}"></script>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <ul id="breadcrumb" class="breadcrumb">
                    <li>
                        {{ html_entity_decode(HTML::link(HTTP_PATH.'admin/admindashboard', '<i class="fa fa-dashboard"></i> Dashboard', array('id' => ''), true)) }}
                    </li>
                    <li>
                        <i class="fa fa-cutlery"></i> 
                        {{ html_entity_decode(HTML::link(HTTP_PATH.'admin/restaurants/admin_index', "Restaurants", array('id' => ''), true)) }}
                    </li>
                    <li class="active">Add Restaurant</li>
                </ul>

                <section class="panel">

                    <header class="panel-heading">
                        Add Restaurant
                    </header>

                    <div class="panel-body">
                        {{ View::make('elements.actionMessage')->render() }}
                        <span class="require_sign">Please note that all fields that have an asterisk (*) are required. </span>
                        {{ Form::open(array('url' => 'admin/restaurants/admin_add', 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"cmxform form-horizontal tasi-form form",'autocomplete' => 'on')) }}

                        <div class="form-group">
                            {{ HTML::decode(Form::label('first_name', "Restaurant Name <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('first_name', Input::old('first_name'), array('class' => 'required form-control')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ HTML::decode(Form::label('username', "User Name <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('username', Input::old('username'), array('class' => 'required form-control username noSpace')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ HTML::decode(Form::label('password', "Password <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{  Form::password('password',  array('type'=>'password','class' => 'required pass form-control','minlength' => 8, 'maxlength' => '40','id'=>"password"))}}
                                <p class="help-block"> Password minimum length must be 8 characters and contain at least 1 number..</p>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('cpassword', "Confirm Password <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::password('cpassword',  array('type'=>'password','class' => 'required form-control','maxlength' => '40', 'equalTo' => '#password')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ HTML::decode(Form::label('email_address', "Email Address <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('email_address', Input::old('email_address'), array('class' => 'required email form-control')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('phone1', "Phone#1 <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('phone1',Input::old('phone1'), array('class' => 'form-control required','data-mask' => '999-999-9999'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('phone2', "Phone#2",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('phone2',Input::old('phone2'), array('class' => 'form-control','data-mask' => '999-999-9999'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('phone3', "Phone#3",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('phone3',Input::old('phone3'), array('class' => 'form-control','data-mask' => '999-999-9999'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('phone4', "Phone#4",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('phone4',Input::old('phone4'), array('class' => 'form-control','data-mask' => '999-999-9999'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('cell_phone1', "Cell Number#1",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('cell_phone1',Input::old('cell_phone1'), array('class' => 'form-control','data-mask' => '999-999-9999'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('cell_phone2', "Cell Number#2",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('cell_phone2',Input::old('cell_phone2'), array('class' => 'form-control','data-mask' => '999-999-9999'))}}
                            </div>
                        </div>
<div class="form-group">
                            {{ HTML::decode(Form::label('cell_phone3', "Cell Number#3",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('cell_phone3',Input::old('cell_phone3'), array('class' => 'form-control','data-mask' => '999-999-9999'))}}
                            </div>
                        </div>
<div class="form-group">
                            {{ HTML::decode(Form::label('cell_phone4', "Cell Number#4",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('cell_phone4',Input::old('cell_phone4'), array('class' => 'form-control','data-mask' => '999-999-9999'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('fax_number', "Fax Number ",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('fax_number', Input::old('fax_number'), array('class' => 'form-control','maxlength'=>'10','minlength'=>'5'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ HTML::decode(Form::label('address', "Address <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('address',Input::old('address'), array('class' => 'required form-control','id' => 'pac-input','autocomplete' => 'on'))}}
                            </div>
                            <!--<div id="infowindow-content">
                                <img src="" width="16" height="16" id="place-icon">
                                <span id="place-name"  class="title"></span><br>
                                <span id="place-address"></span>
                            </div>-->
                            <div class="custom-map">
                                <div id="map-convas"></div>
                            </div>    
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('city', "City <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('city',Input::old('city'), array('class' => 'required form-control','id' => 'locality'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('state', "State <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('state',Input::old('state'), array('class' => 'required form-control','id' => 'administrative_area_level_1'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('zipcode', "Zipcode <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('zipcode',Input::old('zipcode'), array('class' => 'required form-control','id' => 'postal_code'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ HTML::decode(Form::label('Services Offered', "Services Offered <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                <div class="check_box">
                                    {{ Form::label('Table reservations', "Table reservations ",array('class'=>"control-label col-lg-2")) }}
                                    {{ Form::checkbox('service_offered[]','Table reservations', null, ['class' => 'field required']) }}
                                </div>
                                <div class="check_box">
                                    {{ Form::label('Delivery', "Delivery",array('class'=>"control-label col-lg-2")) }}
                                    {{ Form::checkbox('service_offered[]','Delivery', null, ['class' => 'field required']) }}
                                </div>
                                <div class="check_box">
                                    {{ Form::label('Pickup', "Pickup",array('class'=>"control-label col-lg-2")) }}
                                    {{ Form::checkbox('service_offered[]','Pickup', null, ['class' => 'field required']) }}
                                </div>
                            </div>
                        </div>


                        <div class="form-group ">
                            {{ Html::decode(Form::label('restaurant_cat', "Restaurant Category",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                <?php global $rest_Type; ?>
                                {{Form::select('restaurant_cat[]',$rest_Type,Input::old('restaurant_cat'),array('class'=>'required form-control chosen-select','id'=>'','multiple' => 'multiple'))}}
                            </div>
                        </div>

                        <?php
                        $array_cuisine = array();
                        $cuisines = DB::table('admin_cuisine')
                                ->where('status', 1)
                                ->orderby('name', 'ASC')
                                ->get();

                        foreach ($cuisines as $cuisine) {
                            $array_cuisine[$cuisine->name] = ucwords($cuisine->name);
                        }
                        ?>

                        <div class="form-group ">
                            {{ Html::decode(Form::label('cuisines', "Cuisines <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{Form::select('cuisines[]',$array_cuisine,Input::old('cuisines'),array('class'=>'required form-control chosen-selects','id'=>'','multiple' => 'multiple'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ HTML::decode(Form::label('Payment options', "Payment options <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                <div class="check_box">
                                    {{ Form::label('Cash', "Cash",array('class'=>"control-label col-lg-2")) }}
                                    {{ Form::checkbox('payment_options[]','Cash', null, ['class' => 'field required']) }}
                                </div>
                                <div class="check_box">
                                    {{ Form::label('credit card', "Credit Card",array('class'=>"control-label col-lg-2")) }}
                                    {{ Form::checkbox('payment_options[]','Credit Card', null, ['class' => 'field required']) }}
                                </div>
                                <div class="check_box">
                                    {{ Form::label('paypal', "Paypal",array('class'=>"control-label col-lg-2")) }}
                                    {{ Form::checkbox('payment_options[]','Paypal', null, ['class' => 'field required']) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {{ HTML::decode(Form::label('average_price', "Average Price <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('average_price',Input::old('average_price'), array('class' => 'form-control positiveNumber numbers required')) }} 
                            </div>
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('sales_tax', "Sales Tax (%)",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('sales_tax',Input::old('sales_tax'), array('class' => 'form-control  sales_tax positiveNumber numbers')) }} 
                            </div>
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('parking', "Parking",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                <?php
                                $parking_array = array(
                                    '' => 'Please Select',
                                    'Yes' => 'Yes',
                                    'No' => 'No'
                                );
                                ?>
                                {{ Form::select('parking', $parking_array, Input::old('parking'), array('class' => 'form-control', 'id'=>'city')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ HTML::decode(Form::label('delivery_type', "Delivery Option",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                <?php
                                $payment_array = array(
                                    '' => 'Please Select',
                                    'free' => 'free',
                                    'paid' => 'paid'
                                );
                                ?>
                                {{ Form::select('delivery_type', $payment_array, Input::old('delivery_type'), array('class' => 'form-control', 'id'=>'select_delivery_type')) }}
                            </div>
                        </div>

                        <div class="form-group" id="delivery_type" style="display:none;">
                            {{ HTML::decode(Form::label('delivery_cost', "Delivery Cost",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('delivery_cost',Input::old('delivery_cost'), array('class' => 'form-control')) }} 
                            </div>
                        </div>

                        <div class="form-group">
                            {{ HTML::decode(Form::label('estimated_time', "Estimated Delivery Time(Min or Hours) ",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('estimated_time',Input::old('estimated_time'), array('class' => 'form-control')) }} 
                            </div>
                        </div>

                        <div class="form-group">
                            {{ HTML::decode(Form::label('minimum_order', "Minimum Order Amount",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('minimum_order',Input::old('minimum_order'), array('class' => 'positiveNumber form-control','maxlength'=>'16'))}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ HTML::decode(Form::label('description', "Description",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::textarea('description',Input::old('description'), array('class' => 'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{  Form::label('profile_image', 'Profile Image',array('class'=>"control-label col-lg-2")) }}
                            <div class="col-lg-10">
                                {{ Form::file('profile_image'); }}
                                <p class="help-block">Supported File Types: gif, jpg, jpeg, png. Max size 2MB.</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                {{ Form::submit('Save', array('class' => "btn btn-danger",'onclick' => 'return imageValidation();')) }}
                                {{ Form::button('Reset', array('class'=>"btn btn-default" ,'id' => 'clear')) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </section>
            </div>

        </div>
    </section>
</section>

{{ HTML::style('public/js/chosen/chosen.css'); }}
<!--scripts page-->
{{ HTML::script('public/js/chosen/chosen.jquery.js'); }}
<script type="text/javascript">
    $(".chzn-select").chosen();
</script>

<script>
	$('#clear').click(function(){
        $(".chosen-select").val('').trigger("chosen:updated");
	 location.reload();
});
    function in_array(needle, haystack) {
        for (var i = 0, j = haystack.length; i < j; i++) {
            if (needle == haystack[i])
                return true;
        }
        return false;
    }

    function getExt(filename) {
        var dot_pos = filename.lastIndexOf(".");
        if (dot_pos == -1)
            return "";
        return filename.substr(dot_pos + 1).toLowerCase();
    }



    function imageValidation() {

        var filename = document.getElementById("profile_image").value;

        var filetype = ['jpeg', 'png', 'jpg', 'gif'];
        if (filename != '') {
            var ext = getExt(filename);
            ext = ext.toLowerCase();
            var checktype = in_array(ext, filetype);
            if (!checktype) {
                alert(ext + " file not allowed for Profile Image.");
                document.getElementById("profile_image").value = "";
                return false;
            } else {
                var fi = document.getElementById('profile_image');
                var filesize = fi.files[0].size;
                if (filesize > 2097152) {
                    alert('Maximum 2MB file size allowed for Profile Image.');
                    document.getElementById("profile_image").value = "";
                    return false;
                }
            }
        }
        return true;
    }

</script>
<script>
    $(function(){
        initMap();
    });
    //Google map get location using current location and using search address
    function initMap() {


        var marker = '';
        var map = new google.maps.Map(document.getElementById('map-convas'), {
            center: {lat: -33.8688, lng: 151.2195},
            zoom: 13
        });





        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);
       
        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(
                ['address_components', 'geometry', 'icon', 'name']);
        var geocoder = new google.maps.Geocoder();
        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });


        //get currnet location and set marker
        navigator.geolocation.getCurrentPosition(function (position, marker) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            
            infowindow.setPosition(pos);
             //geocodeLatLng(geocoder, map, infowindow);
            //infowindow.setContent('Location found.');
            //infowindow.open(map,marker);
            map.setCenter(pos);
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                map: map
            });
        });

        var componentForm = {
               // sublocality_level_1: 'short_name',
                //street_number: 'long_name',
                //route: 'long_name',
                locality: 'long_name',
                administrative_area_level_1: 'long_name',
                //country: 'long_name',
                postal_code: 'long_name'
              };
        autocomplete.addListener('place_changed', function (event) {
            infowindow.close();
            //marker.setMap(null);
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                  var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
              }
            
//            document.getElementById('pac-input').value = place.name;
            
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
         
            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindowContent.children['place-icon'].src = place.icon;
            infowindowContent.children['place-name'].textContent = place.name;
            infowindowContent.children['place-address'].textContent = address;
            infowindow.open(map, marker);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
//        function setupClickListener(id, types) {
//            var radioButton = document.getElementById(id);
//            radioButton.addEventListener('click', function () {
//                autocomplete.setTypes(types);
//            });
//        }

//        setupClickListener('changetype-all', []);
//        setupClickListener('changetype-address', ['address']);
//        setupClickListener('changetype-establishment', ['establishment']);
//        setupClickListener('changetype-geocode', ['geocode']);
//
//        document.getElementById('use-strict-bounds')
//                .addEventListener('click', function () {
//                    console.log('Checkbox clicked! New state=' + this.checked);
//                    autocomplete.setOptions({strictBounds: this.checked});
//                });
    }
    function geocodeLatLng(geocoder, map, infowindow) {
//        var input = document.getElementById('latlng').value;
//        var latlngStr = input.split(',', 2);
        var latlng = {lat: infowindow.position.lat(), lng: infowindow.position.lng()};
        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              map.setZoom(11);
              var marker = new google.maps.Marker({
                position: latlng,
                map: map
              });
              infowindow.setContent(results[0].formatted_address);
              document.getElementById('pac-input').value = results[0].formatted_address;
              
              infowindow.open(map, marker);
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
      }
</script>


@stop
