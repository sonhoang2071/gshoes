@extends('shoes.app')

@section('main-content')
    <div class="products-card app-card">
        <div class="top-card">
            <img src="{{asset('assets/nike.png')}}" alt="" class="logo-top-card">
        </div>
        <div class="title-card">
            Our Products
        </div>
        <div class="body-card">
            <div>
                @if(!empty($list))
                    @foreach($list as $item)
                        <div class="item">
                            <div class="image-item" style="background-color: {{$item->color}}">
                                <img src="{{$item->image}}" alt="">
                            </div>
                            <div class="name-item">
                                {{$item->name}}
                            </div>
                            <div class="description-item">
                                {{$item->description}}
                            </div>
                            <div class="bottom-item">
                                <div class="price-item">
                                    ${{$item->price}}
                                </div>
                                <div id="add-item-{{$item->id}}">
                                    @if(empty(Session::get("Cart")->shoes[$item->id]))
                                        <div class="add-item" onclick="addToCart({{$item->id}})" >
                                            <p>ADD TO CART</p>
                                        </div>
                                    @else
                                        <div class="add-inactive add-item">
                                            <div class="add-inactive-cover">
                                                <div class="add-inactive-icon">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="cart-card app-card">
        <div class="top-card">
            <img src="{{asset('assets/nike.png')}}" alt="" class="logo-top-card">
        </div>
        <div class="title-card">
            Your cart
            <span id="price-cart">${{!empty(Session::has("Cart")) ? Session::get("Cart")->price : '0.00'}}</span>
        </div>
        <div class="body-card" id="cart-content">
                @if(!empty(Session::has("Cart")))
                        @foreach(Session::get("Cart")->shoes as $item)
                            <div class="cart-item" id="{{$item['info']["id"]}}">
                                <div class="cart-item-left">
                                    <div class="image-cart-item" style="background-color: {{$item["info"]["color"]}}">
                                        <div>
                                            <img src="{{$item["info"]["image"]}}" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-item-right">
                                    <div class="name-cart-item">
                                        {{$item["info"]["name"]}}
                                    </div>
                                    <div class="price-cart-item">
                                        ${{$item["info"]["price"]}}
                                    </div>
                                    <div class="action-cart-item">
                                        <div class="count-cart-item">
                                            <div class="btn-count-cart-item" onclick="decreaseItem({{$item['info']["id"]}})">-</div>
                                            <div class="amount-count-cart-item" id="item-cart-{{$item['info']["id"]}}">{{$item["amount"]}}</div>
                                            <div class="btn-count-cart-item" onclick="increaseItem({{$item['info']["id"]}})">+</div>
                                        </div>
                                        <div class="remove-cart-item" onclick="deleteItem({{$item['info']["id"]}})">
                                            <img src="{{asset('assets/trash.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                @else
                    <div id="empty-cart">
                        <p class="text-empty-cart">
                            Your cart is empty.
                        </p>
                    </div>
                @endif
        </div>
    </div>
    <script>
        let storedData = localStorage.getItem('cart_data');
        let data = JSON.parse(storedData);

        if(data) {

            document.addEventListener("DOMContentLoaded", function() {
                 showCart(data);
            });
            // let price = 0;
            // for(let key in data) {
            //     price += data[key].price;
            // }
            // console.log(price);
        }
        function showCart(data){
            $.ajax({
                url:'showCart',
                type:'GET',
                data:{cart: data},
            }).done(function(response){
                if($('#empty-cart').length) {
                    $('#cart-content').html('');
                }
                for(let key in response.data) {
                    let newItem = `
                         <div class="cart-item" id="${response.data[key].info.id}">
                                <div class="cart-item-left">
                                    <div class="image-cart-item" style="background-color: ${response.data[key].info.color}">
                                        <div>
                                            <img src="${response.data[key].info.image}" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-item-right">
                                    <div class="name-cart-item">
                                       ${response.data[key].info.name}
                    </div>
                    <div class="price-cart-item">
                        $ ${response.data[key].info.price}
                    </div>
                    <div class="action-cart-item">
                        <div class="count-cart-item">
                            <div class="btn-count-cart-item" onclick="decreaseItem(${response.data[key].info.id})">-</div>
                            <div class="amount-count-cart-item" id="item-cart-${response.data[key].info.id}">${response.data[key].amount}</div>
                                            <div class="btn-count-cart-item" onclick="increaseItem(${response.data[key].info.id})">+</div>
                                        </div>
                                        <div class="remove-cart-item" onclick="deleteItem(${response.data[key].info.id})">
                                            <img src="{{asset('assets/trash.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    `;

                    $('#cart-content').append(newItem);
                }
                $("#price-cart").text(`${response.price}`);
            });
        }
        function renderData(res, id = null) {
            localStorage.setItem('cart_data', JSON.stringify(res.data));
            if(id == null) {
                let newItem = `
                     <div class="cart-item" id="${res.shoes.id}">
                            <div class="cart-item-left">
                                <div class="image-cart-item" style="background-color: ${res.shoes.color}">
                                    <div>
                                        <img src="${res.shoes.image}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="cart-item-right">
                                <div class="name-cart-item">
                                    ${res.shoes.name}
                </div>
                <div class="price-cart-item">
                    $${res.shoes.price}
                </div>
                <div class="action-cart-item">
                    <div class="count-cart-item">
                        <div class="btn-count-cart-item" onclick="decreaseItem(${res.shoes.id})">-</div>
                        <div class="amount-count-cart-item" id="item-cart-${res.shoes.id}">1</div>
                                        <div class="btn-count-cart-item" onclick="increaseItem(${res.shoes.id})">+</div>
                                    </div>
                                    <div class="remove-cart-item" onclick="deleteItem(${res.shoes.id})">
                                        <img src="{{asset('assets/trash.png')}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                `;
                if($('#empty-cart').length) {
                    $('#cart-content').html('');
                }
                $('#cart-content').append(newItem);
            }
            if(res.price) {
                $("#price-cart").text('$' + `${res.price}`);
            }
            else
            {
                $("#price-cart").text('$0.00');
            }
        }
        function addToCart(id){
            $.ajax({
                url:'add/'+id,
                type:'GET',
            }).done(function(response){
                renderData(response);
                let $change = $(`#add-item-${response.shoes.id}`);
                let newBtn = `
                    <div class="add-inactive add-item">
                        <div class="add-inactive-cover">
                            <div class="add-inactive-icon">
                            </div>
                        </div>
                    </div>
                `;
                $change.html(newBtn);

            });
        }
        function increaseItem(id) {
            let $n = $("#item-cart-"+id);
            let value = parseInt($n.text());
            $n.text(`${++value}`);
            $.ajax({
                url:'update/'+id + '/' + value,
                type:'GET',
            }).done(function(response){
                renderData(response,id);
            });
        }
        function decreaseItem(id) {
            let $n = $("#item-cart-"+id);
            let value = parseInt($n.text());
            $n.text(`${--value}`);
            $.ajax({
                url:'update/'+id + '/' + value,
                type:'GET',
            }).done(function(response){
                renderData(response,id);
                if(value == 0) {
                    $(`#cart-content #${id}`).remove();
                    let $change = $(`#add-item-${id}`);
                    let newBtn = `
                        <div class="add-item" onclick="addToCart(${id})" >
                            <p>ADD TO CART</p>
                        </div>
                    `;
                    $change.html(newBtn);
                }
                if($("#price-cart").text() == '$0.00') {
                    let emptyHtml = `<div id="empty-cart">
                        <p class="text-empty-cart">
                            Your cart is empty.
                        </p>
                    </div>`;
                    $('#cart-content').html(emptyHtml);
                }
            });
        }
        function deleteItem(id) {
            $.ajax({
                url:'delete/'+id,
                type:'GET',
            }).done(function(response){
                renderData(response,id);
                $(`#cart-content #${id}`).remove();
                let $change = $(`#add-item-${id}`);
                let newBtn = `
                    <div class="add-item" onclick="addToCart(${id})" >
                       <p>ADD TO CART</p>
                    </div>
                `;
                $change.html(newBtn);
                if($("#price-cart").text() == '$0.00') {
                    let emptyHtml = `<div id="empty-cart">
                        <p class="text-empty-cart">
                            Your cart is empty.
                        </p>
                    </div>`;
                    $('#cart-content').html(emptyHtml);
                }
            });
        }
    </script>
@endsection

