<?php

namespace App\Http\Controllers;

use App\Models\Htrans;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class laporan extends Controller
{
    public function lihatLaporan()
    {
        $ht = new Htrans();
        $dataH = $ht->get_all_data_selesai_tahun(2024);
        $param["dataH"] = $dataH;

        $monthlyIncome = [];
        for ($i=1; $i <= 12; $i++) {
            $monthlyIncome[$i] = 0; // inisialisasi pendapatan setiap bulan dengan 0
        }

        foreach ($ht->get_all_data_selesai_tahun(2024) as $data) {
            $bulan = date('m', strtotime($data->tanggal_jemput));
            $year = date('Y', strtotime($data->tanggal_jemput));
            if ($year == date('Y')) {
                $monthlyIncome[(int)$bulan] += $data->total;
            }
        }

        // Mengkonversi $monthlyIncome ke array biasa
        $monthlyIncomeData = [];
        foreach ($monthlyIncome as $income) {
            $monthlyIncomeData[] = $income;
        }

        $param["monthlyIncome"] = $monthlyIncomeData;
        $param["tahun"] = "2024";
        $param["total"] = $dataH->sum("total");

        return view("admin.laporan")->with($param);
    }

    public function getLaporanData($tahun)
    {
        $ht = new Htrans();
        $dataH = $ht->get_all_data_selesai_tahun($tahun);

        $monthlyIncome = [];
        for ($i=1; $i <= 12; $i++) {
            $monthlyIncome[$i] = 0; // inisialisasi pendapatan setiap bulan dengan 0
        }

        foreach ($dataH as $data) {
            $bulan = date('m', strtotime($data->tanggal_jemput));
            $monthlyIncome[(int)$bulan] += $data->total;
        }

        // Mengkonversi $monthlyIncome ke array biasa
        $monthlyIncomeData = [];
        foreach ($monthlyIncome as $income) {
            $monthlyIncomeData[] = $income;
        }

        // Generate table data
        $tableData = '';
        if (!$dataH->isEmpty()) {
            foreach ($dataH as $item) {
                $tanggalAwal3 = $item->tanggal_jemput . " " . $item->jam_jemput;
                $tanggalObjek3 = DateTime::createFromFormat('Y-m-d H:i:s', $tanggalAwal3);
                $carbonDate3 = \Carbon\Carbon::parse($tanggalObjek3)->locale('id');
                $tanggalBaru3 = $carbonDate3->isoFormat('D MMMM YYYY HH:mm');

                $durasiText = $item->durasi;
                if ($item->jenis == "City Tour" || $item->jenis == "Zona I") {
                    $durasiText .= ' jam';
                } else {
                    $durasiText .= ' hari';
                }

                $tableData .= '<tr>';
                $tableData .= '<td>' . $tanggalBaru3 . '</td>';
                $tableData .= '<td>' . $item->nama_cust . '</td>';
                $tableData .= '<td>' . $durasiText . '</td>';
                $tableData .= '<td>Rp ' . number_format($item->total, 0, ',', '.') . '</td>';
                $tableData .= '<td><a href="/admin/sewa/detailSewa/' . $item->id_htrans . '" class="btn btn-outline-success">Detail</a></td>';
                $tableData .= '</tr>';
            }
        }

        // Prepare the response
        $response = [
            'monthlyIncome' => $monthlyIncomeData,
            'tableData' => $tableData,
            'total' => $dataH->sum("total")
        ];

        return response()->json($response);
    }
}
