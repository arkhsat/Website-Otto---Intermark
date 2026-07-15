<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Pos Harian</title>
    <link rel="stylesheet" href="{{ public_path('pdf.css') }}" type="text/css">
    <style>
        .landscape {
            size: 'A3 landscape';
        }
    </style>
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

    <h3>Data Transaksi Pos Masuk dan Pos Out</h3>
    <table>
        <thead>
            <tr>
                <th class="xl66" style="width: 20pt;" width="20">No</th>
                <th class="xl66" style="width: 65pt;" width="87">Tanggal</th>
                <th class="xl65" style="width: 130pt;" width="150">PM Mobil 1</th>
                <th class="xl65" style="width: 130pt;" width="150">PM Mobil 2</th>
                <th class="xl65" style="width: 130pt;" width="150">PM Motor</th>
                <th class="xl65" style="width: 130pt;" width="150">PK Mobil 1</th>
                <th class="xl65" style="width: 130pt;" width="150">PK Mobil 2</th>
                <th class="xl65" style="width: 130pt;" width="150">PK Motor</th>
                <th class="xl65" style="width: 65pt;" width="75">TOTAL Mobil</th>
                <th class="xl65" style="width: 65pt;" width="75">TOTAL Motor</th>
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
                <tr role="row">
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
    </table>

    <h4>Summary</h4>
    <table>
        <thead>
            <tr>
                <th>Pos</th>
                <th>Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pos Masuk Mobil 1</td>
                <td>{{ number_format($totalPMmobil1) }}</td>
            </tr>
            <tr>
                <td>Pos Masuk Mobil 2</td>
                <td>{{ number_format($totalPMmobil2) }}</td>
            </tr>
            <tr>
                <td>Pos Masuk Motor</td>
                <td>{{ number_format($totalPMmotor) }}</td>
            </tr>
            <tr>
                <td>Pos Keluar Mobil 1</td>
                <td>{{ number_format($totalPKmobil1) }}</td>
            </tr>
            <tr>
                <td>Pos Keluar Mobil 2</td>
                <td>{{ number_format($totalPKmobil2) }}</td>
            </tr>
            <tr>
                <td>Pos Keluar Motor</td>
                <td>{{ number_format($totalPKmotor) }}</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{ number_format($total) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <div class="landscape">
        <h3>Data Transaksi Pos Masuk Per Jam</h3>
        <table>
            <thead>
                <tr>
                    <th class="xl66" style="width: 20pt;" rowspan="2" width="20">No</th>
                    <th class="xl66" style="width: 65pt;" rowspan="2" width="87">Tanggal</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">0 - 3 AM</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">4 - 7 AM</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">8 - 11 AM</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">12 - 15 PM</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">16 - 19 PM</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">20 - 23 PM</th>
                    <th class="xl65" style="width: 65pt;" rowspan="2" width="75">TOTAL</th>
                </tr>
                <tr>
                    <th>Pos In Mob1</th>
                    <th>Pos In Mob2</th>
                    <th>Pos In Motor</th>
                    <th>Pos In Mob1</th>
                    <th>Pos In Mob2</th>
                    <th>Pos In Motor</th>
                    <th>Pos In Mob1</th>
                    <th>Pos In Mob2</th>
                    <th>Pos In Motor</th>
                    <th>Pos In Mob1</th>
                    <th>Pos In Mob2</th>
                    <th>Pos In Motor</th>
                    <th>Pos In Mob1</th>
                    <th>Pos In Mob2</th>
                    <th>Pos In Motor</th>
                    <th>Pos In Mob1</th>
                    <th>Pos In Mob2</th>
                    <th>Pos In Motor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datahours as $index => $hours)
                    <tr role="row">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $hours->tanggal }}</td>
                        <td align="right">{{ number_format($hours->PM1_00_03) }}</td>
                        <td align="right">{{ number_format($hours->PM2_00_03) }}</td>
                        <td align="right">{{ number_format($hours->PMMotor_00_03) }}</td>
                        <td align="right">{{ number_format($hours->PM1_04_07) }}</td>
                        <td align="right">{{ number_format($hours->PM2_04_07) }}</td>
                        <td align="right">{{ number_format($hours->PMMotor_04_07) }}</td>
                        <td align="right">{{ number_format($hours->PM1_08_11) }}</td>
                        <td align="right">{{ number_format($hours->PM2_08_11) }}</td>
                        <td align="right">{{ number_format($hours->PMMotor_08_11) }}</td>
                        <td align="right">{{ number_format($hours->PM1_12_15) }}</td>
                        <td align="right">{{ number_format($hours->PM2_12_15) }}</td>
                        <td align="right">{{ number_format($hours->PMMotor_12_15) }}</td>
                        <td align="right">{{ number_format($hours->PM1_16_19) }}</td>
                        <td align="right">{{ number_format($hours->PM2_16_19) }}</td>
                        <td align="right">{{ number_format($hours->PMMotor_16_19) }}</td>
                        <td align="right">{{ number_format($hours->PM1_20_23) }}</td>
                        <td align="right">{{ number_format($hours->PM2_20_23) }}</td>
                        <td align="right">{{ number_format($hours->PMMotor_20_23) }}</td>
                        <td align="right">{{ number_format($hours->total) }} transaksi</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="landscape">
        <h3>Data Transaksi Pos Keluar Per Jam</h3>
        <table>
            <thead>
                <tr>
                    <th class="xl66" style="width: 20pt;" rowspan="2" width="20">No</th>
                    <th class="xl66" style="width: 65pt;" rowspan="2" width="87">Tanggal</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">0 - 3 AM</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">4 - 7 AM</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">8 - 11 AM</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">12 - 15 PM</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">16 - 19 PM</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">20 - 23 PM</th>
                    <th class="xl65" style="width: 65pt;" rowspan="2" width="75">TOTAL</th>
                </tr>
                <tr>
                    <th>Pos Out Mob1</th>
                    <th>Pos Out Mob2</th>
                    <th>Pos Out Motor</th>
                    <th>Pos Out Mob1</th>
                    <th>Pos Out Mob2</th>
                    <th>Pos Out Motor</th>
                    <th>Pos Out Mob1</th>
                    <th>Pos Out Mob2</th>
                    <th>Pos Out Motor</th>
                    <th>Pos Out Mob1</th>
                    <th>Pos Out Mob2</th>
                    <th>Pos Out Motor</th>
                    <th>Pos Out Mob1</th>
                    <th>Pos Out Mob2</th>
                    <th>Pos Out Motor</th>
                    <th>Pos Out Mob1</th>
                    <th>Pos Out Mob2</th>
                    <th>Pos Out Motor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datahours as $index => $hours)
                    <tr role="row">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $hours->tanggal }}</td>
                        <td align="right">{{ number_format($hours->PK1_00_03) }}</td>
                        <td align="right">{{ number_format($hours->PK2_00_03) }}</td>
                        <td align="right">{{ number_format($hours->PKMotor_00_03) }}</td>
                        <td align="right">{{ number_format($hours->PK1_04_07) }}</td>
                        <td align="right">{{ number_format($hours->PK2_04_07) }}</td>
                        <td align="right">{{ number_format($hours->PKMotor_04_07) }}</td>
                        <td align="right">{{ number_format($hours->PK1_08_11) }}</td>
                        <td align="right">{{ number_format($hours->PK2_08_11) }}</td>
                        <td align="right">{{ number_format($hours->PKMotor_08_11) }}</td>
                        <td align="right">{{ number_format($hours->PK1_12_15) }}</td>
                        <td align="right">{{ number_format($hours->PK2_12_15) }}</td>
                        <td align="right">{{ number_format($hours->PKMotor_12_15) }}</td>
                        <td align="right">{{ number_format($hours->PK1_16_19) }}</td>
                        <td align="right">{{ number_format($hours->PK2_16_19) }}</td>
                        <td align="right">{{ number_format($hours->PKMotor_16_19) }}</td>
                        <td align="right">{{ number_format($hours->PK1_20_23) }}</td>
                        <td align="right">{{ number_format($hours->PK2_20_23) }}</td>
                        <td align="right">{{ number_format($hours->PKMotor_20_23) }}</td>
                        <td align="right">{{ number_format($hours->total) }} transaksi</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Tanggal Cetak: {{ date('d F Y') }}
    </div>
</body>
</html>