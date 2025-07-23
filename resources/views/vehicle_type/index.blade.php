@extends('layouts.app')
@section('page-title')
    {{__('Vehicle Type')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Vehicle Type')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if(Gate::check('create vehicle type'))
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('vehicle-type.create') }}"
           data-title="{{__('Create Vehicle Type')}}"> <i class="ti-plus mr-5"></i>{{__('Create Type')}}</a>
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
                            <th>{{__('Title')}}</th>
                            <th>{{__('Parking Zone')}}</th>
                            <th>{{__('Notes')}}</th>
                            <th>{{__('Created Date')}}</th>
                            @if(Gate::check('edit vehicle type') ||  Gate::check('delete vehicle type'))
                                <th class="text-right">{{__('Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($types as $type)
                            <tr role="row">
                                <td> {{ $type->title }}   </td>
                                <td> {{ !empty($type->zones)?$type->zones->zone_name:'-' }}   </td>
                                <td>{{ $type->notes }} </td>
                                <td>{{ dateFormat($type->created_at) }} </td>
                                @if(Gate::check('edit vehicle type') ||  Gate::check('delete vehicle type'))
                                    <td class="text-right">
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['vehicle-type.destroy', $type->id]]) !!}

                                            @if(Gate::check('edit vehicle type') )
                                                <a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Edit')}}" data-size="md" href="#"
                                                   data-url="{{ route('vehicle-type.edit',$type->id) }}"
                                                   data-title="{{__('Edit Vehicle Type')}}"> <i data-feather="edit"></i></a>
                                            @endcan
                                            @if( Gate::check('delete vehicle type'))
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

