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
         Edit My Profile
      </h1>
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
         <p class="description">
            @if (Session::has('error'))
         <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong> {{ Session::get('error') }}</strong>
         </div>
         @endif
         </p>
         <!-- Main content -->
         <!-- left column -->
         <div class="col-md-8">
            <!-- general form elements -->
            <div class="box box-primary">
               <div class="box-header">
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               @if(Auth::user()->has_role('individual'))
               {{ Form::open(array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}
               <div class="form-group">
                  <label>First Name</label>
                  {{ Form::text('firstname', $user->firstname, array('class' => 'form-control', 'required')) }}
                  @if ($errors->has('firstname'))
                  <p class="help-block">{{ $errors->first('firstname') }}</p>
                  @endif
               </div>
               <div class="form-group">
                  <label>Last Name</label>
                  {{ Form::text('lastname', $user->lastname, array('class' => 'form-control', 'placeholder' => 'Surname', 'required')) }}
                  @if ($errors->has('lastname'))
                  <p class="help-block">{{ $errors->first('lastname') }}</p>
                  @endif
               </div>
               <div class="form-group">
                  <label>E-Mail</label>
                  {{ Form::email('email', $user->email, array('class' => 'form-control', 'placeholder' => 'E-Mail', 'disabled')) }}
                  @if ($errors->has('email'))
                  <p class="help-block">{{ $errors->first('email') }}</p>
                  @endif
               </div>
               <div class="form-group">
                  <label>Gender</label>
                  <select class ="form-control"
                  {{ Form::select('gender', User::$GENDER, $user->gender, array('class' => 'form-control', 'placeholder' => 'Gender', 'required')) }}
                  @if ($errors->has('gender'))
                  <p class="help-block">{{ $errors->first('gender') }}</p>
                  @endif
                  </select>
               </div>
               <div class="form-group">
                  <label>Password</label>
                  {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
                  @if ($errors->has('password'))
                  <p class="help-block">{{ $errors->first('password') }}</p>
                  @endif
               </div>
               <div class="form-group">
                  <label>Confirm Password</label>
                  {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm Password')) }}
                  @if ($errors->has('password_confirmation'))
                  <p class="help-block">{{ $errors->first('password_confirmation') }}</p>
                  @endif
               </div>
               <div class="form-group">
                  <label>Phone Number</label>
                  {{ Form::text('phone_number', $user->phone_number, array('class' => 'form-control', 'placeholder' => 'Phone Number (optional)')) }}
                  @if ($errors->has('phone_number'))
                  <p class="help-block">{{ $errors->first('phone_number') }}</p>
                  @endif
               </div>
               <div class="form-group">
                  <label>Project Code</label>
                  <select class ="form-control"
                  {{ Form::select('project_code', User::$PROJECT_CODE, $user->project_code, array('class' => 'form-control', 'placeholder' => 'Project Code')) }}
                  @if ($errors->has('project_code'))
                  <p class="help-block">{{ $errors->first('project_code') }}</p>
                  @endif
                  </select>
               </div>
               {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
               {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
            </div>
            <!-- /.box-body -->
            {{ Form::close() }}
            @endif
         </div>
         <!-- /.box -->
      </div>
      <!--/.col (right) -->
   </section>
   <!-- /.content -->
</div>
<!-- /.row -->
@stop
