<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /* DB::table('posts')->insert([
            'title' => 'Primeira Postagem',
            'description' => 'Postagem Teste com Seeds',
            'content' => 'Conteúdo da Postagem',
            'is_active' => 1,
            'slug' => 'primeira postagem',
            'user_id' => 1
        ]); */

        factory(\App\Post::class, 30)->create();
    }
}
