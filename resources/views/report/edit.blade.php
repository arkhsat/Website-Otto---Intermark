{{Form::model($parkingZone, array('route' => array('parking-zone.update', $parkingZone->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{Form::label('zone_name',__('Zone Name'),array('class'=>'form-label'))}}
            {{Form::text('zone_name',null,array('class'=>'form-control','placeholder'=>__('Enter parking zone name')))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('notes',__('Note'),array('class'=>'form-label'))}}
            {{Form::textarea('notes',null,array('class'=>'form-control','placeholder'=>__('Enter notes'),'rows'=>3))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('Close')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary btn-rounded'))}}
</div>
{{ Form::close() }}




