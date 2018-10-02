<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CartDetail;

class CartDetailController extends Controller
{
    public function store(Request $request) {
    	$cartDetail = new CartDetail();
    	$cartDetail->cart_id = auth()->user()->cart->id; //el usuario puede tener un solo carrito activo a la vez
    	$cartDetail->product_id = $request->product_id;
    	$cartDetail->quantity = $request->quantity;
    	$cartDetail->save();

    	return back();
    }

    public function destroy(Request $request) {
    	$cartDetail = CartDetail::find($request->cart_detail_id);
    	$cartDetail->delete();

    	return back();
    }
}
