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
    <a href="/customer/trans/logout" class="btn btn-outline-primary mb-2 float-right">Keluar</a>
    <h4>Nama: {{$dataH->nama_cust}}</h4>
    <h4>No. Telepon: {{$dataH->telepon_cust}}</h4>
    @php
        $tanggalAwal3 = $dataH->tanggal_jemput . " " . $dataH->jam_jemput;
        $tanggalObjek3 = DateTime::createFromFormat('Y-m-d H:i:s', $tanggalAwal3);
        $carbonDate3 = \Carbon\Carbon::parse($tanggalObjek3)->locale('id');
        $tanggalBaru3 = $carbonDate3->isoFormat('D MMMM YYYY HH:mm');
        // dd($tanggalAwal3);

        $durasi = $dataH->durasi;
        $jenis = $dataH->jenis;

        // Menghitung waktu kembali
        if ($jenis == "City Tour" || $jenis == "Zona I") {
            // Durasi dalam jam
            $carbonDateKembali = $carbonDate3->copy()->addHours($durasi);
        } else {
            // Durasi dalam hari
            $carbonDateKembali = $carbonDate3->copy()->addDays($durasi);
        }
        $tanggalKembali = $carbonDateKembali->isoFormat('D MMMM YYYY');
    @endphp
    <h4>Waktu Penjemputan: {{$tanggalBaru3}}</h4>
    <h4>Durasi Perjalanan: {{$dataH->durasi}} @if($dataH->jenis == "City Tour" || $dataH->jenis == "Zona I") jam @else hari @endif</h4>
    <h4>Waktu Kembali: {{$tanggalKembali}}</h4>
    <h4>Alamat Penjemputan: {{$dataH->alamat_jemput}}</h4>

    <table class="table mt-4">
        <thead>
            <tr>
                <th scope="col" colspan="2"><h3><b>Jenis Perjalanan:</b></h3></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$dataH->jenis}}</td>
                <td>Rp {{ number_format($dataH->harga_jenis, 0, ',', '.') }} x {{$dataH->durasi}} @if($dataH->jenis == "City Tour" || $dataH->jenis == "Zona I") jam @else hari @endif</td>
              </tr>
              <tr>
                <td><b>Subtotal:</b></td>
                <td><b>Rp {{ number_format($dataH->subtotal_jenis, 0, ',', '.') }}</b></td>
              </tr>
        </tbody>
        <thead>
            <tr>
                <th scope="col" colspan="2"><h3><b>Mobil yang disewa:</b></h3></th>
            </tr>
        </thead>
        <tbody>
          @if (!$dataD->isEmpty())
            @foreach ($dataD as $item)
                @php
                    $dataM = DB::table('mobil')->where("id_mobil","=",$item->fk_id_mobil)->first();
                @endphp
                <tr>
                    <td>{{$dataM->nama_mobil}}</td>
                    <td>Rp {{ number_format($dataM->harga_mobil, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td><b>Subtotal:</b></td>
                <td><b>Rp {{ number_format($dataH->subtotal_mobil, 0, ',', '.') }}</b></td>
            </tr>
        @else
            <tr>
                <td colspan="2">Tidak ada data. Silahkan pilih mobil</td>
            </tr>
        @endif
        <tr>
            <td><h3><b>Total:</b></h3></td>
            <td><h3><b>Rp {{ number_format($dataH->total, 0, ',', '.') }}</b></h3></td>
        </tr>
        </tbody>
    </table>

    <h3 class="mt-5"><b>Rincian Pembayaran</b></h3>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @if (!$dataP->isEmpty())
                @foreach ($dataP as $item)
                    <tr>
                        @php
                            $tanggalAwal3 = $item->tanggal;
                            $tanggalObjek3 = DateTime::createFromFormat('Y-m-d H:i:s', $tanggalAwal3);
                            $carbonDate3 = \Carbon\Carbon::parse($tanggalObjek3)->locale('id');
                            $tanggalBaru3 = $carbonDate3->isoFormat('D MMMM YYYY HH:mm');
                        @endphp
                        <td>{{$tanggalBaru3}}</td>
                        <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                @if ($dataP->sum("jumlah") < $dataH->total)
                    <tr>
                        <td><b>Kekurangan :</b></td>
                        <td><b>Rp {{ number_format($dataH->total-$dataP->sum("jumlah"), 0, ',', '.') }}</b></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2" style="text-align: center;"><b>PEMBAYARAN LUNAS!</b></td>
                    </tr>
                @endif
            @endif
        </tbody>
    </table>

    @if ($dataP->sum("jumlah") < $dataH->total)
        {{-- BAGIAN PEMBAYARAN UNTUK SISANYA --}}
        <h3 class="mt-4"><b>Kekurangan Pembayaran: Rp {{ number_format($dataH->total-$dataP->sum("jumlah"), 0, ',', '.') }}</b></h3>
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
        <form action="/customer/trans/bayarSisanya" enctype="multipart/form-data" method="post" class="mb-5 mt-3" id="tambahForm">
            @csrf
            <input type="hidden" name="persen" value={{100-$dataP->sum("persen")}}>
            <input type="hidden" name="htrans" value={{$dataH->id_htrans}}>
            <input type="hidden" name="jumlah" value={{$dataH->total-$dataP->sum("jumlah")}}>
            Masukkan Bukti Pembayaran: <input type="file" name="bukti" id="" accept=".jpg,.png,.jpeg">
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" id="tambah">Bayar</button>
            </div>
        </form>
    @endif

</div>
<script>
    function showImage(imgPath) {
        document.getElementById('modalImage').src = imgPath;
        $('#imageModal').modal('show');
    }
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
    $(document).ready(function() {
        $("#tambah").click(function(event) {
            event.preventDefault(); // Mencegah perilaku default form

            var formData = new FormData($("#tambahForm")[0]);

            $.ajax({
                url: "/customer/trans/bayarSisanya",
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
                            window.location.reload();
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