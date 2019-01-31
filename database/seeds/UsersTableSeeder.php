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
                'login_id' => 'admin',
                'fixed_nickname' => 'admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('qweqwe')
            ]);
        }
        factory(App\User::class, 10)->create(['fixed_nickname'=>null]);
        factory(App\User::class, 10)->create(['unfixed_nickname'=>null]);

    }
}
