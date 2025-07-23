<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Edit Data Member</title>
    <link rel="stylesheet" href="{{ public_path('pdf.css') }}" type="text/css"> 
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/Logo Utama.png') }}" alt="Logo Utama" class="logo">
        <div class="title">
            <h2>{{$judul}}</h2>
            <h4>Intermark Indonesia</h4>
            <p>Tanggal : 
                @if ($startDate == $endDate)
                    {{ date('d F Y', strtotime($startDate)) }}
                @else
                    {{ date('d F Y', strtotime($startDate)) }} s/d {{ date('d F Y', strtotime($endDate)) }}
                @endif
            </p>
        </div>
    </div>

    <hr>

    <table>
        <thead>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">Tanggal</th>
            <th style="width: 20%;">Nama</th>
            <th style="width: 20%;">Perusahaan</th>
            <th style="width: 15%;">Plat Kendaraan</th>
            <th style="width: 10%;">Jenis Kendaraan</th>
            <th style="width: 15%;">Data Sebelum</th>
            <th style="width: 15%;">Data Sesudah</th>
            <th style="width: 10%;">Keterangan</th>
            {{-- <th style="width: 15%;">Biaya</th> --}}
        </thead>
        <tbody>
            @php
            $totalBiaya = 0; 
            @endphp
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
                    {{-- <td>{{ number_format($result->biaya) }}</td> --}}
                </tr>
            @endforeach
            {{-- <tr>
                <td colspan="6" style="text-align: right; font-weight: bold;">Total Biaya:</td>
                <td style="font-weight: bold;">{{ number_format($totalBiaya) }}</td>
            </tr> --}}
        </tbody>
    </table>


    <div class="footer">
        Tanggal Cetak: {{ date('d F Y') }}
    </div>
</body>
</html>