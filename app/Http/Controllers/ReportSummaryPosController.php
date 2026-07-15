<?php

namespace App\Http\Controllers;
use App\Exports\ReportQtyPosExport;
use App\Exports\ReportAmountExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportSummaryPosController extends Controller
{
    public function getAmountReportPos(Request $request)
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
            SUM(CASE WHEN paymentby = 'RFID' AND vehicleid = 'Mobil' THEN cost ELSE 0 END) AS RFID_Mobil,
            SUM(CASE WHEN paymentby = 'RFID' AND vehicleid = 'Motor' THEN cost ELSE 0 END) AS RFID_Motor,
            SUM(cost) as total
        FROM 
            transactions
        WHERE 
            alreadyout = 'x' AND
            statusparking = 'Member' AND
            vehicleid IN ('Mobil', 'Motor') AND
            paymentby IN ('RFID') AND
            DATE(dateout) BETWEEN ? AND ?
                    GROUP BY 
                        DATE(dateout)
                    ORDER BY 
                        DATE(dateout);
            ",[$startDate, $endDate]);
        return view('reportsummarymember.reportamountmember',compact('results', 'startDate', 'endDate'));
    }


    public function getPaymentReportPos(Request $request)
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


    public function getQtyReportPos(Request $request)
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
            SUM(CASE WHEN posinid = 1 THEN 1 ELSE 0 END) AS PM_Mob1,
            SUM(CASE WHEN posinid = 2 THEN 1 ELSE 0 END) AS PM_Mob2,
            SUM(CASE WHEN posinid = 3 THEN 1 ELSE 0 END) AS PM_Motor,
            
            SUM(CASE WHEN posoutid  = 21 THEN 1 ELSE 0 END) AS PK_Mob1,
            SUM(CASE WHEN posoutid  = 22 THEN 1 ELSE 0 END) AS PK_Mob2,
            SUM(CASE WHEN posoutid  = 23 THEN 1 ELSE 0 END) AS PK_Motor,

            SUM(CASE WHEN posinid IN (1,2,3) THEN 1 ELSE 0 END) AS Total_PM,
            SUM(CASE WHEN posoutid IN (21,22,23) THEN 1 ELSE 0 END) AS Total_PK,

            COUNT(transactionid) AS total

        FROM transactions
        WHERE 
            DATE(dateout) BETWEEN ? AND ?
            GROUP BY 
                DATE(dateout)
            ORDER BY 
                DATE(dateout)
        ", [$startDate, $endDate]);

        return view('reportsummarypos.reportqtypos',compact('results'));
    }

    public function downloadpdfQtyPos(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
        SELECT
            DATE(dateout) AS date,
            SUM(CASE WHEN posinid = 1 THEN 1 ELSE 0 END) AS PM_Mob1,
            SUM(CASE WHEN posinid = 2 THEN 1 ELSE 0 END) AS PM_Mob2,
            SUM(CASE WHEN posinid = 3 THEN 1 ELSE 0 END) AS PM_Motor,
            
            SUM(CASE WHEN posoutid  = 21 THEN 1 ELSE 0 END) AS PK_Mob1,
            SUM(CASE WHEN posoutid  = 22 THEN 1 ELSE 0 END) AS PK_Mob2,
            SUM(CASE WHEN posoutid  = 23 THEN 1 ELSE 0 END) AS PK_Motor,

            SUM(CASE WHEN posinid IN (1,2,3) THEN 1 ELSE 0 END) AS Total_PM,
            SUM(CASE WHEN posoutid IN (21,22,23) THEN 1 ELSE 0 END) AS Total_PK

        FROM 
            transactions
        WHERE 
            DATE(dateout) BETWEEN ? AND ?
            GROUP BY 
                DATE(dateout)
            ORDER BY 
                DATE(dateout)
        ", [$startDate, $endDate]);

        $datahours = DB::select("
            SELECT
                DATE(timeout) AS tanggal,

                COUNT(transactionid) AS total,

                -- TOTAL POS MASUK
                SUM(CASE WHEN posinid = 1 THEN 1 ELSE 0 END) AS PM_Mob1,
                SUM(CASE WHEN posinid = 2 THEN 1 ELSE 0 END) AS PM_Mob2,
                SUM(CASE WHEN posinid = 3 THEN 1 ELSE 0 END) AS PM_Motor,

                -- TOTAL POS KELUAR
                SUM(CASE WHEN posoutid = 21 THEN 1 ELSE 0 END) AS PK_Mob1,
                SUM(CASE WHEN posoutid = 22 THEN 1 ELSE 0 END) AS PK_Mob2,
                SUM(CASE WHEN posoutid = 23 THEN 1 ELSE 0 END) AS PK_Motor,

                -- 00 - 03
                SUM(CASE WHEN HOUR(timein) BETWEEN 0 AND 3 AND posinid = 1 THEN 1 ELSE 0 END) AS PM1_00_03,
                SUM(CASE WHEN HOUR(timein) BETWEEN 0 AND 3 AND posinid = 2 THEN 1 ELSE 0 END) AS PM2_00_03,
                SUM(CASE WHEN HOUR(timein) BETWEEN 0 AND 3 AND posinid = 3 THEN 1 ELSE 0 END) AS PMMotor_00_03,

                SUM(CASE WHEN HOUR(timeout) BETWEEN 0 AND 3 AND posoutid = 21 THEN 1 ELSE 0 END) AS PK1_00_03,
                SUM(CASE WHEN HOUR(timeout) BETWEEN 0 AND 3 AND posoutid = 22 THEN 1 ELSE 0 END) AS PK2_00_03,
                SUM(CASE WHEN HOUR(timeout) BETWEEN 0 AND 3 AND posoutid = 23 THEN 1 ELSE 0 END) AS PKMotor_00_03,

                -- 04 - 07
                SUM(CASE WHEN HOUR(timein) BETWEEN 4 AND 7 AND posinid = 1 THEN 1 ELSE 0 END) AS PM1_04_07,
                SUM(CASE WHEN HOUR(timein) BETWEEN 4 AND 7 AND posinid = 2 THEN 1 ELSE 0 END) AS PM2_04_07,
                SUM(CASE WHEN HOUR(timein) BETWEEN 4 AND 7 AND posinid = 3 THEN 1 ELSE 0 END) AS PMMotor_04_07,

                SUM(CASE WHEN HOUR(timeout) BETWEEN 4 AND 7 AND posoutid = 21 THEN 1 ELSE 0 END) AS PK1_04_07,
                SUM(CASE WHEN HOUR(timeout) BETWEEN 4 AND 7 AND posoutid = 22 THEN 1 ELSE 0 END) AS PK2_04_07,
                SUM(CASE WHEN HOUR(timeout) BETWEEN 4 AND 7 AND posoutid = 23 THEN 1 ELSE 0 END) AS PKMotor_04_07,

                -- 08 - 11
                SUM(CASE WHEN HOUR(timein) BETWEEN 8 AND 11 AND posinid = 1 THEN 1 ELSE 0 END) AS PM1_08_11,
                SUM(CASE WHEN HOUR(timein) BETWEEN 8 AND 11 AND posinid = 2 THEN 1 ELSE 0 END) AS PM2_08_11,
                SUM(CASE WHEN HOUR(timein) BETWEEN 8 AND 11 AND posinid = 3 THEN 1 ELSE 0 END) AS PMMotor_08_11,

                SUM(CASE WHEN HOUR(timeout) BETWEEN 8 AND 11 AND posoutid = 21 THEN 1 ELSE 0 END) AS PK1_08_11,
                SUM(CASE WHEN HOUR(timeout) BETWEEN 8 AND 11 AND posoutid = 22 THEN 1 ELSE 0 END) AS PK2_08_11,
                SUM(CASE WHEN HOUR(timeout) BETWEEN 8 AND 11 AND posoutid = 23 THEN 1 ELSE 0 END) AS PKMotor_08_11,

                -- 12 - 15
                SUM(CASE WHEN HOUR(timein) BETWEEN 12 AND 15 AND posinid = 1 THEN 1 ELSE 0 END) AS PM1_12_15,
                SUM(CASE WHEN HOUR(timein) BETWEEN 12 AND 15 AND posinid = 2 THEN 1 ELSE 0 END) AS PM2_12_15,
                SUM(CASE WHEN HOUR(timein) BETWEEN 12 AND 15 AND posinid = 3 THEN 1 ELSE 0 END) AS PMMotor_12_15,

                SUM(CASE WHEN HOUR(timeout) BETWEEN 12 AND 15 AND posoutid = 21 THEN 1 ELSE 0 END) AS PK1_12_15,
                SUM(CASE WHEN HOUR(timeout) BETWEEN 12 AND 15 AND posoutid = 22 THEN 1 ELSE 0 END) AS PK2_12_15,
                SUM(CASE WHEN HOUR(timeout) BETWEEN 12 AND 15 AND posoutid = 23 THEN 1 ELSE 0 END) AS PKMotor_12_15,

                -- 16 - 19
                SUM(CASE WHEN HOUR(timein) BETWEEN 16 AND 19 AND posinid = 1 THEN 1 ELSE 0 END) AS PM1_16_19,
                SUM(CASE WHEN HOUR(timein) BETWEEN 16 AND 19 AND posinid = 2 THEN 1 ELSE 0 END) AS PM2_16_19,
                SUM(CASE WHEN HOUR(timein) BETWEEN 16 AND 19 AND posinid = 3 THEN 1 ELSE 0 END) AS PMMotor_16_19,

                SUM(CASE WHEN HOUR(timeout) BETWEEN 16 AND 19 AND posoutid = 21 THEN 1 ELSE 0 END) AS PK1_16_19,
                SUM(CASE WHEN HOUR(timeout) BETWEEN 16 AND 19 AND posoutid = 22 THEN 1 ELSE 0 END) AS PK2_16_19,
                SUM(CASE WHEN HOUR(timeout) BETWEEN 16 AND 19 AND posoutid = 23 THEN 1 ELSE 0 END) AS PKMotor_16_19,

                -- 20 - 23
                SUM(CASE WHEN HOUR(timein) BETWEEN 20 AND 23 AND posinid = 1 THEN 1 ELSE 0 END) AS PM1_20_23,
                SUM(CASE WHEN HOUR(timein) BETWEEN 20 AND 23 AND posinid = 2 THEN 1 ELSE 0 END) AS PM2_20_23,
                SUM(CASE WHEN HOUR(timein) BETWEEN 20 AND 23 AND posinid = 3 THEN 1 ELSE 0 END) AS PMMotor_20_23,

                SUM(CASE WHEN HOUR(timeout) BETWEEN 20 AND 23 AND posoutid = 21 THEN 1 ELSE 0 END) AS PK1_20_23,
                SUM(CASE WHEN HOUR(timeout) BETWEEN 20 AND 23 AND posoutid = 22 THEN 1 ELSE 0 END) AS PK2_20_23,
                SUM(CASE WHEN HOUR(timeout) BETWEEN 20 AND 23 AND posoutid = 23 THEN 1 ELSE 0 END) AS PKMotor_20_23

            FROM transactions
            WHERE DATE(timeout) BETWEEN ? AND ?
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ", [$startDate, $endDate]);
    
        // Tentukan nama file berdasarkan tanggal
        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report QTY Pos ' . date('d F Y', strtotime($startDate)) . '.pdf';
        } else {
            $fileName = 'Intermark - Report QTY Pos' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.pdf';
        }
        $judul = 'Laporan QTY Transaksi Pos Harian';

        $pdf = Pdf::loadView('PDF/pdfqtypos', ['data' => $results, 'datahours' => $datahours], compact('startDate', 'endDate', 'judul'))->setPaper('a3', 'landscape');


        return $pdf->download($fileName);
    }

    public function downloadpdfAmountPos(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
         SELECT 
            DATE(dateout) AS date,
            SUM(CASE WHEN paymentby = 'RFID' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS RFID_Mobil,
            SUM(CASE WHEN paymentby = 'RFID' AND vehicleid = 'Motor' THEN 1 ELSE 0 END) AS RFID_Motor,
            SUM(CASE WHEN paymentby = 'blue bird' AND vehicleid = 'Mobil' THEN 1 ELSE 0 END) AS BLUEBIRD_Mobil,
            COUNT(transactionid) as total
        FROM 
            transactions
        WHERE 
            alreadyout = 'x' AND
            vehicleid IN ('Mobil', 'Motor') AND
            paymentby IN ('RFID', 'blue bird') AND
            DATE(dateout) BETWEEN ? AND ?
                    GROUP BY 
                        DATE(dateout)
                    ORDER BY 
                        DATE(dateout);
        ", [$startDate, $endDate]);

    
        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report Pos ' . date('d F Y', strtotime($startDate)) . '.pdf';
        } else {
            $fileName = 'Intermark - Report Pos ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.pdf';
        }
        $judul = 'Laporan Pendapatan Transaksi Harian';
        $pdf = Pdf::loadView('PDF/pdfqtyamount', ['data' => $results], compact('startDate', 'endDate', 'judul'));
        
        return $pdf->download($fileName);
    }

    public function downloadExcelQtyPos(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
        SELECT
            DATE(dateout) AS date,
            SUM(CASE WHEN posinid = 1 THEN 1 ELSE 0 END) AS PM_Mob1,
            SUM(CASE WHEN posinid = 2 THEN 1 ELSE 0 END) AS PM_Mob2,
            SUM(CASE WHEN posinid = 3 THEN 1 ELSE 0 END) AS PM_Motor,
            
            SUM(CASE WHEN posoutid  = 21 THEN 1 ELSE 0 END) AS PK_Mob1,
            SUM(CASE WHEN posoutid  = 22 THEN 1 ELSE 0 END) AS PK_Mob2,
            SUM(CASE WHEN posoutid  = 23 THEN 1 ELSE 0 END) AS PK_Motor,

            SUM(CASE WHEN posinid IN (1,2,3) THEN 1 ELSE 0 END) AS Total_PM,
            SUM(CASE WHEN posoutid IN (21,22,23) THEN 1 ELSE 0 END) AS Total_PK

        FROM 
            transactions
        WHERE 
            DATE(dateout) BETWEEN ? AND ?
            GROUP BY 
                DATE(dateout)
            ORDER BY 
                DATE(dateout)
        ", [$startDate, $endDate]);

        $pmm1_datahours = DB::select("
            SELECT
                DATE(timein) AS tanggal,
                COUNT(*) AS total,

                SUM(CASE WHEN HOUR(timein) = 0 THEN 1 ELSE 0 END) AS jam0,
                SUM(CASE WHEN HOUR(timein) = 1 THEN 1 ELSE 0 END) AS jam1,
                SUM(CASE WHEN HOUR(timein) = 2 THEN 1 ELSE 0 END) AS jam2,
                SUM(CASE WHEN HOUR(timein) = 3 THEN 1 ELSE 0 END) AS jam3,
                SUM(CASE WHEN HOUR(timein) = 4 THEN 1 ELSE 0 END) AS jam4,
                SUM(CASE WHEN HOUR(timein) = 5 THEN 1 ELSE 0 END) AS jam5,
                SUM(CASE WHEN HOUR(timein) = 6 THEN 1 ELSE 0 END) AS jam6,
                SUM(CASE WHEN HOUR(timein) = 7 THEN 1 ELSE 0 END) AS jam7,
                SUM(CASE WHEN HOUR(timein) = 8 THEN 1 ELSE 0 END) AS jam8,
                SUM(CASE WHEN HOUR(timein) = 9 THEN 1 ELSE 0 END) AS jam9,
                SUM(CASE WHEN HOUR(timein) = 10 THEN 1 ELSE 0 END) AS jam10,
                SUM(CASE WHEN HOUR(timein) = 11 THEN 1 ELSE 0 END) AS jam11,
                SUM(CASE WHEN HOUR(timein) = 12 THEN 1 ELSE 0 END) AS jam12,
                SUM(CASE WHEN HOUR(timein) = 13 THEN 1 ELSE 0 END) AS jam13,
                SUM(CASE WHEN HOUR(timein) = 14 THEN 1 ELSE 0 END) AS jam14,
                SUM(CASE WHEN HOUR(timein) = 15 THEN 1 ELSE 0 END) AS jam15,
                SUM(CASE WHEN HOUR(timein) = 16 THEN 1 ELSE 0 END) AS jam16,
                SUM(CASE WHEN HOUR(timein) = 17 THEN 1 ELSE 0 END) AS jam17,
                SUM(CASE WHEN HOUR(timein) = 18 THEN 1 ELSE 0 END) AS jam18,
                SUM(CASE WHEN HOUR(timein) = 19 THEN 1 ELSE 0 END) AS jam19,
                SUM(CASE WHEN HOUR(timein) = 20 THEN 1 ELSE 0 END) AS jam20,
                SUM(CASE WHEN HOUR(timein) = 21 THEN 1 ELSE 0 END) AS jam21,
                SUM(CASE WHEN HOUR(timein) = 22 THEN 1 ELSE 0 END) AS jam22,
                SUM(CASE WHEN HOUR(timein) = 23 THEN 1 ELSE 0 END) AS jam23

            FROM transactions
            WHERE DATE(timein) BETWEEN ? AND ?
            AND posinid = 1
            GROUP BY DATE(timein)
            ORDER BY DATE(timein);
        ", [$startDate, $endDate]);

        $pmm2_datahours = DB::select("
            SELECT
                DATE(timein) AS tanggal,
                COUNT(*) AS total,

                SUM(CASE WHEN HOUR(timein) = 0 THEN 1 ELSE 0 END) AS jam0,
                SUM(CASE WHEN HOUR(timein) = 1 THEN 1 ELSE 0 END) AS jam1,
                SUM(CASE WHEN HOUR(timein) = 2 THEN 1 ELSE 0 END) AS jam2,
                SUM(CASE WHEN HOUR(timein) = 3 THEN 1 ELSE 0 END) AS jam3,
                SUM(CASE WHEN HOUR(timein) = 4 THEN 1 ELSE 0 END) AS jam4,
                SUM(CASE WHEN HOUR(timein) = 5 THEN 1 ELSE 0 END) AS jam5,
                SUM(CASE WHEN HOUR(timein) = 6 THEN 1 ELSE 0 END) AS jam6,
                SUM(CASE WHEN HOUR(timein) = 7 THEN 1 ELSE 0 END) AS jam7,
                SUM(CASE WHEN HOUR(timein) = 8 THEN 1 ELSE 0 END) AS jam8,
                SUM(CASE WHEN HOUR(timein) = 9 THEN 1 ELSE 0 END) AS jam9,
                SUM(CASE WHEN HOUR(timein) = 10 THEN 1 ELSE 0 END) AS jam10,
                SUM(CASE WHEN HOUR(timein) = 11 THEN 1 ELSE 0 END) AS jam11,
                SUM(CASE WHEN HOUR(timein) = 12 THEN 1 ELSE 0 END) AS jam12,
                SUM(CASE WHEN HOUR(timein) = 13 THEN 1 ELSE 0 END) AS jam13,
                SUM(CASE WHEN HOUR(timein) = 14 THEN 1 ELSE 0 END) AS jam14,
                SUM(CASE WHEN HOUR(timein) = 15 THEN 1 ELSE 0 END) AS jam15,
                SUM(CASE WHEN HOUR(timein) = 16 THEN 1 ELSE 0 END) AS jam16,
                SUM(CASE WHEN HOUR(timein) = 17 THEN 1 ELSE 0 END) AS jam17,
                SUM(CASE WHEN HOUR(timein) = 18 THEN 1 ELSE 0 END) AS jam18,
                SUM(CASE WHEN HOUR(timein) = 19 THEN 1 ELSE 0 END) AS jam19,
                SUM(CASE WHEN HOUR(timein) = 20 THEN 1 ELSE 0 END) AS jam20,
                SUM(CASE WHEN HOUR(timein) = 21 THEN 1 ELSE 0 END) AS jam21,
                SUM(CASE WHEN HOUR(timein) = 22 THEN 1 ELSE 0 END) AS jam22,
                SUM(CASE WHEN HOUR(timein) = 23 THEN 1 ELSE 0 END) AS jam23

            FROM transactions
            WHERE DATE(timein) BETWEEN ? AND ?
            AND posinid = 2
            GROUP BY DATE(timein)
            ORDER BY DATE(timein);
        ", [$startDate, $endDate]);

        $pmmo_datahours = DB::select("
            SELECT
                DATE(timein) AS tanggal,
                COUNT(*) AS total,

                SUM(CASE WHEN HOUR(timein) = 0 THEN 1 ELSE 0 END) AS jam0,
                SUM(CASE WHEN HOUR(timein) = 1 THEN 1 ELSE 0 END) AS jam1,
                SUM(CASE WHEN HOUR(timein) = 2 THEN 1 ELSE 0 END) AS jam2,
                SUM(CASE WHEN HOUR(timein) = 3 THEN 1 ELSE 0 END) AS jam3,
                SUM(CASE WHEN HOUR(timein) = 4 THEN 1 ELSE 0 END) AS jam4,
                SUM(CASE WHEN HOUR(timein) = 5 THEN 1 ELSE 0 END) AS jam5,
                SUM(CASE WHEN HOUR(timein) = 6 THEN 1 ELSE 0 END) AS jam6,
                SUM(CASE WHEN HOUR(timein) = 7 THEN 1 ELSE 0 END) AS jam7,
                SUM(CASE WHEN HOUR(timein) = 8 THEN 1 ELSE 0 END) AS jam8,
                SUM(CASE WHEN HOUR(timein) = 9 THEN 1 ELSE 0 END) AS jam9,
                SUM(CASE WHEN HOUR(timein) = 10 THEN 1 ELSE 0 END) AS jam10,
                SUM(CASE WHEN HOUR(timein) = 11 THEN 1 ELSE 0 END) AS jam11,
                SUM(CASE WHEN HOUR(timein) = 12 THEN 1 ELSE 0 END) AS jam12,
                SUM(CASE WHEN HOUR(timein) = 13 THEN 1 ELSE 0 END) AS jam13,
                SUM(CASE WHEN HOUR(timein) = 14 THEN 1 ELSE 0 END) AS jam14,
                SUM(CASE WHEN HOUR(timein) = 15 THEN 1 ELSE 0 END) AS jam15,
                SUM(CASE WHEN HOUR(timein) = 16 THEN 1 ELSE 0 END) AS jam16,
                SUM(CASE WHEN HOUR(timein) = 17 THEN 1 ELSE 0 END) AS jam17,
                SUM(CASE WHEN HOUR(timein) = 18 THEN 1 ELSE 0 END) AS jam18,
                SUM(CASE WHEN HOUR(timein) = 19 THEN 1 ELSE 0 END) AS jam19,
                SUM(CASE WHEN HOUR(timein) = 20 THEN 1 ELSE 0 END) AS jam20,
                SUM(CASE WHEN HOUR(timein) = 21 THEN 1 ELSE 0 END) AS jam21,
                SUM(CASE WHEN HOUR(timein) = 22 THEN 1 ELSE 0 END) AS jam22,
                SUM(CASE WHEN HOUR(timein) = 23 THEN 1 ELSE 0 END) AS jam23

            FROM transactions
            WHERE DATE(timein) BETWEEN ? AND ?
            AND posinid = 3
            GROUP BY DATE(timein)
            ORDER BY DATE(timein);
        ", [$startDate, $endDate]);

        $pkm1_datahours = DB::select("
            SELECT
                DATE(timein) AS tanggal,
                COUNT(*) AS total,

                SUM(CASE WHEN HOUR(timein) = 0 THEN 1 ELSE 0 END) AS jam0,
                SUM(CASE WHEN HOUR(timein) = 1 THEN 1 ELSE 0 END) AS jam1,
                SUM(CASE WHEN HOUR(timein) = 2 THEN 1 ELSE 0 END) AS jam2,
                SUM(CASE WHEN HOUR(timein) = 3 THEN 1 ELSE 0 END) AS jam3,
                SUM(CASE WHEN HOUR(timein) = 4 THEN 1 ELSE 0 END) AS jam4,
                SUM(CASE WHEN HOUR(timein) = 5 THEN 1 ELSE 0 END) AS jam5,
                SUM(CASE WHEN HOUR(timein) = 6 THEN 1 ELSE 0 END) AS jam6,
                SUM(CASE WHEN HOUR(timein) = 7 THEN 1 ELSE 0 END) AS jam7,
                SUM(CASE WHEN HOUR(timein) = 8 THEN 1 ELSE 0 END) AS jam8,
                SUM(CASE WHEN HOUR(timein) = 9 THEN 1 ELSE 0 END) AS jam9,
                SUM(CASE WHEN HOUR(timein) = 10 THEN 1 ELSE 0 END) AS jam10,
                SUM(CASE WHEN HOUR(timein) = 11 THEN 1 ELSE 0 END) AS jam11,
                SUM(CASE WHEN HOUR(timein) = 12 THEN 1 ELSE 0 END) AS jam12,
                SUM(CASE WHEN HOUR(timein) = 13 THEN 1 ELSE 0 END) AS jam13,
                SUM(CASE WHEN HOUR(timein) = 14 THEN 1 ELSE 0 END) AS jam14,
                SUM(CASE WHEN HOUR(timein) = 15 THEN 1 ELSE 0 END) AS jam15,
                SUM(CASE WHEN HOUR(timein) = 16 THEN 1 ELSE 0 END) AS jam16,
                SUM(CASE WHEN HOUR(timein) = 17 THEN 1 ELSE 0 END) AS jam17,
                SUM(CASE WHEN HOUR(timein) = 18 THEN 1 ELSE 0 END) AS jam18,
                SUM(CASE WHEN HOUR(timein) = 19 THEN 1 ELSE 0 END) AS jam19,
                SUM(CASE WHEN HOUR(timein) = 20 THEN 1 ELSE 0 END) AS jam20,
                SUM(CASE WHEN HOUR(timein) = 21 THEN 1 ELSE 0 END) AS jam21,
                SUM(CASE WHEN HOUR(timein) = 22 THEN 1 ELSE 0 END) AS jam22,
                SUM(CASE WHEN HOUR(timein) = 23 THEN 1 ELSE 0 END) AS jam23

            FROM transactions
            WHERE DATE(timein) BETWEEN ? AND ?
            AND posoutid = 21
            GROUP BY DATE(timein)
            ORDER BY DATE(timein);
        ", [$startDate, $endDate]);

        $pkm2_datahours = DB::select("
            SELECT
                DATE(timein) AS tanggal,
                COUNT(*) AS total,

                SUM(CASE WHEN HOUR(timein) = 0 THEN 1 ELSE 0 END) AS jam0,
                SUM(CASE WHEN HOUR(timein) = 1 THEN 1 ELSE 0 END) AS jam1,
                SUM(CASE WHEN HOUR(timein) = 2 THEN 1 ELSE 0 END) AS jam2,
                SUM(CASE WHEN HOUR(timein) = 3 THEN 1 ELSE 0 END) AS jam3,
                SUM(CASE WHEN HOUR(timein) = 4 THEN 1 ELSE 0 END) AS jam4,
                SUM(CASE WHEN HOUR(timein) = 5 THEN 1 ELSE 0 END) AS jam5,
                SUM(CASE WHEN HOUR(timein) = 6 THEN 1 ELSE 0 END) AS jam6,
                SUM(CASE WHEN HOUR(timein) = 7 THEN 1 ELSE 0 END) AS jam7,
                SUM(CASE WHEN HOUR(timein) = 8 THEN 1 ELSE 0 END) AS jam8,
                SUM(CASE WHEN HOUR(timein) = 9 THEN 1 ELSE 0 END) AS jam9,
                SUM(CASE WHEN HOUR(timein) = 10 THEN 1 ELSE 0 END) AS jam10,
                SUM(CASE WHEN HOUR(timein) = 11 THEN 1 ELSE 0 END) AS jam11,
                SUM(CASE WHEN HOUR(timein) = 12 THEN 1 ELSE 0 END) AS jam12,
                SUM(CASE WHEN HOUR(timein) = 13 THEN 1 ELSE 0 END) AS jam13,
                SUM(CASE WHEN HOUR(timein) = 14 THEN 1 ELSE 0 END) AS jam14,
                SUM(CASE WHEN HOUR(timein) = 15 THEN 1 ELSE 0 END) AS jam15,
                SUM(CASE WHEN HOUR(timein) = 16 THEN 1 ELSE 0 END) AS jam16,
                SUM(CASE WHEN HOUR(timein) = 17 THEN 1 ELSE 0 END) AS jam17,
                SUM(CASE WHEN HOUR(timein) = 18 THEN 1 ELSE 0 END) AS jam18,
                SUM(CASE WHEN HOUR(timein) = 19 THEN 1 ELSE 0 END) AS jam19,
                SUM(CASE WHEN HOUR(timein) = 20 THEN 1 ELSE 0 END) AS jam20,
                SUM(CASE WHEN HOUR(timein) = 21 THEN 1 ELSE 0 END) AS jam21,
                SUM(CASE WHEN HOUR(timein) = 22 THEN 1 ELSE 0 END) AS jam22,
                SUM(CASE WHEN HOUR(timein) = 23 THEN 1 ELSE 0 END) AS jam23

            FROM transactions
            WHERE DATE(timein) BETWEEN ? AND ?
            AND posoutid = 22
            GROUP BY DATE(timein)
            ORDER BY DATE(timein);
        ", [$startDate, $endDate]);

        $pkmo_datahours = DB::select("
            SELECT
                DATE(timein) AS tanggal,
                COUNT(*) AS total,

                SUM(CASE WHEN HOUR(timein) = 0 THEN 1 ELSE 0 END) AS jam0,
                SUM(CASE WHEN HOUR(timein) = 1 THEN 1 ELSE 0 END) AS jam1,
                SUM(CASE WHEN HOUR(timein) = 2 THEN 1 ELSE 0 END) AS jam2,
                SUM(CASE WHEN HOUR(timein) = 3 THEN 1 ELSE 0 END) AS jam3,
                SUM(CASE WHEN HOUR(timein) = 4 THEN 1 ELSE 0 END) AS jam4,
                SUM(CASE WHEN HOUR(timein) = 5 THEN 1 ELSE 0 END) AS jam5,
                SUM(CASE WHEN HOUR(timein) = 6 THEN 1 ELSE 0 END) AS jam6,
                SUM(CASE WHEN HOUR(timein) = 7 THEN 1 ELSE 0 END) AS jam7,
                SUM(CASE WHEN HOUR(timein) = 8 THEN 1 ELSE 0 END) AS jam8,
                SUM(CASE WHEN HOUR(timein) = 9 THEN 1 ELSE 0 END) AS jam9,
                SUM(CASE WHEN HOUR(timein) = 10 THEN 1 ELSE 0 END) AS jam10,
                SUM(CASE WHEN HOUR(timein) = 11 THEN 1 ELSE 0 END) AS jam11,
                SUM(CASE WHEN HOUR(timein) = 12 THEN 1 ELSE 0 END) AS jam12,
                SUM(CASE WHEN HOUR(timein) = 13 THEN 1 ELSE 0 END) AS jam13,
                SUM(CASE WHEN HOUR(timein) = 14 THEN 1 ELSE 0 END) AS jam14,
                SUM(CASE WHEN HOUR(timein) = 15 THEN 1 ELSE 0 END) AS jam15,
                SUM(CASE WHEN HOUR(timein) = 16 THEN 1 ELSE 0 END) AS jam16,
                SUM(CASE WHEN HOUR(timein) = 17 THEN 1 ELSE 0 END) AS jam17,
                SUM(CASE WHEN HOUR(timein) = 18 THEN 1 ELSE 0 END) AS jam18,
                SUM(CASE WHEN HOUR(timein) = 19 THEN 1 ELSE 0 END) AS jam19,
                SUM(CASE WHEN HOUR(timein) = 20 THEN 1 ELSE 0 END) AS jam20,
                SUM(CASE WHEN HOUR(timein) = 21 THEN 1 ELSE 0 END) AS jam21,
                SUM(CASE WHEN HOUR(timein) = 22 THEN 1 ELSE 0 END) AS jam22,
                SUM(CASE WHEN HOUR(timein) = 23 THEN 1 ELSE 0 END) AS jam23

            FROM transactions
            WHERE DATE(timein) BETWEEN ? AND ?
            AND posoutid = 23
            GROUP BY DATE(timein)
            ORDER BY DATE(timein);
        ", [$startDate, $endDate]);

        // $car_datahours_in = DB::select("
        //     SELECT
        //         DATE(timeout) AS tanggal,
        //         COUNT(timein) AS total,
        //         SUM(CASE WHEN HOUR(timein) = 0 THEN 1 ELSE 0 END) AS jam0,
        //         SUM(CASE WHEN HOUR(timein) = 1 THEN 1 ELSE 0 END) AS jam1,
        //         SUM(CASE WHEN HOUR(timein) = 2 THEN 1 ELSE 0 END) AS jam2,
        //         SUM(CASE WHEN HOUR(timein) = 3 THEN 1 ELSE 0 END) AS jam3,
        //         SUM(CASE WHEN HOUR(timein) = 4 THEN 1 ELSE 0 END) AS jam4,
        //         SUM(CASE WHEN HOUR(timein) = 5 THEN 1 ELSE 0 END) AS jam5,
        //         SUM(CASE WHEN HOUR(timein) = 6 THEN 1 ELSE 0 END) AS jam6,
        //         SUM(CASE WHEN HOUR(timein) = 7 THEN 1 ELSE 0 END) AS jam7,
        //         SUM(CASE WHEN HOUR(timein) = 8 THEN 1 ELSE 0 END) AS jam8,
        //         SUM(CASE WHEN HOUR(timein) = 9 THEN 1 ELSE 0 END) AS jam9,
        //         SUM(CASE WHEN HOUR(timein) = 10 THEN 1 ELSE 0 END) AS jam10,
        //         SUM(CASE WHEN HOUR(timein) = 11 THEN 1 ELSE 0 END) AS jam11,
        //         SUM(CASE WHEN HOUR(timein) = 12 THEN 1 ELSE 0 END) AS jam12,
        //         SUM(CASE WHEN HOUR(timein) = 13 THEN 1 ELSE 0 END) AS jam13,
        //         SUM(CASE WHEN HOUR(timein) = 14 THEN 1 ELSE 0 END) AS jam14,
        //         SUM(CASE WHEN HOUR(timein) = 15 THEN 1 ELSE 0 END) AS jam15,
        //         SUM(CASE WHEN HOUR(timein) = 16 THEN 1 ELSE 0 END) AS jam16,
        //         SUM(CASE WHEN HOUR(timein) = 17 THEN 1 ELSE 0 END) AS jam17,
        //         SUM(CASE WHEN HOUR(timein) = 18 THEN 1 ELSE 0 END) AS jam18,
        //         SUM(CASE WHEN HOUR(timein) = 19 THEN 1 ELSE 0 END) AS jam19,
        //         SUM(CASE WHEN HOUR(timein) = 20 THEN 1 ELSE 0 END) AS jam20,
        //         SUM(CASE WHEN HOUR(timein) = 21 THEN 1 ELSE 0 END) AS jam21,
        //         SUM(CASE WHEN HOUR(timein) = 22 THEN 1 ELSE 0 END) AS jam22,
        //         SUM(CASE WHEN HOUR(timein) = 23 THEN 1 ELSE 0 END) AS jam23
        //     FROM transactions
        //     WHERE DATE(timeout) BETWEEN ? AND ?
        //         AND vehicleid IN ('Mobil')
        //         AND paymentby IN ('RFID', 'blue bird')
        //     GROUP BY DATE(timeout)
        //     ORDER BY DATE(timeout)
        //     ", [$startDate, $endDate]); 
            
        // $motorcycle_datahours_in = DB::select("
        //     SELECT
        //         DATE(timeout) AS tanggal,
        //         COUNT(timein) AS total,
        //         SUM(CASE WHEN HOUR(timein) = 0 THEN 1 ELSE 0 END) AS jam0,
        //         SUM(CASE WHEN HOUR(timein) = 1 THEN 1 ELSE 0 END) AS jam1,
        //         SUM(CASE WHEN HOUR(timein) = 2 THEN 1 ELSE 0 END) AS jam2,
        //         SUM(CASE WHEN HOUR(timein) = 3 THEN 1 ELSE 0 END) AS jam3,
        //         SUM(CASE WHEN HOUR(timein) = 4 THEN 1 ELSE 0 END) AS jam4,
        //         SUM(CASE WHEN HOUR(timein) = 5 THEN 1 ELSE 0 END) AS jam5,
        //         SUM(CASE WHEN HOUR(timein) = 6 THEN 1 ELSE 0 END) AS jam6,
        //         SUM(CASE WHEN HOUR(timein) = 7 THEN 1 ELSE 0 END) AS jam7,
        //         SUM(CASE WHEN HOUR(timein) = 8 THEN 1 ELSE 0 END) AS jam8,
        //         SUM(CASE WHEN HOUR(timein) = 9 THEN 1 ELSE 0 END) AS jam9,
        //         SUM(CASE WHEN HOUR(timein) = 10 THEN 1 ELSE 0 END) AS jam10,
        //         SUM(CASE WHEN HOUR(timein) = 11 THEN 1 ELSE 0 END) AS jam11,
        //         SUM(CASE WHEN HOUR(timein) = 12 THEN 1 ELSE 0 END) AS jam12,
        //         SUM(CASE WHEN HOUR(timein) = 13 THEN 1 ELSE 0 END) AS jam13,
        //         SUM(CASE WHEN HOUR(timein) = 14 THEN 1 ELSE 0 END) AS jam14,
        //         SUM(CASE WHEN HOUR(timein) = 15 THEN 1 ELSE 0 END) AS jam15,
        //         SUM(CASE WHEN HOUR(timein) = 16 THEN 1 ELSE 0 END) AS jam16,
        //         SUM(CASE WHEN HOUR(timein) = 17 THEN 1 ELSE 0 END) AS jam17,
        //         SUM(CASE WHEN HOUR(timein) = 18 THEN 1 ELSE 0 END) AS jam18,
        //         SUM(CASE WHEN HOUR(timein) = 19 THEN 1 ELSE 0 END) AS jam19,
        //         SUM(CASE WHEN HOUR(timein) = 20 THEN 1 ELSE 0 END) AS jam20,
        //         SUM(CASE WHEN HOUR(timein) = 21 THEN 1 ELSE 0 END) AS jam21,
        //         SUM(CASE WHEN HOUR(timein) = 22 THEN 1 ELSE 0 END) AS jam22,
        //         SUM(CASE WHEN HOUR(timein) = 23 THEN 1 ELSE 0 END) AS jam23
        //     FROM transactions
        //     WHERE DATE(timeout) BETWEEN ? AND ?
        //         AND vehicleid IN ('Motor')
        //         AND paymentby IN ('RFID', 'blue bird')
        //     GROUP BY DATE(timeout)
        //     ORDER BY DATE(timeout)
        //     ", [$startDate, $endDate]);

        $judul = 'Laporan QTY Transaksi Member'; // Ubah sesuai keinginan

        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report QTY Pos' . date('d F Y', strtotime($startDate)) . '.xlsx';
        } else {
            $fileName = 'Intermark - Report QTY Pos' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.xlsx';
        }
    
        // return Excel::download(new ReportQtyExport($car_datahours, $motorcycle_datahours, $results, $startDate, $endDate, $judul), $fileName);
        return Excel::download(new ReportQtyPosExport($results, $pmm1_datahours, $pmm2_datahours, 
        $pmmo_datahours, $pkm1_datahours, $pkm2_datahours, $pkmo_datahours,
        $startDate, $endDate, $judul), $fileName);
    }

    public function downloadExcelAmountPos(Request $request) {
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
            paymentby IN ('RFID', 'blue bird') AND
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
            AND paymentby IN ('RFID', 'blue bird')
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
            AND paymentby IN ('RFID', 'blue bird')
            GROUP BY DATE(timeout)
            ORDER BY DATE(timeout)
        ", [$startDate, $endDate]);

    $car_datahours_in = DB::select("
            SELECT
                DATE(timein) AS tanggal,
                COUNT(timein) AS total,
                SUM(CASE WHEN HOUR(timein) = 0 THEN cost ELSE 0 END) AS jam0,
                SUM(CASE WHEN HOUR(timein) = 1 THEN cost ELSE 0 END) AS jam1,
                SUM(CASE WHEN HOUR(timein) = 2 THEN cost ELSE 0 END) AS jam2,
                SUM(CASE WHEN HOUR(timein) = 3 THEN cost ELSE 0 END) AS jam3,
                SUM(CASE WHEN HOUR(timein) = 4 THEN cost ELSE 0 END) AS jam4,
                SUM(CASE WHEN HOUR(timein) = 5 THEN cost ELSE 0 END) AS jam5,
                SUM(CASE WHEN HOUR(timein) = 6 THEN cost ELSE 0 END) AS jam6,
                SUM(CASE WHEN HOUR(timein) = 7 THEN cost ELSE 0 END) AS jam7,
                SUM(CASE WHEN HOUR(timein) = 8 THEN cost ELSE 0 END) AS jam8,
                SUM(CASE WHEN HOUR(timein) = 9 THEN cost ELSE 0 END) AS jam9,
                SUM(CASE WHEN HOUR(timein) = 10 THEN cost ELSE 0 END) AS jam10,
                SUM(CASE WHEN HOUR(timein) = 11 THEN cost ELSE 0 END) AS jam11,
                SUM(CASE WHEN HOUR(timein) = 12 THEN cost ELSE 0 END) AS jam12,
                SUM(CASE WHEN HOUR(timein) = 13 THEN cost ELSE 0 END) AS jam13,
                SUM(CASE WHEN HOUR(timein) = 14 THEN cost ELSE 0 END) AS jam14,
                SUM(CASE WHEN HOUR(timein) = 15 THEN cost ELSE 0 END) AS jam15,
                SUM(CASE WHEN HOUR(timein) = 16 THEN cost ELSE 0 END) AS jam16,
                SUM(CASE WHEN HOUR(timein) = 17 THEN cost ELSE 0 END) AS jam17,
                SUM(CASE WHEN HOUR(timein) = 18 THEN cost ELSE 0 END) AS jam18,
                SUM(CASE WHEN HOUR(timein) = 19 THEN cost ELSE 0 END) AS jam19,
                SUM(CASE WHEN HOUR(timein) = 20 THEN cost ELSE 0 END) AS jam20,
                SUM(CASE WHEN HOUR(timein) = 21 THEN cost ELSE 0 END) AS jam21,
                SUM(CASE WHEN HOUR(timein) = 22 THEN cost ELSE 0 END) AS jam22,
                SUM(CASE WHEN HOUR(timein) = 23 THEN cost ELSE 0 END) AS jam23
            FROM transactions
            WHERE DATE(timein) BETWEEN ? AND ?
                AND vehicleid IN ('Mobil')
                AND paymentby IN ('RFID', 'blue bird')
            GROUP BY DATE(timein)
            ORDER BY DATE(timein)
            ", [$startDate, $endDate]); 
            
        $motorcycle_datahours_in = DB::select("
            SELECT
                DATE(timein) AS tanggal,
                COUNT(timein) AS total,
                SUM(CASE WHEN HOUR(timein) = 0 THEN cost ELSE 0 END) AS jam0,
                SUM(CASE WHEN HOUR(timein) = 1 THEN cost ELSE 0 END) AS jam1,
                SUM(CASE WHEN HOUR(timein) = 2 THEN cost ELSE 0 END) AS jam2,
                SUM(CASE WHEN HOUR(timein) = 3 THEN cost ELSE 0 END) AS jam3,
                SUM(CASE WHEN HOUR(timein) = 4 THEN cost ELSE 0 END) AS jam4,
                SUM(CASE WHEN HOUR(timein) = 5 THEN cost ELSE 0 END) AS jam5,
                SUM(CASE WHEN HOUR(timein) = 6 THEN cost ELSE 0 END) AS jam6,
                SUM(CASE WHEN HOUR(timein) = 7 THEN cost ELSE 0 END) AS jam7,
                SUM(CASE WHEN HOUR(timein) = 8 THEN cost ELSE 0 END) AS jam8,
                SUM(CASE WHEN HOUR(timein) = 9 THEN cost ELSE 0 END) AS jam9,
                SUM(CASE WHEN HOUR(timein) = 10 THEN cost ELSE 0 END) AS jam10,
                SUM(CASE WHEN HOUR(timein) = 11 THEN cost ELSE 0 END) AS jam11,
                SUM(CASE WHEN HOUR(timein) = 12 THEN cost ELSE 0 END) AS jam12,
                SUM(CASE WHEN HOUR(timein) = 13 THEN cost ELSE 0 END) AS jam13,
                SUM(CASE WHEN HOUR(timein) = 14 THEN cost ELSE 0 END) AS jam14,
                SUM(CASE WHEN HOUR(timein) = 15 THEN cost ELSE 0 END) AS jam15,
                SUM(CASE WHEN HOUR(timein) = 16 THEN cost ELSE 0 END) AS jam16,
                SUM(CASE WHEN HOUR(timein) = 17 THEN cost ELSE 0 END) AS jam17,
                SUM(CASE WHEN HOUR(timein) = 18 THEN cost ELSE 0 END) AS jam18,
                SUM(CASE WHEN HOUR(timein) = 19 THEN cost ELSE 0 END) AS jam19,
                SUM(CASE WHEN HOUR(timein) = 20 THEN cost ELSE 0 END) AS jam20,
                SUM(CASE WHEN HOUR(timein) = 21 THEN cost ELSE 0 END) AS jam21,
                SUM(CASE WHEN HOUR(timein) = 22 THEN cost ELSE 0 END) AS jam22,
                SUM(CASE WHEN HOUR(timein) = 23 THEN cost ELSE 0 END) AS jam23
            FROM transactions
            WHERE DATE(timein) BETWEEN ? AND ?
                AND vehicleid IN ('Motor')
                AND paymentby IN ('RFID', 'blue bird')
            GROUP BY DATE(timein)
            ORDER BY DATE(timein)
            ", [$startDate, $endDate]);

    
        $judul = 'Laporan Pendapatan Transaksi';

        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report Pos In & Out' . date('d F Y', strtotime($startDate)) . '.xlsx';
        } else {
            $fileName = 'Intermark - Report Pos In & Out' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.xlsx';
        }
    
        return Excel::download(new ReportAmountExport($results, $car_duration, $motorcycle_duration, 
        $car_datahours_in, $motorcycle_datahours_in, $startDate, $endDate, $judul), $fileName);
    }
   
}