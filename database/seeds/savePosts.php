<?php

use Illuminate\Database\Seeder;

class savePosts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\savePost::class, 10)->create();
    }
}
