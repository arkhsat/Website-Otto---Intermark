@extends('layouts.app')
@section('page-title')
    {{__('Parking')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('ON Parking')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                        <tr>
                            <th>{{__('ID')}}</th>
                            <th>{{__('Transaction No')}}</th>
                            <th>{{__('Type')}}</th>
                           
                            <th>{{__('Entry')}}</th>
                            <th>{{__('Exit')}}</th>
                            <th>{{__('Duration')}}</th>
                            
                            <th>{{__('Cost')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Payment By')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($parkings as $parking)

                            <tr role="row">
                                <td> {{parkingPrefix().$parking->transactionid}}</td>
                                <td> {{$parking->tiketno}}</td>
                                <td> {{$parking->vehicleid}}  </td>
                                <td> {{$parking->datetransact}} </td>
                                <td> {{$parking->dateout}} </td>
                                <td> {{$parking->duration}} </td>
                                <td>{{number_format($parking->cost, 0, '.', ',')}}</td>
                                
                               
                                <td>
                                    @if($parking->alreadyout=='x')
                                        <span class="badge badge-danger">Filled</span>
                                    @else
                                        <span class="badge badge-success">Out</span>
                                    @endif
                                </td>
                                <td>
                                    @if($parking->paymentby!= NULL)
                                        <span class="badge badge-danger">{{$parking->paymentby}}</span>
                                    @else
                                        <span class="badge badge-success">{{$parking->paymentby}}</span>
                                    @endif
                                </td>
                              
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

