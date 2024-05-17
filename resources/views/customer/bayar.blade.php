@extends('layouts.customer')

@section('content')
<style>
    .img-ratio-4-5 {
        width: 150px; /* lebar tetap sama */
        height: 187.5px; /* tinggi diubah untuk mengikuti rasio 4:5 */
        object-fit: cover;
    }
</style>
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
                        <li class="active" id="step4">
                            <strong>Bayar</strong>
                        </li>
                    </ul> 
                    <fieldset> 
                        <h1><b>Pembayaran</b></h1>
                    </fieldset> 
                </form> 
            </div> 
        </div>
    </div> 
</div>
<div class="container mb-5">
    <div class="d-flex justify-content-center">
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-exclamation-circle"></i>Perhatikan! Pelanggan dapat melakukan pembayaran secara tunai atau dengan sistem pembayaran muka (DP) yang dilakukan saat pemesanan, dengan sisa pembayaran harus diselesaikan paling lambat sebelum keberangkatan. Besaran pembayaran muka dapat ditentukan secara fleksibel, namun untuk situasi yang mendesak, pembayaran muka minimal sebesar 50% dari total biaya.
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-6">
            
        </div>
        <div class="col-3">
            <h3><b>Harga</b></h3>
        </div>
        <div class="col-3">
            <h3><b>Subtotal</b></h3>
        </div>
    </div>

    <h3 class="mt-4"><b>Jenis Perjalanan:</b></h3>
    @if (Session::has("jenis") || Session::get("jenis") != null)
        <div class="row">
            <div class="col-6">
                <h3>{{Session::get("jenis")["nama"]}}</h3>
            </div>
            <div class="col-3">
                <h3>Rp {{ number_format(Session::get("jenis")["harga"], 0, ',', '.') }} x {{Session::get("data")["durasi"]}} @if(Session::get("jenis")["nama"] == "City Tour" || Session::get("jenis")["nama"] == "Zona I") jam @else hari @endif</h3>
            </div>
            <div class="col-3">
                <h3>Rp {{ number_format(Session::get("data")["subtotal_jenis"], 0, ',', '.') }}</h3>
            </div>
        </div>
    @else
        <h3>Tidak ada data. Silahkan pilih jenis perjalanan</h3>
    @endif

    <h3 class="mt-4"><b>Mobil yang disewa:</b></h3>
    @if (Session::has("cart") || Session::get("cart") != null)
        @foreach (Session::get("cart") as $item)
            <div class="row">
                <div class="col-6">
                    <h3>{{$item["nama"]}}</h3>
                </div>
                <div class="col-3">
                    <h3>Rp {{ number_format($item["harga"], 0, ',', '.') }}</h3>
                </div>
                <div class="col-3">
                    <h3>Rp {{ number_format($item["harga"], 0, ',', '.') }}</h3>
                </div>
            </div>
        @endforeach
    @else
        <h3>Tidak ada data. Silahkan pilih jenis mobil</h3>
    @endif

    <hr>

    <div class="row mt-4">
        <div class="col-6">
            <h3><b>Total:</b></h3>
        </div>
        <div class="col-3">

        </div>
        <div class="col-3">
            <h3>Rp {{ number_format(Session::get("data")["total"], 0, ',', '.') }}</h3>
        </div>
    </div> --}}

    @if (Session::has("data") || Session::get("data") != null)
        <h4 class="mt-3">Nama: {{Session::get("data")["nama"]}}</h4>
        <h4>No. Telepon: {{Session::get("data")["telepon"]}}</h4>
        @php
            $tanggalAwal3 = Session::get("data")["tanggal_jem"] . " " . Session::get("data")["jam"];
            $tanggalObjek3 = DateTime::createFromFormat('Y-m-d H:i', $tanggalAwal3);
            $carbonDate3 = \Carbon\Carbon::parse($tanggalObjek3)->locale('id');
            $tanggalBaru3 = $carbonDate3->isoFormat('D MMMM YYYY HH:mm');
            // dd($tanggalAwal3);

            $durasi = Session::get("data")["durasi"];
            $jenis = Session::get("jenis")["nama"];

            // Menghitung waktu kembali
            if ($jenis == "City Tour" || $jenis == "Zona I") {
                // Durasi dalam jam
                $carbonDateKembali = $carbonDate3->copy()->addHours($durasi);
            } else {
                // Durasi dalam hari
                $carbonDateKembali = $carbonDate3->copy()->addDays($durasi);
            }
            $tanggalKembali = $carbonDateKembali->isoFormat('D MMMM YYYY HH:mm');
        @endphp
        <h4>Waktu Penjemputan: {{$tanggalBaru3}}</h4>
        <h4>Durasi Perjalanan: {{Session::get("data")["durasi"]}} @if(Session::get("jenis")["nama"] == "City Tour" || Session::get("jenis")["nama"] == "Zona I") jam @else hari @endif</h4>
        <h4>Waktu Kembali: {{$tanggalKembali}}</h4>
        <h4>Alamat Penjemputan: {{Session::get("data")["alamat"]}}</h4>
    @else
        <h4 class="mt-3">Tidak ada data! Silahkan isi data</h4>
    @endif

    <table class="table mt-4">
        <thead>
            <tr>
                <th scope="col" colspan="2"><h3><b>Jenis Perjalanan:</b></h3></th>
            </tr>
        </thead>
        <tbody>
          @if (Session::has("jenis") || Session::get("jenis") != null)
          <tr>
            <td>{{Session::get("jenis")["nama"]}}</td>
            <td>Rp {{ number_format(Session::get("jenis")["harga"], 0, ',', '.') }} x {{Session::get("data")["durasi"]}} @if(Session::get("jenis")["nama"] == "City Tour" || Session::get("jenis")["nama"] == "Zona I") jam @else hari @endif</td>
          </tr>
          <tr>
            <td><b>Subtotal:</b></td>
            <td><b>Rp {{ number_format(Session::get("data")["subtotal_jenis"], 0, ',', '.') }}</b></td>
          </tr>
          @else
          <tr>
            <td colspan="2">Tidak ada data. Silahkan pilih jenis perjalanan</td>
          </tr>
          @endif
        </tbody>
        <thead>
            <tr>
                <th scope="col" colspan="2"><h3><b>Mobil yang disewa:</b></h3></th>
            </tr>
        </thead>
        <tbody>
          @if (Session::has("cart") || Session::get("cart") != null)
            @foreach (Session::get("cart") as $item)
                <tr>
                    <td>{{$item["nama"]}}</td>
                    <td>Rp {{ number_format($item["harga"], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td><b>Subtotal:</b></td>
                <td><b>Rp {{ number_format(Session::get("data")["subtotal_mobil"], 0, ',', '.') }}</b></td>
            </tr>
        @else
            <tr>
                <td colspan="2">Tidak ada data. Silahkan pilih mobil</td>
            </tr>
        @endif
        <tr>
            <td><h3><b>Total:</b></h3></td>
            <td><h3><b>Rp {{ number_format(Session::get("data")["total"], 0, ',', '.') }}</b></h3></td>
        </tr>
        </tbody>
    </table>
    <h3 class="mt-5">Metode Pembayaran:</h3>
    <img onclick="showImage('{{ asset('upload/qris.jpeg') }}')" style="cursor: zoom-in;" class="img-ratio-4-5" src="{{ asset('upload/qris.jpeg') }}" alt="">
    <button onclick="downloadImage('{{ asset('upload/qris.jpeg') }}')" style="margin-left: 10px; padding: 10px 20px; cursor: pointer;">
        Download Image
    </button>
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
    <form class="mt-3" action="/customer/trans/tambahDP" method="POST" enctype="multipart/form-data" id="tambahForm">
        @csrf
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>
                        <select class="form-select" aria-label="Default select example" id="dpSelect" name="persen">
                            <option selected value="" disabled>Pilih DP/Tunai</option>
                            <option value="30">DP 30%</option>
                            <option value="50">DP 50%</option>
                            <option value="100">Tunai 100%</option>
                          </select>
                    </td>
                    <td>
                        <h3 id="jumlah">Total yang dibayar: Rp 0</h3>
                        <input type="hidden" name="jumlah" id="jumlah2" value="">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Masukkan Bukti Pembayaran: <input type="file" name="bukti" id="" accept=".jpg,.png,.jpeg"></td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success" id="tambah">Bayar</button>
            <a href="/customer/trans/loginStatus" hidden class="btn btn-secondary" id="cekStatus">Cek Status</a>
        </div>
    </form>
</div>
<script>
    function showImage(imgPath) {
        document.getElementById('modalImage').src = imgPath;
        $('#imageModal').modal('show');
    }
    const bayarButton = document.getElementById('tambahBayar');
    const cekStatusButton = document.getElementById('cekStatus');
    
    // Misalkan nilai total diambil dari Session
    const total = {{Session::get("data")["total"]}}; // Gantilah nilai ini dengan nilai dari Session::get("data")["total"]

    $(document).ready(function() {
        $('#dpSelect').change(function() {
            let selectedValue = $(this).val();
            let calculatedValue = total;

            if (selectedValue) {
                let percentage = parseInt(selectedValue);
                calculatedValue = total * (percentage / 100);
            }

            $('#jumlah').text('Total yang dibayar: Rp ' + calculatedValue.toLocaleString('id-ID'));
            $('#jumlah2').val(calculatedValue);
        });
        
        $("#tambah").click(function(event) {
            event.preventDefault(); // Mencegah perilaku default form

            var formData = new FormData($("#tambahForm")[0]);

            $.ajax({
                url: "/customer/trans/tambahDP",
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
    function downloadImage(url) {
        fetch(url)
            .then(response => response.blob())
            .then(blob => {
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'qris.jpeg';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            })
            .catch(console.error);
    }
</script>
@endsection