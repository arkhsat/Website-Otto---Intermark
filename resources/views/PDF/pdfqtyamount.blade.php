<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Harian</title>
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
    <div class="landscape">
        <h3>Data Transaksi per Metode Pembayaran</h3>
        <table>
            <thead>
                <tr>
                    <th class="xl66" style="width: 20pt;" rowspan="2" width="20">No</th>
                    <th class="xl66" style="width: 50pt;" rowspan="2" width="87">Tanggal</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">Mandiri</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">BCA</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">BNI</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">BRI</th>
                    <th class="xl65" style="width: 130pt;" colspan="3" width="150">QRIS</th>
                    <th class="xl65" style="width: 65pt;" rowspan="2" width="75">TOTAL</th>
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
                    $totalMandiriMobil = 0;
                    $totalMandiriMotor = 0;
                    $totalMandiriTruck = 0;
                    $totalBCAMobil = 0;
                    $totalBCAMotor = 0;
                    $totalBCATruck = 0;
                    $totalBNIMobil = 0;
                    $totalBNIMotor = 0;
                    $totalBNITruck = 0;
                    $totalBRIMobil = 0;
                    $totalBRIMotor = 0;
                    $totalBRITruck = 0;
                    $totalQRISMobil = 0;
                    $totalQRISMotor = 0;
                    $totalQRISTruck = 0;
                @endphp
                @foreach($data as $index => $result)
                    <tr role="row">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $result->date }}</td>
                        <td align="right">{{ number_format($result->Mandiri_Mobil) }}</td>
                        <td align="right">{{ number_format($result->Mandiri_Motor) }}</td>
                        <td align="right">{{ number_format($result->Mandiri_Truck) }}</td>
                        <td align="right">{{ number_format($result->BCA_Mobil) }}</td>
                        <td align="right">{{ number_format($result->BCA_Motor) }}</td>
                        <td align="right">{{ number_format($result->BCA_Truck) }}</td>
                        <td align="right">{{ number_format($result->BNI_Mobil) }}</td>
                        <td align="right">{{ number_format($result->BNI_Motor) }}</td>
                        <td align="right">{{ number_format($result->BNI_Truck) }}</td>
                        <td align="right">{{ number_format($result->BRI_Mobil) }}</td>
                        <td align="right">{{ number_format($result->BRI_Motor) }}</td>
                        <td align="right">{{ number_format($result->BRI_Truck) }}</td>
                        <td align="right">{{ number_format($result->QRIS_Mobil) }}</td>
                        <td align="right">{{ number_format($result->QRIS_Motor) }}</td>
                        <td align="right">{{ number_format($result->QRIS_Truck) }}</td>
                        <td align="right">{{ number_format($result->total) }}</td>
                        @php
                            $total += $result->total;
                            $totalMandiriMobil += $result->Mandiri_Mobil;
                            $totalMandiriMotor += $result->Mandiri_Motor;
                            $totalMandiriTruck += $result->Mandiri_Truck;
                            $totalBCAMobil += $result->BCA_Mobil;
                            $totalBCAMotor += $result->BCA_Motor;
                            $totalBCATruck += $result->BCA_Truck;
                            $totalBNIMobil += $result->BNI_Mobil;
                            $totalBNIMotor += $result->BNI_Motor;
                            $totalBNITruck += $result->BNI_Truck;
                            $totalBRIMobil += $result->BRI_Mobil;
                            $totalBRIMotor += $result->BRI_Motor;
                            $totalBRITruck += $result->BRI_Truck;
                            $totalQRISMobil += $result->QRIS_Mobil;
                            $totalQRISMotor += $result->QRIS_Motor;
                            $totalQRISTruck += $result->QRIS_Truck;
                        @endphp
                    </tr>
                @endforeach
                <tr>
                    <td colspan="17"><strong>Total</strong></td>
                    <td><strong>{{ number_format($total) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <h4>Summary</h4>
    <table>
        <thead>
            <tr>
                <th>Metode Pembayaran</th>
                <th>Motor</th>
                <th>Mobil</th>
                <th>Truck</th>
                <th>Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Mandiri</td>
                <td>{{ number_format($totalMandiriMotor) }}</td>
                <td>{{ number_format($totalMandiriMobil) }}</td>
                <td>{{ number_format($totalMandiriTruck) }}</td>
                <td>{{ number_format($totalMandiriMobil + $totalMandiriMotor + $totalMandiriTruck) }}</td>
            </tr>
            <tr>
                <td>BCA</td>
                <td>{{ number_format($totalBCAMotor) }}</td>
                <td>{{ number_format($totalBCAMobil) }}</td>
                <td>{{ number_format($totalBCATruck) }}</td>
                <td>{{ number_format($totalBCAMobil + $totalBCAMotor + $totalBCATruck) }}</td>
            </tr>
            <tr>
                <td>BNI</td>
                <td>{{ number_format($totalBNIMotor) }}</td>
                <td>{{ number_format($totalBNIMobil) }}</td>
                <td>{{ number_format($totalBNITruck) }}</td>
                <td>{{ number_format($totalBNIMobil + $totalBNIMotor + $totalBNITruck) }}</td>
            </tr>
            <tr>
                <td>BRI</td>
                <td>{{ number_format($totalBRIMotor) }}</td>
                <td>{{ number_format($totalBRIMobil) }}</td>
                <td>{{ number_format($totalBRITruck) }}</td>
                <td>{{ number_format($totalBRIMobil + $totalBRIMotor + $totalBRITruck) }}</td>
            </tr>
            <tr>
                <td>QRIS</td>
                <td>{{ number_format($totalQRISMotor) }}</td>
                <td>{{ number_format($totalQRISMobil) }}</td>
                <td>{{ number_format($totalQRISTruck) }}</td>
                <td>{{ number_format($totalQRISMobil + $totalQRISMotor + $totalQRISTruck) }}</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{ number_format($totalBRIMotor + $totalBCAMotor + $totalBNIMotor + $totalMandiriMotor + $totalQRISMotor) }}</strong></td>
                <td><strong>{{ number_format($totalBRIMobil + $totalBCAMobil + $totalBNIMobil + $totalMandiriMobil + $totalQRISMobil) }}</strong></td>
                <td><strong>{{ number_format($totalBRITruck + $totalBCATruck + $totalBNITruck + $totalMandiriTruck + $totalQRISTruck) }}</strong></td>
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
                <th>Truck</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalharianmotor = 0;
                $totalharianmobil = 0;
                $totalhariantruck = 0;
            @endphp 
            @foreach($data as $index => $result)
                <tr role="row">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->date }}</td>
                    <td align="right">{{ number_format($result->Mandiri_Motor + $result->BCA_Motor + $result->BNI_Motor + $result->BRI_Motor + $result->QRIS_Motor) }}</td>
                    <td align="right">{{ number_format($result->Mandiri_Mobil + $result->BCA_Mobil + $result->BNI_Mobil + $result->BRI_Mobil + $result->QRIS_Mobil) }}</td>
                    <td align="right">{{ number_format($result->Mandiri_Truck + $result->BCA_Truck + $result->BNI_Truck + $result->BRI_Truck + $result->QRIS_Truck) }}</td>
                    <td align="right">{{ number_format($result->total) }}</td>
                    @php
                        $totalharianmotor += $result->Mandiri_Motor + $result->BCA_Motor + $result->BNI_Motor + $result->BRI_Motor + $result->QRIS_Motor;
                        $totalharianmobil += $result->Mandiri_Mobil + $result->BCA_Mobil + $result->BNI_Mobil + $result->BRI_Mobil + $result->QRIS_Mobil;
                        $totalhariantruck += $result->Mandiri_Truck + $result->BCA_Truck + $result->BNI_Truck + $result->BRI_Truck + $result->QRIS_Truck;
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
                <td>Truck</td>
                <td>{{ number_format($totalhariantruck) }}</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{ number_format($totalharianmotor + $totalharianmobil + $totalhariantruck) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Tanggal Cetak: {{ date('d F Y') }}
    </div>
</body>
</html>