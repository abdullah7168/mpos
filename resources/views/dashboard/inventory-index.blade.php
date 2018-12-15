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
        <h3 class="box-title">Invetory</h3>

        <div class="box-tools pull-right">
            <a href="{{url('/inventory-add-product')}}" class="btn btn-sm btn-info">Add Product</a>
        </div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Purchase Price</th>
                        <th>Sale Price</th>
                    </tr>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="#">{{$product->name}}</a></td>
                            <td>{{$product->quantity}}</td>
                            <td>{{$product->purchase_price}}</td>
                            <td>{{$product->sale_price}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        Footer
        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
@endsection