{{ Form::open(array('url' => 'company', 'method' => 'post')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('company_name', __('Nama Perusahaan'), ['class' => 'form-label']) }}
            {{ Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => __('Masukkan Nama Perusahaan')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('contact', __('Nomor HP'), ['class' => 'form-label']) }}
            {{ Form::text('contact', null, ['class' => 'form-control', 'placeholder' => __('Masukkan Nomor Kontak Perusahaan')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
            {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Masukkan Email Perusahaan')]) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{ Form::submit(__('Edit Data'), ['class' => 'btn btn-primary btn-rounded']) }}
</div>
{{ Form::close() }}

