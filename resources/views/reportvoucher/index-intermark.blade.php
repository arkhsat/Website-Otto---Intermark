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
            <a href="#">{{ __('Report Transaksi Voucher') }}</a>
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
                    <form id="hotel-report-form" action="{{ route('report.voucher.intermark.data') }}" method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-2">
                                {{ Form::label('entry_date', __('Start Date'), ['class' => 'form-label']) }}
                                {{ Form::date('entry_date', request('entry_date', date('Y-m-d')), ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-2">
                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                {{ Form::date('end_date', request('end_date', date('Y-m-d')), ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-secondary" type="submit">Process</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <h4 style="text-align: center;">{{$reportname}}</h4>
                    @if(!empty($results))
                        <div style="margin-bottom: 10px;">
                            <br>

                            {{-- PDF --}}
                            <a href="{{ route('report.voucher.intermark.pdf', [
                                'entry_date' => request('entry_date'),
                                'end_date' => request('end_date'),
                                'voucher_type' => $voucherType
                            ]) }}"
                            class="btn btn-primary">
                                Download PDF
                            </a>

                            {{-- Excel --}}
                            <a href="{{ route('report.voucher.intermark.excel', [
                                'entry_date' => request('entry_date'),
                                'end_date' => request('end_date'),
                                'voucher_type' => $voucherType
                            ]) }}"
                            class="btn btn-success">
                                Download Excel
                            </a>


                            @if($voucherType === 'ALL')

                                {{-- Starbucks --}}
                                <a href="{{ route('report.voucher.intermark.data', [
                                    'entry_date' => request('entry_date'),
                                    'end_date' => request('end_date'),
                                    'voucher_type' => 'SBX'
                                ]) }}"
                                class="btn btn-warning">
                                    Starbucks
                                </a>

                                {{-- Subway --}}
                                <a href="{{ route('report.voucher.intermark.data', [
                                    'entry_date' => request('entry_date'),
                                    'end_date' => request('end_date'),
                                    'voucher_type' => 'SUB'
                                ]) }}"
                                class="btn btn-info">
                                    Subway
                                </a>


                            @elseif($voucherType === 'SBX')

                                {{-- All --}}
                                <a href="{{ route('report.voucher.intermark.data', [
                                    'entry_date' => request('entry_date'),
                                    'end_date' => request('end_date'),
                                    'voucher_type' => 'ALL'
                                ]) }}"
                                class="btn btn-secondary">
                                    All
                                </a>

                                {{-- Subway --}}
                                <a href="{{ route('report.voucher.intermark.data', [
                                    'entry_date' => request('entry_date'),
                                    'end_date' => request('end_date'),
                                    'voucher_type' => 'SUB'
                                ]) }}"
                                class="btn btn-info">
                                    Subway
                                </a>


                            @elseif($voucherType === 'SUB')

                                {{-- Starbucks --}}
                                <a href="{{ route('report.voucher.intermark.data', [
                                    'entry_date' => request('entry_date'),
                                    'end_date' => request('end_date'),
                                    'voucher_type' => 'SBX'
                                ]) }}"
                                class="btn btn-warning">
                                    Starbucks
                                </a>

                                {{-- All --}}
                                <a href="{{ route('report.voucher.intermark.data', [
                                    'entry_date' => request('entry_date'),
                                    'end_date' => request('end_date'),
                                    'voucher_type' => 'ALL'
                                ]) }}"
                                class="btn btn-secondary">
                                    All
                                </a>
                            @endif
                            <br>
                        </div>
                    @endif
                    @if(!empty($results))
                        <table class="display dataTable cell-border datatbl-advance">
                            <thead style="text-align: center;">
                                <tr>
                                    <td class="xl66" style="height: 32.0pt; width: 65pt;">No</td>
                                    <td class="xl66" style="width: 65pt;">Tanggal Masuk</td>
                                    <td class="xl65" style="width: 130pt;">Tanggal Keluar</td>
                                    <td class="xl65" style="width: 130pt;">Kode Voucher</td>
                                    <td class="xl65" style="width: 130pt;">Jenis Kendaraan</td>
                                    <td class="xl65" style="width: 130pt;">Nomor Polisi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $index => $result)
                                    <tr role="row">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $result->tanggal }}</td>
                                        <td>{{ $result->tanggal_keluar }}</td>
                                        <td>{{ $result->kode_voucher}}</td>
                                        <td>{{ $result->jenis_kendaraan }}</td>
                                        <td>{{ $result->nopol }}</td>
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

<script>

    $(document).ready(function() {
        $('.datatbl-advance').DataTable();
    });

</script>



