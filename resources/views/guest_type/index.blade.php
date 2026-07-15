@extends('layouts.app')
@section('page-title')
    {{__('Guest Type')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Guest Type')}}</a>
        </li>
    </ul>
@endsection
@section('card-action-btn')
<a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
   data-url="{{ route('setting.guest-types.create') }}"
   data-title="{{__('Create Guest Type')}}"> <i class="ti-plus mr-5"></i>{{__('Create Guest Type')}}
</a>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                            <tr>
                            <th>{{__('No')}}</th>
                            <th>{{__('Guest Type')}}</th>
                            <th>{{__('Edit')}}</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($types as $type)
                            <tr role="row">
                                <td>{{ $loop->iteration }}</td>
                                <td> {{ ucfirst($type->type)}}  </td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ route('setting.guest-types.edit', $type->id)}}">
                                        <i class="ti-pencil"></i>
                                    </a>
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

