@extends('layouts.customer')

@section('content')
<style>
    .aspect-ratio-square {
        position: relative;
        width: 100%;
        padding-bottom: 62.5%; /* (10 / 16) * 100 */
        background-color: #f5f5f5;
        overflow: hidden;
    }

    .aspect-ratio-square img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Pada ukuran layar kecil (mobile), tampilkan 2 produk per baris */
    @media (max-width: 768px) {
        .product-col {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }
    /* CSS untuk Desktop dan layar besar */
    .responsive-form {
        width: 50%;
    }

    /* CSS untuk layar dengan lebar maksimum 768px (misalnya tablet) */
    @media (max-width: 768px) {
        .responsive-form {
            width: 70%;
        }
    }

    /* CSS untuk layar dengan lebar maksimum 576px (misalnya smartphone) */
    @media (max-width: 576px) {
        .responsive-form {
            width: 100%;
        }
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
                        <li id="step3"><strong>Data</strong></li> 
                        <li id="step4"><strong>Bayar</strong></li> 
                    </ul> 
                    <fieldset> 
                        <h1><b>Pilih Mobil</b></h1>
                    </fieldset> 
                </form> 
            </div> 
        </div> 
    </div> 
</div> 
<div class="container mb-5">
    <div class="row mt-4">
        @if (!$data->isEmpty())
            @foreach ($data as $item)
                <div class="col-md-3 product-col mb-4">
                    <div class="card h-100">
                        <div class="aspect-ratio-square" onclick="showImage('{{ asset('upload/'.$item->foto_mobil) }}')">
                            <img src="{{ asset('upload/' . $item->foto_mobil) }}" class="card-img-top">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">{{$item->nama_mobil}}</h3>
                            <h3 class="card-text"><b>Rp {{ number_format($item->harga_mobil, 0, ',', '.') }}</b></h3>
                            <div class="text-center">
                                <button class="btn btn-primary btn-tambah-keranjang" data-id="{{$item->id_mobil}}">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="cartForm-{{$item->id_mobil}}" action="/customer/keranjang/tambah" method="post" style="display: none;">
                    @csrf
                    <input type="hidden" name="id" value="{{$item->id_mobil}}">
                    <input type="hidden" name="nama" value="{{$item->nama_mobil}}">
                    <input type="hidden" name="harga" value="{{$item->harga_mobil}}">
                </form>
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
            <div class="fixed-bottom mb-3 ml-3">
                <button class="btn btn-primary btn-buka-keranjang" data-toggle="modal" data-target="#keranjangModal">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                </button>
            </div>
            <!-- Tambahkan kode untuk popup keranjang -->
<div class="modal fade" id="keranjangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Keranjang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="keranjang-body">
                        @if (Session::has("cart"))
                            @foreach (Session::get("cart") as $item)
                                <tr>
                                    <td>{{$item["nama"]}}</td>
                                    <td>{{$item["harga"]}}</td>
                                    <td><a href="" class="hapus" data-id="{{$item["id"]}}">Hapus</a></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
        @else
            <h5 class="text-center mt-5">Tidak ada mobil yang tersedia!</h5>
        @endif
    </div>
</div>
<script>
    function showImage(imgPath) {
        document.getElementById('modalImage').src = imgPath;
        $('#imageModal').modal('show');
    }
    
    $(document).ready(function() {
        // Tangani klik tombol tambah ke keranjang
        $(".btn-tambah-keranjang").click(function(e) {
            e.preventDefault();
            var productId = $(this).data('id');
            // Kirim permintaan AJAX
            $.ajax({
                type: "POST",
                url: "/customer/keranjang/tambah", // Ganti URL dengan endpoint yang benar
                data: $('#cartForm-'+productId).serialize(), // Serialize form data
                success: function(response) {
                    // Tangani respons JSON dari server
                    // alert(response.message);
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
                },
                error: function(xhr, status, error) {
                    // Tangani kesalahan AJAX
                    alert('Terjadi kesalahan saat memproses permintaan: ' + error);
                }
            });
        });

        // Fungsi untuk memperbarui tampilan keranjang
        function updateCartView(cartData) {
            // Kosongkan tbody dari tabel keranjang
            $('#keranjang-body').empty();
            // Tambahkan kembali item-item baru dari respons JSON
            $.each(cartData, function(index, item) {
                $('#keranjang-body').append('<tr><td>' + item.nama + '</td><td>' + item.harga + '</td></tr>');
            });
        }

        $(".hapus").click(function(e) {
            e.preventDefault();
            var productId = $(this).data('id');
            // Kirim permintaan AJAX
            $.ajax({
                type: "GET",
                url: "/customer/keranjang/hapus/"+productId, // Ganti URL dengan endpoint yang benar
                data: productId, // Serialize form data
                success: function(response) {
                    // Tangani respons JSON dari server
                    // alert(response.message);
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
                },
                error: function(xhr, status, error) {
                    // Tangani kesalahan AJAX
                    alert('Terjadi kesalahan saat memproses permintaan: ' + error);
                }
            });
        });
    });
</script>
@endsection