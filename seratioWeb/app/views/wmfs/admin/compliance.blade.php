@extends('layout.dashboard_default')

@section('title')
@if(Auth::user()->has_role('CUSWM001'))
Seratio::WMFS::Add a Record
@elseif(Auth::user()->has_role('CUSWC002'))
Seratio::WCC::Add a Record
@elseif(Auth::user()->has_role('CUSBN003'))
Seratio::B&NESC::Add a Record
@elseif(Auth::user()->has_role('CUSEC004'))
Seratio::EC::Add a Record
@elseif(Auth::user()->has_role('CUSSC005'))
Seratio::SCC::Add a Record
@elseif(Auth::user()->has_role('CUSBS006'))
Seratio::B&SUH::Add a Record
@elseif(Auth::user()->has_role('CUSCB007'))
Seratio::CBC::Add a Record
@elseif(Auth::user()->has_role('CUSHC008'))
Seratio::HC::Add a Record
@elseif(Auth::user()->has_role('CUSHC009'))
Seratio::HC::Add a Record
@elsif(Auth::user()->has_role('CUSWF010'))
Seratio::WFC::Add a Record
@elseif(Auth::user()->has_role('CUSCL011'))
Seratio::COL::Add a Record
@elseif(Auth::user()->has_role('CUSWU012'))
Seratio::WU::Add a Record
@elseif(Auth::user()->has_role('CUSWD013'))
Seratio::WD::Add a Record
@elseif( Auth::user()->has_role('CUSNM014'))
Seratio::NMUH::Add a Record
@endif
@parent
@stop

@section('content')


<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Add Result/{{$user->organisation}}

    </h1>

    <ol class="breadcrumb">
      <li><a href="{{URL::route('dashboard.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Add Result</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <p class="description">
        @if (Session::has('message'))
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <strong> {{ Session::get('message') }}</strong>
        </div>
        @endif
      </p>
      <div class="col-md-12">

        <!-- general form elements -->
        <div class="box box-primary">


          <div class="box-header">

          </div><!-- /.box-header -->
          <!-- form start -->
          <div class="box-body">
            <div class="container">
              <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                  <div class="stepwizard-step">
                    <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                    <p>Step 1</p>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                    <p>Step 2</p>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                    <p>Step 3</p>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                    <p>Step 4</p>
                  </div>
                </div>
              </div>
              {{ Form::open(array('route' => array('compliance.save', $user->id), 'method' => 'POST', 'class' => 'form')) }}
              <div class="row setup-content" id="step-1">
                <div class="col-lg-12">
                  <h3> Assessment</h3>
                  <div class="row">
                    <div class="col-lg-5">

                      <div class="form-group">
                        <label>Environment</label>
                        {{ Form::text('environment', $compliance->environment, array('class' => 'form-control', 'placeholder' => 'Environment')) }}
                        @if ($errors->has('environment')) <p class="help-block" style="color:red;">{{ $errors->first('environment') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Cash</label>
                        {{ Form::text('cash', $compliance->cash, array('class' => 'form-control', 'placeholder' => 'Cash')) }}
                        @if ($errors->has('cash')) <p class="help-block" style="color:red;">{{ $errors->first('cash') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>People</label>
                        {{ Form::text('people', $compliance->people, array('class' => 'form-control', 'placeholder' => 'People')) }}
                        @if ($errors->has('people')) <p class="help-block" style="color:red;">{{ $errors->first('people') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Tax Avoidance</label>
                        {{ Form::text('tax_avoidance', $compliance->tax_avoidance, array('class' => 'form-control', 'placeholder' => 'Tax Avoidance')) }}
                        @if ($errors->has('tax_avoidance')) <p class="help-block" style="color:red;">{{ $errors->first('tax_avoidance') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Pay Disparity</label>
                        {{ Form::text('pay_disparity', $compliance->pay_disparity, array('class' => 'form-control', 'placeholder' => 'Pay Disparity')) }}
                        @if ($errors->has('pay_disparity')) <p class="help-block" style="color:red;">{{ $errors->first('pay_disparity') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Personal Value</label>
                        {{ Form::text('personal_value', $compliance->personal_value, array('class' => 'form-control', 'placeholder' => 'Personal Value')) }}
                        @if ($errors->has('personal_value')) <p class="help-block" style="color:red;">{{ $errors->first('personal_value') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Transparency in Supply Chain</label>
                        {{ Form::text('transpareny_in_supply_chain', $compliance->transpareny_in_supply_chain, array('class' => 'form-control', 'placeholder' => 'Transparency in Supply Chain')) }}
                        @if ($errors->has('transpareny_in_supply_chain')) <p class="help-block" style="color:red;">{{ $errors->first('transpareny_in_supply_chain') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Sentiment/Feedback</label>
                        {{ Form::text('sentiment', $compliance->sentiment, array('class' => 'form-control', 'placeholder' => 'Sentiment/Feedback')) }}
                        @if ($errors->has('sentiment')) <p class="help-block" style="color:red;">{{ $errors->first('sentiment') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Hyperlocality</label>
                        {{ Form::text('hyperlocality', $compliance->hyperlocality, array('class' => 'form-control', 'placeholder' => 'Hyperlocality')) }}
                        @if ($errors->has('hyperlocality')) <p class="help-block" style="color:red;">{{ $errors->first('hyperlocality') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Forward Forecasting</label>
                        {{ Form::text('forward_forecasting', $compliance->forward_forecasting, array('class' => 'form-control', 'placeholder' => 'Forward Forecasting')) }}
                        @if ($errors->has('forward_forecasting')) <p class="help-block" style="color:red;">{{ $errors->first('forward_forecasting') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Time Dependant Monitoring</label>
                        {{ Form::text('time_dependent_monitoring', $compliance->time_dependent_monitoring, array('class' => 'form-control', 'placeholder' => 'Time Dependant Monitoring')) }}
                        @if ($errors->has('time_dependent_monitoring')) <p class="help-block" style="color:red;">{{ $errors->first('time_dependent_monitoring') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Financial Value</label>
                        {{ Form::text('financial_value', $compliance->financial_value, array('class' => 'form-control', 'placeholder' => 'Financial Value')) }}
                        @if ($errors->has('financial_value')) <p class="help-block" style="color:red;">{{ $errors->first('financial_value') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Benchmarking</label>
                        {{ Form::text('benchmarking', $compliance->benchmarking, array('class' => 'form-control', 'placeholder' => 'Benchmarking')) }}
                        @if ($errors->has('benchmarking')) <p class="help-block" style="color:red;">{{ $errors->first('benchmarking') }}</p> @endif
                      </div>


                    </div>

                    <div class="col-lg-5">

                      <div class="form-group">
                        <label>Environment - RAG</label>
                        {{ Form::select('environment_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->environment_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('environment_rag')) <p class="help-block" style="color:red">{{ $errors->first('environment_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Cash - RAG</label>
                        {{ Form::select('cash_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->cash_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('cash_rag')) <p class="help-block" style="color:red">{{ $errors->first('cash_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>People - RAG</label>
                        {{ Form::select('people_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->people_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('people_rag')) <p class="help-block" style="color:red">{{ $errors->first('people_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Tax Avoidance - RAG</label>
                        {{ Form::select('tax_avoidance_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->tax_avoidance_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('tax_avoidance_rag')) <p class="help-block" style="color:red">{{ $errors->first('tax_avoidance_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Pay Disparity - RAG</label>
                        {{ Form::select('pay_disparity_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->pay_disparity_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('pay_disparity_rag')) <p class="help-block" style="color:red">{{ $errors->first('pay_disparity_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Personal Value - RAG</label>
                        {{ Form::select('personal_value_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->personal_value_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('personal_value_rag')) <p class="help-block" style="color:red">{{ $errors->first('personal_value_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Transparency in Supply Chain - RAG</label>
                        {{ Form::select('transpareny_in_supply_chain_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->transpareny_in_supply_chain_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('transpareny_in_supply_chain_rag')) <p class="help-block" style="color:red">{{ $errors->first('transpareny_in_supply_chain_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Sentiment/Feedback - RAG</label>
                        {{ Form::select('sentiment_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->sentiment_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('sentiment_rag')) <p class="help-block" style="color:red">{{ $errors->first('sentiment_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Hyperlocality - RAG</label>
                        {{ Form::select('hyperlocality_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->hyperlocality_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('hyperlocality_rag')) <p class="help-block" style="color:red">{{ $errors->first('hyperlocality_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Forward Forecasting - RAG</label>
                        {{ Form::select('forward_forecasting_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->forward_forecasting_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('forward_forecasting_rag')) <p class="help-block" style="color:red">{{ $errors->first('forward_forecasting_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Time Dependant Monitoring - RAG</label>
                        {{ Form::select('time_dependent_monitoring_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->time_dependent_monitoring_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('time_dependent_monitoring_rag')) <p class="help-block" style="color:red">{{ $errors->first('time_dependent_monitoring_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Financial Value - RAG</label>
                        {{ Form::select('financial_value_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->financial_value_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('financial_value_rag')) <p class="help-block" style="color:red">{{ $errors->first('financial_value_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Benchmarking - RAG</label>
                        {{ Form::select('benchmarking_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->benchmarking_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('benchmarking_rag')) <p class="help-block" style="color:red">{{ $errors->first('benchmarking_rag') }}</p> @endif
                      </div>

                    </div>

                  </div>
                  <div class="row">
                    <div class="col-xs-5">
                      <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                    </div>
                  </div>
                  <br>
                </div>
              </div>
              <div class="row setup-content" id="step-2">
                <div class="col-lg-12">
                  <h3> Compliance</h3>

                  <div class="row">
                    <div class="col-lg-5">

                      <div class="form-group">
                        <label>Social Value Act</label>
                        {{ Form::text('social_value_act', $compliance->social_value_act, array('class' => 'form-control', 'placeholder' => 'Social Value Act')) }}
                        @if ($errors->has('social_value_act')) <p class="help-block" style="color:red;">{{ $errors->first('social_value_act') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Modern Slavery Act</label>
                        {{ Form::text('modern_slavery_act', $compliance->modern_slavery_act, array('class' => 'form-control', 'placeholder' => 'Modern Slavery Act')) }}
                        @if ($errors->has('modern_slavery_act')) <p class="help-block" style="color:red;">{{ $errors->first('modern_slavery_act') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>ISO 26000</label>
                        {{ Form::text('iso26000', $compliance->iso26000, array('class' => 'form-control', 'placeholder' => 'ISO 26000')) }}
                        @if ($errors->has('iso26000')) <p class="help-block" style="color:red;">{{ $errors->first('iso26000') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>GRI-4</label>
                        {{ Form::text('gri_4', $compliance->gri_4, array('class' => 'form-control', 'placeholder' => 'GRI-4')) }}
                        @if ($errors->has('gri_4')) <p class="help-block" style="color:red;">{{ $errors->first('gri_4') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>IIRC</label>
                        {{ Form::text('iirc', $compliance->iirc, array('class' => 'form-control', 'placeholder' => 'IIRC')) }}
                        @if ($errors->has('iirc')) <p class="help-block" style="color:red;">{{ $errors->first('iirc') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Benefit Coro</label>
                        {{ Form::text('benefit_coro', $compliance->benefit_coro, array('class' => 'form-control', 'placeholder' => 'Benefit Coro')) }}
                        @if ($errors->has('benefit_coro')) <p class="help-block" style="color:red;">{{ $errors->first('benefit_coro') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>WEF</label>
                        {{ Form::text('wef', $compliance->wef, array('class' => 'form-control', 'placeholder' => 'WEF')) }}
                        @if ($errors->has('wef')) <p class="help-block" style="color:red;">{{ $errors->first('wef') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>EU 500+CSR</label>
                        {{ Form::text('wu_500_csr', $compliance->wu_500_csr, array('class' => 'form-control', 'placeholder' => 'EU 500+CSR')) }}
                        @if ($errors->has('wu_500_csr')) <p class="help-block" style="color:red;">{{ $errors->first('wu_500_csr') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>GECES</label>
                        {{ Form::text('geces', $compliance->geces, array('class' => 'form-control', 'placeholder' => 'GECES')) }}
                        @if ($errors->has('geces')) <p class="help-block" style="color:red;">{{ $errors->first('geces') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>SI 20%</label>
                        {{ Form::text('si', $compliance->si, array('class' => 'form-control', 'placeholder' => 'SI 20%')) }}
                        @if ($errors->has('si')) <p class="help-block" style="color:red;">{{ $errors->first('si') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Litigation Liability</label>
                        {{ Form::text('litigation_liability', $compliance->litigation_liability, array('class' => 'form-control', 'placeholder' => 'Litigation Liability')) }}
                        @if ($errors->has('litigation_liability')) <p class="help-block" style="color:red;">{{ $errors->first('litigation_liability') }}</p> @endif
                      </div>
                    </div>

                    <div class="col-lg-5">

                      <div class="form-group">
                        <label>Social Value Act - RAG</label>
                        {{ Form::select('social_value_act_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->social_value_act_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('social_value_act_rag')) <p class="help-block" style="color:red">{{ $errors->first('social_value_act_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Modern Slavery Act - RAG</label>
                        {{ Form::select('modern_slavery_act_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->modern_slavery_act_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('modern_slavery_act_rag')) <p class="help-block" style="color:red">{{ $errors->first('modern_slavery_act_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>ISO 26000 - RAG</label>
                        {{ Form::select('iso26000_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->iso26000_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('iso26000_rag')) <p class="help-block" style="color:red">{{ $errors->first('iso26000_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>GRI-4 - RAG</label>
                        {{ Form::select('gri4_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->gri4_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('gri4_rag')) <p class="help-block" style="color:red">{{ $errors->first('gri4_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>IIRC - RAG</label>
                        {{ Form::select('iirc_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->iirc_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('iirc_rag')) <p class="help-block" style="color:red">{{ $errors->first('iirc_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Benefit Coro - RAG</label>
                        {{ Form::select('benefit_coro_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->benefit_coro_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('benefit_coro_rag')) <p class="help-block" style="color:red">{{ $errors->first('benefit_coro_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>WEF - RAG</label>
                        {{ Form::select('wef_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->wef_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('wef_rag')) <p class="help-block" style="color:red">{{ $errors->first('wef_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>EU 500+CSR - RAG</label>
                        {{ Form::select('wu_500_csr_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->wu_500_csr_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('wu_500_csr_rag')) <p class="help-block" style="color:red">{{ $errors->first('wu_500_csr_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>GECES - RAG</label>
                        {{ Form::select('geces_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->geces_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('geces_rag')) <p class="help-block" style="color:red">{{ $errors->first('geces_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>SI 20% - RAG</label>
                        {{ Form::select('si_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->si_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('si_rag')) <p class="help-block" style="color:red">{{ $errors->first('si_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Litigation Liability - RAG</label>
                        {{ Form::select('litigation_liability_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->litigation_liability_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('litigation_liability_rag')) <p class="help-block" style="color:red">{{ $errors->first('litigation_liability_rag') }}</p> @endif
                      </div>
                    </div>

                  </div>
                  <div class="row">
                    <div class="col-xs-5">
                      <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                    </div>
                  </div>
                  <br>
                </div>
              </div>
              <div class="row setup-content" id="step-3">
                <div class="col-lg-12">

                  <h3> Compliance</h3>

                  <div class="row">
                    <div class="col-lg-5">

                      <div class="form-group">
                        <label>Monthly Reporting</label>
                        {{ Form::text('monthly_reporting', $compliance->monthly_reporting, array('class' => 'form-control', 'placeholder' => 'Monthly Reporting')) }}
                        @if ($errors->has('monthly_reporting')) <p class="help-block" style="color:red;">{{ $errors->first('monthly_reporting') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Independent Arbitration</label>
                        {{ Form::text('independent_arbitration', $compliance->independent_arbitration, array('class' => 'form-control', 'placeholder' => 'Independent Arbitration')) }}
                        @if ($errors->has('independent_arbitration')) <p class="help-block" style="color:red;">{{ $errors->first('independent_arbitration') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Dashboard Provision</label>
                        {{ Form::text('dashboard_provision', $compliance->dashboard_provision, array('class' => 'form-control', 'placeholder' => 'Dashboard Provision')) }}
                        @if ($errors->has('dashboard_provision')) <p class="help-block" style="color:red;">{{ $errors->first('dashboard_provision') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Capacity Development (online)-MOOC</label>
                        {{ Form::text('capacity_development_online', $compliance->capacity_development_online, array('class' => 'form-control', 'placeholder' => 'Capacity Development (online) - MOOC')) }}
                        @if ($errors->has('capacity_development_online')) <p class="help-block" style="color:red;">{{ $errors->first('capacity_development_online') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Capacity Development (face2face)-Conferences</label>
                        {{ Form::text('capacity_development_face', $compliance->capacity_development_face, array('class' => 'form-control', 'placeholder' => 'Capacity Development (face2face) - Conferences')) }}
                        @if ($errors->has('capacity_development_face')) <p class="help-block" style="color:red;">{{ $errors->first('capacity_development_face') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Capacity Development (written)-Journal</label>
                        {{ Form::text('capacity_development_written', $compliance->capacity_development_written, array('class' => 'form-control', 'placeholder' => 'Capacity Development (written)-Journal')) }}
                        @if ($errors->has('capacity_development_written')) <p class="help-block" style="color:red;">{{ $errors->first('capacity_development_written') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Engagement - Collaborative Mapping (GIS)</label>
                        {{ Form::text('engagement', $compliance->engagement, array('class' => 'form-control', 'placeholder' => 'Engagement - Collaborative Mapping (GIS)')) }}
                        @if ($errors->has('engagement')) <p class="help-block" style="color:red;">{{ $errors->first('engagement') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Solutions - Participatory Planning (Acupuncture)</label>
                        {{ Form::text('solutions', $compliance->solutions, array('class' => 'form-control', 'placeholder' => 'Solutions - Participatory Planning (Acupuncture)')) }}
                        @if ($errors->has('solutions')) <p class="help-block" style="color:red;">{{ $errors->first('solutions') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Ideation</label>
                        {{ Form::text('ideation', $compliance->ideation, array('class' => 'form-control', 'placeholder' => 'Ideation')) }}
                        @if ($errors->has('ideation')) <p class="help-block" style="color:red;">{{ $errors->first('ideation') }}</p> @endif
                      </div>
                    </div>

                    <div class="col-lg-5">

                      <div class="form-group">
                        <label>Monthly Reporting - RAG</label>
                        {{ Form::select('monthly_reporting_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->monthly_reporting_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('monthly_reporting_rag')) <p class="help-block" style="color:red">{{ $errors->first('monthly_reporting_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Independent Arbitration - RAG</label>
                        {{ Form::select('independent_arbitration_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->independent_arbitration_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('independent_arbitration_rag')) <p class="help-block" style="color:red">{{ $errors->first('independent_arbitration_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Dashboard Provision - RAG</label>
                        {{ Form::select('dashboard_provision_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->dashboard_provision_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('dashboard_provision_rag')) <p class="help-block" style="color:red">{{ $errors->first('dashboard_provision_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Capacity Development (online)-MOOC - RAG</label>
                        {{ Form::select('capacity_development_online_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->capacity_development_online_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('capacity_development_online_rag')) <p class="help-block" style="color:red">{{ $errors->first('capacity_development_online_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Capacity Development (face2face)-Conferences - RAG</label>
                        {{ Form::select('capacity_development_face_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->capacity_development_face_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('capacity_development_face_rag')) <p class="help-block" style="color:red">{{ $errors->first('capacity_development_face_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Capacity Development (written)-Journal - RAG</label>
                        {{ Form::select('capacity_development_written_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->capacity_development_written_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('capacity_development_written_rag')) <p class="help-block" style="color:red">{{ $errors->first('capacity_development_written_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Engagement - Collaborative Mapping (GIS) - RAG</label>
                        {{ Form::select('engagement_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->engagement_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('engagement_rag')) <p class="help-block" style="color:red">{{ $errors->first('engagement_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Solutions - Participatory Planning (Acupuncture) - RAG</label>
                        {{ Form::select('solutions_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->solutions_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('solutions_rag')) <p class="help-block" style="color:red">{{ $errors->first('solutions_rag') }}</p> @endif
                      </div>

                      <div class="form-group">
                        <label>Ideation - RAG</label>
                        {{ Form::select('ideation_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->ideation_rag,  array('class' => 'form-control')) }}
                        @if ($errors->has('ideation_rag')) <p class="help-block" style="color:red">{{ $errors->first('ideation_rag') }}</p> @endif
                      </div>
                    </div>

                  </div>
                  <div class="row">
                    <div class="col-xs-5">
                      <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                    </div>
                  </div>
                  <br>
                </div>
              </div>
              <div class="row setup-content" id="step-4">
                <div class="col-xs-10">
                  <div class="col-md-8">
                    <h3> Compliance Report </h3>

                    <div class="form-group">
                      <label>Compliance - RAG</label>
                      {{ Form::select('compliance_rag',['NULL' =>'--Please Select--', 'Green'=>'Green', 'Amber'=>'Amber', 'Red' => 'Red'], $compliance->compliance_rag,  array('class' => 'form-control')) }}
                      @if ($errors->has('compliance_rag')) <p class="help-block" style="color:red">{{ $errors->first('compliance_rag') }}</p> @endif
                    </div>

                    {{ Form::submit('Submit', ['class' => 'btn btn-success btn-lg pull-right']) }}


                    <</div><!-- /.box-body -->
                  </div><!-- /.box -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    {{Form::close()}}

  </div>


  @stop
