<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                "id" => 1,
                "name" => "admin",
                "pages" => "[{\"name\":\"todos\",\"url\":\"todos\"},{\"name\":\"users\",\"url\":\"users\"}]",
                "description" => "Administrator",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ],
            [
                "id" => 2,
                "name" => "editor",
                "pages" => "[{\"name\":\"todos\",\"url\":\"todos\"}]",
                "description" => "Editor",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ],
        ]);
    }
}
