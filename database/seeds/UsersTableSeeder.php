<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'staff1',
            'password' => Hash::make('pws01'), // Password untuk staff
            'name' => 'Staff Satu',
            'jabatan' => 'Koordinator Inventaris',
            'role' => 'staff',
            'email' => 'stepani.apu@si.ukdw.ac.id',
        ]);

        User::create([
            'username' => 'kaunit1',
            'password' => Hash::make('pwk01'), // Password untuk kepala unit
            'name' => 'Kepala Unit',
            'jabatan' => 'Kepala Unit',
            'role' => 'kaunit',
            'email' => '72210511@students.ukdw.ac.id',
        ]);

        User::create([
            'username' => 'staff2',
            'password' => Hash::make('pws02'), // Password untuk staff
            'name' => 'Staff Dua',
            'jabatan' => 'Staff Inventaris',
            'role' => 'staff',
            'email' => 'stepaniapu@gmail.com',
        ]);

        // Anda bisa menambahkan lebih banyak akun di sini jika perlu
    }
}