<?php

namespace App\Http\Controllers;

use App\Models\ParkingRate;
use App\Models\ParkingZone;
use Illuminate\Http\Request;

class ParkingRateController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage parking rate')) {
            $rates = ParkingRate::where('parent_id', '=', parentId())->get();
            return view('parking_rate.index', compact('rates'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        $zones = ParkingZone::where('parent_id', parentId())->get()->pluck('zone_name', 'id');
        $zones->prepend(__('Select Zone'), '');

        return view('parking_rate.create', compact('zones'));
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create parking rate')) {
            $validator = \Validator::make(
                $request->all(), [
                    'zone' => 'required',
                    'start_date' => 'required',
                    'due_date' => 'required',
                    'vehicle_type' => 'required',
                    'fix_rate' => 'required',
                    'hourly_rate' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $rate = new ParkingRate();
            $rate->zone = $request->zone;
            $rate->start_date = $request->start_date;
            $rate->due_date = $request->due_date;
            $rate->vehicle_type = $request->vehicle_type;
            $rate->fix_rate = $request->fix_rate;
            $rate->hourly_rate = $request->hourly_rate;
            $rate->notes = $request->notes;
            $rate->parent_id = parentId();
            $rate->save();

            return redirect()->back()->with('success', __('Parking rate successfully created.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(ParkingRate $parkingRate)
    {
        //
    }


    public function edit(ParkingRate $parkingRate)
    {
        $zones = ParkingZone::where('parent_id', parentId())->get()->pluck('zone_name', 'id');
        $zones->prepend(__('Select Zone'), '');

        return view('parking_rate.edit', compact('zones','parkingRate'));
    }


    public function update(Request $request, ParkingRate $parkingRate)
    {
        if (\Auth::user()->can('create parking rate')) {
            $validator = \Validator::make(
                $request->all(), [
                    'zone' => 'required',
                    'start_date' => 'required',
                    'due_date' => 'required',
                    'vehicle_type' => 'required',
                    'fix_rate' => 'required',
                    'hourly_rate' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $parkingRate->zone = $request->zone;
            $parkingRate->start_date = $request->start_date;
            $parkingRate->due_date = $request->due_date;
            $parkingRate->vehicle_type = $request->vehicle_type;
            $parkingRate->fix_rate = $request->fix_rate;
            $parkingRate->hourly_rate = $request->hourly_rate;
            $parkingRate->notes = $request->notes;
            $parkingRate->save();

            return redirect()->back()->with('success', __('Parking rate successfully updated.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(ParkingRate $parkingRate)
    {
        if (\Auth::user()->can('delete parking rate')) {
            $parkingRate->delete();
            return redirect()->back()->with('success', 'Parking rate successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
