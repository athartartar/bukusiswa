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
                'namalengkap' => 'Admin Sekolah',
                'username' => '0606',
                'password' => '$2y$12$x5LEVYLgs.wVEUfsDE5A1e.WfS.PJ3akRjX.Jo6MdFUr9oBpnFvKm',
                'usertype' => 'guru',
                'foto' => NULL,
                'status' => 'aktif',
                'remember_token' => NULL,
                'created_at' => '2026-02-05 04:43:56',
                'updated_at' => '2026-02-05 04:43:56',
            ),
        ));
        
        
    }
}