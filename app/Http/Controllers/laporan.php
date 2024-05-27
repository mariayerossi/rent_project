<?php

namespace App\Http\Controllers;

use App\Models\Htrans;
use Illuminate\Http\Request;

class laporan extends Controller
{
    public function lihatLaporan()
    {
        $ht = new Htrans();
        $param["dataH"] = $ht->get_all_data();

        $monthlyIncome = [];
        for ($i=1; $i <= 12; $i++) {
            $monthlyIncome[$i] = 0; // inisialisasi pendapatan setiap bulan dengan 0
        }

        foreach ($ht->get_all_data() as $data) {
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

        return view("admin.laporan")->with($param);
    }
}
