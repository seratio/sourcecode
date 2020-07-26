@extends('layout.dashboard_default')
@section('title')
SE Ratio::PS Micosite::Customer Info
@stop
@section('css')
<!--<style type='text/css'>
   .box{
    padding: 20px;
    display: none;
    margin-top: 20px;
    border: 1px solid #000;
   }
   .red{ background: #ff0000; }
   .green{ background: #00ff00; }
   .blue{ background: #0000ff; }
   </style>-->
<style type="text/css">
   div.parent > div {
   display: none;
   }
</style>
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Customer-Basic Details
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Customer Info</li>
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
         <!-- left column -->
         <div class="col-md-10 col-md-offset-1">
            <!-- general form elements -->
            <div class="box box-primary">
               <div class="box-header">
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               {{ Form::open(array('route' => array('microbids.store'), 'class' => 'form', 'files'=>true)) }}
               {{ Form::hidden('user_id', Auth::id()) }}
               <div class="box-body">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label>Bid Name</label>
                           {{ Form::text('bid_name','' , array('class' => 'form-control', 'placeholder' => 'Bid Name', 'required')) }}
                           @if ($errors->has('bid_name'))
                           <p class="help-block" style="color:red;">{{ $errors->first('bid_name') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Bid Date</label>
                           {{ Form::text('bid_date', '' , array('class' => 'form-control', 'placeholder' => 'Bid Date', 'required')) }}
                           @if ($errors->has('bid_date'))
                           <p class="help-block" style="color:red;">{{ $errors->first('bid_date') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Price(£)</label>
                           {{ Form::number('price', '' , array('class' => 'form-control', 'placeholder' => 'Price', 'step' => '0.01', 'required')) }}
                           @if ($errors->has('price'))
                           <p class="help-block" style="color:red;">{{ $errors->first('price') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Added Social Value(£)</label>
                           {{ Form::number('added_social_value', '', array('class' => 'form-control', 'placeholder' => 'Added Social Value','step' => '0.01', 'required')) }}
                           @if ($errors->has('added_social_value'))
                           <p class="help-block" style="color:red;">{{ $errors->first('added_social_value') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>People(£)</label>
                           {{ Form::number('people', '' , array('class' => 'form-control', 'placeholder' => 'People','step' => '0.01', 'required')) }}
                           @if ($errors->has('people'))
                           <p class="help-block" style="color:red;">{{ $errors->first('people') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Cash(£)</label>
                           {{ Form::number('cash', '', array('class' => 'form-control', 'placeholder' => 'Cash','step' => '0.01', 'required')) }}
                           @if ($errors->has('cash'))
                           <p class="help-block" style="color:red;">{{ $errors->first('cash') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Environment(£)</label>
                           {{ Form::number('environment', '', array('class' => 'form-control', 'placeholder' => 'Environment','step' => '0.01', 'required')) }}
                           @if ($errors->has('environment'))
                           <p class="help-block" style="color:red;">{{ $errors->first('environment') }}</p>
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-12">
                     {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                     {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
                  </div>
               </div>
               <br>
            </div>
            <!-- /.box-body -->
         </div>
      </div>
      <!--/.col (right) -->
   </section>
   <!-- /.right-side -->
</div>
@stop
