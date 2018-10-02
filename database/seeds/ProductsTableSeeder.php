<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Category;
use App\ProductImage;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // model factories
        /* Las siguientes 3 líneas crean 5 categorías, 100 productos y 200 imagenes
        pero no hay relaciones entre ellas

        factory(Category::class, 5)->create();
        factory(Product::class, 100)->create();
        factory(ProductImage::class, 200)->create();*/

        /* ahora con esto vamos a crear objetos relacionados, tantos productos por categoria,
        tantas imagenes por producto, etc.
        */
        $categories = factory(Category::class, 3)->create();
        $categories->each(function ($category) {
            $products = factory(Product::class, 11)->make();
            $category->products()->saveMany($products);
            $products->each(function($p) {
                $images = factory(ProductImage::class, 2)->make();
                $p->images()->saveMany($images);

            });
        });
        
    }
}
