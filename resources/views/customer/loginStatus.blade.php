@extends('layouts.customer')

@section('content')
<div class="container mb-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Masukkan Nama, Nomer Telepon dan Tanggal Penjemputan yang telah didaftarkan sebelumnya!') }}</div>

                <div class="card-body">
                    <form method="POST" action="/customer/trans/cekStatus" id="tambahForm">
                        @csrf

                        <div class="form-group row">
                            <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>

                            <div class="col-md-6">
                                <input id="nama" type="text" class="form-control" name="nama" value="{{ old('nama') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telp" class="col-md-4 col-form-label text-md-right">{{ __('Nomer Telepon') }}</label>

                            <div class="col-md-6">
                                <input id="telp" type="text" class="form-control" name="telepon" value="{{ old('telepon') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tgl" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Penjemputan') }}</label>

                            <div class="col-md-6">
                                <input id="tgl" type="date" class="form-control" name="tanggal" value="{{ old('tanggal') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="tambah">
                                    {{ __('Cek') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#tambah").click(function(event) {
            event.preventDefault(); // Mencegah perilaku default form

            var formData = new FormData($("#tambahForm")[0]);

            $.ajax({
                url: "/customer/trans/cekStatus",
                type: "POST",
                data: formData,
                processData: false,  // Important: Don't process the data
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success"
                        }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            cekStatusButton.hidden = false;
                        } else if (result.isDenied) {
                            window.location.reload();
                        }
                        });
                    }
                    else {
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            icon: "error"
                        });
                    }
                    // alert('Berhasil Diterima!');
                    // Atau Anda dapat mengupdate halaman dengan respons jika perlu
                    // Anda dapat menyesuaikan feedback yang diberikan ke pengguna berdasarkan respons server
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Ada masalah saat mengirim data. Silahkan coba lagi.');
                }
            });

            return false;
        });
    });
</script>
@endsection
