@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('barang.index') }}" class="a-breadcrumbs">Data Barang</a> /
        </span> Riwayat Transfer Barang
    </h4>

    <div class="card">
        <h5 class="card-header">Riwayat Transfer Barang</h5>

        <div class="card-body">
            <!-- Tabel Riwayat Transfer -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kode</th>
                        <th>Gedung Asal</th>
                        <th>Ruangan Asal</th>
                        <th>Gedung Tujuan</th>
                        <th>Ruangan Tujuan</th>
                        <th>Tanggal Transfer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transfers as $transfer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transfer->item->name }}</td> 
                        <td>{{ $transfer->item->code }}</td> 
                        <td>{{ $transfer->fromBuilding->name ?? 'N/A' }}</td>
                        <td>{{ $transfer->fromRoom->name ?? 'N/A' }}</td>
                        <td>{{ $transfer->toBuilding->name ?? 'N/A' }}</td>
                        <td>{{ $transfer->toRoom->name ?? 'N/A' }}</td>
                        <td>{{ $transfer->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
