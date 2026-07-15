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
                <th class="xl65" colspan="3" >Mandiri</th>
                <th class="xl65" colspan="3" >BCA</th>
                <th class="xl65" colspan="3" >BNI</th>
                <th class="xl65" colspan="3" >BRI</th>
                <th class="xl65" colspan="3" >QRIS</th>
                <th class="xl65" rowspan="2" >TOTAL</th>
            </tr>
            <tr>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Truck</th>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Truck</th>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Truck</th>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Truck</th>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Truck</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $totalMobil = 0;
                $totalMotor = 0;
                $totalTruck = 0;
            @endphp
            @foreach($data as $index => $result)
                <tr style="{{ date('w', strtotime($result->date)) == 0 ? 'color:red;' : '' }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->date }}</td>
                    <td>{{ number_format($result->Mandiri_Mobil) }}</td>
                    <td>{{ number_format($result->Mandiri_Motor) }}</td>
                    <td>{{ number_format($result->Mandiri_Truck) }}</td>
                    <td>{{ number_format($result->BCA_Mobil) }}</td>
                    <td>{{ number_format($result->BCA_Motor) }}</td>
                    <td>{{ number_format($result->BCA_Truck) }}</td>
                    <td>{{ number_format($result->BNI_Mobil) }}</td>
                    <td>{{ number_format($result->BNI_Motor) }}</td>
                    <td>{{ number_format($result->BNI_Truck) }}</td>
                    <td>{{ number_format($result->BRI_Mobil) }}</td>
                    <td>{{ number_format($result->BRI_Motor) }}</td>
                    <td>{{ number_format($result->BRI_Truck) }}</td>
                    <td>{{ number_format($result->QRIS_Mobil) }}</td>
                    <td>{{ number_format($result->QRIS_Motor) }}</td>
                    <td>{{ number_format($result->QRIS_Truck) }}</td>
                    <td>{{ number_format($result->total) }}</td>
                    @php
                        $total += $result->total;
                        $totalMobil += $result->Mandiri_Mobil + $result->BCA_Mobil + $result->BNI_Mobil + $result->BRI_Mobil + $result->QRIS_Mobil;
                        $totalMotor += $result->Mandiri_Motor + $result->BCA_Motor + $result->BNI_Motor + $result->BRI_Motor + $result->QRIS_Motor;
                        $totalTruck += $result->Mandiri_Truck + $result->BCA_Truck + $result->BNI_Truck + $result->BRI_Truck + $result->QRIS_Truck;
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td colspan="17"><strong>Total</strong></td>
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
        <tr>
            <td></td>
            <td><strong>Total Truck</strong></td>
            <td><strong>{{ number_format($totalTruck) }}</strong></td>
        </tr>
    </table>
</body>
</html>