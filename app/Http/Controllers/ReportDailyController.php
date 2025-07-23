<?php

namespace App\Http\Controllers;

use App\Exports\ReportDailyExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportDailyController extends Controller
{
    public function index()
    {
        // if (\Auth::user()->can('manage report') ) {
        //     $report = Transaction::where('parent_id', '=', parentId())->get();
           
        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $start=$startDate." 00:00:00";
        $endDate = $request->input('end_date', date('Y-m-d'));
        $end=$endDate." 23:59:59";
        $results = DB::select("
        SELECT 
            tiketno,datetransact,dateout,duration,cost,paymentby,vehicleid
        FROM 
            transactions
        WHERE 
            alreadyout = 'x' AND
            statusparking = 'Casual' AND
            vehicleid IN ('Mobil', 'Motor') AND
            dateout BETWEEN '2024-07-01 00:00:00' and '2024-07-01 23:59:59'
        GROUP BY 
            DATE(dateout)
        ORDER BY 
            DATE(dateout);
        ");
        return view('reportdaily.index',compact('results'));
    }


    public function getPaymentReport(Request $request)
    {
        // if (\Auth::user()->can('manage report') ) {
        //     $report = Transaction::where('parent_id', '=', parentId())->get();
           
        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
        $Date = $request->input('entry_date', date('Y-m-d'));
        // $start=$Date." 00:00:00";
        // $endDate = $request->input('end_date', date('Y-m-d'));
        // $end=$endDate." 23:59:59";
        $results = DB::select("
        SELECT 
        transactionid, tiketno, datetransact, dateout, duration,
            cost, paymentby, vehicleid
        FROM 
        transactions
        WHERE 
        alreadyout = 'x' AND
        statusparking = 'Casual' AND
        vehicleid IN ('Mobil', 'Motor') AND
        DATE(dateout) = ?
        AND duration IS NOT NULL
        ", [$Date]);
        return view('reportdaily.index',compact('results'));
    }

    public function downloadPdfDaily(Request $request)
    {
        $Date = $request->input('entry_date', date('Y-m-d'));
        $results = DB::select("
        SELECT 
        SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Amount_Mandiri_Mobil,
        SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Amount_Mandiri_Motor,
        SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Amount_BCA_Mobil,
        SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Amount_BCA_Motor,
        SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Amount_BNI_Mobil,
        SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Amount_BNI_Motor,
        SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Amount_BRI_Mobil,
        SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Amount_BRI_Motor,
        SUM(CASE WHEN paymentby = 'RFID' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Amount_Member_Mobil,
        SUM(CASE WHEN paymentby = 'RFID' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Amount_Member_Motor,
        SUM(CASE WHEN paymentby = 'Hotel' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Amount_Hotel_Mobil,
        SUM(CASE WHEN paymentby = 'Hotel' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Amount_Hotel_Motor,

        COUNT(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Mobil' THEN transactionid ELSE NULL END) AS Lalin_Mandiri_Mobil,
        COUNT(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Motor' THEN transactionid ELSE NULL END) AS Lalin_Mandiri_Motor,
        COUNT(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Mobil' THEN transactionid ELSE NULL END) AS Lalin_BCA_Mobil,
        COUNT(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Motor' THEN transactionid ELSE NULL END) AS Lalin_BCA_Motor,
        COUNT(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Mobil' THEN transactionid ELSE NULL END) AS Lalin_BNI_Mobil,
        COUNT(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Motor' THEN transactionid ELSE NULL END) AS Lalin_BNI_Motor,
        COUNT(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Mobil' THEN transactionid ELSE NULL END) AS Lalin_BRI_Mobil,
        COUNT(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Motor' THEN transactionid ELSE NULL END) AS Lalin_BRI_Motor,
        COUNT(CASE WHEN paymentby = 'RFID' AND vehicleid = 'Mobil' THEN transactionid ELSE NULL END) AS Lalin_Member_Mobil,
        COUNT(CASE WHEN paymentby = 'RFID' AND vehicleid = 'Motor' THEN transactionid ELSE NULL END) AS Lalin_Member_Motor,
        COUNT(CASE WHEN paymentby = 'Hotel' AND vehicleid = 'Mobil' THEN transactionid ELSE NULL END) AS Lalin_Hotel_Mobil,
        COUNT(CASE WHEN paymentby = 'Hotel' AND vehicleid = 'Motor' THEN transactionid ELSE NULL END) AS Lalin_Hotel_Motor
        FROM 
        transactions
        WHERE 
        alreadyout = 'x' AND
        statusparking = 'Casual' AND
        vehicleid IN ('Mobil', 'Motor') AND
        DATE(dateout) = ?
        ", [$Date]);
        $fileName = 'Intermark - Report Harian ' . date('d F Y', strtotime($Date)) . '.pdf';
        $judul = 'Laporan Transaksi';
        $pdf = PDF::loadView('pdf.pdfreportdaily', compact('results', 'Date', 'judul'));
        return $pdf->download($fileName);
    }

    public function downloadExcelDaily(Request $request)  {
        $Date = $request->input('entry_date', date('Y-m-d'));
        $results = DB::select("
        SELECT 
        SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Amount_Mandiri_Mobil,
        SUM(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Amount_Mandiri_Motor,
        SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Amount_BCA_Mobil,
        SUM(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Amount_BCA_Motor,
        SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Amount_BNI_Mobil,
        SUM(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Amount_BNI_Motor,
        SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Amount_BRI_Mobil,
        SUM(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Amount_BRI_Motor,
        SUM(CASE WHEN paymentby = 'RFID' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Amount_Member_Mobil,
        SUM(CASE WHEN paymentby = 'RFID' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Amount_Member_Motor,
        SUM(CASE WHEN paymentby = 'Hotel' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS Amount_Hotel_Mobil,
        SUM(CASE WHEN paymentby = 'Hotel' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS Amount_Hotel_Motor,

        COUNT(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Mobil' THEN transactionid ELSE NULL END) AS Lalin_Mandiri_Mobil,
        COUNT(CASE WHEN paymentby = 'Mandiri' AND vehicleid = 'Motor' THEN transactionid ELSE NULL END) AS Lalin_Mandiri_Motor,
        COUNT(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Mobil' THEN transactionid ELSE NULL END) AS Lalin_BCA_Mobil,
        COUNT(CASE WHEN paymentby = 'BCA' AND vehicleid = 'Motor' THEN transactionid ELSE NULL END) AS Lalin_BCA_Motor,
        COUNT(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Mobil' THEN transactionid ELSE NULL END) AS Lalin_BNI_Mobil,
        COUNT(CASE WHEN paymentby = 'BNI' AND vehicleid = 'Motor' THEN transactionid ELSE NULL END) AS Lalin_BNI_Motor,
        COUNT(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Mobil' THEN transactionid ELSE NULL END) AS Lalin_BRI_Mobil,
        COUNT(CASE WHEN paymentby = 'BRI' AND vehicleid = 'Motor' THEN transactionid ELSE NULL END) AS Lalin_BRI_Motor,
        COUNT(CASE WHEN paymentby = 'RFID' AND vehicleid = 'Mobil' THEN transactionid ELSE NULL END) AS Lalin_Member_Mobil,
        COUNT(CASE WHEN paymentby = 'RFID' AND vehicleid = 'Motor' THEN transactionid ELSE NULL END) AS Lalin_Member_Motor,
        COUNT(CASE WHEN paymentby = 'Hotel' AND vehicleid = 'Mobil' THEN transactionid ELSE NULL END) AS Lalin_Hotel_Mobil,
        COUNT(CASE WHEN paymentby = 'Hotel' AND vehicleid = 'Motor' THEN transactionid ELSE NULL END) AS Lalin_Hotel_Motor
        FROM 
        transactions
        WHERE 
        alreadyout = 'x' AND
        statusparking = 'Casual' AND
        vehicleid IN ('Mobil', 'Motor') AND
        DATE(dateout) = ?
        ", [$Date]);

        $judul = 'Laporan Harian';

        
        $fileName = 'Intermark - Report Harian ' . date('d F Y', strtotime($Date)) . '.xlsx';


        return Excel::download(new ReportDailyExport($results, $Date, $judul), $fileName);
        
    }

   
}
