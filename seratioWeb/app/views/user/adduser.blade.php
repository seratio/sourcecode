@extends('layout.dashboard_default')
@section('title')
SE Ratio::Modern Slavery::Add a Customer
@parent
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         @if($ms || $pslight)
         Add a Customer
         @else
         Add a User
         @endif
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
         <!-- Main content -->
         <!-- left column -->
         <div class="col-md-8">
            <!-- general form elements -->
            <div class="box box-primary">
               <div class="box-header">
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               {{ Form::open(array('route' => 'users.store', 'class' => 'form')) }}
               <div class="box-body">
                  <div class="form-group">
                     <label>Title</label>
                     <select class ="form-control"
                     {{ Form::select('title', User::$TITLES, array('required')) }}
                     @if ($errors->has('title'))
                     <p class="help-block">{{ $errors->first('title') }} </p>
                     @endif
                     </select>
                  </div>
                  <div class="form-group">
                     <label>First Name</label>
                     {{ Form::text('firstname', '', array('class' => 'form-control', 'placeholder' => 'First Name', 'required')) }}
                     @if ($errors->has('firstname'))
                     <p class="help-block">{{ $errors->first('firstname') }}</p>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Last Name</label>
                     {{ Form::text('lastname', '', array('class' => 'form-control', 'placeholder' => 'Last Name', 'required')) }}
                     @if ($errors->has('lastname'))
                     <p class="help-block">{{ $errors->first('lastname') }}</p>
                     @endif
                  </div>
                  @if(!$ms && !$pslight)
                  <div class="form-group">
                     <label>Position</label>
                     {{ Form::text('position', '', array('class' => 'form-control', 'placeholder' => 'Position', 'required')) }}
                     @if ($errors->has('position'))
                     <p class="help-block">{{ $errors->first('position') }}</p>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Organisation</label>
                     {{ Form::text('organisation', '', array('class' => 'form-control', 'placeholder' => 'Organisation', 'required')) }}
                     @if ($errors->has('organisation'))
                     <p class="help-block">{{ $errors->first('organisation') }}</p>
                     @endif
                  </div>
                  @endif
                  <div class="form-group">
                     <label>Email</label>
                     {{ Form::email('email', '', array('class' => 'form-control', 'placeholder' => 'E-Mail', 'required')) }}
                     @if ($errors->has('email'))
                     <p class="help-block">{{ $errors->first('email') }}</p>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Password</label>
                     {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required')) }}
                     @if ($errors->has('password'))
                     <p class="help-block">{{ $errors->first('password') }}</p>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Confirm Password</label>
                     {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm Password', 'required')) }}
                     @if ($errors->has('password_confirmation'))
                     <p class="help-block">{{ $errors->first('password_confirmation') }}</p>
                     @endif
                  </div>
                  @if($ms)
                  <div class="form-group">
                     <label>Customer Type</label>
                     <select class ="form-control"
                     {{ Form::select('customer_type', ['Normal' => 'Normal' , 'Enterprise' => 'Enterprise'], array('class' => 'form-control', 'placeholder' => 'Role', 'required')) }}
                     @if ($errors->has('customer_type'))
                     <p class="help-block">{{ $errors->first('customer_type') }}</p>
                     @endif
                     </select>
                  </div>
                  @endif
                  @if($pslight)
                  <div class="form-group">
                     <label>Customer Type</label>
                     <select class ="form-control"
                     {{ Form::select('customer_type', ['Gold' => 'Gold' , 'Platinum' => 'Platinum', 'Enterprise' => 'Enterprise'], array('class' => 'form-control', 'placeholder' => 'Role', 'required')) }}
                     @if ($errors->has('customer_type'))
                     <p class="help-block">{{ $errors->first('customer_type') }}</p>
                     @endif
                     </select>
                  </div>
                  @endif
                  @if(!$ms && !$pslight)
                  <div class="form-group">
                     <label>Phone Number</label>
                     {{ Form::text('phone_number', '', array('class' => 'form-control', 'placeholder' => 'Phone Number', 'required')) }}
                     @if ($errors->has('phone_number'))
                     <p class="help-block">{{ $errors->first('phone_number') }}</p>
                     @endif
                  </div>
                  <div class="form-group">
                     <label>Role</label>
                     <select class ="form-control"
                     {{ Form::select('role_id', User::$ROLES, array('class' => 'form-control', 'placeholder' => 'Role', 'required')) }}
                     @if ($errors->has('role_id'))
                     <p class="help-block">{{ $errors->first('role_id') }}</p>
                     @endif
                     </select>
                  </div>
                  @endif
                  @if($ms)
                  {{ Form ::hidden('role_id', 8)}}
                  {{ Form ::hidden('subrole_id', 0 )}}
                  @endif
                  @if($pslight)
                  {{ Form::hidden('role_id', 9)}}
                  @endif
                  {{ Form::submit('Add', ['class' => 'btn btn-success']) }}
                  {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
         </div>
         {{Form::close()}}
      </div>
   </section>
</div>
@stop
