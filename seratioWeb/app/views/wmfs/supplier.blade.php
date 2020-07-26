@extends('layout.dashboard_default')

@section('title')
Seratio
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
      <li><a href="{{URL::route('dashboard.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
</br>
<!-- Left col -->
<section class="content">
  <div class="row">
    <section class="col-lg-12 connectedSortable">
      <!-- Map box -->

      @if($contracts)
      <div class="row">


        <div class="col-lg-12">
          <!--Danger box -->
          <div class="box box-solid box-warning">
            <div class="box-header">
              <h3 class="box-title">Updated Contracts</h3>
            </div>


            <div class="box">
              <div class="box-body">
                @if (Session::has('message'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong> {{ Session::get('message') }}</strong>
                </div>
                @endif

                @if ($contracts->count() > 0)
                <div class="alert alert-info alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong> Please click on individual initiatives to review figures and evidence links supporting each entry</strong>
                </div>
                @endif


                <table id="example1" class="table table-responsive table-bordered table-striped" style="overflow: scroll;">
                  <thead>
                    <tr>
                      <th>Name of Initiative</th>
                      <th>Contract Name</th>
                      <th>Contract Value</th>
                      <th>Contract Reference</th>
                      <th>Start Date</th>
                      <th>Actions</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach($contracts as $data)
                    <tr>
                      <td>{{ $data->name_of_initiative ? $data->name_of_initiative : 'Unknown' }} </td>
                      <td>{{ $data->contract ? $data->contract->contract_name : 'Unknwon' }}</td>
                      <td>{{ $data->contract ? $data->contract->contract_value : 'Unknown' }}</td>
                      <td>{{ $data->contract ? $data->contract->contract_reference : 'Unknown' }}</td>
                      <td>{{ $data->contract ? $data->contract->date_start : 'Unknown' }}</td>
                      <td>
                        <a href= "{{URL::route('suppliers.show',['$id' => $data->contract_id, 'supplier_id' => $data->supplier_id, 'initiative_id' => $data->initiative_id])}}" class="btn btn-success btn-xs" title="View Initiative">
                          <span class="glyphicon glyphicon-eye-open"></span></a>

                          {{ Form::open(array('route' => array('suppliers.destroy', $data->id), 'method' => 'delete', 'class' => 'bidDelete')) }}
                            <button type="submit" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></button>
                          {{ Form::close() }}

                        </td>
                      </tr>
                      @endforeach

                    </tbody>
                    <tfoot>

                    </tfoot>
                  </table>

                </div>
              </div><!-- /.box-body -->
            </div>
          </div><!-- /.box -->
        </div><!-- /.box -->

        <div class="row">


          <div class="col-lg-12">
            <!--Danger box -->
            <div class="box box-solid box-success">
              <div class="box-header">
                <h3 class="box-title">Total Results</h3>
              </div>


              <div class="box">
                <div class="box-body">

                  <table id="example2" class="table table-responsive table-bordered table-striped" style='overflow:scroll;'>
                    <thead>
                      <tr>
                        <th>Contract Name</th>
                        <th>People (#m)</th>
                        <th>Cash (£m)</th>
                        <th>Environment (tCO2e)</th>
                        <th>Hyperlocality (Km)</th>
                        <th>Intervention across all years (£m)</th>
                        <th>N Positive (#)</th>
                        <th>N Negative (#)</th>
                        <th>N Neutral (#)</th>
                        <th>A Positive (#)</th>
                        <th>A Negative (#)</th>
                        <th>A Neutral (#)</th>
                        <th>Social Impact (£m)</th>
                        <th>Social Impact as a Percentage of Capitilisation (%)</th>
                        <th>Added Value (£m)</th>
                        <th>Enviornment Reported (%)</th>
                        <th>People Reported (%)</th>
                        <th>Cash Reported (%)</th>
                        <th>Cash Generated Invested (£m)</th>
                        <th>People Calculated (£m)</th>
                        <th>Enviornment Calculated (£m)</th>
                        <th>SER</th>

                        <th>Total SV Created to Date (£)</th>
                        <th>SV Forcast end of contract (£)</th>
                        <th>SV Created to Date Minimum (%)</th>
                        <th>SV Created to Date Target (%)</th>
                        <th>SV Forcast end of contract minimum (%)</th>
                        <th>SV Forcast end of contract target (%)</th>

                      </tr>
                    </thead>
                    <tbody>
                      @foreach($totalResults as $data)
                      <tr>
                        <td>{{ $data['contract_name'] }} </td>
                        <td>{{ $data['people'] }} </td>
                        <td>{{ $data['cash'] }} </td>
                        <td>{{ $data['environment'] }} </td>
                        <td>{{ $data['hyperlocality'] }} </td>
                        <td>{{ $data['intervention_across_all_years'] }} </td>
                        <td>{{ $data['n_positive'] }} </td>
                        <td>{{ $data['n_negative'] }} </td>
                        <td>{{ $data['n_neutral'] }} </td>
                        <td>{{ $data['a_positive'] }} </td>
                        <td>{{ $data['a_negative'] }} </td>
                        <td>{{ $data['a_neutral'] }} </td>
                        <td>{{ $data['social_impact'] }} </td>
                        <td>{{ $data['social_impact_asap_cap'] }} </td>
                        <td>{{ $data['added_value'] }} </td>
                        <td>{{ $data['environment_r'] }} </td>
                        <td>{{ $data['people_r'] }} </td>
                        <td>{{ $data['cash_r'] }} </td>

                        <td>{{ $data['cash_gen_invested'] }} </td>
                        <td>{{ $data['people_cal'] }} </td>
                        <td>{{ $data['enviornment_cal'] }} </td>

                        <td>{{ $data['ser'] }} </td>
                        <td>{{ $data['total_sv_created_to_date'] }} </td>
                        <td>{{ $data['sv_forecast_end_of_contract'] }} </td>
                        <td>{{ $data['sv_created_to_date_minimum'] }} </td>
                        <td>{{ $data['sv_created_to_date_target'] }} </td>
                        <td>{{ $data['sv_forecast_end_of_contract_minimum'] }} </td>
                        <td>{{ $data['sv_forecast_end_of_contract_target'] }} </td>

                      </tr>
                      @endforeach

                    </tbody>
                    <tfoot>

                    </tfoot>
                  </table>

                </div>
              </div><!-- /.box-body -->
            </div>
          </div><!-- /.box -->
        </div><!-- /.box -->
        @else
        <div class="row wrapper">
          <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <h1 class="panel-title">Info</h1>
              </div>
              <p align="justify">
                Oops, There are no results availble
                <br>
                We apologise for any inconvenience this may cause.
              </p>
            </div>
          </div>
        </div>
        @endif

      </section><!-- /.Left col -->
    </div>

  </section><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- add new calendar event modal -->
@stop
@section('scripts')

<!-- page script -->

<script type="text/javascript">
$(function() {
  $("#example1").dataTable();
  $("#example2").dataTable({
    "scrollX": true
  });
});

$('.bidDelete').on('submit',function(e){
       if(!confirm('Do you want to delete this item?')){
             e.preventDefault();
       }
     });
</script>
@stop
