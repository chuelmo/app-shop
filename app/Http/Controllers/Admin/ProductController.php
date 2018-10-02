<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index() {
    	$products = Product::paginate(10);
    	return view('admin.products.index')->with(compact('products'));

    }

    public function create() {
    	return view('admin.products.create');

    }

    public function store(Request $request) {
    	//validar los datos que llegan
    	$messages = [
    		'name.required' => 'El nombre es obligatorio',
    		'name.min' => 'El nombre debe tener al menos 3 caracteres',
    		'description.required' => 'La descripción es obligatoria',
    		'description.max' => 'La descripción no puede exceder los 200 caracteres',
    		'price.required' => 'El precio es obligatorio',
    		'price.min' => 'No se admiten valores negativos',
    		'price.numeric' => 'Ingrese un precio válido'
    	];
    	$rules = [
    		'name' => 'required|min:3',
    		'description' => 'required|max:200',
    		'price' => 'required|numeric|min:0'
    	];
    	$this->validate($request, $rules, $messages);


    	//registrar el nuevo producto en la DB
    	// dd($request->all()); //imprime en pantalla los valores del formulario
    	$product = new Product();
    	$product->name = $request->input('name');
    	$product->description = $request->input('description');
    	$product->price = $request->input('price');
    	$product->long_description = $request->input('long_description');

    	$product->save();

    	return redirect('/admin/products');

    }

    public function edit($id) {
    	$product = Product::find($id);
    	return view('admin.products.edit')->with(compact('product'));

    }

    public function update(Request $request, $id) {
    	$messages = [
    		'name.required' => 'El nombre es obligatorio',
    		'name.min' => 'El nombre debe tener al menos 3 caracteres',
    		'description.required' => 'La descripción es obligatoria',
    		'description.max' => 'La descripción no puede exceder los 200 caracteres',
    		'price.required' => 'El precio es obligatorio',
    		'price.min' => 'No se admiten valores negativos',
    		'price.numeric' => 'Ingrese un precio válido'
    	];
    	$rules = [
    		'name' => 'required|min:3',
    		'description' => 'required|max:200',
    		'price' => 'required|numeric|min:0'
    	];
    	$this->validate($request, $rules, $messages);



    	$product = Product::find($id);
    	$product->name = $request->input('name');
    	$product->description = $request->input('description');
    	$product->price = $request->input('price');
    	$product->long_description = $request->input('long_description');

    	$product->save(); //update

    	return redirect('/admin/products');

    }

    public function destroy($id) {
    	$product = Product::find($id);
    	$product->delete(); //borrar el producto

    	return back();

    }
}
