<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Cart;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //definir la relación entre Usuario y Carrito de compras
    public function carts() {
        return $this->hasMany(Cart::class);
    }

    //devuelve el carrito activo que tenga el usuario y si no tiene crea uno
    public function getCartAttribute() {
        $cart = $this->carts()->where('status', 'Active')->first();
        if ($cart) {
            return $cart;
        }
        // si no hay un carrito se crea
        $cart = new Cart();
        $cart->status = 'Active';
        $cart->user_id = $this->id;
        $cart->save();

        return $cart;
    }
}
