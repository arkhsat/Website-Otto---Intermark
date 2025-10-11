<?php

namespace App\Http\Controllers;

use App\Exports\ReportTrueBlueExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportVoucherTrueBlueController extends Controller
{
    public function index()
    {   $reportname = NULL;
        return view('reportvoucher.index-trueblue', compact('reportname'));
    }

    public function dataTrxHotel(Request $request)
    {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $hotel = 'True Blue Hotel Menteng';
            $results = DB::select("
                SELECT DATE(datetransact) AS tanggal, 
                DATE(dateout) AS tanggal_keluar, 
                vehicleid AS jenis_kendaraan, 
                nokartubank AS kode_voucher, 
                CASE WHEN nopolisi IS NULL THEN '-' ELSE nopolisi 
                END AS nopol, 
                CASE WHEN vehicleid = 'Motor' THEN 10000 
                     WHEN vehicleid = 'Mobil' THEN 15000
                END AS biaya 
                FROM transactions 
                WHERE paymentby = 'Hotel' 
                AND nokartubank IS NOT NULL 
                AND DATE(datetransact) BETWEEN ? AND ? 
                ORDER BY datetransact", [$startDate, $endDate]);
            $reportname = 'Laporan True Blue Hotel Menteng';
        return view('reportvoucher.index-trueblue', compact('results', 'reportname', 'hotel'));
    }

    public function downloadPDF(Request $request)
    {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $hotel = 'True Blue Hotel Menteng';
            $results = DB::select("
                SELECT DATE(datetransact) AS tanggal, 
                DATE(dateout) AS tanggal_keluar, 
                vehicleid AS jenis_kendaraan, 
                nokartubank AS kode_voucher, 
                CASE WHEN nopolisi IS NULL THEN '-' ELSE nopolisi 
                END AS nopol, 
                CASE WHEN vehicleid = 'Motor' THEN 10000 
                     WHEN vehicleid = 'Mobil' THEN 15000
                END AS biaya 
                FROM transactions 
                WHERE paymentby = 'Hotel' 
                AND nokartubank IS NOT NULL 
                AND DATE(datetransact) BETWEEN ? AND ? 
                ORDER BY datetransact", [$startDate, $endDate]);
                
        $reportname = 'Laporan True Blue Hotel Menteng';
        $pdf = PDF::loadView('pdf.pdfreportVoucherTrueBlue', compact('results', 'reportname', 'startDate', 'endDate'));

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
        $hotel = 'True Blue Hotel Menteng';
        $results = DB::select("
                SELECT DATE(datetransact) AS tanggal, 
                DATE(dateout) AS tanggal_keluar, 
                vehicleid AS jenis_kendaraan, 
                nokartubank AS kode_voucher, 
                CASE WHEN nopolisi IS NULL THEN '-' ELSE nopolisi 
                END AS nopol, 
                CASE WHEN vehicleid = 'Motor' THEN 10000 
                     WHEN vehicleid = 'Mobil' THEN 15000
                END AS biaya 
                FROM transactions 
                WHERE paymentby = 'Hotel' 
                AND nokartubank IS NOT NULL 
                AND DATE(datetransact) BETWEEN ? AND ? 
                ORDER BY datetransact", [$startDate, $endDate]);
        $reportname = 'Laporan True Blue Hotel Menteng';

        if ($startDate == $endDate) {
            $fileName = 'Laporan Hotel ' . $hotel . ' ' . date('d F Y', strtotime($startDate)) . '.xlsx';
        } else {
            $fileName = 'Laporan Hotel ' . $hotel . ' ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.xlsx';
        }

        return Excel::download(new ReportTrueBlueExport($results, $startDate, $endDate, $reportname, $hotel), $fileName);
        
    }

   
}
