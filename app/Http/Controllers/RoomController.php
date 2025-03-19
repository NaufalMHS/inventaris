<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Building;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        $rooms = Room::where('building_id', $buildingId)->get();
        return view('admin.rooms.index', compact('building', 'rooms'));
    }

    public function create()
    {
        $buildings = Building::all();
        return view('admin.rooms.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'name_ruangan' => 'required|string',
            'floor' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        Room::create($request->all());

        return redirect()->route('buildings.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
