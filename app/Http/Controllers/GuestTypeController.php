<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuesType;

class GuestTypeController extends Controller
{
    public function index()
    {
        $types = GuesType::orderBy('id')->get();
        return view('guest_type.index', compact('types'));
        // if (\Auth::user()->can('manage report') ) {
        //     $report = Transaction::where('parent_id', '=', parentId())->get();
           
        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
        // return view('report.index');
    }

    public function create()
    {
        $guestTypes = GuesType::pluck('type', 'id');

        return view('guest_type.create', compact('guestTypes'));
        // if (\Auth::user()->can('manage report') ) {
        //     $report = Transaction::where('parent_id', '=', parentId())->get();
           
        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
        // return view('report.report');
    }
    public function edit($id)
    {
        $type = GuesType::findOrFail($id);

        return view('guest_type.edit', compact('type'));;
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|max:255',
        ]);

        GuesType::create([
            'parent_id' => parentId(),
            'type' => $request->type,
        ]);

        return redirect()
            ->route('setting.guest-types')
            ->with('success', 'Guest Type created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|max:255',
        ]);

        $type = GuesType::findOrFail($id);

        $type->update([
            'type' => $request->type,
        ]);

        return redirect()
            ->route('setting.guest-types')
            ->with('success', 'Guest Type updated successfully.');
    }
}
