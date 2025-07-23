<?php

namespace App\Http\Controllers;

use App\Models\ParkingZone;
use Illuminate\Http\Request;

class ParkingZoneController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage parking zone')) {
            $zones = ParkingZone::where('parent_id', '=', parentId())->get();
            return view('zone.index', compact('zones'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        return view('zone.create');
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create parking zone')) {
            $validator = \Validator::make(
                $request->all(), [
                    'zone_name' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $zone = new ParkingZone();
            $zone->zone_name = $request->zone_name;
            $zone->notes = $request->notes;
            $zone->parent_id = parentId();
            $zone->save();

            return redirect()->back()->with('success', __('Parking zone successfully created.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }


    public function show(ParkingZone $parkingZone)
    {

    }


    public function edit(ParkingZone $parkingZone)
    {
        return view('zone.edit', compact('parkingZone'));
    }


    public function update(Request $request, ParkingZone $parkingZone)
    {
        if (\Auth::user()->can('edit parking zone')) {
            $validator = \Validator::make(
                $request->all(), [
                    'zone_name' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $parkingZone->zone_name = $request->zone_name;
            $parkingZone->notes = $request->notes;
            $parkingZone->save();

            return redirect()->back()->with('success', __('Parking zone successfully updayed.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(ParkingZone $parkingZone)
    {
        if (\Auth::user()->can('edit parking zone')) {
            $parkingZone->delete();

            return redirect()->back()->with('success', 'Parking zone successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
