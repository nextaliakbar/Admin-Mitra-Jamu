<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
            sku
            name
            slug
            description
            tags
            price
            stock
            weight
            thumbnail
            dimension
            discount
            status
            is_active
            is_selected
            is_preorder
            preorder_duration
            shipment
            payment
        */

        Product::factory()->count(100)->create();
    }
}
