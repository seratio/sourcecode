@extends('layout.dashboard_default')
@section('title')
SE Ratio::
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Modern Slavery
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="#">Modern Slavery</a></li>
         <li class="active">Modern Slavery</li>
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
         <div class="col-md-10">
            <!-- general form elements -->
            <div class="box box-primary">
               <div class="box-header">
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               {{ Form::open(array('route' => 'users.store', 'class' => 'form')) }}
               <div class="box-body">
                  <div class="form-group">
                     <h3>SENTIMENT</h3>
                     <label>Date</label>
                     {{ Form::text('date', '', array('class' => 'form-control', 'placeholder' => 'dd/mm/yyyy', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Positive</label>
                     {{ Form::text('positive', '', array('class' => 'form-control', 'placeholder' => '#', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Neutral</label>
                     {{ Form::text('neutral', '', array('class' => 'form-control', 'placeholder' => '#', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Negative</label>
                     {{ Form::text('negative', '', array('class' => 'form-control', 'placeholder' => '#', 'required')) }}
                  </div>
                  <div class="form-group">
                     <h3>REPORTING</h3>
                     <label>CSR</label>
                     {{ Form::text('csr', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Deg of Separation</label>
                     {{ Form::text('degofsep', '', array('class' => 'form-control', 'placeholder' => '#', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Shares</label>
                     {{ Form::text('shares', '', array('class' => 'form-control', 'placeholder' => '#m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Capititilization/NAV</label>
                     {{ Form::text('cap', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Staff</label>
                     {{ Form::text('staff', '', array('class' => 'form-control', 'placeholder' => '#', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Carbon Reduction t</label>
                     {{ Form::text('carbonred', '', array('class' => 'form-control', 'placeholder' => 'tCO2e', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Carbon Offset </label>
                     {{ Form::text('carbonoffset', '', array('class' => 'form-control', 'placeholder' => 'tCO2e', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Value tCO2e- Non Traded</label>
                     {{ Form::text('carbonred', '', array('class' => 'form-control', 'placeholder' => '£', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Value tCO2e- Traded </label>
                     {{ Form::text('carbonoffset', '', array('class' => 'form-control', 'placeholder' => '£', 'required')) }}
                  </div>
                  <div class="form-group">
                     <h3>PEOPLE</h3>
                     <label>People (#)</label>
                     {{ Form::text('degofsep', '', array('class' => 'form-control', 'placeholder' => '#n', 'required')) }}
                  </div>
                  <div class="form-group">
                     <h2 align ="center">INCLUDING TAX AVOIDANCE AND PAY DISPARITY</h2>
                     <h3> Current Year </h3>
                     <label>Directors Salary (Executive)</label>
                     {{ Form::text('csr', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Directors Salary (Non-Executive)</label>
                     {{ Form::text('csr', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Staff Salary</label>
                     {{ Form::text('degofsep', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Staff Salary (Without Directors)</label>
                     {{ Form::text('shares', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Tax Charged</label>
                     {{ Form::text('cap', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Total Share Holder Pay (Dividend) (Cash)</label>
                     {{ Form::text('staff', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Executive Board</label>
                     {{ Form::text('carbonred', '', array('class' => 'form-control', 'placeholder' => '#', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Non Executive Board</label>
                     {{ Form::text('carbonred', '', array('class' => 'form-control', 'placeholder' => '#', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Board Total</label>
                     {{ Form::text('carbonred', '', array('class' => 'form-control', 'placeholder' => '#', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Number of Staffs</label>
                     {{ Form::text('carbonred', '', array('class' => 'form-control', 'placeholder' => '#', 'required')) }}
                  </div>
                  <div class="form-group">
                     <h3> Prior Year </h3>
                     <label>Directors Salary (Executive)</label>
                     {{ Form::text('csr', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Directors Salary (Non-Executive)</label>
                     {{ Form::text('csr', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Staff Salary</label>
                     {{ Form::text('degofsep', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Staff Salary (Without Directors)</label>
                     {{ Form::text('shares', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Tax Charged</label>
                     {{ Form::text('cap', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Total Share Holder Pay (Dividend) (Cash)</label>
                     {{ Form::text('staff', '', array('class' => 'form-control', 'placeholder' => '£m', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Executive Board</label>
                     {{ Form::text('carbonred', '', array('class' => 'form-control', 'placeholder' => '#', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Non Executive Board</label>
                     {{ Form::text('carbonred', '', array('class' => 'form-control', 'placeholder' => '#', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Board Total</label>
                     {{ Form::text('carbonred', '', array('class' => 'form-control', 'placeholder' => '#', 'required')) }}
                  </div>
                  <div class="form-group">
                     <label>Number of Staffs</label>
                     {{ Form::text('carbonred', '', array('class' => 'form-control', 'placeholder' => '#', 'required')) }}
                  </div>
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
