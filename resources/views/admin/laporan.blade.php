@extends('layouts.admin')

@section('content')
<style>
    .chart-container {
        width: 100%;   /* Atur lebar sesuai keinginan */
        height: 300px; /* Atur tinggi sesuai keinginan */
        margin: 0 auto; /* opsional: untuk mengatur grafik agar berada di tengah */
    }
    @media (max-width: 768px) {  /* angka 768px adalah titik putus umum untuk tablet, Anda bisa menyesuaikannya */
        .chart-container {
            width: 100%;   /* Di mobile, sebaiknya gunakan 100% agar mengisi seluruh lebar */
            height: 200px; /* Tinggi yang lebih kecil untuk mobile */
        }
    }
    .select-wrapper {
    display: inline-block;
    vertical-align: middle; /* Menyesuaikan posisi vertikal input select */
    margin-left: 10px;
}

.mt-3 {
    vertical-align: middle; /* Menyesuaikan posisi vertikal teks */
}

</style>
<div class="container">
    <h2><b>Total Pendapatan:</b></h2>
    <h2><b id="total-pendapatan">Rp {{number_format($total, 0, ',', '.')}}</b></h2>

    <h3 class="mt-3">Grafik Pendapatan Tahun:
        <div class="select-wrapper">
            <select id="year-select" onchange="pilihTahun(this)">
                <?php
                $start_year = 2022;
                $current_year = date('Y');
                
                for ($year = $start_year; $year <= $current_year; $year++) {
                    $selected = ($year == $tahun) ? 'selected' : ''; // Jika tahun sama dengan $tahun, tambahkan atribut 'selected'
                    echo "<option value=\"$year\" $selected>$year</option>";
                }
                ?>
            </select>
        </div>
    </h3>
    <div class="card">
        <div class="card-body">
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <table class="table mt-4" id="laporan-table">
        <thead>
            <tr>
                <th scope="col">Tanggal Sewa</th>
                <th scope="col">Nama Penyewa</th>
                <th scope="col">Durasi Wisata</th>
                <th scope="col">Total</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if (!$dataH->isEmpty())
                @foreach ($dataH as $item)
                    <tr>
                        @php
                            $tanggalAwal3 = $item->tanggal_jemput . " " . $item->jam_jemput;
                            $tanggalObjek3 = DateTime::createFromFormat('Y-m-d H:i:s', $tanggalAwal3);
                            $carbonDate3 = \Carbon\Carbon::parse($tanggalObjek3)->locale('id');
                            $tanggalBaru3 = $carbonDate3->isoFormat('D MMMM YYYY HH:mm');
                        @endphp
                        <td>{{$tanggalBaru3}}</td>
                        <td>{{$item->nama_cust}}</td>
                        <td>{{$item->durasi}} @if($item->jenis == "City Tour" || $item->jenis == "Zona I") jam @else hari @endif</td>
                        <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        <td><a href="/admin/sewa/detailSewa/{{$item->id_htrans}}" class="btn btn-outline-success">Detail</a></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
    // Data untuk grafik
    var monthlyIncome = @json($monthlyIncome);

    // Labels for the months in Indonesian
    var labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    // Get the context of the new canvas element
    var ctx = document.getElementById('revenueChart').getContext('2d');

    // Create the chart using the updated canvas and maintain original data and configurations
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Pendapatan',
                data: monthlyIncome,
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Updated color to match the new example
                borderColor: 'rgba(54, 162, 235, 1)', // Updated color to match the new example
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                }
            }
        }
    });

    function pilihTahun(select) {
        // alert(select.value);
        var tahun = select.value;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Kirim permintaan AJAX
        $.ajax({
            url: '/admin/laporan/data/' + tahun,
            type: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                // Perbarui grafik
                myChart.data.datasets[0].data = data.monthlyIncome;
                myChart.update();
                // Perbarui tabel
                $('#laporan-table tbody').html(data.tableData);
                $('#total-pendapatan').text('Rp ' + data.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));

            }
        });
    }
</script>
@endsection