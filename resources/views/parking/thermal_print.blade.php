@php
    if(!empty($parking->exit_date) && !empty($parking->exit_time)){
        $endDate=$parking->exit_date;
        $endTime=$parking->exit_time;
    }else{
         $endDate= date('Y-m-d');
        $endTime =date('H:s:i');
    }
    $parkedDuration=timeCalculation($parking->entry_date,$parking->entry_time,$endDate,$endTime);
    $payment=\App\Models\Parking::paymentCalculation($parking->id,$parkedDuration);

@endphp
<div class="pt-0 pb-3 modal-body pos-module" id="thermal_print">
    <table class="table pos-module-tbl">
        <tbody>
        <div class="row text-end">
            <div class="text-left mt-10">
                {{$settings['company_name']}}<br>
                {{$settings['company_phone'] }}<br>
                {{$settings['company_email'] }}<br>
            </div>
        </div>

        <div class="invoice-to mt-2 product-border">
            <b>{{__('Receipt To')}} :</b>
        </div>
        <div>
            {{$parking->name}}
        </div>
        <div>
            {{$parking->phone_number}}
        </div>

        </tbody>
    </table>

    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Parking ID') }}:</div>
            <div class="text-end ms-auto">   <b> {{parkingPrefix().$parking->parking_id}}</b></div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Receipt Date') }}:</div>
            <div class="text-end ms-auto">{{dateFormat(date('Y-m-d'))}}</div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Entry') }}:</div>
            <div class="text-end ms-auto">{{dateFormat($parking->entry_date)}} - {{timeFormat($parking->entry_time)}}</div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Exit') }}:</div>
            <div class="text-end ms-auto">
                @if(!empty($parking->exit_date))
                    {{ dateFormat($parking->exit_date) }} <br>
                    {{ timeFormat($parking->exit_time) }}
                @else
                    -
                @endif
            </div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Parking Zone') }}:</div>
            <div class="text-end ms-auto">{{ !empty($parking->zones)?$parking->zones->zone_name:'-' }}</div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Vehicle Type') }}:</div>
            <div class="text-end ms-auto">{{ !empty($parking->types)?$parking->types->title:'-' }}</div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Vehicle Number') }}:</div>
            <div class="text-end ms-auto">{{$parking->vehicle_number}}</div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Parking Slot') }}:</div>
            <div class="text-end ms-auto">{{ !empty($parking->slots)?$parking->slots->title:'-' }}</div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Floor') }}:</div>
            <div class="text-end ms-auto">{{ !empty($parking->floors)?$parking->floors->title:'-' }} </div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Payment Status') }}:</div>
            <div class="text-end ms-auto">
                @if($parking->payment_status==0)
                    <span class="badge badge-danger">{{\App\Models\Parking::$paymentStatus[$parking->payment_status]}}</span>
                @else
                    <span class="badge badge-success">{{\App\Models\Parking::$paymentStatus[$parking->payment_status]}}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Parking Status') }}:</div>
            <div class="text-end ms-auto">
                @if($parking->status==0)
                    <span class="badge badge-danger">{{\App\Models\Parking::$status[$parking->status]}}</span>
                @else
                    <span class="badge badge-success">{{\App\Models\Parking::$status[$parking->status]}}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Parked Duration') }}:</div>
            <div class="text-end ms-auto"><b>{{$parkedDuration}} {{__('hour')}} </b></div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Total Payment') }}:</div>
            <div class="text-end ms-auto"><b>{{priceFormat($payment)}}</b> </div>
        </div>
    </div>

</div>

<div class=" mt-2 modal-footer text-end">
    <a href="#"  class="btn btn-primary btn-sm text-right float-right mb-3 print-btn">
        {{ __('Print') }}
    </a>
</div>
<script>
    $(".print-btn").click(function () {
        document.getElementById("thermal_print");
        $('.themebody-wrap').addClass('d-none');
        $('.codex-header').addClass('d-none');
        $('.codex-sidebar').addClass('d-none');
        $('.codex-footer').addClass('d-none');
        $('.customizer-action bg-primary').addClass('d-none');
        $('.modal-footer').addClass('d-none');
        window.print();
        $('.themebody-wrap').removeClass('d-none');
        $('.codex-header').removeClass('d-none');
        $('.codex-sidebar').removeClass('d-none');
        $('.codex-footer').removeClass('d-none');
        $('.customizer-action bg-primary').removeClass('d-none');
        $('.modal-footer').removeClass('d-none');
        $('#customModal').modal('hide')
    });
</script>




