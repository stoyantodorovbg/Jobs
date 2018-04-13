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
            DB::table('role_user')->insert([
                'role_id' => 1,
                'user_id' => $user->id,
            ]);
        }

        $moderator = new User();
        $moderator->name = 'Moderator';
        $moderator->email = 'moderator@example.com';
        $moderator->password = bcrypt('secret');
        $moderator->setRememberToken(str_random(10));
        $moderator->save();

        DB::table('role_user')->insert([
            'role_id' => 2,
            'user_id' => $moderator->id,
        ]);

        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@example.com';
        $admin->password = bcrypt('secret');
        $admin->setRememberToken(str_random(10));
        $admin->save();

        DB::table('role_user')->insert([
            'role_id' => 3,
            'user_id' => $admin->id,
        ]);

    }
}
