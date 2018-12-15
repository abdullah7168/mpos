<ul class="product--list" id="products__list--js">
    @foreach ($products as $product)
        <li><a href="#" onclick="select(event)" 
            data-productid="{{$product->id}}" 
            data-productname="{{$product->name}}"
            data-quantity="{{$product->quantity}}"
            data-sale_price="{{$product->sale_price}}"
            >
            {{$product->name}}
            </a>
        </li>
    @endforeach
</ul>