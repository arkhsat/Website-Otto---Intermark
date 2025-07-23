<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\ParkingZone;
use Illuminate\Http\Request;

class FloorController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage floor')) {
            $floors = Floor::where('parent_id', '=', parentId())->get();
            return view('floor.index', compact('floors'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        $zones = ParkingZone::where('parent_id', parentId())->get()->pluck('zone_name', 'id');
        $zones->prepend(__('Select Zone'), '');
        return view('floor.create', compact('zones'));
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create floor')) {
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required',
                    'zone' => 'required',
                    'floor_level' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $floor = new Floor();
            $floor->title = $request->title;
            $floor->zone = $request->zone;
            $floor->floor_level = $request->floor_level;
            $floor->notes = $request->notes;
            $floor->parent_id = parentId();
            $floor->save();

            return redirect()->back()->with('success', __('Parking floor successfully created.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(Floor $floor)
    {
        //
    }


    public function edit(Floor $floor)
    {
        $zones = ParkingZone::where('parent_id', parentId())->get()->pluck('zone_name', 'id');
        $zones->prepend(__('Select Zone'), '');
        return view('floor.edit', compact('floor', 'zones'));
    }


    public function update(Request $request, Floor $floor)
    {
        if (\Auth::user()->can('edit floor')) {
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required',
                    'zone' => 'required',
                    'floor_level' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $floor->title = $request->title;
            $floor->zone = $request->zone;
            $floor->floor_level = $request->floor_level;
            $floor->notes = $request->notes;
            $floor->save();

            return redirect()->back()->with('success', __('Parking floor successfully updated.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(Floor $floor)
    {
        if (\Auth::user()->can('edit floor')) {
            $floor->delete();

            return redirect()->back()->with('success', 'Parking floor successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getFloor($id)
    {
        $floors = Floor::where('zone', $id)->get()->pluck('title', 'id');
        return response()->json($floors);
    }
}
