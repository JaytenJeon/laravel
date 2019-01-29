<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = App\User::all();

        $users->each(function ($user){
            $posts = factory(App\Post::class, 5)->make();
            foreach ($posts as $post){
                $user->posts()->save(
                    $post
                );
            }

        });
    }
}
