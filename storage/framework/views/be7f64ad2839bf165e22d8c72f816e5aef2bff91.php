<?php echo e(Form::open(array('url'=>'hotel','method'=>'post'))); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            <?php echo e(Form::label('room_no',__('Room No'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::text('room_no',null,array('class'=>'form-control','placeholder'=>__('Enter Room No')))); ?>

        </div>
        <div class="form-group  col-md-12">
            <?php echo e(Form::label('guest_name',__('Guest Name'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::text('guest_name',null,array('class'=>'form-control','placeholder'=>__('Enter Guest Name')))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('uidno',__('UID No'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::text('uidno',null,array('class'=>'form-control','placeholder'=>__('Enter UID Card No'), 'required'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('plat_no',__('Plat No'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::text('plat_no',null,array('class'=>'form-control','placeholder'=>__('Enter Plat No')))); ?>

        </div>
        
        <div class="form-group  col-md-6">
            <?php echo e(Form::label('entry_date',__('Check In'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::date('check_in',date('Y-m-d'),array('class'=>'form-control'))); ?>

        </div>
        <div class="form-group  col-md-6">
            <?php echo e(Form::label('entry_date',__('Check Out'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::date('check_out',date('Y-m-d'),array('class'=>'form-control'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('type',__('Type Of Guest'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::select('type', $hotelTypes, null, array('class'=>'form-control','placeholder'=>__('Choose Type Customer'), 'required'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('status',__('status'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::text('status',null,array('class'=>'form-control','placeholder'=>__('Enter status')))); ?>

        </div>
        <div class="form-group  col-md-12">
            <?php echo e(Form::label('notes',__('Notes'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::textarea('notes',null,array('class'=>'form-control','placeholder'=>__('Enter notes'),'rows'=>3))); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Create'),array('class'=>'btn btn-primary btn-rounded'))); ?>

</div>
<?php echo e(Form::close()); ?>



<?php /**PATH D:\laragon\www\Intermark\resources\views/hotel/create.blade.php ENDPATH**/ ?>