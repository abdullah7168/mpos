@extends('dashboard.layout.master')
@push('styles')
    <style>
        .product--list{
            background: #FFF;
            position: absolute;
            z-index: 999;
            width: 100%;
            padding-left: 0;
            list-style: none;
            box-shadow: 0px 1px 1px rgba(0,0,0,0.3);
        }
        .product--list li{
            padding: 8px 10px;
            border-bottom: 1px solid #DEDEDE;
            transition-delay: 1ms ease-in-out;
        }
        .product--list li:hover{
            background:#DEDEDE;
        }
        .product--list li a {
            color:#333;
            display: block;
        }
        .td__cross--btn{
            padding:5px;
            color:red;
        }
        .td__cross--btn i{
            pointer-events: none;
        }
    </style>
@endpush
@section('content')
@if(Session::has('message'))
<div style="padding: 20px 30px; background: rgb(243, 156, 18); z-index: 999999; font-size: 16px; font-weight: 600;">
  {{-- <a class="float-right" href="#" data-toggle="tooltip" data-placement="left" title="Never show me this again!" style="color: rgb(255, 255, 255); font-size: 20px;">×</a> --}}
  <a href="#">{{Session::get('message')}}</a>
</div>
@endif

{{-- <section class="content-header">
    <h1>
      Home Page
      <small>it all starts here</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Examples</a></li>
      <li class="active">Blank page</li>
    </ol>
</section> --}}

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Place Order</h3>

        <div class="box-tools pull-right">
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <span id="input__container--js">
                            <input type="text" 
                            id="name--js" 
                            class="form-control"
                            autocomplete="off"
                            name="name" required>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="name">Quantity</label>
                        <input type="number" id="quantity--js" min="1" class="form-control" name="quantity" required>
                    </div>
                    <input type="hidden" name="product_id" id="product__id--js">
                    <div class="form-group">
                        <label for="name">Sale Price</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="number" id="product_sale_price-js" name="sale_price" class="form-control" required>
                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>
        
                    <div class="pull-right">
                        <a href="{{URL::previous()}}" class="btn btn-default btn-sm">Back</a>
                        <input type="button" id="add--js" class="btn btn-info btn-sm" value="Add">
                        <input type="button" id="checkout--js" class="btn btn-success btn-sm" value="Checkout">
                    </div>
                </div>
                <div class="col-sm-6">
                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th></th>
                        </thead>
                        <tbody id="table_row--js">
        
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <div class="pull-right">
                                        <span>Total <span id="total__products--js">0</span></span>
                                    </div>
                                </td>  
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('document').ready(function(){

            if(localStorage.getItem('order')){
                let order = JSON.parse(window.localStorage.getItem('order'));
                populateTable(order);
            }
        })
        
        var input = document.querySelector('#name--js');
        input.addEventListener('keyup',function(eve){
            if(eve.target.value != ''){
                const URL = '{{url("mpos/public/get-product-list")}}/?name='+eve.target.value;
                $.ajax({
                    'url':URL,
                    'method':'GET'
                }).done(function(data){
                    let container = document.querySelector('#input__container--js');

                    if(container.querySelector('#products__list--js'))
                        container.querySelector('#products__list--js').remove();
                    
                    container.insertAdjacentHTML('beforeend',data);

                    document.addEventListener('click',function(e){

                        if(e.target != eve.target)
                            if(container.querySelector('#products__list--js'))
                                container.querySelector('#products__list--js').remove();

                    })
                })
            }
                
        })
        
        function select(eve){
            const list_item = eve.target;

            var product_id = eve.target.getAttribute('data-productid');
            var product_name = eve.target.getAttribute('data-productname');
            var product_quantity = eve.target.getAttribute('data-quantity');
            var sale_price = eve.target.getAttribute('data-sale_price');

            document.querySelector('#name--js').value = product_name;
            document.querySelector('#quantity--js').setAttribute('max',product_quantity);
            document.querySelector('#product_sale_price-js').value = sale_price;
            document.querySelector('#product__id--js').value = product_id;
        }

        document.querySelector('#add--js').addEventListener('click',function(eve){

            
            let order = [];
            var product_name = document.querySelector('#name--js').value;
            var quantity = document.querySelector('#quantity--js').value;
            var sale_price = document.querySelector('#product_sale_price-js').value;
            var max = document.querySelector('#quantity--js').getAttribute('max');
            var product_id = document.querySelector('#product__id--js').value;
            
            document.querySelectorAll('input').value = '';
            if(window.localStorage.getItem('order')){
                order = JSON.parse(window.localStorage.getItem('order'));

                if(ifexists(product_id,order)){
                    if(!increaseQty(order,product_id,quantity,max)){
                        alert('specified quantity is bigger than the maximum quantity of the product we have');
                        return;
                    }
                } else {

                    order.push(
                            {
                            'id':product_id,
                            'name':product_name,
                            'quantity':quantity,
                            'sale_price':sale_price * quantity
                            }
                        )
                }


                window.localStorage.removeItem('order');
                window.localStorage.setItem('order',JSON.stringify(order));

            } else {
                let order = [];
                order.push(
                    {
                        'id':product_id,
                        'name':product_name,
                        'quantity':quantity,
                        'sale_price':sale_price * quantity
                    }
                )

                window.localStorage.setItem('order',JSON.stringify(order));
            }
            order = window.localStorage.getItem('order');
            populateTable(JSON.parse(order));

        })

        function populateTable(order){
            let tableHTML = '';
            let count = 0;
            let total = 0;
            for(let product of order){
                count++;
                tableHTML +=`
                    <tr>
                        <td>`+count+`</td>
                        <td>`+product.name+`</td>
                        <td>`+product.quantity+`</td>
                        <td>`+product.sale_price+`</td>
                        <td><a href="#" onclick="remove(event)" class="td__cross--btn" data-productid=`+product.id+` id="td__cross--js"><i class="fa fa-times"></i></a></td>
                    </tr>`;
                total = parseInt(total) + parseInt(product.sale_price);
            }  
            document.querySelector('#table_row--js').innerHTML = '';
            document.querySelector('#table_row--js').insertAdjacentHTML('beforeend',tableHTML);
            document.querySelector('#total__products--js').innerHTML = total;
        }

        const checkout = document.querySelector('#checkout--js').addEventListener('click',function(eve){

            if(!localStorage.getItem('order'))
                return;
            
            order = localStorage.getItem('order');

            $.ajax({
                'url':'{{url("/place-order")}}',
                'method':'POST',
                'data':{'order':order}
            }).done(function(data){
                if(data.status == 0){
                    alert('problem in quantity');
                }
                if(data.status == 1){
                    localStorage.removeItem('order');
                    window.location = "{{url('/')}}/order/"+data.order_id;
                }
            })
        })

        function ifexists(product_id,order){
            for(let item of order){
                if(product_id == item.id)
                    return true;
            }
            return false;
        }

        function increaseQty(order,id,qty,max){
            for(let item of order){
                if(item.id == id){
                    let temp = parseInt(item.quantity) + parseInt(qty);
                    if(temp > parseInt(max)){
                        console.log(max,temp);
                        return false;
                    }
                    item.quantity = temp;
                }
            }

            return true;
        }

        function remove(eve){
            const button = eve.target;
            let product_id = button.getAttribute('data-productid');
            let total = parseInt(document.querySelector('#total__products--js').innerText);
            button.closest('tr').remove();
            
            
            if(localStorage.getItem('order')){
                let order = JSON.parse(localStorage.getItem('order'));
                for(let [index,item] of order.entries()){
                    if(item.id == product_id){
                        order.splice(index,1);
                        total = total - item.sale_price;
                    }
                        
                }
                
                localStorage.removeItem('order');
                localStorage.setItem('order',JSON.stringify(order));
                document.querySelector('#total__products--js').innerText = total;
            }

        }
    </script>
@endpush