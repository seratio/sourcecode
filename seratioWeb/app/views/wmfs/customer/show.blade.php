@extends('layout.dashboard_default')

@section('title')
Seratio::WMFS::
@if(Auth::user()->has_role('CUSWM001'))
Seratio::WMFS::Contract Details
@elseif(Auth::user()->has_role('CUSWC002'))
Seratio::WCC::Contract Details
@elseif(Auth::user()->has_role('CUSBN003'))
Seratio::B&NESC::Contract Details
@elseif(Auth::user()->has_role('CUSEC004'))
Seratio::EC::Contract Details
@elseif(Auth::user()->has_role('CUSSC005'))
Seratio::SCC::Contract Details
@elseif(Auth::user()->has_role('CUSBS006'))
Seratio::B&SUH::Contract Details
@elseif(Auth::user()->has_role('CUSCB007'))
Seratio::CBC::Contract Details
@elseif(Auth::user()->has_role('CUSHC008'))
Seratio::HC::Contract Details
@elseif(Auth::user()->has_role('CUSHC009'))
Seratio::HC::Contract Details
@elsif(Auth::user()->has_role('CUSWF010'))
Seratio::WFC::Contract Details
@elseif(Auth::user()->has_role('CUSCL011'))
Seratio::COL::Contract Details
@elseif(Auth::user()->has_role('CUSWU012'))
Seratio::WU::Contract Details
@elseif(Auth::user()->has_role('CUSWD013'))
Seratio::WD::Contract Details
@elseif( Auth::user()->has_role('CUSNM014'))
Seratio::NMUH::Contract Details
@endif
@parent
@stop

@section('content')

<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      View Contract Info / {{$contract->contract_name}}

    </h1>

    <ol class="breadcrumb">
      <li><a href="{{URL::route('dashboard.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Contract Details</li>
    </ol>
  </section>
</br>
<section class="content">
  <div class="row">
    @if (Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <strong> {{ Session::get('message') }}</strong>
    </div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <strong> {{ Session::get('error') }}</strong>
    </div>
    @endif
    <div class="col-lg-8">
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
                        <div class="alert alert-info alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                          <strong> Below are all the essential contract details entered by authorised personnel from the authority.</strong>
                        </div>
                        <div class="row">



                          <div class=" col-md-12">



                            <table class="col-md-12 table-bordered table-striped table-condensed cf">
                              <thead class="cf">

                              </thead>
                              <tbody>
                                <tr>
                                  <td><b>Contract Holder:</b></td>
                                  <td >{{$contract->public_sector_organisation ? $contract->public_sector_organisation : 'Unknown'}}</td>

                                </tr>
                                <tr>
                                  <td><b>Name of Contract:</b></td>
                                  <td >{{$contract->public_sector_organisation ? $contract->contract_name : 'Unknown'}}</td>

                                  <tr>
                                    <td><b>Value of Contract(£m):</b></td>
                                    <td >{{$contract->contract_value ? $contract->contract_value : 'Unknown'}}</td>

                                  </tr>
                                  <tr>
                                    <td><b>Date Start:</b></td>
                                    <td >{{$contract->date_start ? date('d-m-Y', strtotime($contract->date_start)) : 'Unknown'}}</td>

                                  </tr>
                                  <tr>
                                    <td><b>Length of Contract (Months):</b></td>
                                    <td >{{$contract->contract_length ? $contract->contract_length : 'Unknown'}}</td>

                                  </tr>

                                  <tr>
                                    <td><b>Social Impact Minimum(%):</b></td>
                                    <td >{{$contract->social_impact_min ? $contract->social_impact_min : 'Unknown'}}</td>

                                  </tr>
                                  <tr>
                                    <td><b>Social Value Target(%):</b></td>
                                    <td >{{$contract->social_value_target ? $contract->social_value_target : 'Unknown'}}</td>

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
                          <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <strong>The targets below are set by the authority for the length of the contract.</strong>
                          </div>
                          <div class="row">


                            <div class=" col-md-12">

                              <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                <thead class="cf">

                                </thead>
                                <tbody>
                                  <tr>
                                    <td><b>Cash targets set by customer with 0-100% bias of importance to each(£):</b></td>
                                    <td >{{$contract->cash_target ? $contract->cash_target : '0'}}</td>

                                  </tr>
                                  <tr>
                                    <td><b>Cash Importance(%):</b></td>
                                    <td >{{$contract->cash_imp ? $contract->cash_imp : '0'}}</td>

                                  </tr>
                                  <tr>
                                    <td><b>People targets set by customer with 0-100% bias of importance to each(#):</b></td>
                                    <td >{{$contract->people_target ? $contract->people_target : '0'}}</td>
                                  </tr>

                                  <tr>
                                    <td><b>People Importance(%):</b></td>
                                    <td >{{$contract->people_imp ? $contract->people_imp : '0'}}</td>

                                  </tr>
                                  <tr>
                                    <td><b>Environmental targets set by customer with 0-100% bias of importance to each(tCO2e):</b></td>
                                    <td >{{$contract->environment_target ? $contract->environment_target : '0'}}</td>
                                  </tr>
                                  <tr>
                                    <td><b>Environment Importance(%):</b></td>
                                    <td >{{$contract->environment_imp ? $contract->environment_imp : '0'}}</td>
                                  </tr>
                                  <tr>
                                    <td><b>Geo-location targets set by customer with 0-100% bias of importance to each:</b></td>
                                    <td >{{$contract->hyperlocality_target ? $contract->hyperlocality_target : '0'}}</td>
                                  </tr>
                                  <tr>
                                    <td><b>Hyperlocality Importance(%):</b></td>
                                    <td >{{$contract->hyperlocality_imp ? $contract->hyperlocality_imp : '0'}}</td>
                                  </tr>
                                  <tr>
                                    <td><b>Other targets set by customer with 0-100% bias of importance to each:</b></td>
                                    <td >{{$contract->other ? $contract->other : '0'}}</td>
                                  </tr>
                                  <tr>
                                    <td><b>Other targets Importance(%):</b></td>
                                    <td >{{$contract->other_imp ? $contract->other_imp : '0'}}</td>
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
          </div><!-- /.box-body -->
        </div>
      </div><!-- /.box -->


      <div class="col-lg-4">
        <!-- Danger box -->
        <div class="box box-solid box-success">
          <div class="box-header">
            <h3 class="box-title">Contract Info</h3>
          </div>
          <div class="box">
            <div class="box-body">

              <div class= "btn-group-vertical" style="width: 100%; height: 200px;">
                <div class="row">
                  <div class="col-lg-10 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                      @if(((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||
                      Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
                      Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
                      Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
                      Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
                      Auth::user()->has_subrole('customer')) || Auth::user()->has_role('admin'))
                      <div class="inner">
                        <h3>
                          {{ $count ? $count : 0}}
                        </h3>
                        <p>
                          Updates on the contract evaluation
                        </p>
                      </div>
                      @endif
                    </div>
                    @if((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||
                    Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
                    Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
                    Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
                    Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) && Auth::user()->has_subrole('supplier'))

                    <a href= "#" class="btn btn-primary btn-lg" title="Click here to bid" data-toggle="modal" data-target="#myModal">Update Figures/Deliverables</a>
                    @endif
                  </div>
                </div>
              </div>
            </div><!-- /.box-body -->
          </div>
        </div><!-- /.box -->
      </div>
    </div>
    @if(((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||
    Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
    Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') ||
    Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') ||
    Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
    Auth::user()->has_subrole('customer')) || Auth::user()->has_role('admin'))
    <div class="row">

      <div class="col-lg-12">
        <!--Danger box -->
        <div class="box box-solid box-warning">
          <div class="box-header">
            <h3 class="box-title">Contract Monitoring</h3>
          </div>
          <div class="box">
            <div class="box-body">

              <div class="box-body table-responsive" style="overflow: scroll;">

                <table id="example1" class="table table-bordered table-striped" style="overflow:scroll;">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Name of Initiative</th>
                      <th>Cash (£m)</th>
                      <th>Proof of cash</th>
                      <th>People (#m)</th>
                      <th>Proof of people </th>
                      <th>Environment (tCO2e)</th>
                      <th>Proof of environment</th>
                      <th>Hyperlocality (Km)</th>
                      <th>Proof of hyperlocality</th>
                      <th>Sentiment (%)</th>
                      <th>Proof of sentiment</th>
                      <th>Other</th>
                      <th>Other(ev)</th>

                      <th>SER</th>
                      <th>Social Impact (£m)</th>
                      <th>Social Impact as a Percentage of Capitilization (%)</th>
                      <th>Added Value (£m)</th>
                      <th>Enviornment (%)</th>
                      <th>People (%)</th>
                      <th>Cash (%)</th>


                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($bids as $value)
                    <tr>
                      <td> {{ $value->created_at ? date('d-m-Y', strtotime($value->created_at))  : 'N/A' }}</td>
                      <td> {{ $value->name_of_initiative ? $value->name_of_initiative : 'Unknown'}} </td>
                      <td> {{ $value->cash > -1 ? $value->cash : 'N/A'}} </td>

                      @if($value->ev_cash)
                      <td><a href="{{URL::asset($value->ev_cash)}}" target="_blank"><i class="fa fa-download"> Download</i></a></td>
                      @elseif($value->ev_cash_url)
                      <td><a href="{{URL::to($value->ev_cash_url)}}" target="_blank"> Click Here</a></td>
                      @else
                      <td>N/A</td>
                      @endif


                      <td> {{ $value->people > -1 ? $value->people : 'N/A'}} </td>

                      @if($value->ev_people)
                      <td><a href="{{URL::asset($value->ev_people)}}" target="_blank"><i class="fa fa-download"> Download</i></a></td>
                      @elseif($value->ev_people_url)
                      <td><a href="{{URL::to($value->ev_people_url)}}" target="_blank">Click Here</a></td>
                      @else
                      <td>N/A</td>
                      @endif


                      <td> {{ $value->environment > -1 ? $value->environment : 'N/A'}} </td>

                      @if($value->ev_environment)
                      <td><a href="{{URL::asset($value->ev_environment)}}" target="_blank"><i class="fa fa-download"> Download</i></a></td>
                      @elseif($value->ev_environment_url)
                      <td><a href="{{URL::to($value->ev_environment_url)}}" target="_blank">Click Here</a></td>
                      @else
                      <td>N/A</td>
                      @endif


                      <td> {{ $value->hyperlocality ? $value->hyperlocality : 'N/A'}} </td>

                      @if($value->ev_hyperlocality)
                      <td><a href="{{URL::asset($value->ev_hyperlocality)}}" target="_blank"><i class="fa fa-download"> Download</i></a></td>
                      @elseif($value->ev_hyperlocality_url)
                      <td><a href="{{URL::to($value->ev_hyperlocality_url)}}" target="_blank"> Click Here</a></td>
                      @else
                      <td>N/A</td>
                      @endif



                      <td> {{ $value->sentiment > -1 ? $value->sentiment : 'N/A'}} </td>

                      @if($value->ev_sentiment)
                      <td><a href="{{URL::asset($value->ev_sentiment)}}" target="_blank"><i class="fa fa-download"> Download</i></a></td>
                      @elseif($value->ev_sentimemt_url)
                      <td><a href="{{URL::to($value->ev_sentiment_url)}}" target="_blank">Click Here</a></td>
                      @else
                      <td>N/A</td>
                      @endif

                      <td> {{ $value->other ? $value->other : 'N/A'}} </td>

                      @if($value->ev_other)
                      <td><a href="{{URL::asset($value->ev_other)}}" target="_blank"><i class="fa fa-download"> Download</i></a></td>
                      @elseif($value->ev_other_url)
                      <td><a href="{{URL::to($value->ev_other_url)}}" target="_blank">Click Here</a></td>
                      @else
                      <td>N/A</td>
                      @endif


                      <td> {{ $value->ser }} </td>
                      <td> {{ $value->social_impact }} </td>
                      <td> {{ $value->social_impact_asap_cap }} </td>
                      <td> {{ $value->added_value }} </td>
                      <td> {{ $value->environment_r }} </td>
                      <td> {{ $value->people_r }} </td>
                      <td> {{ $value->cash_r }} </td>

                      <td>
                        @if(Auth::user()->has_role('admin'))
                        <a href= "#" class="btn btn-primary btn-xs" title="Add Result" data-toggle="modal" data-target="#myModal{{$value->id}}">
                          <span class="glyphicon glyphicon glyphicon-plus"></span></a>
                          <div class="modal fade" id="myModal{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                  <h4 class="modal-title" id="myModalLabel">Add Result</h4>
                                </div>
                                <div class="modal-body">
                                  {{ Form::open(array('route' => array('contract.result',  $value->id))) }}

                                  <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">£</span>
                                    {{ Form::number('total_social_value', '' , array('class' => 'form-control', 'aria-describedby' => 'basic-addon1', 'required', 'step' => '0.01')) }}
                                    @if ($errors->has('total_social_value')) <p class="help-block">{{ $errors->first('total_social_value') }}</p> @endif
                                    <span class="input-group-btn">
                                      <button class="btn btn-default" type="button">Total Social Value created to date</button>
                                    </span>
                                  </div>
                                </br></br>

                                <div class="input-group">
                                  <span class="input-group-addon" id="basic-addon2">£</span>
                                  {{ Form::number('social_value_min_perc', '', array('class' => 'form-control', 'aria-describedby' => 'basic-addon2', 'required', 'step' => '0.01' )) }}
                                  @if ($errors->has('social_value_min_perc')) <p class="help-block">{{ $errors->first('social_value_min_perc') }}</p> @endif
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Social Value created to date - minimum % of target</button>
                                  </span>
                                </div>
                              </br></br>

                              <div class="input-group">
                                <span class="input-group-addon" id="basic-addon2">£</span>
                                {{ Form::number('social_value_hun_perc','', array('class' => 'form-control', 'aria-describedby' => 'basic-addon2', 'required', 'step' => '0.01')) }}
                                @if ($errors->has('social_value_hun_perc')) <p class="help-block">{{ $errors->first('social_value_hun_perc') }}</p> @endif
                                <span class="input-group-btn">
                                  <button class="btn btn-default" type="button">Social Value created to date - 100% of target</button>
                                </span>
                              </div>
                            </br></br>

                            <div class="input-group">
                              <span class="input-group-addon" id="basic-addon2">£</span>
                              {{ Form::number('social_value_forecast','', array('class' => 'form-control', 'aria-describedby' => 'basic-addon2', 'required', 'step' => '0.01')) }}
                              @if ($errors->has('social_value_forecast')) <p class="help-block">{{ $errors->first('social_value_forecast') }}</p> @endif
                              <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Social Value forecast end of contract</button>
                              </span>
                            </div>
                          </br></br>
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
                </td>


              </tr>
              @endforeach

            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>

      </div>
    </div><!-- /.box-body -->
  </div>
</div><!-- /.box -->
</div><!-- /.box -->
@endif
</section>
</div>



<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog custom-modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add Values</h4>
      </div>
      <div class="modal-body">
        @if (Session::has('message'))
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <strong> {{ Session::get('message') }}</strong>
        </div>
        @endif

        {{ Form::open(array('route' => array('wmfs.bid', $contract->id), 'method' => 'POST', 'files'=>true)) }}
        {{ Form::hidden('user_id', Auth::user()->id)}}

        <div class="row">
          <div class="col-lg-12">

            <div class="form-group">
              <label>Name of Initiative</label>
              {{ Form::text('name_of_initiative', '', array('class' => 'form-control', 'placeholder' => 'Name of Initiative', 'required')) }}
              @if ($errors->has('name_of_initiative'))  <p class="help-block" style="color:red">{{ $errors->first('name_of_initiative') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Current number of months into the contract(#)</label>
              {{ Form::text('no_of_months', '', array('class' => 'form-control', 'placeholder' => 'Number of months', 'required')) }}
              @if ($errors->has('no_of_months'))  <p class="help-block" style="color:red">{{ $errors->first('no_of_months') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Cash(£m)</label>
              {{ Form::text('cash', '', array('class' => 'form-control', 'placeholder' => 'Cash', 'required')) }}
              @if ($errors->has('cash'))  <p class="help-block" style="color:red">{{ $errors->first('cash') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Cash - Upload section to supply information to verify the information entered[File Types: pdf, doc, xls]<i>(Max upload size: 10MB)</i><label data-toggle="tooltip" data-placement="left" title="This may be an invoice for your services, a receipt for a cheque provided or a statement from a 3rd part or NGO demonstrating the services they have provided"><a href="#"><b>(?)</b></a></label></label>
              {{ Form::file('ev_cash') }}
              @if ($errors->has('ev_cash')) <p class="help-block" style="color:red">{{ $errors->first('ev_cash') }}</p> @endif
            </div>
            <div class="col-md-12 col-md-offset-5"> <b>OR</b> </div>
            <br><br>

            <div class="form-group">
              <label>Cash - Enter a URL to supply information to verify the information entered<i>(<b>Format:</b> http://www.yourdomain.com)</i><label data-toggle="tooltip" data-placement="left" title="This may be the website of the organisation that you have supported through your services, stating the financial contribution you have made or a link to a detailed breakdown of your donations"><a href="#">(?)</a></label></label>
              {{ Form::text('ev_cash_url', '', array('class' => 'form-control', 'placeholder' => 'Cash - Enter a URL to supply information to verify the information entered ')) }}
              @if ($errors->has('ev_cash_url')) <p class="help-block" style="color:red">{{ $errors->first('ev_cash_url') }}</p> @endif
            </div>


            <div class="form-group">
              <label>People(#m)</label>
              {{ Form::text('people', '', array('class' => 'form-control', 'placeholder' => 'People', 'required')) }}
              @if ($errors->has('people'))  <p class="help-block" style="color:red">{{ $errors->first('people') }}</p> @endif
            </div>


            <div class="form-group">
              <label>People - Upload section to supply information to verify the information entered[File Types: pdf, doc, xls]<i>(Max upload size: 10MB)</i> <label data-toggle="tooltip" data-placement="left" title="This may be a copy of a letter of thanks that you have received from an organisation, press reports etc"><a href="#">(?)</a></label></label>
              {{ Form::file('ev_people') }}
              @if ($errors->has('ev_people'))  <p class="help-block" style="color:red">{{ $errors->first('ev_people') }}</p> @endif
            </div>

            <div class="col-md-12 col-md-offset-5"> <b>OR</b> </div>
            <br><br>

            <div class="form-group">
              <label>People - Enter a URL to supply information to verify the information entered<i>(<b>Format:</b> http://www.yourdomain.com)</i><label data-toggle="tooltip" data-placement="left" title="This may be the website of the organisation that you have supported through your services, stating how many people attended the event or a link to news reports or similar"><a href="#">(?)</a></label></label>
              {{ Form::text('ev_people_url', '', array('class' => 'form-control', 'placeholder' => 'People - Enter a URL to supply information to verify the information entered')) }}
              @if ($errors->has('ev_people_url'))  <p class="help-block" style="color:red">{{ $errors->first('ev_people_url') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Environment(tCO2e)</label>
              {{ Form::text('environment', '', array('class' => 'form-control', 'placeholder' => 'Environment', 'required')) }}
              @if ($errors->has('environment')) <p class="help-block" style="color:red">{{ $errors->first('environment') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Environment - Upload section to supply information to verify the information entered[File Types: pdf, doc, xls]<i>(Max upload size: 10MB)</i><label data-toggle="tooltip" data-placement="left" title="Most recent audited accounts in the public domain, publicly available progress reports or similar"><a href="#">(?)</a></label></label>
              {{ Form::file('ev_environment') }}
              @if ($errors->has('ev_environment'))  <p class="help-block" style="color:red">{{ $errors->first('ev_environment') }}</p> @endif
            </div>

            <div class="col-md-12 col-md-offset-5"> <b>OR</b> </div>
            <br><br>

            <div class="form-group">
              <label>Environment - Enter a URL to supply information to verify the information entered<i>(<b>Format:</b> http://www.yourdomain.com)</i><label data-toggle="tooltip" data-placement="left" title="This may be a link to your CSR contribution website page or a national reporting website"><a href="#">(?)</a></label></label>
              {{ Form::text('ev_environment_url', '', array('class' => 'form-control', 'placeholder' => 'Environment - Enter a URL to supply information to verify the information entered')) }}
              @if ($errors->has('ev_environment_url'))  <p class="help-block" style="color:red">{{ $errors->first('ev_environment_url') }}</p> @endif
            </div>


            <div class="form-group">
              <label>Distance between Intervention and Target Epicentre (km)?</label>
              {{ Form::text('hyperlocality', '', array('class' => 'form-control', 'placeholder' => 'Hyperlocality', 'required')) }}
              @if ($errors->has('hyperlocality'))  <p class="help-block" style="color:red">{{ $errors->first('hyperlocality') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Hyperlocality - Upload section to supply information to verify the information entered[File Types: pdf, doc, xls]<i>(Max upload size: 10MB)</i><label data-toggle="tooltip" data-placement="left" title="This may include Grant documents, letters or feedback from recipients. Looking for the radius (mileage) of impact"><a href="#">(?)</a></label></label>
              {{ Form::file('ev_hyperlocality') }}
              @if ($errors->has('ev_hyperlocality'))  <p class="help-block" style="color:red">{{ $errors->first('ev_hyperlocality') }}</p> @endif
            </div>

            <div class="col-md-12 col-md-offset-5"> <b>OR</b> </div>
            <br><br>

            <div class="form-group">
              <label>Hyperlocality - Enter a URL to supply information to verify the information entered<i>(<b>Format:</b> http://www.yourdomain.com)</i><label data-toggle="tooltip" data-placement="left" title="This information may be found on your website or on the website of your beneficiaries. Looking for the radius (mileage) of impact"><a href="#">(?)</a></label></label>
              {{ Form::text('ev_hyperlocality_url', '', array('class' => 'form-control', 'placeholder' => 'Hyperlocality - Enter a URL to supply information to verify the information entered')) }}
              @if ($errors->has('ev_hyperlocality_url'))  <p class="help-block" style="color:red">{{ $errors->first('ev_hyperlocality_url') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Sentiment(%)</label>
              {{ Form::text('sentiment', '', array('class' => 'form-control', 'placeholder' => 'Sentiment', 'required')) }}
              @if ($errors->has('sentiment'))  <p class="help-block" style="color:red">{{ $errors->first('sentiment') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Target Population</label>
              {{ Form::text('target_population', '', array('class' => 'form-control', 'placeholder' => 'Target Population', 'required')) }}
              @if ($errors->has('target_population'))  <p class="help-block" style="color:red">{{ $errors->first('target_population') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Sample Size</label>
              {{ Form::text('sample_size', '', array('class' => 'form-control', 'placeholder' => 'Sample Size', 'required')) }}
              @if ($errors->has('sample_size'))  <p class="help-block" style="color:red">{{ $errors->first('sample_size') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Margin of errors (%)</label>
              {{ Form::text('margin_errors', '', array('class' => 'form-control', 'type'=>'number', 'min' => '0', 'max'=> '100', 'placeholder' => 'Margin of errors', 'required')) }}
              @if ($errors->has('margin_errors'))  <p class="help-block" style="color:red">{{ $errors->first('margin_errors') }}</p> @endif
            </div>

            <div class="form-group">
              <label>Sentiment - Upload section to supply information to verify the information entered[File Types: pdf, doc, xls]<i>(Max upload size: 10MB)</i><label data-toggle="tooltip" data-placement="left" title="This may be surveys completed by the users of the service you have provided or from organiser conducted surveys"><a href="#">(?)</a></label></label>
              {{ Form::file('ev_sentiment') }}
              @if ($errors->has('ev_sentiment'))  <p class="help-block" style="color:red">{{ $errors->first('ev_sentiment') }}</p> @endif
            </div>

            <div class="col-md-12 col-md-offset-5"> <b>OR</b> </div>
            <br><br>

            <div class="form-group">
              <label>Sentiment - Enter a URL to supply information to verify the information entered<i>(<b>Format:</b> http://www.yourdomain.com)</i><label data-toggle="tooltip" data-placement="left" title="This may be an online survey website showing the data or recipients websites.  Could also link from National Sentiment Sites such as Social Mention"><a href="#">(?)</a></label></label>
              {{ Form::text('ev_sentiment_url', '', array('class' => 'form-control', 'placeholder' => 'Sentiment - Enter a URL to supply information to verify the information entered')) }}
              @if ($errors->has('ev_sentiment_url'))  <p class="help-block" style="color:red">{{ $errors->first('ev_sentiment_url') }}</p> @endif
            </div>


            <div class="form-group">
              <label>Other Information<label data-toggle="tooltip" data-placement="left" title="Please provide any other information you feel is relevant to the social value or impact of your contract SV contractual obligations"><a href="#">(?)</a></label></label>
              {{ Form::text('other', '', array('class' => 'form-control', 'placeholder' => 'Other', 'required')) }}
              @if ($errors->has('other'))  <p class="help-block" style="color:red">{{ $errors->first('other') }}</p> @endif
            </div>
            <div class="form-group">
              <label>Other - Upload section to supply information to verify the information entered[File Types: pdf, doc, xls]<i>(Max upload size: 10MB)</i></label>
              {{ Form::file('ev_other') }}
              @if ($errors->has('ev_other')) <p class="help-block" style="color:red">{{ $errors->first('ev_other') }}</p> @endif
            </div>

            <div class="col-md-12 col-md-offset-5"> <b>OR</b> </div>
            <br><br>

            <div class="form-group">
              <label>Other - Enter a URL to supply information to verify the information entered<i>(<b>Format:</b> http://www.yourdomain.com)</i></label>
              {{ Form::text('ev_other_url', '', array('class' => 'form-control', 'placeholder' => 'Other - Enter a URL to supply information to verify the information entered')) }}
              @if ($errors->has('ev_other_url')) <p class="help-block" style="color:red">{{ $errors->first('ev_other_url') }}</p> @endif
            </div>

          </div>

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

<!-- add new calendar event modal -->
@stop
@section('scripts')

<!-- page script -->
<script type="text/javascript">
$(function() {
  $("#example1").dataTable();
});
</script>


@if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
<script type="text/javascript">
$(function() {
  $('#myModal').modal('show');
});
</script>
@elseif(!empty(Session::get('success_code')) && Session::get('success_code') == 1)
<script type="text/javascript">
$(function() {
  $('#myModal').modal('show');
});
</script>
@endif

</script>
@stop
