@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Tambah Mobil</h1>
    <form action="/admin/mobil/tambah" method="post" enctype="multipart/form-data" id="tambahForm">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Nama</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="nama" placeholder="Masukkan Nama">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Foto</label>
            <input type="file" class="form-control" name="foto" accept=".jpg,.png,.jpeg">
        </div>
        <div class="form-group">
            <label for="exampleInputHarga1">Harga</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">Rp</div>
                </div>
                <!-- Input yang terlihat oleh pengguna -->
                <input type="text" class="form-control" id="hargaDisplay" placeholder="Masukkan Harga" oninput="formatNumber2(this)">

                <!-- Input tersembunyi untuk kirim ke server -->
                <input type="hidden" name="harga" id="hargaActual">
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" id="tambah">Tambah</button>
        </div>
    </form>
</div>
<script>
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

    $(document).ready(function() {
        $("#tambah").click(function(event) {
            event.preventDefault(); // Mencegah perilaku default form

            var formData = new FormData($("#tambahForm")[0]);

            $.ajax({
                url: "/admin/mobil/tambah",
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
                            window.history.back();
                        } else if (result.isDenied) {
                            window.history.back();
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

            return false; // Mengembalikan false untuk mencegah submission form
        });
    })
</script>
@endsection