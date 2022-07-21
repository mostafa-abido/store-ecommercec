<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeders;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Admin::create([
           'name' => 'mostafa abido',
           'email' => 'mostafaabido@gmail.com',
           'password' => bcrypt('12345678'),
       ]);
    }
}
