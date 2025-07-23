<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Close By ON</title>
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

    <h3>Data Perpanjangan Member</h3>
    <table>
        <thead>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">ID Transaksi</th>
            <th style="width: 20%;">Nomor Kartu</th>
            <th style="width: 20%;">Kendaraan</th>
            <th style="width: 15%;">Tanggal Masuk</th>
            <th style="width: 10%;">Close ON</th>
            <th style="width: 10%;">Gambar Kendaraan</th>
        </thead>
        <tbody>
            @php
            $totalBiaya = 0; 
            @endphp
            @foreach($results as $index => $result)
                <tr role="row">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->transactionid}}</td>
                    <td>{{ $result->tiketno }}</td>
                    <td>{{ $result->vehicleid}}</td>
                    <td>{{ $result->datetransact }}</td>
                    <td>{{ $result->dateout }}</td>
                    <td>
                        @if($result->posinid == '1')
                                <img src="{{ public_path('images\contoh_gambar.jpg')}}" width="100px">
                        @elseif($result->posinid == '2')
                                <img src="{{ public_path('images\contoh_gambar.jpg')}}" width="100px">
                        @elseif($result->posinid == '3')
                                <img src="{{ public_path('images\contoh_gambar.jpg')}}" width="100px">
                        @else
                            <span class="badge badge-danger">No Image</span>
                        @endif
                    </td>
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