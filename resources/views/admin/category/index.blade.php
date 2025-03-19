@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><a href="/" class="a-breadcrumbs">Beranda</a> /</span> Kategori 
    </h4>

    <div class="card">
        <h5 class="card-header">
            <div class="row mb-4">
                <div class="col-md-6">
                    Data Kategori
                    <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm pl-4">Data Baru</a>
                </div>
                <div class="col-md-6 d-flex flex-row-reverse">
                    <form action="{{ route('kategori.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" id="cari" class="form-control" name="cari" value="{{ request('cari') }}" placeholder="Masukkan keyword...">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </h5>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Kode Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $data)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->code }}</td>
                        <td>
                            
                            <a class="btn btn-sm btn-primary" href="{{ route('kategori.edit', Crypt::encrypt($data->id)) }}">
                                <span class="align-middle">Edit</span>
                            </a>
                            <form action="{{ route('kategori.destroy', Crypt::encrypt($data->id)) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kategori {{ $data->name }}?')">
                                    Hapus
                                </button>
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

        {{ $categories->links() }}
    </div>
</div>
@endsection
