{{Form::open(array('url'=>'hotel','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{Form::label('room_no',__('Room No'),array('class'=>'form-label'))}}
            {{Form::text('room_no',null,array('class'=>'form-control','placeholder'=>__('Enter Room No')))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('guest_name',__('Guest Name'),array('class'=>'form-label'))}}
            {{Form::text('guest_name',null,array('class'=>'form-control','placeholder'=>__('Enter Guest Name')))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('uidno',__('UID No'),array('class'=>'form-label'))}}
            {{Form::text('uidno',null,array('class'=>'form-control','placeholder'=>__('Enter UID Card No')))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('plat_no',__('Plat No'),array('class'=>'form-label'))}}
            {{Form::text('plat_no',null,array('class'=>'form-control','placeholder'=>__('Enter Plat No')))}}
        </div>
        
        <div class="form-group  col-md-6">
            {{Form::label('entry_date',__('Check In'),array('class'=>'form-label'))}}
            {{Form::date('check_in',date('Y-m-d'),array('class'=>'form-control'))}}
        </div>
        <div class="form-group  col-md-6">
            {{Form::label('entry_date',__('Check Out'),array('class'=>'form-label'))}}
            {{Form::date('check_out',date('Y-m-d'),array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('status',__('status'),array('class'=>'form-label'))}}
            {{Form::text('status',null,array('class'=>'form-control','placeholder'=>__('Enter status')))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('notes',__('Notes'),array('class'=>'form-label'))}}
            {{Form::textarea('notes',null,array('class'=>'form-control','placeholder'=>__('Enter notes'),'rows'=>3))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary btn-rounded'))}}
</div>
{{ Form::close() }}


