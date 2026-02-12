<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PelanggaransTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pelanggarans')->delete();
        
        \DB::table('pelanggarans')->insert(array (
            0 => 
            array (
                'id_pelanggaran' => 13,
                'id_siswa' => 4,
                'tanggal' => '2026-02-12',
                'jenis_pelanggaran' => 'Atribut Tidak Lengkap',
                'poin' => 5,
                'keterangan' => NULL,
                'bukti_foto' => NULL,
                'dicatat_oleh' => '0606',
                'created_at' => '2026-02-12 02:10:53',
            ),
            1 => 
            array (
                'id_pelanggaran' => 14,
                'id_siswa' => 4,
                'tanggal' => '2026-02-12',
                'jenis_pelanggaran' => 'Terlambat',
                'poin' => 5,
                'keterangan' => NULL,
                'bukti_foto' => 'bukti/1770862256_698d36b093142.jpg',
                'dicatat_oleh' => '0606',
                'created_at' => '2026-02-12 02:10:58',
            ),
            2 => 
            array (
                'id_pelanggaran' => 17,
                'id_siswa' => 4,
                'tanggal' => '2026-02-12',
                'jenis_pelanggaran' => 'Terlambat',
                'poin' => 5,
                'keterangan' => NULL,
                'bukti_foto' => NULL,
                'dicatat_oleh' => '1234',
                'created_at' => '2026-02-12 02:22:57',
            ),
            3 => 
            array (
                'id_pelanggaran' => 18,
                'id_siswa' => 9,
                'tanggal' => '2026-02-12',
                'jenis_pelanggaran' => 'Terlambat',
                'poin' => 5,
                'keterangan' => NULL,
                'bukti_foto' => 'bukti/1770864132_698d3e0410ae1.jpg',
                'dicatat_oleh' => '0606',
                'created_at' => '2026-02-12 02:42:12',
            ),
            4 => 
            array (
                'id_pelanggaran' => 19,
                'id_siswa' => 9,
                'tanggal' => '2026-02-12',
                'jenis_pelanggaran' => 'Berkelahi',
                'poin' => 75,
                'keterangan' => NULL,
                'bukti_foto' => NULL,
                'dicatat_oleh' => '0606',
                'created_at' => '2026-02-12 02:46:09',
            ),
            5 => 
            array (
                'id_pelanggaran' => 20,
                'id_siswa' => 9,
                'tanggal' => '2026-02-12',
                'jenis_pelanggaran' => 'Merokok',
                'poin' => 50,
                'keterangan' => NULL,
                'bukti_foto' => NULL,
                'dicatat_oleh' => '0606',
                'created_at' => '2026-02-12 02:46:10',
            ),
            6 => 
            array (
                'id_pelanggaran' => 21,
                'id_siswa' => 9,
                'tanggal' => '2026-02-12',
                'jenis_pelanggaran' => 'Bolos Pelajaran',
                'poin' => 20,
                'keterangan' => NULL,
                'bukti_foto' => NULL,
                'dicatat_oleh' => '0606',
                'created_at' => '2026-02-12 02:46:10',
            ),
            7 => 
            array (
                'id_pelanggaran' => 22,
                'id_siswa' => 4,
                'tanggal' => '2026-02-12',
                'jenis_pelanggaran' => 'Rambut Gondrong',
                'poin' => 10,
                'keterangan' => NULL,
                'bukti_foto' => NULL,
                'dicatat_oleh' => '0606',
                'created_at' => '2026-02-12 02:47:43',
            ),
            8 => 
            array (
                'id_pelanggaran' => 25,
                'id_siswa' => 4,
                'tanggal' => '2026-02-12',
                'jenis_pelanggaran' => 'Bolos Pelajaran',
                'poin' => 20,
                'keterangan' => NULL,
                'bukti_foto' => NULL,
                'dicatat_oleh' => '0606',
                'created_at' => '2026-02-12 02:49:47',
            ),
            9 => 
            array (
                'id_pelanggaran' => 26,
                'id_siswa' => 4,
                'tanggal' => '2026-02-12',
                'jenis_pelanggaran' => 'Rambut Gondrong',
                'poin' => 10,
                'keterangan' => NULL,
                'bukti_foto' => NULL,
                'dicatat_oleh' => '0606',
                'created_at' => '2026-02-12 02:49:54',
            ),
        ));
        
        
    }
}