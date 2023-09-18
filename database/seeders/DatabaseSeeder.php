<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);

        \App\Models\User::factory(1)->create([
            'role_id' => 1,
            'username' => 'balotpenoy',
            'email' => 'admin@balot.penoy',
        ]);

        \App\Models\User::factory(15)->create([
            'role_id' => null
        ]);
    }
}
