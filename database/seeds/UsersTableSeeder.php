<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if(App\User::count() == 0){
            App\User::create([
                'login_id' => str_random(5),
                'name' => 'guest',
                'email' => 'guest@example.com',
                'password' => bcrypt(str_random(10))
            ]);

            App\User::create([
                'login_id' => 'admin',
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('qweqwe')
            ]);
        }
        factory(App\User::class, 10)->create();

    }
}
