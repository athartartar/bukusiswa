<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GurusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('gurus')->delete();
        
        \DB::table('gurus')->insert(array (
            0 => 
            array (
                'id_guru' => 6,
                'nik' => '0808080808080808',
                'kodeguru' => 'sagj',
                'namaguru' => 'Saya Adalah Guru Jospar',
                'status' => 'Aktif',
                'created_at' => '2026-02-21 19:04:48',
                'updated_at' => '2026-02-21 19:04:48',
            ),
        ));
        
        
    }
}