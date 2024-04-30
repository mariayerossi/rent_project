@extends('layouts.customer')

@section('content')
<style>
    .custom-list {
  list-style: none; /* Menghapus default bullet */
}
.custom-list li:before {
  content: "\2713"; /* Unicode untuk centang */
  display: inline-block;
  width: 1em; /* Menyesuaikan ukuran */
  margin-left: -1em; /* Menggeser ke kiri agar terlihat rapi */
}
.custom-list2 {
  list-style: none; /* Menghapus default bullet */
}
.custom-list2 li:before {
  content: "\2717"; /* Unicode untuk silang */
  display: inline-block;
  width: 1em; /* Menyesuaikan ukuran */
  margin-left: -1em; /* Menggeser ke kiri agar terlihat rapi */
}
ul li {
    font-size: 20px;
}
.card-text {
    font-size: 20px;
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
                        <li id="step2"><strong>Mobil</strong></li> 
                        <li id="step3"><strong>Data</strong></li> 
                        <li id="step4"><strong>Bayar</strong></li> 
                    </ul> 
                    <fieldset> 
                        <h1><b>Pilih Pricelist</b></h1>
                    </fieldset> 
                </form> 
            </div> 
        </div> 
    </div> 
</div> 
<div class="container mb-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center" style="box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);">
                <div class="card-header bg-primary text-white">
                    <h3 class="text-white">City Tour</h3>
                    <h4> </h4>
                </div>
                <div class="card-body d-flex flex-column" style="height: 520px;">
                    <h2 class="card-title">Rp 1.100.000/12 jam</h2>
                    <p class="card-text">
                        <h3>Sudah Termasuk:</h3>
                        <ul class="custom-list mb-3">
                            <li>Mobil</li>
                            <li>Driver</li>
                            <li>BBM</li>
                        </ul>
                        <h3>Tidak Termasuk:</h3>
                        <ul class="custom-list2">
                            <li>Biaya Parkir</li>
                            <li>Biaya Tol</li>
                        </ul>
                    </p>
                    <div class="mt-auto">
                        {{-- <a href="#" class="btn btn-primary">Booking</a> --}}
                        <form action="/customer/jenis/pilih" method="get">
                            @csrf
                            <input type="hidden" name="jenis" value="City Tour">
                            <button type="submit" class="btn btn-primary">Booking</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);">
                <div class="card-header bg-success text-white">
                    <h3 class="text-white">Zona I</h3>
                    <h4 class="text-white">(Jawa Timur ≥ 175 km)</h4>
                </div>
                <div class="card-body d-flex flex-column" style="height: 500px;">
                    <h2 class="card-title">Rp 1.300.000/12 jam</h2>
                    <h4 class="card-title">(max. 15 jam)</h4>
                    <p class="card-text">
                        <h3>Sudah Termasuk:</h3>
                        <ul class="custom-list mb-3">
                            <li>Mobil</li>
                            <li>Driver</li>
                        </ul>
                        <h3>Tidak Termasuk:</h3>
                        <ul class="custom-list2">
                            <li>BBM</li>
                            <li>Biaya Parkir</li>
                            <li>Biaya Tol</li>
                        </ul>
                    </p>
                    <div class="mt-auto">
                        {{-- <a href="#" class="btn btn-primary">Booking</a> --}}
                        <form action="/customer/jenis/pilih" method="get">
                            @csrf
                            <input type="hidden" name="jenis" value="Zona I">
                            <button type="submit" class="btn btn-primary">Booking</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);">
                <div class="card-header bg-secondary text-white">
                    <h3 class="text-white">Zona II</h3>
                    <h4 class="text-white">(Jawa Tengah ≥ 400 km)</h4>
                </div>
                <div class="card-body d-flex flex-column" style="height: 500px;">
                    <h2 class="card-title">Rp 1.500.000/hari</h2>
                    <h4 class="card-title">(min. 2 hari)</h4>
                    <p class="card-text">
                        <h3>Sudah Termasuk:</h3>
                        <ul class="custom-list mb-3">
                            <li>Mobil</li>
                            <li>Driver</li>
                        </ul>
                        <h3>Tidak Termasuk:</h3>
                        <ul class="custom-list2">
                            <li>BBM</li>
                            <li>Biaya Parkir</li>
                            <li>Biaya Tol</li>
                        </ul>
                    </p>
                    <div class="mt-auto">
                        <form action="/customer/jenis/pilih" method="get">
                            @csrf
                            <input type="hidden" name="jenis" value="Zona II">
                            <button type="submit" class="btn btn-primary">Booking</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center" style="box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);">
                <div class="card-header bg-danger text-white">
                    <h3 class="text-white">Zona III</h3>
                    <h4 class="text-white">(Jawa Barat ≥ 800 km)</h4>
                </div>
                <div class="card-body d-flex flex-column" style="height: 500px;">
                    <h2 class="card-title">Rp 1.700.000/hari</h2>
                    <h4 class="card-title">(min. 3 hari)</h4>
                    <p class="card-text">
                        <h3>Sudah Termasuk:</h3>
                        <ul class="custom-list mb-3">
                            <li>Mobil</li>
                            <li>Driver</li>
                        </ul>
                        <h3>Tidak Termasuk:</h3>
                        <ul class="custom-list2">
                            <li>BBM</li>
                            <li>Biaya Parkir</li>
                            <li>Biaya Tol</li>
                        </ul>
                    </p>
                    <div class="mt-auto">
                        <form action="/customer/jenis/pilih" method="get">
                            @csrf
                            <input type="hidden" name="jenis" value="Zona III">
                            <button type="submit" class="btn btn-primary">Booking</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
