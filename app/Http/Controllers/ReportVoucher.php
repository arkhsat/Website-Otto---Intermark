<?php

namespace App\Http\Controllers;

use App\Exports\ReportTransaksiCloseByON;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportPerpanjangMember;

class ReportVoucher extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        // Untuk True Blue
        // $results = DB::select("
        // SELECT * FROM transactions WHERE timeout IS NOT NULL AND paymentby IS NULL 
        // AND DATE(dateout) BETWEEN ? AND ?
        //     ",[$startDate, $endDate]);
        // return view('report.voucher.index',compact(var_name: 'results', 'startDate', 'endDate'));

        
        // Untuk Gelael
        $car_hour_out = DB::select("
            SELECT
                DATE(timeout) AS tanggal,
                COUNT(timeout) AS total,
                SUM(CASE WHEN HOUR(timeout) = 0 THEN 1 ELSE 0 END) AS jam0,
                SUM(CASE WHEN HOUR(timeout) = 1 THEN 1 ELSE 0 END) AS jam1,
                SUM(CASE WHEN HOUR(timeout) = 2 THEN 1 ELSE 0 END) AS jam2,
                SUM(CASE WHEN HOUR(timeout) = 3 THEN 1 ELSE 0 END) AS jam3,
                SUM(CASE WHEN HOUR(timeout) = 4 THEN 1 ELSE 0 END) AS jam4,
                SUM(CASE WHEN HOUR(timeout) = 5 THEN 1 ELSE 0 END) AS jam5,
                SUM(CASE WHEN HOUR(timeout) = 6 THEN 1 ELSE 0 END) AS jam6,
                SUM(CASE WHEN HOUR(timeout) = 7 THEN 1 ELSE 0 END) AS jam7,
                SUM(CASE WHEN HOUR(timeout) = 8 THEN 1 ELSE 0 END) AS jam8,
                SUM(CASE WHEN HOUR(timeout) = 9 THEN 1 ELSE 0 END) AS jam9,
                SUM(CASE WHEN HOUR(timeout) = 10 THEN 1 ELSE 0 END) AS jam10,
                SUM(CASE WHEN HOUR(timeout) = 11 THEN 1 ELSE 0 END) AS jam11,
                SUM(CASE WHEN HOUR(timeout) = 12 THEN 1 ELSE 0 END) AS jam12,
                SUM(CASE WHEN HOUR(timeout) = 13 THEN 1 ELSE 0 END) AS jam13,
                SUM(CASE WHEN HOUR(timeout) = 14 THEN 1 ELSE 0 END) AS jam14,
                SUM(CASE WHEN HOUR(timeout) = 15 THEN 1 ELSE 0 END) AS jam15,
                SUM(CASE WHEN HOUR(timeout) = 16 THEN 1 ELSE 0 END) AS jam16,
                SUM(CASE WHEN HOUR(timeout) = 17 THEN 1 ELSE 0 END) AS jam17,
                SUM(CASE WHEN HOUR(timeout) = 18 THEN 1 ELSE 0 END) AS jam18,
                SUM(CASE WHEN HOUR(timeout) = 19 THEN 1 ELSE 0 END) AS jam19,
                SUM(CASE WHEN HOUR(timeout) = 20 THEN 1 ELSE 0 END) AS jam20,
                SUM(CASE WHEN HOUR(timeout) = 21 THEN 1 ELSE 0 END) AS jam21,
                SUM(CASE WHEN HOUR(timeout) = 22 THEN 1 ELSE 0 END) AS jam22,
                SUM(CASE WHEN HOUR(timeout) = 23 THEN 1 ELSE 0 END) AS jam23
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND vehicleid IN ('Mobil')
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            AND settlementreport like 'VC%'
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ",[$startDate, $endDate]);

        $truck_hour_out = DB::select("
            SELECT
                DATE(timeout) AS tanggal,
                COUNT(timeout) AS total,
                SUM(CASE WHEN HOUR(timeout) = 0 THEN 1 ELSE 0 END) AS jam0,
                SUM(CASE WHEN HOUR(timeout) = 1 THEN 1 ELSE 0 END) AS jam1,
                SUM(CASE WHEN HOUR(timeout) = 2 THEN 1 ELSE 0 END) AS jam2,
                SUM(CASE WHEN HOUR(timeout) = 3 THEN 1 ELSE 0 END) AS jam3,
                SUM(CASE WHEN HOUR(timeout) = 4 THEN 1 ELSE 0 END) AS jam4,
                SUM(CASE WHEN HOUR(timeout) = 5 THEN 1 ELSE 0 END) AS jam5,
                SUM(CASE WHEN HOUR(timeout) = 6 THEN 1 ELSE 0 END) AS jam6,
                SUM(CASE WHEN HOUR(timeout) = 7 THEN 1 ELSE 0 END) AS jam7,
                SUM(CASE WHEN HOUR(timeout) = 8 THEN 1 ELSE 0 END) AS jam8,
                SUM(CASE WHEN HOUR(timeout) = 9 THEN 1 ELSE 0 END) AS jam9,
                SUM(CASE WHEN HOUR(timeout) = 10 THEN 1 ELSE 0 END) AS jam10,
                SUM(CASE WHEN HOUR(timeout) = 11 THEN 1 ELSE 0 END) AS jam11,
                SUM(CASE WHEN HOUR(timeout) = 12 THEN 1 ELSE 0 END) AS jam12,
                SUM(CASE WHEN HOUR(timeout) = 13 THEN 1 ELSE 0 END) AS jam13,
                SUM(CASE WHEN HOUR(timeout) = 14 THEN 1 ELSE 0 END) AS jam14,
                SUM(CASE WHEN HOUR(timeout) = 15 THEN 1 ELSE 0 END) AS jam15,
                SUM(CASE WHEN HOUR(timeout) = 16 THEN 1 ELSE 0 END) AS jam16,
                SUM(CASE WHEN HOUR(timeout) = 17 THEN 1 ELSE 0 END) AS jam17,
                SUM(CASE WHEN HOUR(timeout) = 18 THEN 1 ELSE 0 END) AS jam18,
                SUM(CASE WHEN HOUR(timeout) = 19 THEN 1 ELSE 0 END) AS jam19,
                SUM(CASE WHEN HOUR(timeout) = 20 THEN 1 ELSE 0 END) AS jam20,
                SUM(CASE WHEN HOUR(timeout) = 21 THEN 1 ELSE 0 END) AS jam21,
                SUM(CASE WHEN HOUR(timeout) = 22 THEN 1 ELSE 0 END) AS jam22,
                SUM(CASE WHEN HOUR(timeout) = 23 THEN 1 ELSE 0 END) AS jam23
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND vehicleid IN ('Truck')
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            AND settlementreport like 'VC%'
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ",[$startDate, $endDate]);

        return view('report.voucher.index',compact('car_hour_out', 'truck_hour_out', 'startDate', 'endDate'));
    }

    public function downloadPDF(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
        SELECT
            SELECT
                DATE(timeout) AS tanggal,
                COUNT(timeout) AS total,
                SUM(CASE WHEN HOUR(timeout) = 0 THEN 1 ELSE 0 END) AS jam0,
                SUM(CASE WHEN HOUR(timeout) = 1 THEN 1 ELSE 0 END) AS jam1,
                SUM(CASE WHEN HOUR(timeout) = 2 THEN 1 ELSE 0 END) AS jam2,
                SUM(CASE WHEN HOUR(timeout) = 3 THEN 1 ELSE 0 END) AS jam3,
                SUM(CASE WHEN HOUR(timeout) = 4 THEN 1 ELSE 0 END) AS jam4,
                SUM(CASE WHEN HOUR(timeout) = 5 THEN 1 ELSE 0 END) AS jam5,
                SUM(CASE WHEN HOUR(timeout) = 6 THEN 1 ELSE 0 END) AS jam6,
                SUM(CASE WHEN HOUR(timeout) = 7 THEN 1 ELSE 0 END) AS jam7,
                SUM(CASE WHEN HOUR(timeout) = 8 THEN 1 ELSE 0 END) AS jam8,
                SUM(CASE WHEN HOUR(timeout) = 9 THEN 1 ELSE 0 END) AS jam9,
                SUM(CASE WHEN HOUR(timeout) = 10 THEN 1 ELSE 0 END) AS jam10,
                SUM(CASE WHEN HOUR(timeout) = 11 THEN 1 ELSE 0 END) AS jam11,
                SUM(CASE WHEN HOUR(timeout) = 12 THEN 1 ELSE 0 END) AS jam12,
                SUM(CASE WHEN HOUR(timeout) = 13 THEN 1 ELSE 0 END) AS jam13,
                SUM(CASE WHEN HOUR(timeout) = 14 THEN 1 ELSE 0 END) AS jam14,
                SUM(CASE WHEN HOUR(timeout) = 15 THEN 1 ELSE 0 END) AS jam15,
                SUM(CASE WHEN HOUR(timeout) = 16 THEN 1 ELSE 0 END) AS jam16,
                SUM(CASE WHEN HOUR(timeout) = 17 THEN 1 ELSE 0 END) AS jam17,
                SUM(CASE WHEN HOUR(timeout) = 18 THEN 1 ELSE 0 END) AS jam18,
                SUM(CASE WHEN HOUR(timeout) = 19 THEN 1 ELSE 0 END) AS jam19,
                SUM(CASE WHEN HOUR(timeout) = 20 THEN 1 ELSE 0 END) AS jam20,
                SUM(CASE WHEN HOUR(timeout) = 21 THEN 1 ELSE 0 END) AS jam21,
                SUM(CASE WHEN HOUR(timeout) = 22 THEN 1 ELSE 0 END) AS jam22,
                SUM(CASE WHEN HOUR(timeout) = 23 THEN 1 ELSE 0 END) AS jam23
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND vehicleid IN ('Mobil')
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            AND settlementreport like 'VC%'
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ", [$startDate, $endDate]);
    
        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report Transaksi Close By ON ' . date('d F Y', strtotime($startDate)) . '.pdf';
        } else {
            $fileName = 'Intermark - Report Transaksi Close By ON ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.pdf';
        }
        $judul = 'Laporan Transaksi Close By ON';
        $pdf = Pdf::loadView('PDF/pdfreportcloseON', compact('results', 'startDate', 'endDate', 'judul'));
        $pdf->getDomPDF()->set_option("isRemoteEnabled", true);

        return $pdf->download($fileName);
    }

    public function downloadExcel(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
            SELECT
                DATE(timeout) AS tanggal,
                COUNT(timeout) AS total,
                SUM(CASE WHEN HOUR(timeout) = 0 THEN 1 ELSE 0 END) AS jam0,
                SUM(CASE WHEN HOUR(timeout) = 1 THEN 1 ELSE 0 END) AS jam1,
                SUM(CASE WHEN HOUR(timeout) = 2 THEN 1 ELSE 0 END) AS jam2,
                SUM(CASE WHEN HOUR(timeout) = 3 THEN 1 ELSE 0 END) AS jam3,
                SUM(CASE WHEN HOUR(timeout) = 4 THEN 1 ELSE 0 END) AS jam4,
                SUM(CASE WHEN HOUR(timeout) = 5 THEN 1 ELSE 0 END) AS jam5,
                SUM(CASE WHEN HOUR(timeout) = 6 THEN 1 ELSE 0 END) AS jam6,
                SUM(CASE WHEN HOUR(timeout) = 7 THEN 1 ELSE 0 END) AS jam7,
                SUM(CASE WHEN HOUR(timeout) = 8 THEN 1 ELSE 0 END) AS jam8,
                SUM(CASE WHEN HOUR(timeout) = 9 THEN 1 ELSE 0 END) AS jam9,
                SUM(CASE WHEN HOUR(timeout) = 10 THEN 1 ELSE 0 END) AS jam10,
                SUM(CASE WHEN HOUR(timeout) = 11 THEN 1 ELSE 0 END) AS jam11,
                SUM(CASE WHEN HOUR(timeout) = 12 THEN 1 ELSE 0 END) AS jam12,
                SUM(CASE WHEN HOUR(timeout) = 13 THEN 1 ELSE 0 END) AS jam13,
                SUM(CASE WHEN HOUR(timeout) = 14 THEN 1 ELSE 0 END) AS jam14,
                SUM(CASE WHEN HOUR(timeout) = 15 THEN 1 ELSE 0 END) AS jam15,
                SUM(CASE WHEN HOUR(timeout) = 16 THEN 1 ELSE 0 END) AS jam16,
                SUM(CASE WHEN HOUR(timeout) = 17 THEN 1 ELSE 0 END) AS jam17,
                SUM(CASE WHEN HOUR(timeout) = 18 THEN 1 ELSE 0 END) AS jam18,
                SUM(CASE WHEN HOUR(timeout) = 19 THEN 1 ELSE 0 END) AS jam19,
                SUM(CASE WHEN HOUR(timeout) = 20 THEN 1 ELSE 0 END) AS jam20,
                SUM(CASE WHEN HOUR(timeout) = 21 THEN 1 ELSE 0 END) AS jam21,
                SUM(CASE WHEN HOUR(timeout) = 22 THEN 1 ELSE 0 END) AS jam22,
                SUM(CASE WHEN HOUR(timeout) = 23 THEN 1 ELSE 0 END) AS jam23
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND vehicleid IN ('Mobil')
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            AND settlementreport like 'VC%'
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ", [$startDate, $endDate]);
    
        $judul = 'Laporan Transaksi Close By ON';

        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report Transaksi Close By ON ' . date('d F Y', strtotime($startDate)) . '.xlsx';
        } else {
            $fileName = 'Intermark - Report Transaksi Close By ON ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.xlsx';
        }
    
        return Excel::download(new ReportTransaksiCloseByON ($results, $startDate, $endDate, $judul), $fileName);
    }


    
}
