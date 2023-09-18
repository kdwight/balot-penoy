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
        \App\Models\Role::insert([
            [
                "id" => 1,
                "name" => "admin",
                "modules" => "[{\"name\":\"todos\",\"url\":\"todos\"},{\"name\":\"editor\",\"url\":\"editor\"}]",
                "description" => "Administrator",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ],
            [
                "id" => 2,
                "name" => "editor",
                "modules" => "[{\"name\":\"todos\",\"url\":\"todos\"},{\"name\":\"editor\",\"url\":\"editor\"}]",
                "description" => "Editor",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ],
            [
                "id" => 3,
                "name" => "viewer",
                "modules" => "[{\"name\":\"todos\",\"url\":\"todos\"},{\"name\":\"viewer\",\"url\":\"viewer\"}]",
                "description" => "Viewer",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ]
        ]);

        \App\Models\User::factory(1)->create([
            'role_id' => 1,
            'username' => 'balotpenoy',
            'email' => 'admin@balot.penoy',
        ]);
    }
}
