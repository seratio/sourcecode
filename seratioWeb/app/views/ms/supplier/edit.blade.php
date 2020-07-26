@extends('layout.dashboard_default')
@section('title')
SE Ratio::Modern Slavery::Edit a Supplier
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit a Supplier
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Add a Supplier</li>
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
               {{ Form::open(array('route' => 'mssupplier.store', 'class' => 'form')) }}
               <div class="box-body">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label>Suppplier Name</label>
                           {{ Form::text('supplier_name', $supplier->name, array('class' => 'form-control', 'placeholder' => 'Supplier Name', 'required')) }}
                           @if ($errors->has('supplier_name'))
                           <p class="help-block">{{ $errors->first('supplier_name') }}</p>
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label>Address</label>
                           {{ Form::text('number_street', $supplier->number_street, array('class' => 'form-control', 'placeholder' => 'Address', 'required')) }}
                           @if ($errors->has('number_street'))
                           <p class="help-block">{{ $errors->first('number_street') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>County</label>
                           {{ Form::text('county', $supplier->county, array('class' => 'form-control', 'placeholder' => 'County', 'required')) }}
                           @if ($errors->has('county'))
                           <p class="help-block">{{ $errors->first('county') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Country</label>
                           <select class ="form-control"
                           {{ Form::select('country', $con, $supplier->country, array('class' => 'form-control', 'required')) }}
                           @if ($errors->has('country'))
                           <p class="help-block">{{ $errors->first('country') }}</p>
                           @endif
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label>City</label>
                           {{ Form::text('city', $supplier->city, array('class' => 'form-control', 'placeholder' => 'City', 'required')) }}
                           @if ($errors->has('city'))
                           <p class="help-block">{{ $errors->first('city') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Post Code</label>
                           {{ Form::text('post_code', $supplier->post_code, array('class' => 'form-control', 'placeholder' => 'Post Code', 'required')) }}
                           @if ($errors->has('post_code'))
                           <p class="help-block">{{ $errors->first('post_code') }}</p>
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label>Email</label>
                           {{ Form::email('email', $supplier->email, array('class' => 'form-control', 'placeholder' => 'E-Mail', 'required')) }}
                           @if ($errors->has('email'))
                           <p class="help-block">{{ $errors->first('email') }}</p>
                           @endif
                        </div>
                        <div class="form-group">
                           <label>Sector</label>
                           <select class ="form-control"
                           {{ Form::select('sector', $sectors, $suppllier->sector,  array('class' => 'form-control', 'required')) }}
                           @if ($errors->has('sector'))
                           <p class="help-block">{{ $errors->first('sector') }}</p>
                           @endif
                           </select>
                        </div>
                        <div class="form-group">
                           <label>Industry</label>
                           <select class ="form-control"
                           {{ Form::select('main_industry', $industries, $supplier->main_industry array('class' => 'form-control', 'required')) }}
                           @if ($errors->has('main_industry'))
                           <p class="help-block">{{ $errors->first('main_industry') }}</p>
                           @endif
                           </select>
                        </div>
                     </div>
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
