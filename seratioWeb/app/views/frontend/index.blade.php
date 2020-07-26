<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="google-site-verification" content="VisTkJwqSJexIZirImYPSzgsinPUdwOYUeO6ssmHLMA" />
	<title>
		seratio®
	</title>

	<link href='https://fonts.googleapis.com/css?family=Roboto:300,700' rel='stylesheet' type='text/css'>
	{{ HTML::style('new_assets/css/bootstrap.css')}}
	{{ HTML::style(captcha_layout_stylesheet_url()) }}
	<!-- Bootstrap core CSS -->
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<!-- Custom styles for this template -->
	<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">-->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

	<link rel="shortcut icon" href="{{{ asset('new_assets/images/logo.png') }}}">

	<!-- Latest compiled and minified JavaScript -->
	{{ HTML::script('assets_frontend/js/jquery-2.1.1.min.js')}}
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	{{ HTML::style('new_assets/css/demo.css')}}

	{{ HTML::style('new_assets/css/effect1.css')}}

	{{ HTML::script('new_assets/js/modernizr.custom.js')}}

	{{ HTML::style('new_assets/css/custom-styles.css')}}

	{{ HTML::style('assets_frontend/css/jquery.cookiebar.css')}}
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-71812286-1', 'auto');
		ga('send', 'pageview');

	</script>
</head>

<!-- ==================================== -->

<body>
	<!-- initial header -->
	<!-- top bar -->
	<!-- main content -->
	<div class="all-wrap pagewrap" id="pagewrap">
		<div class="containerr show" id="page-1">
			<div class="socialmedia">
				<a href="{{URL::to('https://www.facebook.com/TheCCEG')}}" target="_blank" class="facebook"></a>
				<a href="{{URL::to('https://plus.google.com/+CcegOrgUk/')}}" target="_blank" class="googlep"></a>
				<a href="{{URL::to('https://www.linkedin.com/company/centre-for-citizenship-enterprise-and-governance')}}" target="_blank" class="linkedin"></a>
				<a href="{{URL::to('https://www.youtube.com/user/TheCCEG')}}" target="_blank" class="youtube"></a>
				<!--<a href="{{URL::to('https://twitter.com/theCCEG')}}" target="_blank" class="twitter"></a>-->
				<a href="{{URL::to('http://theseratio.tumblr.com')}}" class="tumb" target="_blank"></a>
				<a href="{{URL::to('https://instagram.com/theseratio')}}" class="instagram" target="_blank"></a>
				<a href="{{URL::to('http://thecceg.blogspot.co.uk/')}}" class="blog" target="_blank"></a>
				<a href="{{URL::to('https://www.seratio.org')}}" class="edu" target="_blank"></a>


			</div>
			<div class="outer-wrapper">
				<div class="container">
					<div class="row">
						@if (Session::has('message'))
						<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong> {{ Session::get('message') }}</strong>
						</div>
						@endif
						@if($errors->has())
						@foreach ($errors->all() as $error)
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong> {{ $error }}</strong>
						</div>
						@endforeach
						@endif
						<!--first row-->
						<div class="col-md-12">
							<div class="logo-wrapper">
								<a href="{{URL::to('https://seratio.com')}}">{{ HTML::image('new_assets/images/logo.png', 'Seratio') }}</a>
								<div class="lineone"></div>
							</div>
						</div>
						<!--first row-->
						<!--3rd row-->
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-2">

							<div class="clearfix"></div>
						</div>
						<div class="col-md-3 ">

						</div>
						<div class="col-md-3">
							<div class="box onee">
								<div class="revert">
									<a href="{{URL::to('http://serat.io/')}}" target="_blank">
										{{ HTML::image('new_assets/images/personal.png') }}
									</a>
								</div>
							</div>

							<div class="clearfix"></div>

						</div>

						<!--3rd row-->


						<!--2nd row-->

						<div class="col-md-4"></div>
						<div class="col-md-2">
							<div class="box threee">
								<div class="revert">
									<a class="pageload-link" href="#ethical">
										{{ HTML::image('new_assets/images/ethical.png') }}
									</a>
								</div>
							</div>
						</div>





						<div class="col-md-4">
							<div class="box one">
								<div class="revert">
									<a class="pageload-link" href="#health">
										{{ HTML::image('new_assets/images/health.png') }}
									</a>
								</div>
							</div>

							<div class="box two">
								<div class="revert">
									<a href="{{URL::to('http://sectormarketplace.com/')}}" target="_blank">
										{{ HTML::image('new_assets/images/forum.png') }}
									</a>
								</div>
							</div>

							<div class="clearfix"></div>

						</div>
						<!--2nd row row-->
						<div class="box bit">
								<div class="revert">
									<a href="{{URL::to('http://www.bisgit.org/')}}" target="_blank">
										{{ HTML::image('new_assets/images/bit.png') }}
									</a>
								</div>
							</div>

						<!--3rd row-->
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-2">
							<div class="box three">
								<div class="revert">
									<a href="{{URL::to('http://www.cceg.org.uk/')}}" target="_blank">
										{{ HTML::image('new_assets/images/think.png') }}
									</a>
								</div>
							</div>


							<div class="clearfix"></div>
						</div>

						<div class="col-md-3 bigbox_wrapper">
							<div class="big_box">
								<div class="revert">
									<a href="#">{{ HTML::image('new_assets/images/logo-white.png') }} </a>
									<p>making everything intangible in the world
										measurable, applicable and deliverable</p>
									</div>
								</div>
								<div class="lineTwo"></div>
								<div class="arrow">{{ HTML::image('new_assets/images/arrow.png') }}</div>
							</div>
							<div class="col-md-3">
								<div class="box four">
									<div class="revert">
										<a class="pageload-link" href="#arts">
											{{ HTML::image('new_assets/images/art.png') }}
										</a>
									</div>
								</div>

								<div class="clearfix"></div>

								<div class="box pro">
									<div class="revert">
										<a href="{{URL::route('sessions.login')}}">
											{{ HTML::image('new_assets/images/demo.png') }}
										</a>
									</div>
								</div>

								<div class="box block">
									<div class="revert">
										<a href="{{URL::to('https://github.com/seratio/whitepaper')}}" target="_blank">
											{{ HTML::image('new_assets/images/block.png') }}
										</a>
									</div>
								</div>

								<div class="box eu">
									<div class="revert">
										<a href="{{URL::to('http://www.socialvalue.eu')}}" target="_blank">
											{{ HTML::image('new_assets/images/eu.png') }}
										</a>
									</div>
								</div>

								<div class="box city_block">
									<div class="revert">
										<a href="{{URL::to('https://www.cityblockcha.in/')}}" target="_blank">
											{{ HTML::image('new_assets/images/city_assets.png') }}
										</a>
									</div>
								</div>

								<div class="box cyber_futures">
									<div class="revert">
										<a href="{{URL::to('https://list.ly/list/1Zmw-cyber-futures')}}" target="_blank">
											{{ HTML::image('new_assets/images/cyber-future.png') }}
										</a>
									</div>
								</div>

								<div class="box coin1">
									<div class="revert">
										<a href="{{URL::to('https://www.rothbadi.com/')}}" target="_blank">
											{{ HTML::image('new_assets/images/COIN1.png') }}
										</a>
									</div>
								</div>

								<div class="box block_demo">
									<div class="revert">
										<a href="{{URL::to('http://blockchain.seratio.com/')}}" target="_blank">
											{{ HTML::image('new_assets/images/block_demo.png') }}
										</a>
									</div>
								</div>

								<div class="box cceg_block">
									<div class="revert">
										<a href="{{URL::to('https://mypad.northampton.ac.uk/cceg/')}}" target="_blank">
											{{ HTML::image('new_assets/images/cceg_block.png') }}
										</a>
									</div>
								</div>


							</div>
							<!--3rd row-->

							<!--fourth row-->
							<div class="clearfix"></div>

							<div class="col-md-2">&nbsp;</div>



							<div class="col-md-4">
								<div class="box five">
									<div class="revert">
										<a href="{{URL::to('http://www.modernslavery.uk')}}" target="_blank">
											{{ HTML::image('new_assets/images/modern.png') }}
										</a>
									</div>
								</div>
							</div>

							<div class="col-md-1">&nbsp;</div>
							<div class="col-md-3">
								<div class="box six">
									<div class="revert">

										<a href="{{URL::to('https://issuu.com/seratio')}}" target="_blank">
											{{ HTML::image('new_assets/images/SVIR.png') }}
										</a>
									</div>
								</div>
							</div>

							<div class="col-md-2">&nbsp;</div>

							<!--fifth row-->
							<div class="clearfix"></div>

							<div class="col-md-3">
								<div class="box eight">
									<div class="revert">
										<a href="{{URL::to('http://www.publicvalue.online')}}" target="_blank">
											{{ HTML::image('new_assets/images/social.png') }}
										</a>
									</div>
								</div>

								<div class="box fivee">
									<div class="revert">
										<a href="{{URL::to('http://www.cceg.org.uk/membership')}}" target="_blank">
											{{ HTML::image('new_assets/images/join.png') }}
										</a>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="box seven">
									<div class="revert">
										<a class="pageload-link" href="#phron">
											{{ HTML::image('new_assets/images/iov.png') }}
										</a>

									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="box sevenn">
									<div class="revert">
										<a href="#">
											{{ HTML::image('new_assets/images/capacity.png') }}
										</a>

									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="box sevennn">
									<div class="revert">
										<a class="pageload-link" href="#info">
											{{ HTML::image('new_assets/images/info.png') }}
										</a>

									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="box ten">
									<div class="revert">
										<a href="{{URL::to('http://www.socialearningsratio.com/')}}" target="_blank">
											{{ HTML::image('new_assets/images/case_study.png') }}
										</a>

									</div>
								</div>
							</div>


							<div class="col-md-3">&nbsp;</div>
							<div class="clearfix"></div>

							<div class="clearfix"></div>
							<div class="col-md-2"></div>
							<div class="col-md-8 form-wrapper">
								{{ Form::open(array('url' => 'subscribe/unsubscribe')) }}
								{{ Form::email('email', '', array('class' => 'text-muted', 'placeholder' => 'Enter your email', 'required', 'width' => '20')) }}

								{{ Form::submit('SUBSCRIBE', ['class' => 'btn btn-success', 'name' => 'subscribe', 'id' => 'subscribe']) }}
								{{ Form::submit('UNSUBSCRIBE', ['class' => 'btn btn-success', 'name' => 'unsubscribe', 'id' => 'unsubscribe']) }}
								{{ Form::close() }}

								<h3>OUR MISSION IS TO TRANSLATE COMPLEX INPUTS INTO SIMPLE, SINGULAR MEASUREMENTS OF TRUE INTANGIBLE OUTCOMES </h3>
							</div>
							<div class="col-md-2"></div>
							<div class="clearfix"></div>
							<div class="col-md-12 footer-info">
								<p>
									We use a blended approach harnessing the power of social physics, big data, machine learning, sentiment analysis,
									neuroeconomics, impact analytics

									Understanding how to use big data to improve companies, cities and government … people's lives …
									in a way that focuses first and foremost on APPLICATION
								</p>
							</div>


						</div>
					</div>

					<footer>
						<p><a class="pageload-link" href="#about">About</a> | <a class="pageload-link" href="#citizenship">Citizenship</a> | <a  class="pageload-link" href="#seratio">S/E Ratio</a> |
							<a href="https://www.seratio.org/home" target="_blank">MOOC</a> |
							<a href="http://ow.ly/LN0zX" target="_blank">Review</a> |
							<a class="pageload-link" href="#benchmark">Benchmark</a> |
							<a class="pageload-link" href="#partners">Partners</a>|
							<a href="{{URL::route('sessions.login')}}">My Account</a> |
							<a href="{{URL::route('frontend.team')}}">Our Team</a> |
							<a href="#">Support</a> |
							<a href="#">Legal</a> |
							<a href="#">News</a> |
							<a target="_blank" href="{{URL::asset('assets_frontend/privacy_policy.pdf')}}">Privacy Policy</a> |
							<a class="pageload-link" href="#contact">Contact</a>
						</p>
						<p>© 2020 seratio®  All rights reserved Beta Version 1.4</p>
					</footer>
				</div>

				<div id="loader" class="pageload-overlay" data-opening="m -10,-10 0,80 100,0 0,-80 z m 50,-30.5 0,70.5 0,70 0,-70 z">
					<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none" >
						<path d="m -10,-10 0,80 100,0 0,-80 z M 40,-40.5 120,30 40,100 -40,30 z"></path>
					</svg>
				</div><!-- /pageload-overlay -->

			</div>



			<!-- Personal Value content -->
			<div class="containerr" id="personal" style="overflow: scroll;">
				<!-- Top Navigation -->
				<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<h2><span>Personal Value</span></h2>
								<br>
								<p>
									<img src="https://www.seratio.com/assets_frontend/images/pv_pic1.jpg" width="1200" height="600" alt="">
								</p>

								{{ Form::open(array('action' => 'SubscribeController@store', 'class'=>'form-group')) }}
								<div class="col-lg-12 col-md-offset-4">
									<div class="col-xs-4">
										{{ Form::email('email', '', array('placeholder' => 'E-Mail', 'required','class' => 'form-control')) }}
										<br>
										{{ Form::number('phone', '', array('placeholder' => 'Enter your phone number with country code', 'class'=>'form-control')) }}
										<br>

										{{ Form::submit('Subscribe', ['class' => 'btn btn-success']) }}

										{{ Form::close() }}

										<br>
										<br>
										<a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
									</div>

								</div>

							</div>
						</div>
					</div>

				</section>
			</div><!-- /container -->


			<!-- Health content -->
			<div class="containerr" id="health">
				<!-- Top Navigation -->
				<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<h2><span>Health & Wellbeing</span></h2>
								<br>
								<p>
									Happiness, Health and Wellbeing – often quoted as the most
									important characteristic of life itself. Your blood pressure, the
									amount of money in your bank, the number of times you get to
									see your loved ones? Are these really the only measurements
									of happiness that we have? At Seratio we posed the same
									question and are working tirelessly to articulate this most
									important index. <br><br>
									Currently in Beta testing, please subscribe to MEMBERSHIP to be kept informed the release date.
								</p>
								<br>
								{{ Form::open(array('action' => 'SubscribeController@store')) }}
								{{ Form::email('email', '', array('class' => 'text-muted', 'placeholder' => 'Enter your email', 'required', 'width' => '20')) }}

								{{ Form::submit('SUBSCRIBE', ['class' => 'btn btn-success']) }}
								{{ Form::close() }}


							</div>
						</div>
					</div>

				</section>
			</div><!-- /container -->

				<!-- Health content -->
			<div class="containerr" id="phron">
				<!-- Top Navigation -->
				<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<h2><span>Internet of Value</span></h2>
								<br>
								<p>
									Welcome.<br>
									Step into Phronesis World and experience the Feel Good Factor:<br>

									A world where the goodness we all do is recognised and rewarded.<br>
									A simple informed world enabling good purchases and choices<br>
									A currency and exchange for good. <br><br>
									Get regular updates: Subscribe here and support us in making Phronesis world a reality<br>
								</p>
								<br>
								{{ Form::open(array('action' => 'SubscribeController@store')) }}
								{{ Form::email('email', '', array('class' => 'text-muted', 'placeholder' => 'Enter your email', 'required', 'width' => '20')) }}

								{{ Form::submit('SUBSCRIBE', ['class' => 'btn btn-success']) }}
								{{ Form::close() }}

								<br><br><iframe width="560" height="315" src="https://www.youtube.com/embed/pHe0ApyeoN4" frameborder="0" allowfullscreen></iframe><br>

								<a style="color:black" href="https://www.youtube.com/watch?v=pHe0ApyeoN4">Phronesis YouTube video - Link for mobile users</a>

								<br><br>

								<iframe id="iframe_container" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" width="550" height="400" src="https://prezi.com/embed/zrjd2hpjkzls/?bgcolor=ffffff&amp;lock_to_path=0&amp;autoplay=0&amp;autohide_ctrls=0&amp;landing_data=bHVZZmNaNDBIWnNjdEVENDRhZDFNZGNIUE1ieUxRN1E0K1psaG5TNjgrbjBuc25zenlRcllqYjRVdFlhTExkRVEyQT0&amp;landing_sign=FPHrLy1w4X5to3c2bmTOU5eW8LXArnP1SB9lqSpsA5s"></iframe><br>

								<a style="color:black" href="https://prezi.com/zrjd2hpjkzls/the-phronesis-ii-feel-good-world/?utm_campaign=share&utm_medium=copy">The Phronesis II: Feel Good World  Prezi - Link for mobile users</a>
								<a style="color:black" href="https://youtu.be/kTiUeHAvBFc">Phronesis II: YouTube Link</a>
								<br><br>

								<iframe width="560" height="315" src="https://www.youtube.com/embed/tdjyoxfuhHs" frameborder="0" allowfullscreen></iframe><br>

								<a style="color:black" href="https://youtu.be/tdjyoxfuhHs">Phronesis III: YouTube Link</a>


							</div>
						</div>
					</div>

				</section>
			</div><!-- /container -->

			<!--  The Arts content -->
			<div class="containerr" id="arts">
				<!-- Top Navigation -->
				<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<h2><span>The Arts</span></h2>
								<br>
								<p align="justify">
									The Arts are what makes the human race thrive, from cultural development to the cohesion of entire communities an nations it serves as a bedrock to humanity and society on earth. Arts take many forms – from a historical to a cultural context, dance and music to theatre and the visual arts, the arts give humans a unique means of expression. Most importantly the arts have served as an effective mechanism for people to embed morality and social impacts capturing their passions and emotions whilst breaking down barriers, be they racial, political, cultural or financial. The true impact of the arts upon society has seldom been measured forma social perspective or a holistic value perspective. Its ability to look at the way we explore new ideas, subject matter, and cultures – and the direct correlations that has upon special good in both quantitative and qualitative ways has never been universally agreed. At Seratio we are not only developing these unique methods of measuring the impacts arts have – but we are turning our attention to the way in which investment in the arts has social returns in monetary values within communities and how it can also help the public sector authorities in all economies around the world, regardless of size or strength.
								</br></br>The Arts and its variety of offshoots communicates to us  and improves us in ways that help us understand more about each other and enhance our lives in ways we have not fully understood or explored. At Seratio we hope to become the forerunners to a new perspective on the impacts of arts in society – we staunchly believe that we must as a human race continue to find a place for arts programs and partnerships not only for what it teaches students about art, but for what it teaches us all about the world we live in.<br><br>
								Currently in Beta testing, please subscribe to MEMBERSHIP to be kept informed the release date.
							</p>
							<br>

								{{ Form::open(array('action' => 'SubscribeController@store')) }}
								{{ Form::email('email', '', array('class' => 'text-muted', 'placeholder' => 'Enter your email', 'required', 'width' => '20')) }}

								{{ Form::submit('SUBSCRIBE', ['class' => 'btn btn-success']) }}
								{{ Form::close() }}




						</div>
					</div>
				</div>

			</section>
		</div><!-- /container -->

		<!-- Domestic Violence content -->
		<div class="containerr" id="domestic">
			<!-- Top Navigation -->
			<section>

				<p><a class="pageload-link goback" href="#page-1">Go back</a></p>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2><span>Domestic Violence</span></h2>
							<br>
							<p>
								Despite 6,000 years of living in organised societies humankind

								still faces an unprecedented challenge in the context of

								equality. Violence in particular and certain gender and ethnic

								groups has been widely broadcast by the media. Despite the

								best efforts of courageous campaigners who have fought

								against injustice, the inequalities continue often allied to

								aggression. We intend to empower this area with some tangible

								metrics to provide deep learning through an analytical platform

								which goes beyond exposure
							</p>
							<br>
							<a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>


						</div>
					</div>
				</div>
			</section>
		</div>

		<!-- Animal Welfare -->
		<div class="containerr" id="animal">
			<!-- Top Navigation -->
			<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2><span>Animal Welfare</span></h2>
							<br>
							<p>
								We intend to build a universal animal welfare platform with

								detailed analytics and forecasting capabilities to monitor the

								most endangered species, those animals which are hunted or

								abused with real-time, social impact metrics monitoring supply

								chains which exploit or abuse animals around the globe. It will

								be the world’s only comprehensive monitoring and reporting

								platform
							</p>
							<br>
							<a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
						</div>
					</div>
				</div>

			</section>
		</div><!-- /container -->



		<!-- Happy Cities -->
		<div class="containerr" id="happy">
			<!-- Top Navigation -->
			<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2><span>Happy Cities</span></h2>
							<br>
							<p align="justify">
								We believe that the formation and investment of funds into social impact projects which foster the notion of the “happy city” not only is an opportunity for its inhabitants but also for corporations and public bodies which interact with those cities. Research from some of our partners in the world of academia clearly shows that the correlation between happiness and investment is particularly strong for young and disruptive SMEs which the Harvard business review terms “less codified decision making process” powered by the “younger and less experienced managers who are more likely to be influenced by sentiment.’” For us at Seratio the truth comes from sophisticated sentiment analysis – knowing what inhabitants of a city think and feel about their surroundings and articulating that value in terms of evidence based numbers. We also believe that we need to create a more fair and equal society using the very latest technology and the people of the world in a united fashion – a sentiment backed by research which shows that the  relationship between wealth, happiness and equality “was also stronger in places where happiness was spread more equally”. We have worked closely with many corporate partners and increasingly we are finding that firms seem to invest more in places where most people are relatively happy – helping the rich to become richer rather than focusing on areas of need. The solutions we have developed concentrate on these places with happiness “inequality, or large gaps in the distribution of well-being.” They show corporates where their social and financial investment can make the biggest REAL impacts and how they can articulate that return on investment to their stakeholders in terms of definitive value.
							</p>
							<br>
							<a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
						</div>
					</div>
				</div>

			</section>
		</div><!-- /container -->


		<!-- Ethical Leadership -->
		<div class="containerr" id="ethical">
			<!-- Top Navigation -->
			<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2><span>Ethical Leadership</span></h2>
							<br>
							<p align="justify">
								Currently in Beta testing, please subscribe to MEMBERSHIP to be kept informed the release date.
							</p>
							<br>
							{{ Form::open(array('action' => 'SubscribeController@store')) }}
								{{ Form::email('email', '', array('class' => 'text-muted', 'placeholder' => 'Enter your email', 'required', 'width' => '20')) }}

								{{ Form::submit('SUBSCRIBE', ['class' => 'btn btn-success']) }}
								{{ Form::close() }}
						</div>
					</div>
				</div>

			</section>
		</div><!-- /container -->


		<!-- Impact Investment -->
		<div class="containerr" id="impact" style="height:180%;">
			<!-- Top Navigation -->
			<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2><span>Impact Investment</span></h2>
							<br>
							<p align="justify">
								The Banking and Financial Services sectors are set for transformation as their role, industry structure and commercial environments become disrupted by social innovation and a greater awareness of societal change.
								The major trends currently reshaping the global economy have been established by the increasing awareness an.
								This progressive transformation means that many businesses will be unrecognisable by the end of the decade and evolution of market leaders or constituents of many leading stock indices could shaped by this shift.
								Those organisations which remain at the very cusp of social innovation and have the appropriate tools and frameworks to create smart and agile strategies will inevitably leapfrog more lethargic competitors.
								What major corporations will have to ask themselves is will their existing business model still be relevant in the new global economy? How can they take advantage of the shake-up ahead? How can they measure, record or even utilise something that they cannot understand?
								The answer comes from a hybridised solution from SERATIO
							</br></br>
							We have developed the appropriate metrics to give corporations of any size the ability to investigate and forecast the potential return on investment by appropriately resourcing impact investments.
							Further still, using the very latest sentiment analysis, scenario forecasting, benchmarking and deep machine learning we are the leading authority in measuring “the intangible agents of change”.
							For every single financial metric and key performance indictor we have developed the analogous measurement methodology which translates and automates intangibles into a measurement that your firm can use to directly influence all corporate activity, from strategy to your bottom line. We have done this by combining the most powerful manual and digitally automated technologies – from mathematical modelling and formula creation, to the use of the semantic web, machine learning and artificial intelligence.
						</br></br>
						Founded in the UK, Seratio brings together to very best academic and business world talent. It is born out of the last financial crisis and has been used in many pioneering innovations in finance for impact, for example in the development of Social Impact Bonds as a structured finance product for social impact, the creation of socio-economic metrics for corporate stock indexes and in measuring intangible effects that your firm may have upon obscure but highly important societal problems such as slavery, animal welfare and violence.
						It is the world's only scalable, verifiable, cost effective and automated metric – measuring any dimension of social impact every 10 seconds.
					</br></br>
					We have ensured the technology is 100% translatable and transferable – whether you use Microsoft Excel or the most complex Big Data or Artificial Intelligence system – even pen and paper can be automated and translated by SERATIO
				</p>
				<br>
				<img src="https://www.seratio.com/assets_frontend/images/ser.png">
				<br><br>
				<a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
			</div>
		</div>
	</div>
</section>
</div><!-- /container -->

<!-- Social Value -->
<div class="containerr" id="social">
	<!-- Top Navigation -->
	<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><span>Social Value</span></h2>
					<br>
					<p>
						Named as “the most rapidly adopted social impact metric in

						the world” (The Vatican, 2014), seratio has become the leading

						metric in public sector procurement. We are helping all public

						sector agencies procure in a way that in compliant to local

						jurisdictions – implanting more social return on every contract
					</p>

					<br>
					<a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>

				</div>
			</div>
		</div>

	</section>
</div><!-- /container -->

<!--Modern Slavery-->
<div class="containerr" id="modern">
	<!-- Top Navigation -->
	<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><span>Modern Slavery</span></h2>
					<br>
					<p>
						The tip of this iceberg is trafficking, agricultural working,

						domestics, etc but under the media glare is the Transparency

						in Supply Chains where most of the problem lies. But in the

						words of the great American abolitionist William Lloyd Garrison

						himself, seratio “will be as harsh as truth, and as uncompromising

						as justice ... in earnest ... will not equivocate ... will not excuse ... will not

						retreat a single inch — AND I WILL BE HEARD....
					</p>

					<br>
					<a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>

				</div>
			</div>
		</div>

	</section>
</div><!-- /container -->

<!-- Hyper Locality-->
<div class="containerr" id="hyper">
	<!-- Top Navigation -->
	<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><span>Hyper Locality</span></h2>
					<br>
					<p align="justify">
						We all want to know more about the places we live, work or spend our social lives within. Understanding our environment, the complex interactions between people and physical assets such as parks, buildings and public spaces is not only an innate part of our human behaviour but also gives us wisdom on social norms and boundaries in the places we interact with. Ask yourself one very telling question – do you really know what is going on in your locality? Are you connected with your community and do you know the “word on the street”?

						This complex and ever changing information is what hyperlocality looks at – it is the data that is created around a well-defined community or the interaction between communities and the physical landscape around them. The world is globalising at an alarming rate and technology has served to accelerate the interactions and interdependencies communities have between each other, be it economic or social, each interaction is a form of trade. Hyperlocality investigates the real concerns of the population in any given community by looking at the trends in data, the conversations taking place by participants in any given community, the boundaries of which are fluid and ever evolving.
					</br>
				</br>
				At Seratio we use hyperlocality to extract important intelligence from communities and to help external and internal agents of change build community capacity.
				We help target the most effective methods of community growth be it social or economic by robustly determining which methods implant real value and social improvement - going beyond the now outdated concept of social investment as a blind science.
			</br></br>
			We use the very latest technology, leveraging the power of the emergent ecology of data to exploit these channels in order to measure and define the data behind hyperlocal events. These includes but are not limited to user interactions, heat map GIS analysis, aggregators, publication mechanisms, social media and behaviours of agents within a community unit. We focus on what the individual does within a community and the social value they impart upon their surroundings as well as the collective impacts of an entire community. Things need to be made simple for a decision to be reached and actions to be taken - so we can articulate the outcome in one single number. our methods are used to inform public sector services, corporate agents and any other interested group who form part of that community – in a non-partisan and unbiased manner.
		</p>
		<br>
		<a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>

	</div>
</div>
</div>
</section>
</div><!-- /container -->

<!-- Consumer Index -->
<div class="containerr" id="consumer">
	<!-- Top Navigation -->
	<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><span>Consumer Index</span></h2>
					<br>
					<p align="justify">
						Thus far consumer orientated markets have concentrated upon developing measurements that examine the simplistic financial characteristics of the items households purchase, be they tangible goods such as food items or services such as car insurance.  The financial and economic focus of this “commoditisation of goods or services” have increasingly become essential components of capitalist societies.
						The major problem with current methodologies is that they do not give a full picture of the true value of the good or service the individual is purchasing. Take the standard Consumer Pricing Index (CPI) as a classic example. It is calculated by taking the expected or observed price changes for each item in the predetermined basket of goods and averaging them; then these goods are weighted according to their importance – an importance again predetermined by an economist’s model – not by you, the end user or consumer. Changes in CPI are used to assess price changes associated with the cost of living. These are very important because the corporations who make the goods or provide the service will adjust the pricing accordingly which affects you, the governments and public authorities of the world will also influence tax rates and assignment of political priorities based on the demand levels attributed to the CPI – which again directly affects you, the consumer.</br>
					</br>
					At Seratio we know the status quo in the industry of measuring and rating goods and services is not a reflection of the true value. We feel that as the agents of change the consumer should not be veiled by purely financial and economic measurements – they should have access to metrics and measurements that give them the detailed knowledge they need understand what they are buying and what affect that will have upon society at large. We combine the financial value with all intangible values attributed to the product or service you are about to purchase. We dare to ask questions that many corporations probably would not want you to know – as it may influence what you buy. Take the example of a T-shirt manufactured by a sweatshop in Asia or Africa – if you the consumer knew the true extent of social, political, economic and environmental damage that is done by you purchasing that item, you may think twice. At Seratio we go further – we attribute those measurements around you, we will be able to articulate the action of buying that item and benchmarking against your other purchasing habits, telling you what your consumer behaviour does to the society around you but also what good or bad you do around the world. It works two ways also – each and every corporation you interact with is measured in the same way – so now the consumer and the corporate are both equally responsible to make more informed choices.
				</p>
				<br>
				<a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
			</div>
		</div>
	</div>
</section>
</div><!-- /container -->

<!-- Start About Us Section -->
<div class="containerr" id="about">
	<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><span>About Us</span></h2>
					<br>
					<p align="center">At S/Eratio (“seratio”) we are not a consultancy, rating agency or ‘special advisors’ – instead we focus upon turning the intangible measurements that you have always wondered about into something very real and applicable to you.  <br></br>
						Our sole objective of being able to turn intangible outcomes in real, verifiable and accurate measurements. We do this using the very latest in academic knowledge which combines social science, outcome metrics, data mining and sentiment analysis.  The logical outcome is an elite set of supermetrics which are constructed using sentiment analysis, geo-located with future proof analytical technology reinforced with the latest big data mining and machine learning technology.<br></br>
						Who do we serve? You - the citizens of the world – and we believe in multi-stakeholder engagement translated onto a citizenship map. <br></br>
						We aim to inform and empower  those responsible for making the decisions which ultimately have a positive or negative impact upon the world and all of those who aim to make a difference.  These people are not just those in executive boards of major corporations, those who reside in positions of power in government, but you, a consumer, a citizen of the world.  We focus upon informing the societies of the world<br></br>
						We believe that after decades of so called change agents trying to pioneer models of transformation from the top down – there now needs to be accurate measurements, provided by an elite, non-partisan entity which delivers the truth into the hands of the people. <br></br>
					</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12" align="center">
					<div class="custom-tab">
						<ul class="nav nav-tabs nav-justified" role="tablist">
							<li class="active"><a href="#tab-1" role="tab" data-toggle="tab" style="color:black;">Thought Leadership </a></li>
							<li><a href="#tab-2" role="tab" data-toggle="tab" style="color:black;">Total Value</a></li>
							<li><a href="#tab-3" role="tab" data-toggle="tab" style="color:black;">Social Earnings Ratio</a></li>
							<li><a href="#tab-6" role="tab" data-toggle="tab" style="color:black;">Milestones</a></li>
						</ul>

						<div class="tab-content">

							<div class="tab-pane active" id="tab-1">
								<br>
								<p>Seratio have devised the most relevant, scalable and accurate metric for measuring social value. For decades many have tried to make sense of what has been until now truly intangible – devising “measurements” that simply fail to take consideration the “real effects” into account. Thus far such measurements and metrics have been poorly adopted, subject to bias, too specific, not automated in any way and untranslatable. We aimed to put an end to the rather fuzzy world of social impact and social innovation and imbed it into scientific methods which can implement true change.</p>
								<p>During the previous financial crisis we were issued with the challenge of measuring more scientifically and accurately the real-time contributions corporate entities and indeed individuals make to the world around them. The Social to Earning Ratio devised by Seratio measures your impact beyond just the marketplace, showing you in hard numbers the efficiency of your social spend, in much the same way the standard P/E Ratio (Price to Earnings) measures the earnings of your company against costs.</p>
								<p>Indeed, we passionately believe that the current methodologies for measuring impact upon societies, the earth and institutions are out dated and no longer reflect the reality of what those inputs become in terms of impacts upon the grass roots or indeed intended targets. Most modern metrics also fail to utilize the huge technological advances that have occurred in the 21st century thus far. We focus on devising methodologies that are not designed to make corporations look good, but instead help the observer attain an accurate depiction of what really happens on the ground. </p>
							</div>

							<div class="tab-pane" id="tab-2">
								<br>
								<p>WHEN THE FACTS ARE OUT IN THE OPEN – WE ALL BENEFIT, IT’S JUST HOW LIFE IS MEANT TO BE.</p>
								<p>The emphasis on pure financial value and outcomes no longer reflects reality in an ever changing world – we believe  in the new economy the true value of a brand or corporate entity  is now a combination of its Financial Value (P/E) and it’s Social Value (S/E).</p>
								<p>There has to date been a systematic failure which we aim to address using our expertise in intangible measurement and analysis, big data mining and qualitative data analysis – to create metrics which systematically and consistently can measure the direct ramifications of our actions, or non-actions. </p>

							</div>

							<div class="tab-pane" id="tab-3">
								<br>
								<p>Within the financial world, the Price/Earnings Ratio (P/E Ratio or PER) is the main single index evaluation technique of economic performance and health check. Used throughout the world, and reported daily on stock exchanges, it has become the universally adopted tool. In rough terms, the P/E measures the capitalization of a company (what it's worth) against the amount of profit it generates. We have developed the corollary to the P/E, the S/E Ratio (SER) which measures the Social Impact of an organisation against the monies invested to achieve it (the earnings diverted which otherwise would be profit).</p>

								<p>A share price is a relatively weak artefact representing degrees of alignment between shareholders and the organisations. It is subject to numerous reported and unmeasured biases which mean it cannot in isolation reflect the true “value” of the corporate entity. Generally only the shareholders and management benefit, and all others are a slave to that goal. Using human dynamic and descriptive analytics we have devised academically rigorous and peer reviewed methodologies which extend beyond these simple financial metrics.</p>

								<p>Think of yourself as a operator within a ever changing environment, the impacts you make upon the world around you will change constantly as the environment evolves. Your impact as a human being is not simply a constituent of your productivity or ability to make money.</p>
								<p>The social impact interpretation is that of citizenship, that the total value of an organisation is a total of the financial and social values. Taking social value, one has to measure the stakeholder value of customers, suppliers, staff, statutory bodies, community and the environment. </p>
								<p>Independently commissioned, the methodology has been developed by the Centre for Citizenship, Enterprise and Governance (cceg.org.uk) and its affiliated network of 30+ International Universities and Research Institutes to ensure honesty and integrity in the reporting process.</p>

								<p>Seratio reports in future proof XBRL format, using the latest GRI-4 template (Global Reporting Initiative) and is compliant with IIRC (The International Integrated Reporting Council).</p>

							</div>

							<div class="tab-pane" id="tab-6">
								<br>

								<ol align="left">
									<li><a href="{{URL::to('https://procurement-forum.eu/')}}" target="_blank" style="color:red;">January 2015 – chair EU Procurement group “Social Value and Transparency in Supply Chains”</a></li>

									<li><a href="#" target="_blank" style="color:red;">December 2014 - commissioned to produce UK Modern Slavery Act 2014 metric</a></li>

									<li><a href="{{URL::to('http://www.seismicproject.eu/')}}" target="_blank" style="color:red;">November 2014 - appointed Chair of EU SEiSMiC Social Value across 10 countries</a></li>

									<li><a href="{{URL::to('http://www.theinformationdaily.com/2014/11/19/answertime01')}}" target="_blank" style="color:red;">November 2014 – video Question Time with Hazel Blears MP and Prof Ta’eed</a></li>

									<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-professor-takes-part-in-a-panel-alongside-hazel-blears-mp-to-discuss-the-concept-of-social-value')}}" target="_blank" style="color:red;">November 2014 – deliver our S/E social impact report for Loomba Foundation to Bombay Stock Exchange members by Dr Vince Cable MP, Business Secretary of State</a></li>

									<li><a href="{{URL::to('https://www.youtube.com/watch?v=WAyPxiWbOoc')}}" target="_blank" style="color:red;">October 2014 - release of national interviews on Social Value</a></li>

									<li><a href="{{URL::to('https://www.youtube.com/watch?v=lbw_GKy8cow&feature=youtu.be')}}" target="_blank" style="color:red;">October 2014 - release of national interviews on Social Value</a></li>

									<li><a href="{{URL::to('https://drive.google.com/folderview?id=0B51i5nTXo9qtV1ROTDk5QWR5cUk&usp=sharing')}}" target="_blank" style="color:red;">September 2014 - commissioned to launch 250 page "Social Value in Public Procurement" bible</a></li>

									<li><a href="{{URL::to('https://www.dropbox.com/sh/8zzxr4al853cdqe/AAAKDjiCwclOj6DLW5sc3toCa?dl=0')}}" target="_blank" style="color:red;">September 2014 - commissioned to launch 250 page "Social Value in Public Procurement" bible</a></li>

									<li><a href="{{URL::to('http://www.socialvalueportal.com/')}}" target="_blank" style="color:red;">September 2014 - commissioned to produce Social Value Portal with Hazel Blears MP</a></li>

									<li><a href="{{URL::to('http://www.zenit.org/en/articles/olinga-ta-eed-on-link-between-profit-motive-and-reduction-of-poverty')}}" target="_blank" style="color:red;">June 2014 - Speech to The Pope at The Vatican</a></li>

									<li><a href="{{URL::to('http://www.northampton.ac.uk/news/professor-olinga-ta-eed-hosts-united-nations-international-widows-day-at-the-house-of-lords')}}" target="_blank" style="color:red;">June 2014 - 100 Indian CEO's attend House of Lords conference chaired by Prof Ta'eed</a></li>

									<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-professor-receives-unprecedented-feedback-for-inspirational-speech-at-institute-of-financial-services-event')}}" target="_blank" style="color:red;">May 2014 - Annual Institute of Financial Service Lecture</a></li>

									<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-collaborates-with-the-loomba-foundation-to-empower-245-million-widows')}}" target="_blank" style="color:red;">November 2013 - 450 attended London Guildhall event chaired by Prof Ta'eed including Deputy Prime Minister Nick Clegg, former First Lady Cherie Blair, Treasury Minister Danny Alexander</a></li>

									<li><a href="{{URL::to('http://www.brandanomics.com/')}}" target="_blank" style="color:red;">October 2013 - launch licensees using automated platform - Brandanomics</a></li>

									<li><a href="{{URL::to('http://sii2000.com/')}}" target="_blank" style="color:red;">October 2013 - launch licensees using automated platform - SI2000</a></li>

									<li><a href="{{URL::to('http://www.cultiv8solutions.com/')}}" target="_blank" style="color:red;">October 2013 - launch licensees using automated platform - Cultiv8 Solutions</a></li>

									<li><a href="{{URL::to('http://bigredsquare.com/')}}" target="_blank" style="color:red;">October 2013 - launch licensees using automated platform - Big Red Square</a></li>

									<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-professor-urges-individuals-worth-100-billion-collectively-to-consider-global-enterprise')}}" target="_blank" style="color:red;">June 2013 - US$ 100 billion HNWI attend The Dorchester, London, chaired by Prof Ta'eed including Lakshmi Mittal (US$ 16 b), Hinduja Brothers (US$ 17 b)</a></li>

									<li><a href="#" target="_blank" style="color:red;">January 208-Q1 2013 - wiki university approach on S/E amongst c. 30 universities</a></li>

									<li><a href="#" target="_blank" style="color:red;">November 2011 - commissioned by UK Government's 'Big Society' to develop universal social impact metric </a></li>
								</ol>
							</div>
						</div><!-- /.tab-content -->
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!-- End About Us Section -->

<!-- Start Citizenship Section -->
<div class="containerr" id="citizenship">
	<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><span>Citizenship Map</span></h2>
					<br>
					<p> The Social Earnings Ratio (S/E) is built on our current understanding of organisational structure - the multistakeholder environment, often called a Citizenship Map.
						We have also developed a range of S/E prodigy metrics to reflect Total Value.
					</p>
				</div>
			</div>
			<br>
			<div class="container">
				<div class="row">
					<div class="section-title text-center">
						<h2><span>Key</span></h2>
						<br>
						<div class="list-group column">
							<h4 class ="list-group col-lg-6">1.Capitilization</h4>
							<h4 class="list-group col-lg-6">5.CO2</h4>
							<h4 class="list-group col-lg-6">2.Social Value</h4>
							<h4 class="list-group col-lg-6">6.Transparency in Supply Chains</h4>
							<h4 class="list-group col-lg-6">3.Pay Disparity</h4>
							<h4 class="list-group col-lg-6">7.Personal(Citizen) Value </h4>
							<h4 class="list-group col-lg-6">4.Tax Avoidance</h4>
						</div>
					</div>
				</div>
			</div>

			<div class="container">
				<div class="row">
					<div class="section-title text-center">

					</br>
					<img src="https://www.seratio.com/assets_frontend/images/citizen.png" width="600" height="600" alt="">
				</div>
			</div>
		</div>
	</div>
</section>
</div>
<!-- End Citizenship Section -->


<!-- Start S/E Ratio Section -->
<div class="containerr" id="seratio">
	<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><span>S/E Ratio</span></h2>
					<br>
					<p align="center">The Social to Earnings ratio (S/E) behaves as a grandfather
						metric – the corollary to the P/E ratio used in the financial
						world. We give you a more powerful way to support or
						augment trading strategies and generate new ideas by giving
						you new views of the market from both a financial context
						and a “everything else” context, principally social impact, the
						morality of interactions inside and outside the organisation.
						Having said this, we are a neutral metric – we make no
						judgement on ethics – we simply objectively report them as we
						find them and cannot ‘influence’ any figures. <br></br>
						We harness the full breadth and depth of information in
						the SOCIAL IMPACT MARKETPLACE to create visualizations
						that uncover key insights, translate any index or metric into
						a comprehensive set of measurements that we generate
						specifically for you. The S/E metric can be applied to whole
						organisations, projects and processes across public, private,
						third and community sectors. <br></br> </p>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12" align="center">
						<div class="custom-tab">
							<ul class="nav nav-tabs nav-justified" role="tablist">
								<li class="active"><a href="#tab-4" role="tab" data-toggle="tab" style="color:black;">INTEGRATION MATTERS</a></li>
								<li><a href="#tab-5" role="tab" data-toggle="tab" style="color:black;">CUSTOMISATION, COLLABORATION, FORECASTING</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab-4">
									<br>
									<p>
										Our charting integrates the entire scope of social data,
										supplemented with the most robust financial APIs to create a
										holistic platform allowing you to create charts that consolidate
										all relevant information. This means you can quickly validate
										ideas, watch trends and generate value. Only on Seratio’s
										platforms can you plot multiple instruments across every social
										and financial asset class. Compare company fundamentals,
										ratios and estimates with other companies, commodities,
										currencies and economic data, then create composites for a
										more comprehensive view of the market.<br>
										Draw from almost 400 technical studies and indicators, both
										in the financial and social world – with the ability to translate
										any including those from well-known third-party contributors.
										We help you incorporate news headlines and market-moving
										events and indicators as diverse as economic cycles, energy
										and agricultural. You can incorporate your own company data
										or upload your firm’s custom content, comparing suppliers,
										competitors or even host organisations with whom you wish to
										make strategic partnerships with.</p>
									</div>

									<div class="tab-pane" id="tab-5">
										<br>
										<p>
											Charting on our platform is powerful and customisable, with
											numerous pre-packaged applications and shortcuts that allow
											you to jump quickly to charts and studies important to you.
											Start with a template, and then choose from a vast array of
											customization tools to configure data and associated alerts.
											Create your own view of the markets with our annotations
											palette. You’re always ready to present ideas, with a few
											clicks all it takes to export charts into presentations with all
											annotations included.<br>
											Communication and collaboration using charts is simple.
											You can share and co-edit charts with clients and colleagues
											throughout the community, in real time, through our reorting
											engine. Compare ideas and build a common point of view.<br>
											Design your own custom studies and share with colleagues and
											clients to generate profitable trade ideas. Use our forecasting
											tool to play out thousands of scenarios from a wide array
											of benchmarks to determine strategies and optimization
											techniques most profitable over time
										</p>
									</div>

									<div class="section-title text-center">
										<h2><span>Information</span></h2>
									</div>
								</br>
								<div class="container">
									<div class="row">
										<div class="col-md-3 col-sm-6">
											<div class="pricing-table">
												<div class="plan-name">
													<h3>The Vatican</h3>
												</div>

												<div class="plan-list">
													<ol align="left">
														<li><a href="{{URL::to('http://www.zenit.org/en/articles/the-vatican-has-long-promoted-intangible-values-can-they-be-measured')}}" target="_blank" style="color:red;">Zenit (5th January 2015)</a></li>
														<li><a href="{{URL::to('http://www.zenit.org/en/articles/olinga-ta-eed-on-link-between-profit-motive-and-reduction-of-poverty')}}" target="_blank" style="color:red;">Interview (1st July 2014)</a></li>
														<li><a href="{{URL::to('http://ow.ly/BgAwB')}}" target="_blank" style="color:red;">Vatican Speech Video</a></li>
													</ol>
												</div>
											</div>
										</div>

										<div class="col-md-3 col-sm-6">
											<div class="pricing-table">
												<div class="plan-name">
													<h3>Networks</h3>
												</div>

												<div class="plan-list">
													<ol align="left">
														<li><a href="{{URL::to('http://ow.ly/Gpu7N')}}" target="_blank" style="color:red;">EU SEiSMiC Social Value</a></li>
														<li><a href="{{URL::to('http://ow.ly/Hi4sd')}}" target="_blank" style="color:red;">EU Procurement Social Value & Transparency in Supply Chains</a></li>
													</ol>
												</div>

											</div>
										</div>


										<div class="col-md-3 col-sm-6">
											<div class="pricing-table">
												<div class="plan-name">
													<h3>Pilots</h3>
												</div>

												<div class="plan-list">
													<ol align="left">
														<li><a href="{{URL::to('http://ow.ly/Bgx2d')}}" target="_blank" style="color:red;">Implementation</a></li>
														<li><a href="{{URL::to('http://ow.ly/BgxpJ')}}" target="_blank" style="color:red;">Case Study pilot</a></li>
														<li><a href="{{URL::to('http://ow.ly/BgAOc')}}" target="_blank" style="color:red;">Application 2% Law India</a></li>
													</ol>
												</div>

											</div>
										</div>

										<div class="col-md-3 col-sm-6">
											<div class="pricing-table">
												<div class="plan-name">
													<h3>Social Earnings Ratio</h3>
												</div>

												<div class="plan-list">
													<ol align="left">
														<li><a href="{{URL::to('http://ow.ly/CKHCf')}}" target="_blank" style="color:red;">International Research</a></li>
														<li><a href="{{URL::to('http://ow.ly/BgvR9')}}" target="_blank" style="color:red;">Prezi introduction</a></li>
														<li><a href="{{URL::to('http://ow.ly/Bgw1S')}}" target="_blank" style="color:red;">Timeglider history</a></li>
														<li><a href="{{URL::to('https://www.seratio.org/')}}" target="_blank" style="color:red;">Online course</a></li>
														<li><a href="{{URL::to('https://github.com/seratio/SocialEarningsRatio')}}" target="_blank" style="color:red;">GitHub</a></li>
													</ol>
												</div>

											</div>
										</div>
									</div>
								</br>
								<div class="row">
									<div class="col-md-3 col-sm-6">
										<div class="pricing-table">
											<div class="plan-name">
												<h3>Licensees</h3>
											</div>

											<div class="plan-list">
												<ol align="left">
													<li><a href="{{URL::to('http://www.brandanomics.com/')}}" target="_blank" style="color:red;">Consumer brands</a> </li>
													<li><a href="{{URL::to('http://bigredsquare.com/')}}" target="_blank" style="color:red;">Public sector</a> </li>
													<li><a href="{{URL::to('http://www.cultiv8solutions.com/')}}" target="_blank" style="color:red;">Birmingham</a></li>
													<li><a href="{{URL::to('http://sii2000.com/')}}" target="_blank" style="color:red;">Listed companies</a></li>
													<li><a href="{{URL::to('http://www.socialvalueportal.com/')}}" target="_blank" style="color:red;">Social Value Portal</a></li>
												</ol>
											</div>

										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="pricing-table">
											<div class="plan-name">
												<h3>Social Value Act</h3>
											</div>

											<div class="plan-list">
												<ol align="left">
													<li><a href="{{URL::to('http://ow.ly/CbFUa')}}" target="_blank" style="color:red;">Social Value in Public Procurement (googledrive)</a></li>
													<li><a href="{{URL::to('http://ow.ly/CChMi')}}" target="_blank" style="color:red;">Social Value in Public Procurement (dropbox)</a></li>
													<li><a href="{{URL::to('http://ow.ly/Bsr9Y')}}" target="_blank" style="color:red;">Infogram of report</a></li>
													<li><a href="{{URL::to('http://ow.ly/BALSM ')}}" target="_blank" style="color:red;">Intro video (part 1)</a></li>
													<li><a href="{{URL::to('http://ow.ly/BqrbK')}}" target="_blank" style="color:red;">Intro video (part 2)</a></li>
													<li><a href="{{URL::to('http://ow.ly/Hi23r')}}" target="_blank" style="color:red;">Answer time with Hazel Blears MP</a></li>
												</ol>
											</div>

										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="pricing-table">
											<div class="plan-name">
												<h3>Press Releases </h3>
											</div>

											<div class="plan-list">
												<ol align="left">
													<li><a href="{{URL::to('http://www.northampton.ac.uk/news/professor-olinga-ta-eed-hosts-united-nations-international-widows-day-at-the-house-of-lords')}}" target="_blank" style="color:red;">June 2014 - 100 Indian CEO's attend House of Lords conference chaired by Prof Ta'eed </a></li>
													<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-professor-receives-unprecedented-feedback-for-inspirational-speech-at-institute-of-financial-services-event')}}" target="_blank" style="color:red;">May 2014 - Annual Institute of Financial Service Lecture </a></li>
													<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-collaborates-with-the-loomba-foundation-to-empower-245-million-widows')}}" target="_blank" style="color:red;">November 2013 - 450 attended London Guildhall event chaired by Prof Ta'eed including Deputy Prime Minister Nick Clegg, former First Lady Cherie Blair, Treasury Minister Danny Alexander</a></li>
													<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-professor-urges-individuals-worth-100-billion-collectively-to-consider-global-enterprise')}}" target="_blank" style="color:red;">June 2013 - US$ 100 billion HNWI attend The Dorchester, London, chaired by Prof Ta'eed including Lakshmi Mittal (US$ 16 b), Hinduja Brothers (US$ 17 b)</a></li>
												</ol>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div><!-- /.tab-content -->
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!-- End S/E Ratio Section -->

<!-- Start Info Section -->
<div class="containerr" id="info">
	<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><span>Info</span></h2>
					<br>

				</div>
			</div>

			<div class="row">
				<div class="col-md-12" align="center">
					<div class="custom-tab">
						<ul class="nav nav-tabs nav-justified" role="tablist">
							<li class="active"><a href="#tab-10" role="tab" data-toggle="tab" style="color:black;">Brochures</a></li>
							<li><a href="#tab-11" role="tab" data-toggle="tab" style="color:black;">Social Value and Intangibles Review</a></li>
							<li><a href="#tab-12" role="tab" data-toggle="tab" style="color:black;">SVIR Media Kit 2016</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab-10">
								<br>
								<p>
									<div class="right">

										<div class="rightcontent">
											<div style="padding-bottom:10px;"></div>
											<div class="clear"></div>
											<div class="col-md-3" style="padding-bottom:20px;"><a href="{{URL::asset('assets_frontend/pv/images/J1212_PV_6PV Brochure_VIS07_AW01_Pages.pdf')}}" target="_blank"><img src="assets_frontend/images/b1.png " alt="" width="90" height="120" border="0" /></a></div>
											<div class="col-md-3"><a href="{{URL::asset('assets_frontend/pv/images/J1212_PV_6PV Brochure_VIS07_AW01_Pages_Crop.pdf')}}" target="_blank"><img src="assets_frontend/images/b2.png" alt="" width="90" height="120" border="0" /></a></div>
										</div>
									</div>
								</p>
							</div>

							<div class="tab-pane" id="tab-11">
								<br>
								<p>
									<div class="right">

										<div class="rightcontent">
											<div style="padding-bottom:10px;"></div>
											<div class="clear"></div>
											<div class="col-md-3" style="padding-bottom:20px;"><a href="{{URL::asset('assets_frontend/pv/images/november_2015.pdf')}}" target="_blank"><img src="assets_frontend/pv/images/journal1.jpg " alt="" width="90" height="120" border="0" /></a></div>
											<div class="col-md-3"><a href="{{URL::asset('assets_frontend/pv/images/april_2015.pdf')}}" target="_blank"><img src="assets_frontend/pv/images/journal2.jpg" alt="" width="90" height="120" border="0" /></a></div>
											<div class="col-md-3"><a href="{{URL::asset('assets_frontend/images/mag_svir.pdf')}}" target="_blank"><img src="assets_frontend/images/mag_cover.png" alt="" width="90" height="120" border="0" /></a></div>
											<div class="col-md-3"><a href="{{URL::asset('assets_frontend/images/mag_svir_sep_2016.pdf')}}" target="_blank"><img src="assets_frontend/images/mag_cover_sep_2016.png" alt="" width="90" height="120" border="0" /></a></div>
										</div>
									</div>
								</p>
							</div>

							<div class="tab-pane" id="tab-12">
								<br>
								<p>
									<div class="right">

										<div class="rightcontent">
											<div style="padding-bottom:10px;"></div>
											<div class="clear"></div>

											<div class="col-md-3"><a href="{{URL::asset('assets_frontend/images/media_kit.pdf')}}" target="_blank"><img src="assets_frontend/images/journal3.png" alt="" width="90" height="120" border="0" /></a></div>
											<div class="col-md-3"><a href="{{URL::asset('assets_frontend/images/svir_f_2017.pdf')}}" target="_blank"><img src="assets_frontend/images/svir_feb_2017.png" alt="" width="90" height="120" border="0" /></a></div>
										</div>
									</div>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>


	<!-- End Info Section -->

	<!-- Start Case Study Section -->
<div class="containerr" id="case">
	<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><span>Case Study</span></h2>
					<br>
					<p align="center">Seratio leads in the real-world measurement of social value. Our metric is helping a large number of organisations to design, develop and deliver social value to their communities. A couple of case studies of the work we have done can be downloaded here

							<li><a style="color:black;" href="{{URL::asset('assets_frontend/pv/images/west_midlans_case_study.pdf')}}" target="_blank">West Midlands Fire Service Case Study</a></li>
							<li><a style="color:black;" href="{{URL::asset('assets_frontend/pv/images/sv_made_in_corby_case_stuy.pdf')}}" target="_blank">Social Value of the Arts - Made in Corby</a></li>

					</p>
					</div>
					<br>

				</div>
			</div>

			<div class="row">

			</div>
		</section>
	</div>


	<!-- End Case Study Section -->

	<!-- Start Benchmark Section -->
	<div class="containerr" id="benchmark">
		<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h2><span>Introduction</span></h2>
						<br>
						<p>  The Social Earnings Ratio came out of a leading team of academics that researched, re-modelled, and developed over a 3 year period (2011-2014) all the likely applications of a single universal non-financial metric. Working collaboratively now with over 40 universities in the world, we finally ended our testing period in Autumn 2014 and moved to implementation phase resulting in the seratio.com SaaS platform. Access to the Big Data we have harvested is by permission only, but many of our licensees across the world display parts of the data freely. Here we share with you a sample set of test data since 2011 to convey the exacting provenance of our research.
						</p>

					</div>
				</div>
				<br>
				<div class="container">
					<div class="row">
						<div class="section-title text-center">
							<h3>Factors in consideration</h3>
							<h4>GENERAL</h4>
							<li>Project</li>
							<li>Category</li>
							<li>Company</li>
							<h4>INPUT DATA</h4>
							<li>Popularity</li>
							<li>Positive Sentiment</li>
							<li>CSR spend</li>
							<li>Environmental</li>
							<li>People</li>
							<li>Cash Generated+Invested</li>
							<h4>REPORTED</h4>
							<li>SER</li>
							<li>SI by calculation</li>
							<li>Added Social Value</li>
							<li>Increase in Market Cap/NAV</li>
							<li>Environment</li>
							<li>People</li>
							<li>Cash</li>
							<li>Tax Avoidance</li>
							<li>Pay Disparity</li>

						</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="section-title text-center">
							<h3>Social Earnings Ratio</h3>
						</br>

						<img src="https://www.seratio.com/assets_frontend/images/se.jpg" width="900" height="2000" alt="">
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="section-title text-center">
						<h3>Increase in Market Cap/NAV (%)</h3>

						<img src="https://www.seratio.com/assets_frontend/images/ca.jpg" width="900" height="2000" alt="">

					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!-- End Benchmark Section -->

<!-- Start Partners Section -->
<div class="containerr" id="partners">
	<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><span>Seratio Partners</span></h2>
					<br>
					<div class="row">
						<div class="col-md-3 col-sm-6">
							<div class="team-member">
								<a href="{{URL::to('http://www.brandanomics.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Brandanomics"><img src="https://www.seratio.com/assets_frontend/images/logo/brandanomics-logo.png" alt="Brandanomics"></a>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="team-member">
								<a href="{{URL::to('http://www.cultiv8solutions.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Cultiv8 Solutions"><img src="https://www.seratio.com/assets_frontend/images/logo/cultiv8.png" alt="Cultiv8 Solutions"></a>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="team-member">
								<a href="{{URL::to('http://sii2000.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="SI2000"><img src="https://www.seratio.com/assets_frontend/images/logo/si2000.png" alt="SI2000"></a>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="team-member">
								<a href="{{URL::to('http://www.unseenuk.org/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Slavery"><img src="https://www.seratio.com/assets_frontend/images/logo/unseen.gif" alt="Slavery"></a>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="team-member">
								<a href="{{URL::to('http://www.seismicproject.eu/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="EU SEiSMiC Social Value"><img src="https://www.seratio.com/assets_frontend/images/logo/seismic.png" alt="EU SEiSMiC Social Value"></a>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="team-member">
								<a href="{{URL::to('http://www.cceg.org.uk/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="CCEG"><img src="https://www.seratio.com/assets_frontend/images/logo/cceg.png" alt="CCEG"></a>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="team-member">
								<a href="{{URL::to('https://procurement-forum.eu/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Procurement FORUM"><img src="https://www.seratio.com/assets_frontend/images/logo/pf.png" alt="Procurement FORUM"></a>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="team-member">
								<a href="{{URL::to('http://www.semantrica.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Semantrica"><img src="https://www.seratio.com/assets_frontend/images/logo/sem.png" alt="Semantrica"></a>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="team-member">
								<a href="{{URL::to('http://socialvalueportal.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="The Social Value Portal"><img src="https://www.seratio.com/assets_frontend/images/logo/svportal.png" alt="The Social Value Portal"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!-- End Partners Section -->

<!-- Start Our Team Section -->
<div class="containerr" id="team">
	<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><span>Directors</span></h2>
					<br>
					<div class="row">
							<div class="col-md-6">
								<div class="testimonial">
									<img src="https://www.seratio.com/assets_frontend/images/team/barbara.jpg" width="200" height="30" class="img-responsive" alt="">
									<h4>Barbara Mellish MBA, MIRM, ACIB - CEO</h4>
									<div class="speech">
										<p style="font-size:125%" align="justify">
											An experienced Director, Non-Exec and Advisor to Blue-Chip and private companies, public sector organisations and third sector businesses.
											Barbara’s commercial acumen has been built from a successful career within financial services, specialising in risk management, corporate governance and compliance, including board appointments at Barclaycard and European boards and representation for the global brands of MasterCard and Visa.
											Her private sector discipline and experience has been blended with executive roles in the not-for profit and public sectors. The most recent role being the Director of Payments Integrity and Security at the Payments Council which had responsibility for the reliability and cyber resilience of the UK’s banking payments systems.
											Barbara has two teenage children and is a keen traveller, scuba diver & adrenalin sports fan.</p>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="testimonial">
										<img src="https://www.seratio.com/assets_frontend/images/team/olinga.png" width="500" height="50" class="img-responsive" alt="">
										<h4>Professor Olinga Ta’eed PhD FIoD - Chairman</h4>
										<div class="speech">
											<p style="font-size:125%" align="justify">
												Olinga is Director of the Centre for Citizenship, Enterprise and Governance and attributed with the creation of the Social Earnings Ratio (S/E). He is Professor of Social Enterprise at  University of Northampton, Visiting Professor in Capacity Development at Birmingham City University, Chair of EU SEiSMiC Social Value and Chair of EU PROCUREMENT Social Value & Transparency in Supply Chains. He is Executive Editor of Social Value & Intangibles Review.
												Olinga retired from a successful private sector career at the age of 48 as “entrepreneur, investor, and social activist”. In the last 7 years he has developed his role of a carer including for emergency fostering on his small holding in Wales and he remains a registered adopter. He has homes in the UK and Italy.</p>
											</div>
										</div>
									</div>
								</div>
								<br>

								<h2><span>Team</span></h2>
								<br>
								<div class="row">
									<div class="col-md-6">
										<div class="testimonial">
											<img src="https://www.seratio.com/assets_frontend/images/team/sajin.jpg" width="200" height="30" class="img-responsive" alt="">
											<h4>Sajin Abdu B Tech, MBA - Head of Technology</h4>
											<div class="speech">
												<p style="font-size:125%" align="justify">A dedicated professional with over five years of combined experience as a software developer, marketing supervisor and PMO in blue chip and private companies. His most recent role being the PMO of Tata Consultancy Services which had responsibility for project commercial management, Internal audits facilitator and presales proposals creation and estimation. Sajin is a qualified electronics and communications engineer and has completed his Master of Business Administration from University of Northampton.
													He enjoys keeping up-to-date with the latest advances in technology and have remained amazed at the speed of computerised developments over the past few years. He is an avid traveller and enjoys music and good food.</p>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="testimonial">
												<img src="https://www.seratio.com/assets_frontend/images/team/simon1.JPG" width="200" height="30" class="img-responsive" alt="">
												<h4>Simon Cohen - Head of Public Sector</h4>
												<div class="speech">
													<p style="font-size:125%" align="justify">Simon is an experienced Board-level strategist and business development professional. He has worked for small, and medium and large blue-chip organisations – mostly in technology but also in manufacturing.

														His achievements include: being part of the small Japan-based team that coordinated the delivery of Toyota’s £840 million manufacturing investment in the UK on schedule and on budget in the early 1990s; and heading the commercial team which brought to market the world’s first commercial video-over-mobile solution and the world’s first 3G live video solution – a technology which was subsequently licensed in over 35 territories.

														Simon is married with two children. He is a keen skier, and is a former club squash champion – having once taken 2 lucky points off the then world no.9.</p>
													</div>
												</div>
											</div>

										</div>
										<br>
										<div class="row">
											<div class="col-md-6">
												<div class="testimonial">
													<img src="https://www.seratio.com/assets_frontend/images/team/raisa.jpg" width="200" height="30" class="img-responsive" alt="">
													<h4>Raisa Ambros MA - Editor at Social Value & Intangibles Review</h4>
													<div class="speech">
														<p style="font-size:125%" align="justify">Raisa is a TV presenter and a journalist. She is specialized in geopolitical reporting,
															migration, intercultural and social policies both in print media and video. Her live
															talk shows have focused in an interactive format on social issues of the foreign
															communities in Italy.
															With her language profficiency in Italian, Russian, Romanian, French and English
															her role in CCEG includes co-ordination of all European activities. She is also
															interested in European policies promoting the member countries and EU candidates
															on the Eurocomunicazione.com platform. In her spare time she volunteers for the
															NGO “Piuculture”, which operates the Infomigranti project teaching journalism to
															immigrants.
															She is also working on translation projects and developing her creative writing skills,
															which she honed in screenwriting and narrative technique courses in Europe.
															Raisa is frequently invited as a speaker at conferences on integration and social
															policies.</p>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="testimonial">
														<img src="https://www.seratio.com/assets_frontend/images/team/joanne.jpg" width="200" height="30" class="img-responsive" alt="">
														<h4>Joanne Evans MBA - Project Manager</h4>
														<div class="speech">
															<p style="font-size:125%" align="justify">An experienced manager, change maker and social value specialist.
																Joannes commercial and social value experience has developed through a career within the retail
																industry; a trouble shooter and change maker to one of the UKs leading retailers.  Specialising in
																Corporate Social Responsibility and marketing through Stakeholder engagement and sentiment;
																initiating bottom up change through management programme involving childrens associations,
																inspiring change and sponsorship, impacting on 400,000 children each year.
																Her experience in CSR and change was infused through her training at The Centre of Citizenship and
																Governance; specialising in the articulation of CSR contributions and the increase of the social value
																and market capital of companies.  Her most recent position; driving sentiment from the front line,
																responsible for the training and development of colleagues, customer retention and sales increase.
																Joanne is married and has 3 step-daughters, 5 cats and 2 rabbits.  Her interests include Classic VW
																Beetles, hand crafted arts, running, Reiki and veganism.</p>
															</div>
														</div>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-md-6">
														<div class="testimonial">
															<img src="https://www.seratio.com/assets_frontend/images/team/sevda.JPG" width="200" height="30" class="img-responsive" alt="">
															<h4>Sevda Gungormus - Head of Finance</h4>
															<div class="speech">
																<p style="font-size:125%" align="justify">Sevda is a trilingual finance and HR consummate professional who has worked with HNWI's and companies for 20 years. She has successfully managed start-ups to weekly transactions of UK£ 5m and knows how to scale and ensure sustainability through implementing strict process control. Her experience is cross-sectorial, from international media groups like CNN, through to large social housing providers in the UK Poplar HARCA.
																	Sevda is a multicultural individual with home bases in the UK, France and Turkey.</p>
																</div>
															</div>
														</div>

														<div class="col-md-6">
															<div class="testimonial">
																<img src="https://www.seratio.com/assets_frontend/images/team/ardrain.png" width="200" height="30" class="img-responsive" alt="">
																<h4>Adrian Pryce MBA, ACIB, FHEA - Head of Capacity Development</h4>
																<div class="speech">
																	<p style="font-size:125%" align="justify">An experienced educator in international business strategy and cross-cultural management and an active non-exec director and advisor to private companies and third sector organisations.
																		With a career spanning banking, travel & tourism and the food industry as well as academia, Adrian has a breadth of business development experience and a strong entrepreneurial flair. Fluent in Spanish after living in Spain, he has over 25 years international experience. He is a Rotarian, a non-executive director of a regional theatre and chairman of a homelessness charity and its social enterprise trading arm.
																		Adrian is married with three teenage children and is a keen cyclist for charity.</p>
																	</div>
																</div>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-md-6">
																<div class="testimonial">
																	<img src="https://www.seratio.com/assets_frontend/images/team/adelle.JPG" width="200" height="30" class="img-responsive" alt="">
																	<h4>Adelle Chilinksi - Head of Business Services</h4>
																	<div class="speech">
																		<p style="font-size:125%" align="justify">Adelle is a commercially focused Business Operations Manager specialising in IT & Project Management, Finance, Risk Management, Business Resilience and Continuity.  Operating at Executive level in Nationwide as Head of Business Continuity and experienced in the public sector having worked with Local Authorities.  Adelle is highly effective in managing complex multi-stakeholder environments and leading industry level change.  In her spare time she enjoys travel, new experiences, good food & drink and family time.</p>
																	</div>
																</div>
															</div>

															<div class="col-md-6">
																<div class="testimonial">
																	<img src="https://www.seratio.com/assets_frontend/images/team/rani.jpg" width="200" height="30" class="img-responsive" alt="">
																	<h4>Rani Kaur - Development Analyst</h4>
																	<div class="speech">
																		<p style="font-size:125%" align="justify">Rani is currently Senior lecturer within the Northampton Business School and manages the overseas delivery of the Business Management Programme.
																			She has a wealth of experience in outsourcing SME call centres to South East Asia.  Rani’s corporate background is primarily in Fraud Strategy and Project Management, from working with Deutche Bank, Barclaycard and Marconi.
																			For some time now, she has focused her efforts on local charitable works, as a non-executive director combating domestic violence and driving through preventative strategies. She is involved in delivering programs empowering women who have suffered domestic Violence, in a group and on a 1:1 basis.
																			She consults to organisations here and abroad on successful board development for the third sector.
																			In her spare time, she likes Hiking, reading and spending time with her young daughter..</p>
																		</div>
																	</div>
																</div>
															</div>
															<br>
															<div class="row">
																	<div class="col-md-6">
																		<div class="testimonial">
																			<img src="https://www.seratio.com/assets_frontend/images/team/tiggy.png" width="200" height="30" class="img-responsive" alt="">
																			<h4>Tigris Ta’eed - Chief Disruption Officer</h4>
																			<div class="speech">
																				<p style="font-size:125%" align="justify">Tigris is an artist, story writer and poet. She is a graduate in Fine Art from Reading University, and has been an art teacher for Primo Balleto dance school,
																					where the children choreographed their pieces from ballet, hip hop and musical theatre styles, as well as voluntary youth work with delinquent teenagers,
																					arming them with an artistic outlet and distraction from alcohol and drugs.
																					She was also a researcher and runner for Resistance Ltd, a company who made the Nazi movie of the same name.
																					Tigris is a freedom fighter and cyberpunk online, having worked with Amnesty International human rights organisation,
																					petitioning against the introduction of CCTV and ID cards. Tigris, nickname Tiggy or Trip,
																					is passionate and experienced in music and film, and was a part of the fantasy, science fiction and horror
																					subculture when living in Cambridge. She loves dancing at psy trance and drum’n’bass raves, festivals and gigs,
																					the pleasure of theatre and reading, with a fire for the occult, keeping a blog online where she expresses
																					her spiritual beliefs as a psychedelic chaos magician.</p>
																				</div>
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="testimonial">
																				<img src="https://www.seratio.com/assets_frontend/images/team/phil.jpg" width="200" height="30" class="img-responsive" alt="">
																				<h4>Phil Renshaw MCT, ACIB, PGCHE - Research Analyst</h4>
																				<div class="speech">
																					<p style="font-size:125%" align="justify">Phil believes that maximising success for anyone requires an understanding of both value and

																						leadership – if you know the value of something and the people around you, success is yours for the

																						taking.

																						Phil has a senior business leadership background as a banker, corporate financier, and a Finance

																						Director. He’s lived in London, New York and Sydney. Six years ago he become a professional coach

																						specialising in international assignments. He is fascinated by these assignments and the inability of

																						organisations to value them. His expertise has prompted him to start a PhD at Cranfield University in

																						the organisational value of international assignments.

																						Phil is married to Alison. They love trips out in their VW campervan and are currently in the market

																						for both a cat and a dog.</p>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</section>
													</div>
													<!-- End Our Team Section -->

													<!-- Start Contact Section -->
													<div class="containerr" id="contact">
														<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
															<div class="container">
																<div class="row">
																	<div class="col-md-12">
																		<h2><span>Contact With Us</span></h2>
																		<br><br><br>
																		<div class="container">
																			<div class="row">
																				<div class="col-md-8">
																					<div class="well well-sm">
																						 {{ Form::open(array('route' => array('frontend.contactus'), 'method' => 'POST', 'class' => 'form')) }}
																							<div class="row">
																								<div class="col-md-6">
																									<div class="form-group">
																										<label for="name">
																											Name</label>
																											<input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required="required" />
																										</div>
																										<div class="form-group">
																											<label for="email">
																												Email Address</label>
																												<div class="input-group">
																													<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
																												</span>
																												<input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required="required" /></div>
																											</div>
																											<div class="form-group">
																												<label for="subject">
																													Subject</label>
																													<select id="subject" name="subject" class="form-control" required="required">
																														<option value="na" selected="">Choose One:</option>
																														<option value="service">General Customer Service</option>
																														<option value="suggestions">Suggestions</option>
																														<option value="product">Product Support</option>
																													</select>
																												</div>
																											</div>
																											<div class="col-md-6">
																												<div class="form-group">
																													<label for="name">
																														Message</label>
																														<textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
																														placeholder="Message"></textarea>
																													</div>
																												</div>
																												<div class="g-recaptcha col-md-6" data-sitekey="6LcWgVwUAAAAAM41oPsGaSs0tvoYyLdP5j2OVGrp"></div>
																												<div class="col-md-12">
																													<button type="submit" class="btn btn-primary pull-right" id="btnContactUs">
																														Send Message</button>
																													</div>
																												</div>
																											</form>
																										</div>
																									</div>
																									<div class="col-md-4">
																										<form>
																											<legend><span class="glyphicon glyphicon-envelope"></span> Our Address</legend>
																											<address>
																												<strong>Seratio Limited</strong><br>
																												Centre for Citizenship, Enterprise & Governance.<br>
																												Trinity Chapel, Nixonville, MT<br>

																												<abbr title="Phone">Ph:</abbr> 1 (604) 550100<br>
																												<a href="mailto:#" style="color:red;">info@cceg.org.uk</a>
																											</address>

																										  {{ Form::close() }}
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</section>
																		</div>
																		<!-- End Contact Section -->
																	</div><!-- /container -->

																	<!-- ================================================== -->
																	<!-- Placed at the end of the document so the pages load faster -->
																	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
																	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
																	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
																	<script src='https://www.google.com/recaptcha/api.js'></script>


																	{{ HTML::script('new_assets/js/snap.svg-min.js')}}

																	{{ HTML::script('new_assets/js/svgLoader.js')}}

																	{{ HTML::script('new_assets/js/classie.js')}}

																	{{ HTML::script('new_assets/js/pathLoader.js')}}

																	{{ HTML::script('new_assets/js/main.js')}}

																	{{ HTML::script('new_assets/js/jquery.backstretch.min.js')}}

																	{{ HTML::script('new_assets/js/letme.js')}}

																	{{ HTML::script('assets_frontend/js/jquery.cookiebar.js')}}

																	<script>
																		$.backstretch("../new_assets/images/body_bg.jpg");
																		TweenMax.staggerTo([".onee",".one",".two",".threee",".three",".four",".five",".six",".seven",".sevenn",".sevennn",".eight",".fivee",".ten", ".pro", ".eu", ".bit", ".block", ".block_demo", ".cceg_block", ".city_block", ".cyber_futures", ".coin1"],0,{ opacity:1,transform:"rotate(45deg)",scale:1,ease:Elastic.easeOut},.15);
																		var targetItem = $('.box');
																		targetItem.on("mouseenter", function(event) {
																			TweenLite.to($(this), 0, {scale:1.1,ease: Elastic.easeOut});
																		});

																		targetItem.on("mouseleave", function(event) {
																			TweenLite.to($(this), 0, {scale:1, ease: Elastic.easeOut});
																		});

																		/*animation*/
																		TweenLite.to(".lineone", 1, { height:"97px", ease:Back.easeOut});
																		TweenLite.from(".lineTwo", 1, { height:"0px",opacity:0, ease:Back.easeOut});
																		TweenLite.to(".arrow", 1, { bottom:"-157px", ease:Back.easeOut});
																		TweenMax.staggerTo([".facebook",".googlep",".linkedin",".youtube",".twitter",".tumb",".instagram", ".blog",".edu" ],1.8,{ right:0,opacity:1,ease: Elastic.easeOut},.20);

																		$(document).ready(function(){
																			$(this).scrollTop(0);
																		});

																	</script>

																	<script type="text/javascript">
																		$(document).ready(function(){
																			$.cookieBar({
																			});
																		});
																	</script>
																</body>
																</html>
