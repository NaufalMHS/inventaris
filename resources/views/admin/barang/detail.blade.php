@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('barang.index') }}" class="a-breadcrumbs">Data Barang</a> / 
        </span> Detail Barang
    </h4>

    <div class="card">
        <h5 class="card-header">Detail Barang</h5>

        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Nama Barang</label>
                        <div class="col-md-9">
                            <p>{{ $item->name }}</p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Kategori Barang</label>
                        <div class="col-md-9">
                            <p>{{ $item->category->name }}</p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Gedung</label>
                        <div class="col-md-9">
                            <p>{{ $item->building->name }}</p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Ruangan</label>
                        <div class="col-md-9">
                            <p>{{ $item->room->name }}</p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Status Barang</label>
                        <div class="col-md-9">
                            <p>{{ ucfirst($item->status) }}</p>
                        </div>
                    </div>

                    <!-- Tombol Lihat Riwayat Transfer -->
                    <div class="text-end">
                    <a class="btn btn-info" href="{{ route('transfer.showhistory', Crypt::encrypt($item->id)) }}">Lihat Riwayat Transfer</a>
                        <a class="btn btn-primary" href="{{ route('barang.edit', Crypt::encrypt($item->id)) }}">Edit</a>
                        <a class="btn btn-warning" href="{{ route('barang.index') }}">Kembali</a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
