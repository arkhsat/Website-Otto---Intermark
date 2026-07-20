<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\ParkingSlot;
use App\Models\ParkingZone;
use App\Models\MemberPackage;
use App\Models\RfidVehicle;
use App\Models\VehicleType;
use App\Models\MemberHistory;
use App\Models\Company;
use Illuminate\Http\Request;

class TandaTerimaController extends Controller
{

    public function index()
{
    $vehicleTypes = VehicleType::pluck('title', 'id');
    $memberTypes = MemberPackage::where('parent_id', parentId())->get();

    
    $companyList = DB::table('rfid_vehicles')
        ->leftJoin('member_package', 'member_package.product_code', '=', 'rfid_vehicles.member_type')
        ->whereNotIn('member_package.product_code', ['CM01', 'CM03', 'CM06', 'CM12'])
        ->where('rfid_vehicles.company_name', '<>', '')
        ->where('rfid_vehicles.rfid_no', '<>', '0')
        ->select('vehicle_no', 'company_name')
        ->get()
        ->mapWithKeys(function ($item) {
            $cleanNo = strtoupper(trim($item->vehicle_no));
            return [$cleanNo => $cleanNo . ' - ' . strtoupper($item->company_name)];
        });

    return view('tanda_terima.index', compact('vehicleTypes', 'memberTypes', 'companyList'));
}



    private function romanNumerals($bulan) {
        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $romawi[$bulan];
    }

    public function show(Request $request)
    {
    // Normalisasi input dari form
    $vehicleNos = collect($request->input('vehicle_no', []))
        ->map(function ($nopol) {
            return strtoupper(trim($nopol));
        })
        ->toArray();

    // Debug jika kosong
    if (empty($vehicleNos)) {
        return 'Tidak ada vehicle_no yang dipilih.';
    }

    // Counter & penomoran
    $path = storage_path('app/counter.txt');
    $number = file_exists($path) ? (int) file_get_contents($path) : 1;
    $bulanRomawi = $this->romanNumerals(now()->month);
    $tahun = now()->year;

    // Ambil data kendaraan dengan whereIn yang sudah dibersihkan
    // $vehicles = DB::table('rfid_vehicles')
    //     ->leftJoin('member_history', 'member_history.member_id', '=', 'rfid_vehicles.id')
    //     ->leftJoin('member_package', 'member_package.product_code', '=', 'member_history.product_code')
    //     ->leftJoin('member_history', 'member_history.new', '=', 'member_cardnew_status.status' ) // NEW
    //     ->leftJoin('member_history', 'member_history.new == 1', '=', 'member_package.newcard' ) // NEW
    //     ->whereIn(DB::raw('UPPER(TRIM(vehicle_no))'), $vehicleNos)
    //     ->where('rfid_vehicles.rfid_no', '<>', '0')
    //     ->whereNotNull('member_history.product_code')
    //     ->select(
    //             'vehicle_no',
    //             'company_name',
    //             'vehicleid',
    //             'member_history.product_code',
    //             'member_package.keterangan',
    //             'member_history.member_id',
    //             // 'member_history.biaya'
    //             'member_package.price as biaya',
    //             'member_package.newcard as newcard' // NEW
    //     )
    //     ->orderBy('member_history.id', 'desc')
    //     ->get();
    // $vehicles = DB::table('rfid_vehicles')
    //     ->leftJoin('member_history', 'member_history.member_id', '=', 'rfid_vehicles.id')
    //     ->leftJoin('member_package', 'member_package.product_code', '=', 'member_history.product_code')

    //     ->whereIn(DB::raw('UPPER(TRIM(vehicle_no))'), $vehicleNos)
    //     ->where('rfid_vehicles.rfid_no', '<>', '0')
    //     ->whereNotNull('member_history.product_code')

    //     ->select(
    //         'vehicle_no',
    //         'company_name',
    //         'vehicleid',
    //         'member_history.product_code',
    //         'member_package.keterangan',
    //         'member_history.member_id',

    //         // harga paket
    //         'member_package.price as biaya',

    //         // tampilkan harga new card hanya jika member_history.new = 1
    //         DB::raw("
    //             CASE
    //                 WHEN member_history.new = 1
    //                 THEN member_package.newcard
    //                 ELSE NULL
    //             END as newcard
    //         ")
    //     )

    //     ->orderBy('member_history.id', 'desc')
    //     ->get();
    $latestHistory = DB::table('member_history')
        ->select('member_id', DB::raw('MAX(id) as id'))
        ->groupBy('member_id');

    $vehicles = DB::table('rfid_vehicles')
        ->leftJoinSub($latestHistory, 'latest', function ($join) {
            $join->on('rfid_vehicles.id', '=', 'latest.member_id');
        })
        // ->leftJoin('member_history', 'member_history.member_id', '=', 'rfid_vehicles.id')
        ->leftJoin('member_history', 'member_history.id', '=', 'latest.id')
        ->leftJoin('member_package', 'member_package.product_code', '=', 'member_history.product_code')

        ->whereIn(DB::raw('UPPER(TRIM(rfid_vehicles.vehicle_no))'), $vehicleNos)
        ->where('rfid_vehicles.rfid_no', '<>', '0')
        ->whereNotNull('member_history.product_code')
        ->where('member_package.price', '>', 0) // ← Tambahkan di sini

        ->select(
            'rfid_vehicles.vehicle_no',
            'rfid_vehicles.company_name',
            'rfid_vehicles.vehicleid',
            'member_history.product_code',
            'member_package.keterangan',
            'member_history.member_id',
            'member_package.price as biaya',

            DB::raw("
                CASE
                    WHEN member_history.new = 1
                    THEN member_package.newcard
                    ELSE NULL
                END AS newcard
            ")
        )
        ->get();

        dd($vehicles);

    // Kelompokkan berdasarkan company_name
    $grouped = $vehicles->groupBy('company_name');
    $invoices = [];

    foreach ($grouped as $companyName => $items) {
        $formatted = str_pad($number++, 3, '0', STR_PAD_LEFT);
        $nomor_full = "Otto-member/intrmk/{$formatted}/{$bulanRomawi}/{$tahun}";

        $data = $items->groupBy('product_code')->map(function ($group) {
        $first = $group->first();

        // Ambil vehicle_no unik (hindari duplikat karena join)
        $vehicle_nos = $group->pluck('vehicle_no')->unique();

        return (object)[
            'qty' => $vehicle_nos->count(),              
            'product_code' => $first->product_code,
            'keterangan' => $first->keterangan,
            'biaya' => $first->biaya,
            'vehicleid' => $first->vehicleid,
            'vehicle_nos' => $vehicle_nos->values(),  
            'newcard' => $first->newcard  // NEW
        ];
    })->values();



        $invoices[] = [
    'company_name' => $companyName,
    'nomor_full' => $nomor_full,
    'data' => $data,
    'vehicle_nos' => $items->groupBy('vehicleid')->map(function ($group) {
        return $group->pluck('vehicle_no')->unique()->values();
    })->toArray()
];
    }

    file_put_contents($path, $number);

    if (empty($invoices)) {
        return 'Tidak ada data ditemukan.';
    }

    return view('tanda_terima.tanda_terima', compact('invoices'));
}


}
