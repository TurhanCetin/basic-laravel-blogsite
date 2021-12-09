<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0;$i<4;$i++){
        $faker=\Faker\Factory::create();
        DB::table('blogs')->insert([
            'categoryid'=>rand(1,4),
            'image'=>$faker->imageUrl(420,340,'technology',true),
            'title'=>$faker->sentence(6),
            'subtitle'=>$faker->sentence(10),
            'description'=>$faker->paragraph,
            'slug'=>str_slug($faker->sentence),
            'updated_at'=>now(),
            'created_at'=>$faker->dateTime($max = 'now')
        ]);
    }

    }
}
