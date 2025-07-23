{{Form::model($parkingRate, array('route' => array('parking-rate.update', $parkingRate->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{Form::label('zone',__('Parking Zone'),array('class'=>'form-label'))}}
            {{Form::select('zone',$zones,null,array('class'=>'form-control hidesearch','id'=>'zone_id'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('vehicle_type',__('Vehicle Type'),array('class'=>'form-label'))}}
            <div class="vehicle_type_dive">
                <select class="form-control hidesearch vehicle_type" id="vehicle_type" name="vehicle_type">
                    <option value="">{{__('Select Vehicle Type')}}</option>
                </select>
            </div>
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('start_date',__('Start Date'),array('class'=>'form-label'))}}
            {{Form::date('start_date',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('due_date',__('Due Date'),array('class'=>'form-label'))}}
            {{Form::date('due_date',null,array('class'=>'form-control'))}}
        </div>

        <div class="form-group  col-md-6">
            {{Form::label('fix_rate',__('Fixed Rate'),array('class'=>'form-label'))}}
            {{Form::number('fix_rate',null,array('class'=>'form-control','placeholder'=>__('Enter fixed rate')))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('hourly_rate',__('Hourly Rate'),array('class'=>'form-label'))}}
            {{Form::number('hourly_rate',null,array('class'=>'form-control','placeholder'=>__('Enter fixed rate')))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('notes',__('Notes'),array('class'=>'form-label'))}}
            {{Form::textarea('notes',null,array('class'=>'form-control','placeholder'=>__('Enter notes'),'rows'=>3))}}
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
                var vehicle_type = `<select class="form-control hidesearch vehicle_type" id="vehicle_type" name="vehicle_type"></select>`;
                $('.vehicle_type_div').html(vehicle_type);

                $.each(data, function (key, value) {
                    $('.vehicle_type').append('<option value="' + key + '">' + value + '</option>');
                });

            },

        });
    });
    $('#zone_id').trigger('change');
</script>







