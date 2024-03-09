<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    public $shoes = null;
    public $price = 0;
    public $amount = 0;
    public function __construct($cart = null)
    {
        if($cart) {
            $this->shoes = $cart->shoes;
            $this->price = $cart->price;
            $this->amount = $cart->amount;
        }
    }
    public function add($shoes, $id){
        $newShoes = ['amount' => 0,'price' => $shoes->price, 'info' => $shoes];
        if($this->$shoes){
            if(array_key_exists($id, $this->$shoes)) {
                $newShoes = $this->$shoes[$id];
            }
        }
        $newShoes['amount']++;
        $newShoes['price'] = $newShoes['amount'] * $shoes->price;
        $this->shoes[$id] = $newShoes;
        $this->price += $shoes->price;
        $this->amount++;
    }
    public function updateCart($amount, $id) {
        if($amount == 0) {
            $this->deleteItemCart($id);
        } else {
            $this->amount -= $this->shoes[$id]['amount'];
            $this->price -= $this->shoes[$id]['price'];
            $this->shoes[$id]['amount'] = $amount;
            $this->shoes[$id]['price'] = $amount * $this->shoes[$id]['info']->price;
            $this->amount += $this->shoes[$id]['amount'];
            $this->price += $this->shoes[$id]['price'];
        }
    }
    public function deleteItemCart($id){
        $this->price -= $this->shoes[$id]['price'];
        $this->amount -= $this->shoes[$id]['amount'];
        unset($this->shoes[$id]);
    }
}
