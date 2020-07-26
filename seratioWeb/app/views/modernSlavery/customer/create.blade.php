@extends('layout.dashboard_default')

@section('title')
@if(Auth::user()->has_role('CUSWM001'))
Seratio::WMFS::Modern Slavery::Add a Record
@elseif(Auth::user()->has_role('CUSWC002'))
Seratio::WCC::WMFS::Modern Slavery::Add a Record
@elseif(Auth::user()->has_role('CUSBN003'))
Seratio::B&NESC::WMFS::Modern Slavery::Add a Record
@elseif(Auth::user()->has_role('CUSEC004'))
Seratio::EC::WMFS::Modern Slavery::Add a Record
@elseif(Auth::user()->has_role('CUSSC005'))
Seratio::SCC::WMFS::Modern Slavery::Add a Record
@elseif(Auth::user()->has_role('CUSBS006'))
Seratio::B&SUH::WMFS::Modern Slavery::Add a Record
@elseif(Auth::user()->has_role('CUSCB007'))
Seratio::CBC::WMFS::Modern Slavery::Add a Record
@elseif(Auth::user()->has_role('CUSHC008'))
Seratio::HC::WMFS::Modern Slavery::Add a Record
@elseif(Auth::user()->has_role('CUSHC009'))
Seratio::HC::WMFS::Modern Slavery::Add a Record
@elsif(Auth::user()->has_role('CUSWF010'))
Seratio::WFC::WMFS::Modern Slavery::Add a Record
@elseif(Auth::user()->has_role('CUSCL011'))
Seratio::COL::WMFS::Modern Slavery::Add a Record
@elseif(Auth::user()->has_role('CUSWU012'))
Seratio::WU::WMFS::Modern Slavery::Add a Record
@elseif(Auth::user()->has_role('CUSWD013'))
Seratio::WD::WMFS::Modern Slavery::Add a Record
@elseif( Auth::user()->has_role('CUSNM014'))
Seratio::NMUH::WMFS::Modern Slavery::Add a Record
@endif
@parent
@stop

@section('content')


<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Add a Record

    </h1>

    <ol class="breadcrumb">
      <li><a href="{{URL::route('dashboard.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Add a Record</li>
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
              {{ Form::open(array('route'=> 'mslavery.store', 'class' => 'form')) }}
              <div class="row">
                <div class="col-lg-10">
                  <div class="col-md-8">
                    <h3> Modern Slavery</h3>

                    <div class="panel panel-info">
                      <p align="justify">Please enter the following data for your Modern Slavery Assessment
                      </p>

                    </div>
                    <div class="input-group">
                      <div class="input-group-addon">Year</div>
                      {{ Form::select('financial_year', Modernslavery::$YEAR, '', array('class' => 'form-control', 'placeholder' => 'Financial Year')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="The financial year of the measured data"><a href="#">Financial Year</a></label>
                    </div>
                    @if ($errors->has('financial_year')) <p class="help-block">{{ $errors->first('financial_year') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <div class="input-group-addon">£</div>
                      {{ Form::text('total_salary', '', array('class' => 'form-control', 'placeholder' => 'Total Salary', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total salary bill for the measured year"><a href="#">Total Salary</a></label>
                    </div>
                    @if ($errors->has('total_salary')) <p class="help-block">{{ $errors->first('total_salary') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <div class="input-group-addon">#</div>
                      {{ Form::text('total_staff', '', array('class' => 'form-control', 'placeholder' => 'Total Staff', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="Total number of staff for the measured year"><a href="#">Total Staff</a></label>
                    </div>
                    @if ($errors->has('total_staff')) <p class="help-block">{{ $errors->first('total_staff') }}</p> @endif
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon">%</span>
                      {{ Form::text('sentiment', '', array('class' => 'form-control', 'placeholder' => 'Sentiment', 'required')) }}
                      <label class="input-group-addon" data-toggle="tooltip" data-placement="left" title="The overall sentiment results from the staff survey carried out in the measured year"><a href="#">Sentiment</a></label>
                    </div>
                    @if ($errors->has('sentiment')) <p class="help-block">{{ $errors->first('sentiment') }}</p> @endif
                    <br>

                    {{ Form::hidden('user_id', Auth::id(), array('class' => 'form-control', 'placeholder' => 'User ID', 'required')) }}
                    {{ Form::submit('Submit', ['class' => 'btn btn-success btn-lg pull-right', 'name' => 'save_type']) }}
                  </div><!-- /.box-body -->
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
