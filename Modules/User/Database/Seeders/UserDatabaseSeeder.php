<?php

namespace Modules\User\Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Dokter\Entities\Dokter;
use Modules\Pasien\Entities\Pasien;

class UserDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            GenderTableSeeder::class,
            AgamaTableSeeder::class,
            PerkawinanTableSeeder::class,
        ]);

        $user = User::create([
            "name" => "Admin Super",
            "email" => "brsud.waled@gmail.com",
            "username" => "adminrs",
            'password' => bcrypt('qweqwe'),
            'email_verified_at' => Carbon::now()
        ]);
        $user->assignRole('Admin');

        $user = User::create([
            "name" => "Admin Pelayanana Medis",
            "username" => "adminyanmed",
            'password' => bcrypt('qweqwe'),
            'email_verified_at' => Carbon::now()
        ]);
        $user->assignRole('Pelayanan Medis');

        // User::factory(5)->create()->each(function ($item) {
        //     Dokter::create([
        //         'user_id' => $item->id,
        //         'kode' => 'DOK2021' . $item->id,
        //         'status' => 1,
        //         'spesialis' => 'Anak',
        //         'sip'=>'20.822/IP/IDIKabCrb/X/2021',
        //     ]);
        //     $item->assignRole('Dokter');
        // });
        // User::factory(5)->create()->each(function ($item) {
        //     $item->assignRole('Kasir');
        // });
        User::factory(10)->create()->each(function ($item) {
            $item->assignRole('Keuangan');
        });
        // User::factory(5)->create()->each(function ($item) {
        //     $item->assignRole('Pengawas');
        // });
        // User::factory(5)->create()->each(function ($item) {
        //     Pasien::create([
        //         'user_id' => $item->id,
        //         'kode' => '2021' . $item->id,
        //     ]);
        //     $item->assignRole('Pasien');
        // });
    }
}
