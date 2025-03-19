@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><a href="/" class="a-breadcrumbs">Beranda</a> /</span> Data Barang
    </h4>

    <div class="card">
        <h5 class="card-header">
            <div class="row mb-4">
                <div class="col-md-6">
                    Data Barang
                    <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm pl-4">Tambah Barang</a>
                </div>
                <div class="col-md-6 d-flex flex-row-reverse">
                    <form action="{{ route('barang.index') }}" method="GET">
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
                        <th class="sortable" data-sort="name">Nama Barang</th>
                        <th class="sortable" data-sort="code">Kode Barang</th>
                        <th class="sortable" data-sort="category">Kategori</th>
                        <th>Posisi Barang</th> 
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="items-table-body">
                    @forelse ($items as $data)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->code }}</td>
                        <td>{{ $data->category->name }}</td>
                        <td>{{ $data->building->name }} - {{ $data->room->name }}</td>

                        <!-- Menampilkan posisi barang -->
                        <td>
                            <a class="btn btn-sm btn-secondary" href="{{ route('barang.show', Crypt::encrypt($data->id)) }}">
                                <span class="align-middle">Detail</span>
                            </a>
                            <a class="btn btn-sm btn-primary" href="{{ route('barang.edit', Crypt::encrypt($data->id)) }}">
                                <span class="align-middle">Edit</span>
                            </a>

                            <!-- Tombol Pindah Barang -->
                            <a class="btn btn-sm btn-warning" href="{{ route('transfer.edit', Crypt::encrypt($data->id)) }}">
                                <span class="align-middle">Pindah</span>
                            </a>

                            <form action="{{ route('barang.destroy', Crypt::encrypt($data->id)) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus barang {{ $data->name }}?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak Ada Data!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Sorting logic for table
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function () {
            const sortKey = this.dataset.sort;
            const currentSortOrder = this.dataset.order || 'asc';
            const newSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
            
            // Toggle the sort order attribute
            this.dataset.order = newSortOrder;

            // Get the table body
            const tableBody = document.querySelector('#items-table-body');
            const rows = Array.from(tableBody.querySelectorAll('tr'));

            // Sort rows based on the column clicked
            rows.sort((rowA, rowB) => {
                const cellA = rowA.querySelector(`td:nth-child(${this.cellIndex + 1})`).innerText.trim();
                const cellB = rowB.querySelector(`td:nth-child(${this.cellIndex + 1})`).innerText.trim();

                if (sortKey === 'name' || sortKey === 'category') {
                    return newSortOrder === 'asc'
                        ? cellA.localeCompare(cellB)
                        : cellB.localeCompare(cellA);
                }

                if (sortKey === 'code') {
                    return newSortOrder === 'asc'
                        ? cellA.localeCompare(cellB, undefined, { numeric: true })
                        : cellB.localeCompare(cellA, undefined, { numeric: true });
                }

                return 0;
            });

            // Reorder the table rows based on the sorted data
            tableBody.innerHTML = '';
            rows.forEach(row => tableBody.appendChild(row));
        });
    });
</script>
@endsection
