<?php

use App\Blog_category;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            ['name' => 'Html'],
            ['name' => 'Laravel'],
            ['name' => 'Java'],
            ['name' => 'Android'],
            ['name' => 'PHP'],
        ];

        for ($i=0; $i < 5; $i++) {
            Blog_category::create([
                'name' => $category[$i]['name']
            ]);
        }
    }
}
