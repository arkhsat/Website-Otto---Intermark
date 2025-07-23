@extends('layouts.app')
@section('page-title')
    {{__('Parking Slot')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Parking Slot')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if(Gate::check('create parking slot'))
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="{{ route('parking-slot.create') }}"
           data-title="{{__('Create Parking Slot')}}"> <i class="ti-plus mr-5"></i>{{__('Create Parking Slot')}}</a>
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
                            <th>{{__('Vehicle Type')}}</th>
                            <th>{{__('Parking Floor')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Notes')}}</th>
                            @if(Gate::check('edit parking slot') ||  Gate::check('delete parking slot'))
                                <th class="text-right">{{__('Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($slots as $slot)

                            <tr role="row">
                                <td>{{$slot->title}}</td>
                                <td> {{ !empty($slot->zones)?$slot->zones->zone_name:'-' }}   </td>
                                <td> {{ !empty($slot->types)?$slot->types->title:'-' }}   </td>
                                <td> {{ !empty($slot->floors)?$slot->floors->title:'-' }}   </td>
                                <td>
                                    @if($slot->is_available==1)
                                        <span class="badge badge-success">{{__('Available')}}</span>
                                    @else
                                        <span class="badge badge-danger">{{__('Occupied')}}</span>
                                    @endif
                                </td>
                                <td>{{ $slot->notes }} </td>
                                @if(Gate::check('edit parking slot') ||  Gate::check('delete parking slot'))
                                    <td class="text-right">
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['parking-slot.destroy', $slot->id]]) !!}

                                            @if(Gate::check('edit parking slot') )
                                                <a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Edit')}}" data-size="lg" href="#"
                                                   data-url="{{ route('parking-slot.edit',$slot->id) }}"
                                                   data-title="{{__('Edit Parking Slot')}}"> <i data-feather="edit"></i></a>
                                            @endcan
                                            @if( Gate::check('delete parking slot'))
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

