@extends('layouts.admin')

@section('content')
<style>
    .img-ratio-16-9 {
        width: 150px;
        height: 84.375px;
        object-fit: cover;
    }

</style>
<div class="container">
    <h1>Daftar Mobil</h1>
    <div class="d-flex justify-content-end">
        <a href="/admin/mobil/tambahMobil" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Mobil</a>
    </div>

    <table class="table table-sm mt-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Foto</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @if (!$data->isEmpty())
                @foreach ($data as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->nama_mobil}}</td>
                        <td><img onclick="showImage('{{ asset('upload/'.$item->foto_mobil) }}')" style="cursor: zoom-in;" class="img-ratio-16-9" src="{{ asset('upload/' . $item->foto_mobil) }}" alt=""></td>
                        <td>Rp {{ number_format($item->harga_mobil, 0, ',', '.') }}/hari</td>
                    </tr>
                @endforeach
                {{-- fitur show image --}}
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                        <img src="" id="modalImage" class="img-fluid">
                        </div>
                    </div>
                    </div>
                </div>
            @else
                <tr>
                    <td colspan="4" class="text-center">Tidak Ada Data</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<script>
    function showImage(imgPath) {
        document.getElementById('modalImage').src = imgPath;
        $('#imageModal').modal('show');
    }
</script>
@endsection