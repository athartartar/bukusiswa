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
                'id_siswa' => 1801,
                'nis' => '213123123',
                'namalengkap' => 'Asdsadasd',
                'jeniskelamin' => 'L',
                'kelas' => 'XII TKJ 2',
                'created_at' => '2026-02-08 09:36:48',
                'updated_at' => '2026-02-08 09:36:48',
                'id_user' => NULL,
            ),
            1 => 
            array (
                'id_siswa' => 1802,
                'nis' => '12321312',
                'namalengkap' => 'Asdsadsads',
                'jeniskelamin' => 'P',
                'kelas' => 'X AKL 2',
                'created_at' => '2026-02-08 10:10:01',
                'updated_at' => '2026-02-08 10:10:01',
                'id_user' => NULL,
            ),
            2 => 
            array (
                'id_siswa' => 1803,
                'nis' => '040404040404',
                'namalengkap' => 'Kim Poo Theen',
                'jeniskelamin' => 'L',
                'kelas' => 'X TSM 1',
                'created_at' => '2026-02-12 04:24:34',
                'updated_at' => '2026-02-12 04:24:34',
                'id_user' => 5,
            ),
            3 => 
            array (
                'id_siswa' => 1804,
                'nis' => '242510001',
                'namalengkap' => 'Aded Fadly Mulyawan',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:52',
                'updated_at' => '2026-02-13 19:00:52',
                'id_user' => NULL,
            ),
            4 => 
            array (
                'id_siswa' => 1805,
                'nis' => '242510002',
                'namalengkap' => 'Adelia Nurul Aviyansah',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:52',
                'updated_at' => '2026-02-13 19:00:52',
                'id_user' => NULL,
            ),
            5 => 
            array (
                'id_siswa' => 1806,
                'nis' => '242510003',
                'namalengkap' => 'Alan Rifki Saputra',
                'jeniskelamin' => 'L',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:53',
                'updated_at' => '2026-02-13 19:00:53',
                'id_user' => NULL,
            ),
            6 => 
            array (
                'id_siswa' => 1807,
                'nis' => '242510004',
                'namalengkap' => 'Amelia Nur Maulida',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:53',
                'updated_at' => '2026-02-13 19:00:53',
                'id_user' => NULL,
            ),
            7 => 
            array (
                'id_siswa' => 1808,
                'nis' => '242510005',
                'namalengkap' => 'Anggiesya Putri Hanuun',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:53',
                'updated_at' => '2026-02-13 19:00:53',
                'id_user' => NULL,
            ),
            8 => 
            array (
                'id_siswa' => 1809,
                'nis' => '242510006',
                'namalengkap' => 'Anggun Cahya Kirani',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:53',
                'updated_at' => '2026-02-13 19:00:53',
                'id_user' => NULL,
            ),
            9 => 
            array (
                'id_siswa' => 1810,
                'nis' => '242510007',
                'namalengkap' => 'Arumy Prameswari',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:54',
                'updated_at' => '2026-02-13 19:00:54',
                'id_user' => NULL,
            ),
            10 => 
            array (
                'id_siswa' => 1811,
                'nis' => '242510008',
                'namalengkap' => 'Aura Maulida Yassmin',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:54',
                'updated_at' => '2026-02-13 19:00:54',
                'id_user' => NULL,
            ),
            11 => 
            array (
                'id_siswa' => 1812,
                'nis' => '242510009',
                'namalengkap' => 'Ayuma Anayshfa',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:54',
                'updated_at' => '2026-02-13 19:00:54',
                'id_user' => NULL,
            ),
            12 => 
            array (
                'id_siswa' => 1813,
                'nis' => '242510010',
                'namalengkap' => 'Daffi Alfahrizi',
                'jeniskelamin' => 'L',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:54',
                'updated_at' => '2026-02-13 19:00:54',
                'id_user' => NULL,
            ),
            13 => 
            array (
                'id_siswa' => 1814,
                'nis' => '242510011',
                'namalengkap' => 'Daviero Ibnu Basid',
                'jeniskelamin' => 'L',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:55',
                'updated_at' => '2026-02-13 19:00:55',
                'id_user' => NULL,
            ),
            14 => 
            array (
                'id_siswa' => 1815,
                'nis' => '242510012',
                'namalengkap' => 'Difa Novita Sari',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:55',
                'updated_at' => '2026-02-13 19:00:55',
                'id_user' => NULL,
            ),
            15 => 
            array (
                'id_siswa' => 1816,
                'nis' => '242510013',
                'namalengkap' => 'Dini Aprilia',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:55',
                'updated_at' => '2026-02-13 19:00:55',
                'id_user' => NULL,
            ),
            16 => 
            array (
                'id_siswa' => 1817,
                'nis' => '242510014',
                'namalengkap' => 'Dini Septia Ramadhani',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:56',
                'updated_at' => '2026-02-13 19:00:56',
                'id_user' => NULL,
            ),
            17 => 
            array (
                'id_siswa' => 1818,
                'nis' => '242510015',
                'namalengkap' => 'Ghifari Gheria Saputra',
                'jeniskelamin' => 'L',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:56',
                'updated_at' => '2026-02-13 19:00:56',
                'id_user' => NULL,
            ),
            18 => 
            array (
                'id_siswa' => 1819,
                'nis' => '242510016',
                'namalengkap' => 'Keisya Rahma Nurfadilah',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:56',
                'updated_at' => '2026-02-13 19:00:56',
                'id_user' => NULL,
            ),
            19 => 
            array (
                'id_siswa' => 1820,
                'nis' => '242510017',
                'namalengkap' => 'Keyzha As Shiffa',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:56',
                'updated_at' => '2026-02-13 19:00:56',
                'id_user' => NULL,
            ),
            20 => 
            array (
                'id_siswa' => 1821,
                'nis' => '242510018',
                'namalengkap' => 'Laura Lidya Pratama',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:57',
                'updated_at' => '2026-02-13 19:00:57',
                'id_user' => NULL,
            ),
            21 => 
            array (
                'id_siswa' => 1822,
                'nis' => '242510019',
                'namalengkap' => 'Meisya Talaita Putri',
                'jeniskelamin' => 'P',
                'kelas' => 'XI DPIBA',
                'created_at' => '2026-02-13 19:00:57',
                'updated_at' => '2026-02-13 19:00:57',
                'id_user' => NULL,
            ),
        ));
        
        
    }
}