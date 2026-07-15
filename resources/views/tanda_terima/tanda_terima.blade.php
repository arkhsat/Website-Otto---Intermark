@if (!isset($invoices) || count($invoices) === 0)
    <p style="color: red; font-weight: bold;">Tidak ada data yang tersedia.</p>
@else
    @foreach ($invoices as $invoice)
        @php
            if (!function_exists('terbilang')) {
                function terbilang($angka) {
                    $angka = abs($angka);
                    $baca = ["", " Satu", " Dua", " Tiga", " Empat", " Lima", " Enam", " Tujuh", " Delapan", " Sembilan", " Sepuluh", " Sebelas"];
                    $terbilang = "";

                    if ($angka < 12) {
                        $terbilang = " " . $baca[$angka];
                    } elseif ($angka < 20) {
                        $terbilang = terbilang($angka - 10) . " belas ";
                    } elseif ($angka < 100) {
                        $terbilang = terbilang(intval($angka / 10)) . " puluh " . terbilang($angka % 10);
                    } elseif ($angka < 200) {
                        $terbilang = " seratus" . terbilang($angka - 100);
                    } elseif ($angka < 1000) {
                        $terbilang = terbilang(intval($angka / 100)) . " ratus " . terbilang($angka % 100);
                    } elseif ($angka < 2000) {
                        $terbilang = " seribu" . terbilang($angka - 1000);
                    } elseif ($angka < 1000000) {
                        $terbilang = terbilang(intval($angka / 1000)) . " ribu " . terbilang($angka % 1000);
                    } elseif ($angka < 1000000000) {
                        $terbilang = terbilang(intval($angka / 1000000)) . " juta " . terbilang($angka % 1000000);
                    }

                    return trim($terbilang);
                }
            }

            $client = $invoice['company_name'];
            $data = $invoice['data'];
            $nomor_full = $invoice['nomor_full'];
            $vehicle_nos = $invoice['vehicle_nos'] ?? collect();
            $date2 = date("d-M-y");
            $bulan_angka = date('n');
            $bulan_nama = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
            $date = $bulan_nama[$bulan_angka];
            $client_address = "Gedung Intermark Indonesia<br>Jl. Lkr. Tim. No.9, Rw. Mekar Jaya,<br>Kec. Serpong, Kota Tangerang Selatan, Banten 15310";
        @endphp

        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Tanda Terima</title>
            <style>
                        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            font-size: 14px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
        }
        .header img {
            height: 80px;
        }
        .company-info {
            text-align: justify;
        }
        .company-info p {
            margin: 2px 0;
        }
        .invoice-title {
            margin-top: 10px;
            padding: 10px;
            background-color: #c0d6eb;
            font-size: 24px;
            font-weight: bold;
            width: 200px;
            text-align: center;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .section {
            margin-top: 20px;
        }
        .section p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
        }
        .total {
            text-align: right;
            margin-top: 10px;
        }

        .bank-info {
            margin-top: 20px;
            border: 1px solid black;
            padding: 10px;
            width: 50%;
        }
        .signature {
            /* float: right; */
            margin-top: 30px;
            text-align: right;
        }
.section .row {
    display: grid;
    grid-template-columns: 120px 10px auto;
    margin-bottom: 5px;
    font-family: Arial, sans-serif;
    font-size: 14px;
}

.label {
    font-weight: bold;
}

.colon {
    text-align: center;
}

.value {
    padding-left: 5px;
}


        .left {
    display: flex;
    flex-direction: column;
     align-items: center;
}
.logo-img {
    transform: scale(1.5); /* 2x lebih besar dari ukuran asli */
}
.noborder td {
    border: none !important;
    padding: 6px 8px;
}
.amount-in-words {
    border-top: 2px solid black;
    border-bottom: 2px solid black;
    padding: 10px;
    width: 400px;
    margin-top: 20px;
    margin-bottom: 20px;
    text-align: left;
    font-style: italic; /* Inilah yang membuat huruf miring */
    font-weight: bold;       /* Huruf tebal */
}

.subtotal-row .no-border {
    border: none !important;
    background-color: transparent;
}

.subtotal-row td:last-child {
    border: 1px solid black; /* Atau sesuai gaya border yang kamu pakai */
}
                .signature { float: right; margin-top: 30px; text-align: center; }
                ul { margin: 0; padding-left: 20px; }
            </style>
        </head>
        <body>

        <div class="header">
            <div class="left">
                <img class="logo-img" src="{{ asset('images/Logo Utama.png') }}" alt="Otto Parking">
                <div class="invoice-title">TANDA TERIMA</div>
            </div>
            <div class="company-info">
                <p><strong style="font-size: 16px;">OTTO PARKING</strong></p>
                <p>Gedung Intermark Indonesia</p>
                <p>Jl. Lkr. Tim. No.9, Rw. Mekar Jaya,</p>
                <p>Kec. Serpong, Kota Tangerang Selatan, Banten 15310</p>
            </div>
        </div>

        <div class="section">
            <div class="row">
                <div class="label">Date</div><div>:</div><div class="value">{{ $date2 }}</div>
            </div>
            <div class="row">
                <div class="label">Tanda Terima No.</div><div>:</div><div class="value">{{ $nomor_full }}</div>
            </div>
        </div>

        <div class="section">
            <p><strong>To:</strong></p>
            <p><strong>{{ $client }}</strong></p>
            <p>{!! $client_address !!}</p>
        </div>

        <table>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price (IDR)</th>
                <th>Amount (IDR)</th>
            </tr>
            @php $total = 0; @endphp
            @foreach ($data as $item)
    @php
    $value_kendaraan = isset($item->vehicleid)
        ? ($item->vehicleid == 1 ? 'Mobil' : 'Motor')
        : 'Tidak diketahui';

    $nopollist = $item->vehicle_nos->take(5); 
    $showNopolList = $item->qty <= 5 && $nopollist->count() > 0;
    
    $addon = $item->newcard;
    $subadd = $item->qty * $item->newcard;

    $sub = $item->qty * $item->biaya;

    $subtotal = $subadd + $sub;
    $total += $subtotal;
@endphp



<tr>
    <td>
        Pembayaran membership {{ $value_kendaraan }} {{ $date }}<br>
        @if($showNopolList)
    No Polisi Terlampir:
    <ul>
        @foreach ($nopollist as $nopol)
            <li>{{ $nopol }}</li>
        @endforeach
    </ul>
<!-- @elseif($addon == 1)
    <em>No Polisi Terlampir Terpisah.</em>
        @endif -->
    </td>
    <td style="text-align:center;">{{ $item->qty }}</td>
    <td>Rp {{ number_format($item->biaya, 0, ',', '.') }}</td>
    <td>Rp {{ number_format($sub, 0, ',', '.') }}</td>
</tr>
@if($addon > 0)
<tr>
    <td>
        Additional Charge <br>
        @if($addon)
    <ul>
        <li>Pembuatan Kartu Baru Untuk {{ $value_kendaraan }}</li>
    </ul>
        @endif
    </td>
    <td style="text-align:center;">{{ $item->qty }}</td>
    <td>Rp {{ number_format($item->newcard , 0, ',', '.') }}</td>
    <td>Rp {{ number_format($subadd, 0, ',', '.') }}</td>
</tr>
@endif

@endforeach
            <tr>
                <td colspan="3" style="text-align: right;"><strong>TOTAL</strong></td>
                <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
        </table>

        <div class="amount-in-words">
            {{ ucwords(terbilang($total)) }} Rupiah
        </div>

        <div class="signature">
            <p>Authorised Signed,</p><br><br><br>
            <p>Admin Otto Intermark</p>
        </div>

        <div style="clear: both;"></div>

        <div style="page-break-after: always;"></div>

        </body>
        </html>

        <div style="page-break-after: always;"></div>
    @endforeach
@endif
