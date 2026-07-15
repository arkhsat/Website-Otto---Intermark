<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Harian Member</title>
    <link rel="stylesheet" href="{{ public_path('pdf.css') }}" type="text/css">
    <style>
        .landscape {
            size: 'A4 landscape';
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

    <h3>Data Transaksi RFID</h3>
    <table>
        <thead>
            <tr>
                <th class="xl66" style="width: 20pt;" rowspan="2" width="20">No</th>
                <th class="xl66" style="width: 65pt;" rowspan="2" width="87">Tanggal</th>
                <th class="xl65" style="width: 130pt;" colspan="2" width="150">RFID</th>
                <th class="xl65" style="width: 130pt;" colspan="1" width="150">Blue Bird</th>
                <th class="xl65" style="width: 65pt;" rowspan="2" width="75">TOTAL</th>
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
                $totalRFIDMobil = 0;
                $totalRFIDMotor = 0;
                $totalBlueBirdMobil = 0;
            @endphp
            @foreach($data as $index => $result)
                <tr role="row">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->date }}</td>
                    <td align="right">{{ number_format($result->RFID_Mobil) }}</td>
                    <td align="right">{{ number_format($result->RFID_Motor) }}</td>
                    <td align="right">{{ number_format($result->BLUEBIRD_Mobil) }}</td>
                    <td align="right">{{ number_format($result->total) }}</td>
                    @php
                        $totalRFIDMobil += $result->RFID_Mobil;
                        $totalRFIDMotor += $result->RFID_Motor;
                        $totalBlueBirdMobil += $result->BLUEBIRD_Mobil;
                        $total += $result->total;
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td colspan="5"><strong>Total</strong></td>
                <td><strong>{{ number_format($total) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <h4>Summary</h4>
    <table>
        <thead>
            <tr>
                <th>Metode Pembayaran</th>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>RFID</td>
                <td>{{ number_format($totalRFIDMobil) }}</td>
                <td>{{ number_format($totalRFIDMotor) }}</td>
                <td>{{ number_format($totalRFIDMobil + $totalRFIDMotor) }}</td>
            </tr>
            <tr>
                <td>Blue Bird</td>
                <td>{{ number_format($totalBlueBirdMobil) }}</td>
                <td>{{ number_format(0) }}</td>
                <td>{{ number_format($totalBlueBirdMobil) }}</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{ number_format($totalRFIDMobil + $totalBlueBirdMobil)}}</strong></td>
                <td><strong>{{ number_format($totalRFIDMotor) }}</strong></td>
                <td><strong>{{ number_format($total) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <h3>Data Transaksi per Jenis Kendaraan</h3>
    <table>
        <thead>
            <tr style="height: 16.0pt;">
                <th>No</th>
                <th>Tanggal</th>
                <th>Motor</th>
                <th>Mobil</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalharianmotor = 0;
                $totalharianmobil = 0;
            @endphp 
            @foreach($data as $index => $result)
                <tr role="row">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->date }}</td>
                    <td align="right">{{ number_format($result->RFID_Motor) }}</td>
                    <td align="right">{{ number_format($result->RFID_Mobil + $result->BLUEBIRD_Mobil) }}</td>
                    <td align="right">{{ number_format($result->total) }}</td>
                    @php
                        $totalharianmotor += $result->RFID_Motor;
                        $totalharianmobil += $result->RFID_Mobil + $result->BLUEBIRD_Mobil;
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td><strong>{{ number_format($totalharianmobil + $totalharianmotor) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <h4>Summary</h4>
    <table>
        <thead>
            <tr>
                <th>Jenis Kendaraan</th>
                <th>Lalin</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Motor</td>
                <td>{{ number_format($totalharianmotor) }}</td>
            </tr>
            <tr>
                <td>Mobil</td>
                <td>{{ number_format($totalharianmobil) }}</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{ number_format($totalharianmotor + $totalharianmobil) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <div class="landscape">
        <h3>Data Transaksi Per Jam</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>1 jam</th>
                    <th>1 - 2 jam</th>
                    <th>2 - 3 jam</th>
                    <th>3 - 2 jam</th>
                    <th>4 - 3 jam</th>
                    <th>5 - 2 jam</th>
                    <th>6 - 3 jam</th>
                    <th>7 - 2 jam</th>
                    <th>8 - 3 jam</th>
                    <th>9 - 2 jam</th>
                    <th>10 - 3 jam</th>
                    <th>11 - 2 jam</th>
                    <th>> 12 jam</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datahours as $index => $hours)
                    <tr role="row">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $hours->tanggal }}</td>
                        <td align="right">{{ number_format($hours->s0sampai1) }}</td>
                        <td align="right">{{ number_format($hours->s1sampai2) }}</td>
                        <td align="right">{{ number_format($hours->s2sampai3) }}</td>
                        <td align="right">{{ number_format($hours->s3sampai4) }}</td>
                        <td align="right">{{ number_format($hours->s4sampai5) }}</td>
                        <td align="right">{{ number_format($hours->s5sampai6) }}</td>
                        <td align="right">{{ number_format($hours->s6sampai7) }}</td>
                        <td align="right">{{ number_format($hours->s7sampai8) }}</td>
                        <td align="right">{{ number_format($hours->s8sampai9) }}</td>
                        <td align="right">{{ number_format($hours->s9sampai10) }}</td>
                        <td align="right">{{ number_format($hours->s10sampai11) }}</td>
                        <td align="right">{{ number_format($hours->s11sampai12) }}</td>
                        <td align="right">{{ number_format($hours->diatas12) }}</td>
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