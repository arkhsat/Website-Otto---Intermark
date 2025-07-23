{{Form::model($rfidVehicle, array('route' => array('rfid-vehicle.extend_store', $rfidVehicle->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-6">
            {{Form::label('name',__('Name'),array('class'=>'form-label'))}}
            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter name')))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('phone_number',__('Phone Number'),array('class'=>'form-label'))}}
            {{Form::text('phone_number',null,array('class'=>'form-control','placeholder'=>__('Enter phone number')))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('zone',__('Parking Zone'),array('class'=>'form-label'))}}
            {{Form::select('zone',$zones,null,array('class'=>'form-control hidesearch','id'=>'zone_id'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('vehicle_type',__('Vehicle Type'),array('class'=>'form-label'))}}
            <input type="hidden" id="edit_type" value="{{$rfidVehicle->type}}">
            <div class="vehicle_type_dive">
                <select class="form-control hidesearch vehicle_type" id="vehicle_type" name="type">
                    <option value="">{{__('Select Vehicle Type')}}</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-6">
            {{Form::label('floor',__('Floor'),array('class'=>'form-label'))}}
            <input type="hidden" id="edit_floor" value="{{$rfidVehicle->floor}}">
            <div class="floor_dive">
                <select class="form-control hidesearch floor" id="floor_id" name="floor">
                    <option value="">{{__('Select Floor')}}</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-6">
            {{Form::label('slot',__('Slot'),array('class'=>'form-label'))}}
            <input type="hidden" id="edit_slot" value="{{$rfidVehicle->slot}}">
            <div class="slot_dive">
                <select class="form-control hidesearch slot" id="slot" name="slot">
                    @foreach($slots as $k=>$slot)
                        <option value="{{$k}}" {{$k==$rfidVehicle->slot?'selected':''}}>{{$slot}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('vehicle_no',__('Vehicle Number'),array('class'=>'form-label'))}}
            {{Form::text('vehicle_no',null,array('class'=>'form-control','placeholder'=>__('Enter vehicle number')))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('rfid_no',__('RFID Number'),array('class'=>'form-label'))}}
            {{Form::text('rfid_no',null,array('class'=>'form-control','placeholder'=>__('Enter RFID number')))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('notes',__('Notes'),array('class'=>'form-label'))}}
            {{Form::textarea('notes',null,array('class'=>'form-control','placeholder'=>__('Enter notes'),'rows'=>2))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary btn-rounded'))}}
</div>
{{ Form::close() }}
<script>

    $('#zone_id').on('change', function () {
        "use strict";
        var zone_id = $(this).val();
        var url = '{{ route("zone.type", ":id") }}';
        url = url.replace(':id', zone_id);
        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                zone_id: zone_id,
            },
            contentType: false,
            processData: false,
            type: 'GET',
            success: function (data) {
                $('.vehicle_type').empty();
                var vehicle_type = `<select class="form-control hidesearch vehicle_type" id="vehicle_type" name="type"></select>`;
                $('.vehicle_type_div').html(vehicle_type);

                $.each(data, function (key, value) {
                    var edit_type_id = $('#edit_type').val();
                    if (key == edit_type_id) {
                        $('.vehicle_type').append('<option selected value="' + key + '">' + value + '</option>');
                    } else {
                        $('.vehicle_type').append('<option value="' + key + '">' + value + '</option>');
                    }
                });

            },

        });
    });

    $('#zone_id').on('change', function () {
        "use strict";
        var zone_id = $(this).val();
        var url = '{{ route("zone.floor", ":id") }}';
        url = url.replace(':id', zone_id);
        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                zone_id: zone_id,
            },
            contentType: false,
            processData: false,
            type: 'GET',
            success: function (data) {
                $('.floor').empty();
                var floor = `<select class="form-control hidesearch floor" id="floor_id" name="floor"><option value="">Select Floor</option></select>`;
                $('.floor').html(floor);

                $.each(data, function (key, value) {
                    var edit_floor_id = $('#edit_floor').val();
                    if (key == edit_floor_id) {
                        $('.floor').append('<option selected value="' + key + '">' + value + '</option>');
                    } else {
                        $('.floor').append('<option value="' + key + '">' + value + '</option>');
                    }

                });

            },

        });
    });

    $('#floor_id').on('change', function () {
        "use strict";
        var floor_id = $(this).val();
        var zone_id = $('#zone_id').val();
        var type_id = $('#vehicle_type').val();

        var url = '{{ route("zone.floor.slot", [":floor_id",":zone_id",":type_id"]) }}';
        url = url.replace(':floor_id', floor_id);
        url = url.replace(':zone_id', zone_id);
        url = url.replace(':type_id', type_id);
        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {

            },
            contentType: false,
            processData: false,
            type: 'GET',
            success: function (data) {
                $('.slot').empty();
                var slot = `<select class="form-control hidesearch slot" id="slot" name="slot"></select>`;
                $('.slot_div').html(slot);

                $.each(data, function (key, value) {
                    var edit_slot_id= $('#edit_slot').val();
                    if(key==edit_slot_id){
                        $('.slot').append('<option selected value="' + key + '">' + value +'</option>');
                    }else{
                        $('.slot').append('<option value="' + key + '">' + value + '</option>');
                    }
                });

            },

        });
    });
    $('#zone_id').trigger('change');

</script>

