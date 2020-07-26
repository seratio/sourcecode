
@extends('layout.admin_default')

@section('title')
login::
@parent
@stop

@section('content')



<body class="page-body login-page login-form-fall">
	<div class="login-container">
		<div class="login-header login-caret">
			<div class="login-content">
				<a href= "{{URL::route('home.index')}}" class="logo">
					{{ HTML::image('assets_backend/images/logo.png', 'SE Ratio', array('width' => '200')) }}
				</a>

				<p class="description">
					@if (Session::has('success'))
					<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong> {{ Session::get('success') }}</strong>
					</div>
					@endif
				</p>
				<p class="description">
					@if (Session::has('message'))
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong> {{ Session::get('message') }}</strong>
					</div>
					@endif
				</p>

				<p class="description">
					@if($errors->has())
					@foreach ($errors->all() as $error)
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong> {{ $error }}</strong>
					</div>
					@endforeach
					@endif
				</p>
				<!-- progress bar indicator -->
				<div class="login-progressbar-indicator">
					<h3>43%</h3>
					<span>logging in...</span>
				</div>
			</div>

		</div>

		<div class="login-progressbar">
			<div></div>
		</div>

		<div class="login-form">

			<div class="login-content">

				

				{{ Form::open(array('route' => 'modernslavery.action', 'class' => 'form')) }}
				<div class="form-group">
					{{ Form::text('customer_number', '', array('class' => 'form-control', 'placeholder' => 'Customer Number', 'required')) }}
					@if ($errors->has('customer_number')) <p class="help-block">{{ $errors->first('customer_number') }}</p> @endif
				</div>
				<div class="form-group">
					{{ Form::text('supplier_number', '', array('class' => 'form-control', 'placeholder' => 'Supplier Number', 'required')) }}
					@if ($errors->has('supplier_number')) <p class="help-block">{{ $errors->first('supplier_number') }}</p> @endif
				</div>
				
				{{ Form::submit('Get Access', ['class' => 'btn btn-lg btn-success btn-block']) }}              


				{{ Form::close() }}
				
				<!-- Implemented in v1.1.4 -->
				
				@stop
