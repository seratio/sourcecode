@extends('layout.dashboard_default')
@section('title')
@if(Auth::user()->has_role('CUSWM001'))
Seratio::WMFS
@elseif(Auth::user()->has_role('CUSWC002'))
Seratio::WCC
@elseif(Auth::user()->has_role('CUSBN003'))
Seratio::B&amp;NESC
@elseif(Auth::user()->has_role('CUSEC004'))
Seratio::EC
@elseif(Auth::user()->has_role('CUSSC005'))
Seratio::SCC
@elseif(Auth::user()->has_role('CUSBS006'))
Seratio::B&amp;SUH
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
      @if(Auth::user()->has_role('CUSWM001'))
      Welcome to the WMFS dashboard
      @elseif(Auth::user()->has_role('CUSWC002'))
      Welcome to the WCC dashboard
      @elseif(Auth::user()->has_role('CUSBN003'))
      Welcome to the B&amp;NESC dashboard
      @elseif(Auth::user()->has_role('CUSEC004'))
      Welcome to the EC  dashboard
      @elseif(Auth::user()->has_role('CUSSC005'))
      Welcome to the SCC dashboard
      @elseif(Auth::user()->has_role('CUSBS006'))
      Welcome to the B&amp;SUH dashboard
      @elseif(Auth::user()->has_role('CUSCB007'))
      Welcome to the CBC dashboard
      @elseif(Auth::user()->has_role('CUSHC008'))
      Welcome to the HC dashboard
      @elseif(Auth::user()->has_role('CUSHC009'))
      Welcome to the HC dashboard
      @elsif(Auth::user()->has_role('CUSWF010'))
      Welcome to the WFC dashboard
      @elseif(Auth::user()->has_role('CUSCL011'))
      Welcome to the COL dashboard
      @elseif(Auth::user()->has_role('CUSWU012'))
      Welcome to the WU dashboard
      @elseif(Auth::user()->has_role('CUSWD013'))
      Welcome to the WD dashboard
      @elseif( Auth::user()->has_role('CUSNM014'))
      Welcome to the NMUH dashboard
      @endif
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
      @if (Session::has('message'))
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong> {{ Session::get('message') }}</strong>
      </div>
      @endif
      <!-- Map box -->
      <div class="box box-solid collapsed-box">
        <div class="box-header">
          <!-- tools box -->
          <div class="pull-right box-tools">
            <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
          </div>
          <!-- /. tools -->
          <i class="fa fa-bars"></i>
          <h3 class="box-title">
            Contracts
          </h3>
        </div>
        <div class="box-body" style="display:none;overflow:scroll;" >
          <div id="content" style="width: 100%; height: 510px;">
            @if ($contracts->count() > 0)
            <div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <strong> Please find below all listed contracts, you can view each of the contract details by pressing the green symbol in the action column</strong>
            </div>
            @endif
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Tender</th>
                    <th>Date Started</th>
                    <th>End Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($contracts as $contract)
                  <tr>
                    <td>{{ $contract->contract_name ? $contract->contract_name :'N/A' }} </td>
                    <td>{{ $contract->public_sector_organisation ? $contract->public_sector_organisation :'N/A' }} </td>
                    <td>{{ $contract->date_start ? date('d-m-Y H:i:s', strtotime($contract->date_start)) :'N/A' }} </td>
                    <td>{{ $contract->end_date ? date ('d-m-Y H:i:s', strtotime($contract->end_date)) :'N/A' }} </td>
                    <td>
                      @if((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||
                      Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') || Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
                      Auth::user()->has_subrole('customer'))
                      <a href= "{{URL::route('customer.show',['$id'=>$contract->id])}}" class="btn btn-success btn-xs" title="View Contract Info">
                        <span class="glyphicon glyphicon-eye-open"></span></a>
                        {{ Form::open(array('route' => array('customer.destroy', $contract->id), 'method' => 'delete', 'onsubmit' => 'return confirmDelete()')) }}
                        <button type="submit" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus-sign"></span></button>
                        {{ Form::close() }}
                        <!-- <a data-method="delete" data-confirm="Are you sure?" class="btn btn-danger btn-xs" href="{{ route('customer.destroy', ['id' => $contract->id]) }}" title="Delete Contract Info">
                          <span class="glyphicon glyphicon-minus-sign"></span>
                        </a> -->
                        @elseif((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') ||
                        Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') || Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') || Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
                        Auth::user()->has_subrole('supplier'))
                        <a href= "{{URL::route('customer.show',['$id'=>$contract->id])}}" class="btn btn-success btn-xs" title="View Contract Info">
                          <span class="glyphicon glyphicon-eye-open"></span></a>
                          @elseif(Auth::user()->has_role('admin'))
                          <a href= "{{URL::route('customer.show',['$id'=>$contract->id])}}" class="btn btn-success btn-xs" title="View Contract Info">
                            <span class="glyphicon glyphicon-eye-open"></span></a>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                      </tfoot>
                    </table>
                  </div>
                  <!-- /.box-body -->
                </div>
              </div>
              <!-- /.box-body-->
            </div>
            <!-- Map box -->
            <div class="box box-solid collapsed-box">
              <div class="box-header">
                <!-- tools box -->
                <div class="pull-right box-tools">
                  <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                </div>
                <!-- /. tools -->
                <i class="fa fa-bar-chart-o"></i>
                <h3 class="box-title">
                  Compliance
                </h3>
              </div>
              <div class="box-body" style="display:none;overflow:scroll;">
                <div class="col-lg-12">
                  <div class="col-lg-12">
                    <div class="col-lg-6">
                      <h3>KNOWLEDGE BASE </h3>
                      <p align="justify">Submit your response towards your understanding. Lighter the colour better the understanding</p>
                      {{ Form::open(array('route' => array('wmfs.knowledge', Auth::user()->id))) }}
                      {{ Form::submit('1', array('class' => 'btn btn-circle', 'style' => 'background-color: #293d3d;', 'name' => 'compl')) }}
                      {{ Form::submit('2', array('class' => 'btn btn-circle', 'style' => 'background-color: #5c8a8a;', 'name' => 'compl')) }}
                      {{ Form::submit('3', array('class' => 'btn btn-circle', 'style' => 'background-color: #a3c2c2;', 'name' => 'compl')) }}
                      {{Form::close()}}
                    </div>
                    <div class="col-lg-6">
                      <div class="pull-right">
                        <h3>YOUR RESPONSE </h3>
                        @if($user->compl == "1")
                        <button type="button" class="btn btn-circle" style="background-color: #293d3d;"></button>
                        @elseif($user->compl == "2")
                        <button type="button" class="btn btn-circle" style="background-color: #5c8a8a;"></button>
                        @elseif($user->compl == "3")
                        <button type="button" class="btn btn-circle" style="background-color: #a3c2c2;"></button>
                        @else
                        <td></td>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <h3>COMPLIANCE </h3>
                  <div id="light">
                    @if($compliance->compliance_rag == 'Red')
                    <span class="active" id="red"></span>
                    <span id="orange"></span>
                    <span id="green"></span>
                    @elseif($compliance->compliance_rag == 'Amber')
                    <span id="red"></span>
                    <span class="active" id="orange"></span>
                    <span id="green"></span>
                    @elseif($compliance->compliance_rag == 'Green')
                    <span id="red"></span>
                    <span id="orange"></span>
                    <span class="active" id="green"></span>
                    @else
                    <span id="red"></span>
                    <span id="orange"></span>
                    <span id="green"></span>
                    @endif
                  </div>
                  <br>
                </div>
                <div id="content" style="width: 100%; height: 2000px;">
                  <table class="table table-bordered">
                    <tr>
                      <th bgcolor="green" style="color:white;font-weight:bold">Assessment</th>
                      <th bgcolor="green" style="color:white;font-weight:bold">Comment</th>
                      <th bgcolor="green" style="color:white;font-weight:bold">RAG</th>
                    </tr>
                    <tr>
                      <td> </td>
                      <td> </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td> Environment</td>
                      <td>{{$compliance->environment}} </td>
                      @if($compliance->environment_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->environment_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->environment_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Cash</td>
                      <td> {{$compliance->cash}}</td>
                      @if($compliance->cash_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->cash_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->cash_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> People</td>
                      <td> {{$compliance->people}}</td>
                      @if($compliance->people_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->people_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->people_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Tax Avoidance</td>
                      <td>{{$compliance->tax_avoidance}} </td>
                      @if($compliance->tax_avoidance_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->tax_avoidance_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->tax_avoidance_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Pay Disparity</td>
                      <td> {{$compliance->pay_disparity}}</td>
                      @if($compliance->pay_disparity_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->pay_disparity_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->pay_disparity_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Personal Value</td>
                      <td>{{$compliance->personal_value}} </td>
                      @if($compliance->personal_value_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->personal_value_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->personal_value_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Transparency in Supply Chain</td>
                      <td> {{$compliance->transpareny_in_supply_chain}} </td>
                      @if($compliance->transpareny_in_supply_chain_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->transpareny_in_supply_chain_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->transpareny_in_supply_chain_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Sentiment/Feedback</td>
                      <td> {{$compliance->sentiment}} </td>
                      @if($compliance->sentiment_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->sentiment_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->sentiment_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Hyperlocality</td>
                      <td> {{$compliance->hyperlocality}} </td>
                      @if($compliance->hyperlocality_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->hyperlocality_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->hyperlocality_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Forward Forecasting</td>
                      <td> {{$compliance->forward_forecasting}}</td>
                      @if($compliance->forward_forecasting_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->forward_forecasting_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->forward_forecasting_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Time Dependant Monitoring</td>
                      <td> {{$compliance->time_dependent_monitoring}}</td>
                      @if($compliance->time_dependent_monitoring_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->time_dependent_monitoring_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->time_dependent_monitoring_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Financial Value</td>
                      <td>{{$compliance->financial_value}} </td>
                      @if($compliance->financial_value_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->financial_value_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->financial_value_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Benchmarking</td>
                      <td> {{$compliance->benchmarking}}</td>
                      @if($compliance->benchmarking_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->benchmarking_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->benchmarking_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> </td>
                      <td> </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <th bgcolor="green" style="color:white;font-weight:bold">Compliance</th>
                      <th bgcolor="green" style="color:white;font-weight:bold">Comment</th>
                      <th bgcolor="green" style="color:white;font-weight:bold">RAG</th>
                    </tr>
                    <tr>
                      <td> </td>
                      <td> </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td> Social Value Act</td>
                      <td> {{$compliance->social_value_act}}</td>
                      @if($compliance->social_value_act_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->social_value_act_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->social_value_act_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Modern Slavery Act</td>
                      <td> {{$compliance->modern_slavery_act}}</td>
                      @if($compliance->modern_slavery_act_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->modern_slavery_act_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->modern_slavery_act_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> ISO 26000</td>
                      <td>{{$compliance->iso26000}} </td>
                      @if($compliance->iso26000_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->iso26000_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->iso26000_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> GRI-4</td>
                      <td> {{$compliance->gri_4}} </td>
                      @if($compliance->gri4_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->gri4_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->gri4_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> IIRC</td>
                      <td> {{$compliance->iirc}}</td>
                      @if($compliance->iirc_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->iirc_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->iirc_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Benefit Coro</td>
                      <td>{{$compliance->benefit_coro}} </td>
                      @if($compliance->benefit_coro_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->benefit_coro_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->benefit_coro_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> WEF</td>
                      <td> {{$compliance->wef}}</td>
                      @if($compliance->wef_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->benefit_coro_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->benefit_coro_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> EU 500+CSR</td>
                      <td> {{$compliance->wu_500_csr}}</td>
                      @if($compliance->wu_500_csr_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->wu_500_csr_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->wu_500_csr_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> GECES</td>
                      <td>{{$compliance->geces}} </td>
                      @if($compliance->geces_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->geces_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->geces_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> SI 20%</td>
                      <td> {{$compliance->si}}</td>
                      @if($compliance->si_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->si_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->si_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Litigation Liability</td>
                      <td>{{$compliance->litigation_liability}} </td>
                      @if($compliance->litigation_liability_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->litigation_liability_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->litigation_liability_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> </td>
                      <td> </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <th bgcolor="green" style="color:white;font-weight:bold">Framework</th>
                      <th bgcolor="green" style="color:white;font-weight:bold">Comment</th>
                      <th bgcolor="green" style="color:white;font-weight:bold">RAG</th>
                    </tr>
                    <tr>
                      <td> </td>
                      <td> </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td> Monthly Reporting</td>
                      <td> {{$compliance->monthly_reporting}} </td>
                      @if($compliance->monthly_reporting_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->monthly_reporting_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->monthly_reporting_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Independent Arbitration</td>
                      <td> {{$compliance->independent_arbitration}} </td>
                      @if($compliance->independent_arbitration_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->independent_arbitration_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->independent_arbitration_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Dashboard Provision</td>
                      <td> {{$compliance->dashboard_provision}} </td>
                      @if($compliance->dashboard_provision_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->dashboard_provision_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->dashboard_provision_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td>Capacity Development (online) - MOOC</td>
                      <td> {{$compliance->capacity_development_online}} </td>
                      @if($compliance->capacity_development_online_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->capacity_development_online_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->capacity_development_online_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Capacity Development (face2face) - Conferences</td>
                      <td> {{$compliance->capacity_development_face}} </td>
                      @if($compliance->capacity_development_face_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->capacity_development_face_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->capacity_development_face_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Capacity Development (written) - Journal</td>
                      <td> {{$compliance->capacity_development_written}} </td>
                      @if($compliance->capacity_development_written_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->capacity_development_written_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->capacity_development_written_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Engagement - Collaborative Mapping (GIS)</td>
                      <td> {{$compliance->engagement}} </td>
                      @if($compliance->engagement_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->engagement_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->engagement_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Solutions - Participatory Planning (Acupuncture)</td>
                      <td> {{$compliance->solutions}} </td>
                      @if($compliance->solutions_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->solutions_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->solutions_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td> Ideation</td>
                      <td> {{$compliance->ideation}} </td>
                      @if($compliance->ideation_rag == "Green")
                      <td style="background-color:green;"></td>
                      @elseif($compliance->ideation_rag == "Amber")
                      <td style="background-color:#ffc200;"></td>
                      @elseif($compliance->ideation_rag == "Red")
                      <td style="background-color:red;"></td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                  </table>
                </div>
                <!-- /.box-body-->
              </div>
              <!-- /.box-body-->
            </div>
            @if(Auth::user()->has_role('CUSWM001'))
            <div class="box box-solid collapsed-box">
              <div class="box-header">
                <!-- tools box -->
                <div class="pull-right box-tools">
                  <button onclick="var ifr=document.getElementsByName('map')[0]; ifr.src=ifr.src;" class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                </div>
                <!-- /. tools -->
                <i class="fa  fa-map-marker"></i>
                <h3 class="box-title">
                  Collaborative Mapping
                </h3>
              </div>
              <div class="box-body" style="display:none;overflow:scroll;">
                <div class="overlay-map" onClick="style.pointerEvents='none'"></div>
                <iframe name="map" src="https://www.google.com/maps/d/u/0/embed?mid=zMxTY8WYoRAQ.k-90z9BEJ2rM&ll=52.4840604,-1.8777567&z=9" width="1020" height="600"></iframe>
              </div>
              <!-- /.box-body-->
            </div>
            <div class="box box-solid collapsed-box">
              <div class="box-header">
                <!-- tools box -->
                <div class="pull-right box-tools">
                  <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                </div>
                <!-- /. tools -->
                <i class="fa fa-map-marker"></i>
                <h3 class="box-title">
                  Hyperlocality
                </h3>
              </div>
              <div class="box-body" style="display:none;overflow:scroll;">
                <div id="content" style="width: 100%; height: 3600px;">
                  <table class="table table-bordered">
                    <tr>
                      <th bgcolor="green" style="color:white;font-weight:bold">Headquarters with 4 mile radius against ARM Q4 data</th>
                    </tr>
                    <tr>
                      <td>
                        <p class="justify">The map below displays WMFS Headquarters with a radius of 4 miles against the Area Risk Map (ARM) for Q4.
                          The ARM calls are represented by the red pins in the map below, and demonstrates where all the emergency calls were made in 2014 Q4.
                          The yellow symbols are from WMFS projects within the community to identify the impact they may have had on the surrounding areas.
                        </p>
                        {{ HTML::image('assets/img/HQ.png' ,'', array('width' => '1200', 'height' =>'400')) }}
                      </td>
                    </tr>
                    <tr>
                      <th bgcolor="green" style="color:white;font-weight:bold">West Midlands Fire stations with 4 mile radius</th>
                    </tr>
                    <tr>
                      <td>
                        <p class="justify">The map below displays the locations of WMFS fire stations, represented here as flames.
                          Each station has a 4 mile impact radius around it.
                          The smaller the circle on the radius, the stronger the impact opportunity is.
                        </p>
                        {{ HTML::image('assets/img/FS1.png','', array('width' => '1200', 'height' =>'400')) }}
                      </td>
                    </tr>
                    <tr>
                      <th bgcolor="green" style="color:white;font-weight:bold">West Midlands Fire stations against ARM Q4 data</th>
                    </tr>
                    <tr>
                      <td>
                        <p class="justify">The map below displays the calls from the ARM report in Q4 2014 against the 4 mile radius of each WMFS fire station.
                          The ARM reported calls are represented by red pins.
                        </p>
                        {{ HTML::image('assets/img/FS2.png','', array('width' => '1200', 'height' =>'400')) }}
                      </td>
                    </tr>
                    <tr>
                      <th bgcolor="green" style="color:white;font-weight:bold">Project outcomes with 4 mile radius</th>
                    </tr>
                    <tr>
                      <td>
                        <p class="justify">The map below displays the locations of the community projects WMFS have provided the local community, they are represented here as green pins.
                          Each project is accompanied with a 4 mile radius.The smaller the circle on the raius, the stronger the impact opportunity is.
                        </p>
                        {{ HTML::image('assets/img/PO1.png','', array('width' => '1200', 'height' =>'400'))}}
                      </td>
                    </tr>
                    <tr>
                      <th bgcolor="green" style="color:white;font-weight:bold">Project outcomes against ARM Q4 data.</th>
                    </tr>
                    <tr>
                      <td>
                        <p class="justify">The map below displays the the locations of the community projects provided by WMFS, with a 4 mile impact radius and the ARM reported calls that WMFS received in Q4 2014.
                          This map shows the missied impact opportunities within the service area.
                        </p>
                        {{ HTML::image('assets/img/PO2.png','', array('width' => '1200', 'height' =>'400')) }}
                      </td>
                    </tr>
                    <tr>
                      <th bgcolor="green" style="color:white;font-weight:bold">Third Sector Partners with 4 mile radius</th>
                    </tr>
                    <tr>
                      <td>
                        <p class="justify">The map below display the locations of WMFS 3rd sector partners and a 4 mile impact radius. The smaller the circle on the raius, the stronger the impact opportunity is.</p>
                        {{ HTML::image('assets/img/TP1.png','', array('width' => '1200', 'height' =>'400')) }}
                      </td>
                    </tr>
                    <tr>
                      <th bgcolor="green" style="color:white;font-weight:bold">Third Sector Partners against ARM Q4 data</th>
                    </tr>
                    <tr>
                      <td>
                        <p class="justify">The map below shows the locations of WMFS 3rd sector partners, the 4 mile impact radius with the calls taken from the ARM report for Q4 2014. This demonstrates the areas the 3rd sector partners will have the most impact, and where thre is a need for the reources to be focused on next.</p>
                        {{ HTML::image('assets/img/TP2.png','', array('width' => '1200', 'height' =>'400')) }}
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            @endif
            <div class="box box-solid collapsed-box">
              <div class="box-header">
                <!-- tools box -->
                <div class="pull-right box-tools">
                  <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                </div>
                <!-- /. tools -->
                <i class="fa fa-dashboard"></i>
                <h3 class="box-title">
                  Social Earnings Analysis
                </h3>
              </div>
              <div class="box-body" style="display:none;overflow:scroll;">
                <div class="box-body table-responsive" style="overflow: scroll;">
                  <table id="wmfs" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Measured Year</th>
                        <th>SER</th>
                        <th>Social Impact</th>
                        <th>Social Impact as a Percentage of Capitilisation </th>
                        <th>Added Value</th>
                        <th>Environment(%)</th>
                        <th>People(%)</th>
                        <th>Cash(%)</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($wmfs as $wmfs)
                      <tr>
                        <td>{{ $wmfs->measured_year ? $wmfs->measured_year : 'N/A'}} </td>
                        <td>{{ $wmfs->ser ? $wmfs->ser : 'N/A' }}</td>
                        <td>{{ $wmfs->social_impact ? $wmfs->social_impact : 'N/A'}}</td>
                        <td>{{ $wmfs->social_impact_asap_cap ? $wmfs->social_impact_asap_cap : 'N/A'}}
                          <td>{{ $wmfs->added_value ? $wmfs->added_value : 'N/A'}}</td>
                          <td>{{ $wmfs->environment ? $wmfs->environment : 'N/A'}}</td>
                          <td>{{ $wmfs->people_r ? $wmfs->people_r : 'N/A'}}</td>
                          <td>{{ $wmfs->cash ? $wmfs->cash : 'N/A'}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                      </tfoot>
                    </table>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box-body-->
              </div>
              <div class="box box-solid collapsed-box">
                <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button id="piechart" class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title">
                    Chart of Social Impact in £
                  </h3>
                </div>
                <div class="box-body" style="display:none;overflow:scroll;">
                  <p align="justify">This chart represents the current social value investments created by category</p>
                  <div id="year_picker"></div>
                  <div id="piechart_3d" style="width: 110%; height: 500px;"></div>
                </div>
                <!-- /.box-body-->
              </div>
              @if(Auth::user()->has_role('CUSWM001'))
              <div class="box box-solid collapsed-box">
                <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa fa-th-list"></i>
                  <h3 class="box-title">
                    Learning Tender
                  </h3>
                </div>
                <div class="box-body" style="display:none;overflow:scroll;">
                  <div id="content" style="width: 100%; height: 510px;">
                    <div class="table-responsive" style="overflow: scroll;">
                      <table id="tenders" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Contract Name</th>
                            <th>Estimated Price</th>
                            <th>Tender</th>
                            <th>Social Value Act</th>
                            <th>Modern Slavery Act</th>
                            <th>Contract Value(£)</th>
                            <th>Added Social Value(£)</th>
                            <th>People</th>
                            <th>Cash</th>
                            <th>Environment</th>
                            <th>Hyperlocality</th>
                            <th>Pay Disparity</th>
                            <th>Tax Avoidance</th>
                            <th>Social Value as a % of Contract Value</th>
                            <th>KPI 1</th>
                            <th>KPI 2</th>
                            <th>Final Score</th>
                            <th>Price Scoring</th>
                            <th>Quality Scoring</th>
                            <th>Social Value Scoring</th>
                            <th>Actions</th>
                          </tr>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($tenders as $tender)
                        <tr>
                          <td>{{ $tender->contract_name ? $tender->contract_name : 'N/A'}}</td>
                          <td>{{ $tender->estimated_price ? $tender->estimated_price : 'N/A' }}</td>
                          <td>{{ $tender->tender ? $tender->tender : 'N/A' }}</td>
                          @if($tender->social_value_act == "Green")
                          <td style="background-color:green;"></td>
                          @elseif($tender->social_value_act == "Amber")
                          <td style="background-color:#ffc200;"></td>
                          @elseif($tender->social_value_act == "Red")
                          <td style="background-color:red;"></td>
                          @else
                          <td></td>
                          @endif
                          @if($tender->modern_slavery_act == "Green")
                          <td style="background-color:green;"></td>
                          @elseif($tender->modern_slavery_act == "Amber")
                          <td style="background-color:#ffc200;"></td>
                          @elseif($tender->modern_slavery_act == "Red")
                          <td style="background-color:red;"></td>
                          @else
                          <td></td>
                          @endif
                          <td>{{ $tender->contract_value ? $tender->contract_value : 'N/A' }}</td>
                          <td>{{ $tender->added_social_value ? $tender->added_social_value : 'N/A' }}</td>
                          <td>{{ $tender->people ? $tender->people : 'N/A' }}</td>
                          <td>{{ $tender->cash ? $tender->cash : 'N/A' }}</td>
                          <td>{{ $tender->environment ? $tender->environment : 'N/A' }}</td>
                          <td>{{ $tender->hyperlocality ? $tender->hyperlocality : 'N/A' }}</td>
                          <td>{{ $tender->pay_disparity ? $tender->pay_disparity : 'N/A' }}</td>
                          <td>{{ $tender->tax_avoidance ? $tender->tax_avoidance : 'N/A' }}</td>
                          <td>{{ $tender->sv_as_perc_contract_value ? $tender->sv_as_perc_contract_value : 'N/A' }}</td>
                          <td>{{ $tender->kpi1 ? $tender->kpi1 : 'N/A' }}</td>
                          <td>{{ $tender->kpi2 ? $tender->kpi2 : 'N/A' }}</td>
                          <td>{{ $tender->final_score ? $tender->final_score : 'N/A' }}</td>
                          <td>{{ $tender->price_scoring ? $tender->price_scoring : 'N/A' }}</td>
                          <td>{{ $tender->quality_scoring ? $tender->quality_scoring : 'N/A' }}</td>
                          <td>{{ $tender->social_value_scoring ? $tender->social_value_scoring : 'N/A' }}</td>
                          <td>
                            <a data-method="delete" data-confirm="Are you sure?" class="btn btn-danger btn-xs" href="{{ route('tenders.destroy', ['id' => $tender->id]) }}" title="Delete Tender">
                              <span class="glyphicon glyphicon-minus-sign"></span>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    <!-- /.box-body -->
                  </div>
                </div>
                <!-- /.box-body-->
              </div>
              <div class="box box-solid collapsed-box">
                <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                  </div>
                  <!-- /. tools -->
                  <i class="fa fa-file-text"></i>
                  <h3 class="box-title">
                    Budget
                  </h3>
                </div>
                <div class="box-body" style="display:none;overflow:scroll;">
                  <div id="content" style="width: 100%; height: 850px;">
                    <table class="table table-bordered">
                      <tr>
                        <th bgcolor="green" style="color:white;font-weight:bold">WMFS Budgets - Non Statutory Spend</th>
                        <th bgcolor="green" style="color:white;font-weight:bold"> Budget</th>
                        <th bgcolor="green" style="color:white;font-weight:bold">Deficit</th>
                      </tr>
                      <th colspan="3" style="color:black;font-weight:bold">Non-Satutory Costs 2013-14</th>
                      <tr>
                      </tr>
                      <tr>
                        <td>Community Safety UK£m </td>
                        <td> 12.694</td>
                        <td> </td>
                      </tr>
                      <tr>
                        <td>Money leveraged for Community Fire Safety Engagement UK£m </td>
                        <td> 1.143</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Community Activity - # engagement </td>
                        <td> 259,753</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Service Users (m) </td>
                        <td> 2.70</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Procurement Budget UK£m </td>
                        <td> 10.8</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Social Value 20% of Procurement Budget </td>
                        <td> 0.00</td>
                        <td></td>
                      </tr>
                    </tr>
                    <th colspan="3" style="color:black;font-weight:bold">Non-Satutory Costs 2017-18</th>
                    <tr>
                    </tr>
                    <tr>
                      <td>Community Safety UK£m </td>
                      <td> 10.8</td>
                      <td style="color:red;">1.894 </td>
                    </tr>
                    <tr>
                      <td>Money leveraged for Community Fire Safety Engagement  </td>
                      <td> 0.97</td>
                      <td style="color:red;">0.173</td>
                    </tr>
                    <tr>
                      <th colspan="2" style="color:red;font-weight:bold;">Subtotal loss of budget</th>
                      <td style="color:red;font-weight:bold;">2.067</td>
                    </tr>
                    <tr>
                      <td>Community Activity - # engagement </td>
                      <td> 285,727</td>
                      <td>25,974</td>
                    </tr>
                    <tr>
                      <td>Service Users (m) </td>
                      <td> 2.89</td>
                      <td>0.19</td>
                    </tr>
                    <tr>
                      <td>Procurement Budget UK£m </td>
                      <td> 10.4</td>
                      <td>0.40</td>
                    </tr>
                    <tr>
                      <td style="color:green;font-weight:bold;">Social Value 20% of Procurement Budget </td>
                      <td style="color:green;font-weight:bold;"> 2.08</td>
                      <td style="color:green;font-weight:bold">0</td>
                    </tr>
                  </table>
                </br>
                <table class="table table-bordered">
                  <tr>
                    <th bgcolor="green" style="color:white;font-weight:bold">WMFS Total Budgets</th>
                    <th bgcolor="green" style="color:white;font-weight:bold"> Budget</th>
                    <th bgcolor="green" style="color:white;font-weight:bold">Deficit</th>
                  </tr>
                  <tr>
                    <td>Annual budget 2013-14 UK£m</td>
                    <td> 118.76</td>
                    <td> </td>
                  </tr>
                  <tr>
                    <td>Annual budget 2017-18 UK£m</td>
                    <td> 90</td>
                    <td style="color:red;font-weight:bold">28.76</td>
                  </tr>
                  <tr>
                    <td>Social Value Created UK£m </td>
                    <td> 28.19</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>Commercial Activities UK£m </td>
                    <td> 0.6</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td style="font-weight:bold">New Activities </td>
                    <td style="color:green;font-weight:bold"> 28.79</td>
                    <td style="color:green;font-weight:bold">0</td>
                  </tr>
                </table>
              </div>
            </div>
            <!-- /.box-body-->
          </div>
          @endif
          <div class="box box-solid collapsed-box">
            <div class="box-header">
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
              </div>
              <!-- /. tools -->
              <i class="fa  fa-check"></i>
              <h3 class="box-title">
                Benchmark
              </h3>
            </div>
            <div class="box-body" style="display:none;overflow:scroll;">
              <p align="justify">The dials below display the benchmark of the social earnings score and increased capitalization, this is based on data taken from information published in the public domain during the most recent financial year and is updated on an annual basis throughout the contract.</p>
              <div id="year_picker_gauge"></div>
              <div id="chart_div_ben" style="width: 150%; height: 500px;"></div>
            </div>
            <!-- /.box-body-->
          </div>
          <div class="box box-solid collapsed-box">
            <div class="box-header">
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
              </div>
              <!-- /. tools -->
              <i class="fa fa-bars"></i>
              <h3 class="box-title">
                Modern Slavery
              </h3>
            </div>
            <div class="box-body" style="display:none;overflow:scroll;">
              <div id="content" style="width: 100%; height: 510px;">
                <div class="alert alert-info alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong>The RAG results identify how well your company is complying to the Modern Slavery Act 2015 </strong>
                </div>
                <div class="box-body table-responsive">
                  <table id="mslavery" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Financial Year</th>
                        <th>Total Salary (£)</th>
                        <th>Total Staff (#)</th>
                        <th>Sentiment (%)</th>
                        <th>Created At</th>
                        <th>Result</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($modernSlavery as $value)
                      <tr>
                        <td>{{ $value->financial_year ? $value->financial_year :'N/A' }} </td>
                        <td>{{ $value->total_salary ? $value->total_salary :'N/A' }} </td>
                        <td>{{ $value->total_staff ? $value->total_staff :'N/A' }} </td>
                        <td>{{ $value->sentiment ? $value->sentiment :'N/A' }} </td>
                        <td>{{ $value->created_at ? date ('d-m-Y H:i:s', strtotime($value->created_at)) :'N/A' }} </td>
                        <td>
                          <div id="light">
                            @if($value->result > 2)
                            <span id="red"></span>
                            <span id="orange"></span>
                            <span class="active" id="green"></span>
                            @elseif($value->result >= 0.5 && $value->result <= 2)
                            <span id="red"></span>
                            <span class="active" id="orange"></span>
                            <span id="green"></span>
                            @elseif($value->result < 0.5)
                            <span class="active" id="red"></span>
                            <span id="orange"></span>
                            <span id="green"></span>
                            @else
                            <span id="red"></span>
                            <span id="orange"></span>
                            <span id="green"></span>
                            @endif
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
            </div>
            <!-- /.box-body-->
          </div>
        </section>
        <!-- /.Left col -->
      </div>
    </section>
  </div>

  <!-- /.right-side -->

  <!-- add new calendar event modal -->
  @stop
  @section('scripts')
  <script type="text/javascript">
  $(document).ready(function() {
    $("#test").click(function() {
      drawBasic();
    });

  });
</script>
<script type="text/javascript">
$(document).ready(function() {
  $("#piechart").click(function() {
    drawPie();
  });
});
</script>
@stop
@section('charts')
<script type="text/javascript">
var wmfsData = {{ json_encode($wmfsArray) }};

google.load('visualization', '1.0', {packages: ['corechart', 'bar']});
google.load('visualization', '1.0', {packages:['gauge']});
google.load("visualization", "1", {packages:["corechart"]});
google.load('visualization', '1.1', {packages: ['controls']});

google.setOnLoadCallback(drawChart);
google.setOnLoadCallback(drawPie);

function drawChart() {
  var gaugeData = [];
  var iCnt = 0;
  $.each(wmfsData, function () {
    if(parseInt(wmfsData[iCnt]['measured_year'])){
      gaugeData.push(["SER", parseFloat(wmfsData[iCnt]['ser']), parseInt(wmfsData[iCnt]['measured_year'])]);
      gaugeData.push(["% Capitalization", parseFloat(wmfsData[iCnt]['social_impact_asap_cap']), parseInt(wmfsData[iCnt]['measured_year'])]);
      iCnt += 1;
    }
  });
  var selectedYear = gaugeData[0]["2"] ? gaugeData[0]["2"]: 0;
  var data = new google.visualization.DataTable();
  data.addColumn('string', 'Label');
  data.addColumn('number', 'Value');
  data.addColumn('number', 'Year');
  data.addRows(gaugeData);

  var yearPicker = new google.visualization.ControlWrapper({
    'controlType': 'CategoryFilter',
    'containerId': 'year_picker_gauge',
    'options': {
      'filterColumnLabel': 'Year',
      'ui': {
        'labelStacking': 'vertical',
        'allowTyping': false,
        'allowMultiple': false,
        'allowNone': false
      }
    },
    'state': {
      selectedValues: [selectedYear]
    }
  });

  var GaugeChart = new google.visualization.ChartWrapper({
    'chartType': 'Gauge',
    'containerId': 'chart_div_ben',
    'options': {
      'width': 800,
      'height': 300,
      'minorTicks': 5
    },
    'view': {
      'columns': [0, 1]
    }
  });
  var dash = new google.visualization.Dashboard(document.getElementById('dashboard'));
  dash.bind(yearPicker, [GaugeChart]);
  dash.draw(data);
}


function drawPie() {
  var pieData = [];
  var iCnt = 0;
  $.each(wmfsData, function () {
    if(parseInt(wmfsData[iCnt]['measured_year'])){
      pieData.push(["Environment", parseFloat(wmfsData[iCnt]['enviornment_cal']), parseInt(wmfsData[iCnt]['measured_year'])]);
      pieData.push(["People", parseFloat(wmfsData[iCnt]['people_cal']), parseInt(wmfsData[iCnt]['measured_year'])]);
      pieData.push(["Cash", parseFloat(wmfsData[iCnt]['cash_gen_invested']), parseInt(wmfsData[iCnt]['measured_year'])]);
      iCnt += 1;
    }
  });
  var selectedYear = pieData[0]["2"] ? pieData[0]["2"]: 0;
  var data = new google.visualization.DataTable();
  data.addColumn('string', 'Label');
  data.addColumn('number', 'Value');
  data.addColumn('number', 'Year');
  data.addRows(pieData);

  var yearPicker = new google.visualization.ControlWrapper({
    'controlType': 'CategoryFilter',
    'containerId': 'year_picker',
    'options': {
      'filterColumnLabel': 'Year',
      'ui': {
        'labelStacking': 'vertical',
        'allowTyping': false,
        'allowMultiple': false,
        'allowNone': false
      }
    },
    'state': {
      selectedValues: [selectedYear]
    }
  });

  var pieChartA = new google.visualization.ChartWrapper({
    'chartType': 'PieChart',
    'containerId': 'piechart_3d',
    'options': {
      'is3D': true,
      'sliceVisibilityThreshold':0,
    },
    'legend': {
      'position': 'labeled',
      'labeledValueText': 'both',

    },
    'view': {
      'columns': [0, 1]
    }
  });
  var dash = new google.visualization.Dashboard(document.getElementById('dashboard'));
  dash.bind(yearPicker, [pieChartA]);
  dash.draw(data);
}
</script>
<!-- page script -->
<script type="text/javascript">
$(function() {
  $("#example1").dataTable({
    "pageLength": 5,
    "bLengthChange": false
  });
  $("#tenders").dataTable({
    "pageLength": 5,
    "bLengthChange": false
  });
  $("#wmfs").dataTable({
    "pageLength": 5,
    "bLengthChange": false
  });
  $("#mslavery").dataTable({
    "pageLength": 5,
    "bLengthChange": false
  });

});

function confirmDelete() {
  var result = confirm('The contract will be deleted and all associated initiatives will be deleted as well. Do you want to proceed?');

  if (result) {
    return true;
  } else {
    return false;
  }
}
</script>
@stop
