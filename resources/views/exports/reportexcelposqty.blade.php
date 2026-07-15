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
                <th class="xl66" style="height: 32.0pt; width: 65pt;"width="5" height="42">No</th>
                <th class="xl66" style="width: 100pt;" width="20">Tanggal</th>
                <th class="xl65" style="width: 80pt;" width="15">PM Mobil 1</th>
                <th class="xl65" style="width: 80pt;" width="15">PM Mobil 2</th>
                <th class="xl65" style="width: 80pt;" width="15">PM Motor</th>
                <th class="xl65" style="width: 80pt;" width="15">PK Mobil 1</th>
                <th class="xl65" style="width: 80pt;" width="15">PK Mobil 2</th>
                <th class="xl65" style="width: 80pt;" width="15">PK Motor</th>
                <th class="xl65" style="width: 80pt;" width="15">Total Masuk</th>
                <th class="xl65" style="width: 80pt;" width="15">Total Keluar</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPMmobil1 = 0;
                $totalPMmobil2 = 0;
                $totalPMmotor = 0;
                $totalPKmobil1 = 0;
                $totalPKmobil2 = 0;
                $totalPKmotor = 0;
                $totalPM = 0;
                $totalPK = 0;
                $total = 0;
            @endphp
            @foreach($data as $index => $result)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->date }}</td>
                    <td align="right">{{ number_format($result->PM_Mob1) }}</td>
                    <td align="right">{{ number_format($result->PM_Mob2) }}</td>
                    <td align="right">{{ number_format($result->PM_Motor) }}</td>
                    <td align="right">{{ number_format($result->PK_Mob1) }}</td>
                    <td align="right">{{ number_format($result->PK_Mob2) }}</td>
                    <td align="right">{{ number_format($result->PK_Motor) }}</td>
                    <td align="right">{{ number_format($result->Total_PM) }}</td>
                    <td align="right">{{ number_format($result->Total_PK) }}</td>
                    @php
                        $totalPMmobil1 += $result->PM_Mob1;
                        $totalPMmobil2 += $result->PM_Mob2;
                        $totalPMmotor += $result->PM_Motor;
                        $totalPKmobil1 += $result->PK_Mob1;
                        $totalPKmobil2 += $result->PK_Mob2;
                        $totalPKmotor += $result->PK_Motor;
                        $totalPM += $result->Total_PM;
                        $totalPK += $result->Total_PK;
                        $total = $totalPM + $totalPK;
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td><strong>{{ number_format($totalPMmobil1) }}</strong></td>
                <td><strong>{{ number_format($totalPMmobil2) }}</strong></td>
                <td><strong>{{ number_format($totalPMmotor) }}</strong></td>
                <td><strong>{{ number_format($totalPKmobil1) }}</strong></td>
                <td><strong>{{ number_format($totalPKmobil2) }}</strong></td>
                <td><strong>{{ number_format($totalPKmotor) }}</strong></td>
                <td><strong>{{ number_format($totalPM) }}</strong></td>
                <td><strong>{{ number_format($totalPK) }}</strong></td>
            </tr>
        </tbody>
        <tr>
             <td colspan="10"></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Pos Masuk Mobil 1</strong></td>
            <td><strong>{{ number_format($totalPMmobil1) }}</strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Pos Masuk Mobil 2</strong></td>
            <td><strong>{{ number_format($totalPMmobil2) }}</strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Pos Masuk Motor</strong></td>
            <td><strong>{{ number_format($totalPMmotor) }}</strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Pos Keluar Mobil 1</strong></td>
            <td><strong>{{ number_format($totalPKmobil1) }}</strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Pos Keluar Mobil 2</strong></td>
            <td><strong>{{ number_format($totalPKmobil2) }}</strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Pos Keluar Motor</strong></td>
            <td><strong>{{ number_format($totalPKmotor) }}</strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Total</strong></td>
            <td><strong>{{ number_format($total) }}</strong></td>
        </tr>
    </table>
</body>
</html>