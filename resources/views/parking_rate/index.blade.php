@extends('layouts.app')
@section('page-title')
    {{__('Parking Rate')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Parking Rate')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if(Gate::check('create parking rate'))
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="{{ route('parking-rate.create') }}"
           data-title="{{__('Create Parking Rate')}}"> <i class="ti-plus mr-5"></i>{{__('Create Parking Rate')}}</a>
    @endif
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                        <tr>
                            <th>{{__('Vehicle Type')}}</th>
                            <th>{{__('Parking Zone')}}</th>
                            <th>{{__('Start Date')}}</th>
                            <th>{{__('Due Date')}}</th>
                            <th>{{__('Fixed Rate')}}</th>
                            <th>{{__('Hourly Rate')}}</th>
                            @if(Gate::check('edit parking rate') ||  Gate::check('delete parking rate'))
                                <th class="text-right">{{__('Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rates as $rate)

                            <tr role="row">
                                <td> {{ !empty($rate->types)?$rate->types->title:'-' }}   </td>
                                <td> {{ !empty($rate->zones)?$rate->zones->zone_name:'-' }}   </td>
                                <td>
                                    {{ dateFormat($rate->start_date) }}
                                </td>
                                <td>
                                    {{ dateFormat($rate->due_date) }}
                                </td>
                                <td>{{ priceFormat($rate->fix_rate) }} </td>
                                <td>{{ priceFormat($rate->hourly_rate) }} </td>
                                @if(Gate::check('edit parking rate') ||  Gate::check('delete parking rate'))
                                    <td class="text-right">
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['parking-rate.destroy', $rate->id]]) !!}

                                            @if(Gate::check('edit parking rate') )
                                                <a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Edit')}}" data-size="lg" href="#"
                                                   data-url="{{ route('parking-rate.edit',$rate->id) }}"
                                                   data-title="{{__('Edit Parking Rate')}}"> <i data-feather="edit"></i></a>
                                            @endcan
                                            @if( Gate::check('delete parking rate'))
                                                <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Detete')}}" href="#"> <i
                                                        data-feather="trash-2"></i></a>
                                            @endcan
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

