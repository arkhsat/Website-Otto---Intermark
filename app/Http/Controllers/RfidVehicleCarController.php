<?php

namespace App\Http\Controllers;

use App\Models\ParkingSlot;
use App\Models\ParkingZone;
use App\Models\MemberPackage;
use App\Models\RfidVehicleCar;
use App\Models\VehicleType;
use App\Models\MemberHistory;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //

class RfidVehicleCarController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage rfid vehicle')) {
            $vehicles = DB::table('rfid_car')->get();
    
            return view('rfid_car.index', compact('vehicles'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        return view('rfid_car.create');
    }



    public function store(Request $request)
    {
            $validator = \Validator::make(
                $request->all(),
                [
                    'rfid_no' => 'required|string|unique:rfid_vehicles,rfid_no|max:50'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $vehicle = new RfidVehicleCar();
            $vehicle->rfid_no = $request->rfid_no;
            $vehicle->save(); // ✅ tambahkan ini

            return redirect()->back()->with('success', __('RFID vehicle successfully created.'));
    }


    // RfidVehicleCarController.php
    public function edit($id)
    {
        $rfidVehiclecar = RfidVehicleCar::findOrFail($id);
        return view('rfid_car.edit', compact('rfidVehiclecar'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'rfid_no' => 'required|string|max:100|unique:rfid_car,rfid_no,' . $id,
        ]);

        $rfidVehiclecar = RfidVehicleCar::findOrFail($id);
        $rfidVehiclecar->update([
            'rfid_no' => $request->rfid_no,
        ]);

        return redirect()->back()->with('success', 'RFID vehicle successfully updated.');
    }

    public function destroy(RfidVehicleCar $rfidVehiclecar)
    {
        if (\Auth::user()->can('delete rfid vehicle')) {
            $rfidVehiclecar->delete();
            return redirect()->back()->with('success', 'RFID vehicle successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
