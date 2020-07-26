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
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-71812286-1', 'auto');
  ga('send', 'pageview');

</script>
</head>


@yield('content')


<!-- Bottom scripts (common) -->

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
