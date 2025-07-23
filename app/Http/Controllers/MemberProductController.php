<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemberPackage;

class MemberProductController extends Controller
{
    public function getVehicleProduct($vehicleid) {
        // Ambil data member_types berdasarkan vehicle_id
        $memberTypes = MemberPackage::where('vehicle_id', $vehicleid)
                                ->select('product_code', 'keterangan', 'price', 'month', 'newcard')
                                ->get();

        // Periksa apakah ada data
        if ($memberTypes->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Kembalikan data dalam format JSON
        return response()->json($memberTypes);
        }

    public function getMemberProduct($product_code) {
        // Ambil data member_types berdasarkan member_id
        $memberTypes = MemberPackage::where('product_code', $product_code)
                                ->select( 'keterangan')
                                ->get();

        // Periksa apakah ada data
        if ($memberTypes->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Kembalikan data dalam format JSON
        return response()->json($memberTypes);
    }
}
