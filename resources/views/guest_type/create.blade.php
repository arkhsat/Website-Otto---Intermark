{{Form::open(array('route' => 'setting.guest-types.store','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{Form::label('type','Guest Type')}}
            {{Form::text('type', null, ['class'=>'form-control', 'placeholder'=>'Enter Guest Type'])}}
        </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary btn-rounded'))}}
</div>
{{ Form::close() }}


