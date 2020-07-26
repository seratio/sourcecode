@extends('layout.dashboard_default')
@section('title')
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Dashboard
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Dashboard</li>
      </ol>
   </section>
   </br>
   <!-- Left col -->
   <section class="content">
      <div class="row">
         <section class="col-lg-12">
            <!-- Map box -->
            <div class="row">
               <div class="col-lg-6">
                  <div class="box box-solid box-primary">
                     <div class="box-header with-border">
                        <h3 class="box-title">Info</h3>
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body">
                        <strong><i class="fa fa-book margin-r-5"></i> Name</strong>
                        <p class="text-muted">
                           {{ Auth::user()->organisation ? Auth::user()->organisation : 'Unknwon'}}
                        </p>
                        <hr>
                        <strong><i class="fa fa-hand-o-right margin-r-5"></i> Accelerator</strong>
                        <p class="text-muted">{{ $eu->fiware ? $eu->fiware : 'Unknown' }}</p>
                        <hr>
                     </div>
                     <!-- /.box-body -->
                  </div>
               </div>
               <!-- /.box -->
               <div class="col-lg-6">
                  <div class="box box-solid box-success">
                     <div class="box-header">
                        <h3 class="box-title">Result</h3>
                     </div>
                     <div class="box">
                        <div class="box-body">
                           <div class= "btn-group-vertical" style="width: 100%; height: 155px;">
                              <div class="row">
                                 <div class="col-lg-10 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-red">
                                       <div class="inner">
                                          <h3>
                                             {{ $eu->added_social_value ? $eu->added_social_value : 'Unknown'}}
                                          </h3>
                                          <p>
                                             Added Social Value in Millions of Euro
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- /.box-body -->
                     </div>
                  </div>
                  <!-- /.box -->
               </div>
               <!-- /.box -->
            </div>
            <div class="row">
               <div class="col-lg-6">
                  <div class="box box-solid box-primary">
                     <div class="box-header">
                        <h3 class="box-title">Comparisons</h3>
                     </div>
                     <div class="box">
                        <div class="box-body" align="center">
                           <div id="chart_div"></div>
                           <span align="center">"This is your score relative to other companies under same fiware"</span>
                        </div>
                     </div>
                  </div>
                  <!-- /.box-body -->
               </div>
               <div class="col-lg-6">
                  <div class="box box-solid box-danger">
                     <div class="box-header">
                        <h3 class="box-title">Comparisons</h3>
                     </div>
                     <div class="box">
                        <div class="box-body" align="center">
                           <div id="chart_div_avg"></div>
                           <span align="center">"This is your score relative to other companies all fiware"</span>
                        </div>
                     </div>
                  </div>
                  <!-- /.box-body -->
               </div>
            </div>
         </section>
         <!-- /.Left col -->
      </div>
   </section>
   <!-- /.right-side -->
</div>
<!-- ./wrapper -->
<!-- add new calendar event modal -->
@stop
@section('scripts')
<script type="text/javascript">
   google.load("visualization", "1", {packages:["gauge"]});
   google.setOnLoadCallback(drawChart);
   google.setOnLoadCallback(drawChartavg);
   function drawChart() {

     var data = google.visualization.arrayToDataTable([
       ['Label', 'Value'],
       ['Benchmarking', {{round($comp,2)}}]
       ]);

     var options = {
       minorTicks: 5
     };

     var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

     chart.draw(data, options);


   }

   function drawChartavg() {

     var data = google.visualization.arrayToDataTable([
       ['Label', 'Value'],
       ['Sentiment', {{round($acce,2)}}]
       ]);

     var options = {
       minorTicks: 5
     };

     var chart = new google.visualization.Gauge(document.getElementById('chart_div_avg'));

     chart.draw(data, options);


   }
</script>
@stop
