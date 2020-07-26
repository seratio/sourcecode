@extends('layout.dashboard_default')
@section('title')
Seratio::WMFS::Contract Info
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      View Contract Info / {{$contract->contract->contract_name}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{URL::route('dashboard.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Contract Details</li>
    </ol>
  </section>
</br>
<section class="content">
  <div class="row">
    <div class="col-lg-12">
      <!-- Danger box -->
      <div class="box box-solid box-primary">
        <div class="box-header">
          <h3 class="box-title">Contract Details</h3>
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
                    <strong>Contract Details</strong><br>
                  </div>
                  <div class="col-xs-5 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".cyruxx">
                    <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                  </div>
                </div>
                <div class="row user-infos cyruxx">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                    <div class="panel panel-success">
                      <div class="panel-heading">
                        <h3 class="panel-title">Contract Details</h3>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <div class=" col-md-12">
                            <table class="col-md-12 table-bordered table-striped table-condensed cf">
                              <thead class="cf">
                              </thead>
                              <tbody>
                                <tr>
                                  <td><b>Name of Public Sector Organisation:</b></td>
                                  <td >{{$contract->contract ? $contract->contract->public_sector_organisation : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>Name of Contract:</b></td>
                                  <td >{{$contract->contract ? $contract->contract->contract_name : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>Value of Contract(£m):</b></td>
                                  <td >{{$contract->contract ? $contract->contract->contract_value : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>Date Start:</b></td>
                                  <td >{{$contract->contract ? date('d-m-Y', strtotime($contract->contract->date_start)) : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>Length of Contract:</b></td>
                                  <td >{{$contract->contract ? $contract->contract->contract_length : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>Social Impact Minimum(%):</b></td>
                                  <td >{{$contract->contract ? $contract->contract->social_impact_min : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>Social Value Target(%):</b></td>
                                  <td >{{$contract->contract ? $contract->contract->social_value_target : 'Unknown'}}</td>
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
                    <strong>Targets of Public Sector Organisation for this contract</strong><br>
                  </div>
                  <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".user2">
                    <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                  </div>
                </div>
                <div class="row user-infos user2">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                    <div class="panel panel-danger">
                      <div class="panel-heading">
                        <h3 class="panel-title">Targets of Public Sector Organisation for this contract</h3>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <div class=" col-md-12">
                            <table class="col-md-12 table-bordered table-striped table-condensed cf">
                              <thead class="cf">
                              </thead>
                              <tbody>
                                <tr>
                                  <td><b>Cash targets set by customer with 0-100% bias of importance to each(£):</b></td>
                                  <td >{{$contract->contract ? $contract->contract->cash_target : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>Cash Importance(%):</b></td>
                                  <td >{{$contract->contract ? $contract->contract->cash_imp : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>People targets set by customer with 0-100% bias of importance to each(#):</b></td>
                                  <td >{{$contract->contract ? $contract->contract->people_target : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>People Importance(%):</b></td>
                                  <td >{{$contract->contract ? $contract->contract->people_imp : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>Environmental targets set by customer with 0-100% bias of importance to each(tCO2e):</b></td>
                                  <td >{{$contract->contract ? $contract->contract->environment_target : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>Environment Importance(%):</b></td>
                                  <td >{{$contract->contract ? $contract->contract->environment_imp : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>Geo-location targets set by customer with 0-100% bias of importance to each:</b></td>
                                  <td >{{$contract->contract ? $contract->contract->hyperlocality_target : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>Hyperlocality Importance(%):</b></td>
                                  <td >{{$contract->contract ? $contract->contract->hyperlocality_imp : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>Other targets set by customer with 0-100% bias of importance to each:</b></td>
                                  <td >{{$contract->contract ? $contract->contract->other : 'Unknown'}}</td>
                                </tr>
                                <tr>
                                  <td><b>Other targets Importance(%):</b></td>
                                  <td >{{$contract->contract ? $contract->contract->other_imp : 'Unknown'}}</td>
                                </tr>
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
    <div class="col-lg-12">
      <!-- Danger box -->
      <div class="box box-solid box-success">
        <div class="box-header">
          <h3 class="box-title">Contract Updates</h3>
        </div>
        <div class="box">
          <div class="box-body">
            <div class="row">
              <!-- small box -->
              <div class="col-md-4">
                <div class="row">
                  <table class="table-bordered table-striped table-condensed cf">
                    <thead class="cf">
                    </thead>
                    <tbody>
                      <tr>
                        <td><b>Cash</b></td>
                        <td >{{$contract->cash ? $contract->cash : 'Unknown'}}</td>
                      </tr>
                      <tr>
                        <td><b>People</b></td>
                        <td >{{$contract->people ? $contract->people : 'Unknown'}}</td>
                      </tr>
                      <tr>
                        <td><b>Environment</b></td>
                        <td >{{$contract->environment }}</td>
                      </tr>
                      <tr>
                        <td><b>Hyperlocality</b></td>
                        <td >{{$contract->hyperlocality }}</td>
                      </tr>
                      <tr>
                        <td><b>Sentiment</b></td>
                        <td >{{$contract->sentiment ? $contract->sentiment : 'Unknown'}}</td>
                      </tr>
                      <tr>
                        <td><b>Other</b></td>
                        <td >{{$contract->other ? $contract->other : 'Unknown'}}</td>
                      </tr>
                      <tr>
                        <td><b>Updated At</b></td>
                        <td >{{$contract->updated_at ? date('d-m-Y H:i:s', strtotime($contract->updated_at)): 'Unknown'}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <table class="table-bordered table-striped table-condensed cf">
                    <thead class="cf">
                    </thead>
                    <tbody>
                      <tr>
                        <td><b>Cash - Evidence</b></td>
                        @if($contract->ev_cash)
                        <td> <a href="{{URL::asset($contract->ev_cash)}}" target="_blank"><i class="fa fa-download">
                          Download</i></a>
                        </td>
                        @else
                        <td>N/A</td>
                        @endif
                      </tr>
                      <tr>
                        <td><b>People - Evidence</b></td>
                        @if($contract->ev_people)
                        <td> <a href="{{URL::asset($contract->ev_people)}}" target="_blank"><i class="fa fa-download">
                          Download</i></a>
                        </td>
                        @else
                        <td>N/A</td>
                        @endif
                      </tr>
                      <tr>
                        <td><b>Environment - Evidence</b></td>
                        @if($contract->ev_environment)
                        <td> <a href="{{URL::asset($contract->ev_environment)}}" target="_blank"><i class="fa fa-download">
                          Download</i></a>
                        </td>
                        @else
                        <td>N/A</td>
                        @endif
                      </tr>
                      <tr>
                        <td><b>Hyperlocality - Evidence</b></td>
                        @if($contract->ev_hyperlocality)
                        <td> <a href="{{URL::asset($contract->ev_hyperlocality)}}" target="_blank"><i class="fa fa-download">
                          Download</i></a>
                        </td>
                        @else
                        <td>N/A</td>
                        @endif
                      </tr>
                      <tr>
                        <td><b>Sentiment - Evidence</b></td>
                        @if($contract->ev_sentiment)
                        <td> <a href="{{URL::asset($contract->ev_sentiment)}}" target="_blank"><i class="fa fa-download">
                          Download</i></a>
                        </td>
                        @else
                        <td>N/A</td>
                        @endif
                      </tr>
                      <tr>
                        <td><b>Other - Evidence</b></td>
                        @if($contract->ev_other)
                        <td> <a href="{{URL::asset($contract->ev_other)}}" target="_blank"><i class="fa fa-download">
                          Download</i></a>
                        </td>
                        @else
                        <td>N/A</td>
                        @endif
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <table class="table-bordered table-striped table-condensed cf">
                    <thead class="cf">
                    </thead>
                    <tbody>
                      <tr>
                        <td><b>Cash-Evidence-URL</b></td>
                        @if($contract->ev_cash_url)
                        <td> <a href="{{URL::to($contract->ev_cash_url)}}" target="_blank">
                          Click Here</a>
                        </td>
                        @else
                        <td>N/A</td>
                        @endif
                      </tr>
                      <tr>
                        <td><b>People-Evidence-URL</b></td>
                        @if($contract->ev_people_url)
                        <td> <a href="{{URL::to($contract->ev_people_url)}}" target="_blank">
                          Click Here</a>
                        </td>
                        @else
                        <td>N/A</td>
                        @endif
                      </tr>
                      <tr>
                        <td><b>Environment-Evidence-URL </b></td>
                        @if($contract->ev_environment_url)
                        <td> <a href="{{URL::to($contract->ev_environment_url)}}" target="_blank">
                          Click Here</a>
                        </td>
                        @else
                        <td>N/A</td>
                        @endif
                      </tr>
                      <tr>
                        <td><b>Hyperlocality-Evidence-URL</b></td>
                        @if($contract->ev_hyperlocality_url)
                        <td> <a href="{{URL::to($contract->ev_hyperlocality_url)}}" target="_blank">
                          Click Here</a>
                        </td>
                        @else
                        <td>N/A</td>
                        @endif
                      </tr>
                      <tr>
                        <td><b>Sentiment-Evidence-URL</b></td>
                        @if($contract->ev_sentiment_url)
                        <td> <a href="{{URL::to($contract->ev_sentiment_url)}}" target="_blank">
                          Click Here</a>
                        </td>
                        @else
                        <td>N/A</td>
                        @endif
                      </tr>
                      <tr>
                        <td><b>Other-Evidence-URL</b></td>
                        @if($contract->ev_other_url)
                        <td> <a href="{{URL::to($contract->ev_other_url)}}" target="_blank">
                          Click Here</a>
                        </td>
                        @else
                        <td>N/A</td>
                        @endif
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <!-- /.box -->
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <!-- Danger box -->
      <div class="box box-solid box-warning">
        <div class="box-header">
          <h3 class="box-title">Social Value Report</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <!-- small box -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="overflow:scroll;">
                  <div id="chartdiv1" style="width: 600px; height: 200px;"></div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="overflow:scroll;">
                  <div id="chartdiv2" style="width: 600px; height: 200px;"></div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="overflow:scroll;">
                  <div id="chartdiv3" style="width: 600px; height: 200px;"></div>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="overflow:scroll;">
                  <div id="chartdiv8" style="width: 600px; height: 200px;"></div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="overflow:scroll;">
                  <div id="chartdiv9" style="width: 600px; height: 200px;"></div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="overflow:scroll;">
                  <div id="chartdiv10" style="width: 600px; height: 200px;"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
</div>



<!-- /.right-side -->

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
var chart;

var chartData1 = [
  {
    "type": "Cash Investment Expectation in contract",
    "cash": {{ $contract->contract ? $contract->contract->cash_target : 0 }}
  },
  {
    "type": "Actual Cash Investment to date",
    "cash": {{ ($contract->cash*1000000) }}
  }
];


AmCharts.ready(function () {
  // SERIAL CHART
  chart = new AmCharts.AmSerialChart();
  chart.dataProvider = chartData1;
  chart.categoryField = "type";
  // this single line makes the chart a bar chart,
  // try to set it to false - your bars will turn to columns
  chart.rotate = true;
  // the following two lines makes chart 3D
  chart.depth3D = 10;
  chart.angle = 30;

  // AXES
  // Category
  var categoryAxis = chart.categoryAxis;
  categoryAxis.gridPosition = "start";
  categoryAxis.axisColor = "#DADADA";
  categoryAxis.fillAlpha = 1;
  categoryAxis.gridAlpha = 0;
  categoryAxis.fillColor = "#FAFAFA";

  // value
  var valueAxis = new AmCharts.ValueAxis();
  valueAxis.axisColor = "#DADADA";
  valueAxis.title = "Cash(£)";
  valueAxis.gridAlpha = 0.1;
  chart.addValueAxis(valueAxis);

  // GRAPH
  var graph = new AmCharts.AmGraph();
  graph.title = "Cash";
  graph.valueField = "cash";
  graph.type = "column";
  graph.balloonText = "[[category]]:[[value]]";
  graph.lineAlpha = 0;
  graph.fillColors = "#1f004d";
  graph.fillAlphas = 1;
  chart.addGraph(graph);

  chart.creditsPosition = "top-right";

  // WRITE
  chart.write("chartdiv1");
});
</script>
<script type="text/javascript">
var chart;

var chartData2 = [
  {
    "type": "Expected number of people to benefit from community initiatives",
    "people": {{ $contract->contract ? round($contract->contract->people_target, 2) : 0 }}
  },
  {
    "type": "Actual number of people benefitting from community initiatives",
    "people": {{ ($contract->people*1000000) }}
  }
];


AmCharts.ready(function () {
  // SERIAL CHART
  chart = new AmCharts.AmSerialChart();
  chart.dataProvider = chartData2;
  chart.categoryField = "type";
  // this single line makes the chart a bar chart,
  // try to set it to false - your bars will turn to columns
  chart.rotate = true;
  // the following two lines makes chart 3D
  chart.depth3D = 10;
  chart.angle = 30;

  // AXES
  // Category
  var categoryAxis = chart.categoryAxis;
  categoryAxis.gridPosition = "start";
  categoryAxis.axisColor = "#DADADA";
  categoryAxis.fillAlpha = 1;
  categoryAxis.gridAlpha = 0;
  categoryAxis.fillColor = "#FAFAFA";

  // value
  var valueAxis = new AmCharts.ValueAxis();
  valueAxis.axisColor = "#DADADA";
  valueAxis.title = "People(£)";
  valueAxis.gridAlpha = 0.1;
  chart.addValueAxis(valueAxis);

  // GRAPH
  var graph = new AmCharts.AmGraph();
  graph.title = "People";
  graph.valueField = "people";
  graph.type = "column";
  graph.balloonText = "[[category]]:[[value]]";
  graph.lineAlpha = 0;
  graph.fillColors = "#b30047";
  graph.fillAlphas = 1;
  chart.addGraph(graph);

  chart.creditsPosition = "top-right";

  // WRITE
  chart.write("chartdiv2");
});
</script>
<script type="text/javascript">
var chart;

var chartData3 = [
  {
    "type": "Expected environmental target in tCO2e",
    "environment": {{ $contract->contract ? round($contract->contract->environment_target, 2) : 0 }}
  },
  {
    "type": "Actual environmental impact in tCO2e",
    "environment": {{ round(($contract->enviornment_cal-$sv->enviornment_cal)*1000000, 2) }}
  }
];


AmCharts.ready(function () {
  // SERIAL CHART
  chart = new AmCharts.AmSerialChart();
  chart.dataProvider = chartData3;
  chart.categoryField = "type";
  // this single line makes the chart a bar chart,
  // try to set it to false - your bars will turn to columns
  chart.rotate = true;
  // the following two lines makes chart 3D
  chart.depth3D = 10;
  chart.angle = 30;

  // AXES
  // Category
  var categoryAxis = chart.categoryAxis;
  categoryAxis.gridPosition = "start";
  categoryAxis.axisColor = "#DADADA";
  categoryAxis.fillAlpha = 1;
  categoryAxis.gridAlpha = 0;
  categoryAxis.fillColor = "#FAFAFA";

  // value
  var valueAxis = new AmCharts.ValueAxis();
  valueAxis.axisColor = "#DADADA";
  valueAxis.title = "Environment(£)";
  valueAxis.gridAlpha = 0.1;
  chart.addValueAxis(valueAxis);

  // GRAPH
  var graph = new AmCharts.AmGraph();
  graph.title = "Environment";
  graph.valueField = "environment";
  graph.type = "column";
  graph.balloonText = "[[category]]:[[value]]";
  graph.lineAlpha = 0;
  graph.fillColors = "#004d00";
  graph.fillAlphas = 1;
  chart.addGraph(graph);

  chart.creditsPosition = "top-right";

  // WRITE
  chart.write("chartdiv3");
});
</script>
<script type="text/javascript">
var chart;

var chartData4 = [
  {
    "type": "Expected impact mileage",
    "hyperlocality": {{ $contract->contract ? round($contract->contract->hyperlocality_target, 2) : 0 }}
  },
  {
    "type": "Actual impact mileage",
    "hyperlocality": {{ $contract->hyperlocality  ? round($contract->hyperlocality, 2) : 0}}
  }
];


AmCharts.ready(function () {
  // SERIAL CHART
  chart = new AmCharts.AmSerialChart();
  chart.dataProvider = chartData4;
  chart.categoryField = "type";
  // this single line makes the chart a bar chart,
  // try to set it to false - your bars will turn to columns
  chart.rotate = true;
  // the following two lines makes chart 3D
  chart.depth3D = 10;
  chart.angle = 30;

  // AXES
  // Category
  var categoryAxis = chart.categoryAxis;
  categoryAxis.gridPosition = "start";
  categoryAxis.axisColor = "#DADADA";
  categoryAxis.fillAlpha = 1;
  categoryAxis.gridAlpha = 0;
  categoryAxis.fillColor = "#FAFAFA";

  // value
  var valueAxis = new AmCharts.ValueAxis();
  valueAxis.axisColor = "#DADADA";
  valueAxis.title = "Hyperlocality";
  valueAxis.gridAlpha = 0.1;
  chart.addValueAxis(valueAxis);

  // GRAPH
  var graph = new AmCharts.AmGraph();
  graph.title = "Hyperlocality";
  graph.valueField = "hyperlocality";
  graph.type = "column";
  graph.balloonText = "[[category]]:[[value]]";
  graph.lineAlpha = 0;
  graph.fillColors = "#808000";
  graph.fillAlphas = 1;
  chart.addGraph(graph);

  chart.creditsPosition = "top-right";

  // WRITE
  chart.write("chartdiv4");
});
</script>
<!--<script type="text/javascript">
var chart;

var chartData5 = [
{
"type": "Expected",
"sentiment": {{ $contract->contract ? $contract->contract->sentiment_target : 0 }}
},
{
"type": "Actual",
"sentiment": {{ $contract->sentiment  ? $contract->sentiment : 0}}
}
];


AmCharts.ready(function () {
// SERIAL CHART
chart = new AmCharts.AmSerialChart();
chart.dataProvider = chartData5;
chart.categoryField = "type";
// this single line makes the chart a bar chart,
// try to set it to false - your bars will turn to columns
chart.rotate = true;
// the following two lines makes chart 3D
chart.depth3D = 10;
chart.angle = 30;

// AXES
// Category
var categoryAxis = chart.categoryAxis;
categoryAxis.gridPosition = "start";
categoryAxis.axisColor = "#DADADA";
categoryAxis.fillAlpha = 1;
categoryAxis.gridAlpha = 0;
categoryAxis.fillColor = "#FAFAFA";

// value
var valueAxis = new AmCharts.ValueAxis();
valueAxis.axisColor = "#DADADA";
valueAxis.title = "Sentiment";
valueAxis.gridAlpha = 0.1;
chart.addValueAxis(valueAxis);

// GRAPH
var graph = new AmCharts.AmGraph();
graph.title = "Sentiment";
graph.valueField = "sentiment";
graph.type = "column";
graph.balloonText = "Sentiment in [[category]]:[[value]]";
graph.lineAlpha = 0;
graph.fillColors = "#bf1c25";
graph.fillAlphas = 1;
chart.addGraph(graph);

chart.creditsPosition = "top-right";

// WRITE
chart.write("chartdiv5");
});
</script>-->
<script type="text/javascript">
var chart;

var chartData6 = [
  {
    "type": "Expected",
    "other": {{ $contract->contract ? round($contract->contract->other, 2) : 0 }}
  },
  {
    "type": "Actual",
    "other": {{ $contract->other  ? round($contract->other, 2) : 0}}
  }
];


AmCharts.ready(function () {
  // SERIAL CHART
  chart = new AmCharts.AmSerialChart();
  chart.dataProvider = chartData6;
  chart.categoryField = "type";
  // this single line makes the chart a bar chart,
  // try to set it to false - your bars will turn to columns
  chart.rotate = true;
  // the following two lines makes chart 3D
  chart.depth3D = 10;
  chart.angle = 30;

  // AXES
  // Category
  var categoryAxis = chart.categoryAxis;
  categoryAxis.gridPosition = "start";
  categoryAxis.axisColor = "#DADADA";
  categoryAxis.fillAlpha = 1;
  categoryAxis.gridAlpha = 0;
  categoryAxis.fillColor = "#FAFAFA";

  // value
  var valueAxis = new AmCharts.ValueAxis();
  valueAxis.axisColor = "#DADADA";
  valueAxis.title = "Other(£)";
  valueAxis.gridAlpha = 0.1;
  chart.addValueAxis(valueAxis);

  // GRAPH
  var graph = new AmCharts.AmGraph();
  graph.title = "Other";
  graph.valueField = "other";
  graph.type = "column";
  graph.balloonText = "[[category]]:[[value]]";
  graph.lineAlpha = 0;
  graph.fillColors = "#bf1c25";
  graph.fillAlphas = 1;
  chart.addGraph(graph);

  chart.creditsPosition = "top-right";

  // WRITE
  chart.write("chartdiv6");
});
</script>
<script type="text/javascript">
var chart;

var chartData8 = [
  {
    "type": "Total Social Value created to date (£)",
    "other": {{ $total_sv_created_to_date ? $total_sv_created_to_date : 0 }}
  },
  {
    "type": "Social Value Forecast End of Contract (£)",
    "other": {{ $sv_forecast_end_of_contract  ? round($sv_forecast_end_of_contract,2)  : 0}}
  }
];


AmCharts.ready(function () {
  // SERIAL CHART
  chart = new AmCharts.AmSerialChart();
  chart.dataProvider = chartData8;
  chart.categoryField = "type";
  // this single line makes the chart a bar chart,
  // try to set it to false - your bars will turn to columns
  chart.rotate = true;
  // the following two lines makes chart 3D
  chart.depth3D = 10;
  chart.angle = 30;

  // AXES
  // Category
  var categoryAxis = chart.categoryAxis;
  categoryAxis.gridPosition = "start";
  categoryAxis.axisColor = "#DADADA";
  categoryAxis.fillAlpha = 1;
  categoryAxis.gridAlpha = 0;
  categoryAxis.fillColor = "#FAFAFA";

  // value
  var valueAxis = new AmCharts.ValueAxis();
  valueAxis.axisColor = "#DADADA";
  valueAxis.title = "Social Value created against forecast (%)";
  valueAxis.gridAlpha = 0.1;
  chart.addValueAxis(valueAxis);

  // GRAPH
  var graph = new AmCharts.AmGraph();
  graph.valueField = "other";
  graph.type = "column";
  graph.balloonText = "[[category]]:[[value]]";
  graph.lineAlpha = 0;
  graph.fillColors = "#808000";
  graph.fillAlphas = 1;
  chart.addGraph(graph);

  chart.creditsPosition = "top-right";

  // WRITE
  chart.write("chartdiv8");
});
</script>
<script type="text/javascript">
var chart;

var chartData9 = [
  {
    "type": "Social Value created to date as % of minimum (%)",
    "other": {{ $sv_created_to_date_minimum  ? round($sv_created_to_date_minimum, 2)  : 0}}
  },
  {
    "type": "Social Value created to date as % of target (%)",
    "other": {{ $sv_created_to_date_target  ? round($sv_created_to_date_target, 2)  : 0}}
  }
];


AmCharts.ready(function () {
  // SERIAL CHART
  chart = new AmCharts.AmSerialChart();
  chart.dataProvider = chartData9;
  chart.categoryField = "type";
  // this single line makes the chart a bar chart,
  // try to set it to false - your bars will turn to columns
  chart.rotate = true;
  // the following two lines makes chart 3D
  chart.depth3D = 10;
  chart.angle = 30;

  // AXES
  // Category
  var categoryAxis = chart.categoryAxis;
  categoryAxis.gridPosition = "start";
  categoryAxis.axisColor = "#DADADA";
  categoryAxis.fillAlpha = 1;
  categoryAxis.gridAlpha = 0;
  categoryAxis.fillColor = "#FAFAFA";

  // value
  var valueAxis = new AmCharts.ValueAxis();
  valueAxis.title = "Social Value created against minimum target (%)";
  valueAxis.axisColor = "#DADADA";
  valueAxis.gridAlpha = 0.1;
  chart.addValueAxis(valueAxis);

  // GRAPH
  var graph = new AmCharts.AmGraph();
  graph.valueField = "other";
  graph.type = "column";
  graph.balloonText = "[[category]]:[[value]]";
  graph.lineAlpha = 0;
  graph.fillColors = "#b32400";
  graph.fillAlphas = 1;
  chart.addGraph(graph);

  chart.creditsPosition = "top-right";

  // WRITE
  chart.write("chartdiv9");
});
</script>
<script type="text/javascript">
var chart;

var chartData10 = [
  {
    "type": "Social Value forecast end of contract as % of minimum (%)",
    "other": {{ $sv_forecast_end_of_contract_minimum  ? round($sv_forecast_end_of_contract_minimum, 2)  : 0}}
  },
  {
    "type": "Social Value forecast end of contract as % of target (%)",
    "other": {{ $sv_forecast_end_of_contract_target  ? round($sv_forecast_end_of_contract_target, 2) : 0}}

  }
];


AmCharts.ready(function () {
  // SERIAL CHART
  chart = new AmCharts.AmSerialChart();
  chart.dataProvider = chartData10;
  chart.categoryField = "type";
  // this single line makes the chart a bar chart,
  // try to set it to false - your bars will turn to columns
  chart.rotate = true;
  // the following two lines makes chart 3D
  chart.depth3D = 10;
  chart.angle = 30;

  // AXES
  // Category
  var categoryAxis = chart.categoryAxis;
  categoryAxis.gridPosition = "start";
  categoryAxis.axisColor = "#DADADA";
  categoryAxis.fillAlpha = 1;
  categoryAxis.gridAlpha = 0;
  categoryAxis.fillColor = "#FAFAFA";

  // value
  var valueAxis = new AmCharts.ValueAxis();
  valueAxis.title = "Social Value forecast against minimum target (%)";
  valueAxis.axisColor = "#DADADA";
  valueAxis.gridAlpha = 0.1;
  chart.addValueAxis(valueAxis);

  // GRAPH
  var graph = new AmCharts.AmGraph();
  graph.valueField = "other";
  graph.type = "column";
  graph.balloonText = "[[category]]:[[value]]";
  graph.lineAlpha = 0;
  graph.fillColors = "#bf1c25";
  graph.fillAlphas = 1;
  chart.addGraph(graph);

  chart.creditsPosition = "top-right";

  // WRITE
  chart.write("chartdiv10");
});
</script>
<script type="text/javascript">
var chart = AmCharts.makeChart("chartdiv7", {
  "type": "radar",
  "theme": "none",
  "dataProvider": [{
    "type": "Cash",
    "expected": {{ $customer_contract->cash_target ? round($customer_contract->cash_target, 2) : 0 }},
    "actual": {{ $contract->cash_r ? round($contract->cash_r, 2) : 0 }}
  }, {
    "type": "People",
    "expected": {{ $customer_contract->people_target ? round($customer_contract->people_target, 2) : 0 }},
    "actual": {{ $contract->people_r ? round($contract->people_r, 2) : 0  }}
  }, {
    "type": "Environment",
    "expected": {{ $customer_contract->environment_target ? round($customer_contract->environment_target, 2) : 0 }},
    "actual": {{ $contract->environment_r ? round($contract->environment_r, 2) : 0  }}
  }],
  "valueAxes": [{
    "axisTitleOffset": 20,
    "minimum": 0,
    "axisAlpha": 0.15
  }, {
    "id": "v2",
    "axisTitleOffset": 20,
    "minimum": 0,
    "axisAlpha": 0,
    "inside": true
  }],
  "startDuration": 2,
  "graphs": [{
    "balloonText": "[[value]]% expected",
    "bullet": "round",
    "valueField": "expected"
  }, {
    "balloonText": "[[value]]% satisfied",
    "bullet": "square",
    "valueField": "actual",
    "valueAxis": "v2"
  }],
  "categoryField": "type"
});
</script>
@stop
