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
</div>
@endsection