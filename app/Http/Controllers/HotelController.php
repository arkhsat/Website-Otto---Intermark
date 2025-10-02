<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\ParkingZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{

    public function index()
    {
        // if (\Auth::user()->can('manage hotel')) {
            $hotels = Hotel::where('parent_id', '=', parentId())->orderBy('id', 'desc')->limit(100)->get();
            return view('hotel.index', compact('hotels'));
        // } else {
            // return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }


    public function create()
    {
       

        
        return view('hotel.create');
    }


    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(), [
                'parent_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $hotel = new Hotel();
        $hotel->room_no = $request->room_no;
        $hotel->guest_name = $request->guest_name;
        $hotel->check_in = $request->check_in;
        $hotel->check_out = $request->check_out;
        $hotel->plat_no = $request->plat_no;
        $hotel->uidno = $request->uidno;
        $hotel->status = '1';
        $hotel->parent_id = parentId();
        $hotel->save();

        return redirect()->back()->with('success', __('Parking Hotel successfully created.'));
    }


    // public function show(Floor $floor)
    // {
    //     //
    // }


    // public function edit(Floor $floor)
    // {
    //     $zones = ParkingZone::where('parent_id', parentId())->get()->pluck('zone_name', 'id');
    //     $zones->prepend(__('Select Zone'), '');
    //     return view('floor.edit', compact('floor', 'zones'));
    // }


    // public function update(Request $request, Floor $floor)
    // {
    //     if (\Auth::user()->can('edit floor')) {
    //         $validator = \Validator::make(
    //             $request->all(), [
    //                 'title' => 'required',
    //                 'zone' => 'required',
    //                 'floor_level' => 'required',
    //             ]
    //         );
    //         if ($validator->fails()) {
    //             $messages = $validator->getMessageBag();
    //             return redirect()->back()->with('error', $messages->first());
    //         }

    //         $floor->title = $request->title;
    //         $floor->zone = $request->zone;
    //         $floor->floor_level = $request->floor_level;
    //         $floor->notes = $request->notes;
    //         $floor->save();

    //         return redirect()->back()->with('success', __('Parking floor successfully updated.'));

    //     } else {
    //         return redirect()->back()->with('error', __('Permission denied.'));
    //     }
    // }


    // public function destroy(Floor $floor)
    // {
    //     if (\Auth::user()->can('edit floor')) {
    //         $floor->delete();

    //         return redirect()->back()->with('success', 'Parking floor successfully deleted.');
    //     } else {
    //         return redirect()->back()->with('error', __('Permission denied.'));
    //     }
    // }

    // public function getFloor($id)
    // {
    //     $floors = Floor::where('zone', $id)->get()->pluck('title', 'id');
    //     return response()->json($floors);
    // }
}
