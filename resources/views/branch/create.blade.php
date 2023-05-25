    {{Form::open(array('url'=>'branch','method'=>'post'))}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('employee_id',__('Branch Manager'))}}
                {{Form::select('employee_id',$employees,null,array('class'=>'form-control ','id'=>'employee_id','placeholder'=>__('Select Employee')))}}
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                {{Form::label('name_ar',__('Name_ar'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
                {{Form::text('name_ar',null,array('class'=>'form-control','placeholder'=>__('Enter Branch Name arabic')))}}
                @error('name_ar')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class' => 'd-flex align-items-center fs-6 fw-semibold mb-2'])}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Branch Name')))}}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="timezone">{{__('company_map_location')}}</label>
                {{Form::hidden('lat','24.7305650',array('class'=>'form-control' , 'id' => 'lat'))}}
                {{Form::hidden('lon','46.6555170',array('class'=>'form-control' , 'id' => 'lon'))}}
                <div style="width: 100%;height: 300px;" id="map"></div>
            </div>
        </div>

        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
            <input type="button" value="{{__('Cancel')}}" class="btn btn-white" data-bs-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_foD6VvulHSpxKYjtgehkQ_UoVGHH64Y&callback=initMap&libraries=places,geometry"></script>
    <script>
        function initMap() {
                var latlng = new google.maps.LatLng(document.getElementById("lat").value, document.getElementById("lon").value);
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: latlng,
                    zoom: 10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    title: 'Set lat/lon values for this property',
                    draggable: true
                });

                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                        var pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        map.setCenter(pos);
                        marker.setPosition(pos);
                        document.getElementById("lat").value = pos.lat;
                        document.getElementById("lon").value = pos.lng;
                        }, function() {
                        handleLocationError(true, map.getCenter());
                        });
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, map.getCenter());
                }

                google.maps.event.addListener(marker, 'dragend', function(a) {
                document.getElementById("lat").value = a.latLng.lat().toFixed(6);
                document.getElementById("lon").value = a.latLng.lng().toFixed(6);
                });
        };
    </script>
