<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Post;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
           $newPost = new Post();
           $newPost->title = $faker->sentence();
           $newPost->content = $faker->text(500);
           $slug = Str::slug($newPost->title);
           $slugBase = $slug;
           $currentPost = Post::where('slug', $slug)->first();
           $cont = 1;
           while($currentPost) {
               $slug = $slugBase . '-' . $cont;
               $cont++;
               $currentPost = Post::where('slug', $slug)->first();
           }
           $newPost->slug = $slug;
           $newPost->save();
       }
   }
}
