<?php

use App\User;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'first_name' => 'Gabriel',
            'last_name' => 'Moreno',
            'email' => 'gabriel@attila.com',
            'username' => 'gabrielattila',
            'role' => 'admin',
        ]);
    }
}
