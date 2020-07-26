@extends('layout.dashboard_default')
@section('title')
SE Ratio::Add Result
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Result
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="#">Forms</a></li>
         <li class="active">Add a User</li>
      </ol>
   </section>
   <p class="description">
      @if (Session::has('message'))
   <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <strong> {{ Session::get('message') }}</strong>
   </div>
   @endif
   </p>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- left column -->
         <div class="col-md-8">
            <!-- general form elements -->
            <div class="box box-primary">
               <div class="box-header">
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               {{ Form::open(array('route' => 'result.store', 'class' => 'form')) }}
               <div class="box-body">
                  <div class="input-group">
                     <div class="input-group-addon">Ratio</div>
                     {{ Form::text('ser', '', array('class' => 'form-control', 'placeholder' => 'SER', 'required')) }}
                     @if ($errors->has('ser'))
                     <p class="help-block">{{ $errors->first('ser') }}</p>
                     @endif
                     <label class="input-group-addon">SER</label>
                  </div>
                  <br>
                  <div class="input-group">
                     <span class="input-group-addon">£m</span>
                     {{ Form::text('social_impact', '', array('class' => 'form-control', 'placeholder' => 'Social Impact', 'required')) }}
                     @if ($errors->has('social_impact'))
                     <p class="help-block">{{ $errors->first('social_impact') }}</p>
                     @endif
                     <label class="input-group-addon">Social Impact</label>
                  </div>
                  <br>
                  <div class="input-group">
                     <span class="input-group-addon">%</span>
                     {{ Form::text('social_impact_asap_cap', '', array('class' => 'form-control', 'placeholder' => 'Social Impact As a Percentage of Capitilization', 'required')) }}
                     @if ($errors->has('social_impact_asap_cap'))
                     <p class="help-block">{{ $errors->first('social_impact_asap_cap') }}</p>
                     @endif
                     <label class="input-group-addon">Social Impact As a Percentage of Capitilization</label>
                  </div>
                  <br>
                  <div class="input-group">
                     <span class="input-group-addon">£m</span>
                     {{ Form::text('added_value', '', array('class' => 'form-control datepicker', 'placeholder' => 'Sentiment Date', 'required')) }}
                     @if ($errors->has('added_value'))
                     <p class="help-block">{{ $errors->first('added_value') }}</p>
                     @endif
                     <label class="input-group-addon">Added Value</label>
                  </div>
                  <br>
                  <div class="input-group">
                     <span class="input-group-addon">%</span>
                     {{ Form::text('environment', '', array('class' => 'form-control datepicker', 'placeholder' => 'Environment', 'required')) }}
                     @if ($errors->has('environment'))
                     <p class="help-block">{{ $errors->first('environment') }}</p>
                     @endif
                     <label class="input-group-addon">Environment</label>
                  </div>
                  <br>
                  <div class="input-group">
                     <span class="input-group-addon">%</span>
                     {{ Form::text('people', '', array('class' => 'form-control datepicker', 'placeholder' => 'People', 'required')) }}
                     @if ($errors->has('people'))
                     <p class="help-block">{{ $errors->first('people') }}</p>
                     @endif
                     <label class="input-group-addon">People</label>
                  </div>
                  <br>
                  <div class="input-group">
                     <span class="input-group-addon">%</span>
                     {{ Form::text('cash', '', array('class' => 'form-control datepicker', 'placeholder' => 'Cash', 'required')) }}
                     @if ($errors->has('cash'))
                     <p class="help-block">{{ $errors->first('cash') }}</p>
                     @endif
                     <label class="input-group-addon">Cash</label>
                  </div>
                  <br>
                  {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                  {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
               </div>
               <!-- /.box-body -->
               {{ Form::close() }}
            </div>
            <!-- /.box -->
         </div>
         <!--/.col (right) -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
@stop
