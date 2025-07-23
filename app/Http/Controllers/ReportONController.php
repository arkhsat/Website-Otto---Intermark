<?php

namespace App\Http\Controllers;

use App\Exports\ReportTransaksiCloseByON;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportPerpanjangMember;

class ReportONController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $results = DB::select("
        SELECT * FROM transactions WHERE timeout IS NOT NULL AND paymentby IS NULL 
        AND DATE(dateout) BETWEEN ? AND ?
            ",[$startDate, $endDate]);
        return view('reporton.index',compact('results', 'startDate', 'endDate'));
    }

    public function downloadPDF(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
        SELECT * FROM transactions WHERE timeout IS NOT NULL AND paymentby IS NULL 
        AND DATE(dateout) BETWEEN ? AND ?
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
        SELECT * FROM transactions WHERE timeout IS NOT NULL AND paymentby IS NULL 
        AND DATE(dateout) BETWEEN ? AND ?
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
