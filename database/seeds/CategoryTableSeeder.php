<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->insert(
            [
                'title' => "Technology",
                'details' => "Technology Details",
                'visibility_status' => 'Visible',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        DB::table('categories')->insert(
            [
                'title' => "Politics",
                'details' => "Politics Details",
                'visibility_status' => 'Visible',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        DB::table('categories')->insert(
            [
                'title' => "Sports",
                'details' => "Sports Details",
                'visibility_status' => 'Visible',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
