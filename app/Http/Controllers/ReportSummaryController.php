<?php

namespace App\Http\Controllers;
use App\Exports\ReportQtyExport;
use App\Exports\ReportAmountExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportSummaryController extends Controller
{
    public function getAmountReport(Request $request)
    {
        // if (\Auth::user()->can('manage report') ) {
        //     $report = Transaction::where('parent_id', '=', parentId())->get();
           
        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $results = DB::select("
        SELECT 
            DATE(dateout) AS date,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Mandiri_Mobil,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Mandiri_Motor,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS BCA_Mobil,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS BCA_Motor,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS BNI_Mobil,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS BNI_Motor,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS BRI_Mobil,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS BRI_Motor,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS QRIS_Mobil,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS QRIS_Motor,
            SUM(cost) as total
        FROM 
            transactions
        WHERE 
            alreadyout = 'x' AND
            statusparking = 'Casual' AND
            vehicleid IN ('Mobil', 'Motor') AND
            paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS') AND
            DATE(dateout) BETWEEN ? AND ?
                    GROUP BY 
                        DATE(dateout)
                    ORDER BY 
                        DATE(dateout);
            ",[$startDate, $endDate]);
        return view('reportsummary.reportamount',compact('results', 'startDate', 'endDate'));
    }


    public function getPaymentReport(Request $request)
    {
        // if (\Auth::user()->can('manage report') ) {
        //     $report = Transaction::where('parent_id', '=', parentId())->get();
           
        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $results = DB::select("
        SELECT 
            DATE(dateout) AS date,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Mandiri_Mobil,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Mandiri_Motor,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS BCA_Mobil,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS BCA_Motor,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS BNI_Mobil,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS BNI_Motor,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS BRI_Mobil,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS BRI_Motor,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS QRIS_Mobil,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS QRIS_Motor,
        FROM 
            transactions
        WHERE 
            alreadyout = 'x' AND
            statusparking = 'Casual' AND
            vehicleid IN ('Mobil', 'Truck') AND
            paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS') AND
            DATE(dateout) BETWEEN ? AND ?
                    GROUP BY 
                        DATE(dateout)
                    ORDER BY 
                        DATE(dateout);
        ", [$startDate, $endDate]);
        return view('reportsummary.reportamount',compact('results'));
    }


    public function getQtyReport(Request $request)
    {
        // if (\Auth::user()->can('manage report') ) {
        //     $report = Transaction::where('parent_id', '=', parentId())->get();
           
        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $results = DB::select("
        SELECT 
            DATE(dateout) AS date,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS Mandiri_Mobil,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS Mandiri_Motor,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS BCA_Mobil,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS BCA_Motor,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS BNI_Mobil,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS BNI_Motor,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS BRI_Mobil,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS BRI_Motor,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS QRIS_Mobil,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS QRIS_Motor,
            COUNT(transactionid) as total
        FROM 
            transactions
        WHERE 
            alreadyout = 'x' AND
            statusparking = 'Casual' AND
            vehicleid IN ('Mobil', 'Motor') AND
            paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS') AND
            DATE(dateout) BETWEEN ? AND ?
                    GROUP BY 
                        DATE(dateout)
                    ORDER BY 
                        DATE(dateout);
        ", [$startDate, $endDate]);
        return view('reportsummary.reportqty',compact('results'));
    }

    public function downloadpdfQty(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
        SELECT 
            DATE(dateout) AS date,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS Mandiri_Mobil,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS Mandiri_Motor,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS BCA_Mobil,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS BCA_Motor,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS BNI_Mobil,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS BNI_Motor,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS BRI_Mobil,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS BRI_Motor,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS QRIS_Mobil,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS QRIS_Motor,
            COUNT(transactionid) as total
        FROM 
            transactions
        WHERE 
            alreadyout = 'x' AND
            statusparking = 'Casual' AND
            vehicleid IN ('Mobil', 'Motor') AND
            paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS') AND
            DATE(dateout) BETWEEN ? AND ?
                    GROUP BY 
                        DATE(dateout)
                    ORDER BY 
                        DATE(dateout);
        ", [$startDate, $endDate]);

        $datahours = DB::select("
            SELECT
            DATE(timeout) AS tanggal,
            COUNT(vehicleid) AS total,
            SUM(CASE WHEN TIMESTAMPDIFF(MINUTE, timein, timeout) < 60  THEN 1 ELSE 0 END) as s0sampai1,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 60 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 120) THEN 1 ELSE 0 END) as s1sampai2,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 120 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 180) THEN 1 ELSE 0 END) as s2sampai3,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 180 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 240) THEN 1 ELSE 0 END) as s3sampai4,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 240 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 300) THEN 1 ELSE 0 END) as s4sampai5,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 300 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 360) THEN 1 ELSE 0 END) as s5sampai6,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 360 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 420) THEN 1 ELSE 0 END) as s6sampai7,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 420 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 480) THEN 1 ELSE 0 END) as s7sampai8,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 480 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 540) THEN 1 ELSE 0 END) as s8sampai9,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 540 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 600) THEN 1 ELSE 0 END) as s9sampai10,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 600 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 660) THEN 1 ELSE 0 END) as s10sampai11,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 660 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 720) THEN 1 ELSE 0 END) as s11sampai12,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) >= 720 ) THEN 1 ELSE 0 END) as diatas12
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ", [$startDate, $endDate]);
    
        // Tentukan nama file berdasarkan tanggal
        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report QTY ' . date('d F Y', strtotime($startDate)) . '.pdf';
        } else {
            $fileName = 'Intermark - Report QTY ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.pdf';
        }
        $judul = 'Laporan QTY Transaksi Harian';

        $pdf = Pdf::loadView('PDF/pdfqty', ['data' => $results, 'datahours' => $datahours], compact('startDate', 'endDate', 'judul'))->setPaper('a4', 'landscape');


        return $pdf->download($fileName);
    }

    public function downloadpdfAmount(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
        SELECT 
            DATE(dateout) AS date,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Mandiri_Mobil,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Mandiri_Motor,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS BCA_Mobil,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS BCA_Motor,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS BNI_Mobil,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS BNI_Motor,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS BRI_Mobil,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS BRI_Motor,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS QRIS_Mobil,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS QRIS_Motor,
            SUM(cost) as total
        FROM 
            transactions
        WHERE 
            alreadyout = 'x' AND
            statusparking = 'Casual' AND
            vehicleid IN ('Mobil', 'Motor') AND
            paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS') AND
            DATE(dateout) BETWEEN ? AND ?
            GROUP BY 
                DATE(dateout)
            ORDER BY 
                DATE(dateout);
        ", [$startDate, $endDate]);
    
        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report Pendapatan ' . date('d F Y', strtotime($startDate)) . '.pdf';
        } else {
            $fileName = 'Intermark - Report Pendapatan ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.pdf';
        }
        $judul = 'Laporan Pendapatan Transaksi Harian';
        $pdf = Pdf::loadView('PDF/pdfqtyamount', ['data' => $results], compact('startDate', 'endDate', 'judul'));
        
        return $pdf->download($fileName);
    }

    public function downloadExcelQty(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
        SELECT 
            DATE(dateout) AS date,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS Mandiri_Mobil,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS Mandiri_Motor,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS BCA_Mobil,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS BCA_Motor,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS BNI_Mobil,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS BNI_Motor,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS BRI_Mobil,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS BRI_Motor,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS QRIS_Mobil,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS QRIS_Motor,
            COUNT(transactionid) as total
        FROM 
            transactions
        WHERE 
            alreadyout = 'x' AND
            statusparking = 'Casual' AND
            vehicleid IN ('Mobil', 'Motor') AND
            DATE(dateout) BETWEEN ? AND ? AND
            paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            GROUP BY 
                DATE(dateout)
            ORDER BY 
                DATE(dateout);
        ", [$startDate, $endDate]);

        $car_datahours = DB::select("
            SELECT
            DATE(timeout) AS tanggal,
            COUNT(vehicleid) AS total,
            SUM(CASE WHEN TIMESTAMPDIFF(MINUTE, timein, timeout) < 60  THEN 1 ELSE 0 END) as s0sampai1,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 60 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 120) THEN 1 ELSE 0 END) as s1sampai2,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 120 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 180) THEN 1 ELSE 0 END) as s2sampai3,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 180 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 240) THEN 1 ELSE 0 END) as s3sampai4,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 240 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 300) THEN 1 ELSE 0 END) as s4sampai5,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 300 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 360) THEN 1 ELSE 0 END) as s5sampai6,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 360 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 420) THEN 1 ELSE 0 END) as s6sampai7,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 420 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 480) THEN 1 ELSE 0 END) as s7sampai8,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 480 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 540) THEN 1 ELSE 0 END) as s8sampai9,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 540 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 600) THEN 1 ELSE 0 END) as s9sampai10,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 600 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 660) THEN 1 ELSE 0 END) as s10sampai11,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 660 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 720) THEN 1 ELSE 0 END) as s11sampai12,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) >= 720 ) THEN 1 ELSE 0 END) as diatas12
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND vehicleid IN ('Mobil')
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ", [$startDate, $endDate]);

        $motorcycle_datahours = DB::select("
            SELECT
            DATE(timeout) AS tanggal,
            COUNT(vehicleid) AS total,
            SUM(CASE WHEN TIMESTAMPDIFF(MINUTE, timein, timeout) < 60  THEN 1 ELSE 0 END) as s0sampai1,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 60 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 120) THEN 1 ELSE 0 END) as s1sampai2,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 120 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 180) THEN 1 ELSE 0 END) as s2sampai3,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 180 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 240) THEN 1 ELSE 0 END) as s3sampai4,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 240 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 300) THEN 1 ELSE 0 END) as s4sampai5,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 300 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 360) THEN 1 ELSE 0 END) as s5sampai6,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 360 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 420) THEN 1 ELSE 0 END) as s6sampai7,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 420 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 480) THEN 1 ELSE 0 END) as s7sampai8,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 480 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 540) THEN 1 ELSE 0 END) as s8sampai9,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 540 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 600) THEN 1 ELSE 0 END) as s9sampai10,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 600 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 660) THEN 1 ELSE 0 END) as s10sampai11,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) > 660 and TIMESTAMPDIFF(MINUTE, timein, timeout) <= 720) THEN 1 ELSE 0 END) as s11sampai12,
            SUM(CASE WHEN (TIMESTAMPDIFF(MINUTE, timein, timeout) >= 720 ) THEN 1 ELSE 0 END) as diatas12
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND vehicleid IN ('Motor')
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ", [$startDate, $endDate]);

        $judul = 'Laporan QTY Transaksi Harian'; // Ubah sesuai keinginan

        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report QTY ' . date('d F Y', strtotime($startDate)) . '.xlsx';
        } else {
            $fileName = 'Intermark - Report QTY ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.xlsx';
        }
    
        // return Excel::download(new ReportQtyExport($car_datahours, $motorcycle_datahours, $results, $startDate, $endDate, $judul), $fileName);
        return Excel::download(new ReportQtyExport($results, $car_datahours, $motorcycle_datahours, $startDate, $endDate, $judul), $fileName);
    }

    public function downloadExcelAmount(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
        SELECT 
            DATE(dateout) AS date,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Mandiri_Mobil,
            SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Mandiri_Motor,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS BCA_Mobil,
            SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS BCA_Motor,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS BNI_Mobil,
            SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS BNI_Motor,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS BRI_Mobil,
            SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS BRI_Motor,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS QRIS_Mobil,
            SUM(CASE WHEN paymentby = 'QRIS' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS QRIS_Motor,
            SUM(cost) as total
        FROM 
            transactions
        WHERE 
            alreadyout = 'x' AND
            statusparking = 'Casual' AND
            vehicleid IN ('Mobil', 'Motor') AND
            paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS') AND
            DATE(dateout) BETWEEN ? AND ?
                    GROUP BY 
                        DATE(dateout)
                    ORDER BY 
                        DATE(dateout);
        ", [$startDate, $endDate]);
    
        $judul = 'Laporan Pendapatan Transaksi';

        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report Pendapatan ' . date('d F Y', strtotime($startDate)) . '.xlsx';
        } else {
            $fileName = 'Intermark - Report Pendapatan ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.xlsx';
        }
    
        return Excel::download(new ReportAmountExport($results, $startDate, $endDate, $judul), $fileName);
    }
   
}