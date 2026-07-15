<?php

namespace App\Http\Controllers;

use App\Models\ParkingSlot;
use App\Models\ParkingZone;
use App\Models\MemberPackage;
use App\Models\RfidVehicle;
use App\Models\VehicleType;
use App\Models\MemberHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RfidExtendVehicleController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage rfid vehicle')) {
            $vehicles = RfidVehicle::where('parent_id', '=', parentId())
            ->orderBy('end_date', 'desc')
            ->get();
            return view('rfid_extend.index', compact('vehicles'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        $members = RfidVehicle::where('parent_id', parentId())
            ->get()
            ->mapWithKeys(function ($member) {
                return [$member->id => $member->rfid_no . ' - ' . $member->name];
            });
        $members->prepend(__('Select Member '), '');
        return view('rfid_extend.create', compact('members'));
    }

    public function extend($id)
    {
        $vehicle = RfidVehicle::findOrFail($id);
        $vehicleTypes = VehicleType::pluck('title', 'id');
        $memberTypes = MemberPackage::where('parent_id', parentId())->get();
        return view('rfid_extend.edit', compact('vehicle', 'vehicleTypes', 'memberTypes'));
    }

    // public function update(Request $request, $id)
    // {
    //     $validator = \Validator::make(
    //         $request->all(), [
    //             // 'name' => 'required|string|max:255',
    //             // 'phone_number' => 'required|string|max:15',
    //             // 'company_name' => 'required|string|max:255',
    //             'membertype' => 'required|string',
    //             // 'vehicle_no' => 'required|string|max:20',
    //             // 'rfid_no' => 'required|string|max:50|unique:rfid_vehicles,rfid_no,' . $id,
    //             // 'price' => 'required|numeric',
    //             'start_date' => 'required|date',
    //             'end_date' => 'required|date|after_or_equal:start_date',
    //             'notes' => 'nullable|string'
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         return redirect()->back()->with('error', $validator->errors()->first());
    //     }

    //     $vehicle = RfidVehicle::findOrFail($id);
    //     // $vehicle->vehicle_no = $request->vehicle_no;
    //     // $vehicle->rfid_no = $request->rfid_no;
    //     // $vehicle->name = $request->name;
    //     // $vehicle->phone_number = $request->phone_number;
    //     $vehicle->notes = $request->notes;
    //     $vehicle->vehicleid = $request->vehicle_type;
    //     $vehicle->slot = $request->price;
    //     $vehicle->member_type = $request->membertype;
    //     $vehicle->start_date = $request->start_date;
    //     $vehicle->status = 'x';
    //     $vehicle->end_date = $request->end_date;
    //     $vehicle->save();

    //     $memberHistory = new MemberHistory();
    //     $memberHistory->member_id = $vehicle->id;
    //     $memberHistory->product_code = $request->membertype;
    //     $memberHistory->vehicle_id = $request->vehicle_type;
    //     $memberHistory->new = 0;
    //     $memberHistory->biaya = $request->price;
    //     $memberHistory->awal_berlaku = $request->start_date;
    //     $memberHistory->akhir_berlaku = $request->end_date;
    //     $memberHistory->save();

    //     return redirect()->back()->with('success', __('Berhasil Memperpanjang Masa Aktif RFID'));
    // }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(), [
                'membertype' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'notes' => 'nullable|string'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $vehicle = RfidVehicle::findOrFail($id);

            // UPDATE VEHICLE
            $vehicle->notes = $request->notes;
            $vehicle->vehicleid = $request->vehicle_type;
            $vehicle->slot = $request->price;
            $vehicle->member_type = $request->membertype;
            $vehicle->start_date = $request->start_date;
            $vehicle->status = 'x';
            $vehicle->end_date = $request->end_date;
            $vehicle->save();

            // INSERT HISTORY
            $memberHistory = new MemberHistory();
            $memberHistory->member_id = $vehicle->id;
            $memberHistory->product_code = $request->membertype;
            $memberHistory->vehicle_id = $request->vehicle_type;
            $memberHistory->new = 0;
            $memberHistory->biaya = $request->price;
            $memberHistory->awal_berlaku = $request->start_date;
            $memberHistory->akhir_berlaku = $request->end_date;
            $memberHistory->save();

            // ✅ jika semua sukses
            DB::commit();

            return redirect()->back()->with('success', __('Berhasil Memperpanjang Masa Aktif RFID NEHH'));

        } catch (\Exception $e) {

            // ❌ kalau ada error → rollback semua
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create rfid vehicle')) {
            $validator = \Validator::make(
                $request->all(), [
                    'zone' => 'required',
                    'type' => 'required',
                    'floor' => 'required',
                    'vehicle_no' => 'required',
                    'rfid_no' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $vehicle = new RfidVehicle();
            $vehicle->zone = $request->zone;
            $vehicle->type = $request->type;
            $vehicle->floor = $request->floor;
            $vehicle->slot = $request->slot;
            $vehicle->vehicle_no = $request->vehicle_no;
            $vehicle->rfid_no = $request->rfid_no;
            $vehicle->name = $request->name;
            $vehicle->phone_number = $request->phone_number;
            $vehicle->notes = $request->notes;
            $vehicle->vehicleid = $request->type;
            $vehicle->company_name = $request->company_name;
            $vehicle->member_type = $request->membertype;
            $vehicle->start_date = $request->start_date;
            $vehicle->end_date = $request->end_date;
            $vehicle->parent_id = parentId();
            $vehicle->save();

            return redirect()->back()->with('success', __('RFID vehicle successfully created.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(RfidVehicle $rfidVehicle)
    {
        //
    }


    public function edit(RfidVehicle $rfidVehicle)
    {
        $zones = ParkingZone::where('parent_id', parentId())->get()->pluck('zone_name', 'id');
        $zones->prepend(__('Select Zone'), '');

        $slots = ParkingSlot::where('zone', $rfidVehicle->zone)->get()->pluck('title', 'id');

        return view('rfid_vehicle.edit', compact('zones','rfidVehicle','slots'));
    }


    public function destroy(RfidVehicle $rfidVehicle)
    {
        if (\Auth::user()->can('delete rfid vehicle')) {
            $rfidVehicle->delete();
            return redirect()->back()->with('success', 'RFID vehicle successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
