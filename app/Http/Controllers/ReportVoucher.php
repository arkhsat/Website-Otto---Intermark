<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportVoucherExports;


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
        $hour_out = DB::select("
            SELECT
                DATE(timeout) AS tanggal,
                COUNT(timeout) AS total,
                SUM(CASE WHEN HOUR(timeout) = 0 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam0_mobil,
                SUM(CASE WHEN HOUR(timeout) = 0 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam0_motor,
                SUM(CASE WHEN HOUR(timeout) = 0 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam0_truck,
                SUM(CASE WHEN HOUR(timeout) = 1 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam1_mobil,
                SUM(CASE WHEN HOUR(timeout) = 1 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam1_motor,
                SUM(CASE WHEN HOUR(timeout) = 1 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam1_truck,
                SUM(CASE WHEN HOUR(timeout) = 2 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam2_mobil,
                SUM(CASE WHEN HOUR(timeout) = 2 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam2_motor,
                SUM(CASE WHEN HOUR(timeout) = 2 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam2_truck,
                SUM(CASE WHEN HOUR(timeout) = 3 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam3_mobil,
                SUM(CASE WHEN HOUR(timeout) = 3 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam3_motor,
                SUM(CASE WHEN HOUR(timeout) = 3 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam3_truck,
                SUM(CASE WHEN HOUR(timeout) = 4 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam4_mobil,
                SUM(CASE WHEN HOUR(timeout) = 4 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam4_motor,
                SUM(CASE WHEN HOUR(timeout) = 4 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam4_truck,
                SUM(CASE WHEN HOUR(timeout) = 5 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam5_mobil,
                SUM(CASE WHEN HOUR(timeout) = 5 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam5_motor,
                SUM(CASE WHEN HOUR(timeout) = 5 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam5_truck,
                SUM(CASE WHEN HOUR(timeout) = 6 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam6_mobil,
                SUM(CASE WHEN HOUR(timeout) = 6 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam6_motor,
                SUM(CASE WHEN HOUR(timeout) = 6 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam6_truck,
                SUM(CASE WHEN HOUR(timeout) = 7 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam7_mobil,
                SUM(CASE WHEN HOUR(timeout) = 7 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam7_motor,
                SUM(CASE WHEN HOUR(timeout) = 7 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam7_truck,
                SUM(CASE WHEN HOUR(timeout) = 8 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam8_mobil,
                SUM(CASE WHEN HOUR(timeout) = 8 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam8_motor,
                SUM(CASE WHEN HOUR(timeout) = 8 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam8_truck,
                SUM(CASE WHEN HOUR(timeout) = 9 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam9_mobil,
                SUM(CASE WHEN HOUR(timeout) = 9 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam9_motor,
                SUM(CASE WHEN HOUR(timeout) = 9 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam9_truck,
                SUM(CASE WHEN HOUR(timeout) = 10 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam10_mobil,
                SUM(CASE WHEN HOUR(timeout) = 10 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam10_motor,
                SUM(CASE WHEN HOUR(timeout) = 10 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam10_truck,
                SUM(CASE WHEN HOUR(timeout) = 11 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam11_mobil,
                SUM(CASE WHEN HOUR(timeout) = 11 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam11_motor,
                SUM(CASE WHEN HOUR(timeout) = 11 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam11_truck,
                SUM(CASE WHEN HOUR(timeout) = 12 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam12_mobil,
                SUM(CASE WHEN HOUR(timeout) = 12 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam12_motor,
                SUM(CASE WHEN HOUR(timeout) = 12 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam12_truck,
                SUM(CASE WHEN HOUR(timeout) = 13 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam13_mobil,
                SUM(CASE WHEN HOUR(timeout) = 13 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam13_motor,
                SUM(CASE WHEN HOUR(timeout) = 13 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam13_truck,
                SUM(CASE WHEN HOUR(timeout) = 14 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam14_mobil,
                SUM(CASE WHEN HOUR(timeout) = 14 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam14_motor,
                SUM(CASE WHEN HOUR(timeout) = 14 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam14_truck,
                SUM(CASE WHEN HOUR(timeout) = 15 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam15_mobil,
                SUM(CASE WHEN HOUR(timeout) = 15 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam15_motor,
                SUM(CASE WHEN HOUR(timeout) = 15 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam15_truck,
                SUM(CASE WHEN HOUR(timeout) = 16 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam16_mobil,
                SUM(CASE WHEN HOUR(timeout) = 16 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam16_motor,
                SUM(CASE WHEN HOUR(timeout) = 16 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam16_truck,
                SUM(CASE WHEN HOUR(timeout) = 17 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam17_mobil,
                SUM(CASE WHEN HOUR(timeout) = 17 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam17_motor,
                SUM(CASE WHEN HOUR(timeout) = 17 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam17_truck,
                SUM(CASE WHEN HOUR(timeout) = 18 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam18_mobil,
                SUM(CASE WHEN HOUR(timeout) = 18 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam18_motor,
                SUM(CASE WHEN HOUR(timeout) = 18 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam18_truck,
                SUM(CASE WHEN HOUR(timeout) = 19 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam19_mobil,
                SUM(CASE WHEN HOUR(timeout) = 19 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam19_motor,
                SUM(CASE WHEN HOUR(timeout) = 19 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam19_truck,
                SUM(CASE WHEN HOUR(timeout) = 20 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam20_mobil,
                SUM(CASE WHEN HOUR(timeout) = 20 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam20_motor,
                SUM(CASE WHEN HOUR(timeout) = 20 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam20_truck,
                SUM(CASE WHEN HOUR(timeout) = 21 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam21_mobil,
                SUM(CASE WHEN HOUR(timeout) = 21 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam21_motor,
                SUM(CASE WHEN HOUR(timeout) = 21 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam21_truck,
                SUM(CASE WHEN HOUR(timeout) = 22 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam22_mobil,
                SUM(CASE WHEN HOUR(timeout) = 22 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam22_motor,
                SUM(CASE WHEN HOUR(timeout) = 22 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam22_truck,
                SUM(CASE WHEN HOUR(timeout) = 23 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam23_mobil,
                SUM(CASE WHEN HOUR(timeout) = 23 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam23_motor,
                SUM(CASE WHEN HOUR(timeout) = 23 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam23_truck
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND vehicleid IN ('Mobil')
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            AND settlementreport like 'VC%'
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ",[$startDate, $endDate]);

        return view('reportvoucher.index',compact('hour_out', 'startDate', 'endDate'));
    }

    public function downloadPDF(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
        SELECT
                DATE(timeout) AS tanggal,
                COUNT(timeout) AS total,
                SUM(CASE WHEN HOUR(timeout) = 0 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam0_mobil,
                SUM(CASE WHEN HOUR(timeout) = 0 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam0_motor,
                SUM(CASE WHEN HOUR(timeout) = 0 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam0_truck,
                SUM(CASE WHEN HOUR(timeout) = 1 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam1_mobil,
                SUM(CASE WHEN HOUR(timeout) = 1 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam1_motor,
                SUM(CASE WHEN HOUR(timeout) = 1 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam1_truck,
                SUM(CASE WHEN HOUR(timeout) = 2 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam2_mobil,
                SUM(CASE WHEN HOUR(timeout) = 2 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam2_motor,
                SUM(CASE WHEN HOUR(timeout) = 2 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam2_truck,
                SUM(CASE WHEN HOUR(timeout) = 3 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam3_mobil,
                SUM(CASE WHEN HOUR(timeout) = 3 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam3_motor,
                SUM(CASE WHEN HOUR(timeout) = 3 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam3_truck,
                SUM(CASE WHEN HOUR(timeout) = 4 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam4_mobil,
                SUM(CASE WHEN HOUR(timeout) = 4 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam4_motor,
                SUM(CASE WHEN HOUR(timeout) = 4 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam4_truck,
                SUM(CASE WHEN HOUR(timeout) = 5 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam5_mobil,
                SUM(CASE WHEN HOUR(timeout) = 5 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam5_motor,
                SUM(CASE WHEN HOUR(timeout) = 5 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam5_truck,
                SUM(CASE WHEN HOUR(timeout) = 6 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam6_mobil,
                SUM(CASE WHEN HOUR(timeout) = 6 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam6_motor,
                SUM(CASE WHEN HOUR(timeout) = 6 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam6_truck,
                SUM(CASE WHEN HOUR(timeout) = 7 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam7_mobil,
                SUM(CASE WHEN HOUR(timeout) = 7 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam7_motor,
                SUM(CASE WHEN HOUR(timeout) = 7 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam7_truck,
                SUM(CASE WHEN HOUR(timeout) = 8 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam8_mobil,
                SUM(CASE WHEN HOUR(timeout) = 8 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam8_motor,
                SUM(CASE WHEN HOUR(timeout) = 8 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam8_truck,
                SUM(CASE WHEN HOUR(timeout) = 9 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam9_mobil,
                SUM(CASE WHEN HOUR(timeout) = 9 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam9_motor,
                SUM(CASE WHEN HOUR(timeout) = 9 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam9_truck,
                SUM(CASE WHEN HOUR(timeout) = 10 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam10_mobil,
                SUM(CASE WHEN HOUR(timeout) = 10 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam10_motor,
                SUM(CASE WHEN HOUR(timeout) = 10 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam10_truck,
                SUM(CASE WHEN HOUR(timeout) = 11 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam11_mobil,
                SUM(CASE WHEN HOUR(timeout) = 11 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam11_motor,
                SUM(CASE WHEN HOUR(timeout) = 11 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam11_truck,
                SUM(CASE WHEN HOUR(timeout) = 12 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam12_mobil,
                SUM(CASE WHEN HOUR(timeout) = 12 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam12_motor,
                SUM(CASE WHEN HOUR(timeout) = 12 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam12_truck,
                SUM(CASE WHEN HOUR(timeout) = 13 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam13_mobil,
                SUM(CASE WHEN HOUR(timeout) = 13 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam13_motor,
                SUM(CASE WHEN HOUR(timeout) = 13 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam13_truck,
                SUM(CASE WHEN HOUR(timeout) = 14 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam14_mobil,
                SUM(CASE WHEN HOUR(timeout) = 14 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam14_motor,
                SUM(CASE WHEN HOUR(timeout) = 14 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam14_truck,
                SUM(CASE WHEN HOUR(timeout) = 15 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam15_mobil,
                SUM(CASE WHEN HOUR(timeout) = 15 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam15_motor,
                SUM(CASE WHEN HOUR(timeout) = 15 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam15_truck,
                SUM(CASE WHEN HOUR(timeout) = 16 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam16_mobil,
                SUM(CASE WHEN HOUR(timeout) = 16 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam16_motor,
                SUM(CASE WHEN HOUR(timeout) = 16 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam16_truck,
                SUM(CASE WHEN HOUR(timeout) = 17 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam17_mobil,
                SUM(CASE WHEN HOUR(timeout) = 17 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam17_motor,
                SUM(CASE WHEN HOUR(timeout) = 17 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam17_truck,
                SUM(CASE WHEN HOUR(timeout) = 18 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam18_mobil,
                SUM(CASE WHEN HOUR(timeout) = 18 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam18_motor,
                SUM(CASE WHEN HOUR(timeout) = 18 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam18_truck,
                SUM(CASE WHEN HOUR(timeout) = 19 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam19_mobil,
                SUM(CASE WHEN HOUR(timeout) = 19 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam19_motor,
                SUM(CASE WHEN HOUR(timeout) = 19 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam19_truck,
                SUM(CASE WHEN HOUR(timeout) = 20 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam20_mobil,
                SUM(CASE WHEN HOUR(timeout) = 20 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam20_motor,
                SUM(CASE WHEN HOUR(timeout) = 20 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam20_truck,
                SUM(CASE WHEN HOUR(timeout) = 21 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam21_mobil,
                SUM(CASE WHEN HOUR(timeout) = 21 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam21_motor,
                SUM(CASE WHEN HOUR(timeout) = 21 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam21_truck,
                SUM(CASE WHEN HOUR(timeout) = 22 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam22_mobil,
                SUM(CASE WHEN HOUR(timeout) = 22 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam22_motor,
                SUM(CASE WHEN HOUR(timeout) = 22 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam22_truck,
                SUM(CASE WHEN HOUR(timeout) = 23 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam23_mobil,
                SUM(CASE WHEN HOUR(timeout) = 23 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam23_motor,
                SUM(CASE WHEN HOUR(timeout) = 23 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam23_truck
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND vehicleid IN ('Mobil')
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            AND settlementreport like 'VC%'
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ", [$startDate, $endDate]);
    
        if ($startDate == $endDate) {
            $fileName = config('app.location'). ' - Report Transaksi Close By ON ' . date('d F Y', strtotime($startDate)) . '.pdf';
        } else {
            $fileName = config('app.location'). ' - Report Transaksi Close By ON ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.pdf';
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
                SUM(CASE WHEN HOUR(timeout) = 0 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam0_mobil,
                SUM(CASE WHEN HOUR(timeout) = 0 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam0_motor,
                SUM(CASE WHEN HOUR(timeout) = 0 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam0_truck,
                SUM(CASE WHEN HOUR(timeout) = 1 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam1_mobil,
                SUM(CASE WHEN HOUR(timeout) = 1 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam1_motor,
                SUM(CASE WHEN HOUR(timeout) = 1 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam1_truck,
                SUM(CASE WHEN HOUR(timeout) = 2 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam2_mobil,
                SUM(CASE WHEN HOUR(timeout) = 2 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam2_motor,
                SUM(CASE WHEN HOUR(timeout) = 2 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam2_truck,
                SUM(CASE WHEN HOUR(timeout) = 3 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam3_mobil,
                SUM(CASE WHEN HOUR(timeout) = 3 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam3_motor,
                SUM(CASE WHEN HOUR(timeout) = 3 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam3_truck,
                SUM(CASE WHEN HOUR(timeout) = 4 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam4_mobil,
                SUM(CASE WHEN HOUR(timeout) = 4 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam4_motor,
                SUM(CASE WHEN HOUR(timeout) = 4 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam4_truck,
                SUM(CASE WHEN HOUR(timeout) = 5 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam5_mobil,
                SUM(CASE WHEN HOUR(timeout) = 5 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam5_motor,
                SUM(CASE WHEN HOUR(timeout) = 5 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam5_truck,
                SUM(CASE WHEN HOUR(timeout) = 6 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam6_mobil,
                SUM(CASE WHEN HOUR(timeout) = 6 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam6_motor,
                SUM(CASE WHEN HOUR(timeout) = 6 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam6_truck,
                SUM(CASE WHEN HOUR(timeout) = 7 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam7_mobil,
                SUM(CASE WHEN HOUR(timeout) = 7 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam7_motor,
                SUM(CASE WHEN HOUR(timeout) = 7 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam7_truck,
                SUM(CASE WHEN HOUR(timeout) = 8 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam8_mobil,
                SUM(CASE WHEN HOUR(timeout) = 8 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam8_motor,
                SUM(CASE WHEN HOUR(timeout) = 8 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam8_truck,
                SUM(CASE WHEN HOUR(timeout) = 9 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam9_mobil,
                SUM(CASE WHEN HOUR(timeout) = 9 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam9_motor,
                SUM(CASE WHEN HOUR(timeout) = 9 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam9_truck,
                SUM(CASE WHEN HOUR(timeout) = 10 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam10_mobil,
                SUM(CASE WHEN HOUR(timeout) = 10 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam10_motor,
                SUM(CASE WHEN HOUR(timeout) = 10 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam10_truck,
                SUM(CASE WHEN HOUR(timeout) = 11 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam11_mobil,
                SUM(CASE WHEN HOUR(timeout) = 11 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam11_motor,
                SUM(CASE WHEN HOUR(timeout) = 11 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam11_truck,
                SUM(CASE WHEN HOUR(timeout) = 12 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam12_mobil,
                SUM(CASE WHEN HOUR(timeout) = 12 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam12_motor,
                SUM(CASE WHEN HOUR(timeout) = 12 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam12_truck,
                SUM(CASE WHEN HOUR(timeout) = 13 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam13_mobil,
                SUM(CASE WHEN HOUR(timeout) = 13 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam13_motor,
                SUM(CASE WHEN HOUR(timeout) = 13 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam13_truck,
                SUM(CASE WHEN HOUR(timeout) = 14 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam14_mobil,
                SUM(CASE WHEN HOUR(timeout) = 14 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam14_motor,
                SUM(CASE WHEN HOUR(timeout) = 14 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam14_truck,
                SUM(CASE WHEN HOUR(timeout) = 15 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam15_mobil,
                SUM(CASE WHEN HOUR(timeout) = 15 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam15_motor,
                SUM(CASE WHEN HOUR(timeout) = 15 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam15_truck,
                SUM(CASE WHEN HOUR(timeout) = 16 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam16_mobil,
                SUM(CASE WHEN HOUR(timeout) = 16 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam16_motor,
                SUM(CASE WHEN HOUR(timeout) = 16 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam16_truck,
                SUM(CASE WHEN HOUR(timeout) = 17 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam17_mobil,
                SUM(CASE WHEN HOUR(timeout) = 17 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam17_motor,
                SUM(CASE WHEN HOUR(timeout) = 17 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam17_truck,
                SUM(CASE WHEN HOUR(timeout) = 18 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam18_mobil,
                SUM(CASE WHEN HOUR(timeout) = 18 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam18_motor,
                SUM(CASE WHEN HOUR(timeout) = 18 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam18_truck,
                SUM(CASE WHEN HOUR(timeout) = 19 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam19_mobil,
                SUM(CASE WHEN HOUR(timeout) = 19 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam19_motor,
                SUM(CASE WHEN HOUR(timeout) = 19 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam19_truck,
                SUM(CASE WHEN HOUR(timeout) = 20 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam20_mobil,
                SUM(CASE WHEN HOUR(timeout) = 20 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam20_motor,
                SUM(CASE WHEN HOUR(timeout) = 20 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam20_truck,
                SUM(CASE WHEN HOUR(timeout) = 21 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam21_mobil,
                SUM(CASE WHEN HOUR(timeout) = 21 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam21_motor,
                SUM(CASE WHEN HOUR(timeout) = 21 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam21_truck,
                SUM(CASE WHEN HOUR(timeout) = 22 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam22_mobil,
                SUM(CASE WHEN HOUR(timeout) = 22 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam22_motor,
                SUM(CASE WHEN HOUR(timeout) = 22 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam22_truck,
                SUM(CASE WHEN HOUR(timeout) = 23 and vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS jam23_mobil,
                SUM(CASE WHEN HOUR(timeout) = 23 and vehicleid = 'Motor' THEN 1 ELSE 0 END) AS jam23_motor,
                SUM(CASE WHEN HOUR(timeout) = 23 and vehicleid = 'Truck' THEN 1 ELSE 0 END) AS jam23_truck
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
            $fileName = config('app.location'). ' - Report Transaksi Close By ON ' . date('d F Y', strtotime($startDate)) . '.xlsx';
        } else {
            $fileName = config('app.location'). ' - Report Transaksi Close By ON ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.xlsx';
        }
    
        return Excel::download(new ReportVoucherExports ($results, $startDate, $endDate, $judul), $fileName);
    }


    
}
