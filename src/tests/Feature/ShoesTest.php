<?php

namespace Tests\Feature;

use App\Http\Controllers\ShoesController;
use App\Models\Shoes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ShoesTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_add_to_cart(): void
    {
        $shoesController = new ShoesController();
        $idTest = 1;
        $expected = $shoesController->addToCart($idTest)->original;
        $actual = Shoes::find(1);
        $this->assertEquals($expected["price"], $actual->price);
        $this->assertEquals($expected["shoes"], $actual);
        $this->assertEquals($expected["data"], Session::get('Cart')->shoes);
    }
    public function test_update_item_cart():void
    {
        $this->assertTrue(true);
    }
    public function test_delete_item_cart():void
    {
        $this->assertTrue(true);
    }
}
