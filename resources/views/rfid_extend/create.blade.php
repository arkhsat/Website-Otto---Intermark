{{Form::open(array('url'=>'rfid-vehicle','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{Form::label('rfid',__('RFID'),array('class'=>'form-label'))}}
            {{Form::select('rfid_no',$members,null,array('class'=>'form-control hidesearch','id'=>'member_id'))}}
        </div>
        
       
        <div class="form-group  col-md-6">
            {{Form::label('start_date',__('Start Date'),array('class'=>'form-label'))}}
            {{Form::date('start_date',date('Y-m-d'),array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('end_date',__('End Date'),array('class'=>'form-label'))}}
            {{Form::date('end_date',date('Y-m-d'),array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('notes',__('Notes'),array('class'=>'form-label'))}}
            {{Form::textarea('notes',null,array('class'=>'form-control','placeholder'=>__('Enter notes'),'rows'=>2))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary btn-rounded'))}}
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
                    $('.vehicle_type').append('<option value="' + key + '">' + value + '</option>');
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
                var floor = `<select class="form-control hidesearch floor" id="floor_id" name="floor"> <option value="">Select Floor</option></select>`;
                $('.floor').html(floor);

                $.each(data, function (key, value) {
                    $('.floor').append('<option value="' + key + '">' + value + '</option>');
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
                zone_id: zone_id,
                type_id: type_id,
            },
            contentType: false,
            processData: false,
            type: 'GET',
            success: function (data) {
                $('.slot').empty();
                var slot = `<select class="form-control hidesearch slot" id="slot" name="slot"></select>`;
                $('.slot_div').html(slot);

                $.each(data, function (key, value) {
                    $('.slot').append('<option value="' + key + '">' + value + '</option>');
                });

            },

        });
    });
</script>
