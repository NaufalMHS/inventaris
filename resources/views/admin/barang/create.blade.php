@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('barang.index') }}" class="a-breadcrumbs">Data Barang</a> / 
        </span> Tambah Barang
    </h4>

    <div class="card">
        <h5 class="card-header">Tambah Barang</h5>

        <form action="{{ route('barang.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Nama Barang</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="name" value="{{ old('name') }}" required/>
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
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
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
                                    <option value="{{ $building->id }}">{{ $building->name }}</option>
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
                                </select>
                                @error('room_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Barang -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Status Barang</label>
                            <div class="col-md-9">
                                <select class="form-control" name="status" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="baru">Baru</option>
                                    <option value="bekas">Bekas</option>
                                    <option value="rusak">Rusak</option>
                                </select>
                                @error('status')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
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
        if (buildingId) {
            fetch(`/api/rooms/${buildingId}`)
                .then(response => response.json())
                .then(data => {
                    let roomSelect = document.getElementById('room');
                    roomSelect.innerHTML = '<option value="">-- Pilih Ruangan --</option>';
                    data.rooms.forEach(room => {
                        roomSelect.innerHTML += `<option value="${room.id}">${room.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error fetching rooms:', error);
                });
        } else {
            document.getElementById('room').innerHTML = '<option value="">-- Pilih Ruangan --</option>';
        }
    });
</script>
@endsection
