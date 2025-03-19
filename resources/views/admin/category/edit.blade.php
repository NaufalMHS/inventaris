@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('kategori.index') }}" class="a-breadcrumbs">Kategori Foto</a> /
        </span> Edit Kategori
    </h4>

    <div class="card">
        <h5 class="card-header">Edit Kategori Foto</h5>

        <form action="{{ route('kategori.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Nama Kategori</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="name" value="{{ old('name', $category->name) }}"/>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Kode Kategori</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="code" value="{{ old('code', $category->code) }}"/>
                                @error('code')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col text-start">
                        <button class="btn btn-primary" type="submit">
                            <span class="align-middle">Update</span>
                        </button>
                    </div>
                    <div class="col text-end">
                        <a class="btn btn-warning" href="{{ route('kategori.index') }}">
                            <span class="align-middle">Kembali</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
