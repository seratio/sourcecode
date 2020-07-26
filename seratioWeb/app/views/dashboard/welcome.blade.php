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
         Welcome
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Welcome</li>
      </ol>
   </section>
   <!-- START OF HTML FOR DEMO - NOT NEEDED -->
   <section class="content">
      <div class="row">
         <div class="container">
            <div class="header">
            </div>
            <div class="jumbotron">
               <p>At Seratio we measure value creation and transferrence in organisations (public, private, third/NGO, community), projects, processes and citizens.
                  The SaaS platform has been built following 3 years of extensive development and testing internationally through our unique wiki-university research
                  Please be patient with us whilst we test the portal. In the meantime we are providing you with live demo capabilities to illustrate what to expect
                  Every quarter we will be releasing a new fully tested version of our platform
               </p>
               </br>
               <div class="container">
                  <div class="tabbable">
                     <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">PLC Demo</a></li>
                        <li><a href="#tab2" data-toggle="tab">PILOT Demo</a></li>
                        @if(Auth::user()->has_role('admin'))
                        <li><a href="#tab3" data-toggle="tab">WMFS</a></li>
                        @endif
                     </ul>
                     <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                           </br>
                           <a class="btn btn-lg btn-info" href="{{URL::route('dashboard.plc')}}">Dashboard</a>
                        </div>
                        <div class="tab-pane" id="tab2">
                           </br>
                           <button class="btn btn-lg btn-primary" data-toggle="modal" data-target=".process">Process</button>
                           <button class="btn btn-lg btn-warning" data-toggle="modal" data-target=".audit">Audit</button>
                           <button class="btn btn-lg btn-info" data-toggle="modal" data-target=".delivery">Delivery</button>
                           <button class="btn btn-lg btn-primary" data-toggle="modal" data-target=".engagement">Engagement</button>
                           <a class="btn btn-lg btn-danger" href="{{URL::route('dashboard.pilot')}}">Dashboard</a>
                        </div>
                        <div class="tab-pane" id="tab3">
                           </br>
                           <a class="btn btn-lg btn-danger" href="{{URL::route('dashboard.wmfs')}}">Dashboard</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         </p>
         <!-- /container -->
         <div class="modal fade process" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content" style="height:1100px; max-height:1100px; width:750px; max-width:750px;">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     <h3 class="modal-title" id="myModalLabel">Process</h3>
                  </div>
                  <div class="modal-body">
                     <h4>Process 1</h4>
                     {{ HTML::image('assets/img/process1.png') }}
                     </br> </br> </br>
                     <h4>Process 2</h4>
                     {{ HTML::image('assets/img/process2.png') }}
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal fade audit" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content" style="height:1000px; max-height:1000px; width:750px; max-width:750px;">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     <h3 class="modal-title" id="myModalLabel">Audit</h3>
                  </div>
                  <div class="modal-body">
                     {{ HTML::image('assets/img/audit1.png') }}
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal fade delivery" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content" style="height:620px; max-height:620px; width:750px; max-width:750px;">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     <h4 class="modal-title" id="myModalLabel">Delivery</h4>
                  </div>
                  <div class="modal-body">
                     {{ HTML::image('assets/img/delivery.png') }}
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal fade engagement" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content" style="height:720px; max-height:720px; width:750px; max-width:750px;">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     <h4 class="modal-title" id="myModalLabel">Engagement</h4>
                  </div>
                  <div class="modal-body">
                     {{ HTML::image('assets/img/engagement.png') }}
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </p>
   </section>
</div>
<!-- END OF HTML FOR DEMO - NOT NEEDED -->
<!-- add new calendar event modal -->
@stop
@section('scripts')
<script type="text/javascript">
   var auto_refresh = setInterval(
   function ()
   {
   $("#loading").hide();

   $('#content').load( "{{ URL::route('dashboard.livedata') }}");
   }, 20000); // refresh every 10000 milliseconds
</script>
<script type="text/javascript">
   var chart;
   var legend;

   var chartData = [
       {
           "label": "Environmental",
           "value": '1.57'
       },
       {
           "label": "People",
           "value": '1.09'
       },
       {
           "label": "Cash Generated + Invested",
           "value": '55.09'
       },
       {
           "label": "Tax Avoidance",
           "value": '41.81'
       },
       {
           "label": "Pay Disparity",
           "value": '0.42'
       }
   ];

   AmCharts.ready(function () {
       // PIE CHART
       pieChart = new AmCharts.AmPieChart();
       pieChart.dataProvider = chartData;
       pieChart.titleField = "label";
       pieChart.valueField = "value";
       pieChart.outlineColor = "#FFFFFF";
       pieChart.fontSize = 14;
       pieChart.fontFamily = 'Georgia';
       pieChart.outlineAlpha = 0.8;
       pieChart.outlineThickness = 1;
       pieChart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]%</b></span>";
       pieChart.colors = ["#FFCB05", "#252525", "#888888"];

       // LEGEND
       pieLegend = new AmCharts.AmLegend();
       pieLegend.align = "center";
       pieLegend.position = "bottom";
       pieLegend.equalWidths = false;
       pieLegend.autoMargins = false;
       pieLegend.labelText = "[[title]]";
       pieLegend.valueText = "[[value]]%";
       pieLegend.valueAlign = "left";
       pieLegend.markerType = "square";
       pieLegend.switchable = false;
       pieChart.addLegend(pieLegend);

       pieChart.labelRadius = 30;
       pieChart.labelText = "";

       // this makes the chart 3D
       pieChart.depth3D = 15;
       pieChart.angle = 30;

       // WRITE
       pieChart.write("chartdiv");
   });

</script>
<script type="text/javascript">
   var chartData1 = [];
   var chartData2 = [];


   generateChartData();

       function generateChartData()
           {

               chartData1.push({
               date: new Date(2015, 0, 01, 17, 0, 0, 0),
               value: '242.50000',
               volume: '242.50000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 02, 17, 0, 0, 0),
               value: '242.20000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 03, 17, 0, 0, 0),
               value: '242.20000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 04, 17, 0, 0, 0),
               value: '242.20000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 05, 17, 0, 0, 0),
               value: '242.30000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 06, 17, 0, 0, 0),
               value: '234.05000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 07, 17, 0, 0, 0),
               value: '232.10000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 08, 17, 0, 0, 0),
               value: '234.30000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 09, 17, 0, 0, 0),
               value: '235.40000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 10, 17, 0, 0, 0),
               value: '235.40000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 11, 17, 0, 0, 0),
               value: '235.40000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 12, 17, 0, 0, 0),
               value: '231.35000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 13, 17, 0, 0, 0),
               value: '230.25000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 14, 17, 0, 0, 0),
               value: '231.00000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 15, 17, 0, 0, 0),
               value: '227.50000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 16, 17, 0, 0, 0),
               value: '226.80000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 17, 17, 0, 0, 0),
               value: '226.80000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 18, 17, 0, 0, 0),
               value: '226.80000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 19, 17, 0, 0, 0),
               value: '224.15000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 20, 17, 0, 0, 0),
               value: '231.40000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 21, 17, 0, 0, 0),
               value: '235.25000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 22, 17, 0, 0, 0),
               value: '238.50000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 23, 17, 0, 0, 0),
               value: '244.20000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 24, 17, 0, 0, 0),
               value: '244.20000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 25, 17, 0, 0, 0),
               value: '244.20000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 26, 17, 0, 0, 0),
               value: '240.35000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 27, 17, 0, 0, 0),
               value: '240.90000'
           });
                           chartData1.push({
               date: new Date(2015, 0, 28, 17, 0, 0, 0),
               value: '234.33000'
           });

                            chartData1.push({
               date: new Date(2015, 0, 29, 17, 0, 0, 0),
               value: '245.38000'
           });

                            chartData1.push({
               date: new Date(2015, 0, 30, 17, 0, 0, 0),
               value: '248.37000'
           });
                            chartData1.push({
               date: new Date(2015, 0, 31, 17, 0, 0, 0),
               value: '240.37000'
           });
                            chartData1.push({
               date: new Date(2015, 1, 1, 17, 0, 0, 0),
               value: '240.37000'
           });



                           chartData2.push({
               date: new Date(2015, 0, 01, 17, 0, 0, 0),
               value: '1.58434'
           });
                           chartData2.push({
               date: new Date(2015, 0, 02, 17, 0, 0, 0),
               value: '1.58405'
           });
                           chartData2.push({
               date: new Date(2015, 0, 03, 17, 0, 0, 0),
               value: '1.58709'
           });
                           chartData2.push({
               date: new Date(2015, 0, 04, 17, 0, 0, 0),
               value: '1.58212'
           });
                           chartData2.push({
               date: new Date(2015, 0, 05, 17, 0, 0, 0),
               value: '1.69332'
           });
                           chartData2.push({
               date: new Date(2015, 0, 06, 17, 0, 0, 0),
               value: '1.58203'
           });
                           chartData2.push({
               date: new Date(2015, 0, 07, 17, 0, 0, 0),
               value: '1.58660'
           });
                           chartData2.push({
               date: new Date(2015, 0, 08, 17, 0, 0, 0),
               value: '1.55627'
           });
                           chartData2.push({
               date: new Date(2015, 0, 09, 17, 0, 0, 0),
               value: '1.54673'
           });
                           chartData2.push({
               date: new Date(2015, 0, 10, 17, 0, 0, 0),
               value: '1.54743'
           });
                           chartData2.push({
               date: new Date(2015, 0, 11, 17, 0, 0, 0),
               value: '1.58318'
           });
                           chartData2.push({
               date: new Date(2015, 0, 12, 17, 0, 0, 0),
               value: '1.54711'
           });
                           chartData2.push({
               date: new Date(2015, 0, 13, 17, 0, 0, 0),
               value: '1.64861'
           });
                           chartData2.push({
               date: new Date(2015, 0, 14, 17, 0, 0, 0),
               value: '1.58524'
           });
                           chartData2.push({
               date: new Date(2015, 0, 15, 17, 0, 0, 0),
               value: '1.59090'
           });
                           chartData2.push({
               date: new Date(2015, 0, 16, 17, 0, 0, 0),
               value: '1.58938'
           });
                           chartData2.push({
               date: new Date(2015, 0, 17, 17, 0, 0, 0),
               value: '1.53397'
           });
                           chartData2.push({
               date: new Date(2015, 0, 18, 17, 0, 0, 0),
               value: '1.58550'
           });
                           chartData2.push({
               date: new Date(2015, 0, 19, 17, 0, 0, 0),
               value: '1.58070'
           });
                           chartData2.push({
               date: new Date(2015, 0, 20, 17, 0, 0, 0),
               value: '1.58495'
           });
                           chartData2.push({
               date: new Date(2015, 0, 21, 17, 0, 0, 0),
               value: '1.59339'
           });
                           chartData2.push({
               date: new Date(2015, 0, 22, 17, 0, 0, 0),
               value: '1.60915'
           });
                           chartData2.push({
               date: new Date(2015, 0, 23, 17, 0, 0, 0),
               value: '1.60135'
           });
                           chartData2.push({
               date: new Date(2015, 0, 24, 17, 0, 0, 0),
               value: '1.58492'
           });
                           chartData2.push({
               date: new Date(2015, 0, 25, 17, 0, 0, 0),
               value: '1.58781'
           });
                           chartData2.push({
               date: new Date(2015, 0, 26, 17, 0, 0, 0),
               value: '1.58667'
           });
                           chartData2.push({
               date: new Date(2015, 0, 27, 17, 0, 0, 0),
               value: '1.58911'
           });
                            chartData2.push({
               date: new Date(2015, 0, 28, 17, 0, 0, 0),
               value: '1.57511'
           });
                           chartData2.push({
               date: new Date(2015, 0, 29, 17, 0, 0, 0),
               value: '1.59211'
           });
                           chartData2.push({
               date: new Date(2015, 0, 30, 17, 0, 0, 0),
               value: '1.56711'
           });
                           chartData2.push({
               date: new Date(2015, 0, 31, 17, 0, 0, 0),
               value: '1.58911'
           });
                           chartData2.push({
               date: new Date(2015, 1, 1, 17, 0, 0, 0),
               value: '1.54611'
           });


       }


   AmCharts.makeChart("chartdiv_bar", {
       type: "stock",
       pathToImages: "https://178.62.80.134/assets/js/amcharts_stock/images/",
       dataSets: [{
           title: "Share Price",
           fieldMappings: [{
               fromField: "value",
               toField: "value"
           }],
           dataProvider: chartData1,
           categoryField: "date"
       },

       {
           title: "S/E Ratio",
           fieldMappings: [{
               fromField: "value",
               toField: "value"
           }],
           dataProvider: chartData2,
           categoryField: "date"
       }],


       panels: [{

           showCategoryAxis: true,
           title: "Value",
           percentHeight: 70,

           stockGraphs: [{
               id: "g1",

               valueField: "value",
               comparable: true,
               compareField: "value",
               bullet: "round",
               bulletBorderColor: "#FFFFFF",
               bulletBorderAlpha: 1,
               balloonText: "[[title]]:<b>[[value]]</b>",
               compareGraphBalloonText: "[[title]]:<b>[[value]]</b>",
               compareGraphBullet: "round",
               compareGraphBulletBorderColor: "#FFFFFF",
               compareGraphBulletBorderAlpha: 5
           }],

           stockLegend: {
               periodValueTextComparing: "[[percents.value.close]]%",
               periodValueTextRegular: "[[value.close]]"
           }
       }],

       chartScrollbarSettings: {
           graph: "g1"
       },

       chartCursorSettings: {
           valueBalloonsEnabled: true,
           valueLineEnabled:true,
           valueLineBalloonEnabled:true
       },

       periodSelector: {
           position: "left",
           periods: [{
               period: "DD",
               count: 10,
               label: "10 days"
           }, {
               period: "MM",
               selected: true,
               count: 1,
               label: "1 month"
           }, {
               period: "YYYY",
               count: 1,
               label: "1 year"
           }, {
               period: "YTD",
               label: "YTD"
           }, {
               period: "MAX",
               label: "MAX"
           }]
       },

       dataSetSelector: {
           position: "left"
       }
   });

</script>
@stop
