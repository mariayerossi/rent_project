@extends('layouts.customer')

@section('content')
<div class="container"> 
    <div class="row justify-content-center"> 
        <div class="col-11 col-sm-9 col-md-7 col-lg-6 col-xl-5 text-center p-0"> 
            <div class="px-0 pb-0"> 
                <form id="form"> 
                    <ul id="progressbar">
                        <li class="active" id="step1"> 
                            <strong>Pricelist</strong> 
                        </li> 
                        <li class="active" id="step2">
                            <strong>Mobil</strong>
                        </li> 
                        <li class="active" id="step3">
                            <strong>Data</strong>
                        </li> 
                        <li id="step4"><strong>Bayar</strong></li> 
                    </ul> 
                    <fieldset> 
                        <h1><b>Isi Data</b></h1>
                    </fieldset> 
                </form> 
            </div> 
        </div>
    </div> 
</div>
<div class="container mb-5">
    <form action="" method="post" id="kirimForm">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Nama</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="nama" placeholder="Masukkan Nama Anda">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Nomer Telepon yang terdaftar di Whatsapp</label>
            <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="telepon" placeholder="Masukkan Nomer Telepon Whatsaap Anda">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Alamat Email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Masukkan Alamat Email Anda">
        </div>
        <div class="form-group">
            <label for="exampleInputDate1">Tanggal Penjemputan</label>
            <input type="date" class="form-control" id="exampleInputDate1" aria-describedby="dateHelp" name="tanggal">
        </div>
        <div class="form-group">
            <label for="exampleInputTime1">Jam Penjemputan</label>
            <input type="time" class="form-control" id="exampleInputTime1" aria-describedby="timeHelp" name="jam">
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Alamat Penjemputan</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="alamat"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputDurasi1">Durasi Wisata</label>
            <div class="input-group mb-2">
                <input type="number" class="form-control" id="exampleInputDurasi1" aria-describedby="durasiHelp" name="durasi" min="0" max="10" placeholder="Masukkan Durasi Wisata Anda">
                <div class="input-group-prepend">
                    @if (session()->get("jenis") == "City Tour" || session()->get("jenis") == "Zona I")
                        <div class="input-group-text">jam</div>
                    @else
                        <div class="input-group-text">hari</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" id="kirim">Submit</button>
        </div>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="agreementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">PERHATIAN!</h5>
                </div>
                <div class="modal-body">
                    Peraturan: <br>
                    1. Mobil harus dikembalikan dengan  tangki bahan bakar yang terisi penuh. (Kecuali jenis city tour) <br>
                    2. Harga tidak dapat dinegosiasikan untuk perjalanan pada akhir pekan atau saat libur. <br>
                    3. Negosiasi harga dan pemesanan hanya dapat dilakukan melalui Whatsapp. <br>
                    4. Pembatalan pemesanan 1 minggu sebelumnya mendapat pengembalian dana sebesar 50%. <br>
                    5. Pembatalan pemesanan kurang dari seminggu sebelumnya tidak mendapat pengembalian dana.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmBooking">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('kirim').addEventListener('click', function(event) {
        event.preventDefault();
        $('#agreementModal').modal('show');
    });

    document.getElementById('confirmBooking').addEventListener('click', function(event) {
        $('#agreementModal').modal('hide');
        event.preventDefault();

        var formData = new FormData($("#kirimForm")[0]);

        $.ajax({
            url: "/customer/kirimData",
            type: "POST",
            data: formData,
            processData: false,
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
                        // window.location.reload();
                        window.location.href = "/customer/bayar";
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

        return false; // Mengembalikan false untuk mencegah submission form
    });
</script>
@endsection