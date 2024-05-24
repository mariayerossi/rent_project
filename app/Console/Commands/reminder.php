<?php

namespace App\Console\Commands;

use App\Models\Htrans;
use App\Models\Ketersediaan;
use App\Models\notifikasiEmail;
use DateInterval;
use DateTime;
use Illuminate\Console\Command;

class reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sed = new Ketersediaan();
        $data2 = $sed->get_all_data();

        date_default_timezone_set("Asia/Jakarta");
        $skrg = date("Y-m-d");
        
        if (!$data2->isEmpty()) {
            foreach ($data2 as $key => $value) {
                if ($value->tanggal_selesai < $skrg) {
                    $data3 = [
                        "id" => $value->id_sedia
                    ];
                    $sed->deleteKetersediaan($data3);
                }
            }
        }

        //---------------------------------------------------------------

        $ht = new Htrans();
        $dataHt1 = $ht->get_all_data_menunggu();

        if (!$dataHt1->isEmpty()) {
            foreach ($dataHt1 as $key => $value) {
                //reminder melunasi hutang
                if ($value->status_htrans == "Menunggu") {
                    date_default_timezone_set('Asia/Jakarta');
                    $skrg = date('Y-m-d H:i:s');

                    //reminder ke cust bahwa besok waktu booking
                    $tanggal = $value->tanggal_jemput." ".$value->jam_jemput;
                    $sewa = new DateTime($tanggal);
                    $sewa->sub(new DateInterval('P5D'));
                    $sew = $sewa->format('Y-m-d H:i:s');

                    if (new DateTime($skrg) == new DateTime($sew)) {
                    // if ($skrg == $sew) {
                        $dataNotif = [
                            "subject" => "🔔Jangan Lupa Melunasi Pembayaran🔔",
                            "judul" => "Jangan Lupa Melunasi Pembayaran!",
                            "nama_user" => $value->nama_cust,
                            "url" => "/customer/trans/loginStatus",
                            "button" => "Lunasi Sekarang",
                            "isi" => "Halo! Jangan Lupa lunasi pembayaran ya! pelunasan maksimal sebelum keberangkatan. Yuk nikmati wisata bersama Central Hiace Rent Jatim! See You!😊"
                        ];
                        $e = new notifikasiEmail();
                        $e->sendEmail($value->email_cust, $dataNotif);
                    }
                }
            }
        }
    }
}