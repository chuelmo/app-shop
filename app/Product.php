<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category() {
    	return $this->belongsTo(Category::class);
    }

    public function images() {
    	return $this->hasMany(ProductImage::class);
    }

    //el atributo se llama featured_image_url por lo tanto el nombre
    //del accesor (la función que escribo debajo es:)
    public function getFeaturedImageUrlAttribute() {
    	$featuredImage = $this->images()->where('featured', true)->first(); //cargo la primer imagen destacada
    	if (!$featuredImage) { //si no tiene imagen destacada
    		$featuredImage = $this->images()->first(); //cargo la primer imagen entonces
    	}
    	if ($featuredImage) { //si encontre una imagen
    		return $featuredImage->url; //devuelvo su url
    	}

    	// el producto no tiene imagen si llegué hasta acá
    	return 'images/products/default.jpg';
    }
}
