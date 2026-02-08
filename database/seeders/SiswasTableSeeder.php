<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SiswasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('siswas')->delete();
        
        \DB::table('siswas')->insert(array (
            0 => 
            array (
                'id_siswa' => 3,
                'nis' => '06060606',
                'namalengkap' => 'Asep Sukandar Immanuel',
                'jeniskelamin' => 'L',
                'kelas' => 'X TSM 1',
                'created_at' => '2026-02-07 19:30:45',
                'updated_at' => '2026-02-07 19:30:45',
            ),
        ));
        
        
    }
}