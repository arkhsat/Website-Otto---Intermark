<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportEditMember;

class ReportMemberNonPaymentController extends Controller
{
    public function getmemberReport(Request $request)
    {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $results = DB::select("
        SELECT mh.created_at AS tanggal, rv.name AS nama, rv.company_name AS perusahaan, rv.vehicle_no AS nopol, 
        CASE WHEN mh.vehicle_id = 1 THEN 'MOBIL' ELSE 'MOTOR' END AS jenis_kendaraan,
        mh.sebelum AS data_sebelum, mh.setelah AS data_update,
        mcs.keterangan AS keterangan
        FROM member_history mh
        LEFT JOIN rfid_vehicles rv ON mh.member_id = rv.id
        LEFT JOIN member_cardnew_status AS mcs ON mh.new = mcs.status
        WHERE DATE(mh.created_at) BETWEEN ? AND ?
        AND mh.product_code IS NULL;
            ",[$startDate, $endDate]);
        return view('reportmember.reportmembernonpayment',compact('results', 'startDate', 'endDate'));
    }

    public function downloadpdfMember(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
        SELECT mh.created_at AS tanggal, rv.name AS nama, rv.company_name AS perusahaan, rv.vehicle_no AS nopol, 
        CASE WHEN mh.vehicle_id = 1 THEN 'MOBIL' ELSE 'MOTOR' END AS jenis_kendaraan,
        mh.sebelum AS data_sebelum, mh.setelah AS data_update,
        mcs.keterangan AS keterangan
        FROM member_history mh
        LEFT JOIN rfid_vehicles rv ON mh.member_id = rv.id
        LEFT JOIN member_cardnew_status AS mcs ON mh.new = mcs.status
        WHERE DATE(mh.created_at) BETWEEN ? AND ?
        AND mh.product_code IS NULL;
        ", [$startDate, $endDate]);
    
        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report Edit Data ' . date('d F Y', strtotime($startDate)) . '.pdf';
        } else {
            $fileName = 'Intermark - Report Edit Data ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.pdf';
        }
        $judul = 'Report Edit Data Member';
        
        $pdf = Pdf::loadView('PDF/pdfmembernonpayment', compact('results', 'startDate', 'endDate', 'judul'));
        
        return $pdf->download($fileName);
    }

    public function downloadexcelMember(Request $request) {
        $startDate = $request->input('entry_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));
        
        $results = DB::select("
        SELECT mh.created_at AS tanggal, rv.name AS nama, rv.company_name AS perusahaan, rv.vehicle_no AS nopol, 
        CASE WHEN mh.vehicle_id = 1 THEN 'MOBIL' ELSE 'MOTOR' END AS jenis_kendaraan,
        mh.sebelum AS data_sebelum, mh.setelah AS data_update,
        mcs.keterangan AS keterangan
        FROM member_history mh
        LEFT JOIN rfid_vehicles rv ON mh.member_id = rv.id
        LEFT JOIN member_cardnew_status AS mcs ON mh.new = mcs.status
        WHERE DATE(mh.created_at) BETWEEN ? AND ?
        AND mh.product_code IS NULL;
        ", [$startDate, $endDate]);
    
        $judul = 'Report Edit Data Member';

        if ($startDate == $endDate) {
            $fileName = 'Intermark - Report Edit Data ' . date('d F Y', strtotime($startDate)) . '.xlsx';
        } else {
            $fileName = 'Intermark - Report Edit Data ' . date('d F Y', strtotime($startDate)) . ' sd ' . date('d F Y', strtotime($endDate)) . '.xlsx';
        }
    
        return Excel::download(new ReportEditMember($results, $startDate, $endDate, $judul), $fileName);
    }


    
}
