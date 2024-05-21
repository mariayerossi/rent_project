@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Daftar Sewa</h1>
    <div class="card mt-3 mb-5 p-3">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Penyewa</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$data->isEmpty())
                        @foreach ($data as $item)
                            <tr>
                                @php
                                    $tanggalAwal3 = $item->tanggal_htrans;
                                    $tanggalObjek3 = DateTime::createFromFormat('Y-m-d H:i:s', $tanggalAwal3);
                                    $carbonDate3 = \Carbon\Carbon::parse($tanggalObjek3)->locale('id');
                                    $tanggalBaru3 = $carbonDate3->isoFormat('D MMMM YYYY HH:mm');
                                @endphp
                                <td>{{$tanggalBaru3}}</td>
                                <td>{{$item->nama_cust}}</td>
                                <td>{{$item->jenis}}</td>
                                <td><a href="/admin/sewa/detailSewa/{{$item->id_htrans}}" class="btn btn-outline-success">Detail</a></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">Tidak Ada Data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection