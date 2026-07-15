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
            <th style="width: 5%;">No</th>
            <th style="width: 20%;">Waktu Masuk</th>
            <th style="width: 20%;">Waktu Keluar</th>
            <th style="width: 20%;">Nama</th>
            <th style="width: 10%;">Kendaraan</th>
            <th style="width: 10%;">Nomor Polisi</th>
            <th style="width: 10%;">Kamar</th>
            <th style="width: 10%;">Tipe Tamu</th>
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
                    <td>{{ $result->tanggal_masuk }}</td>
                    <td>{{ $result->tanggal_keluar }}</td>
                    <td>{{ $result->nama}}</td>
                    <td>{{ $result->jenis_kendaraan }}</td>
                    <td>{{ $result->nopol }}</td>
                    <td>{{ $result->kamar }}</td>
                    <td>{{ $result->tipe_guest}}</td>
                    @php
                        $summaryByDate = [];
                        foreach ($results as $result) {
                            $tgl = date('Y-m-d', strtotime($result->tanggal_keluar)); 
                            if (!isset($summaryByDate[$tgl])) {
                                $summaryByDate[$tgl] = ['mobil' => 0, 'motor' => 0, 'total' => 0];
                            }
                            if (strtolower($result->jenis_kendaraan) == 'mobil') {
                                $summaryByDate[$tgl]['mobil']++;
                            } elseif (strtolower($result->jenis_kendaraan) == 'motor') {
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
    <h4>Summary Harian Berdasarkan Tanggal Keluar</h4>
    <table>
        <thead>
            <tr>
                <th>Tanggal Keluar</th>
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