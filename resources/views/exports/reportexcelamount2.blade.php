<!-- filepath: /e:/Kerja/parkingsystem/parkingsystem/resources/views/exports/reportexcelqty2.blade.php -->

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
                <th colspan="16">
                    <div class="header">
                        <div class="title">
                            <h2>{{ $judul }}</h2>
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
                </th>
            </tr>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>1 jam</th>
                <th>1 - 2 jam</th>
                <th>2 - 3 jam</th>
                <th>3 - 4 jam</th>
                <th>4 - 5 jam</th>
                <th>5 - 6 jam</th>
                <th>6 - 7 jam</th>
                <th>7 - 8 jam</th>
                <th>8 - 9 jam</th>
                <th>9 - 10 jam</th>
                <th>10 - 11 jam</th>
                <th>11 - 12 jam</th>
                <th>> 12 jam</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total0sampai1 = 0;
                $total1sampai2 = 0;
                $total2sampai3 = 0;
                $total3sampai4 = 0;
                $total4sampai5 = 0;
                $total5sampai6 = 0;
                $total6sampai7 = 0;
                $total7sampai8 = 0;
                $total8sampai9 = 0;
                $total9sampai10 = 0;
                $total10sampai11 = 0;
                $total11sampai12 = 0;
                $totalDiatas12 = 0;
                $totalTransaksi = 0;
            @endphp
            @foreach($datahours as $index => $hours)

                <tr role="row" style="{{ date('w', strtotime($result->date)) == 0 ? 'color:red;' : '' }}">
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
                    <td align="right">{{ number_format($hours->total) }}</td>
                </tr>
                @php
                    $total0sampai1 += $hours->s0sampai1;
                    $total1sampai2 += $hours->s1sampai2;
                    $total2sampai3 += $hours->s2sampai3;
                    $total3sampai4 += $hours->s3sampai4;
                    $total4sampai5 += $hours->s4sampai5;
                    $total5sampai6 += $hours->s5sampai6;
                    $total6sampai7 += $hours->s6sampai7;
                    $total7sampai8 += $hours->s7sampai8;
                    $total8sampai9 += $hours->s8sampai9;
                    $total9sampai10 += $hours->s9sampai10;
                    $total10sampai11 += $hours->s10sampai11;
                    $total11sampai12 += $hours->s11sampai12;
                    $totalDiatas12 += $hours->diatas12;
                    $totalTransaksi += $hours->total;
                @endphp
            @endforeach
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td align="right"><strong>{{ number_format($total0sampai1) }}</strong></td>
                <td align="right"><strong>{{ number_format($total1sampai2) }}</strong></td>
                <td align="right"><strong>{{ number_format($total2sampai3) }}</strong></td>
                <td align="right"><strong>{{ number_format($total3sampai4) }}</strong></td>
                <td align="right"><strong>{{ number_format($total4sampai5) }}</strong></td>
                <td align="right"><strong>{{ number_format($total5sampai6) }}</strong></td>
                <td align="right"><strong>{{ number_format($total6sampai7) }}</strong></td>
                <td align="right"><strong>{{ number_format($total7sampai8) }}</strong></td>
                <td align="right"><strong>{{ number_format($total8sampai9) }}</strong></td>
                <td align="right"><strong>{{ number_format($total9sampai10) }}</strong></td>
                <td align="right"><strong>{{ number_format($total10sampai11) }}</strong></td>
                <td align="right"><strong>{{ number_format($total11sampai12) }}</strong></td>
                <td align="right"><strong>{{ number_format($totalDiatas12) }}</strong></td>
                <td align="right"><strong>{{ number_format($totalTransaksi) }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>