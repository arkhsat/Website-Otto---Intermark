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
                <th colspan="5">
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
                <th>Tanggal Keluar</th>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Total Transaksi</th>
            </tr>
            
        </thead>
        <tbody>
            @php
                $nomor = 1;
            @endphp
            @foreach($summaryByDate as $tanggal => $sum)
                <tr>
                    <td> {{ $nomor ++  }}</td>
                    <td>{{ date('d-m-Y', strtotime($tanggal)) }}</td>
                    <td>{{ $sum['mobil'] }}</td>
                    <td>{{ $sum['motor'] }}</td>
                    <td>{{ $sum['total'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td><strong>{{ $totalMobil }}</strong></td>
                <td><strong>{{ $totalMotor }}</strong></td>
                <td><strong>{{ $totalMobil + $totalMotor }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>