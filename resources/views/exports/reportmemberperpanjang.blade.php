<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>
    <style>
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            width: 1cm;
            height: auto;
        }
        .title {
            text-align: center;
        }
        .header-row{
            height: 75px;
            text-align: center
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th colspan="8">
                    <div class="header">
                        <div class="title">
                            <h2>{{ $judul }}</h2>
                            <h4>{{ config('app.location')}}</h4>
                            <p>Tanggal : 
                                @if ($startDate == $endDate)
                                    {{ date('d F Y', strtotime($startDate)) }}
                                @else
                                    {{ date('d F Y', strtotime($startDate)) }} s/d {{ date('d F Y', strtotime($endDate)) }}
                                @endif
                            </p>
                        </div>
                    </div>
                </th>
            </tr>

            <tr>
                <th>No</th>
                <th>Tanggal Bayar</th>
                <th>Nama</th>
                <th>Perusahaan</th>
                <th>Plat Nomor</th>
                <th>Jenis Kendaraan</th>
                <th>Produk</th>
                <th>Keterangan</th>
                {{-- <th>Biaya</th> --}}
            </tr>
            
        </thead>
        <tbody>
            @php
            $totalBiaya = 0; 
            @endphp
            @foreach($data as $index => $result)
                <tr role="row">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->tanggal }}</td>
                    <td>{{ $result->nama}}</td>
                    <td>{{ $result->perusahaan }}</td>
                    <td>{{ $result->nopol }}</td>
                    <td>{{ $result->jenis_kendaraan }}</td>
                    <td>{{ $result->jenis_produk }}</td>
                    <td>{{ $result->keterangan }}</td>
                    {{-- <td>{{ number_format($result->biaya) }}</td> --}}
                </tr>
                @php
                    $totalBiaya += $result->biaya;
                @endphp
            @endforeach
            {{-- <tr>
                <td colspan="6" style="text-align: right; font-weight: bold;">Total Biaya:</td>
                <td><strong>{{ number_format($totalBiaya) }}</strong></td>
            </tr> --}}
        </tbody>
    </table>
</body>
</html>