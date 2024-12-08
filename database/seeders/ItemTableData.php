<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ItemTableData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            [
              'name'=>'Veg Pizza',
              'description'=>'A Veg Pizza is a flavorful combination of a crispy crust, rich tomato sauce, and melted cheese, topped with a variety of fresh vegetables. Popular toppings include bell peppers, onions, mushrooms, olives, tomatoes, and sweet corn.',
              'category_id'=>1,
              'price' => 24,
              'image'=>'items/Bg404GFoHSncgtEHexPH6pPieXbeHwX0Zlb0epPU.png',
            ],

            [
                'name'=>'Chicken Pizza',
                'description'=>'A Veg Pizza is a flavorful combination of a crispy crust, rich tomato sauce, and melted cheese, topped with a variety of fresh vegetables. Popular toppings include bell peppers, onions, mushrooms, olives, tomatoes, and sweet corn.',
                'category_id'=>1,
                'price' => 30,
                'image'=>'items/MKWCAfbQXZqE9aXEWtQNLB4Xh7zxqooocNqf4KRS.jpg',
            ],

            [
                'name'=>'Coke Cola',
                'description'=>'A Veg Pizza is a flavorful combination of a crispy crust, rich tomato sauce, and melted cheese, topped with a variety of fresh vegetables. Popular toppings include bell peppers, onions, mushrooms, olives, tomatoes, and sweet corn.',
                'category_id'=>3,
                'price' => 20,
                'image'=>'items/MKWCAfbQXZqE9aXEWtQNLB4Xh7zxqooocNqf4KRS.jpg',
            ],

            [
                'name'=>'Mixure',
                'description'=>'A Veg Pizza is a flavorful combination of a crispy crust, rich tomato sauce, and melted cheese, topped with a variety of fresh vegetables. Popular toppings include bell peppers, onions, mushrooms, olives, tomatoes, and sweet corn.',
                'category_id'=>3,
                'price' => 24,
                'image'=>'items/MKWCAfbQXZqE9aXEWtQNLB4Xh7zxqooocNqf4KRS.jpg',
            ],

            [
                'name'=>'chicken B',
                'description'=>'A Veg Pizza is a flavorful combination of a crispy crust, rich tomato sauce, and melted cheese, topped with a variety of fresh vegetables. Popular toppings include bell peppers, onions, mushrooms, olives, tomatoes, and sweet corn.',
                'category_id'=>2,
                'price' => 40,
                'image'=>'items/MKWCAfbQXZqE9aXEWtQNLB4Xh7zxqooocNqf4KRS.jpg',
            ],

            [
                'name'=>'Veg B',
                'description'=>'A Veg Pizza is a flavorful combination of a crispy crust, rich tomato sauce, and melted cheese, topped with a variety of fresh vegetables. Popular toppings include bell peppers, onions, mushrooms, olives, tomatoes, and sweet corn.',
                'category_id'=>2,
                'price' => 50,
                'image'=>'items/MKWCAfbQXZqE9aXEWtQNLB4Xh7zxqooocNqf4KRS.jpg',
            ],
        ]);
    }
}
