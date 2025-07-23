<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Close By ON</title>
    <link rel="stylesheet" href="{{ public_path('pdf.css') }}" type="text/css"> 
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/Logo Utama.png') }}" alt="Logo Utama" class="logo">
        <div class="title">
            <h2>{{$reportname}}</h2>
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

    <h3>Data Transaksi Hotel Swiss Bell - SBSR</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;" rowspan="2">No</th>
                <th style="width: 20%;" rowspan="2">Tanggal Transaksi</th>
                <th style="width: 20%;" rowspan="2">Tanggal Registrasi Hotel</th>
                <th style="width: 20%;" rowspan="2">Nama</th>
                <th style="width: 30%;" colspan="2">Kendaraan</th>
                <th style="width: 10%;" rowspan="2">Nomor Polisi</th>
                <th style="width: 10%;" rowspan="2">Kamar</th>
            </tr>
            <tr>
                <th style="width: 15%;">Mobil</th>
                <th style="width: 15%;">Motor</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalMobil = 0;
                $totalMotor = 0;
                $summaryByDate = [];
            @endphp
            @foreach($results as $index => $result)
                <tr role="row">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $result->tanggal }}</td>
                        <td>{{ $result->tanggal_regis }}</td>
                        <td>{{ $result->nama}}</td>
                        <td>{{ $result->Mobil }}</td>
                        <td>{{ $result->Motor }}</td>
                        <td>{{ $result->nopol }}</td>
                        <td>{{ $result->kamar }}</td>
                    @php
                        $summaryByDate = [];
                        foreach ($results as $result) {
                            $tgl = date('Y-m-d', strtotime($result->tanggal)); 
                            if (!isset($summaryByDate[$tgl])) {
                                $summaryByDate[$tgl] = ['mobil' => 0, 'motor' => 0, 'total' => 0];
                            }
                            if ($result->Mobil == 1) {
                                $summaryByDate[$tgl]['mobil']++;
                            } elseif ($result->Motor == 1) {
                                $summaryByDate[$tgl]['motor']++;
                            }
                            $summaryByDate[$tgl]['total']++;
                        }
                        ksort($summaryByDate); 
                    @endphp
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <h4>Summary Harian Berdasarkan Tanggal Transaksi</h4>
    <table>
        <thead>
            <tr>
                <th>Tanggal Transaksi</th>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalMobil = 0;
                $totalMotor = 0;
            @endphp
            @foreach($summaryByDate as $tanggal => $sum)
                <tr>
                    <td>{{ date('d-m-Y', strtotime($tanggal)) }}</td>
                    <td>{{ $sum['mobil'] }}</td>
                    <td>{{ $sum['motor'] }}</td>
                    <td>{{ $sum['total'] }}</td>
                    @php
                        $totalMobil += $sum['mobil'];
                        $totalMotor += $sum['motor'];
                    @endphp
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{ $totalMobil }}</strong></td>
                <td><strong>{{ $totalMotor }}</strong></td>
                <td><strong>{{ $totalMobil + $totalMotor }}</strong></td>
            </tr>
    </table>


    <div class="footer">
        Tanggal Cetak: {{ date('d F Y') }}
    </div>
</body>
</html>