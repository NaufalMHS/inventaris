@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('transfer.index') }}" class="a-breadcrumbs">Data Transfer</a> /</span> Transfer Barang
    </h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('transfer.store') }}" method="POST">
                @csrf

                <!-- Pilih Barang yang akan Ditransfer -->
                <div class="mb-3">
                    <label for="item_id" class="form-label">Barang</label>
                    <select name="item_id" id="item_id" class="form-control" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" data-category="{{ $item->category->name }}"
                                    {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} ({{ $item->category->name }})
                            </option>
                        @endforeach
                    </select>
                    @error('item_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lokasi Asal Barang (Gedung - Ruangan) -->
                <div class="mb-3">
                    <label for="from_location_id" class="form-label">Lokasi Asal Barang</label>
                    <input type="text" name="from_location_id" id="from_location_id" class="form-control" 
                           placeholder="Gedung - Ruangan" required>
                    @error('from_location_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input hidden untuk from_building_id dan from_room_id -->
                <input type="hidden" name="from_building_id" id="from_building_id">
                <input type="hidden" name="from_room_id" id="from_room_id">

                <!-- Pilih Gedung Tujuan -->
                <div class="mb-3">
                    <label for="to_building_id" class="form-label">Gedung Tujuan</label>
                    <select name="to_building_id" id="to_building_id" class="form-control" required>
                        <option value="">-- Pilih Gedung Tujuan --</option>
                        @foreach($buildings as $building)
                            <option value="{{ $building->id }}" {{ old('to_building_id') == $building->id ? 'selected' : '' }}>
                                {{ $building->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('to_building_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pilih Ruangan Tujuan -->
                <div class="mb-3" id="to-room-container" style="display:none;">
                    <label for="to_room_id" class="form-label">Ruangan Tujuan</label>
                    <select name="to_room_id" id="to_room_id" class="form-control" required>
                        <option value="">-- Pilih Ruangan Tujuan --</option>
                    </select>
                    @error('to_room_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Transfer -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status Transfer</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="dalam proses" {{ old('status') == 'dalam proses' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Transfer</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Menampilkan lokasi asal setelah memilih barang
    document.getElementById('item_id').addEventListener('change', function() {
        let itemId = this.value;

        if (itemId) {
            document.getElementById('from-location-container').style.display = 'block';

            // Fetch lokasi asal berdasarkan item yang dipilih
            fetch(`/api/item/${itemId}/locations`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        let fromLocationText = `${data.building} - ${data.room}`;
                        document.getElementById('from_location_id').value = fromLocationText;

                        // Set hidden fields for building and room IDs
                        document.querySelector('input[name="from_building_id"]').value = data.building_id;
                        document.querySelector('input[name="from_room_id"]').value = data.room_id;
                    }
                });

            // Enable gedung tujuan
            document.getElementById('to_building_id').disabled = false;
        } else {
            document.getElementById('from-location-container').style.display = 'none';
            document.getElementById('to_building_id').disabled = true;
        }
    });

    // Menampilkan ruangan tujuan setelah memilih gedung tujuan
    document.getElementById('to_building_id').addEventListener('change', function() {
        let buildingId = this.value;

        if (buildingId) {
            document.getElementById('to-room-container').style.display = 'block';

            fetch(`/api/rooms/${buildingId}`)
                .then(response => response.json())
                .then(data => {
                    let toRoomSelect = document.getElementById('to_room_id');
                    toRoomSelect.innerHTML = '<option value="">-- Pilih Ruangan Tujuan --</option>';

                    if (data.length > 0) {
                        data.forEach(room => {
                            toRoomSelect.innerHTML += `<option value="${room.id}">${room.name}</option>`;
                        });
                    } else {
                        toRoomSelect.innerHTML += '<option value="">Tidak ada ruangan</option>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching rooms:', error);
                });
        } else {
            document.getElementById('to-room-container').style.display = 'none';
        }
    });
</script>
@endsection
