@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><a href="/" class="a-breadcrumbs">Beranda</a> /</span> Data Lokasi
    </h4>

    <div class="card">
        <h5 class="card-header">
            <div class="row">
                <div class="col-md-6">
                    Data Gedung & Ruangan
                    <a href="{{ route('lokasi.create') }}" class="btn btn-primary btn-sm">Tambah Gedung</a>
                </div>
            </div>
        </h5>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Gedung</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($buildings as $building)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $building->name }}</td>
                        <td>{{ $building->alamat }}</td>
                        <td>
                            <a class="btn btn-sm btn-secondary" href="{{ route('lokasi.show', $building->id) }}">
                                <span class="align-middle">Lihat Ruangan</span>
                            </a>
                            <a href="{{ route('lokasi.edit', $building->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('lokasi.destroy', $building->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak Ada Data!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
