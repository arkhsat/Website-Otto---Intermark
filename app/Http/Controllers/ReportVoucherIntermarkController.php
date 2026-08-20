<?php

namespace App\Http\Controllers;

use App\Exports\ReportIntermarkExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportVoucherIntermarkController extends Controller
{
    public function index()
    {   $reportname = NULL;
        return view('reportvoucher.index-intermark', compact('reportname'));
    }

    // public function dataTrxHotel(Request $request)
    // {
    //     $startDate = $request->input('entry_date', date('Y-m-d'));
    //     $endDate = $request->input('end_date', date('Y-m-d'));
    //     $voucherType = $request->input('voucher_type', 'ALL');
    //     if ($voucherType === 'SBX') {
    //         $voucherCondition = "AND settlementreport LIKE ?";
    //         $voucherParam = 'SBX%';
    //     } elseif ($voucherType === 'SPH') {
    //         $voucherCondition = "AND settlementreport LIKE ?";
    //         $voucherParam = 'SPH%';
    //     } else {
    //         $voucherCondition = "AND settlementreport LIKE ?";
    //         $voucherParam = 'SBX%' OR 'SPH%';
    //     }

    //     $results = DB::select("
    //         SELECT 
    //             DATE(datetransact) AS tanggal,
    //             DATE(dateout) AS tanggal_keluar,
    //             vehicleid AS jenis_kendaraan,
    //             settlementreport AS kode_voucher,
    //             nokartubank AS nomor_kartu,
    //             CASE 
    //                 WHEN nopolisi IS NULL THEN '-' 
    //                 ELSE nopolisi 
    //             END AS nopol
    //         FROM transactions
    //         AND nokartubank IS NOT NULL
    //         AND DATE(datetransact) BETWEEN ? AND ?
    //         $voucherCondition
    //         ORDER BY datetransact
    //     ", [$startDate, $endDate, $voucherParam]);
    //         $reportname = 'Laporan Voucher Intermark';
    //     return view('reportvoucher.index-intermark', compact('results', 'reportname', 'voucherType'));
    // }
    public function dataTrxHotel(Request $request)
    {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $voucherType = $request->input('voucher_type', 'ALL');

        $query = DB::table('transactions')
            ->selectRaw("
                DATE(datetransact) AS tanggal,
                DATE(dateout) AS tanggal_keluar,
                vehicleid AS jenis_kendaraan,
                settlementreport AS kode_voucher,
                nokartubank AS nomor_kartu,
                COALESCE(nopolisi, '-') AS nopol
            ")
            ->whereNotNull('nokartubank')
            ->whereBetween(DB::raw('DATE(datetransact)'), [$startDate, $endDate]);

        if ($voucherType === 'SBX') {
            $query->where('settlementreport', 'LIKE', 'SBX%');
        } elseif ($voucherType === 'SUB') {
            $query->where('settlementreport', 'LIKE', 'SUB%');
        } else {
            $query->where(function ($q) {
                $q->where('settlementreport', 'LIKE', 'SBX%')
                ->orWhere('settlementreport', 'LIKE', 'SUB%');
            });
        }

        $results = $query->orderBy('datetransact')->get();

        $reportname = 'Laporan Voucher Intermark';
        return view('reportvoucher.index-intermark', compact('results', 'reportname', 'voucherType'));
    }
    
    // public function downloadPDF(Request $request)
    // {
    //     $startDate = $request->input('entry_date', date('Y-m-d'));
    //     $endDate = $request->input('end_date', date('Y-m-d'));
    //         $results = DB::select("
    //             SELECT DATE(datetransact) AS tanggal,
    //             DATE(dateout) AS tanggal_keluar, 
    //             vehicleid AS jenis_kendaraan, 
    //             settlementreport AS kode_voucher, 
    //             nokartubank AS nomor_kartu,
    //             CASE WHEN nopolisi IS NULL THEN '-' ELSE nopolisi 
    //             END AS nopol
    //             FROM transactions 
    //             WHERE settlementreport LIKE 'SBW%' or settlementreport LIKE 'STR%'
    //             AND nokartubank IS NOT NULL 
    //             AND DATE(datetransact) BETWEEN ? AND ? 
    //             ORDER BY datetransact", [$startDate, $endDate]);
                
    //     $reportname = 'Laporan Voucher Intermark';
    //     $pdf = PDF::loadView('pdf.pdfreportVoucherIntermark', compact('results', 'reportname', 'startDate', 'endDate'));

    //     if ($startDate == $endDate) {
    //         $fileName = 'Laporan Voucher Intermark ' . date('d F Y', strtotime($startDate)) . '.pdf';
    //     } else {
    //         $fileName = 'Laporan Voucher Intermark ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.pdf';
    //     }


    //     return $pdf->download($fileName);
    // }

    public function downloadPDF(Request $request)
    {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $voucherType = $request->input('voucher_type', 'ALL');

        $query = DB::table('transactions')
            ->selectRaw("
                DATE(datetransact) AS tanggal,
                DATE(dateout) AS tanggal_keluar,
                vehicleid AS jenis_kendaraan,
                settlementreport AS kode_voucher,
                nokartubank AS nomor_kartu,
                COALESCE(nopolisi, '-') AS nopol
            ")
            ->whereNotNull('nokartubank')
            ->whereBetween(
                DB::raw('DATE(datetransact)'),
                [$startDate, $endDate]
            );

        if ($voucherType === 'SBX') {

            $query->where('settlementreport', 'LIKE', 'SBX%');

        } elseif ($voucherType === 'SUB') {

            $query->where('settlementreport', 'LIKE', 'SUB%');

        } else {

            $query->where(function ($q) {
                $q->where('settlementreport', 'LIKE', 'SBX%')
                ->orWhere('settlementreport', 'LIKE', 'SUB%');
            });
        }

        $results = $query
            ->orderBy('datetransact')
            ->get();

        $reportname = 'Laporan Voucher Intermark';

        $pdf = PDF::loadView(
            'pdf.pdfreportVoucherIntermark',
            compact(
                'results',
                'reportname',
                'startDate',
                'endDate',
                'voucherType'
            )
        );

        // Nama voucher
        if ($voucherType === 'SBX') {
            $voucherName = 'Starbucks';
        } elseif ($voucherType === 'SUB') {
            $voucherName = 'Subway';
        } else {
            $voucherName = 'All';
        }

        if ($startDate == $endDate) {
            $fileName = 'Laporan Voucher ' . $voucherName . ' '
                . date('d F Y', strtotime($startDate))
                . '.pdf';
        } else {
            $fileName = 'Laporan Voucher ' . $voucherName . ' '
                . date('d F Y', strtotime($startDate))
                . ' sd '
                . date('d F Y', strtotime($endDate))
                . '.pdf';
        }

        return $pdf->download($fileName);
    }

    public function downloadExcel(Request $request)
    {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $voucherType = $request->input('voucher_type', 'ALL');

        $query = DB::table('transactions')
            ->selectRaw("
                DATE(datetransact) AS tanggal,
                DATE(dateout) AS tanggal_keluar,
                vehicleid AS jenis_kendaraan,
                settlementreport AS kode_voucher,
                nokartubank AS nomor_kartu,
                COALESCE(nopolisi, '-') AS nopol
            ")
            ->whereNotNull('nokartubank')
            ->whereBetween(
                DB::raw('DATE(datetransact)'),
                [$startDate, $endDate]
            );

        if ($voucherType === 'SBX') {

            $query->where('settlementreport', 'LIKE', 'SBX%');

        } elseif ($voucherType === 'SUB') {

            $query->where('settlementreport', 'LIKE', 'SUB%');

        } else {

            $query->where(function ($q) {
                $q->where('settlementreport', 'LIKE', 'SBX%')
                ->orWhere('settlementreport', 'LIKE', 'SUB%');
            });
        }

        $results = $query
            ->orderBy('datetransact')
            ->get();

        if ($voucherType === 'SBX') {
            $voucherName = 'Starbucks';
        } elseif ($voucherType === 'SUB') {
            $voucherName = 'Subway';
        } else {
            $voucherName = 'All';
        }

        $judul = 'Laporan Voucher ' . $voucherName;

        if ($startDate == $endDate) {
            $fileName = $judul . ' '
                . date('d F Y', strtotime($startDate))
                . '.xlsx';
        } else {
            $fileName = $judul . ' '
                . date('d F Y', strtotime($startDate))
                . ' sd '
                . date('d F Y', strtotime($endDate))
                . '.xlsx';
        }

        return Excel::download(
            new ReportIntermarkExport(
                $results,
                $startDate,
                $endDate,
                $judul
            ),
            $fileName
        );
    }
   
}
