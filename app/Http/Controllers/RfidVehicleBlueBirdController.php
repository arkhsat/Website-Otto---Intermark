<?php

namespace App\Http\Controllers;

use App\Models\ParkingSlot;
use App\Models\ParkingZone;
use App\Models\MemberPackage;
use App\Models\RfidVehicleBlueBird;
use App\Models\VehicleType;
use App\Models\MemberHistory;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //

class RfidVehicleBlueBirdController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage rfid vehicle')) {
            $vehicles = DB::table('blue_bird')->get();
    
            return view('rfid_bluebird.index', compact('vehicles'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        return view('rfid_bluebird.create');
    }



    public function store(Request $request)
    {
            $validator = \Validator::make(
                $request->all(),
                [
                    'uidno' => 'required|string|unique:blue_bird,uidno|max:50'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $vehicle = new RfidVehicleBlueBird();
            $vehicle->uidno = $request->uidno;
            $vehicle->save(); // ✅ tambahkan ini

            return redirect()->back()->with('success', __('RFID vehicle successfully created.'));
    }


    // RfidVehicleCarController.php
    public function edit($id)
    {
        $rfidVehicleblue_bird = RfidVehicleBlueBird::findOrFail($id);
        return view('rfid_bluebird.edit', compact('rfidVehicleblue_bird'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'uidno' => 'required|string|max:100|unique:blue_bird,uidno,' . $id,
        ]);

        $rfidVehiclebluebird = RfidVehicleBlueBird::findOrFail($id);
        $rfidVehiclebluebird->update([
            'uidno' => $request->uidno,
        ]);

        return redirect()->back()->with('success', 'RFID vehicle successfully updated.');
    }

    public function destroy(RfidVehicleBlueBird $rfidVehiclebluebird)
    {
        if (\Auth::user()->can('delete rfid vehicle')) {
            $rfidVehiclebluebird->delete();
            return redirect()->back()->with('success', 'RFID vehicle successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
