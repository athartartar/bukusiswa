<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            SiswasTableSeeder::class,
            PlotWalasTableSeeder::class,
            PelanggaransTableSeeder::class,
            KelasTableSeeder::class,
            GurusTableSeeder::class,
        ]);
        $this->call(SiswasTableSeeder::class);
        $this->call(PelanggaransTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PlotWalasTableSeeder::class);
        $this->call(KelasTableSeeder::class);
        $this->call(GurusTableSeeder::class);
    }
}
