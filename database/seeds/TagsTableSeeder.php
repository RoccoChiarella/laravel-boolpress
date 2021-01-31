<?php

use Illuminate\Database\Seeder;
use App\Tag;
use Faker\Generator as Faker;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 5; $i++) {

            $newTag = new Tag();
            $newTag->name = $faker->words(3, true);
            $slug = Str::slug($newTag->name);
            $slugBase = $slug;
            $currentTag = Tag::where('slug', $slug)->first();
            $cont = 1;
            while($currentTag) {
                $slug = $slugBase . '-' . $cont;
                $cont++;
                $currentTag = Tag::where('slug', $slug)->first();
            }
            $newTag->slug = $slug;
            $newTag->save();
        }
    }
}
