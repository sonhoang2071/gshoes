<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Shoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShoesController extends Controller
{
    //

    public function index()
    {
        $list = Shoes::all();
        return view('shoes.index', compact('list'));
    }
    public function addToCart( $id)
    {
        $shoes = Shoes::find($id);
        if($shoes != null) {
            $oldCart = Session::get('Cart') ? Session::get('Cart') : null;
            $newCart = new Cart($oldCart);
            $newCart->add($shoes, $id);
            Session::put('Cart', $newCart);
        }
        $res = Session::get('Cart');
        return response([
            "shoes" => $shoes,
            "price" => round($res->price, 2),
            "data" => $res->shoes,
        ]);
    }
    public function updateItemCart(Request $req, $id, $amount)
    {
        $oldCart = Session::get('Cart') ? Session::get('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->updateCart($amount, $id);
        if(count($newCart->shoes) > 0)
        {
            $req->session()->put('Cart',$newCart);
            $res = Session::get('Cart');
            return  response([
                "price" => round($res->price, 2),
                "data" => $res->shoes,
            ]);
        } else {
            Session::forget('Cart');
            return  response([
                "price" => 0.00,
                "data" => null,
            ]);
        }
    }
    public function deleteItemCart(Request $req, $id)
    {
        $oldCart = Session::get('Cart') ? Session::get('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->deleteItemCart($id);
        if(count($newCart->shoes) > 0) {
            $req->session()->put('Cart',$newCart);
            $res = Session::get('Cart');
            return  response([
                "price" => round($res->price, 2),
                "data" => $res->shoes,
            ]);
        } else {
            Session::forget('Cart');
            return  response([
                "price" => 0.00,
                "data" => null,
            ]);
        }
    }
    public function showCart(Request $req) {
        if(empty(Session::has('Cart'))) {
            $newCart = new Cart();
            foreach($req->cart as $key => $value) {
                $newCart->shoes[$key] = $value;
                $newCart->amount += $value["amount"];
                $newCart->price += $value["price"];
            }
            $req->session()->put('Cart',$newCart);
            return  response([
                "price" => round($newCart->price,2),
                "data" =>$newCart->shoes,
            ]);
        }

    }
}
