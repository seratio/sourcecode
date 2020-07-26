
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
					@if (Session::has('message'))
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong> {{ Session::get('message') }}</strong>
					</div>
					@endif
					@if (Session::has('error'))
					<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong> {{ Session::get('error') }}</strong>
					</div>
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

				<div class="form-login-error">
					<h3>Invalid login</h3>
					<p>Enter <strong>demo</strong>/<strong>demo</strong> as login and password.</p>
				</div>

				{{ Form::open(array('route' => 'sessions.action', 'class' => 'form')) }}
				<div class="form-group">
					{{ Form::email('email', '', array('class' => 'form-control', 'placeholder' => 'E-Mail', 'required')) }}

					@if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
				</div>

				<div class="form-group">
					{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required')) }}
					@if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
				</div>
				{{ Form::submit('Login', ['class' => 'btn btn-lg btn-success btn-block']) }}              


				{{ Form::close() }}
				
				<!-- Implemented in v1.1.4 -->
				<div class="form-group">
					<em>- or -</em>
				</div>

				<div class="form-group">
					<a href= "{{URL::route('users.create')}}" class="btn btn-lg btn-warning btn-block" title="Create an Account">Create an Account</a><br>
					<a href= "{{URL::route('frontend.pv')}}" class="btn btn-lg btn-warning btn-block" title="For Personal Value signup, please click here">For Personal Value signup, please click here</a><br>
					<!--<a href= "{{URL::route('users.create', 'ms') }}" class="btn btn-lg btn-warning btn-block" title="For Modern Slavory signup, please click here">For Modern Slavory signup, please click here</a>-->
				</div>

				

				<div class="login-bottom-links">
					<a href="" data-toggle="modal" data-target="#myModal"><strong>Forgot Password?</strong></a>

				</div>	
				<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h1 class="text-center">What's My Password?</h1>
							</div>
							<div class="modal-body">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="text-center">

												<p>If you have forgotten your password you can reset it here.</p>
												<div class="panel-body">
													<fieldset>
														{{ Form::open(array('route' => 'password.request')) }}
														<div class="form-group">
															<input class="form-control input-lg" placeholder="E-mail Address" name="email" type="email" required>
														</div>
														<input class="btn btn-lg btn-primary btn-block" value="Send My Password" type="submit">
														{{ Form::close() }}
													</fieldset>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>	
				</div>
				@stop
