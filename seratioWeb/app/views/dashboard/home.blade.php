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
         <small>Control panel - Demo</small>
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Dashboard</li>
      </ol>
   </section>
   </br>
   <section class="content">
      <div class="row">
         <div class="col-lg-6">
            <!-- Danger box -->
            <div class="box box-solid box-primary">
               <div class="box-header">
                  <h3 class="box-title">Live Data - Case A: Listed Company</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     {{ HTML::image('assets_backend/images/ajax-loader.gif', 'SE Ratio', array('id' => 'loading', 'alt'=>'loading', 'align'=>'center')) }}
                     <div id="content" style="width: 100%; height: 270px;"></div>
                  </div>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!-- /.box -->
         <div class="col-lg-6">
            <!-- Danger box -->
            <div class="box box-solid box-primary">
               <div class="box-header">
                  <h3 class="box-title">Compliance</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <div class= "btn-group-vertical" align="right" style="width: 100%; height: 270px;">
                        <button type="button" align="right" style=" height: 130px;" class="btn btn-success btn-lg"><b>Good</b></button>
                        <button type="button" class="btn btn-warning" style="width:50px height: 90px;">Average</button>
                        <button type="button" class="btn btn-danger" style="width :50px height: 90px;">Improvement</button>
                     </div>
                  </div>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!-- /.box -->
      </div>
      <div class="row">
         <div class="col-xs-12">
            <!--Danger box -->
            <div class="box box-solid box-danger">
               <div class="box-header">
                  <h3 class="box-title">Monthly Graph - Case A: Listed Company</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <div id="chartdiv_bar" style="width: 100%; height: 500px;">
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
         <div class="col-xs-12">
            <!-- Danger box -->
            <div class="box box-solid box-success">
               <div class="box-header">
                  <h3 class="box-title">Social Impact Classification - Pie Chart</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <div id="chartdiv" style="width: 110%; height: 500px;"></div>
                  </div>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!-- /.box -->
      </div>
      <div class="row">
         <div class="col-xs-12">
            <!-- Danger box -->
            <div class="box box-solid box-primary">
               <div class="box-header">
                  <h3 class="box-title">GIS</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <iframe src="https://www.google.com/maps/d/u/1/embed?mid=zCSd2kzqJNzU.kQFBPqkqz8FY" width="965" height="500"></iframe>
                     <P>Problem viewing the GIS?<a href="https://mapsengine.google.com/map/edit?mid=zKM4gFRXdr0I.ku00o34Mslu8" >&nbspClick Here</a></p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12">
            <!-- Danger box -->
            <div class="box box-solid box-primary">
               <div class="box-header">
                  <h3 class="box-title">Prior Data (2014 - Case A: Listed Company)</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <div id="content" style="width: 100%; height: 480px;">
                        <table class="table table-bordered">
                           <tr>
                              <th>#</th>
                              <th>Index</th>
                              <th style="width: 40px">Value</th>
                           </tr>
                           <tr>
                              <td> 1 </td>
                              <td> Sentiment - Positive (#)</td>
                              <td>65</td>
                           </tr>
                           <tr>
                              <td>2 </td>
                              <td> Sentiment - Neutral(#)</td>
                              <td>317</td>
                           </tr>
                           <tr>
                              <td> 3 </td>
                              <td> Sentiment - Negative(#) </td>
                              <td>4</td>
                           </tr>
                           <tr>
                              <td> 4 </td>
                              <td> Reported - CSR (£m)</td>
                              <td>64.5</td>
                           </tr>
                           <tr>
                              <td> 5 </td>
                              <td> Reported - Degree of Sepration (#)</td>
                              <td>0 </td>
                           </tr>
                           <tr>
                              <td> 6 </td>
                              <td> Reported - Shares (#m)</td>
                              <td>12199</td>
                           </tr>
                           <tr>
                              <td> 7 </td>
                              <td> Reported - Staff (#)</td>
                              <td>139200</td>
                           </tr>
                           <tr>
                              <td> 8 </td>
                              <td> Reported - Carbon Reduction Traded (tCO2e)</td>
                              <td>76676</td>
                           </tr>
                           <tr>
                              <td> 9 </td>
                              <td> Reported - Carbon Offset (tCO2e)</td>
                              <td>11000000</td>
                           </tr>
                           <tr>
                              <td> 10 </td>
                              <td> People (#m) </td>
                              <td>2.039</td>
                           </tr>
                           <tr>
                              <td> 11</td>
                              <td> Money Leveraged(£m) </td>
                              <td>30.3</td>
                           </tr>
                        </table>
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
         <div class="col-xs-12">
            <!-- Danger box -->
            <div class="box box-solid box-primary">
               <div class="box-header">
                  <h3 class="box-title">Prior Data (2014 - Case A: Listed Company) - INCLUDING TAX AVOIDANCE AND PAY DISPARITY</h3>
               </div>
               <div class="box">
                  <div class="box-body">
                     <div id="content" style="width: 100%; height: 900px;">
                        <table class="table table-bordered">
                           <tr>
                              <th>#</th>
                              <th>Index</th>
                              <th style="width: 40px">Value</th>
                           </tr>
                           <tr>
                              <td> 1 </td>
                              <td> Current Year - Directors Salary (Executive) (£m)</td>
                              <td>2.15</td>
                           </tr>
                           <tr>
                              <td>2 </td>
                              <td> Current Year - Directors Salary (Non-Executive) (£m)</td>
                              <td>2.11</td>
                           </tr>
                           <tr>
                              <td> 3 </td>
                              <td> Current Year - Staff Salary(£m) </td>
                              <td>6,277.00</td>
                           </tr>
                           <tr>
                              <td> 4 </td>
                              <td> Current Year - Staff Salary (Without Directors) (£m)</td>
                              <td>6,273</td>
                           </tr>
                           <tr>
                              <td> 5 </td>
                              <td> Current Year - 1,928.00 (£m)</td>
                              <td>0 </td>
                           </tr>
                           <tr>
                              <td> 6 </td>
                              <td> Current Year - Total Shareholder Pay(Divident) (£m)</td>
                              <td>1,387.00</td>
                           </tr>
                           <tr>
                              <td> 7 </td>
                              <td> Current Year - Executive Board (£m)</td>
                              <td>2</td>
                           </tr>
                           <tr>
                              <td> 8 </td>
                              <td> Current Year - Non Executive Board (#)</td>
                              <td>11</td>
                           </tr>
                           <tr>
                              <td> 9 </td>
                              <td> Current Year - Board Total (#)</td>
                              <td>13</td>
                           </tr>
                           <tr>
                              <td> 10 </td>
                              <td> Current Year - Number of Staff (#) </td>
                              <td>141100</td>
                           </tr>
                           <tr>
                              <td> 11 </td>
                              <td> Prior Year - Directors Salary (Executive) (£m)</td>
                              <td>2.11</td>
                           </tr>
                           <tr>
                              <td>12 </td>
                              <td> Prior Year - Directors Salary (Non-Executive) (£m)</td>
                              <td>1.84</td>
                           </tr>
                           <tr>
                              <td> 13 </td>
                              <td> Prior Year - Staff Salary(£m) </td>
                              <td>8,809.00</td>
                           </tr>
                           <tr>
                              <td> 14 </td>
                              <td> Prior Year - Staff Salary (Without Directors) (£m)</td>
                              <td>8,805</td>
                           </tr>
                           <tr>
                              <td> 15 </td>
                              <td> Prior Year - 1,928.00 (£m)</td>
                              <td>1,516.00 </td>
                           </tr>
                           <tr>
                              <td> 16 </td>
                              <td> Prior Year - Total Shareholder Pay(Divident) (£m)</td>
                              <td>1,011.00</td>
                           </tr>
                           <tr>
                              <td> 17 </td>
                              <td> Prior Year - Executive Board (£m)</td>
                              <td>2</td>
                           </tr>
                           <tr>
                              <td> 18 </td>
                              <td> Prior Year - Non Executive Board (#)</td>
                              <td>11</td>
                           </tr>
                           <tr>
                              <td> 19 </td>
                              <td> Prior Year - Board Total (#)</td>
                              <td>13</td>
                           </tr>
                           <tr>
                              <td> 20 </td>
                              <td> Prior Year - Number of Staff (#) </td>
                              <td>147,500</td>
                           </tr>
                           <tr>
                              <td> 21 </td>
                              <td> Tax Avoidance (£m) </td>
                              <td>69.45</td>
                           </tr>
                           <tr>
                              <td> 22 </td>
                              <td> Pay Disparity (£m) </td>
                              <td>0.7090</td>
                           </tr>
                        </table>
                     </div>
                  </div>
                  <!-- /.box-body -->
               </div>
            </div>
            <!-- /.box -->
         </div>
         <!-- /.box -->
      </div>
   </section>
   <!-- /.right-side -->
</div>
<!-- ./wrapper -->
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
