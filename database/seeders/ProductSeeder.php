<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // VendorFactoryクラスで定義した内容にもとづいてダミーデータを5つ生成し、vendorsテーブルに追加する
        Product::factory()->count(20)->create();
    }
}
