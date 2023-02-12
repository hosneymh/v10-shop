<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission =[
            'all_categories'=>'Show All Categories',
            'add_category'=>'Add New Category',
            'edit_category'=>'Edit Category',
            'delete_category'=>'Delete Category',
            'all_products'=>'Show All Products',
            'add_product'=>'Add New product',
            'edit_product'=>'Edit product',
            'delete_product'=>'Delete product',
        ];
        Permission::truncate();
        foreach($permission as $code => $name){
            Permission::create([
                'code'=> $code,
                'name'=> $name
            ]);
        }
    }
}
