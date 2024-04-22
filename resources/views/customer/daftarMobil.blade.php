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
                <div class="col-md-3 product-col mb-4" onclick="showImage('{{ asset('upload/'.$item->foto_mobil) }}')">
                    <div class="card h-100">
                        <div class="aspect-ratio-square">
                            <img src="{{ asset('upload/' . $item->foto_mobil) }}" class="card-img-top">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">{{$item->nama_mobil}}</h3>
                            <h3 class="card-text"><b>Rp {{ number_format($item->harga_mobil, 0, ',', '.') }}</b></h3>
                            <div class="text-center">
                                <button class="btn btn-primary">Tambah</button>
                            </div>
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
            <h5 class="text-center mt-5">Tidak ada mobil yang tersedia!</h5>
        @endif
    </div>
</div>
<script>
    function showImage(imgPath) {
        document.getElementById('modalImage').src = imgPath;
        $('#imageModal').modal('show');
    }
</script>
@endsection