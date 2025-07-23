@extends('layouts.app')
@section('page-title')
    {{__('Gate')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Gate')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
@if(Gate::check('create gate'))
<a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
   data-url="{{ route('gate.create') }}"
   data-title="{{__('Create Gate')}}"> <i class="ti-plus mr-5"></i>{{__('Create Gate')}}</a>
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
                            <th>{{__('Gate No')}}</th>
                            <th>{{__('Gate Name')}}</th>
                            <th>{{__('Gate Type')}}</th>
                            <th>{{__('Parking Zone')}}</th>
                            <th class="text-right">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($gates as $gate)
                            <tr>
                                <td>{{ ucfirst($gate->gateno) }} </td>
                                <td>{{\Auth::user()->roleWiseUserCount($gate->gatename)}}</td>
                                <td>{{ ucfirst($gate->gate_type) }} </td>
                                <td> {{ !empty($gate->zones)?$gate->zones->zone_name:'-' }}   </td>
                                @if(Gate::check('edit gate') ||  Gate::check('delete gate'))
                                    <td class="text-right">
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['gate.destroy', $gate->id]]) !!}

                                            @if(Gate::check('edit gate') )
                                                <a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Edit')}}" data-size="md" href="#"
                                                   data-url="{{ route('gate.edit',$floor->id) }}"
                                                   data-title="{{__('Edit Gate')}}"> <i data-feather="edit"></i></a>
                                            @endcan
                                            @if( Gate::check('delete gate'))
                                                <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Delete')}}" href="#"> <i
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

