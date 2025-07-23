<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportPerpanjangMember;

class ReportMemberDailyController extends Controller
{
    public function getmemberReport(Request $request)
    {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $results = DB::select("
        SELECT DATE(mh.created_at) AS tanggal, rv.name AS nama, rv.company_name AS perusahaan, rv.vehicle_no AS nopol, 
        CASE WHEN mh.vehicle_id = 1 THEN 'MOBIL' ELSE 'MOTOR' END AS jenis_kendaraan,
        CASE WHEN mh.product_code IS NOT NULL THEN mp.keterangan ELSE mcs.keterangan END AS jenis_produk,
        mcs.keterangan AS keterangan,
        mh.biaya AS biaya
        FROM member_history mh
        LEFT JOIN rfid_vehicles rv ON mh.member_id = rv.id
        LEFT JOIN member_package mp ON mh.product_code = mp.product_code
        LEFT JOIN member_cardnew_status AS mcs ON mh.new = mcs.status
        WHERE DATE(mh.created_at) BETWEEN ? AND ?
        AND (mh.product_code LIKE 'B%' or mh.product_code LIKE 'C%')
        ORDER BY rv.company_name DESC;
            ",[$startDate, $endDate]);
        return view('reportmember.reportmemberdaily',compact('results', 'startDate', 'endDate'));
    }

    public function downloadpdfMember(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
        SELECT DATE(mh.created_at) AS tanggal, rv.name AS nama, rv.company_name AS perusahaan, rv.vehicle_no AS nopol, 
        CASE WHEN mh.vehicle_id = 1 THEN 'MOBIL' ELSE 'MOTOR' END AS jenis_kendaraan,
        CASE WHEN mh.product_code IS NOT NULL THEN mp.keterangan ELSE mcs.keterangan END AS jenis_produk,
        mcs.keterangan AS keterangan,
        mh.biaya AS biaya
        FROM member_history mh
        LEFT JOIN rfid_vehicles rv ON mh.member_id = rv.id
        LEFT JOIN member_package mp ON mh.product_code = mp.product_code
        LEFT JOIN member_cardnew_status AS mcs ON mh.new = mcs.status
        WHERE DATE(mh.created_at) BETWEEN ? AND ?
        AND (mh.product_code LIKE 'B%' or mh.product_code LIKE 'C%')
        ORDER BY rv.company_name DESC;
        ", [$startDate, $endDate]);
    
        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report Perpanjangan Member ' . date('d F Y', strtotime($startDate)) . '.pdf';
        } else {
            $fileName = 'Intermark - Report Perpanjangan Member ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.pdf';
        }
        $judul = 'Laporan Perpanjangan Member';
        $pdf = Pdf::loadView('PDF/pdfperpanjangmember', compact('results', 'startDate', 'endDate', 'judul'));
        
        return $pdf->download($fileName);
    }

    public function downloadexcelMember(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
        SELECT DATE(mh.created_at) AS tanggal, rv.name AS nama, rv.company_name AS perusahaan, rv.vehicle_no AS nopol, 
        CASE WHEN mh.vehicle_id = 1 THEN 'MOBIL' ELSE 'MOTOR' END AS jenis_kendaraan,
        CASE WHEN mh.product_code IS NOT NULL THEN mp.keterangan ELSE mcs.keterangan END AS jenis_produk,
        mcs.keterangan AS keterangan,
        mh.biaya AS biaya
        FROM member_history mh
        LEFT JOIN rfid_vehicles rv ON mh.member_id = rv.id
        LEFT JOIN member_package mp ON mh.product_code = mp.product_code
        LEFT JOIN member_cardnew_status AS mcs ON mh.new = mcs.status
        WHERE DATE(mh.created_at) BETWEEN ? AND ?
        AND (mh.product_code LIKE 'B%' or mh.product_code LIKE 'C%')
        ORDER BY rv.company_name DESC;
        ", [$startDate, $endDate]);
    
        $judul = 'Laporan Perpanjangan Member';

        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report Perpanjangan Member ' . date('d F Y', strtotime($startDate)) . '.xlsx';
        } else {
            $fileName = 'Intermark - Report Perpanjangan Member ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.xlsx';
        }
    
        return Excel::download(new ReportPerpanjangMember($results, $startDate, $endDate, $judul), $fileName);
    }
    
}
