@extends('dashboard.layout.master')
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
        <h3 class="box-title">
            <p>Order Number: {{$order->id}}</p>
            <p>Order Date: {{$order->created_at}}</p>
        </h3>

        <div class="box-tools pull-right">
            <a href="{{url('place-order')}}}" class="btn btn-info">Place another order</a>
        </div>
        <div class="box-body">
            <table class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Product Quantity</th>
                        <th>Product Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->products as $product)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->pivot->quantity}}</td>
                            <td>{{$product->pivot->sale_price}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <div class="pull-right">
                                Total Bill: {{$order->total}}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="pull-right">
                <a href="#" class="btn btn-info btn-sm">Print Receipt</a>
            </div>
        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
@endsection