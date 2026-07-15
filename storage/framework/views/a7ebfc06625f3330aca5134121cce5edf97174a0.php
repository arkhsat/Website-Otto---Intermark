<?php echo e(Form::open(array('route' => 'setting.guest-types.store','method'=>'post'))); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            <?php echo e(Form::label('type','Guest Type')); ?>

            <?php echo e(Form::text('type', null, ['class'=>'form-control', 'placeholder'=>'Enter Guest Type'])); ?>

        </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Create'),array('class'=>'btn btn-primary btn-rounded'))); ?>

</div>
<?php echo e(Form::close()); ?>



<?php /**PATH D:\laragon\www\Intermark\resources\views/guest_type/create.blade.php ENDPATH**/ ?>