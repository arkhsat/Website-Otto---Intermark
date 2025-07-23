@extends('layouts.app')
@section('page-title')
    {{__('Gate Type')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Gate Type')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
    @if(Gate::check('create gate type'))
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="{{ route('gate-type.create') }}"
           data-title="{{__('Create Gate Type')}}"> <i class="ti-plus mr-5"></i>{{__('Gate Type')}}</a>
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
                            <th>{{__('Gate Type')}}</th>
                            
                            <th>{{__('Notes')}}</th>
                            <th>{{__('Created Date')}}</th>
                            @if(Gate::check('edit gatetype') ||  Gate::check('delete gatetype'))
                                <th class="text-right">{{__('Action')}}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($gatetypes as $gatetype)
                            <tr role="row">
                                <td> {{ $gatetype->gatetype }}   </td>
                               
                                <td>{{ $gatetype->notes }} </td>
                                <td>{{ dateFormat($gatetype->created_at) }} </td>
                                @if(Gate::check('edit gatetype') ||  Gate::check('delete gatetype'))
                                    <td class="text-right">
                                        <div class="cart-action">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['gate-type.destroy', $gatetype->id]]) !!}

                                            @if(Gate::check('edit gatetype') )
                                                <a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="{{__('Edit')}}" data-size="md" href="#"
                                                   data-url="{{ route('gate-type.edit',$type->id) }}"
                                                   data-title="{{__('Edit Gate Type')}}"> <i data-feather="edit"></i></a>
                                            @endcan
                                            @if( Gate::check('delete gatetype'))
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

