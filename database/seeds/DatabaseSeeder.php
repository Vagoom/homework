<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        DB::table('documents')->insert([
            'title' => Str::random(10),
            'file_path' => __DIR__ . '/sampledoc.pdf',
            'file_url' => 'uploads/sampledoc.pdf'
        ]);
    }
}
