@extends('layouts.app')

@section('page-title')
    {{ __('Data Perusahaan') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}"><h1>{{ __('Dashboard') }}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{ __('Data Perusahaan') }}</a>
        </li>
    </ul>
@endsection

@section('card-action-btn')
    @if(Gate::check('create rfid vehicle'))
       
           <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="{{ route('company.create') }}"
           data-title="{{__('Tambahkan Perusahaan')}}"> <i class="ti-plus mr-5"></i>{{__('Tambahkan Perusahaan')}}</a>
    @endif
@endsection
@section('content')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(!empty($results) && count($results) > 0)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>{{__('No')}}</th>
                                    <th>{{__('Nama Perusahaan')}}</th>
                                    <th>{{__('Kontak')}}</th>
                                    <th>{{__('Email')}}</th>
                                    <th>{{__('Aksi')}}</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $index => $result)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $result->company_name }}</td>
                                        <td>{{ $result->contact }}</td>
                                        <td>{{ $result->email }}</td>
                                        <td class="text-right">
                                        <div class="cart-action">   
                                            <a class="btn btn-primary customModal" data-bs-toggle="tooltip"
                                                        data-bs-original-title="{{__('Edit')}}" data-size="lg" href="#"
                                                        data-url="{{ route('company.edit',$result->id) }}"
                                                        data-title="{{__('Edit Company Data')}}">Edit</a>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center text-muted">{{ __('No data available for the selected date range.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
