<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="{{{ asset('assets_backend/images/logo.png') }}}">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Neon Admin Panel" />
<meta name="author" content="" />
<title>
@section('title')
seratio&trade;
@show
</title>

{{ HTML::script ('assets_backend/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css') }}

{{ HTML::style ('assets_backend/css/font-icons/entypo/css/entypo.css') }}

{{ HTML::style ('https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic')}}

{{ HTML::style ('assets_backend/css/bootstrap.css')}}

{{ HTML::style ('assets_backend/css/neon-core.css')}}

{{ HTML::style ('assets_backend/css/neon-theme.css')}}

{{ HTML::style ('assets_backend/css/neon-forms.css')}}

{{ HTML::style ('assets_backend/css/custom.css')}}

{{ HTML::script ('assets_backend/js/jquery-1.11.0.min.js') }}

<script>$.noConflict();</script>

<!--[if lt IE 9]><script src="public/assets_backend/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

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
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<strong> {{ Session::get('message') }}</strong>
		</div>
		@endif
		@if (Session::has('error_msg'))
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<strong> {{ Session::get('error_msg') }}</strong>
		</div>
		@endif
		@if($errors->has())
		@foreach ($errors->all() as $error)
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
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

	<div class="form-login-error">
		<h3>Invalid login</h3>
		<p>Enter <strong>demo</strong>/<strong>demo</strong> as login and password.</p>
	</div>

	{{ Form::open(array('route' => array('password.update', $token))) }}
	{{ Form::hidden('token', $token) }}
	<div class="form-group">
		{{ Form::email('email', '', array('class' => 'form-control', 'placeholder' => 'E-Mail', 'required')) }}

		@if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
	</div>

	<div class="form-group">
		{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required')) }}
		@if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
	</div>

	<div class="form-group">
		{{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Password Confirmation', 'required')) }}
		@if ($errors->has('password_confirmation')) <p class="help-block">{{ $errors->first('password_confirmation') }}</p> @endif
	</div>
	{{ Form::submit('Submit', ['class' => 'btn btn-lg btn-success btn-block']) }}


	{{ Form::close() }}



	{{ HTML::script ('assets_backend/js/gsap/main-gsap.js') }}

	{{ HTML::script ('assets_backend/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js') }}

	{{ HTML::script ('assets_backend/js/bootstrap.js') }}

	{{ HTML::script ('assets_backend/js/joinable.js') }}

	{{ HTML::script ('assets_backend/js/resizeable.js') }}

	{{ HTML::script ('assets_backend/js/neon-api.js') }}

	{{ HTML::script ('assets_backend/js/jquery.validate.min.js') }}

	{{ HTML::script ('assets_backend/js/neon-login.js') }}

	<!-- JavaScripts initializations and stuff -->
	{{ HTML::script ('assets_backend/js/neon-custom.js') }}

	<!-- Demo Settings -->
	{{ HTML::script ('assets_backend/js/neon-demo.js') }}


</body>
</html>
