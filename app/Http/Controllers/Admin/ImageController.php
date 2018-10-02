<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Product;
use App\ProductImage;
use File;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function index($id) {
    	$product = Product::find($id);
    	//$images = $product->images;
    	$images = $product->images()->orderBy('featured', 'desc')->get(); //ordenadas, primero la destacada
    	return view('admin.products.images.index')->with(compact('product', 'images'));
    }

    public function store(Request $request, $id) {
    	// 1) guardar la imagen en nuestro proyecto
    	$file = $request->file('photo');
    	$path = public_path() . '/images/products';
    	$fileName = uniqid() . $file->getClientOriginalName();
    	$moved = $file->move($path, $fileName);
    	
    	// 2) crear el registro en la tabla product_images
    	if ($moved) {
    		$productImage = new ProductImage();
	    	$productImage->image = $fileName;
	    	//$productImage->featured = false;
	    	$productImage->product_id = $id;
	    	$productImage->save();
    	}
    	return back();
    }

    public function destroy(Request $request) {
    	// 1) elimnar el archivo
    	$productImage = ProductImage::find($request->input('image_id')); //o $request->image_id
    	if (substr($productImage->image, 0, 4) !== "http") {
    		$fullPath = public_path() . '/images/products/' . $productImage->image;
    		$deleted = File::delete($fullPath);
    	} else {
    		$deleted = true;
    	}
    	// 2) si se elimino el archivo eliminamos el registro de la DB
    	if ($deleted) {
    		$productImage->delete();
    	}
    	return back();
    }

    public function featuredimage($product_id, $image_id) {
    	ProductImage::where('product_id', $product_id)->update([
    		'featured' => false
    	]);

    	$productImage = ProductImage::find($image_id);
    	$productImage->featured = true;
    	$productImage->save();

    	return back();
    }
}
