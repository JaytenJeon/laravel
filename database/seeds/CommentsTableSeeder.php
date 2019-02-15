<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $posts = App\Post::all();
        $posts->each(function($post){
            $users = App\User::take(3)->get();
            foreach ($users as $user){
                $post->comments()->save(factory(App\Comment::class)->make()->authorable()->associate($user));
            }
        });
    }
}
