@extends('layout.admin_default')
@if($eu_id>0)
@section('title')
Registration
@stop
@else
@section('title')
Register::
@parent
@stop
@endif
@section('content')
<body class="page-body login-page login-form-fall">
   <div class="login-container">
   <div class="login-header login-caret">
      <div class="login-content">
         @if($eu_id)
         <a href= "{{URL::route('home.index')}}" class="logo">
         {{ HTML::image('assets_backend/images/fiware.png', 'SE Ratio', array('width' => '300')) }}
         </a>
         @else
         <a href= "{{URL::route('home.index')}}" class="logo">
         {{ HTML::image('assets_backend/images/logo.png', 'SE Ratio', array('width' => '200')) }}
         </a>
         @endif
         @if($eu_id)
         <h1 style="color:white;">Welcome to FIWARE Social Impact</h1>
         <p class="description">Please register to take the test. All the information you provide will remain confidential</p>
         @else
         <p class="description">Create an account, it's free and takes few moments only!</p>
         @endif
         <p class="description">
            @if (Session::has('message'))
         <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong> {{ Session::get('message') }}</strong>
         </div>
         @endif
         </p>
      </div>
   </div>
   @if($temp_id>0)
   <div class="login-content">
      {{ Form::open(array('route' => 'users.store', 'class' => 'login-form')) }}
      {{ Form::hidden('temp_id', $temp_id) }}
      <fieldset>
         <div class="form-group">
            {{ Form::text('firstname', '', array('class' => 'form-control', 'placeholder' => 'Forename', 'required')) }}
            @if ($errors->has('firstname'))
            <p class="help-block">{{ $errors->first('firstname') }}</p>
            @endif
         </div>
         <div class="form-group">
            {{ Form::text('lastname', '', array('class' => 'form-control', 'placeholder' => 'Surname', 'required')) }}
            @if ($errors->has('lastname'))
            <p class="help-block">{{ $errors->first('lastname') }}</p>
            @endif
         </div>
         <div class="form-group">
            {{ Form::email('email', '', array('class' => 'form-control', 'placeholder' => 'E-Mail', 'required')) }}
            @if ($errors->has('email'))
            <p class="help-block">{{ $errors->first('email') }}</p>
            @endif
         </div>
         <div class="form-group">
            <select class ="form-control"
            {{ Form::select('gender', User::$GENDER, array('class' => 'form-control', 'placeholder' => 'Gender', 'required')) }}
            @if ($errors->has('gender'))
            <p class="help-block">{{ $errors->first('gender') }}</p>
            @endif
            </select>
         </div>
         <div class="form-group">
            {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required')) }}
            @if ($errors->has('password'))
            <p class="help-block">{{ $errors->first('password') }}</p>
            @endif
         </div>
         <div class="form-group">
            {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm Password', 'required')) }}
            @if ($errors->has('password_confirmation'))
            <p class="help-block">{{ $errors->first('password_confirmation') }}</p>
            @endif
         </div>
         <div class="form-group">
            {{ Form::text('phone_number', '', array('class' => 'form-control', 'placeholder' => 'Phone Number (optional)')) }}
            @if ($errors->has('phone_number'))
            <p class="help-block">{{ $errors->first('phone_number') }}</p>
            @endif
         </div>
         <div class="form-group">
            <select class ="form-control"
            {{ Form::select('project_code', User::$PROJECT_CODE, array('class' => 'form-control', 'placeholder' => 'Project Code')) }}
            @if ($errors->has('project_code'))
            <p class="help-block">{{ $errors->first('project_code') }}</p>
            @endif
            </select>
         </div>
         {{ Form::hidden('role_id', 4) }}
         {{ Form::submit('Register', ['class' => 'btn btn-lg btn-success btn-block']) }}
         {{ Form::reset('Reset', ['class' => 'btn btn-lg btn-success btn-block']) }}
      </fieldset>
      {{ Form::close() }}
      @else
      <div class="login-content">
         {{ Form::open(array('route' => 'users.store', 'class' => 'login-form')) }}
         <fieldset>
            <div class="form-group">
               <select class ="form-control"
               {{ Form::select('title', User::$TITLES, array('class' => 'form-control', 'placeholder' => 'Title', 'required')) }}
               @if ($errors->has('title'))
               <p class="help-block">{{ $errors->first('title') }}</p>
               @endif
               </select>
            </div>
            <div class="form-group">
               {{ Form::text('firstname', '', array('class' => 'form-control', 'placeholder' => 'First Name', 'required')) }}
               @if ($errors->has('firstname'))
               <p class="help-block">{{ $errors->first('firstname') }}</p>
               @endif
            </div>
            <div class="form-group">
               {{ Form::text('lastname', '', array('class' => 'form-control', 'placeholder' => 'Last Name', 'required')) }}
               @if ($errors->has('lastname'))
               <p class="help-block">{{ $errors->first('lastname') }}</p>
               @endif
            </div>
            <div class="form-group">
               <select class ="form-control"
               {{ Form::select('gender', array('Male' => 'Male', 'Female' => 'Female'))}}
               @if ($errors->has('gender'))
               <p class="help-block">{{ $errors->first('gender') }}</p>
               @endif
               </select>
            </div>
            @if(!$ms)
            <div class="form-group">
               {{ Form::text('position', '', array('class' => 'form-control', 'placeholder' => 'Position', 'required')) }}
               @if ($errors->has('position'))
               <p class="help-block">{{ $errors->first('position') }}</p>
               @endif
            </div>
            <div class="form-group">
               {{ Form::text('organisation', '', array('class' => 'form-control', 'placeholder' => 'Organisation', 'required')) }}
               @if ($errors->has('organisation'))
               <p class="help-block">{{ $errors->first('organisation') }}</p>
               @endif
            </div>
            @endif
            <div class="form-group">
               {{ Form::email('email', '', array('class' => 'form-control', 'placeholder' => 'E-Mail', 'required')) }}
               @if ($errors->has('email'))
               <p class="help-block">{{ $errors->first('email') }}</p>
               @endif
            </div>
            <div class="form-group">
               {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required')) }}
               @if ($errors->has('password'))
               <p class="help-block">{{ $errors->first('password') }}</p>
               @endif
            </div>
            <div class="form-group">
               {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm Password', 'required')) }}
               @if ($errors->has('password_confirmation'))
               <p class="help-block">{{ $errors->first('password_confirmation') }}</p>
               @endif
            </div>
            @if(!$ms)
            <div class="form-group">
               {{ Form::text('phone_number', '', array('class' => 'form-control', 'placeholder' => 'Phone Number', 'required')) }}
               @if ($errors->has('phone_number'))
               <p class="help-block">{{ $errors->first('phone_number') }}</p>
               @endif
            </div>
            @endif
            @if($eu_id>0)
            {{ Form::hidden('role_id', 7) }}
            {{ Form::hidden('eu_id', $eu_id) }}
            @elseif($ms)
            {{ Form ::hidden('role_id', 8)}}
            {{ Form ::hidden('subrole_id', 0 )}}
            @else
            <div class="form-group">
               <select class ="form-control"
               {{ Form::select('role_id', User::$ROLES_VIEW, array('class' => 'form-control', 'placeholder' => 'Role', 'required')) }}
               @if ($errors->has('role_id'))
               <p class="help-block">{{ $errors->first('role_id') }}</p>
               @endif
            </div>
            @endif
            {{ Form::submit('Register', ['class' => 'btn btn-lg btn-success btn-block']) }}
            {{ Form::reset('Reset', ['class' => 'btn btn-lg btn-success btn-block']) }}
         </fieldset>
         {{ Form::close() }}
         @endif
         <div class="login-bottom-links">
            <a href="{{URL::route('sessions.login')}}" class="link">
            <i class="entypo-lock"></i>
            Return to Login Page
            </a>
            <br />
         </div>
      </div>
   </div>
   @stop
