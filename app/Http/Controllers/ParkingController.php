<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\Transaction;
use App\Models\ParkingSlot;
use App\Models\ParkingZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class ParkingController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage parking')) {
            $parkings = \DB::table('transactions')
                ->leftJoin('hotels', 'transactions.tiketno', '=', 'hotels.uidno')
                ->select('transactions.*')
                ->whereNull('transactions.dateout')
                ->whereNull('transactions.alreadyout')
                ->where('transactions.statusparking', '=', 'Casual')
                ->whereDate('transactions.timein', '>', \DB::raw('CURDATE() - INTERVAL 7 DAY'))
                ->where(function($query) {
                    $query->whereNull('hotels.id')
                        ->orWhere('hotels.check_out', '<=', now());
                })
                ->groupBy('transactions.transactionid')
                ->orderBy('transactions.dateout', 'desc')
                ->get();

            return view('parking.index', compact('parkings'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        $zones = ParkingZone::where('parent_id', parentId())->get()->pluck('zone_name', 'id');
        $zones->prepend(__('Select Zone'), '');

        $status = Parking::$status;
        return view('parking.create', compact('zones', 'status'));
    }


    public function store(Request $request)
    {

        if (\Auth::user()->can('create parking')) {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'phone_number' => 'required',
                    'zone' => 'required',
                    'type' => 'required',
                    'slot' => 'required',
                    'floor' => 'required',
                    'vehicle_number' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $parking = new Parking();
            $parking->parking_id = $this->parkingNumber();
            $parking->name = $request->name;
            $parking->phone_number = $request->phone_number;
            $parking->vehicle_number = $request->vehicle_number;
            $parking->zone = $request->zone;
            $parking->type = $request->type;
            $parking->floor = $request->floor;
            $parking->slot = $request->slot;
            $parking->status = $request->status;
            $parking->entry_date = $request->entry_date;
            $parking->entry_time = $request->entry_time;
            $parking->notes = $request->notes;
            $parking->parent_id = parentId();
            $parking->save();

            if (!empty($parking)) {
                $slot = ParkingSlot::find($request->slot);
                $slot->is_available = 0;
                $slot->save();
            }
            return redirect()->back()->with('success', __('Parking successfully created.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show($id)
    {
        $parking = Parking::find(Crypt::decrypt($id));
        $settings = settings();
        return view('parking.show', compact('parking', 'settings'));
    }


    public function edit(Parking $parking)
    {
        $zones = ParkingZone::where('parent_id', parentId())->get()->pluck('zone_name', 'id');
        $zones->prepend(__('Select Zone'), '');

        $status = Parking::$status;

        $slots = ParkingSlot::where('zone', $parking->zone)->get()->pluck('title', 'id');
        return view('parking.edit', compact('zones', 'status', 'parking', 'slots'));
    }


    public function update(Request $request, Parking $parking)
    {
        if (\Auth::user()->can('edit parking')) {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'phone_number' => 'required',
                    'zone' => 'required',
                    'type' => 'required',
                    'slot' => 'required',
                    'floor' => 'required',
                    'vehicle_number' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $parking->name = $request->name;
            $parking->phone_number = $request->phone_number;
            $parking->vehicle_number = $request->vehicle_number;
            $parking->zone = $request->zone;
            $parking->type = $request->type;
            $parking->floor = $request->floor;
            $parking->slot = $request->slot;
            $parking->status = $request->status;
            $parking->entry_date = $request->entry_date;
            $parking->entry_time = $request->entry_time;
            $parking->notes = $request->notes;
            $parking->save();

            return redirect()->back()->with('success', __('Parking successfully updated.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function close($transactionid){
        if (\Auth::user()->can('delete parking')) {
            $parking = Transaction::where('transactionid', $transactionid)->firstOrFail();
            $parking->paymentby = 'CloseByON';
            $parking->alreadyout = 'x';
            $parking->dateout = Carbon::now()->format('Y-m-d H:i:s');

            $parking->save();

            return redirect()->back()->with('success', __('Parking successfully closed.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(Parking $parking)
    {
        if (\Auth::user()->can('delete parking')) {
            $parking->delete();
            return redirect()->back()->with('success', 'Parking successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getSlot($floorId, $zoneId, $typeId)
    {
        $slots = ParkingSlot::where('is_available', 1)->where('zone', $zoneId)->where('floor', $floorId)->where('type', $typeId)->get()->pluck('title', 'id');
        return response()->json($slots);
    }

    function parkingNumber()
    {
        $latest = Parking::where('parent_id', parentId())->latest()->first();
        if (!$latest) {
            return 1;
        }
        return $latest->parking_id + 1;
    }

    public function exitVehicle($parking_id, $amount)
    {

        return view('parking.exit_vehicle', compact('parking_id', 'amount'));
    }

    public function exitVehicleData(Request $request, $parking_id)
    {
        if (\Auth::user()->can('create parking')) {
            $validator = \Validator::make(
                $request->all(), [
                    'exit_date' => 'required',
                    'exit_time' => 'required',
                    'amount' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $parking = Parking::find($parking_id);
            $parking->exit_date = $request->exit_date;
            $parking->exit_time = $request->exit_time;
            $parking->amount = $request->amount;
            $parking->payment_status = 1;
            $parking->status = 1;
            $parking->save();

            if (!empty($parking)) {
                $slot = ParkingSlot::find($parking->slot);
                $slot->is_available = 1;
                $slot->save();
            }
            return redirect()->back()->with('success', __('Vehicle successfully exited.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function parkedVehicle()
    {
        if (\Auth::user()->can('manage parking')) {
            $parkings = Transaction::whereNull('alreadyout')->where('statusparking', 'Casual')->get();
            return view('parking.parked_list', compact('parkings'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function memberMotor()
    {
        if (\Auth::user()->can('manage parking')) {
            $parkings = Transaction::where('alreadyout','x')->where('statusparking', 'Member')->where('vehicleid', 'Motor')->get();
            return view('parking.motor_member_list', compact('parkings'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function memberMobil()
    {
        if (\Auth::user()->can('manage parking')) {
            $parkings = Transaction::where('alreadyout','x')->where('statusparking', 'Member')->where('vehicleid', 'Mobil')->get();
            return view('parking.mobil_member_list', compact('parkings'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function thermalPrint($id)
    {
        $parking = Parking::find($id);
        $settings = settings();
        return view('parking.thermal_print', compact('parking', 'settings'));
    }
}
