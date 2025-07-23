@extends('layouts.app')

@section('page-title')
    {{ __('Report Close ON Transaction') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}"><h1>{{ __('Dashboard') }}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{ __('Report Close ON Transaction') }}</a>
        </li>
    </ul>
@endsection

@section('content')
    <style>
        thead th{
            text-align: center;
            background-color: #f4f4f4;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('report.on') }}" method="GET">
                        <div class="form-group col-md-6">
                            {{ Form::label('entry_date', __('Start Date'), ['class' => 'form-label']) }}
                            {{ Form::date('entry_date', request('entry_date', date('Y-m-d')), ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                            {{ Form::date('end_date', request('end_date', date('Y-m-d')), ['class' => 'form-control']) }}
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="submit">Process</button>
                        </div>
                    </form>

                    @if(!empty($results))
                    <div style="margin-bottom: 10px;">
                        <a href="{{ route('report.on.pdf', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))]) }}" class="btn btn-primary">Download PDF</a>
                        <!-- <a href="{{ route('report.on.excel', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))]) }}" class="btn btn-success">Download Excel</a> -->
                    </div>
                    <table class="display dataTable cell-border">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%;">{{__('ID')}}</th>
                                <th class="text-center" style="width: 5%;">{{__('Transaction No')}}</th>
                                <th class="text-center">{{__('Kendaraan')}}</th>
                                <th class="text-center">{{__('Masuk')}}</th>
                                <th class="text-center">{{__('Close ON')}}</th>
                                <th class="text-center">{{__('Gambar Kendaraan')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $parking)

                            <tr role="row">
                                <td> {{parkingPrefix().$parking->transactionid}}</td>
                                <td> {{$parking->tiketno}}</td>
                                <td> {{$parking->vehicleid}}  </td>
                                <td> {{$parking->datetransact}} </td>
                               
                                <td> {{$parking->dateout}} </td>

                                <td>
                                    @if($parking->posinid == '1')
                                        <a href="{{asset('http://192.168.1.55/sambashare/FotoPMLG/'.$parking->tiketno.'-'.$parking->transactionid.'.jpg')}}" data-lightbox="parking-{{$parking->transactionid}}" data-title="Vehicle Image">
                                            <img src="{{asset('http://192.168.1.55/sambashare/FotoPMLG/'.$parking->tiketno.'-'.$parking->transactionid.'.jpg')}}" 
                                                alt="Vehicle Image" 
                                                style="width: 200px; height: auto; cursor: pointer;"
                                                class="img-thumbnail">
                                        </a>
                                    @elseif($parking->posinid == '2')
                                        <a href="{{asset('http://192.168.1.55/sambashare/FotoPMLoading/'.$parking->tiketno.'-'.$parking->transactionid.'.jpg')}}" data-lightbox="parking-{{$parking->transactionid}}" data-title="Vehicle Image">
                                            <img src="{{asset('http://192.168.1.55/sambashare/FotoPMLoading/'.$parking->tiketno.'-'.$parking->transactionid.'.jpg')}}" 
                                                alt="Vehicle Image" 
                                                style="width: 200px; height: auto; cursor: pointer;"
                                                class="img-thumbnail">
                                        </a>
                                    @elseif($parking->posinid == '3')
                                        <a href="{{asset('http://192.168.1.55/sambashare/FotoPMMotor/'.$parking->tiketno.'-'.$parking->transactionid.'.jpg')}}" data-lightbox="parking-{{$parking->transactionid}}" data-title="Vehicle Image">
                                            <img src="{{asset('http://192.168.1.55/sambashare/FotoPMMotor/'.$parking->tiketno.'-'.$parking->transactionid.'.jpg')}}" 
                                                alt="Vehicle Image" 
                                                style="width: 200px; height: auto; cursor: pointer;"
                                                class="img-thumbnail">
                                        </a>
                                    @else
                                        <span class="badge badge-danger">No Image</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>{{ __('No data available for the selected date range.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

$(document).ready(function() {
    $('.datatbl-advance').DataTable();
});



