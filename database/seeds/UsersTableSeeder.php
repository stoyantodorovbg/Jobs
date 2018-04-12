<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory('App\User', 5)->create();

        foreach ($users as $user) {
            $user->roles()->create(['name' => 'user']);
        }

        $moderator = new User();
        $moderator->name = 'Moderator';
        $moderator->email = 'moderator@example.com';
        $moderator->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; // secret
        $moderator->setRememberToken(str_random(10));
        $moderator->save();
        $moderator->roles()->create(['name' => 'moderator']);

        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@example.com';
        $admin->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; // secret
        $admin->setRememberToken(str_random(10));
        $admin->save();
        $admin->roles()->create(['name' => 'moderator']);
    }
}
