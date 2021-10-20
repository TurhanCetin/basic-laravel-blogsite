<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Bilgisayar', 'Yazılım', 'Giyim', 'Eğlence','Teknoloji','AR-GE','Günlük Hayat','Magazin'];

        $faker=\Faker\Factory::create();
        foreach ($categories as $cat) {
            DB::table('categories')->insert([
                'name' => $cat,
                'slug' => str_slug($cat),
                'image'=>$faker->imageUrl(420,340,'cats',true,'Konu Resmi'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
