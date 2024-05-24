@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Daftar Sewa</h1>
    <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="menunggu-tab" data-bs-toggle="tab" href="#menunggu" role="tab" aria-controls="menunggu" aria-selected="true">Menunggu</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="lunas-tab" data-bs-toggle="tab" href="#lunas" role="tab" aria-controls="lunas" aria-selected="false">Lunas</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="selesai-tab" data-bs-toggle="tab" href="#selesai" role="tab" aria-controls="selesai" aria-selected="false">Selesai</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="dibatalkan-tab" data-bs-toggle="tab" href="#dibatalkan" role="tab" aria-controls="dibatalkan" aria-selected="false">Dibatalkan</a>
        </li>
    </ul>
    <div class="tab-content mt-3 mb-5 p-3" id="myTabContent">
        <div class="tab-pane fade show active" id="menunggu" role="tabpanel" aria-labelledby="menunggu-tab">
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <th>Penyewa</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$menunggu->isEmpty())
                                @foreach ($menunggu as $item)
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
        <div class="tab-pane fade" id="lunas" role="tabpanel" aria-labelledby="lunas-tab">
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <th>Penyewa</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$lunas->isEmpty())
                                @foreach ($lunas as $item)
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
        <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <th>Penyewa</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$selesai->isEmpty())
                                @foreach ($selesai as $item)
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
        <div class="tab-pane fade" id="dibatalkan" role="tabpanel" aria-labelledby="dibatalkan-tab">
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <th>Penyewa</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$dibatalkan->isEmpty())
                                @foreach ($dibatalkan as $item)
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
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault()
            tabTrigger.show()
        })
    })
});

</script>
@endsection