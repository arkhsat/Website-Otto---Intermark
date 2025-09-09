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
            SUM(CASE WHEN TIMESTAMPDIFF(SECOND, timein, timeout) <= 3600  THEN 1 ELSE 0 END) as s0sampai1,
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
            SUM(CASE WHEN TIMESTAMPDIFF(SECOND, timein, timeout) <= 3600  THEN 1 ELSE 0 END) as s0sampai1,
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
            AND vehicleid IN ('Mobil')
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ", [$startDate, $endDate]);

        $motorcycle_datahours = DB::select("
            SELECT
            DATE(timeout) AS tanggal,
            COUNT(vehicleid) AS total,
            SUM(CASE WHEN TIMESTAMPDIFF(SECOND, timein, timeout) <= 3600  THEN 1 ELSE 0 END) as s0sampai1,
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

        
        $car_duration = DB::select("
            SELECT
            DATE(timeout) AS tanggal,
            SUM(cost) AS total,
            SUM(CASE WHEN TIMESTAMPDIFF(SECOND, timein, timeout) <= 3600  THEN cost ELSE 0 END) as s0sampai1,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 3600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 7200) THEN cost ELSE 0 END) as s1sampai2,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 7200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 10800) THEN cost ELSE 0 END) as s2sampai3,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 10800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 14400) THEN cost ELSE 0 END) as s3sampai4,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 14400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 18000) THEN cost ELSE 0 END) as s4sampai5,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 18000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 21600) THEN cost ELSE 0 END) as s5sampai6,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 21600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 25200) THEN cost ELSE 0 END) as s6sampai7,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 25200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 28800) THEN cost ELSE 0 END) as s7sampai8,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 28800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 32400) THEN cost ELSE 0 END) as s8sampai9,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 32400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 36000) THEN cost ELSE 0 END) as s9sampai10,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 36000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 39600) THEN cost ELSE 0 END) as s10sampai11,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 39600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 43200) THEN cost ELSE 0 END) as s11sampai12,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 43200 ) THEN cost ELSE 0 END) as diatas12
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND vehicleid IN ('Mobil')
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ", [$startDate, $endDate]);

        $motorcycle_duration = DB::select("
            SELECT
            DATE(timeout) AS tanggal,
            SUM(cost) AS total,
            SUM(CASE WHEN TIMESTAMPDIFF(SECOND, timein, timeout) <= 3600  THEN cost ELSE 0 END) as s0sampai1,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 3600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 7200) THEN cost ELSE 0 END) as s1sampai2,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 7200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 10800) THEN cost ELSE 0 END) as s2sampai3,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 10800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 14400) THEN cost ELSE 0 END) as s3sampai4,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 14400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 18000) THEN cost ELSE 0 END) as s4sampai5,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 18000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 21600) THEN cost ELSE 0 END) as s5sampai6,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 21600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 25200) THEN cost ELSE 0 END) as s6sampai7,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 25200 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 28800) THEN cost ELSE 0 END) as s7sampai8,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 28800 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 32400) THEN cost ELSE 0 END) as s8sampai9,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 32400 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 36000) THEN cost ELSE 0 END) as s9sampai10,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 36000 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 39600) THEN cost ELSE 0 END) as s10sampai11,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 39600 and TIMESTAMPDIFF(SECOND, timein, timeout) <= 43200) THEN cost ELSE 0 END) as s11sampai12,
            SUM(CASE WHEN (TIMESTAMPDIFF(SECOND, timein, timeout) > 43200 ) THEN cost ELSE 0 END) as diatas12
            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            AND vehicleid IN ('Motor')
            AND paymentby IN ('Mandiri', 'BCA', 'BNI', 'BRI', 'QRIS')
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ", [$startDate, $endDate]);

        // $car_datahours = DB::select(
        //     "SELECT
        //     DATE(timeout) AS tanggal,
        //     COUNT(vehicleid) AS total,
        //     COUNT(CASE WHEN HOUR(
        // );
    
        $judul = 'Laporan Pendapatan Transaksi';

        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report Pendapatan ' . date('d F Y', strtotime($startDate)) . '.xlsx';
        } else {
            $fileName = 'Intermark - Report Pendapatan ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.xlsx';
        }
    
        return Excel::download(new ReportAmountExport($results, $car_duration, $motorcycle_duration, $startDate, $endDate, $judul), $fileName);
    }
   
}