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
            <a href="#">{{ __('Report Transaksi Hotel') }}</a>
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
                    <form id="hotel-report-form" action="{{ route('report.pajak.data') }}" method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-2">
                                {{ Form::label('bulan', __('Month'), ['class' => 'form-label']) }}
                                {{ Form::select('bulan', [
                                    '01' => 'Januari',
                                    '02' => 'Februari',
                                    '03' => 'Maret',
                                    '04' => 'April',
                                    '05' => 'Mei',
                                    '06' => 'Juni',
                                    '07' => 'Juli',
                                    '08' => 'Agustus',
                                    '09' => 'September',
                                    '10' => 'Oktober',
                                    '11' => 'November',
                                    '12' => 'Desember'
                                ], request('bulan', date('m')), ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-2">
                                {{ Form::label('tahun', __('Year'), ['class' => 'form-label']) }}
                                {{ Form::selectRange('tahun', 2020, date('Y') + 5, request('tahun', date('Y')), ['class' => 'form-control']) }}
                            </div>


                            <div class="col-md-2">
                                <button class="btn btn-secondary" type="submit">Process</button>
                            </div>
                        </div>
                    </form>
                    <br>

                    @if(!empty($results))
                        <h4 style="text-align: center;">{{$reportname}}</h4>
                        <div style="margin-bottom: 10px;">
                            <a href="{{ route('report.pajak.print', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}" class="btn btn-primary">Download PDF</a>
                            {{-- <a href="{{ route('report.hotel.SBSR.excel', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d')), 'hotel' => request('hotel')]) }}" class="btn btn-success">Download Excel</a> --}}
                        </div>
                        <table class="display dataTable cell-border">
                            <thead style="text-align: center;">
                                <tr>
                                    <td class="xl66" style="height: 32.0pt; width: 10pt;">No</td>
                                    <td class="xl66" style="width: 35pt;">Tanggal Transaksi</td>
                                    <td class="xl65" style="width: 130pt;">Omset</td>
                                    {{-- <td class="xl65" style="width: 130pt;">Biaya</td> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $index => $result)
                                    <tr role="row" style="text-align: center;">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $result->tanggal_transaksi }}</td>
                                        <td>Rp {{ number_format($result->amount,0,',','.') }}</td>
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

<script>

    $(document).ready(function() {
        $('.datatbl-advance').DataTable();
    });

</script>



