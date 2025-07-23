{{Form::open(array('route'=>array('exit.vehicle.store',$parking_id),'method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-12">
            {{Form::label('exit_date',__('Exit Date'),array('class'=>'form-label'))}}
            {{Form::date('exit_date',date('Y-m-d'),array('class'=>'form-control','readonly'))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('exit_time',__('Exit Time'),array('class'=>'form-label'))}}
            {{Form::time('exit_time',date('H:i'),array('class'=>'form-control','readonly'))}}
        </div>
        <div class="form-group  col-md-12">
            {{Form::label('amount',__('Amount'),array('class'=>'form-label'))}}
            {{Form::number('amount',round($amount),array('class'=>'form-control'))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{Form::submit(__('Done'),array('class'=>'btn btn-primary btn-rounded'))}}
</div>
