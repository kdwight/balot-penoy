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

        $user = \App\Models\User::factory()->create([
            'role_id' => 1,
            'username' => 'balotpenoy',
            'email' => 'admin@balot.penoy',
        ]);

        $todo = $user->todos()->create([
            'title' => 'Admin first task',
        ]);

        /* collect(['foo', 'bar', 'baz'])->each(function ($title) use ($todo) {
            $todo->items()->create([
                'title' => $title
            ]);
        }); */

        $todo->items()->createMany([
            ['title' => 'foo', 'completed' => NOW()],
            ['title' => 'bar', 'target_date' => "2024-01-01"],
            ['title' => 'baz'],
        ]);

        \App\Models\User::factory(5)->create([
            'role_id' => null
        ]);
    }
}
