<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\ParkingSlot;
use App\Models\ParkingZone;
use Illuminate\Http\Request;

class ParkingSlotController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage parking slot')) {
            $slots = ParkingSlot::where('parent_id', '=', parentId())->get();
            return view('parking_slot.index', compact('slots'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        $zones = ParkingZone::where('parent_id', parentId())->get()->pluck('zone_name', 'id');
        $zones->prepend(__('Select Zone'), '');

        return view('parking_slot.create', compact('zones'));
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create parking slot')) {
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required',
                    'zone' => 'required',
                    'type' => 'required',
                    'floor' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $slot = new ParkingSlot();
            $slot->title = $request->title;
            $slot->zone = $request->zone;
            $slot->type = $request->type;
            $slot->floor = $request->floor;
            $slot->notes = $request->notes;
            $slot->parent_id = parentId();
            $slot->save();

            return redirect()->back()->with('success', __('Parking slot successfully created.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(ParkingSlot $parkingSlot)
    {
        //
    }


    public function edit(ParkingSlot $parkingSlot)
    {
        $zones = ParkingZone::where('parent_id', parentId())->get()->pluck('zone_name', 'id');
        $zones->prepend(__('Select Zone'), '');

        return view('parking_slot.edit', compact('zones','parkingSlot'));
    }


    public function update(Request $request, ParkingSlot $parkingSlot)
    {
        if (\Auth::user()->can('edit parking slot')) {
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required',
                    'zone' => 'required',
                    'type' => 'required',
                    'floor' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $parkingSlot->title = $request->title;
            $parkingSlot->zone = $request->zone;
            $parkingSlot->type = $request->type;
            $parkingSlot->floor = $request->floor;
            $parkingSlot->notes = $request->notes;
            $parkingSlot->save();
            return redirect()->back()->with('success', __('Parking slot successfully created.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(ParkingSlot $parkingSlot)
    {
        if (\Auth::user()->can('delete parking slot')) {
            $parkingSlot->delete();
            return redirect()->back()->with('success', 'Parking slot successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getSlot($floorId,$zoneId,$typeId)
    {

        $slots = ParkingSlot::where('is_available',1)->where('zone', $zoneId)->where('floor', $floorId)->where('type', $typeId)->get()->pluck('title', 'id');
        return response()->json($slots);
    }

}
