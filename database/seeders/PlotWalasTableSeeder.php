<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PlotWalasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('plot_walas')->delete();
        
        \DB::table('plot_walas')->insert(array (
            0 => 
            array (
                'id_walas' => 2,
                'id_guru' => 6,
                'id_kelas' => 1,
                'created_at' => '2026-02-21 19:18:41',
                'updated_at' => '2026-02-21 19:18:57',
            ),
        ));
        
        
    }
}