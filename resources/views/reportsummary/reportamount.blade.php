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
            <a href="#">{{ __('Report Summary Amount') }}</a>
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
                    <form action="{{ route('report.summary.amount') }}" method="GET">
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
                        <a href="{{ route('report.summary.amount.pdf', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))]) }}" class="btn btn-primary">Download PDF</a>
                        <a href="{{ route('report.summary.amount.excel', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))]) }}" class="btn btn-success">Download Excel</a>
                    </div>
                    <table class="display dataTable cell-border">
                        <thead>
                            <tr style="height: 16.0pt;">
                                <th class="xl66" style="height: 32.0pt; width: 65pt;" rowspan="2" width="87" height="42">No</th>
                                <th class="xl66" style="width: 100pt;" rowspan="2" width="87">Nomor</th>
                                <th class="xl65" style="width: 80pt;" colspan="2" width="174">Mandiri</th>
                                <th class="xl65" style="width: 80pt;" colspan="2" width="174">BCA</th>
                                <th class="xl65" style="width: 80pt;" colspan="2" width="174">BNI</th>
                                <th class="xl65" style="width: 80pt;" colspan="2" width="174">BRI</th>
                                <th class="xl65" style="width: 80pt;" colspan="2" width="174">QRIS</th>
                                <th class="xl65" style="width: 80pt;" rowspan="2" width="174">Total</th>
                            </tr>
                            <tr style="height: 16.0pt;">
                                <th style="height: 16.0pt;" height="21">Mobil</th>
                                <th>Motor</th>
                                <th>Mobil</th>
                                <th>Motor</th>
                                <th>Mobil</th>
                                <th>Motor</th>
                                <th>Mobil</th>
                                <th>Motor</th>
                                <th>Mobil</th>
                                <th>Motor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $index => $result)
                                <tr role="row">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $result->date }}</td>
                                    <td style="text-align: center">Rp {{ number_format($result->Mandiri_Mobil) }}</td>
                                    <td style="text-align: center">Rp {{ number_format($result->Mandiri_Motor) }}</td>
                                    <td style="text-align: center">Rp {{ number_format($result->BCA_Mobil) }}</td>
                                    <td style="text-align: center">Rp {{ number_format($result->BCA_Motor) }}</td>
                                    <td style="text-align: center">Rp {{ number_format($result->BNI_Mobil) }}</td>
                                    <td style="text-align: center">Rp {{ number_format($result->BNI_Motor) }}</td>
                                    <td style="text-align: center">Rp {{ number_format($result->BRI_Mobil) }}</td>
                                    <td style="text-align: center">Rp {{ number_format($result->BRI_Motor) }}</td>
                                    <td style="text-align: center">Rp {{ number_format($result->QRIS_Mobil) }}</td>
                                    <td style="text-align: center">Rp {{ number_format($result->QRIS_Motor) }}</td>
                                    <td style="text-align: center">Rp {{ number_format($result->total) }}</td>
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

$(document).ready(function() {
    $('.datatbl-advance').DataTable();
});



