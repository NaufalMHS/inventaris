<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Room;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $buildings = Building::all();
        return view('admin.lokasi.index', compact('buildings'));
    }

    public function create()
    {
        return view('admin.lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
        ]);

        Building::create($request->all());

        return redirect()->route('lokasi.index')->with('success', 'Gedung berhasil ditambahkan!');
    }

    public function show($id)
    {
        $building = Building::findOrFail($id);
        $rooms = Room::where('building_id', $id)->get();

        return view('admin.lokasi.show', compact('building', 'rooms'));
    }

    public function edit($id)
    {
        $building = Building::findOrFail($id);
        return view('admin.lokasi.edit', compact('building'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
        ]);

        $building = Building::findOrFail($id);
        $building->update($request->all());

        return redirect()->route('lokasi.index')->with('success', 'Gedung berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $building = Building::findOrFail($id);
        $building->delete();

        return redirect()->route('lokasi.index')->with('success', 'Gedung berhasil dihapus!');
    }

        
        public function storeRoom(Request $request, $buildingId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'floor' => 'required|integer',
        ]);

        Room::create([
            'building_id' => $buildingId,
            'name' => $request->name,
            'floor' => $request->floor,
        ]);

        return redirect()->route('lokasi.rooms', $buildingId)->with('success', 'Ruangan berhasil ditambahkan!');

    }

}
