@extends('layouts.app')

@section('page-title')
    {{ __('Parking Report Amount') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}"><h1>{{ __('Dashboard') }}</h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{ __('Report Edit Data Member') }}</a>
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
                    <form action="{{ route('reportmember.nonpayment') }}" method="GET">
                        <div class="form-group col-md-6">
                            {{ Form::label('entry_date', __('Start Date'), ['class' => 'form-label']) }}
                            {{ Form::date('entry_date', request('entry_date', date('Y-m-d')), ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                            {{ Form::date('end_date', request('end_date', date('Y-m-d')), ['class' => 'form-control']) }}
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="submit">Process</button>
                        </div>
                    </form>

                    @if(!empty($results))
                    <div style="margin-bottom: 10px;">
                        <a href="{{ route('reportmember.nonpayment.pdf', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))]) }}" class="btn btn-primary">Download PDF</a>
                        <a href="{{ route('reportmember.nonpayment.excel', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))]) }}" class="btn btn-success">Download Excel</a>
                    </div>

                    <table id="data" class="display dataTable cell-border">
                        <thead>
                            <thead>
                                <td class="xl66" style="height: 32.0pt; width: 65pt;">No</td>
                                <td class="xl66" style="width: 65pt;">Tanggal Edit</td>
                                <td class="xl65" style="width: 130pt;">Nama</td>
                                <td class="xl65" style="width: 130pt;">Perusahaan</td>
                                <td class="xl65" style="width: 130pt;">Plat Kendaraan</td>
                                <td class="xl65" style="width: 130pt;">Jenis Kendaraan</td>
                                <td class="xl65" style="width: 130pt;">Data Sebelum</td>
                                <td class="xl65" style="width: 130pt;">Data Sesudah</td>
                                <td class="xl65" style="width: 130pt;">Keterangan</td>
                                {{-- <td class="xl65" style="width: 130pt;">Biaya</td> --}}
                        </thead>
                        <tbody>
                            @foreach($results as $index => $result)
                                <tr role="row">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $result->tanggal }}</td>
                                    <td>{{ $result->nama}}</td>
                                    <td>{{ $result->perusahaan }}</td>
                                    <td>{{ $result->nopol }}</td>
                                    <td>{{ $result->jenis_kendaraan }}</td>
                                    <td>{{ $result->data_sebelum }}</td>
                                    <td>{{ $result->data_update }}</td>
                                    <td>{{ $result->keterangan }}</td>
                                    {{-- <td>Rp {{ number_format($result->biaya, 0, ',', '.') }}</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>{{ __('No data available for the selected date range.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection