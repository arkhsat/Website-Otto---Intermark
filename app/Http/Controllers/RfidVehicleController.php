<?php

namespace App\Http\Controllers;

use App\Models\ParkingSlot;
use App\Models\ParkingZone;
use App\Models\MemberPackage;
use App\Models\RfidVehicle;
use App\Models\VehicleType;
use App\Models\MemberHistory;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //

class RfidVehicleController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage rfid vehicle')) {
            $vehicles = RfidVehicle::leftJoin('member_package', 'rfid_vehicles.member_type', '=', 'member_package.product_code')
                ->where('rfid_vehicles.parent_id', parentId())
                ->where('rfid_vehicles.rfid_no', '!=', '0')
                ->select('rfid_vehicles.*', 'member_package.keterangan as member_type_keterangan')
                ->get();
    
            return view('rfid_vehicle.index', compact('vehicles'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show()
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
        $vehicleTypes = VehicleType::pluck('title', 'id');
        $memberTypes = MemberPackage::where('parent_id', parentId())->get();
        $company = Company::pluck('company_name', 'company_name');
        return view('rfid_vehicle.create', compact('vehicleTypes', 'memberTypes', 'company'));
    }

    public function create_car()
    {
        $vehicleTypes = VehicleType::pluck('title', 'id');
        $memberTypes = MemberPackage::where('parent_id', parentId())->get();
        $company = Company::pluck('company_name', 'company_name');
        return view('rfid_car.create', compact('vehicleTypes', 'memberTypes', 'company'));
    }

    public function extend(RfidVehicle $rfidVehicle)
    {
        
        $zones = ParkingZone::where('parent_id', parentId())->get()->pluck('zone_name', 'id');
        $zones->prepend(__('Select Zone'), '');

        $slots = ParkingSlot::where('zone', $rfidVehicle->zone)->get()->pluck('title', 'id');

        return view('rfid_vehicle.extend', compact('zones','rfidVehicle','slots'));
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create rfid vehicle')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:255',
                    'phone_number' => 'required|string|max:15',
                    'company_name' => 'required|string|max:255',
                    'membertype' => 'required|string',
                    // 'vehicleid' => 'required|string',
                    'vehicle_no' => 'required|string|max:20',
                    'price' => 'required|numeric',
                    'rfid_no' => 'required|string|unique:rfid_vehicles,rfid_no|max:50',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                    'notes' => 'nullable|string'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $vehicle = new RfidVehicle();
            $vehicle->vehicle_no = $request->vehicle_no;
            $vehicle->rfid_no = $request->rfid_no;
            $vehicle->name = $request->name;
            $vehicle->phone_number = $request->phone_number;
            $vehicle->notes = $request->notes;
            $vehicle->status = 'x';
            $vehicle->slot = $request->price;
            $vehicle->vehicleid = $request->vehicle_type; // Sesuai dengan form
            $vehicle->company_name = $request->company_name;
            $vehicle->member_type = $request->membertype; // Sesuai dengan form
            $vehicle->start_date = $request->start_date;
            $vehicle->end_date = $request->end_date;
            $vehicle->parent_id = parentId(); 
            $vehicle->save();

            $memberHistory = new MemberHistory();
            $memberHistory->member_id = $vehicle->id;
            $memberHistory->product_code = $request->membertype;
            $memberHistory->vehicle_id = $request->vehicle_type;
            $memberHistory->new = 1;
            $memberHistory->biaya = $request->price;
            $memberHistory->awal_berlaku = $request->start_date;
            $memberHistory->akhir_berlaku = $request->end_date;
            $memberHistory->save();

            return redirect()->back()->with('success', __('RFID vehicle successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function recipt($member_id)
    {
                // Ambil data member
                $member = MemberPayment::findOrFail($member_id);
        
                // Ambil data pembayaran terbaru untuk member
                $payment = Payment::where('id', $member_id)->latest()->first();
                
                // Pastikan member sudah melakukan pembayaran
                if (!$payment) {
                    return redirect()->route('rfid_vehicle.index')->with('error', 'Belum ada pembayaran.');
                }
        
                // Kirim data ke view untuk ditampilkan
                return view('rfid_vehicle.recipt', compact('member', 'payment'));
    }


    public function edit(RfidVehicle $rfidVehicle)
    {
        $rfidVehicle->start_date = date('Y-m-d', strtotime($rfidVehicle->start_date));
        $rfidVehicle->end_date = date('Y-m-d', strtotime($rfidVehicle->end_date));

        $vehicleTypes = VehicleType::pluck('title', 'id');
        $memberTypes = MemberPackage::where('parent_id', parentId())->get();
        $company = Company::pluck('company_name', 'company_name');
        return view('rfid_vehicle.edit', compact('rfidVehicle', 'vehicleTypes', 'memberTypes', 'company'));
    }

    public function update(Request $request, RfidVehicle $rfidVehicle)
    {
        $validator = \Validator::make(
            $request->all(), [
                'name' => 'required|string|max:255',
                'phone_number' => 'nullable|string|max:15',
                'company_name' => 'nullable|string|max:255',
                'vehicle_no' => 'required|string|max:20',
                'rfid_no' => 'required|string|max:100|unique:rfid_vehicles,rfid_no,' . $rfidVehicle->id,
                'start_date' => 'required|date',
                'vehicleid' => 'integer|string',
                'end_date' => 'required|date|after_or_equal:start_date',
                'notes' => 'nullable|string',
                'card_status' => 'nullable|in:lost,damaged,blokir,activate',
            ]
        );
    
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
    
        try {
            $oldName = $rfidVehicle->name;
            $oldPhoneNumber = $rfidVehicle->phone_number;
            $oldVehicleId = $rfidVehicle->vehicleid;
            $oldNopol = $rfidVehicle->vehicle_no;
            $oldCompany = $rfidVehicle->company_name;
            $oldRfidNo = $rfidVehicle->rfid_no;

            $rfidVehicle->vehicle_no = $request->vehicle_no;
            $rfidVehicle->rfid_no = $request->rfid_no;
            $rfidVehicle->name = $request->name;
            $rfidVehicle->phone_number = $request->phone_number;
            $rfidVehicle->notes = $request->notes;
            $rfidVehicle->vehicleid = $request->vehicleid;
            $rfidVehicle->company_name = $request->company_name;
            $rfidVehicle->start_date = $request->start_date;
            $rfidVehicle->end_date = $request->end_date;
            
            // dd($rfidVehicle->toArray());

            $rfidVehicle->save();

            if ($request->filled('card_status')) {
                $memberHistory = new MemberHistory();
                $memberHistory->member_id = $rfidVehicle->id;
                $memberHistory->vehicle_id = $request->vehicleid;
                $memberHistory->biaya = 0;
                $memberHistory->awal_berlaku = $request->start_date;
                $memberHistory->akhir_berlaku = $request->end_date;
    
                // Tentukan nilai kolom `new` berdasarkan status kartu
                if ($request->card_status === 'lost') {
                    $memberHistory->new = 2; // Kartu Hilang
                } elseif ($request->card_status === 'damaged') {
                    $memberHistory->new = 3; // Kartu Rusak
                } elseif ($request->card_status === 'blokir') {
                    $memberHistory->sebelum = $oldRfidNo;
                    $memberHistory->setelah = $request->rfid_no;
                    $memberHistory->new = 4; 
                } elseif ($request->card_status === 'activate') {
                    $memberHistory->sebelum = $oldRfidNo;
                    $memberHistory->setelah = $request->rfid_no;
                    $memberHistory->new = 5; 
                }

                $memberHistory->save();
            }

            if ($oldName !== $request->name) {
                $memberHistory = new MemberHistory();
                $memberHistory->member_id = $rfidVehicle->id;
                $memberHistory->vehicle_id = $request->vehicleid;
                $memberHistory->biaya = 0;
                $memberHistory->sebelum = $oldName;
                $memberHistory->setelah = $request->name;
                // $memberHistory->awal_berlaku = $request->start_date;
                // $memberHistory->akhir_berlaku = $request->end_date;
                $memberHistory->new = 100; // Perubahan pada nama
                $memberHistory->save();
            }
    
            if ($oldPhoneNumber !== $request->phone_number) {
                $memberHistory = new MemberHistory();
                $memberHistory->member_id = $rfidVehicle->id;
                $memberHistory->vehicle_id = $request->vehicleid;
                $memberHistory->biaya = 0;
                $memberHistory->sebelum = $oldPhoneNumber;
                $memberHistory->setelah = $request->phone_number;
                // $memberHistory->awal_berlaku = $request->start_date;
                // $memberHistory->akhir_berlaku = $request->end_date;
                $memberHistory->new = 101; // Perubahan pada nomor telepon
                $memberHistory->save();
            }
    
            if ($oldVehicleId !== $request->vehicleid) {
                $memberHistory = new MemberHistory();
                $memberHistory->member_id = $rfidVehicle->id;
                $memberHistory->vehicle_id = $request->vehicleid;
                $memberHistory->biaya = 0;
                $memberHistory->sebelum = $oldVehicleId;
                $memberHistory->setelah = $request->vehicleid;
                // $memberHistory->awal_berlaku = $request->start_date;
                // $memberHistory->akhir_berlaku = $request->end_date;
                $memberHistory->new = 102; // Perubahan pada jenis kendaraan
                $memberHistory->save();
            }
            
            if ($oldNopol !== $request->vehicle_no) {
                $memberHistory = new MemberHistory();
                $memberHistory->member_id = $rfidVehicle->id;
                $memberHistory->vehicle_id = $request->vehicleid;
                $memberHistory->biaya = 0;
                $memberHistory->sebelum = $oldNopol;
                $memberHistory->setelah = $request->vehicle_no;
                // $memberHistory->awal_berlaku = $request->start_date;
                // $memberHistory->akhir_berlaku = $request->end_date;
                $memberHistory->new = 103; // Perubahan pada nomor polisi
                $memberHistory->save();
            }

            if ($oldCompany !== $request->company_name) {
                $memberHistory = new MemberHistory();
                $memberHistory->member_id = $rfidVehicle->id;
                $memberHistory->vehicle_id = $request->vehicleid;
                $memberHistory->biaya = 0;
                $memberHistory->sebelum = $oldCompany;
                $memberHistory->setelah = $request->company_name;
                // $memberHistory->awal_berlaku = $request->start_date;
                // $memberHistory->akhir_berlaku = $request->end_date;
                $memberHistory->new = 104; // Perubahan pada nama perusahaan
                $memberHistory->save();
            }

            return redirect()->back()->with('success', __('RFID vehicle successfully updated.'));
    
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan error
            return redirect()->back()->with('error', __('Failed to update RFID vehicle: ') . $e->getMessage());
        }
    }

    public function extend_store(Request $request, RfidVehicle $rfidVehicle)
    {
        if (\Auth::user()->can('edit rfid vehicle')) {
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

            $rfidVehicle->zone = $request->zone;
            $rfidVehicle->type = $request->type;
            $rfidVehicle->floor = $request->floor;
            $rfidVehicle->slot = $request->slot;
            $rfidVehicle->vehicle_no = $request->vehicle_no;
            $rfidVehicle->rfid_no = $request->rfid_no;
            $rfidVehicle->name = $request->name;
            $rfidVehicle->phone_number = $request->phone_number;
            $rfidVehicle->notes = $request->notes;
            $rfidVehicle->save();

            return redirect()->back()->with('success', __('RFID vehicle successfully updated.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
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
