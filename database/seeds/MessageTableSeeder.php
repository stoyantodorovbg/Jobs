<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages = factory('App\Http\Models\Message', 5)->create();

        for ($i = 1; $i < count($messages); $i += 2) {
            DB::table('message_user')->insert([
                'message_id' => $messages[$i]->id,
                'user_id' => $i,
                'is_sent' => 1,
            ]);
            DB::table('message_user')->insert([
                'message_id' => $messages[$i]->id,
                'user_id' => $i + 1,
                'is_received' => 1,
            ]);
        }
    }
}
