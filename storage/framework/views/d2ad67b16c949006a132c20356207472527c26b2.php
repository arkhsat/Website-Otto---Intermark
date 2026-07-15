

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Guest Type')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>">
                <h1><?php echo e(__('Dashboard')); ?></h1>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('setting.guest-types')); ?>">
                <?php echo e(__('Guest Type')); ?>

            </a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Edit')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4><?php echo e(__('Edit Guest Type')); ?></h4>
            </div>

            <div class="card-body">

                <?php echo e(Form::model($type, [
                    'route' => ['setting.guest-types.update', $type->id],
                    'method' => 'PUT'
                ])); ?>


                <div class="form-group">
                    <?php echo e(Form::label('type', __('Guest Type'), ['class' => 'form-label'])); ?>


                    <?php echo e(Form::text('type', null, [
                        'class' => 'form-control',
                        'placeholder' => __('Enter Guest Type'),
                        'required'
                    ])); ?>

                </div>

                <div class="form-group mt-20 text-end">
                    <?php echo e(Form::submit(__('Update'), ['class' => 'btn btn-primary btn-rounded'])); ?>

                </div>

                <?php echo e(Form::close()); ?>


            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\Intermark\resources\views/guest_type/edit.blade.php ENDPATH**/ ?>