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
                <th colspan="13">
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
                <th class="xl66" rowspan="2" >No</th>
                <th class="xl66" rowspan="2" >Tanggal</th>
                <th class="xl65" colspan="2" >RFID</th>
                <th class="xl65" colspan="1" >Blue Bird</th>
                <th class="xl65" rowspan="2" >TOTAL</th>
            </tr>
            <tr>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Mobil</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $totalMobil = 0;
                $totalMotor = 0;
            @endphp
            @foreach($data as $index => $result)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->date }}</td>
                    <td>{{ number_format($result->RFID_Mobil) }}</td>
                    <td>{{ number_format($result->RFID_Motor) }}</td>
                    <td>{{ number_format($result->BLUEBIRD_Mobil) }}</td>
                    <td>{{ number_format($result->total) }}</td>
                    @php
                        $total += $result->total;
                        $totalMobil += $result->RFID_Mobil + $result->BLUEBIRD_Mobil;
                        $totalMotor += $result->RFID_Motor;
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td colspan="5"><strong>Total</strong></td>
                <td><strong>{{ number_format($total) }}</strong></td>
            </tr>
        </tbody>
        <tr></tr>
        <tr>
            <td></td>
            <td><strong>Total Mobil</strong></td>
            <td><strong>{{ number_format($totalMobil) }}</strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Total Motor</strong></td>
            <td><strong>{{ number_format($totalMotor) }}</strong></td>
        </tr>
    </table>
</body>
</html>