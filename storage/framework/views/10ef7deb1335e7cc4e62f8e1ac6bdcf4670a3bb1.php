<?php echo e(Form::model($company, ['route' => ['company.update', $company->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('company_name', __('Nama Perusahaan'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => __('Masukkan Nama Perusahaan')])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('contact', __('Nomor HP'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('contact', null, ['class' => 'form-control', 'placeholder' => __('Masukkan Nomor Kontak Perusahaan')])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('email', __('Email'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Masukkan Email Perusahaan')])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Simpan Perubahan'), ['class' => 'btn btn-primary btn-rounded'])); ?>

</div>
<?php echo e(Form::close()); ?>


<?php /**PATH E:\website-otto\resources\views/company/edit.blade.php ENDPATH**/ ?>