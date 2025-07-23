<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Harian</title>
    <link rel="stylesheet" href="{{ public_path('pdf.css') }}" type="text/css"> 
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/Logo Utama.png') }}" alt="Logo Utama" class="logo">
        <div class="title">
            <h2>{{$judul}}</h2>
            <h4>Intermark Indonesia</h4>
            <p>Tanggal : 
                {{ date('d F Y', strtotime($Date)) }}
            </p>
        </div>
    </div>

    <hr>

    <h3>Data Transaksi Per Metode Pembayaran</h3>
    <table>
        <thead>
            <tr>
                <th class="xl65" style="width: 80pt;" width="50">Metode Pembayaran</th>
                <th class="xl65" style="width: 80pt;" width="50">Jenis Kendaraan</th>
                <th class="xl65" style="width: 30pt;" width="20">Lalin</th>
                <th class="xl65" style="width: 50t;" width="100">Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $result = $results[0];
            @endphp
            <tr>
                <td rowspan="2">Mandiri</td>
                <td>Mobil</td>
                <td align="right">{{ number_format($result->Lalin_Mandiri_Mobil) }}</td>
                <td align="right">{{ number_format($result->Amount_Mandiri_Mobil) }}</td>
            </tr>
            <tr>
                <td>Motor</td>
                <td align="right">{{ number_format($result->Lalin_Mandiri_Motor) }}</td>
                <td align="right">{{ number_format($result->Amount_Mandiri_Motor) }}</td>
            </tr>
            <tr>
                <td rowspan="2">BCA</td>
                <td>Mobil</td>
                <td align="right">{{ number_format($result->Lalin_BCA_Mobil) }}</td>
                <td align="right">{{ number_format($result->Amount_BCA_Mobil) }}</td>
            </tr>
            <tr>
                <td>Motor</td>
                <td align="right">{{ number_format($result->Lalin_BCA_Motor) }}</td>
                <td align="right">{{ number_format($result->Amount_BCA_Motor) }}</td>
            </tr>
            <tr>
                <td rowspan="2">BNI</td>
                <td>Mobil</td>
                <td align="right">{{ number_format($result->Lalin_BNI_Mobil) }}</td>
                <td align="right">{{ number_format($result->Amount_BNI_Mobil) }}</td>
            </tr>
            <tr>
                <td>Motor</td>
                <td align="right">{{ number_format($result->Lalin_BNI_Motor) }}</td>
                <td align="right">{{ number_format($result->Amount_BNI_Motor) }}</td>
            </tr>
            <tr>
                <td rowspan="2">BRI</td>
                <td>Mobil</td>
                <td align="right">{{ number_format($result->Lalin_BRI_Mobil) }}</td>
                <td align="right">{{ number_format($result->Amount_BRI_Mobil) }}</td>
            </tr>
            <tr>
                <td>Motor</td>
                <td align="right">{{ number_format($result->Lalin_BRI_Motor) }}</td>
                <td align="right">{{ number_format($result->Amount_BRI_Motor) }}</td>
            </tr>
            <tr>
                <td rowspan="2">Member</td>
                <td>Mobil</td>
                <td align="right">{{ number_format($result->Lalin_Member_Mobil) }}</td>
                <td align="right">{{ number_format($result->Amount_Member_Mobil) }}</td>
            </tr>
            <tr>
                <td>Motor</td>
                <td align="right">{{ number_format($result->Lalin_Member_Motor) }}</td>
                <td align="right">{{ number_format($result->Amount_Member_Motor) }}</td>
            </tr>
            <tr>
                <td rowspan="2">Hotel</td>
                <td>Mobil</td>
                <td align="right">{{ number_format($result->Lalin_Hotel_Mobil) }}</td>
                <td align="right">{{ number_format($result->Amount_Hotel_Mobil) }}</td>
            </tr>
            <tr>
                <td>Motor</td>
                <td align="right">{{ number_format($result->Lalin_Hotel_Motor) }}</td>
                <td align="right">{{ number_format($result->Amount_Hotel_Motor) }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td><strong>{{ number_format($result->Lalin_Mandiri_Mobil + $result->Lalin_Mandiri_Motor +
                    $result->Lalin_BCA_Mobil + $result->Lalin_BCA_Motor +
                    $result->Lalin_BNI_Mobil + $result->Lalin_BNI_Motor +
                    $result->Lalin_BRI_Mobil + $result->Lalin_BRI_Motor +
                    $result->Lalin_Member_Mobil + $result->Lalin_Member_Motor +
                    $result->Lalin_Hotel_Mobil + $result->Lalin_Hotel_Motor) }}</strong></td>
                <td><strong>{{ number_format($result->Amount_Mandiri_Mobil + $result->Amount_Mandiri_Motor +
                    $result->Amount_BCA_Mobil + $result->Amount_BCA_Motor +
                    $result->Amount_BNI_Mobil + $result->Amount_BNI_Motor +
                    $result->Amount_BRI_Mobil + $result->Amount_BRI_Motor +
                    $result->Amount_Member_Mobil + $result->Amount_Member_Motor +
                    $result->Amount_Hotel_Mobil + $result->Amount_Hotel_Motor) }}</strong></td>
            </tr>
        </tbody>              
    </table>

    <h4>Summary</h4>
    <table>
        <thead>
            <tr>
                <th>Jenis Pembayaran</th>
                <th>Lalin</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Mandiri</td>
                <td>{{ number_format($result->Lalin_Mandiri_Motor + $result->Lalin_Mandiri_Mobil) }}</td>
                <td>{{ number_format($result->Amount_Mandiri_Motor + $result->Amount_Mandiri_Mobil) }}</td>
            </tr>
            <tr>
                <td>BCA</td>
                <td>{{ number_format($result->Lalin_BCA_Motor + $result->Lalin_BCA_Mobil) }}</td>
                <td>{{ number_format($result->Amount_BCA_Motor + $result->Amount_BCA_Mobil) }}</td>
            </tr>
            <tr>
                <td>BNI</td>
                <td>{{ number_format($result->Lalin_BNI_Motor + $result->Lalin_BNI_Mobil) }}</td>
                <td>{{ number_format($result->Amount_BNI_Motor + $result->Amount_BNI_Mobil) }}</td>
            </tr>
            <tr>
                <td>BRI</td>
                <td>{{ number_format($result->Lalin_BRI_Motor + $result->Lalin_BRI_Mobil) }}</td>
                <td>{{ number_format($result->Amount_BRI_Motor + $result->Amount_BRI_Mobil) }}</td>
            </tr>
            <tr>
                <td>Member</td>
                <td>{{ number_format($result->Lalin_Member_Motor + $result->Lalin_Member_Mobil) }}</td>
                <td>{{ number_format($result->Amount_Member_Motor + $result->Amount_Member_Mobil) }}</td>
            </tr>
            <tr>
                <td>Hotel</td>
                <td>{{ number_format($result->Lalin_Hotel_Motor + $result->Lalin_Hotel_Mobil) }}</td>
                <td>{{ number_format($result->Amount_Hotel_Motor + $result->Amount_Hotel_Mobil) }}</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{ number_format($result->Lalin_Mandiri_Mobil + $result->Lalin_Mandiri_Motor +
                    $result->Lalin_BCA_Mobil + $result->Lalin_BCA_Motor +
                    $result->Lalin_BNI_Mobil + $result->Lalin_BNI_Motor +
                    $result->Lalin_BRI_Mobil + $result->Lalin_BRI_Motor +
                    $result->Lalin_Member_Mobil + $result->Lalin_Member_Motor +
                    $result->Lalin_Hotel_Mobil + $result->Lalin_Hotel_Motor) }}</strong></td>
                <td><strong>{{ number_format($result->Amount_Mandiri_Mobil + $result->Amount_Mandiri_Motor +
                    $result->Amount_BCA_Mobil + $result->Amount_BCA_Motor +
                    $result->Amount_BNI_Mobil + $result->Amount_BNI_Motor +
                    $result->Amount_BRI_Mobil + $result->Amount_BRI_Motor +
                    $result->Amount_Member_Mobil + $result->Amount_Member_Motor +
                    $result->Amount_Hotel_Mobil + $result->Amount_Hotel_Motor) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Tanggal Cetak: {{ date('d F Y') }}
    </div>
</body>
</html>