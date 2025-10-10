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
        $duration = DB::select("
            SELECT
                DATE(timeout) AS tanggal,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) <= 3600) THEN 1 ELSE 0 END) as s0sampai1,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 3600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 7200) THEN 1 ELSE 0 END) as s1sampai2,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 7200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 10800) THEN 1 ELSE 0 END) as s2sampai3,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 10800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 14400) THEN 1 ELSE 0 END) as s3sampai4,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 14400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 18000) THEN 1 ELSE 0 END) as s4sampai5,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 18000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 21600) THEN 1 ELSE 0 END) as s5sampai6,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 21600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 25200) THEN 1 ELSE 0 END) as s6sampai7,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 25200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 28800) THEN 1 ELSE 0 END) as s7sampai8,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 28800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 32400) THEN 1 ELSE 0 END) as s8sampai9,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 32400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 36000) THEN 1 ELSE 0 END) as s9sampai10,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 36000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 39600) THEN 1 ELSE 0 END) as s10sampai11,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 39600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 43200) THEN 1 ELSE 0 END) as s11sampai12,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 43200 ) THEN 1 ELSE 0 END) as diatas12
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            AND settlementreport like 'VC%'
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ",[$startDate, $endDate]);

        return view('reportvoucher.index',compact('duration', 'startDate', 'endDate'));
    }

    public function downloadPDF(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
            SELECT
                DATE(timeout) AS tanggal,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) <= 3600) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s0sampai1_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) <= 3600) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s0sampai1_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) <= 3600) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s0sampai1_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 3600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 7200) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s1sampai2_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 3600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 7200) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s1sampai2_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 3600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 7200) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s1sampai2_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 7200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 10800) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s2sampai3_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 7200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 10800) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s2sampai3_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 7200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 10800) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s2sampai3_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 10800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 14400) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s3sampai4_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 10800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 14400) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s3sampai4_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 10800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 14400) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s3sampai4_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 14400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 18000) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s4sampai5_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 14400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 18000) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s4sampai5_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 14400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 18000) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s4sampai5_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 18000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 21600) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s5sampai6_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 18000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 21600) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s5sampai6_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 18000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 21600) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s5sampai6_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 21600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 25200) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s6sampai7_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 21600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 25200) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s6sampai7_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 21600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 25200) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s6sampai7_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 25200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 28800) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s7sampai8_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 25200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 28800) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s7sampai8_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 25200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 28800) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s7sampai8_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 28800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 32400) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s8sampai9_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 28800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 32400) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s8sampai9_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 28800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 32400) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s8sampai9_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 32400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 36000) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s9sampai10_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 32400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 36000) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s9sampai10_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 32400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 36000) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s9sampai10_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 36000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 39600) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s10sampai11_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 36000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 39600) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s10sampai11_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 36000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 39600) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s10sampai11_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 39600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 43200) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s11sampai12_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 39600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 43200) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s11sampai12_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 39600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 43200) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s11sampai12_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 43200 ) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as diatas12_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 43200 ) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as diatas12_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 43200 ) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as diatas12_truck
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            AND settlementreport like 'VC%'
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ", [$startDate, $endDate]);
    
        if ($startDate == $endDate) {
            $fileName = config('app.location'). ' - Report Penggunaan Voucher ' . date('d F Y', strtotime($startDate)) . '.pdf';
        } else {
            $fileName = config('app.location'). ' - Report Penggunaan Voucher ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.pdf';
        }
        $judul = 'Laporan Penggunaan Voucher';
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
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) <= 3600) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s0sampai1_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) <= 3600) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s0sampai1_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) <= 3600) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s0sampai1_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 3600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 7200) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s1sampai2_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 3600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 7200) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s1sampai2_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 3600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 7200) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s1sampai2_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 7200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 10800) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s2sampai3_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 7200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 10800) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s2sampai3_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 7200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 10800) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s2sampai3_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 10800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 14400) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s3sampai4_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 10800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 14400) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s3sampai4_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 10800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 14400) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s3sampai4_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 14400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 18000) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s4sampai5_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 14400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 18000) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s4sampai5_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 14400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 18000) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s4sampai5_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 18000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 21600) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s5sampai6_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 18000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 21600) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s5sampai6_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 18000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 21600) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s5sampai6_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 21600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 25200) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s6sampai7_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 21600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 25200) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s6sampai7_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 21600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 25200) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s6sampai7_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 25200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 28800) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s7sampai8_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 25200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 28800) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s7sampai8_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 25200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 28800) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s7sampai8_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 28800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 32400) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s8sampai9_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 28800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 32400) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s8sampai9_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 28800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 32400) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s8sampai9_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 32400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 36000) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s9sampai10_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 32400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 36000) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s9sampai10_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 32400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 36000) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s9sampai10_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 36000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 39600) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s10sampai11_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 36000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 39600) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s10sampai11_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 36000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 39600) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s10sampai11_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 39600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 43200) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as s11sampai12_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 39600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 43200) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as s11sampai12_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 39600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 43200) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as s11sampai12_truck,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 43200 ) and vehicleid = 'Mobil' THEN 1 ELSE 0 END) as diatas12_mobil,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 43200 ) and vehicleid = 'Motor' THEN 1 ELSE 0 END) as diatas12_motor,
                SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 43200 ) and vehicleid = 'Truck' THEN 1 ELSE 0 END) as diatas12_truck
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            AND settlementreport like 'VC%'
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ", [$startDate, $endDate]);
    
        $judul = 'Laporan Penggunaan Voucher';

        if ($startDate == $endDate) {
            $fileName = config('app.location'). ' - Report Penggunaan Voucher ' . date('d F Y', strtotime($startDate)) . '.xlsx';
        } else {
            $fileName = config('app.location'). ' - Report Penggunaan Voucher ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.xlsx';
        }
    
        return Excel::download(new ReportVoucherExports ($results, $startDate, $endDate, $judul), $fileName);
    }


    
}
