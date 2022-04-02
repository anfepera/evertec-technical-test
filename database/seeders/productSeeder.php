<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class productSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'product_name' => "Computer Asus",
            'price' => 4500000
        ]);
        DB::table('products')->insert([
            'product_name' => "Printer EPSON ",
            'price' => 2100000
        ]);
        DB::table('products')->insert([
            'product_name' => "Play Station 5",
            'price' => 3600000
        ]);
        DB::table('products')->insert([
            'product_name' => "Hard Disk Crudcial SDD 500gb",
            'price' => 600000
        ]);
    }
}
