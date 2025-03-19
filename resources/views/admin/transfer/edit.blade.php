@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('barang.index') }}" class="a-breadcrumbs">Data Barang</a> / 
        </span> Pindah Barang
    </h4>

    <div class="card">
        <h5 class="card-header">Pindah Barang: {{ $item->name }}</h5>

        <form action="{{ route('transfer.update', Crypt::encrypt($item->id)) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="row">
                    <div class="col">

                        <!-- Lokasi Asal -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Lokasi Asal</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" value="{{ $item->building->name }} - {{ $item->room->name }}" readonly />
                            </div>
                        </div>

                        <!-- Gedung Tujuan -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Gedung Tujuan</label>
                            <div class="col-md-9">
                                <select class="form-control" name="to_building_id" id="to_building_id" required>
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
                        </div>

                        <!-- Ruangan Tujuan -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Ruangan Tujuan</label>
                            <div class="col-md-9">
                                <select class="form-control" name="to_room_id" id="to_room_id" required>
                                    <option value="">-- Pilih Ruangan Tujuan --</option>
                                </select>
                                @error('to_room_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Pindah Barang -->
                        <div class="text-end">
                            <button class="btn btn-primary" type="submit">Pindah Barang</button>
                            <a class="btn btn-warning" href="{{ route('barang.index') }}">Kembali</a>
                        </div>

                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    document.getElementById('to_building_id').addEventListener('change', function() {
        let buildingId = this.value;
        fetch(`/api/rooms/${buildingId}`)
            .then(response => response.json())
            .then(data => {
                let roomSelect = document.getElementById('to_room_id');
                roomSelect.innerHTML = '<option value="">-- Pilih Ruangan Tujuan --</option>';
                data.rooms.forEach(room => {
                    roomSelect.innerHTML += `<option value="${room.id}">${room.name}</option>`;
                });
            });
    });
</script>
@endsection
