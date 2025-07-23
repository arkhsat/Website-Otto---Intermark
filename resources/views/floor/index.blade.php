@extends('layouts.app')
@section('page-title')
    {{__('Floor')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Floor')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if(Gate::check('create floor'))
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('floor.create') }}"
           data-title="{{__('Create Floor')}}"> <i class="ti-plus mr-5"></i>{{__('Create Floor')}}</a>
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
                            <th>{{__('Floor Level')}}</th>
                            <th>{{__('Notes')}}</th>
                            <th>{{__('Created Date')}}</th>
                            @if(Gate::check('edit floor') ||  Gate::check('delete floor'))
                                <th class="text-right">{{__('Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($floors as $floor)
                            <tr role="row">
                                <td> {{ $floor->title }}   </td>
                                <td> {{ !empty($floor->zones)?$floor->zones->zone_name:'-' }}   </td>
                                <td>{{ $floor->floor_level }} </td>
                                <td>{{ $floor->notes }} </td>
                                <td>{{ dateFormat($floor->created_at) }} </td>
                                @if(Gate::check('edit floor') ||  Gate::check('delete floor'))
                                    <td class="text-right">
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['floor.destroy', $floor->id]]) !!}

                                            @if(Gate::check('edit floor') )
                                                <a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Edit')}}" data-size="md" href="#"
                                                   data-url="{{ route('floor.edit',$floor->id) }}"
                                                   data-title="{{__('Edit Floor')}}"> <i data-feather="edit"></i></a>
                                            @endcan
                                            @if( Gate::check('delete floor'))
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

