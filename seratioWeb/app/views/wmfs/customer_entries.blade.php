@extends('layout.dashboard_default')

@section('title')
@if(Auth::user()->has_role('CUSWM001'))
Seratio::WMFS
@elseif(Auth::user()->has_role('CUSWC002'))
Seratio::WCC
@elseif(Auth::user()->has_role('CUSBN003'))
Seratio::B&NESC
@elseif(Auth::user()->has_role('CUSEC004'))
Seratio::EC
@elseif(Auth::user()->has_role('CUSSC005'))
Seratio::SCC
@elseif(Auth::user()->has_role('CUSBS006'))
Seratio::B&SUH
@elseif(Auth::user()->has_role('CUSCB007'))
Seratio::CBC
@elseif(Auth::user()->has_role('CUSHC008'))
Seratio::HC
@elseif(Auth::user()->has_role('CUSHC009'))
Seratio::HC
@elsif(Auth::user()->has_role('CUSWF010'))
Seratio::WFC
@elseif(Auth::user()->has_role('CUSCL011'))
Seratio::COL
@elseif(Auth::user()->has_role('CUSWU012'))
Seratio::WU
@elseif(Auth::user()->has_role('CUSWD013'))
Seratio::WD
@elseif( Auth::user()->has_role('CUSNM014'))
Seratio::NMUH
@endif
@parent
@stop

@section('content')

<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      View All Entries
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{URL::route('dashboard.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">View all entries</li>
    </ol>

  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">

          </div><!-- /.box-header -->
          @if (Session::has('message'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong> {{ Session::get('message') }}</strong>
          </div>
          @endif

          @if ($wmfs->count() > 0)
          <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong>The table below shows WMFS data, SER score, social impact and added value for the financial year.
              Entries are updated annually. Please scroll to the far right of the table and select the blue eye icon in the Action column to view entry progress.
              If you require any changes to the entry you must contact the administration team</strong>
            </div>
            @endif
            <div class="box-body table-responsive" style="overflow: scroll;">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Company</th>
                    <th>Measured Year</th>
                    <th>Target Audience</th>
                    <th>Created At</th>
                    <th>Positive(#)</th>
                    <th>Negative(#)</th>
                    <th>Neutral(#)</th>
                    <th>Sentiment Date</th>

                    <th>Non Statutory Spend(£m)</th>
                    <th>Number of Service Users(#)</th>
                    <th>Net Asset Value(£m)</th>
                    <th>Number of Staff(#)</th>
                    <th>Carbon Reduction(tCO2e)</th>
                    <th>Carbon Offset(tCO2e)</th>

                    <th>People(#m)</th>

                    <th>Money Leveraged(£m)</th>

                    <th>Year Directors Salary(£m)-Cur</th>
                    <th>Members Salary(£m)-Cur</th>
                    <th>Total Staff Salary Bill(£m)-Cur</th>
                    <th>Executive Board Total(#)-Cur</th>
                    <th>Total Number of Councilers/Members(#)-Cur</th>
                    <th>Total Number of Board/Senior executives/Directors(#)-Cur</th>
                    <th>Total Number of Staff(#)-Cur</th>


                    <th>Directors Salary(£m)-Pre</th>
                    <th>Members Salary(£m)-Pre</th>
                    <th>Total Staff Salary Bill(£m)-Pre</th>
                    <th>Executive Board Total(#)-Pre</th>
                    <th>Total Number of Councilers/Members(#)-Pre</th>
                    <th>Total Number of Board/Senior executives/Directors(#)-Pre</th>
                    <th>Total Number of Staff(#)-Pre</th>


                    <th>SER</th>
                    <th>Social Impact (£m)</th>
                    <th>Social Impact as a Percentage of Capitilisation (%) </th>
                    <th>Added Value (£m)</th>
                    <th>Environment(%)</th>
                    <th>People(%)</th>
                    <th>Cash(%)</th>

                    <th>Actions</th>

                  </tr>
                </thead>
                <tbody>
                  @foreach($wmfs as $wmfs)
                  <tr>
                    <td>{{ $wmfs->user ? $wmfs->user->organisation : 'Unknown' }}</td>
                    <td>{{ $wmfs->measured_year ? $wmfs->measured_year : 'N/A'}} </td>
                    <td>{{ $wmfs->targeted_audience? $wmfs->targeted_audience : 'Unknown'}}
                      <td>{{ $wmfs->created_at }} </td>
                      <td>{{ $wmfs->positive }}</td>
                      <td>{{ $wmfs->negative }}</td>
                      <td>{{ $wmfs->neutral }}</td>
                      <td>{{ $wmfs->sentiment_date }}</td>

                      <td>{{ $wmfs->non_statutory_spend }}</td>
                      <td>{{ $wmfs->no_of_service_users }}</td>
                      <td>{{ $wmfs->net_asset_value }} </td>
                      <td>{{ $wmfs->staff }}</td>
                      <td>{{ $wmfs->carbon_reduction_t }}</td>
                      <td>{{ $wmfs->carbon_offset }}</td>

                      <td>{{ $wmfs->people }}</td>

                      <td>{{ $wmfs->money_leveraged }}</td>

                      <td>{{ $wmfs->cu_directors_salary }}</td>
                      <td>{{ $wmfs->cu_members_salary }}</td>
                      <td>{{ $wmfs->cu_staff_salary_bill }} </td>
                      <td>{{ $wmfs->cu_executive_board }}</td>
                      <td>{{ $wmfs->cu_total_counc_members }}</td>
                      <td>{{ $wmfs->cu_total_board_senior_directors }}</td>
                      <td>{{ $wmfs->cu_total_staff }}</td>


                      <td>{{ $wmfs->py_directors_salary }}</td>
                      <td>{{ $wmfs->py_members_salary }}</td>
                      <td>{{ $wmfs->py_staff_salary_bill }} </td>
                      <td>{{ $wmfs->py_executive_board }}</td>
                      <td>{{ $wmfs->py_total_counc_members }}</td>
                      <td>{{ $wmfs->py_total_board_senior_directors }}</td>
                      <td>{{ $wmfs->py_total_staff }}</td>


                      <td>{{ $wmfs->ser ? $wmfs->ser : 'N/A' }}</td>
                      <td>{{ $wmfs->social_impact ? $wmfs->social_impact : 'N/A'}}</td>
                      <td>{{ $wmfs->social_impact_asap_cap ? $wmfs->social_impact_asap_cap : 'N/A'}}
                        <td>{{ $wmfs->added_value ? $wmfs->added_value : 'N/A'}}</td>
                        <td>{{ $wmfs->environment ? $wmfs->environment : 'N/A'}}</td>
                        <td>{{ $wmfs->people_r ? $wmfs->people_r : 'N/A'}}</td>
                        <td>{{ $wmfs->cash ? $wmfs->cash : 'N/A'}}</td>

                        <td>
                          @if(Auth::user()->has_role('admin'))
                          <a href= "#" class="btn btn-primary btn-xs" title="Add Result" data-toggle="modal" data-target="#myModal{{$wmfs->id}}">
                            <span class="glyphicon glyphicon glyphicon-plus"></span></a>
                            <div class="modal fade" id="myModal{{$wmfs->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Add Result</h4>
                                  </div>
                                  <div class="modal-body">
                                    {{ Form::open(array('route' => array('result.wmfs', $wmfs->id))) }}

                                    <div class="input-group">
                                      <span class="input-group-addon" id="basic-addon1">Ratio</span>
                                      {{ Form::number('ser', $wmfs->ser, array('class' => 'form-control', 'aria-describedby' => 'basic-addon1', 'step' => '0.01', 'required' )) }}
                                      @if ($errors->has('ser')) <p class="help-block">{{ $errors->first('ser') }}</p> @endif
                                      <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">SER</button>
                                      </span>
                                    </div>
                                  </br></br>

                                  <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon2">£m</span>
                                    {{ Form::number('social_impact',$wmfs->social_impact, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2', 'step' => '0.01')) }}
                                    @if ($errors->has('social_impact')) <p class="help-block">{{ $errors->first('social_impact') }}</p> @endif
                                    <span class="input-group-btn">
                                      <button class="btn btn-default" type="button">Social Impact</button>
                                    </span>
                                  </div>
                                </br></br>

                                <div class="input-group">
                                  <span class="input-group-addon" id="basic-addon2">%</span>
                                  {{ Form::number('social_impact_asap_cap',$wmfs->social_impact_asap_cap, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2', 'step' => '0.01')) }}
                                  @if ($errors->has('social_impact_asap_cap')) <p class="help-block">{{ $errors->first('social_impact_asap_cap') }}</p> @endif
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Social Impact as a Percentage of Capitilisation</button>
                                  </span>
                                </div>
                              </br></br>

                              <div class="input-group">
                                <span class="input-group-addon" id="basic-addon2">£m</span>
                                {{ Form::number('added_value',$wmfs->added_value, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2', 'step' => '0.01')) }}
                                @if ($errors->has('added_value')) <p class="help-block">{{ $errors->first('added_value') }}</p> @endif
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button">Added Value</button>
                                </span>
                              </div>
                            </br></br>

                            <div class="input-group">
                              <span class="input-group-addon" id="basic-addon2">%</span>
                              {{ Form::number('environment',$wmfs->environment, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2', 'step' => '0.01')) }}
                              @if ($errors->has('environment')) <p class="help-block">{{ $errors->first('environment') }}</p> @endif
                              <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Environment</button>
                              </span>
                            </div>
                          </br></br>

                          <div class="input-group">
                            <span class="input-group-addon" id="basic-addon2">%</span>
                            {{ Form::number('people_r',$wmfs->people_r, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2', 'step' => '0.01')) }}
                            @if ($errors->has('people_r')) <p class="help-block">{{ $errors->first('people_r') }}</p> @endif
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button">People</button>
                            </span>
                          </div>
                        </br></br>

                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon2">%</span>
                          {{ Form::number('cash',$wmfs->cash, array('class' => 'form-control', 'aria-describedby' => 'basic-addon2', 'step' => '0.01')) }}
                          @if ($errors->has('cash')) <p class="help-block">{{ $errors->first('cash') }}</p> @endif
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Cash</button>
                          </span>
                        </div>


                      </div>

                      <div class="modal-footer">
                        {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                        {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
                      </div>
                      {{ Form::close() }}


                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
                @endif
                <a href= "#" class="btn btn-info btn-xs" title="View Stats" data-toggle="modal" data-target="#myModal1{{$wmfs->id}}">
                  <span class="glyphicon glyphicon glyphicon-zoom-in"></span></a>
                  <div class="modal fade" id="myModal1{{$wmfs->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel">View Status</h4>
                        </div>
                        <div class="modal-body">

                          <div id="light">

                            @if(($wmfs->ser == '0' || $wmfs->ser == '') && $wmfs->query != '1')

                            <span class="active" id="red"></span>
                            <span id="orange"></span>
                            <span id="green"></span>

                            @elseif($wmfs->query == '1')
                            <span id="red"></span>
                            <span class="active" id="orange"></span>
                            <span id="green"></span>

                            @elseif($wmfs->ser != '0')
                            <span id="red"></span>
                            <span id="orange"></span>
                            <span class="active" id="green"></span>
                            @endif

                          </div>
                          <div class="row">
                            <h3> Explanation of indicators</h3>
                            <ul>
                              <li> Red: Entry accepted and being processed </li>
                              <li> Orange: Queries raised  </li>
                              <li> Green: Result posted to Dashboard </li>
                            </ul>
                          </div>

                        </div>

                        <div class="modal-footer">

                        </div>

                      </div>

                    </div>

                  </div>
                  <!-- /.modal -->

                  <a href= "{{URL::route('organisation.edit',['$id'=>$wmfs->id])}}" class="btn btn-warning btn-xs" title="Edit Entry">
                    <span class="glyphicon glyphicon glyphicon-pencil"></span></a>

                  @if(Auth::user()->has_role('admin') || Auth::user()->has_subrole('customer'))
                    {{ Form::open(array('route' => array('organisation.destroy', $wmfs->id), 'method' => 'delete', 'onsubmit' => 'return confirmDelete()')) }}
                    <button type="submit" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus-sign"></span></button>
                    {{ Form::close() }}
                  @endif
                  
                  @if(Auth::user()->has_role('admin'))
                    <a href= "#" class="btn btn-success btn-xs" title="There is a query" data-toggle="modal" data-target="#myModal2{{$wmfs->id}}">
                      <span class="glyphicon glyphicon glyphicon-info-sign"></span></a>
                      <div class="modal fade" id="myModal2{{$wmfs->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Change status</h4>
                            </div>
                            <div class="modal-body">
                              {{ Form::open(array('route' => array('query.wmfs', $wmfs->id))) }}
                              <div class="input-group">
                                <label>Query</label>
                                <select class ="form-control"
                                {{ Form::select('query', ['No', 'Yes'], null) }}
                                @if ($errors->has('query')) <p class="help-block">{{ $errors->first('query') }} </p>@endif
                              </select>
                            </div>
                          </div>

                          <div class="modal-footer">
                            {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                            {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
                          </div>
                          {{Form::close()}}
                        </div>

                      </div>

                    </div>
                    <!-- /.modal -->
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>

              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
    </div>

  </section><!-- /.content -->
</div><!-- ./wrapper -->

@stop
@section('scripts')

<!-- page script -->

<script type="text/javascript">
$(document).ready(function() {
  $('#example1').DataTable( {
    dom: 'C<"clear">lfrtip',

    colVis: {
      exclude: [],
      groups: [
        {
          title: "Sentiment",
          columns: [ 2, 3, 4, 5 ]
        },
        {
          title: "Reported",
          columns: [ 6, 7, 8, 9, 10, 11, 12 ]
        },
        {
          title: "People",
          columns: [ 13 ]
        },
        {
          title: "Money Leveraged",
          columns: [ 14 ]
        },
        {
          title: "Current Year",
          columns: [ 15, 16, 17, 18, 19, 20, 21]
        },
        {
          title: "Previous Year",
          columns: [ 22, 23, 24, 25, 26, 27, 28]
        },
        {
          title: "Result",
          columns: [ 29, 30, 31, 32, 33, 34, 35]
        },
        {
          title: "Action",
          columns: [ 36 ]
        }
      ]
    }
  } );
} );

function confirmDelete() {
  var result = confirm('Are you sure you want to delete?');

  if (result) {
    return true;
  } else {
    return false;
  }
}
</script>
@stop
