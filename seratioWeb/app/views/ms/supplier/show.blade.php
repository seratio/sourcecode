@extends('layout.dashboard_default', ['ms' => $ms])
@section('title')
SE Ratio::Modern Slavery::Supplier Info
@parent
@stop
@section('content')
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
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         View Supplier Data / {{$supplier->supplier_name}}
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Supplier Info</li>
      </ol>
   </section>
   </br>
   <section class="content">
      <div class="row">
         <div class="col-lg-8">
            <!-- Danger box -->
            <div class="box box-solid box-primary">
               <div class="box-header">
                  <h3 class="box-title">Supplier Info</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <div class="row">
                        <div class="well col-lg-10 col-md-offset-1" style="">
                           <div class="row user-row">
                              <div class="col-xs-3 col-sm-2 col-md-1 col-lg-0">
                                 <i class="fa fa-info-circle" style="color:green; font-size: 2.5em;"></i>
                              </div>
                              <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                 <strong>Basic Info</strong><br>
                              </div>
                              <div class="col-xs-5 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".cyruxx">
                                 <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                              </div>
                           </div>
                           <div class="row user-infos cyruxx">
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                                 <div class="panel panel-success">
                                    <div class="panel-heading">
                                       <h3 class="panel-title">Basic Info</h3>
                                    </div>
                                    <div class="panel-body">
                                       <div class="row">
                                          <div class=" col-md-12">
                                             <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                                <thead class="cf">
                                                </thead>
                                                <tbody>
                                                   <tr>
                                                      <td><b>Supplier Name:</b></td>
                                                      <td >{{$supplier->supplier_name ? $supplier->supplier_name : 'Unknown'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Address:</b></td>
                                                      <td>{{$supplier->number_street ? $supplier->number_street : ''}},<br>{{$supplier->city ? $supplier->city : ''}},<br>{{$supplier->county ? $supplier->county : ''}},<br>{{$supplier->post_code ? $supplier->post_code : ''}},<br>{{  array_get(Country::countries(), $supplier->country, 'Unknown') }}</td>
                                                   <tr>
                                                      <td><b>E-Mail:</b></td>
                                                      <td >{{$supplier->email ? $supplier->email : 'Unknown'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Sector:</b></td>
                                                      <td>{{ array_get(MSlavery::sectors(), $supplier->sector, 'Unknown') }}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Main Industry:</b></td>
                                                      <td>{{ array_get(MSlavery::industries(), $supplier->main_industry, 'Unknown') }}</td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row user-row">
                              <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
                                 <i class="fa fa-money"  style="color:maroon; font-size: 2.5em;"></i>
                              </div>
                              <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                 <strong>Pay</strong><br>
                              </div>
                              <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".user2">
                                 <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                              </div>
                           </div>
                           <div class="row user-infos user2">
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                                 <div class="panel panel-danger">
                                    <div class="panel-heading">
                                       <h3 class="panel-title">Pay</h3>
                                    </div>
                                    <div class="panel-body">
                                       <div class="row">
                                          <div class=" col-md-12">
                                             <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                                <thead class="cf">
                                                </thead>
                                                <tbody>
                                                   <tr>
                                                      <td><b>Currency:</b></td>
                                                      <td>{{$supplier->currency ? $supplier->currency : 'Unknown'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Total Revenue:</b></td>
                                                      <td>{{$supplier->total_revenue ? $supplier->total_revenue : 'Unknown'}}</td>
                                                   <tr>
                                                      <td><b>Total Wages:</b></td>
                                                      <td>{{$supplier->total_wages ? $supplier->total_wages : 'Unknown'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Number of Employees:</b></td>
                                                      <td>{{$supplier->no_of_employees ? $supplier->no_of_employees : 'Unknown'}}</td>
                                                   </tr>
                                                   @if($supplier->document1)
                                                   <tr>
                                                      <td><b>Documents:</b></td>
                                                      <td> <a href="{{URL::asset($supplier->document1)}}" target="_blank"><i class="fa fa-download">
                                                         Click here to download the file</i></a>
                                                      </td>
                                                   </tr>
                                                   @endif
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row user-row">
                              <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
                                 <i class="fa fa-line-chart"  style="color:orange; font-size: 2.5em;"></i>
                              </div>
                              <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                 <strong>Sentiment</strong><br>
                              </div>
                              <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".user3">
                                 <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                              </div>
                           </div>
                           <div class="row user-infos user3">
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                                 <div class="panel panel-warning">
                                    <div class="panel-heading">
                                       <h3 class="panel-title">Sentiment</h3>
                                    </div>
                                    <div class="panel-body">
                                       <div class="row">
                                          <div class=" col-md-12">
                                             <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                                <thead class="cf">
                                                </thead>
                                                <tbody>
                                                   <tr>
                                                      <td >Have you carried out a sentiment survey of your employees?</td>
                                                      <td> {{ $supplier->sentiment_q1 ? 'Yes' : 'No'}}</td>
                                                   </tr>
                                                   @if($supplier->sentiment_q1 == '1')
                                                   <tr>
                                                      <td>What % of your employees would recommend your company to a friend to work for?</td>
                                                      <td>{{ $supplier->sentiment_q2 ? $supplier->sentiment_q2 : 'Unknown'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td >What % of employees completed your survey?</td>
                                                      <td >{{ $supplier->sentiment_q3 ? $supplier->sentiment_q3 : 'Unknown'}}</td>
                                                   </tr>
                                                   <tr>
                                                      <td>When was this survey conducted? Month/Year</td>
                                                      <td>{{ $supplier->sentiment_q4 ? $supplier->sentiment_q4 : 'Unknown'}}</td>
                                                   </tr>
                                                   @endif
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
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
         <div class="col-lg-4">
            <!-- Danger box -->
            <div class="box box-solid box-success">
               <div class="box-header">
                  <h3 class="box-title">Info</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <div class= "btn-group-vertical" style="width: 100%; height: 270px;">
                        <div class="row">
                           <div class="col-lg-10 col-xs-6">
                              <!-- small box -->
                              <div class="small-box bg-red">
                                 <div class="inner">
                                    <h3>
                                       {{$supplier->customer_number}}
                                    </h3>
                                    <p>
                                       Customer Number
                                    </p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-lg-10 col-xs-6">
                              <!-- small box -->
                              <div class="small-box bg-maroon">
                                 <div class="inner">
                                    <h3>
                                       {{ $supplier->supplier_number }}
                                    </h3>
                                    <p>
                                       Supplier Number
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
      </div>
      <div class="row">
         <div class="col-lg-6">
            <!-- Danger box -->
            <div class="box box-solid box-info">
               <div class="box-header">
                  <h3 class="box-title">Compliance</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <button type="button" align="right" style=" height: 100px;width:100%" class="btn btn-success btn-lg">
                        <b>
                           No Risk @if($supplier->modern_slavery>=2) ({{$supplier->modern_slavery}})
                           <line>
                           @endif
                        </b>
                     </button>
                     <br><br>
                     <button type="button" class="btn btn-warning" style="height: 100px;width:100%">
                        <b>
                           Potential Risk @if($supplier->modern_slavery>=1 && $supplier->modern_slavery<2) ({{$supplier->modern_slavery}})
                           <line>
                           @endif
                        </b>
                     </button>
                     <br><br>
                     <button type="button" class="btn btn-danger" style="height: 100px;width:100%">
                        <b>
                           Identifiable Risk @if($supplier->modern_slavery<1 && !empty($supplier->modern_slavery)) ({{$supplier->modern_slavery}})
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
               </div>
               <!-- /.box-body-->
            </div>
            <!-- /.box -->
         </div>
      </div>
      <!-- /.box -->
      <div class="row">
         <div class="col-xs-12">
            <!--Danger box -->
            <div class="box box-solid box-primary">
               <div class="box-header">
                  <h3 class="box-title">Sentiment Survey Results </h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <table id="example1" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>In which country do you work?</th>
                              <th>Do you feel positive when you are at work?</th>
                              <th>Is it safe to speak up and challenge they way things are done within your organisation?</th>
                              <th>What Impact does your work have on your health?</th>
                              <th>Would you recommend your work to a friend?</th>
                              <th>Are you forced to work beyond your agreed working hours or workload and threatend with unpleasent consequences if you do not?</th>
                              <th>Do you feel safe at your workplace?</th>
                              <th>Are you movements outside of work restricted by your employer?</th>
                              <th>Are you working voluntarily?</th>
                              <th>Does your employer deduct money from your wages for travel, for food or for rent</th>
                              <th>Do you feel exploited in your work?</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($surveys as $survey)
                           <tr>
                              <td>{{$survey->country ? $survey->country : 'Unknown'}} </td>
                              <td>{{ $survey->question_1 ? $survey->question_1 : 'Unknown' }}</td>
                              <td>{{ $survey->question_2 ? $survey->question_2 : 'Unknown' }}</td>
                              <td>{{ $survey->question_3 ? $survey->question_3 : 'Unknown' }}</td>
                              <td>{{ $survey->question_4 ? $survey->question_4 : 'Unknown' }}</td>
                              <td>{{ $survey->question_5 ? $survey->question_5 : 'Unknown' }}</td>
                              <td>{{ $survey->question_6 ? $survey->question_6 : 'Unknown' }}</td>
                              <td>{{ $survey->question_7 ? $survey->question_7 : 'Unknown' }}</td>
                              <td>{{ $survey->question_8 ? $survey->question_8 : 'Unknown' }}</td>
                              <td>{{ $survey->question_9 ? $survey->question_9 : 'Unknown' }}</td>
                              <td>{{ $survey->question_10 ? $survey->question_10 : 'Unknown' }}</td>
                           </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                        </tfoot>
                     </table>
                  </div>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!-- /.box -->
      </div>
      <!-- /.box -->
   </section>
</div>
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
