<?php echo e(Form::model($parkingSlot, array('route' => array('parking-slot.update', $parkingSlot->id), 'method' => 'PUT'))); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-6">
            <?php echo e(Form::label('title',__('Title'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter title')))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('zone',__('Parking Zone'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::select('zone',$zones,null,array('class'=>'form-control hidesearch','id'=>'zone_id'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('vehicle_type',__('Vehicle Type'),array('class'=>'form-label'))); ?>

            <div class="vehicle_type_dive">
                <select class="form-control hidesearch vehicle_type" id="vehicle_type" name="type">
                    <option value=""><?php echo e(__('Select Vehicle Type')); ?></option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('floor',__('Floor'),array('class'=>'form-label'))); ?>

            <div class="floor_dive">
                <select class="form-control hidesearch floor" id="floor" name="floor">
                    <option value=""><?php echo e(__('Select Floor')); ?></option>
                </select>
            </div>
        </div>
        <div class="form-group  col-md-12">
            <?php echo e(Form::label('notes',__('Notes'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::textarea('notes',null,array('class'=>'form-control','placeholder'=>__('Enter notes'),'rows'=>2))); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Update'),array('class'=>'btn btn-primary btn-rounded'))); ?>

</div>
<?php echo e(Form::close()); ?>

<script>
    $('#zone_id').on('change', function () {
        "use strict";
        var zone_id = $(this).val();
        var url = '<?php echo e(route("zone.type", ":id")); ?>';
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
        var url = '<?php echo e(route("zone.floor", ":id")); ?>';
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
                var floor = `<select class="form-control hidesearch floor" id="floor" name="floor"></select>`;
                $('.floor_div').html(floor);

                $.each(data, function (key, value) {
                    $('.floor').append('<option value="' + key + '">' + value + '</option>');
                });

            },

        });
    });
    $('#zone_id').trigger('change');
</script>
<?php /**PATH E:\Kerja\parkingsystem\parkingsystem\resources\views/parking_slot/edit.blade.php ENDPATH**/ ?>