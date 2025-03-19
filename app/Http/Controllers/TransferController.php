<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Building;
use App\Models\Room;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TransferController extends Controller
{
    /**
     * Menampilkan form untuk pemindahan barang
     */
    public function edit($id)
    {
        // Mendekripsi ID yang diterima
        $id = Crypt::decrypt($id);

        // Mencari barang berdasarkan ID
        $item = Item::findOrFail($id);

        // Mengambil data gedung dan ruangan yang ada
        $buildings = Building::with('rooms')->get();

        // Menampilkan halaman edit untuk pemindahan barang
        return view('admin.transfer.edit', compact('item', 'buildings'));
    }

    /**
     * Memperbarui posisi barang (pemindahan barang)
     */
    public function update(Request $request, $id)
    {
        // Mendekripsi ID yang diterima
        $id = Crypt::decrypt($id);

        // Mencari barang berdasarkan ID
        $item = Item::findOrFail($id);

        // Validasi input
        $request->validate([
            'to_building_id' => 'required|exists:buildings,id',
            'to_room_id' => 'required|exists:rooms,id',
        ]);

        // Menyimpan data transfer ke tabel transfers
        Transfer::create([
            'item_id' => $item->id,
            'from_building_id' => $item->building_id,
            'from_room_id' => $item->room_id,
            'to_building_id' => $request->to_building_id,
            'to_room_id' => $request->to_room_id,
            'status' => 'dalam proses', // Atau sesuaikan status sesuai kebutuhan
        ]);

        // Memperbarui data barang
        $item->update([
            'building_id' => $request->to_building_id,
            'room_id' => $request->to_room_id,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dipindahkan.');
    }
    public function getRoomsByBuilding($buildingId)
    {
        $rooms = Room::where('building_id', $buildingId)->get();
        return response()->json(['rooms' => $rooms]);
    }
        
    public function showHistory($id)
    {
        // Mendapatkan item berdasarkan ID yang sudah di-crypt
        $itemId = Crypt::decrypt($id);
        $item = Item::findOrFail($itemId);

        // Mengambil riwayat transfer barang berdasarkan item_id
        $transfers = Transfer::where('item_id', $itemId)->get();

        return view('admin.barang.historytransfer', compact('item', 'transfers'));
    }
    public function history()
    {
        // Ambil semua data transfer
        $transfers = Transfer::with('item', 'fromBuilding', 'fromRoom', 'toBuilding', 'toRoom')->get();

        // Kirim data ke view
        return view('admin.transfer.history', compact('transfers'));
    }

}
