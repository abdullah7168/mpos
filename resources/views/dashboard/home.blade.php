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
        <h3 class="box-title">Title</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                  title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores, beatae. Necessitatibus beatae, id dolorum quisquam est aspernatur, illo vitae, dicta dignissimos officia tempore molestiae fugit aut. Perspiciatis earum maiores iusto?
        </p>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
      </div>
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
@endsection
