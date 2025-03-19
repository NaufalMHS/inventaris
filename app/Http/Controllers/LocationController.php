<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Room;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // Menampilkan daftar gedung
    public function index()
    {
        $buildings = Building::all();
        return view('admin.lokasi.index', compact('buildings'));
    }

    // Menampilkan form tambah gedung
    public function create()
    {
        return view('admin.lokasi.create');
    }

    // Menyimpan gedung baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
        ]);

        Building::create($request->all());

        return redirect()->route('lokasi.index')->with('success', 'Gedung berhasil ditambahkan!');
    }

    // Menampilkan detail gedung dan daftar ruangannya
    public function show($id)
    {
        $building = Building::findOrFail($id);
        $rooms = Room::where('building_id', $id)->get();

        return view('admin.lokasi.show', compact('building', 'rooms'));
    }

    // Menampilkan form edit gedung
    public function edit($id)
    {
        $building = Building::findOrFail($id);
        return view('admin.lokasi.edit', compact('building'));
    }

    // Mengupdate data gedung
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

    // Menghapus gedung
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
