<?php

namespace App\Http\Controllers;

use App\Exports\ReportDailyExport;
use App\Exports\ReportHotelUtama;
use App\Exports\ReportSBSRExports;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportHotelController extends Controller
{
    public function index()
    {   $reportname = NULL;
        return view('reporthotel.index', compact('reportname'));
    }

    public function dataTrxHotel(Request $request)
    {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $hotel = $request->input('hotel');
        if ($hotel == 'SBSR') {
            $results = DB::select("
                SELECT DATE(tr.timein) as tanggal, 
                ht.plat_no as nopol, ht.guest_name as nama, tr.vehicleid as jenis_kendaraan,
                tr.timein as tanggal_masuk, tr.datetransact as tanggal_keluar, ht.room_no as kamar, ht.type as tipe_guest, 
                CASE
                    WHEN ht.type = 1 THEN 'Hotel Guest'
                    WHEN ht.type = 2 THEN 'Event Hotel'
                END AS tipe_guest
                FROM transactions tr
                LEFT JOIN hotels ht
                ON tr.tiketno=ht.uidno
                WHERE tr.paymentby = 'Hotel'
                AND ht.user_id = 7
                AND DATE(tr.datetransact) BETWEEN ? AND ?
                AND tr.alreadyout='x'
                GROUP BY tr.datetransact", [$startDate, $endDate]);
            $reportname = 'Laporan Hotel Swiss Bell - SBSR';
        } else if ($hotel == 'SCSR') {
            $results = DB::select("
                SELECT 
                date(datetransact) as tanggal, ht.plat_no as nopol, ht.guest_name as nama, ht.type as tipe_guest,
                CASE when tr.vehicleid = 'Motor' then 1 END AS Motor,
                CASE when tr.vehicleid = 'Mobil' then 1 END AS Mobil,
                ht.created_at as tanggal_regis, ht.room_no as kamar, ht.type as tipe_guest,
                CASE
                    WHEN ht.type = 1 THEN 'Hotel Guest'
                    WHEN ht.type = 2 THEN 'Event Hotel'
                END AS tipe_guest
                FROM transactions tr
                LEFT JOIN hotels ht
                ON tr.tiketno=ht.uidno
                WHERE tr.paymentby = 'Hotel'
                AND ht.user_id = 10
                AND DATE(tr.datetransact) BETWEEN ? AND ?
                AND tr.alreadyout='x'
                GROUP BY plat_no, DATE(datetransact)
                ORDER BY DATE(datetransact)", [$startDate, $endDate]);
                $reportname = 'Laporan Hotel Swiss Bell Court - SCSR';
        } 
        return view('reporthotel.index', compact('results', 'reportname', 'hotel'));
    }

    public function downloadPDF(Request $request)
    {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $hotel = $request->input('hotel');
        if ($hotel == 'SBSR') {
            $results = DB::select("
                SELECT DATE(tr.timein) as tanggal, 
                ht.plat_no as nopol, ht.guest_name as nama, tr.vehicleid as jenis_kendaraan,
                tr.timein as tanggal_masuk, tr.datetransact as tanggal_keluar, ht.room_no as kamar, ht.type as tipe_guest,    
                CASE
                    WHEN ht.type = 1 THEN 'Hotel Guest'
                    WHEN ht.type = 2 THEN 'Event Hotel'
                END AS tipe_guest
                FROM transactions tr
                LEFT JOIN hotels ht
                ON tr.tiketno=ht.uidno
                WHERE tr.paymentby = 'Hotel'
                AND ht.user_id = 7
                AND DATE(tr.datetransact) BETWEEN ? AND ?
                AND tr.alreadyout='x'
                GROUP BY tr.datetransact", [$startDate, $endDate]);
            $reportname = 'Laporan Hotel Swiss Bell - SBSR';
            $pdf = PDF::loadView('pdf.pdfreportSBSR', compact('results', 'reportname', 'startDate', 'endDate'));

        } else if ($hotel == 'SCSR') {
            $results = DB::select("
                SELECT 
                date(datetransact) as tanggal, ht.plat_no as nopol, ht.guest_name as nama,
                CASE when tr.vehicleid = 'Motor' then 1 END AS Motor,
                CASE when tr.vehicleid = 'Mobil' then 1 END AS Mobil,
                ht.created_at as tanggal_regis, ht.room_no as kamar, ht.type as tipe_guest,    
                 CASE
                    WHEN ht.type = 1 THEN 'Hotel Guest'
                    WHEN ht.type = 2 THEN 'Event Hotel'
                END AS tipe_guest
                FROM transactions tr
                LEFT JOIN hotels ht
                ON tr.tiketno=ht.uidno
                WHERE tr.paymentby = 'Hotel'
                AND ht.user_id = 10
                AND DATE(tr.datetransact) BETWEEN ? AND ?
                AND tr.alreadyout='x'
                GROUP BY plat_no, DATE(datetransact)
                ORDER BY DATE(datetransact)", [$startDate, $endDate]);
            $reportname = 'Laporan Hotel Swiss Bell Court - SCSR';
            $pdf = PDF::loadView('pdf.pdfreportSCSR', compact('results', 'reportname', 'startDate', 'endDate'));

        } else {
            return response()->json(['error' => 'Hotel tidak dikenali.'], 400);
        }

        if ($startDate == $endDate) {
            $fileName = 'Laporan Hotel ' . $hotel . ' ' . date('d F Y', strtotime($startDate)) . '.pdf';
        } else {
            $fileName = 'Laporan Hotel ' . $hotel . ' ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.pdf';
        }


        return $pdf->download($fileName);
    }

    public function downloadExcel(Request $request)  {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $hotel = $request->input('hotel');
        if ($hotel == 'SBSR') {
            $results = DB::select("
                SELECT DATE(tr.timein) as tanggal, 
                ht.plat_no as nopol, ht.guest_name as nama, tr.vehicleid as jenis_kendaraan,
                tr.timein as tanggal_masuk, tr.datetransact as tanggal_keluar, ht.room_no as kamar, ht.type as tipe_guest,
                CASE
                    WHEN ht.type = 1 THEN 'Hotel Guest'
                    WHEN ht.type = 2 THEN 'Event Hotel'
                END AS tipe_guest
                FROM transactions tr
                LEFT JOIN hotels ht
                ON tr.tiketno=ht.uidno
                WHERE tr.paymentby = 'Hotel'
                AND ht.user_id = 7
                AND DATE(tr.datetransact) BETWEEN ? AND ?
                AND tr.alreadyout='x'
                GROUP BY tr.datetransact", [$startDate, $endDate]);
            $reportname = 'Laporan Hotel Swiss Bell - SBSR';
            $pdf = PDF::loadView('pdf.pdfreportSBSR', compact('results', 'reportname', 'startDate', 'endDate'));

        } else if ($hotel == 'SCSR') {
            $results = DB::select("
                SELECT 
                date(datetransact) as tanggal, ht.plat_no as nopol, ht.guest_name as nama,
                CASE when tr.vehicleid = 'Motor' then 1 END AS Motor,
                CASE when tr.vehicleid = 'Mobil' then 1 END AS Mobil,
                ht.created_at as tanggal_regis, ht.room_no as kamar, ht.type as tipe_guest,
                CASE
                    WHEN ht.type = 1 THEN 'Hotel Guest'
                    WHEN ht.type = 2 THEN 'Event Hotel'
                END AS tipe_guest
                FROM transactions tr
                LEFT JOIN hotels ht
                ON tr.tiketno=ht.uidno
                WHERE tr.paymentby = 'Hotel'
                AND ht.user_id = 10
                AND DATE(tr.datetransact) BETWEEN ? AND ?
                AND tr.alreadyout='x'
                GROUP BY plat_no, DATE(datetransact)
                ORDER BY DATE(datetransact)", [$startDate, $endDate]);
            $reportname = 'Laporan Hotel Swiss Bell Court - SCSR';
            $pdf = PDF::loadView('pdf.pdfreportSCSR', compact('results', 'reportname', 'startDate', 'endDate'));

        } else {
            return response()->json(['error' => 'Hotel tidak dikenali.'], 400);
        }

        if ($startDate == $endDate) {
            $fileName = 'Laporan Hotel ' . $hotel . ' ' . date('d F Y', strtotime($startDate)) . '.xlsx';
        } else {
            $fileName = 'Laporan Hotel ' . $hotel . ' ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.xlsx';
        }

        return Excel::download(new ReportHotelUtama($results, $startDate, $endDate, $reportname, $hotel), $fileName);
        
    }

   
}
