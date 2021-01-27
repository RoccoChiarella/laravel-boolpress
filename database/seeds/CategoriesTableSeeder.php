<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 5; $i++) {

            $newCategory = new Category();
            $newCategory->name = $faker->words(3, true);
            $slug = Str::slug($newCategory->name);
            $slugBase = $slug;
            $currentCategory = Category::where('slug', $slug)->first();
            $cont = 1;
            while($currentCategory) {
                $slug = $slugBase . '-' . $cont;
                $cont++;
                $currentCategory = Category::where('slug', $slug)->first();
            }
            $newCategory->slug = $slug;
            $newCategory->save();
        }
    }
}
