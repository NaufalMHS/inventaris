@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('barang.index') }}" class="a-breadcrumbs">Data Barang</a> / 
        </span> Riwayat Transfer Barang: {{ $item->name }}
    </h4>

    <div class="card">
        <h5 class="card-header">Riwayat Transfer Barang: {{ $item->name }}</h5>

        <div class="card-body">
            @if($transfers->isEmpty())
                <p>Tidak ada riwayat transfer untuk barang ini.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gedung Asal</th>
                            <th>Ruangan Asal</th>
                            <th>Gedung Tujuan</th>
                            <th>Ruangan Tujuan</th>
                            <th>Tanggal Transfer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transfers as $index => $transfer)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $transfer->fromBuilding->name }}</td>
                                <td>{{ $transfer->fromRoom->name }}</td>
                                <td>{{ $transfer->toBuilding->name }}</td>
                                <td>{{ $transfer->toRoom->name }}</td>
                                <td>{{ $transfer->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="text-end">
            <a class="btn btn-warning" href="{{ route('barang.show', Crypt::encrypt($item->id)) }}">Kembali</a>
        </div>
    </div>
</div>
@endsection
