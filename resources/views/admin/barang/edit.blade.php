@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('barang.index') }}" class="a-breadcrumbs">Data Barang</a> / 
        </span> Edit Barang
    </h4>

    <div class="card">
        <h5 class="card-header">Edit Barang</h5>

        <form action="{{ route('barang.update', Crypt::encrypt($item->id)) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <!-- Nama Barang -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Nama Barang</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="name" value="{{ old('name', $item->name) }}" required/>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kategori Barang -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Kategori Barang</label>
                            <div class="col-md-9">
                                <select class="form-control" name="category_id" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Gedung -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Gedung</label>
                            <div class="col-md-9">
                                <select class="form-control" name="building_id" id="building" required>
                                    <option value="">-- Pilih Gedung --</option>
                                    @foreach($buildings as $building)
                                    <option value="{{ $building->id }}" {{ old('building_id', $item->building_id) == $building->id ? 'selected' : '' }}>
                                        {{ $building->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('building_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Ruangan -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Ruangan</label>
                            <div class="col-md-9">
                                <select class="form-control" name="room_id" id="room" required>
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach($item->building->rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id', $item->room_id) == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Status Barang</label>
                            <div class="col-md-9">
                                <select class="form-control" name="status" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="baru" {{ old('status', $item->status) == 'baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="bekas" {{ old('status', $item->status) == 'bekas' ? 'selected' : '' }}>Bekas</option>
                                    <option value="rusak" {{ old('status', $item->status) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                </select>
                                @error('status')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <a class="btn btn-warning" href="{{ route('barang.index') }}">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('building').addEventListener('change', function() {
        let buildingId = this.value;
        fetch(`/api/rooms/${buildingId}`)
            .then(response => response.json())
            .then(data => {
                let roomSelect = document.getElementById('room');
                roomSelect.innerHTML = '<option value="">-- Pilih Ruangan --</option>';
                data.rooms.forEach(room => {
                    roomSelect.innerHTML += `<option value="${room.id}">${room.name}</option>`;
                });
            });
    });

    window.addEventListener('DOMContentLoaded', (event) => {
        let buildingId = document.getElementById('building').value;
        if (buildingId) {
            fetch(`/api/rooms/${buildingId}`)
                .then(response => response.json())
                .then(data => {
                    let roomSelect = document.getElementById('room');
                    roomSelect.innerHTML = '<option value="">-- Pilih Ruangan --</option>';
                    data.rooms.forEach(room => {
                        roomSelect.innerHTML += `<option value="${room.id}" ${room.id == "{{ old('room_id', $item->room_id) }}" ? 'selected' : ''}>${room.name}</option>`;
                    });
                });
        }
    });
</script>
@endsection
