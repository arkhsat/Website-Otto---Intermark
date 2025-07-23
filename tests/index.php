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
            float: right;
            margin-top: 30px;
            text-align: center;
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


    </style>
</head>
<body>

<?php
$date = date("d-M-y");
$invoice_no = "Otto-member/intrmk/001/V/2025";
$client = "PT.CIRKLE-K";
$client_address = "Gedung Intermark Indonesia<br>Jl. Lkr. Tim. No.9, Rw. Mekar Jaya,<br>Kec. Serpong, Kota Tangerang Selatan, Banten 15310";

$description = "Pembayaran membership motor juni<br>no polisi terlampir";
$quantity = $_GET['qty'];
$price = 80000;
$total = $quantity * $price;
?>

<div class="header">
    <div class="left">
        <img src="Logo Utama.png" alt="Otto Parking Logo" class="logo-img">
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
        <div class="label">Date</div>
        <div class="colon">:</div>
        <div class="value"><?= $date ?></div>
    </div>
    <div class="row">
        <div class="label">Tanda Terima No.</div>
        <div class="colon">:</div>
        <div class="value"><?= $invoice_no ?></div>
    </div>
</div>


<div class="section">
    <p><strong>To:</strong></p>
    <p><strong><?= $client ?></strong></p>
    <p><?= $client_address ?></p>
</div>

<table>
    <tr>
        <th>Description</th>
        <th>Quantity</th>
        <th>Unit Price (IDR)</th>
        <th>Amount (IDR)</th>
    </tr>
    <tr>
        <td><?= $description ?></td>
        <td><?= $quantity ?></td>
        <td>Rp <?= number_format($price, 0, ',', '.') ?></td>
        <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
    </tr>
   <tr class="subtotal-row">
    <td class="no-border" colspan="3" style="text-align: right;"><strong>SUBTOTAL</strong></td>
    <td><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
</tr>
<tr class="subtotal-row">
    <td class="no-border" colspan="3" style="text-align: right;"><strong>TOTAL</strong></td>
    <td><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
</tr>
</table>

<div class="amount-in-words">
    <?= ucwords(terbilang($total)) ?> Rupiah
</div>

<!-- <div class="bank-info">
    <p><strong>Please transfer to</strong></p>
    <p>PT Metro Tekno Media Infranusantara</p>
    <p>Bank Mandiri</p>
    <p>A/C 104.000.5874.214</p>
</div> -->

<div class="signature">
    <p>Authorised Signed,</p>
    <br><br><br>
    <p>Admin Otto Intermark</p>
</div>

</body>
</html>

<?php
// Fungsi konversi angka ke huruf sederhana (versi pendek)
function terbilang($angka) {
    $angka = abs($angka);
    $baca = array("", " Satu", " Dua", " Tiga", " Empat", " Lima", " Enam", " Tujuh", " Delapan", " Sembilan", " Sepuluh", " Sebelas");
    $terbilang = "";

    if ($angka < 12) {
        $terbilang = " " . $baca[$angka];
    } elseif ($angka < 20) {
        $terbilang = terbilang($angka - 10) . " belas";
    } elseif ($angka < 100) {
        $terbilang = terbilang(intval($angka / 10)) . " puluh" . terbilang($angka % 10);
    } elseif ($angka < 200) {
        $terbilang = " seratus" . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        $terbilang = terbilang(intval($angka / 100)) . " ratus " . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        $terbilang = " seribu" . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        $terbilang = terbilang(intval($angka / 1000)) . " ribu" . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        $terbilang = terbilang(intval($angka / 1000000)) . " juta" . terbilang($angka % 1000000);
    }

    return trim($terbilang);
}
?>
