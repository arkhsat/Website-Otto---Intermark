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
                    <form id="hotel-report-form" action="{{ route('report.hotel.trx') }}" method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-2">
                                {{ Form::label('entry_date', __('Start Date'), ['class' => 'form-label']) }}
                                {{ Form::date('entry_date', request('entry_date', date('Y-m-d')), ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-2">
                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                {{ Form::date('end_date', request('end_date', date('Y-m-d')), ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-4">
                                {{ Form::label('hotel', __('Pilih Hotel'), ['class' => 'form-label']) }}
                                {{ Form::select(
                                    'hotel',
                                    ['SBSR' => 'SBSR - Swiss Bell Hotel', 'SCSR' => 'SCSR - Swiss Bell Court'],
                                    request('hotel'),
                                    ['class' => 'form-control', 'id' => 'hotel-select']
                                ) }}
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-secondary" type="submit">Process</button>
                            </div>
                        </div>
                    </form>
                    <br>

                    @if(!empty($results))
                        @if ($hotel == 'SBSR') 
                            <h4 style="text-align: center;">{{$reportname}}</h4>
                            <div style="margin-bottom: 10px;">
                                <a href="{{ route('report.hotel.SBSR.pdf', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d')), 'hotel' => request('hotel')]) }}" class="btn btn-primary">Download PDF</a>
                                <a href="{{ route('report.hotel.SBSR.excel', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d')), 'hotel' => request('hotel')]) }}" class="btn btn-success">Download Excel</a>
                            </div>
                            <table class="display dataTable cell-border">
                                <thead style="text-align: center;">
                                    <tr>
                                        <td class="xl66" style="height: 32.0pt; width: 65pt;">No</td>
                                        <td class="xl66" style="width: 65pt;">Tanggal Masuk</td>
                                        <td class="xl65" style="width: 130pt;">Tanggal Keluar</td>
                                        <td class="xl65" style="width: 130pt;">Nama</td>
                                        <td class="xl65" style="width: 130pt;">Jenis Kendaraan</td>
                                        <td class="xl65" style="width: 130pt;">Nomor Polisi</td>
                                        <td class="xl65" style="width: 130pt;">Kamar</td>
                                        {{-- <td class="xl65" style="width: 130pt;">Biaya</td> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $index => $result)
                                        <tr role="row">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $result->tanggal_masuk }}</td>
                                            <td>{{ $result->tanggal_keluar }}</td>
                                            <td>{{ $result->nama}}</td>
                                            <td>{{ $result->jenis_kendaraan }}</td>
                                            <td>{{ $result->nopol }}</td>
                                            <td>{{ $result->kamar }}</td>
                                            {{-- <td>Rp {{ number_format($result->biaya, 0, ',', '.') }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        @elseif ($hotel == 'SCSR')
                            <h4 style="text-align: center;">{{$reportname}}</h4>
                            <div style="margin-bottom: 10px;">
                                <a href="{{ route('report.hotel.SCSR.pdf', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d')), 'hotel' => request('hotel')]) }}" class="btn btn-primary">Download PDF</a>
                                <a href="{{ route('report.hotel.SCSR.excel', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d')), 'hotel' => request('hotel')]) }}" class="btn btn-success">Download Excel</a>
                            </div>
                            <table class="display dataTable cell-border">
                                <thead>
                                    <thead style="text-align: center; font-weight: bold; color: #000">
                                        <tr>
                                            <td class="xl66" style="height: 32.0pt; width: 65pt;" rowspan="2">No</td>
                                            <td class="xl66" style="width: 65pt;" rowspan="2">Tanggal Transaksi</td>
                                            <td class="xl65" style="width: 130pt;" rowspan="2">Tanggal Registrasi Hotel</td>
                                            <td class="xl65" style="width: 130pt;" rowspan="2">Nama</td>
                                            <td class="xl65" style="width: 130pt;" colspan="2">Jenis Kendaraan</td>
                                            <td class="xl65" style="width: 130pt;" rowspan="2">Nomor Polisi</td>
                                            <td class="xl65" style="width: 130pt;" rowspan="2">Kamar</td>
                                        </tr>
                                        <tr>
                                            <td class="xl65" style="width: 130pt;">Mobil</td>
                                            <td class="xl65" style="width: 130pt;">Motor</td>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $index => $result)
                                        <tr role="row">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $result->tanggal }}</td>
                                            <td>{{ $result->tanggal_regis }}</td>
                                            <td>{{ $result->nama}}</td>
                                            <td>{{ $result->Mobil }}</td>
                                            <td>{{ $result->Motor }}</td>
                                            <td>{{ $result->nopol }}</td>
                                            <td>{{ $result->kamar }}</td>
                                            {{-- <td>Rp {{ number_format($result->biaya, 0, ',', '.') }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
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



