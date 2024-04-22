@extends('layouts.admin')

@section('content')
<style>
    .img-ratio-16-9 {
        width: 150px;
        height: 84.375px;
        object-fit: cover;
    }
    .toggleSwitch {
        cursor: pointer;
    }
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<div class="container">
    <h1>Daftar Mobil</h1>
    <div class="d-flex justify-content-end">
        <a href="/admin/mobil/tambahMobil" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Mobil</a>
    </div>

    <div class="card mt-3 mb-5 p-3">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Foto</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$data->isEmpty())
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->nama_mobil}}</td>
                                <td><img onclick="showImage('{{ asset('upload/'.$item->foto_mobil) }}')" style="cursor: zoom-in;" class="img-ratio-16-9" src="{{ asset('upload/' . $item->foto_mobil) }}" alt=""></td>
                                <td>Rp {{ number_format($item->harga_mobil, 0, ',', '.') }}/hari</td>
                                <td>{{$item->status_mobil}}</td>
                                <td><button class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal{{$item->id_mobil}}" data-whatever="@mdo">Edit</button></td>
                            </tr>
                            <div class="modal fade" id="exampleModal{{$item->id_mobil}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Edit Mobil</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <form method="post" action="/admin/mobil/edit">
                                        @csrf
                                        <div class="form-group">
                                          <label for="recipient-name" class="col-form-label">Nama:</label>
                                          <input type="text" class="form-control" id="recipient-name" value="{{$item->nama_mobil}}" name="nama">
                                        </div>
                                        <div class="form-group">
                                            <label for="hargaDisplay" class="col-form-label">Harga:</label>
                                            <input type="text" class="form-control" id="hargaDisplay" value="{{ number_format($item->harga_mobil, 0, ',', '.') }}" oninput="formatNumber2(this)" name="harga">
                                            <input type="hidden" name="harga" id="hargaActual">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-status" class="col-form-label">Status:</label><br>
                                            <label class="switch">
                                                <input type="checkbox" checked name="status">
                                                <span class="slider round"></span>
                                              </label>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Edit</button>
                                    </div>
                                </form>
                                  </div>
                                </div>
                              </div>
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
    </div>
</div>
<script>
    function showImage(imgPath) {
        document.getElementById('modalImage').src = imgPath;
        $('#imageModal').modal('show');
    }

    function formatNumber2(input) {
        let value = input.value;
        value = value.replace(/\D/g, '');
        let numberValue = parseInt(value, 10);
        
        if (!isNaN(numberValue)) {
            // Update input yang terlihat oleh pengguna dengan format yang sudah diformat
            input.value = numberValue.toLocaleString('id-ID');
            // Update input tersembunyi dengan angka murni
            document.getElementById('hargaActual').value = numberValue;
        } else {
            input.value = '';
            document.getElementById('hargaActual').value = '';
        }
    }
</script>
@endsection