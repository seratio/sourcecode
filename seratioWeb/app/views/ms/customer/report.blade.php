@extends('layout.dashboard_default', ['ms' => $ms])
@section('title')
SE Ratio::Modern Slavery::Supplier Info
@parent
@stop
<style type="text/css">
   line {
   display: block;
   margin-top: 0.5em;
   margin-bottom: 0.5em;
   margin-left: auto;
   margin-right: auto;
   border-style: inset;
   border-width: 1px;
   border-color: #A51D09;
   }
</style>
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Modern Slavery - Report / {{ $ms->customer_name }}
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Customer Info</li>
      </ol>
   </section>
   </br>
   <section class="content">
      <div class="row">
         <div class="col-lg-6">
            <!-- Danger box -->
            <div class="box box-solid box-primary">
               <div class="box-header">
                  <h3 class="box-title">Compliance</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <button type="button" align="right" style=" height: 100px;width:100%" class="btn btn-success btn-lg">
                        <b>
                           No Risk @if($ms->modern_slavery>=2) ({{$ms->modern_slavery}})
                           <line>
                           @endif
                        </b>
                     </button>
                     <br><br>
                     <button type="button" class="btn btn-warning" style="height: 100px;width:100%">
                        <b>
                           Potential Risk @if($ms->modern_slavery>=1 && $ms->modern_slavery<2) ({{$ms->modern_slavery}})
                           <line>
                           @endif
                        </b>
                     </button>
                     <br><br>
                     <button type="button" class="btn btn-danger" style="height: 100px;width:100%">
                        <b>
                           Identifiable Risk @if($ms->modern_slavery<1 && !empty($ms->modern_slavery)) ({{$ms->modern_slavery}})
                           <line>
                           @endif
                        </b>
                     </button>
                  </div>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!-- /.box -->
         <div class="col-lg-6">
            <!-- Danger box -->
            <div class="box box-solid box-success">
               <div class="box-header">
                  <h3 class="box-title">Progress</h3>
               </div>
               <div class="box-body">
                  <table class="table table-bordered">
                  </table>
                  <div id="chart_div"></div>
                  <!--<div id="content" style="width: 100%; height: 200px;">
                     <table class="table table-bordered">
                         <tr>
                             <th bgcolor="green" style="color:white;font-weight:bold">Overview of Project Status</th>

                         </tr>

                         <tr>
                             <th> 92% Completed </th>
                         </tr>
                         <tr>
                             <th> 8% Outstanding</th>
                         </tr>
                     </table>
                     </div>-->
               </div>
               <!-- /.box-body-->
            </div>
            <!-- /.box -->
         </div>
      </div>
      </br>
   </section>
   <!-- /.right-side -->
</div>
<!-- ./wrapper -->
<!-- add new calendar event modal -->
@stop
@section('scripts')
<!-- page script -->
<script type="text/javascript">
   $(function() {
       $("#example1").dataTable();
   });
</script>
<script type="text/javascript">
   google.load('visualization', '1.0', {packages: ['corechart', 'bar']});
   google.load('visualization', '1.0', {packages:['gauge']});
   google.load("visualization", "1", {packages:["corechart"]});

   google.setOnLoadCallback(drawBasic);


   function drawBasic() {

     var data = google.visualization.arrayToDataTable([
       ['Sections', '% Completion',],
       ['Basic Info', {{$basic_info}}],
       ['Pay', {{$pay}}],
       ['Sentiment', {{$sentiment}}]

       ]);

     var options = {
       chartArea: {width: '60%'},
       hAxis: {
         minValue: 0
     },
     vAxis: {

     }
   };

   var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
   chart.draw(data, options);
   }



</script>
@stop
