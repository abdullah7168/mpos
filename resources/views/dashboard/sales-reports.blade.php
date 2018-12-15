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
        <h3 class="box-title">Reports</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                  title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
          <div class="pull-right">
                <select id="sorting--js">
                    <option value="day">Daily</option>
                    <option value="week">Weekly</option>
                    <option value="month">Monthly</option>
                </select>
          </div>
      </div>
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
@endsection

@push('scripts')
<script type="text/javascript">
    window.onload = function() {

        var dataPoints = [];
        var label = 'Daily';

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: `${label} Sales Data`
            },
            axisY: {
                title: "Units",
                titleFontSize: 24
            },
            axisX:{
                valueFormatString: "hh:mm TT"
            },
            data: [{
                type: "column",
                yValueFormatString: "#,### Units",
                dataPoints: dataPoints
            }]
        });

        function addData(data) {
            console.log(chart);
            for (var i = 0; i < data.length; i++) {
                dataPoints.push({
                    x: new Date(data[i].date),
                    y: data[i].units
                });
            }
            
            
            switch (document.querySelector('#sorting--js').value) {
                case 'day':
                    chart.options.title.text = 'Daily Sales Data'
                    chart.options.axisX.valueFormatString = 'hh:mm TT'
                    break;
                case 'week':
                    chart.options.title.text = 'Weekly Sales Data' 
                    chart.options.axisX.valueFormatString = 'DDD'
                    chart.options.axisX.intervalType = 'day'
                    chart.options.axisX.interval = 0
                    break;
                case 'month':
                    chart.options.title.text = 'Monthly Sales Data' 
                    chart.options.axisX.valueFormatString = 'MMM'
                    chart.options.axisX.intervalType = 'month'
                    chart.options.axisX.interval = 0
                    break;
            
                default:
                    break;
            }

            chart.render();
        }

        $.getJSON("{{url('orders-json')}}", addData);

        document.querySelector('#sorting--js').addEventListener('change',function(eve){
            $.getJSON(`mpos/public/orders-json/?type=${eve.target.value}`, addData);
        })

    }
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
@endpush