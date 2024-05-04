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
    <h3><b>Jenis Perjalanan:</b></h3>
    @if (Session::has("jenis") || Session::get("jenis") != null)
        <div class="row">
            <div class="col-9">
                <h3>{{Session::get("jenis")["nama"]}}</h3>
            </div>
            <div class="col-3">
                @php
                    //buat format harga
                    
                @endphp
                <h3>Rp. {{Session::get("jenis")["harga"]}}</h3>
            </div>
        </div>
    @else
        <h3>Tidak ada data. Silahkan pilih jenis perjalanan</h3>
    @endif
</div>
@endsection