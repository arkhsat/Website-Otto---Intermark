@extends('layouts.app')
@section('page-title')
    {{parkingPrefix().$parking->parking_id}}{{__('Details')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('parking.index')}}">{{__('Parking')}}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{parkingPrefix().$parking->parking_id}} {{__('Details')}}</a>
        </li>
    </ul>
@endsection
@push('script-page')
    <script>
        $(document).on('click', '.print', function () {
            var printContents = document.getElementById('invoice-print').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;

        });
    </script>
@endpush
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
@section('card-action-btn')
    <a class="btn btn-warning customModal me-2" href="javascript:void(0);" data-url="{{ route('parking.thermal.print',$parking->id) }}"  data-title=" {{$settings['company_name']}}" data-ajax-popup="true" data-size="sm"><i class="fa fa-print"></i> {{__('Thermal Receipt')}}</a>
    <a class="btn btn-secondary print" href="javascript:void(0);"><i class="fa fa-print"></i> {{__('Print Receipt')}}</a>
    @if(Gate::check('show parking') && $parking->status==0)
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('parking.exit.vehicle',[$parking->id,$payment]) }}"
           data-title="{{__('Exit Vehicle')}}"><i class="fa fa-automobile"></i> {{__('Exit Vehicle')}}</a>
    @endif
@endsection
@section('content')
    <div class="row" id="invoice-print">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body cdx-invoice">
                    <div id="cdx-invoice">
                        <div class="head-invoice">
                            <div class="codex-brand">
                                <a class="codexbrand-logo" href="Javascript:void(0);">
                                    <img class="img-fluid" src="{{asset(Storage::url('upload/logo/')).'/'.(isset($settings['company_logo']) && !empty($settings['company_logo'])?$settings['company_logo']:'logo.png')}}" alt="invoice-logo">
                                </a>
                                <a class="codexdark-logo" href="Javascript:void(0);">
                                    <img class="img-fluid" src="{{asset(Storage::url('upload/logo/')).'/'.(isset($settings['company_logo']) && !empty($settings['company_logo'])?$settings['company_logo']:'logo.png')}}" alt="invoice-logo">
                                </a>
                            </div>
                            <ul class="contact-list">
                                <li>
                                    <div class="icon-wrap"><i class="fa fa-user"></i></div>
                                    {{$settings['company_name']}}
                                </li>
                                <li>
                                    <div class="icon-wrap"><i class="fa fa-phone"></i></div>
                                    {{$settings['company_email']}}
                                </li>
                                <li>
                                    <div class="icon-wrap"><i class="fa fa-envelope"></i></div>
                                    {{$settings['company_phone']}}
                                </li>

                            </ul>
                        </div>
                        <div class="invoice-user">
                            <div class="left-user">
                                <h5>{{__('Receipt To')}}:</h5>
                                <ul class="detail-list">
                                    <li>
                                        <div class="icon-wrap"><i class="fa fa-user"></i></div>
                                        {{$parking->name}}
                                    </li>
                                    <li>
                                        <div class="icon-wrap"><i class="fa fa-phone"></i></div>
                                        {{$parking->phone_number}}
                                    </li>

                                </ul>
                            </div>
                            <div class="right-user">
                                <ul class="detail-list">
                                    <li>{{__('Receipt Date')}}: <span> {{dateFormat(date('Y-m-d'))}}</span></li>
                                    <li>{{__('Parking ID')}}: <span>{{parkingPrefix().$parking->parking_id}}</span></li>
                                    <li>{{__('Entry')}}: <span>{{dateFormat($parking->entry_date)}} - {{timeFormat($parking->entry_time)}}</span></li>
                                    <li>{{__('Exit')}}:
                                        <span>
                                         @if(!empty($parking->exit_date))
                                                {{ dateFormat($parking->exit_date) }} <br>
                                                {{ timeFormat($parking->exit_time) }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="body-invoice">
                            <div class="table-responsive1">
                                <table class="table ml-1">
                                    <thead>
                                    <tr>
                                        <th>{{__('Parking Zone')}}</th>
                                        <th>{{ !empty($parking->zones)?$parking->zones->zone_name:'-' }} </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{__('Vehicle Type')}}</td>
                                        <td>{{ !empty($parking->types)?$parking->types->title:'-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Vehicle Number')}}</td>
                                        <td>{{$parking->vehicle_number}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Parking Slot')}}</td>
                                        <td>{{ !empty($parking->slots)?$parking->slots->title:'-' }} </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Floor')}}</td>
                                        <td>{{ !empty($parking->floors)?$parking->floors->title:'-' }} </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Payment Status')}}</td>
                                        <td>
                                            @if($parking->payment_status==0)
                                                <span class="badge badge-danger">{{\App\Models\Parking::$paymentStatus[$parking->payment_status]}}</span>
                                            @else
                                                <span class="badge badge-success">{{\App\Models\Parking::$paymentStatus[$parking->payment_status]}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Parking Status')}}</td>
                                        <td>
                                            @if($parking->status==0)
                                                <span class="badge badge-danger">{{\App\Models\Parking::$status[$parking->status]}}</span>
                                            @else
                                                <span class="badge badge-success">{{\App\Models\Parking::$status[$parking->status]}}</span>
                                            @endif
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="footer-invoice">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>{{__('Parked Duration')}}</td>
                                    <td>{{$parkedDuration}} {{__('hour')}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('Total Payment')}}</td>
                                    <td>{{priceFormat($payment)}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

