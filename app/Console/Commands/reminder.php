<?php

namespace App\Console\Commands;

use App\Models\Ketersediaan;
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
    }
}