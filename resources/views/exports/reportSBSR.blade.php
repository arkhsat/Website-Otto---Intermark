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
                <th colspan="7">
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
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                <th>Nama</th>
                <th>Jenis Kendaraan</th>
                <th>Nomor Polisi</th>
                <th>Kamar</th>
                <th>Tipe Tamu</th>
            </tr>
            
        </thead>
        <tbody>
            @php
            $totalBiaya = 0; 
            @endphp
            @foreach($results as $index => $result)
                <tr role="row">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->tanggal_masuk }}</td>
                    <td>{{ $result->tanggal_keluar }}</td>
                    <td>{{ $result->nama}}</td>
                    <td>{{ $result->jenis_kendaraan }}</td>
                    <td>{{ $result->nopol }}</td>
                    <td>{{ $result->kamar }}</td>
                    <td>{{ $result->tipe_guest }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>