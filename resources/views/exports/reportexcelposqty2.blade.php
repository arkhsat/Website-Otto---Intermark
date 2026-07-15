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

        .header-row {
            height: 75px;
            text-align: center;
        }
    </style>
</head>
<body>

<table>
    <thead>
        <tr>
            <th colspan="27">
                <div class="header">
                    <div class="title">
                        <h2>{{ $judul }}</h2>
                        <h4>{{ config('app.location') }}</h4>

                        <p>
                            Tanggal :
                            @if ($startDate == $endDate)
                                {{ date('d F Y', strtotime($startDate)) }}
                            @else
                                {{ date('d F Y', strtotime($startDate)) }}
                                s/d
                                {{ date('d F Y', strtotime($endDate)) }}
                            @endif
                        </p>
                    </div>
                </div>
            </th>
        </tr>

        <tr>
            <th>No</th>
            <th>Tanggal</th>

            @for ($i = 0; $i <= 23; $i++)
                <th>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00</th>
            @endfor

            <th>Total</th>
        </tr>
    </thead>

    <tbody>

        @php
            $totals = [];

            for ($i = 0; $i <= 23; $i++) {
                $totals[$i] = 0;
            }

            $grandTotal = 0;
        @endphp

        @foreach($datahours as $index => $hours)

            <tr>
                <td>{{ $index + 1 }}</td>

                <td>
                    {{ date('d-m-Y', strtotime($hours->tanggal)) }}
                </td>

                @for ($i = 0; $i <= 23; $i++)
                    <td align="right">
                        {{ number_format($hours->{'jam'.$i}) }}
                    </td>
                @endfor

                <td align="right">
                    {{ number_format($hours->total) }}
                </td>
            </tr>

            @php
                for ($i = 0; $i <= 23; $i++) {
                    $totals[$i] += $hours->{'jam'.$i};
                }

                $grandTotal += $hours->total;
            @endphp

        @endforeach

        <tr>
            <td colspan="2">
                <strong>Total</strong>
            </td>

            @for ($i = 0; $i <= 23; $i++)
                <td align="right">
                    <strong>{{ number_format($totals[$i]) }}</strong>
                </td>
            @endfor

            <td align="right">
                <strong>{{ number_format($grandTotal) }}</strong>
            </td>
        </tr>

    </tbody>
</table>

</body>
</html>