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
    <form action="" method="post" id="submitForm">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Nama</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="nama" placeholder="Masukkan Nama Anda">
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
            <label for="exampleInputDurasi1">Durasi Wisata</label>
            <input type="number" class="form-control" id="exampleInputDurasi1" aria-describedby="durasiHelp" name="durasi" min="0" max="10" placeholder="Masukkan Durasi Wisata Anda">
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
        </div>
    </form>
</div>
@endsection