<?php

namespace App\Http\Controllers;

use App\Models\ParkingZone;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage vehicle type')) {
            $types = VehicleType::where('parent_id', '=', parentId())->get();
            return view('vehicle_type.index', compact('types'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        $zones = ParkingZone::where('parent_id', parentId())->get()->pluck('zone_name', 'id');
        $zones->prepend(__('Select Zone'), '');

        return view('vehicle_type.create', compact('zones'));
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create vehicle type')) {
            $validator = \Validator::make(
                $request->all(), [
                    'zone' => 'required',
                    'title' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $type = new VehicleType();
            $type->zone = $request->zone;
            $type->title = $request->title;
            $type->notes = $request->notes;
            $type->status = 1;
            $type->parent_id = parentId();
            $type->save();

            return redirect()->back()->with('success', __('Vehicle type successfully created.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $type=VehicleType::find($id);
        $zones = ParkingZone::where('parent_id', parentId())->get()->pluck('zone_name', 'id');
        $zones->prepend(__('Select Zone'), '');
        return view('vehicle_type.edit', compact('type','zones'));
    }


    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('create vehicle type')) {
            $validator = \Validator::make(
                $request->all(), [
                    'zone' => 'required',
                    'title' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $type=VehicleType::find($id);
            $type->zone = $request->zone;
            $type->title = $request->title;
            $type->notes = $request->notes;
            $type->save();
            return redirect()->back()->with('success', __('Vehicle type successfully updated.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy($id)
    {
        $type=VehicleType::find($id);
        if (\Auth::user()->can('delete vehicle type')) {
            $type->delete();
            return redirect()->back()->with('success', 'Vehicle type successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getvehicleType($id)
    {
        $types = VehicleType::where('zone', $id)->get()->pluck('title', 'id');
        return response()->json($types);
    }
}
