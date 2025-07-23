@extends('layouts.app')
@section('page-title')
    {{__('Parking Zone')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Parking Zone')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if(Gate::check('create parking zone'))
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('parking-zone.create') }}"
           data-title="{{__('Create Zone')}}"> <i class="ti-plus mr-5"></i>{{__('Create Zone')}}</a>
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
                            <th>{{__('Zone Name')}}</th>
                            <th>{{__('Notes')}}</th>
                            <th>{{__('Created Date')}}</th>
                            @if(Gate::check('edit parking zone') ||  Gate::check('delete parking zone'))
                                <th class="text-right">{{__('Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($zones as $zone)
                            <tr role="row">
                                <td> {{ $zone->zone_name }}   </td>
                                <td>{{ $zone->notes }} </td>
                                <td>{{ dateFormat($zone->created_at) }} </td>
                                @if(Gate::check('edit parking zone') ||  Gate::check('delete parking zone'))
                                    <td class="text-right">
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['parking-zone.destroy', $zone->id]]) !!}

                                            @if(Gate::check('edit parking zone') )
                                                <a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Edit')}}" data-size="md" href="#"
                                                   data-url="{{ route('parking-zone.edit',$zone->id) }}"
                                                   data-title="{{__('Edit Zone')}}"> <i data-feather="edit"></i></a>
                                            @endcan
                                            @if( Gate::check('delete parking zone'))
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

