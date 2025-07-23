@extends('layouts.app')

@section('page-title')
    {{ __('Parking Tanda Terima') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}"><h1>{{ __('Dashboard') }}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{ __('Tanda Terima Member') }}</a>
        </li>
    </ul>
@endsection

@section('content')
    <style>
        thead th{
            text-align: center;
            background-color: #f4f4f4;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tanda.terima.view') }}" method="GET">
                        <div class="row g-3 align-items-end">
                            
                          
                            <div class="col-md-4">
                                <select name="vehicle_no[]" class="form-control select2" multiple data-placeholder="Pilih No Polisi">
    @foreach($companyList as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
</select>

                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-secondary" type="submit">Process</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection




