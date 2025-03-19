@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('lokasi.index') }}" class="a-breadcrumbs">Data Lokasi</a> /</span> Edit Gedung
    </h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('lokasi.update', $building->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Gedung</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $building->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat">{{ $building->alamat }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('lokasi.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
