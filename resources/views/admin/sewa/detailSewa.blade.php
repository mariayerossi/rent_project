@extends('layouts.admin')

@section('content')
<div class="container">
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
    <h4>Status: @if($dataH->status_htrans == "Lunas") <b style="color: rgb(11, 164, 11)">Lunas</b> @else <b style="color:rgb(227, 227, 0)">{{$dataH->status_htrans}}</b>  @endif </h4>

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
</div>
@endsection