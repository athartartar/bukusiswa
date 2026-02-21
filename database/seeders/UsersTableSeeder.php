<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id_user' => 1,
                'namalengkap' => 'saya josdun saya sehat',
                'username' => '0606',
                'password' => '$2y$12$rhsqFAyo/V8IRxZEk9LLn.cyygBYDkTUYqYlxMwzEyMZB5BzqCfLS',
                'usertype' => 'admin',
                'foto' => 'profile-photos/zd9iAcwxfmjoO1pPNi90tEpfI38lgkbX6M2Q2trr.jpg',
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-05 04:43:56',
                'updated_at' => '2026-02-07 18:53:28',
            ),
            1 => 
            array (
                'id_user' => 4,
                'namalengkap' => 'Saya Asep Saya Bangga',
                'username' => '0404',
                'password' => '$2y$12$lmttxYBGephx.PfxMdeiLulOK.1DhqwdLNmuCfFuMR9Z6JswN53QW',
                'usertype' => 'walas',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-08 10:02:57',
                'updated_at' => '2026-02-08 10:51:49',
            ),
            2 => 
            array (
                'id_user' => 5,
                'namalengkap' => 'Kim Poo Theen',
                'username' => '040404040404',
                'password' => '$2y$12$KxKlWDZU39OMAFOwjDZeR.G/hm6nKTJUx9znqmCx/Cy.XPmVaj1cK',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-12 04:25:00',
                'updated_at' => '2026-02-12 04:25:00',
            ),
            3 => 
            array (
                'id_user' => 6,
                'namalengkap' => 'Aded Fadly Mulyawan',
                'username' => '242510001',
                'password' => '$2y$12$7kZCUO9IrTnNVNAddV3XkOGvJvwA2K8.GB.bFloS6Y56LlGGEHDW6',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:52',
                'updated_at' => '2026-02-13 19:00:52',
            ),
            4 => 
            array (
                'id_user' => 7,
                'namalengkap' => 'Adelia Nurul Aviyansah',
                'username' => '242510002',
                'password' => '$2y$12$7CM2FIk8WvrhgKVuguQ26uBJQ61SU3XN0725Xy08UUImeMVuzGDay',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:53',
                'updated_at' => '2026-02-13 19:00:53',
            ),
            5 => 
            array (
                'id_user' => 8,
                'namalengkap' => 'Alan Rifki Saputra',
                'username' => '242510003',
                'password' => '$2y$12$tnilLjMm6gQyMRt3Kjwxiui3yW3lo.WbtLTdFZqDx0Q.5EUv9buly',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:53',
                'updated_at' => '2026-02-13 19:00:53',
            ),
            6 => 
            array (
                'id_user' => 9,
                'namalengkap' => 'Amelia Nur Maulida',
                'username' => '242510004',
                'password' => '$2y$12$q9Hg5XVCZg9.YauANghZ.Ok/kK9Ox5ZQNLvjtNEeIsx/pQlWX6Zc.',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:53',
                'updated_at' => '2026-02-13 19:00:53',
            ),
            7 => 
            array (
                'id_user' => 10,
                'namalengkap' => 'Anggiesya Putri Hanuun',
                'username' => '242510005',
                'password' => '$2y$12$KgOGDmfV9G/jNHqwD4mavuJSxZPVn2k2zzuAl3es3u7M2X0DzlebW',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:53',
                'updated_at' => '2026-02-13 19:00:53',
            ),
            8 => 
            array (
                'id_user' => 11,
                'namalengkap' => 'Anggun Cahya Kirani',
                'username' => '242510006',
                'password' => '$2y$12$AO/A0wNmBNeuJwfsJSuGmudWbKZqupBWL6mAj0UpC14xYXA6asSwK',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:54',
                'updated_at' => '2026-02-13 19:00:54',
            ),
            9 => 
            array (
                'id_user' => 12,
                'namalengkap' => 'Arumy Prameswari',
                'username' => '242510007',
                'password' => '$2y$12$k.IXI5cKIP3YgrVd1m2yz.cZ.RhWrImKQEv/iQ7L/xj1PBk1/37RW',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:54',
                'updated_at' => '2026-02-13 19:00:54',
            ),
            10 => 
            array (
                'id_user' => 13,
                'namalengkap' => 'Aura Maulida Yassmin',
                'username' => '242510008',
                'password' => '$2y$12$OwKxOIfPY6Sd8smavT/OAeve2ZEDo8kYBscX3vg5aNFgiCpRoy3LG',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:54',
                'updated_at' => '2026-02-13 19:00:54',
            ),
            11 => 
            array (
                'id_user' => 14,
                'namalengkap' => 'Ayuma Anayshfa',
                'username' => '242510009',
                'password' => '$2y$12$BZ5RzLXFCyISQChTrQdzMeYYGfzxHZ634xzZoPO3ZEHpZmqYVkW32',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:54',
                'updated_at' => '2026-02-13 19:00:54',
            ),
            12 => 
            array (
                'id_user' => 15,
                'namalengkap' => 'Daffi Alfahrizi',
                'username' => '242510010',
                'password' => '$2y$12$Kpi1ijfmiTgrkQEnj.Eh7eo2wLPNZoD0ZDheWTtcaw2lNkCJ/rhyq',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:55',
                'updated_at' => '2026-02-13 19:00:55',
            ),
            13 => 
            array (
                'id_user' => 16,
                'namalengkap' => 'Daviero Ibnu Basid',
                'username' => '242510011',
                'password' => '$2y$12$bw4XNHX.qMcw8ayisbdRuus8QTNFySiUsLKEd3B7pQr5gUzyX4/rG',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:55',
                'updated_at' => '2026-02-13 19:00:55',
            ),
            14 => 
            array (
                'id_user' => 17,
                'namalengkap' => 'Difa Novita Sari',
                'username' => '242510012',
                'password' => '$2y$12$jlv9ogpfPjer/aE2gXQ4seZBrK2GkQCbVUIr1NeVCdS3ZNPx0zrou',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:55',
                'updated_at' => '2026-02-13 19:00:55',
            ),
            15 => 
            array (
                'id_user' => 18,
                'namalengkap' => 'Dini Aprilia',
                'username' => '242510013',
                'password' => '$2y$12$qN7mgOKhlRmrCvNVk1SYJON9gNsgvZCl0Sb04S2yLclTtGHQ3yJVu',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:56',
                'updated_at' => '2026-02-13 19:00:56',
            ),
            16 => 
            array (
                'id_user' => 19,
                'namalengkap' => 'Dini Septia Ramadhani',
                'username' => '242510014',
                'password' => '$2y$12$0L.Y/BDtSPH01a1TKm40beumn9rjQE2wBv.ZzBakvyV/AETKkeDvy',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:56',
                'updated_at' => '2026-02-13 19:00:56',
            ),
            17 => 
            array (
                'id_user' => 20,
                'namalengkap' => 'Ghifari Gheria Saputra',
                'username' => '242510015',
                'password' => '$2y$12$fgYln6TwyFklfvWYp/.iaeKw3UQ3NtsWSw1dQWtWscKMUSN6XWQz2',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:56',
                'updated_at' => '2026-02-13 19:00:56',
            ),
            18 => 
            array (
                'id_user' => 21,
                'namalengkap' => 'Keisya Rahma Nurfadilah',
                'username' => '242510016',
                'password' => '$2y$12$Qrrnx5uchGKfNujDN5LTUeoRJjwrgGgxdtInTjU71FGTrMZ3g.cfW',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:56',
                'updated_at' => '2026-02-13 19:00:56',
            ),
            19 => 
            array (
                'id_user' => 22,
                'namalengkap' => 'Keyzha As Shiffa',
                'username' => '242510017',
                'password' => '$2y$12$/LoA6o37VkH7a2dBoMAMKufPNKLA9e7IujpZLgAZPftNVuqLs1Nc2',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:57',
                'updated_at' => '2026-02-13 19:00:57',
            ),
            20 => 
            array (
                'id_user' => 23,
                'namalengkap' => 'Laura Lidya Pratama',
                'username' => '242510018',
                'password' => '$2y$12$dtJY8vg41TaPuOaeUVNLD.kit6ENTqMZyLitVS25d41L8WgLlMKMi',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:57',
                'updated_at' => '2026-02-13 19:00:57',
            ),
            21 => 
            array (
                'id_user' => 24,
                'namalengkap' => 'Meisya Talaita Putri',
                'username' => '242510019',
                'password' => '$2y$12$NzFYv430idPRi6T5cbF6XOr4Lg6suI.DcpAPan3FGxaHIoXKn4hxm',
                'usertype' => 'siswa',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-13 19:00:57',
                'updated_at' => '2026-02-13 19:00:57',
            ),
        ));
        
        
    }
}